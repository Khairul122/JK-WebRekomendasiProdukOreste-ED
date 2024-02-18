/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.22-MariaDB : Database - oreste_rekomendasi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`oreste_rekomendasi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `oreste_rekomendasi`;

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` mediumtext DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `klasifikasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_alternatif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`kode_alternatif`,`nama_alternatif`,`gambar`,`deskripsi`,`harga`,`total`,`rank`,`klasifikasi`) values ('A001','Kemeja Korduroi','983201.jpg','Bahan :Korduroi\r\nUkuran : M,L,XL\r\nLd : 110-115\r\nKlasifikasi warna : Kuning,abu2,muda biru,ungu tua,maroon,Dongker\r\nGaya : komuter korea\r\nJenis kerah : polo\r\n\r\n',135000,2.8726417236907,1,NULL),('A002','Maine Colection','522402.jpg','Bahan : katun\r\nGaya : basic\r\nPanjang atasan : Panjang\r\nUkuran : All size\r\nMotif : kotak-kotak\r\nwarna : biru,pink,hitam,kuning\r\n',155000,3.7535396137655,5,NULL),('A003','Laveya','403503.jpg','Fabric : armany sapto\r\nSize/ukuran : all size\r\nLd : 106 cm\r\nPb : 85 cm\r\n-Wudhu friendly\r\n-Busui friendly\r\n-Tekstur bahan adem,flowly dan tidak nerawang\r\n',185000,3.1247638886319,3,NULL),('A004','Indira','146004.jpg','New series “sofia knitwear”\r\nBy: Indira idn\r\nBahan : knit handmade super stretch\r\nWarna : hitam,oren,cream,maroon\r\nSize : all size M fit to Xl\r\nPd : 70 cm\r\nTekstur bahan lembut adem sungguh nyaman\r\n',175000,2.9467823053133,2,NULL),('A005','Cerruty Chiffon plisket ','343405.jpg','Bahan : ceruty ,furing premiumfuring\r\nGaya : basic,Korean\r\nMotif : etnic\r\n',155000,3.352301589144,4,NULL);

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  `nilai_kriteria` double DEFAULT NULL,
  PRIMARY KEY (`kode_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`kode_kriteria`,`nama_kriteria`,`nilai_kriteria`) values ('C01','Harga',5),('C02','Warna',3),('C03','Bahan',4),('C04','Kualitas',5),('C05','Model',3);

/*Table structure for table `tb_rel_alternatif` */

DROP TABLE IF EXISTS `tb_rel_alternatif`;

CREATE TABLE `tb_rel_alternatif` (
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `kode_sub` varchar(16) DEFAULT NULL,
  KEY `kode_alternatif` (`kode_alternatif`),
  KEY `kode_kriteria` (`kode_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_rel_alternatif` */

insert  into `tb_rel_alternatif`(`kode_alternatif`,`kode_kriteria`,`kode_sub`) values ('A001','C01','S01'),('A001','C02','S06'),('A001','C03','S08'),('A001','C04','S10'),('A001','C05','S13'),('A002','C01','S02'),('A002','C02','S04'),('A002','C03','S07'),('A002','C04','S12'),('A002','C05','S13'),('A003','C01','S02'),('A003','C02','S06'),('A003','C03','S09'),('A003','C04','S10'),('A003','C05','S14'),('A004','C01','S01'),('A004','C02','S04'),('A004','C03','S09'),('A004','C04','S11'),('A004','C05','S13'),('A005','C01','S02'),('A005','C02','S04'),('A005','C03','S09'),('A005','C04','S10'),('A005','C05','S14');

/*Table structure for table `tb_sub` */

DROP TABLE IF EXISTS `tb_sub`;

CREATE TABLE `tb_sub` (
  `kode_sub` varchar(16) NOT NULL,
  `nama_sub` varchar(255) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai_sub` double DEFAULT NULL,
  PRIMARY KEY (`kode_sub`),
  KEY `kode_kriteria` (`kode_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_sub` */

insert  into `tb_sub`(`kode_sub`,`nama_sub`,`kode_kriteria`,`nilai_sub`) values ('S01','100.000-125.000 ','C01',4),('S02','126.000-150.000 ','C01',3),('S03','151.000-175.000 ','C01',2),('S04','176.000-200.000 ','C01',1),('S05','Primer','C02',4),('S06','Sekunder','C02',3),('S07','Tersier','C02',2),('S08','Netral','C02',1),('S09','Tebal','C03',4),('S10','Tidak Mudah Rusak','C03',3),('S11','Mudah Menyerap Keringat','C03',2),('S12','Teksture','C03',1),('S13','Premium','C04',4),('S14','Baik','C04',3),('S15','Standar','C04',2),('S16','Rendah','C04',1),('S17','Sangat Menarik','C05',4),('S18','Menarik','C05',3),('S19','Standar','C05',2),('S20','Kurang Menarik','C05',1);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`user`,`pass`) values ('admin','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
