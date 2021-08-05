<?php

/*
 * 2007-2013 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2013 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class Shape extends ObjectModel {

    /** @var integer Shape id */
    public $id_shape;

    /** @var string Shape Display Name */
    public $display_name;

    /** @var integer Shape SKU Prefix */
    public $sku_prefix;

    /** @var string Shape Margin */
    public $margin;
    
    /** @var string Shape Margin */
    public $packing_material;

    /** @var string Shape Title */
    public $title;

    /** @var integer Shape Note */
    public $note;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iq_shapes',
        'primary' => 'id_iq_shape',
        'fields' => array(
            'display_name' => array('type' => self::TYPE_STRING, 'required' => true),
            'sku_prefix' => array('type' => self::TYPE_STRING, 'required' => true),
            'margin' => array('type' => self::TYPE_STRING, 'required' => true),
            'packing_material' => array('type' => self::TYPE_STRING, 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'required' => true),
            'note' => array('type' => self::TYPE_HTML, 'required' => true)
        ),
    );

    public function __construct($id = null, $name = null, $id_lang = null) {        
        $this->def = MaterialType::getDefinition($this);
        $this->setDefinitionRetrocompatibility();

        if ($id)
            parent::__construct($id);
        else if ($name && Validate::isGenericName($name) && $id_lang && Validate::isUnsignedId($id_lang)) {
            $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT *
			FROM `' . _DB_PREFIX_ . 'shapes` t
			WHERE `display_name` LIKE \'' . pSQL($name));

            if ($row) {
                $this->id = (int) $row['id_iq_shape'];
                $this->name = $row['display_name'];
            }
        }
    }

    /**
     * Adding values to the Material Type table
     * @author Hari
     * @param type $autodate
     * @param type $null_values
     * @return boolean
     */
    public function add($autodate = true, $null_values = false) {
        if (!parent::add($autodate, $null_values))
            return false;

        return true;
    }
    

    /**
     * Function to get all list of material types
     * @return type array
     */
    public static function getMaterialTypeList() {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT DISTINCT(mt.id_iq_material_type), mt.material_type_name 
                                                              FROM ' . _DB_PREFIX_ . 'iq_material_type mt
                                                              LEFT JOIN ' . _DB_PREFIX_ . 'iq_material_size ms ON ms.material_type_id = mt.id_iq_material_type
                                                              WHERE ms.is_active = 1 ORDER BY id_iq_material_type ASC');
    }

    /**
     * Function to get all material sizes according to material type
     * @param type $material_type_id
     * @return type array
     */
    public static function getMaterialSizeList($material_type_id) {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_iq_material_size, material_measurement, display_name FROM `' . _DB_PREFIX_ . 'iq_material_size` WHERE `is_active` = 1 AND material_type_id = ' . $material_type_id);
    }

    /**
     * Deleting existing mapping to insert new set of values
     * @param type $shapeID
     */
    public static function deleteExistingMapping($shapeID) {
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('DELETE FROM `' . _DB_PREFIX_ . 'iq_material_size_shape_map` WHERE shape_id =' . $shapeID);
    }

    /**
     * Function to insert mapping options to mapping table
     * @param type $mapData
     * @param type $shapeID
     */
    public static function addShapeMapping($mapData, $shapeID) {
        foreach ($mapData as $option) {
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('INSERT INTO `' . _DB_PREFIX_ . 'iq_material_size_shape_map` (shape_id, material_size_id) VALUE (' . $shapeID . ', ' . $option . ')');
        }
    }

    /**
     * Function to get mapping option data
     * @param type $shapeID
     * @return type array
     */
    public static function getMappingOptionData($shapeID) {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT material_size_id FROM ' . _DB_PREFIX_ . 'iq_material_size_shape_map WHERE shape_id =' . $shapeID);
    }

    /**
     * 
     * @param type $shapeID
     * @return type array
     */
    public static function getShapeConstants($shapeID) {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_iq_shape_constant, display_name, constant_name, constant_value FROM ' . _DB_PREFIX_ . 'iq_shapes_constants WHERE is_active = 1 AND id_iq_shape =' . $shapeID);
    }

    /**
     * Function to update constant values
     * @param type $constant
     * @param type $shapeID
     * @return type
     */
    public static function updateConstantValues($constants, $shapeID) {
        foreach ($constants as $key=>$value) {
            Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('UPDATE `' . _DB_PREFIX_ . 'iq_shapes_constants` SET constant_value = '.$value.' WHERE constant_name = "'.$key.'" AND id_iq_shape = '.$shapeID);
        }
    }

    public static function updateShapeValues($id_iq_shape, $display_name, $sku_prefix, $margin, $packing_material, $title, $note){
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('UPDATE `' . _DB_PREFIX_ . 'iq_shapes` SET display_name = "'.$display_name.'" , sku_prefix = "'.$sku_prefix.'" , margin = "'.$margin.'" , packing_material = "'.$packing_material.'" , title = "'.$title.'" , note = "'.$note.'" WHERE  id_iq_shape = '.$id_iq_shape);
    } 

}
