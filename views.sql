
USE uts_pbd_005;

CREATE VIEW satuan_vu AS
SELECT idsatuan, nama_satuan, status
FROM satuan;

CREATE VIEW role_vu AS
SELECT idrole, nama_role
FROM role;

CREATE VIEW vendor_vu AS
SELECT idvendor, nama_vendor, badan_hukum, status
FROM vendor;

CREATE VIEW barang_vu AS
SELECT b.idbarang, b.jenis, b.nama, s.nama_satuan, b.status, b.harga
FROM barang b
JOIN satuan s ON b.idsatuan = s.idsatuan;

CREATE VIEW user_vu AS
SELECT u.iduser, u.username, r.nama_role
FROM user u
JOIN role r ON u.idrole = r.idrole;

CREATE VIEW margin_penjualan_vu AS
SELECT m.idmargin_penjualan, m.persen, m.status, u.username AS dibuat_oleh, m.created_at, m.updated_at
FROM margin_penjualan m
JOIN user u ON m.iduser = u.iduser;
