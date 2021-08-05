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

class AdminMaterialSizeController extends AdminController {

    public function __construct() {
        $this->table = 'iq_material_size';
        $this->className = 'MaterialSize';
        $this->currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
        $this->fields_list = array(
            'id_iq_material_size' => array(
                'title' => ('ID'),
                'align' => 'center',
                'width' => 25,
            ),
            'material_measurement' => array(
                'title' => ('Material Designation'),
                'filter_key' => 'l!name'
            ),
            'material_type_name' => array(
                'title' => ('Material Type'),
                'filter_key' => 'l!name'
            ),
            'material_thickness' => array(
                'title' => ('Thickness'),
                'filter_key' => 'l!name'
            ),
            'display_name' => array(
                'title' => ('Display Name'),
                'filter_key' => 'l!name'
            ),
        );

        $this->bulk_actions = array('delete' => array('text' => ('Delete selected'), 'confirm' => ('Delete selected items?')));
        $this->bootstrap=true;
        parent::__construct();
    }

    public function renderList() {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->_select.= 't.material_type_name';
        $this->_join.= ' INNER JOIN '._DB_PREFIX_.'iq_material_type t ON t.id_iq_material_type = a.material_type_id ';
        $this->_where.= ' AND a.is_active = 1';
        return parent::renderList();
    }

    public function postProcess() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
            $material_type_id =(!empty($_REQUEST['material_type']))?(int)$_REQUEST['material_type']:0;
            $material_thickness =  (!empty($_REQUEST['thickness']))?(float)$_REQUEST['thickness']:0;
            $price_per_volume = MaterialSize::getMaterialPrice($material_type_id);
            $material_price = ($material_thickness * $price_per_volume['price_per_volume']);
            //echo $material_price;
            echo $material_price;
            die;
        }
        return parent::postProcess();
    }

    public function renderForm() {
        if (!($obj = $this->loadObject(true)))
            return;
        if(!empty($this->object->display_name))
            $this->breadcrumbs[2] = $this->object->display_name;
        $this->toolbar_btn['save-and-stay'] = array('href'=>'#', 'desc' => 'Save & stay');
        ksort($this->toolbar_btn);
        $material_type_options = MaterialSize::getMaterialTypes();
        //Get Material Price
        $material_type_id = (!empty($this->object->material_type_id))?$this->object->material_type_id:0;
        $material_thickness = (!empty($this->object->material_thickness))?$this->object->material_thickness:0;;
        $price_per_volume = MaterialSize::getMaterialPrice($material_type_id);
        $material_price = ($material_thickness * $price_per_volume['price_per_volume']);

        $this->fields_form = array(
            'legend' => array(
                'title' => ('Material Size')
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => ('Material Type:'),
                    'name' => 'material_type_id',
                    'required' => true,
                    'class' => 'field_mt_size',
                    'options' => array(
                        'query' => $material_type_options, // Data from the Material Type table
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => ('Designation:'),
                    'name' => 'material_measurement',
                    'class' => 'field_mt_size',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Thickness:'),
                    'name' => 'material_thickness',
                    'class' => 'field_mt_size',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Display Name:'),
                    'name' => 'display_name',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Max Width:'),
                    'name' => 'max_width',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Max Length:'),
                    'name' => 'max_length',
                    'required' => true
                ),
                array(
                    'label' => ('Material Price:'),
                    'type' => 'text',
                    'name' => 'material_price',
                    'class' => 'mt_price_txt',
                    'readonly' => 'readonly',
                    'id' => 'material_price'
                ),
            ),
            'submit' => array(
                'title' => ('Save'),
                'class' => 'button'
            )
        );

        return parent::renderForm();
    }

    public function viewAccess($disable = false)
{
    return true;
}

}
