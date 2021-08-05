<?php
/**
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'instantquote` (
    `id_instantquote` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY  (`id_instantquote`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[]="CREATE TABLE `ps_iq_material_size` (`id_iq_material_size` int(10) UNSIGNED NOT NULL,`material_type_id` int(10) UNSIGNED NOT NULL COMMENT 'Type of Material from ps_material_type',`material_measurement` varchar(20) NOT NULL COMMENT 'Measurement of the material in Gauges',`material_thickness` decimal(3,2) NOT NULL,`display_name` varchar(100) NOT NULL COMMENT 'Name of the Material to be displayed',`material_price` decimal(20,10) UNSIGNED NOT NULL DEFAULT '0.0000000000' COMMENT 'Price of the material',`max_width` int(11) NOT NULL COMMENT 'Maximum Width of the Material',`max_height` int(11) NOT NULL COMMENT 'Maximum Height of the Material',`max_length` int(11) NOT NULL,`is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',`created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[]="INSERT INTO `ps_iq_material_size` (`id_iq_material_size`, `material_type_id`, `material_measurement`, `material_thickness`, `display_name`, `material_price`, `max_width`, `max_height`, `max_length`, `is_active`, `created_on`) VALUES(1, 1, 'Test', '3.00', 'Test', '45.0000000000', 333, 0, 333, 1, '2017-10-12 06:52:33'),(7, 2, '14C', '0.07', '14GA (0.0747\") (2mm)', '0.0105924600', 60, 0, 60, 1, '2015-02-19 04:11:55'),(9, 2, '20C', '0.04', '20GA (0.0359\") (0.9mm)', '0.0050906200', 60, 0, 120, 1, '2015-02-26 06:42:44'),(10, 2, '18C', '0.05', '18GA (0.0478\") (1.25mm)', '0.0067780400', 60, 0, 120, 1, '2015-02-26 06:47:05'),(11, 3, '20G', '0.04', '20GA (0.0359\") (0.9mm)', '0.0066163700', 60, 0, 120, 1, '2015-02-26 06:50:21'),(12, 3, '14G', '0.07', '14GA (0.0858\") (2mm)', '0.0137672100', 48, 0, 120, 1, '2015-02-26 06:54:32'),(13, 3, '18G', '0.05', '18GA (0.0478\") (1.25mm)', '0.0088095400', 60, 0, 120, 1, '2015-02-26 06:55:16'),(14, 1, '14S', '0.07', '14GA (0.0747\") (2mm)', '0.0672300000', 40, 0, 120, 1, '2015-02-26 07:05:56'),(15, 1, '18S', '0.05', '18GA (0.0478\") (1.25mm)', '0.0430200000', 60, 0, 120, 1, '2015-02-26 07:06:02'),(16, 1, '20S', '0.04', '20GA (0.0359\") (0.9mm)', '0.0323100000', 60, 0, 120, 1, '2015-02-26 07:06:08'),(17, 4, '90A', '0.09', '0.09\" (2.30mm)', '0.0300510000', 60, 0, 120, 1, '2015-02-26 07:06:17'),(18, 4, '60A', '0.06', '0.06\" (1.63mm)', '0.0200340000', 60, 0, 120, 1, '2015-02-26 07:06:22'),(19, 4, '30A', '0.03', '0.03\" (.91mm)', '0.0100170000', 60, 0, 120, 1, '2015-02-26 07:06:29');";
$sql[]="CREATE TABLE `ps_iq_material_size_shape_map` (`shape_id` int(10) UNSIGNED DEFAULT NULL,`material_size_id` int(10) UNSIGNED DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$sql[]="INSERT INTO `ps_iq_material_size_shape_map` (`shape_id`, `material_size_id`) VALUES(2, 7),(1, 14),(1, 15),(1, 16),(1, 7),(1, 9),(1, 10),(1, 11),(1, 12),(1, 13),(1, 17),(1, 18),(1, 19);";
$sql[]="CREATE TABLE `ps_iq_material_type` (  `id_iq_material_type` int(11) NOT NULL,  `material_type_name` varchar(50) NOT NULL COMMENT 'Name of the Material Type',  `price_per_volume` decimal(20,6) UNSIGNED NOT NULL COMMENT 'Price per volume',  `density` decimal(20,6) UNSIGNED NOT NULL COMMENT 'Density',  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',  `thickness_order` varchar(50) NOT NULL COMMENT 'Order display',  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[]="INSERT INTO `ps_iq_material_type` (`id_iq_material_type`, `material_type_name`, `price_per_volume`, `density`, `is_active`, `thickness_order`, `created_on`) VALUES(1, 'Aluminimum', '15.000000', '1.200000', 1, 'ASC', '2017-10-12 06:44:02');";
$sql[]="CREATE TABLE `ps_iq_shapes` (  `id_iq_shape` int(10) UNSIGNED NOT NULL,  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Shape',  `sku_prefix` varchar(50) NOT NULL COMMENT 'Unique Prefix of the SKU Number',  `price_engine_path` varchar(255) NOT NULL COMMENT 'Path of the Class file to calculate the price according to the shape',  `shape_image` varchar(255) NOT NULL COMMENT 'Image of the Shape',  `store_id` int(10) DEFAULT NULL,  `image_width` smallint(2) DEFAULT '0' COMMENT 'Width of the Image',  `image_height` smallint(2) DEFAULT '0' COMMENT 'Height of the Image',  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',  `margin` decimal(20,6) NOT NULL,  `packing_material` int(11) NOT NULL,  `ds_product_atatchment` varchar(255) NOT NULL,  `title` varchar(254) NOT NULL,  `note` text NOT NULL,  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[]="INSERT INTO `ps_iq_shapes` (`id_iq_shape`, `display_name`, `sku_prefix`, `price_engine_path`, `shape_image`, `store_id`, `image_width`, `image_height`, `is_active`, `margin`, `packing_material`, `ds_product_atatchment`, `title`, `note`, `created_on`) VALUES(1, 'Killarney Metals Drip Pan', 'KM', 'Srp\CostCalculation\KmPanCostProcessor', 'ptl_422.jpg', 1, 100, 100, 1, '0.438000', 3, 'KillarneySimplePan.PDF', 'WHAT SIZE IS YOUR PAN', 'Fill in the Length, Width and Height Fields on the Diagram Select Material Type, Material Thickness and Number of <span style=\"text-decoration: underline;\"><strong>Parts All Dimensions are in Inches All Dimensions are Outside Dimensions</strong></span>', '2015-02-19 04:18:24');";
$sql[]="CREATE TABLE `ps_iq_shapes_constants` (  `id_iq_shape_constant` int(10) UNSIGNED NOT NULL,  `id_iq_shape` smallint(2) NOT NULL DEFAULT '0' COMMENT 'Shape ID from ps_iq_shapes table',  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Constant',  `constant_name` varchar(100) NOT NULL COMMENT 'Name of the Constant - Not Editable',  `constant_value` varchar(100) NOT NULL COMMENT 'Value of the Constant',  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[]="INSERT INTO `ps_iq_shapes_constants` (`id_iq_shape_constant`, `id_iq_shape`, `display_name`, `constant_name`, `constant_value`, `is_active`, `created_on`) VALUES(1, 1, 'Setup Cost', 'KM_PAN_SETUP_CONST', '85', 1, '2015-02-19 03:34:56'),(2, 1, 'Welding Cost', 'KM_PAN_WELD_CONST', '0.95', 1, '2015-02-19 03:35:10'),(3, 1, 'Labour Cost', 'KM_PAN_LABOUR_CONST', '6.9', 1, '2015-02-19 03:35:26');";
$sql[]="CREATE TABLE `ps_iq_shapes_inputs` (  `id_iq_shapes_input` int(10) UNSIGNED NOT NULL,  `id_iq_shape` smallint(2) NOT NULL DEFAULT '0' COMMENT 'Shape ID from the table iq_shapes',  `param` varchar(25) NOT NULL COMMENT 'Parameters of the Shape (Eg: Length, Width, Height)',  `display_name` varchar(100) NOT NULL COMMENT 'Display Name of the Parameter',  `x_position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position of the Param in X Axis on the image',  `y_position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position of the Param in Y Axis on the image',  `input_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Input Order of the parameter in the image',  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Enabled / 0 - Disabled',  `properties` text NOT NULL,  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[]="INSERT INTO `ps_iq_shapes_inputs` (`id_iq_shapes_input`, `id_iq_shape`, `param`, `display_name`, `x_position`, `y_position`, `input_order`, `is_active`, `properties`, `created_on`) VALUES(1, 1, 'L', 'Length', 75, 270, 1, 1, 'roundto2', '2015-02-19 01:15:17'),(2, 1, 'W', 'Width', 240, 270, 2, 1, 'roundto2', '2015-02-19 01:15:23'),(3, 1, 'H', 'Height', 0, 152, 3, 1, 'roundto2', '2015-02-19 01:15:28');";
$sql[]="ALTER TABLE `ps_iq_material_size` ADD PRIMARY KEY (`id_iq_material_size`);";
$sql[]="ALTER TABLE `ps_iq_material_type` ADD PRIMARY KEY (`id_iq_material_type`), ADD UNIQUE KEY `idx_material_type_name` (`material_type_name`);";
$sql[]="ALTER TABLE `ps_iq_shapes` ADD PRIMARY KEY (`id_iq_shape`);";
$sql[]="ALTER TABLE `ps_iq_shapes_constants` ADD PRIMARY KEY (`id_iq_shape_constant`);";
$sql[]="ALTER TABLE `ps_iq_shapes_inputs` ADD PRIMARY KEY (`id_iq_shapes_input`);";
$sql[]="ALTER TABLE `ps_iq_material_size` MODIFY `id_iq_material_size` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;";
$sql[]="ALTER TABLE `ps_iq_material_type` MODIFY `id_iq_material_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
$sql[]="ALTER TABLE `ps_iq_shapes` MODIFY `id_iq_shape` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
$sql[]="ALTER TABLE `ps_iq_shapes_constants` MODIFY `id_iq_shape_constant` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";
$sql[]="ALTER TABLE `ps_iq_shapes_inputs` MODIFY `id_iq_shapes_input` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";





foreach ($sql as $query)
	if (Db::getInstance()->execute($query) == false)
		return false;
