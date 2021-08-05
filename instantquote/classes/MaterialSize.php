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

class MaterialSize extends ObjectModel {

    /** @var integer Material Size id */
    public $id_material_size;

    /** @var integer Material Type id */
    public $material_type_id;

    /** @var string Material Measurement in Gauges */
    public $material_measurement;

    /** @var string Material Thickness in Gauges */
    public $material_thickness;

    /** @var string Material Size Display Name */
    public $display_name;

    /** @var string Material Size Max Width */
    public $max_width;

    /** @var string Material Size Max Length */
    public $max_length;

    /** @var string Material Price */
    public $material_price;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'iq_material_size',
        'primary' => 'id_iq_material_size',
        'fields' => array(
            'material_type_id' => array('type' => self::TYPE_STRING, 'required' => true),
            'material_measurement' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 5),
            'material_thickness' => array('type' => self::TYPE_STRING, 'validate' => 'isUnsignedFloat', 'required' => true, 'size' => 30),
            'display_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'max_width' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'max_length' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'material_price' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
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
			FROM `' . _DB_PREFIX_ . 'iq_material_type` t
			WHERE `material_type_name` LIKE \'' . pSQL($name));

            if ($row) {
                $this->id = (int) $row['id_material_type'];
                $this->name = $row['material_type_name'];
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
     * Function to get Material Types
     * @return type
     */
    public static function getMaterialTypes(){
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT id_iq_material_type as id_option, material_type_name as name 
			FROM `' . _DB_PREFIX_ . 'iq_material_type` 
			WHERE is_active = 1');
    }

}
