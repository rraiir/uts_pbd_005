CREATE DATABASE uts_pbd_005;
USE uts_pbd_005;

CREATE TABLE satuan (
idsatuan INT AUTO_INCREMENT,
nama_satuan VARCHAR(45) NOT NULL,
status TINYINT NOT NULL,
CONSTRAINT satuan_idsatuan_pk PRIMARY KEY (idsatuan)
);

CREATE TABLE vendor (
idvendor INT AUTO_INCREMENT,
nama_vendor VARCHAR(100) NOT NULL,
badan_hukum CHAR(1) NOT NULL,
status CHAR(1) NOT NULL,
CONSTRAINT vendor_idvendor_pk PRIMARY KEY (idvendor)
);

CREATE TABLE role (
idrole INT AUTO_INCREMENT,
nama_role VARCHAR(100) NOT NULL,
CONSTRAINT role_idrole_pk PRIMARY KEY (idrole)
);

CREATE TABLE barang (
idbarang INT AUTO_INCREMENT,
jenis CHAR(1) NOT NULL,
nama VARCHAR(45) NOT NULL,
idsatuan INT NOT NULL,
status TINYINT NOT NULL,
harga INT NOT NULL,
CONSTRAINT barang_idbarang_pk PRIMARY KEY (idbarang),
CONSTRAINT barang_idsatuan_fk FOREIGN KEY (idsatuan) REFERENCES satuan(idsatuan)
);

CREATE TABLE user (
iduser INT AUTO_INCREMENT,
username VARCHAR(45) NOT NULL,
password VARCHAR(100) NOT NULL,
idrole INT NOT NULL,
CONSTRAINT user_iduser_pk PRIMARY KEY (iduser),
CONSTRAINT user_idrole_fk FOREIGN KEY (idrole) REFERENCES role(idrole)
);

CREATE TABLE pengadaan (
idpengadaan BIGINT AUTO_INCREMENT,
timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
user_iduser INT NOT NULL,
status CHAR(1) NOT NULL,
vendor_idvendor INT NOT NULL,
subtotal_nilai INT NOT NULL,
ppn INT NOT NULL,
total_nilai INT NOT NULL,
CONSTRAINT pengadaan_idpengadaan_pk PRIMARY KEY (idpengadaan),
CONSTRAINT pengadaan_user_iduser_fk FOREIGN KEY (user_iduser) REFERENCES user(iduser),
CONSTRAINT pengadaan_vendor_idvendor_fk FOREIGN KEY (vendor_idvendor) REFERENCES vendor(idvendor)
);

CREATE TABLE margin_penjualan (
idmargin_penjualan INT AUTO_INCREMENT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
persen DOUBLE NOT NULL,
status TINYINT NOT NULL,
iduser INT NOT NULL,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT margin_penjualan_idmargin_penjualan_pk PRIMARY KEY (idmargin_penjualan),
CONSTRAINT margin_penjualan_iduser_fk FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_pengadaan (
iddetail_pengadaan BIGINT AUTO_INCREMENT,
harga_satuan INT NOT NULL,
jumlah INT NOT NULL,
sub_total INT NOT NULL,
idbarang INT NOT NULL,
idpengadaan BIGINT NOT NULL,
CONSTRAINT detail_pengadaan_iddetail_pengadaan_pk PRIMARY KEY (iddetail_pengadaan),
CONSTRAINT detail_pengadaan_idbarang_fk FOREIGN KEY (idbarang) REFERENCES barang(idbarang),
CONSTRAINT detail_pengadaan_idpengadaan_fk FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan)
);

CREATE TABLE kartu_stok (
idkartu_stok BIGINT AUTO_INCREMENT,
jenis_transaksi CHAR(1) NOT NULL,
masuk INT NOT NULL,
keluar INT NOT NULL,
stok INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
idtransaksi INT NOT NULL,
idbarang INT NOT NULL,
CONSTRAINT kartu_stok_idkartu_stok_pk PRIMARY KEY (idkartu_stok),
CONSTRAINT kartu_stok_idbarang_fk FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
);

CREATE TABLE penerimaan (
idpenerimaan BIGINT AUTO_INCREMENT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
status CHAR(1) NOT NULL,
idpengadaan BIGINT NOT NULL,
iduser INT NOT NULL,
CONSTRAINT penerimaan_idpenerimaan_pk PRIMARY KEY (idpenerimaan),
CONSTRAINT penerimaan_idpengadaan_fk FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan),
CONSTRAINT penerimaan_iduser_fk FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE penjualan (
idpenjualan INT AUTO_INCREMENT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
subtotal_nilai INT NOT NULL,
ppn INT NOT NULL,
total_nilai INT NOT NULL,
iduser INT NOT NULL,
idmargin_penjualan INT NOT NULL,
CONSTRAINT penjualan_idpenjualan_pk PRIMARY KEY (idpenjualan),
CONSTRAINT penjualan_iduser_fk FOREIGN KEY (iduser) REFERENCES user(iduser),
CONSTRAINT penjualan_idmargin_penjualan_fk FOREIGN KEY (idmargin_penjualan) REFERENCES margin_penjualan(idmargin_penjualan)
);

CREATE TABLE detail_penerimaan (
iddetail_penerimaan BIGINT AUTO_INCREMENT,
idpenerimaan BIGINT NOT NULL,
barang_idbarang INT NOT NULL,
jumlah_terima INT NOT NULL,
harga_satuan_terima INT NOT NULL,
sub_total_terima INT NOT NULL,
CONSTRAINT detail_penerimaan_iddetail_penerimaan_pk PRIMARY KEY (iddetail_penerimaan),
CONSTRAINT detail_penerimaan_idpenerimaan_fk FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
CONSTRAINT detail_penerimaan_barang_idbarang_fk FOREIGN KEY (barang_idbarang) REFERENCES barang(idbarang)
);

CREATE TABLE detail_penjualan (
iddetail_penjualan BIGINT AUTO_INCREMENT,
harga_satuan INT NOT NULL,
jumlah INT NOT NULL,
subtotal INT NOT NULL,
penjualan_idpenjualan INT NOT NULL,
idbarang INT NOT NULL,
CONSTRAINT detail_penjualan_iddetail_penjualan_pk PRIMARY KEY (iddetail_penjualan),
CONSTRAINT detail_penjualan_penjualan_idpenjualan_fk FOREIGN KEY (penjualan_idpenjualan) REFERENCES penjualan(idpenjualan),
CONSTRAINT detail_penjualan_idbarang_fk FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
;

CREATE TABLE retur (
idretur BIGINT AUTO_INCREMENT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
idpenerimaan BIGINT NOT NULL,
iduser INT NOT NULL,
CONSTRAINT retur_idretur_pk PRIMARY KEY (idretur),
CONSTRAINT retur_idpenerimaan_fk FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
CONSTRAINT retur_iduser_fk FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_retur (
iddetail_retur INT AUTO_INCREMENT,
jumlah INT NOT NULL,
alasan VARCHAR(200) NOT NULL,
idretur BIGINT NOT NULL,
iddetail_penerimaan BIGINT NOT NULL,
CONSTRAINT detail_retur_iddetail_retur_pk PRIMARY KEY (iddetail_retur),
CONSTRAINT detail_retur_idretur_fk FOREIGN KEY (idretur) REFERENCES retur(idretur),
CONSTRAINT detail_retur_iddetail_penerimaan_fk FOREIGN KEY (iddetail_penerimaan) REFERENCES detail_penerimaan(iddetail_penerimaan)
);
