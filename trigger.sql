USE uts_pbd_005;

-- 1. Trigger penerimaan barang di tabel detail_penerimaan
-- buat nyatet mutasi masuk ke kartu stok sekalian update harga beli terbaru
DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_insert_detail_penerimaan$$
CREATE TRIGGER trg_after_insert_detail_penerimaan
AFTER INSERT ON detail_penerimaan
FOR EACH ROW
BEGIN
    DECLARE v_stok_terakhir INT DEFAULT 0;
    DECLARE v_stok_baru INT DEFAULT 0;

    -- ambil saldo stok terakhir
    SELECT COALESCE(stok, 0) INTO v_stok_terakhir
    FROM kartu_stok
    WHERE idbarang = NEW.barang_idbarang
    ORDER BY idkartu_stok DESC
    LIMIT 1;

    IF v_stok_terakhir IS NULL THEN
        SET v_stok_terakhir = 0;
    END IF;

    -- hitung saldo baru
    SET v_stok_baru = v_stok_terakhir + NEW.jumlah_terima;

    -- masukin ke kartu stok sebagai mutasi masuk ('M')
    INSERT INTO kartu_stok (
        jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at
    ) VALUES (
        'M', NEW.jumlah_terima, 0, v_stok_baru, NEW.idpenerimaan, NEW.barang_idbarang, CURRENT_TIMESTAMP
    );

    -- update harga beli terbaru di master barang
    UPDATE barang
    SET harga = NEW.harga_satuan_terima
    WHERE idbarang = NEW.barang_idbarang;
END$$

DELIMITER ;


-- 2. Function buat ngitung harga jual kasir (modal + margin aktif)
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_harga_jual$$
CREATE FUNCTION fn_hitung_harga_jual(p_idbarang INT)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_harga_modal INT DEFAULT 0;
    DECLARE v_persen_margin DOUBLE DEFAULT 0;
    DECLARE v_harga_jual INT DEFAULT 0;

    -- ambil modal barang
    SELECT harga INTO v_harga_modal
    FROM barang
    WHERE idbarang = p_idbarang;

    -- ambil margin yang lagi aktif (status = 1)
    SELECT persen INTO v_persen_margin
    FROM margin_penjualan
    WHERE status = 1
    ORDER BY updated_at DESC
    LIMIT 1;

    IF v_persen_margin IS NULL THEN
        SET v_persen_margin = 0;
    END IF;

    -- rumus harga jual: modal + (modal * persen / 100)
    SET v_harga_jual = v_harga_modal + ROUND(v_harga_modal * (v_persen_margin / 100));

    RETURN v_harga_jual;
END$$

DELIMITER ;


-- 3. Stored Procedure buat proses penjualan di kasir
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_proses_penjualan$$
CREATE PROCEDURE sp_proses_penjualan(
    IN p_idbarang INT,
    IN p_jumlah INT,
    IN p_persen_ppn INT,
    IN p_iduser INT,
    OUT p_idpenjualan_baru INT,
    OUT p_pesan VARCHAR(100)
)
BEGIN
    DECLARE v_stok_tersedia INT DEFAULT 0;
    DECLARE v_harga_jual INT DEFAULT 0;
    DECLARE v_idmargin INT DEFAULT 0;
    DECLARE v_subtotal INT DEFAULT 0;
    DECLARE v_ppn INT DEFAULT 0;
    DECLARE v_total INT DEFAULT 0;
    DECLARE v_stok_baru INT DEFAULT 0;

    -- cek sisa stok dulu di kartu stok
    SELECT COALESCE(stok, 0) INTO v_stok_tersedia
    FROM kartu_stok
    WHERE idbarang = p_idbarang
    ORDER BY idkartu_stok DESC
    LIMIT 1;

    -- kalo stok ga cukup langsung batalkan
    IF v_stok_tersedia < p_jumlah THEN
        SET p_idpenjualan_baru = 0;
        SET p_pesan = 'GAGAL: Stok barang tidak mencukupi untuk dijual!';
    ELSE
        -- ambil margin aktif
        SELECT idmargin_penjualan INTO v_idmargin
        FROM margin_penjualan
        WHERE status = 1
        ORDER BY updated_at DESC
        LIMIT 1;

        -- hitung harga jual pake function sekalian ppn sama totalnya
        SET v_harga_jual = fn_hitung_harga_jual(p_idbarang);
        SET v_subtotal   = v_harga_jual * p_jumlah;
        SET v_ppn        = ROUND(v_subtotal * (p_persen_ppn / 100));
        SET v_total      = v_subtotal + v_ppn;

        -- simpan ke penjualan
        INSERT INTO penjualan (subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan, created_at)
        VALUES (v_subtotal, v_ppn, v_total, p_iduser, v_idmargin, CURRENT_TIMESTAMP);

        SET p_idpenjualan_baru = LAST_INSERT_ID();

        -- simpan ke detail penjualan
        INSERT INTO detail_penjualan (harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang)
        VALUES (v_harga_jual, p_jumlah, v_subtotal, p_idpenjualan_baru, p_idbarang);

        -- potong stok dan catat mutasi keluar ('K') di kartu stok
        SET v_stok_baru = v_stok_tersedia - p_jumlah;

        INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at)
        VALUES ('K', 0, p_jumlah, v_stok_baru, p_idpenjualan_baru, p_idbarang, CURRENT_TIMESTAMP);

        SET p_pesan = 'BERHASIL: Transaksi penjualan tersimpan dan stok terpotong.';
    END IF;
END$$

DELIMITER ;
