-- ====================================================================
-- FILE: sp_function.sql
-- Proyek: StokKu - Praktikum Pemrograman Basis Data (UTS PBD)
-- Isi: 2 Stored Functions & 2 Stored Procedures
-- ====================================================================

USE uts_pbd_005;

-- ====================================================================
-- 1. FUNCTION: fn_hitung_harga_jual
-- Deskripsi: Menghitung harga jual barang berdasarkan harga modal (tabel barang)
--            ditambah margin aktif (tabel margin_penjualan)
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

    -- 1. Ambil harga modal barang
    SELECT harga INTO v_harga_modal
    FROM barang
    WHERE idbarang = p_idbarang;

    -- 2. Ambil persentase margin penjualan yang statusnya aktif (1)
    SELECT persen INTO v_persen_margin
    FROM margin_penjualan
    WHERE status = 1
    ORDER BY updated_at DESC
    LIMIT 1;

    -- Cegah nilai NULL
    IF v_persen_margin IS NULL THEN
        SET v_persen_margin = 0;
    END IF;

    -- 3. Hitung harga jual: modal + (modal * margin / 100)
    SET v_harga_jual = v_harga_modal + ROUND(v_harga_modal * (v_persen_margin / 100));

    RETURN v_harga_jual;
END$$

DELIMITER ;


-- ====================================================================
-- 2. FUNCTION: fn_hitung_total_transaksi
-- Deskripsi: Menghitung final total nilai transaksi (subtotal + PPN)
-- ====================================================================
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_total_transaksi$$
CREATE FUNCTION fn_hitung_total_transaksi(p_subtotal INT, p_persen_ppn INT)
RETURNS INT
DETERMINISTIC
NO SQL
BEGIN
    DECLARE v_ppn INT DEFAULT 0;
    DECLARE v_total INT DEFAULT 0;

    -- Hitung nilai PPN bulat
    SET v_ppn = ROUND(p_subtotal * (p_persen_ppn / 100));

    -- Total akhir = subtotal + nilai PPN
    SET v_total = p_subtotal + v_ppn;

    RETURN v_total;
END$$

DELIMITER ;


-- ====================================================================
-- 3. STORED PROCEDURE: sp_terima_barang
-- Deskripsi: Mencatat penerimaan fisik barang gudang dari pesanan pengadaan vendor,
--            memasukkan detail penerimaan, dan otomatis mencatat mutasi masuk ke kartu stok.
-- ====================================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_terima_barang$$
CREATE PROCEDURE sp_terima_barang(
    IN p_idpengadaan BIGINT,
    IN p_idbarang INT,
    IN p_jumlah_terima INT,
    IN p_harga_satuan INT,
    IN p_iduser INT,
    OUT p_idpenerimaan_baru BIGINT
)
BEGIN
    DECLARE v_subtotal INT DEFAULT 0;
    DECLARE v_stok_sekarang INT DEFAULT 0;
    DECLARE v_stok_baru INT DEFAULT 0;

    -- Hitung subtotal terima
    SET v_subtotal = p_jumlah_terima * p_harga_satuan;

    -- A. Insert ke header tabel penerimaan
    INSERT INTO penerimaan (idpengadaan, iduser, status, created_at)
    VALUES (p_idpengadaan, p_iduser, '1', CURRENT_TIMESTAMP);

    SET p_idpenerimaan_baru = LAST_INSERT_ID();

    -- B. Insert ke tabel detail_penerimaan
    INSERT INTO detail_penerimaan (idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
    VALUES (p_idpenerimaan_baru, p_idbarang, p_jumlah_terima, p_harga_satuan, v_subtotal);

    -- C. Hitung saldo stok terkini dari riwayat kartu_stok
    SELECT COALESCE(SUM(masuk - keluar), 0) INTO v_stok_sekarang
    FROM kartu_stok
    WHERE idbarang = p_idbarang;

    SET v_stok_baru = v_stok_sekarang + p_jumlah_terima;

    -- D. Otomatis catat mutasi masuk ('M') di tabel kartu_stok
    INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at)
    VALUES ('M', p_jumlah_terima, 0, v_stok_baru, p_idpenerimaan_baru, p_idbarang, CURRENT_TIMESTAMP);
END$$

DELIMITER ;


-- ====================================================================
-- 4. STORED PROCEDURE: sp_proses_penjualan
-- Deskripsi: Memproses transaksi penjualan kasir:
--            - Validasi kecukupan stok fisik di kartu stok
--            - Ambil margin aktif & hitung harga jual dengan fn_hitung_harga_jual
--            - Hitung total akhir dengan fn_hitung_total_transaksi
--            - Simpan ke penjualan & detail_penjualan
--            - Otomatis potong stok dan catat mutasi keluar di kartu_stok
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

    -- 1. Validasi cek ketersediaan stok fisik barang di gudang
    SELECT COALESCE(SUM(masuk - keluar), 0) INTO v_stok_tersedia
    FROM kartu_stok
    WHERE idbarang = p_idbarang;

    IF v_stok_tersedia < p_jumlah THEN
        SET p_idpenjualan_baru = 0;
        SET p_pesan = 'GAGAL: Stok fisik tidak mencukupi untuk transaksi penjualan!';
    ELSE
        -- 2. Ambil ID margin penjualan yang sedang aktif
        SELECT idmargin_penjualan INTO v_idmargin
        FROM margin_penjualan
        WHERE status = 1
        ORDER BY updated_at DESC
        LIMIT 1;

        -- 3. Hitung harga jual otomatis pakai Function fn_hitung_harga_jual
        SET v_harga_jual = fn_hitung_harga_jual(p_idbarang);
        SET v_subtotal   = v_harga_jual * p_jumlah;
        SET v_ppn        = ROUND(v_subtotal * (p_persen_ppn / 100));

        -- 4. Hitung final total transaksi pakai Function fn_hitung_total_transaksi
        SET v_total      = fn_hitung_total_transaksi(v_subtotal, p_persen_ppn);

        -- 5. Insert ke header tabel penjualan
        INSERT INTO penjualan (subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan, created_at)
        VALUES (v_subtotal, v_ppn, v_total, p_iduser, v_idmargin, CURRENT_TIMESTAMP);

        SET p_idpenjualan_baru = LAST_INSERT_ID();

        -- 6. Insert ke tabel detail_penjualan
        INSERT INTO detail_penjualan (harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang)
        VALUES (v_harga_jual, p_jumlah, v_subtotal, p_idpenjualan_baru, p_idbarang);

        -- 7. Hitung sisa stok dan catat mutasi pengeluaran ('K') di kartu_stok
        SET v_stok_baru = v_stok_tersedia - p_jumlah;

        INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stok, idtransaksi, idbarang, created_at)
        VALUES ('K', 0, p_jumlah, v_stok_baru, p_idpenjualan_baru, p_idbarang, CURRENT_TIMESTAMP);

        SET p_pesan = 'BERHASIL: Transaksi penjualan berhasil diproses dan stok terpotong.';
    END IF;
END$$

DELIMITER ;
