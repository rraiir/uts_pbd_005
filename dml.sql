USE uts_pbd_005;

INSERT INTO satuan (nama_satuan, status) VALUES
('PCS', 1),
('LUSIN', 1),
('KG', 1),
('LITER', 1),
('SACHET', 1);

INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES
('PT Mitra Pangan', 'Y', '1'),
('CV Berkah Jaya', 'Y', '1'),
('PT Sumber Rejeki', 'Y', '1'),
('UD Makmur Sentosa', 'N', '1'),
('Toko Sinar Baru', 'N', '1');

INSERT INTO role (nama_role) VALUES
('Admin'),
('Kasir'),
('Gudang'),
('Manager'),
('Supervisor');

INSERT INTO barang (jenis, nama, idsatuan, status, harga) VALUES
('M', 'Wafer Cokelat', 1, 1, 2500),
('M', 'Kecap Manis Sachet', 5, 1, 1500),
('B', 'Gula Pasir 1kg', 3, 1, 16000),
('B', 'Minyak Goreng 2L', 4, 1, 38000),
('K', 'Sabun Cuci Piring', 1, 1, 9000);

INSERT INTO user (username, password, idrole) VALUES
('admin', SHA2('admin123', 256), 1),
('kasir1', SHA2('kasir123', 256), 2),
('gudang1', SHA2('gudang123', 256), 3),
('manager1', SHA2('manager123', 256), 4),
('supervisor1', SHA2('supervisor123', 256), 5);

INSERT INTO margin_penjualan (persen, status, iduser) VALUES
(10.0, 1, 1),
(15.0, 0, 1),
(20.0, 0, 1),
(25.0, 0, 1),
(30.0, 0, 1);
