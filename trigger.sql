-- ====================================================================
-- FILE: trigger.sql
-- Proyek: StokKu - Praktikum Pemrograman Basis Data
-- Materi: Pertemuan 10 - Trigger (dengan integrasi 1 Function & 1 SP)
-- ====================================================================

USE uts_pbd_005;

-- ====================================================================
-- 1. TRIGGER: trg_after_insert_detail_penerimaan
-- Tabel: detail_penerimaan (AFTER INSERT FOR EACH ROW)
-- Alur Bisnis:
--   1. Bekerja "diam-diam" otomatis mencatat mutasi masuk ('M') ke kartu_stok
--      serta menghitung saldo stok terbaru.
--   2. Otomatis mengupdate kolom harga di master barang mengikuti harga
--      satuan penerimaan terbaru dari vendor mitra.
-- ====================================================================
DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_insert_detail_penerimaan$$
CREATE TRIGGER trg_after_insert_detail_penerimaan
AFTER INSERT ON detail_penerimaan
FOR EACH ROW
BEGIN
    DECLARE v_stok_terakhir INT DEFAULT 0;
    DECLARE v_stok_baru INT DEFAULT 0;

    -- A. Ambil saldo stok fisik terakhir dari kartu_stok untuk barang bersangkutan
    SELECT COALESCE(stok, 0) INTO v_stok_terakhir
    FROM kartu_stok
    WHERE idbarang = NEW.barang_idbarang
    ORDER BY idkartu_stok DESC
    LIMIT 1;

    IF v_stok_terakhir IS NULL THEN
        SET v_stok_terakhir = 0;
    END IF;

    -- B. Hitung saldo stok baru
    SET v_stok_baru = v_stok_terakhir + NEW.jumlah_terima;

    -- C. Otomatis catat mutasi Masuk ('M') ke kartu_stok
    INSERT INTO kartu_stok (
        jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at
    ) VALUES (
        'M', NEW.jumlah_terima, 0, v_stok_baru, NEW.idpenerimaan, NEW.barang_idbarang, CURRENT_TIMESTAMP
    );

    -- D. Update harga beli di master barang mengikuti harga penerimaan terbaru
    UPDATE barang
    SET harga = NEW.harga_satuan_terima
    WHERE idbarang = NEW.barang_idbarang;
END$$

DELIMITER ;


-- ====================================================================
-- 2. FUNCTION: fn_hitung_harga_jual
-- Fungsi: Menghitung harga jual barang berdasarkan harga modal barang
--         ditambah margin laba aktif dari tabel margin_penjualan.
-- ====================================================================
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

    -- Ambil harga modal barang terkini
    SELECT harga INTO v_harga_modal
    FROM barang
    WHERE idbarang = p_idbarang;

    -- Ambil persen margin yang statusnya aktif (1)
    SELECT persen INTO v_persen_margin
    FROM margin_penjualan
    WHERE status = 1
    ORDER BY updated_at DESC
    LIMIT 1;

    IF v_persen_margin IS NULL THEN
        SET v_persen_margin = 0;
    END IF;

    -- Hitung harga jual: modal + (modal * margin / 100)
    SET v_harga_jual = v_harga_modal + ROUND(v_harga_modal * (v_persen_margin / 100));

    RETURN v_harga_jual;
END$$

DELIMITER ;


-- ====================================================================
-- 3. STORED PROCEDURE: sp_proses_penjualan
-- Fungsi: Memproses transaksi penjualan kasir secara utuh:
--         - Cek ketersediaan stok fisik di kartu_stok
--         - Panggil fn_hitung_harga_jual untuk kalkulasi harga jual kasir
--         - Hitung PPN & total transaksi
--         - Insert ke header penjualan dan detail_penjualan
--         - Otomatis potong stok dengan mutasi Keluar ('K') di kartu_stok
-- ====================================================================
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

    -- 1. Cek stok fisik terakhir di kartu stok
    SELECT COALESCE(stok, 0) INTO v_stok_tersedia
    FROM kartu_stok
    WHERE idbarang = p_idbarang
    ORDER BY idkartu_stok DESC
    LIMIT 1;

    IF v_stok_tersedia < p_jumlah THEN
        SET p_idpenjualan_baru = 0;
        SET p_pesan = 'GAGAL: Stok barang tidak mencukupi untuk dijual!';
    ELSE
        -- 2. Ambil ID margin aktif
        SELECT idmargin_penjualan INTO v_idmargin
        FROM margin_penjualan
        WHERE status = 1
        ORDER BY updated_at DESC
        LIMIT 1;

        -- 3. Hitung harga jual kasir menggunakan fn_hitung_harga_jual
        SET v_harga_jual = fn_hitung_harga_jual(p_idbarang);
        SET v_subtotal   = v_harga_jual * p_jumlah;
        SET v_ppn        = ROUND(v_subtotal * (p_persen_ppn / 100));
        SET v_total      = v_subtotal + v_ppn;

        -- 4. Simpan ke tabel penjualan
        INSERT INTO penjualan (subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan, created_at)
        VALUES (v_subtotal, v_ppn, v_total, p_iduser, v_idmargin, CURRENT_TIMESTAMP);

        SET p_idpenjualan_baru = LAST_INSERT_ID();

        -- 5. Simpan ke detail_penjualan
        INSERT INTO detail_penjualan (harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang)
        VALUES (v_harga_jual, p_jumlah, v_subtotal, p_idpenjualan_baru, p_idbarang);

        -- 6. Catat mutasi keluar ('K') di kartu_stok
        SET v_stok_baru = v_stok_tersedia - p_jumlah;

        INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at)
        VALUES ('K', 0, p_jumlah, v_stok_baru, p_idpenjualan_baru, p_idbarang, CURRENT_TIMESTAMP);

        SET p_pesan = 'BERHASIL: Transaksi penjualan tersimpan dan stok terpotong.';
    END IF;
END$$

DELIMITER ;
