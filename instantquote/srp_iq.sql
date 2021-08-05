/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.5.37-0ubuntu0.14.04.1-log : Database - srp-web
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`srp-web` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `srp-web`;

/*Table structure for table `ps_iq_material_size` */

DROP TABLE IF EXISTS `ps_iq_material_size`;

CREATE TABLE `ps_iq_material_size` (
  `id_iq_material_size` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `material_type_id` int(10) unsigned NOT NULL COMMENT 'Type of Material from ps_material_type',
  `material_measurement` varchar(20) NOT NULL COMMENT 'Measurement of the material in Gauges',
  `material_thickness` decimal(6,6) NOT NULL,
  `display_name` varchar(100) NOT NULL COMMENT 'Name of the Material to be displayed',
  `material_price` decimal(20,10) unsigned NOT NULL DEFAULT '0.0000000000' COMMENT 'Price of the material',
  `max_width` int(11) NOT NULL COMMENT 'Maximum Width of the Material',
  `max_length` int(11) NOT NULL COMMENT 'Maximum Length of the Material',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_iq_material_size`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_material_size` */

insert  into `ps_iq_material_size`(`id_iq_material_size`,`material_type_id`,`material_measurement`,`material_thickness`,`display_name`,`material_price`,`max_width`,`max_length`,`is_active`,`created_on`) values (7,2,'14C','0.074700','14GA (0.0747\") (2mm)','0.0105924600',60,60,1,'2015-02-19 15:11:55'),(9,2,'20C','0.035900','20GA (0.0359\") (0.9mm)','0.0050906200',60,120,1,'2015-02-26 17:42:44'),(10,2,'18C','0.047800','18GA (0.0478\") (1.25mm)','0.0067780400',60,120,1,'2015-02-26 17:47:05'),(11,3,'20G','0.035900','20GA (0.0359\") (0.9mm)','0.0066163700',60,120,1,'2015-02-26 17:50:21'),(12,3,'14G','0.074700','14GA (0.0858\") (2mm)','0.0137672100',60,120,1,'2015-02-26 17:54:32'),(13,3,'18G','0.047800','18GA (0.0478\") (1.25mm)','0.0088095400',60,120,1,'2015-02-26 17:55:16'),(14,1,'14S','0.047800','14GA (0.0478\") (1.25mm)','0.0741472200',60,120,1,'2015-02-26 18:05:56'),(15,1,'18S','0.047800','18GA (0.0478\") (1.25mm)','0.0474462800',60,120,1,'2015-02-26 18:06:02'),(16,1,'20S','0.035900','20GA (0.0359\") (0.9mm)','0.0356343400',60,120,1,'2015-02-26 18:06:08'),(17,4,'90A','0.090000','0.09\" (2.30mm)','0.0300510000',60,120,1,'2015-02-26 18:06:17'),(18,4,'60A','0.060000','0.06\" (1.63mm)','0.0200340000',60,120,1,'2015-02-26 18:06:22'),(19,4,'30A','0.030000','0.03\" (.91mm)','0.0100170000',60,120,1,'2015-02-26 18:06:29');

/*Table structure for table `ps_iq_material_size_shape_map` */

DROP TABLE IF EXISTS `ps_iq_material_size_shape_map`;

CREATE TABLE `ps_iq_material_size_shape_map` (
  `shape_id` int(10) unsigned DEFAULT NULL,
  `material_size_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_material_size_shape_map` */

insert  into `ps_iq_material_size_shape_map`(`shape_id`,`material_size_id`) values (2,7),(1,7),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19);

/*Table structure for table `ps_iq_material_type` */

DROP TABLE IF EXISTS `ps_iq_material_type`;

CREATE TABLE `ps_iq_material_type` (
  `id_iq_material_type` int(11) NOT NULL AUTO_INCREMENT,
  `material_type_name` varchar(50) NOT NULL COMMENT 'Name of the Material Type',
  `price_per_volume` decimal(20,6) unsigned NOT NULL COMMENT 'Price per volume',
  `density` decimal(4,4) NOT NULL COMMENT 'Density of the Material',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_iq_material_type`),
  UNIQUE KEY `idx_material_type_name` (`material_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_material_type` */

insert  into `ps_iq_material_type`(`id_iq_material_type`,`material_type_name`,`price_per_volume`,`density`,`is_active`,`created_on`) values (1,'Stainless Steel','0.992600','0.2900',1,'2015-02-12 14:37:45'),(2,'Steel\r\n','0.141800','0.2900',1,'2015-02-12 14:37:50'),(3,'Galvanized Steel','0.184300','0.2900',1,'2015-02-12 14:38:00'),(4,'Aluminum\r\n','0.333900','0.1000',1,'2015-02-12 14:38:06');

/*Table structure for table `ps_iq_shape` */

DROP TABLE IF EXISTS `ps_iq_shape`;

CREATE TABLE `ps_iq_shape` (
  `id_iq_shape` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Shape',
  `sku_prefix` varchar(50) NOT NULL COMMENT 'Unique Prefix of the SKU Number',
  `price_engine_path` varchar(255) NOT NULL COMMENT 'Path of the Class file to calculate the price according to the shape',
  `shape_image` varchar(255) NOT NULL COMMENT 'Image of the Shape',
  `image_width` smallint(2) DEFAULT '0' COMMENT 'Width of the Image',
  `image_height` smallint(2) DEFAULT '0' COMMENT 'Height of the Image',
  `margin` decimal(20,6) DEFAULT NULL COMMENT 'margin price for the shapes',
  `title` varchar(255) DEFAULT NULL,
  `note` text,
  `packing_material` int(11) NOT NULL COMMENT 'Packing Material',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ds_product_atatchment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_iq_shape`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_shape` */

insert  into `ps_iq_shape`(`id_iq_shape`,`store_id`,`display_name`,`sku_prefix`,`price_engine_path`,`shape_image`,`image_width`,`image_height`,`margin`,`title`,`note`,`packing_material`,`is_active`,`created_on`,`ds_product_atatchment`) values (1,1,'PAN','KM','Srp\\CostCalculation\\KmPanCostProcessor','ptl_422.jpg',100,100,'0.438000','WHAT SIZE IS YOUR PAN ',' All dimensions are in inches <br /> All dimensions are outside dimensions',3,1,'2015-02-19 15:18:24','eefaf9d44bb4b9f.jpg'),(2,1,'Pan (3 Sided)','KM','Srp\\CostCalculation\\KmPanCostProcessor2','ptl_423.jpg',100,100,'0.438000','WHAT SIZE IS YOUR 3 SIDED PAN ',NULL,0,0,'2015-02-27 12:06:14',NULL);

/*Table structure for table `ps_iq_shape_constant` */

DROP TABLE IF EXISTS `ps_iq_shape_constant`;

CREATE TABLE `ps_iq_shape_constant` (
  `id_iq_shape_constant` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_iq_shape` smallint(2) NOT NULL DEFAULT '0' COMMENT 'Shape ID from ps_iq_shapes table',
  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Constant',
  `constant_name` varchar(100) NOT NULL COMMENT 'Name of the Constant - Not Editable',
  `constant_value` varchar(100) NOT NULL COMMENT 'Value of the Constant',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_iq_shape_constant`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_shape_constant` */

insert  into `ps_iq_shape_constant`(`id_iq_shape_constant`,`id_iq_shape`,`display_name`,`constant_name`,`constant_value`,`is_active`,`created_on`) values (1,1,'Setup Cost','KM_PAN_SETUP_CONST','85',1,'2015-02-19 14:34:56'),(2,1,'Welding Cost','KM_PAN_WELD_CONST','0.95',1,'2015-02-19 14:35:10'),(3,1,'Labour Cost','KM_PAN_LABOUR_CONST','6.9',1,'2015-02-19 14:35:26');

/*Table structure for table `ps_iq_shape_input` */

DROP TABLE IF EXISTS `ps_iq_shape_input`;

CREATE TABLE `ps_iq_shape_input` (
  `id_iq_shape_input` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_iq_shape` smallint(2) NOT NULL DEFAULT '0' COMMENT 'Shape ID from the table iq_shapes',
  `param` varchar(25) NOT NULL COMMENT 'Parameters of the Shape (Eg: Length, Width, Height)',
  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Parameter',
  `x_position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position of the Param in X Axis on the image',
  `y_position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position of the Param in Y Axis on the image',
  `input_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Input Order of the parameter in the image',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_iq_shape_input`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `ps_iq_shape_input` */

insert  into `ps_iq_shape_input`(`id_iq_shape_input`,`id_iq_shape`,`param`,`display_name`,`x_position`,`y_position`,`input_order`,`is_active`,`created_on`) values (1,1,'L','Length',75,270,1,1,'2015-02-19 12:15:17'),(2,1,'W','Width',240,270,2,1,'2015-02-19 12:15:23'),(3,1,'H','Height',0,152,3,1,'2015-02-19 12:15:28'),(4,2,'L','Length2',0,152,1,1,'2015-02-27 18:19:59'),(5,2,'W','width2',135,290,2,1,'2015-02-27 18:20:14'),(6,2,'H','Height2',281,302,3,1,'2015-02-27 18:20:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
