
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

class AdminShapeController extends AdminController {

    /**
     * To check whether any one of the material thickness is associated with the material type for the shape
     * @var type
     */
    public $isCheckedAny;

    public function __construct() {
        $this->table = 'iq_shapes';
        $this->identifier='id_iq_shape';
        $this->className = 'Shape';
        $this->bootstrap = true;
        $this->fieldImageSettings = array(
            'name' => 'shape_image',
            'dir' => 'sh'
        );

        //get list of stores
	$shopResult = Db::getInstance()->executeS('SELECT name as shop_name FROM '._DB_PREFIX_.'shop WHERE active = 1');
	$shopList = array();
	foreach($shopResult as $row) {
		$name = current($row);
		$shopList[$name] = $name;
	}


        $this->fields_list = array(
            'id_iq_shape' => array(
                'title' => ('ID'),
                'align' => 'center',
                'width' => 25,
            ),
            'display_name' => array(
                'title' => ('Shape'),
                'filter_key' => 'a!display_name'
            ),
            'sku_prefix' => array(
                'title' => ('SKU Prefix'),
                'filter_key' => 'a!sku_prefix'
            ),
            'name' => array(
                'title' => ('Shop'),
                'filter_key' => 's!name',
                'type' => 'select',
                'list' => $shopList
            )
        );

        //$this->bulk_actions = array('delete' => array('text' => ('Delete selected'), 'confirm' => ('Delete selected items?')));
        $this->actions_available = array_merge($this->actions_available, array('constants'));

        parent::__construct();
    }

    public function renderList() {
        unset($this->toolbar_btn['new']);
        $this->addRowAction('edit');
        $this->addRowAction('constants');
        $this->_select.= 's.name';
        $this->_join.= ' LEFT JOIN ' . _DB_PREFIX_ . 'shop s ON s.id_shop = a.store_id ';
        $this->_where.= ' AND a.is_active = 1';
        return parent::renderList();
    }

    public function postProcess() {
        $shapeID = Tools::getValue('id_iq_shape');

        if (!empty($_POST) && !empty($shapeID)) {
            $display_name = Tools::getValue('display_name');
            $sku_prefix = Tools::getValue('sku_prefix');
            $margin = Tools::getValue('margin');
            $packing_material = Tools::getValue('packing_material');
            $title = Tools::getValue('title');
            $note = Tools::getValue('note');

            // Updating Material Size Mapping data with Shape
            //Shape::deleteExistingMapping($shapeID);
            //$mapData = $_POST['mapping_options'];
            //Shape::addShapeMapping($mapData, $shapeID);

            // Updating Constant Data
            //$constants = $_POST['constants'];
            //Shape::updateConstantValues($constants, $shapeID);

            //Update IQ Shape
            Shape::updateShapeValues($shapeID, $display_name, $sku_prefix, $margin, $packing_material, $title, $note);
        }

        return parent::postProcess();
    }

    public function renderForm() {
        if (!($obj = $this->loadObject(true)))
            return;
        $this->breadcrumbs[2] = $this->object->display_name;
        $this->toolbar_btn['save-and-stay'] = array('href'=>'#', 'desc' => 'Save & stay');
        ksort($this->toolbar_btn);
        $smarty = new Smarty;
        $shapeID = Tools::getValue('id_iq_shape');

        //Building mapping array
        $mappingData = Shape::getMappingOptionData($shapeID);
        if (empty($mappingData)) {
            $mappingOptions = array();
        } else {
            $mappingOptions = $mappingData;
        }

        //Building array to render the checkbox options with mapping data
        $materialTypes = Shape::getMaterialTypeList();
        foreach ($materialTypes as $key => $type) {
            $materialTypes[$key]['group_name'] = trim(strtolower(str_replace(' ', '_', $type['material_type_name'])));
            $materialTypes[$key]['mapping'] = $this->getMappingList($type['id_iq_material_type'], $mappingOptions);
            $materialTypes[$key]['isCheckedAny'] = $this->isCheckedAny;
        }

        // Building array to render the shape constants
        $shapeConstants = Shape::getShapeConstants($shapeID);

        //Detail form initialization
        $this->fields_form = array(
            'legend' => array(
                'title' => ('Shape Details'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => ('Shape:'),
                    'name' => 'display_name',
                    'required' => true,
                    'class' => 'shape-field-width'
                ),
                array(
                    'type' => 'text',
                    'label' => ('SKU Prefix:'),
                    'name' => 'sku_prefix',
                    'required' => true,
                    'class' => 'shape-field-width'
                ),
                array(
                    'type' => 'text',
                    'label' => ('Margin'),
                    'name' => 'margin',
                    'required' => true,
                    'class' => 'shape-field-width'
                ),
                array(
                    'type' => 'text',
                    'label' => ('Packing Material Weight'),
                    'name' => 'packing_material',
                    'required' => true,
                    'class' => 'shape-field-width'
                ),
                array(
                    'type' => 'text',
                    'label' => ('Title'),
                    'name' => 'title',
                    'required' => true,
                    'class' => 'shape-field-width'
                ),
                array(
                    'type' => 'textarea',
                    'label' => ('Notes:'),
                    'name' => 'note',
                    'rows' => 15,
                    'autoload_rte' => true,
                    'cols' => 75,
                    'required' => true
                ),
            ),
            'submit' => array('title' => ('Save'), 'class' => 'button'),
        );

        //Assign data to smarty
        $this->tpl_form_vars = array('materialTypes' => $materialTypes, 'mappingOptions' => $mappingOptions, 'shapeConstants' => $shapeConstants);

        return parent::renderForm();
    }

    /**
     * Function to display constants
     * @param type $token
     * @param type $id
     * @param type $name
     * @return type
     */
//    public function displayConstantsLink($token = null, $id, $name = null) {
//        $linkObj = new Link();
//        $controller_name = 'AdminShapeConstant';
//        $tpl = $this->createTemplate('helpers/list/list_action_view.tpl');
//        $tpl->assign(array(
//            'href' => $linkObj->getAdminLink($controller_name) . "&id_iq_shape=$id",
//            'action' => ''
//        ));
//
//        return $tpl->fetch();
//    }

    /**
     * Function to get Mapping options
     * @param type $id_iq_material_type
     * @param type $mapping_options
     * @return type
     */
    public function getMappingList($id_iq_material_type, $mapping_options) {
        $sizeList = Shape::getMaterialSizeList($id_iq_material_type);
        $this->isCheckedAny = 'false';
        foreach ($sizeList as $key => $size) {
            $sizeList[$key]['checked'] = $this->isChecked($size['id_iq_material_size'], $mapping_options);
            if($sizeList[$key]['checked'] == 'checked'){
                $this->isCheckedAny = 'true';
            }
        }
        return $sizeList;
    }

    /**
     * Function to check whether the option is checked or not
     * @param type $material_type_id
     * @param type $mapping_options
     * @return string
     */
    public function isChecked($material_type_id, $mapping_options) {
        if ($this->search_array($material_type_id, $mapping_options)) {
            return 'checked';
        } else {
            return '';
        }
    }

    /**
     * Custom function to search for a value in an array
     * @param type $needle
     * @param type $haystack
     * @return boolean
     */
    public function search_array($needle, $haystack) {
        if (in_array($needle, $haystack)) {
            return true;
        }
        foreach ($haystack as $element) {
            if (is_array($element) && $this->search_array($needle, $element))
                return true;
        }
        return false;
    }

    public function viewAccess($disable = false)
{
    return true;
}

}
