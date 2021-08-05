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

class AdminMaterialTypeController extends ModuleAdminController {

    public function __construct() {
        $this->table = 'iq_material_type';
        $this->className = 'MaterialType';
        $this->bootstrap = true;
        $this->fields_list = array(
            'id_iq_material_type' => array(
                'title' => ('ID'),
                'align' => 'center',
                'width' => 25,
            ),
            'material_type_name' => array(
                'title' => ('Material Name'),
                'filter_key' => 'a!material_type_name'
            ),
            'price_per_volume' => array(
                'title' => ('Price Per Volume'),
                'filter_key' => 'a!price_per_volume'
            ),
            'density' => array(
                'title' => ('Density'),
                'filter_key' => 'a!density'
            )
        );

        $this->bulk_actions = array('delete' => array('text' => ('Delete selected'), 'confirm' => ('Delete selected items?')));

        parent::__construct();
    }

    public function renderList() {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->_where.= ' AND a.is_active = 1';
        return parent::renderList();
    }

    public function postProcess() {
        if($_POST)
            $this->resetMeterialTypePrice();
         return        parent::postProcess();

    }

    public function renderForm() {
        if (!($obj = $this->loadObject(true)))
            return;
        $this->breadcrumbs[2] = $this->object->material_type_name;

        $this->toolbar_btn['save-and-stay'] = array('href'=>'#', 'desc' => 'Save & stay');
        ksort($this->toolbar_btn);

        $ordering_options = array(array('id_option' => 'ASC','name' => 'Ascending'), array('id_option' => 'DESC','name' => 'Descending'));

        $this->fields_form = array(
            'legend' => array(
                'title' => ('Material Type')
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => ('Name:'),
                    'name' => 'material_type_name',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Price per Volume:'),
                    'name' => 'price_per_volume',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => ('Density:'),
                    'name' => 'density',
                    'required' => true
                ),
               array(
                    'type' => 'select',
                    'label' => ('Order:'),
                    'name' => 'thickness_order',
                    'required' => true,
                    'options' => array(
                        'query' => $ordering_options,
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
            ),
            'submit' => array(
                'title' => ('Save'),
                'class' => 'button'
            )
        );

        return parent::renderForm();
    }

    public function processDelete() {
        $material_type_id = $_REQUEST['id_iq_material_type'];
        $data = MaterialType::checkMaterialSizeMap($material_type_id);
        if (!empty($data)) {
            $this->errors[] = 'Sorry, Unable to delete as this Material Type is associated with one or more Material Sizes';
            return false;
        }
        parent::processDelete();
    }
    public function resetMeterialTypePrice()
    {
        //$this->price_per_volume;
        if($_POST['price_per_volume'] && !empty($_REQUEST['id_iq_material_type']))
        {
              $meterialSize="UPDATE ". _DB_PREFIX_ . "iq_material_size SET material_price=(material_thickness*".($_POST['price_per_volume']).") WHERE material_type_id=".$_REQUEST['id_iq_material_type'];
              return   Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($meterialSize);
        }
        return false;
    }
    public function viewAccess($disable = false)
{
    return true;
}
}
