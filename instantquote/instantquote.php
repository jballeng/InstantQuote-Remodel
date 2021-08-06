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
if (!defined('_PS_VERSION_'))
    exit;

class instantquote extends Module {

    protected $config_form = false;

    public function __construct() {
        $this->name = 'instantquote';
        $this->tab = 'front_office_features';
        $this->version = '2.1.1';
        $this->author = 'Confianz';
        $this->need_instance = 0;
        $this->bootstrap =true;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Instant Quote');
        $this->description = $this->l('Instant Quote - Short ');
        require_once(dirname(__FILE__) . '/MaterialType.php');
        require_once(dirname(__FILE__) . '/MaterialSize.php');
        require_once(dirname(__FILE__) . '/Shape.php');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install() {
         Configuration::updateValue('IQ_DEFAULT_CATEGORY', $this->context->shop->id_category);
         include(dirname(__FILE__).'/sql/install.php');
        return parent::install() &&
                $this->registerTab() &&
                $this->registerHook('header') &&
                $this->registerHook('backOfficeHeader') &&
                $this->registerHook('displayHeader');
    }
    public function uninstall() {
        Configuration::deleteByName('IQ_DEFAULT_CATEGORY');
         include(dirname(__FILE__).'/sql/uninstall.php');
        return parent::uninstall() &&
                $this->uninstallTab();
    }

    /**
     * Load the configuration form
     */
    public function getContent() {
        /**
         * If values have been submitted in the form, process.
         */
        $this->_postProcess();

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

        return $output . $this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm() {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitinstantquoteModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
                . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm() {

        $selected_categories = array(Configuration::get('IQ_DEFAULT_CATEGORY'));
        if(empty($selected_categories)|| empty($selected_categories[0]))
            $selected_categories[]=$this->context->shop->id_category;

        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                    'type'  => 'categories',
                    'label' => $this->trans('Default category', array(), 'Admin.Catalog.Feature'),
                    'name'  => 'id_category',
                    'tree'  => array(
                        'id'                  => 'categories-tree',
                        'selected_categories' => $selected_categories,
                        'disabled_categories' =>  null,
                        'root_category'       => $this->context->shop->getCategory()
                    )
                )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues() {
        return array(
            'instantquote_LIVE_MODE' => Configuration::get('instantquote_LIVE_MODE', true),
            'instantquote_ACCOUNT_EMAIL' => Configuration::get('instantquote_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'instantquote_ACCOUNT_PASSWORD' => Configuration::get('instantquote_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data.
     */
    protected function _postProcess() {
        $form_values = $this->getConfigFormValues();
        if(!empty(Tools::getValue('id_category')))
            Configuration::updateValue('IQ_DEFAULT_CATEGORY', Tools::getValue('id_category'));
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader() {
        $this->context->controller->addJS($this->_path . 'js/back.js');
        $this->context->controller->addJS($this->_path . 'js/material.js');
        $this->context->controller->addJS($this->_path . 'js/jquery-ui.js');
        $this->context->controller->addCSS($this->_path . 'css/back.css');
        return "<script>var instant_quote_module = '" . $this->context->link->getAdminLink('AdminMaterialSize') . "'</script>";
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader() {
        $this->context->controller->addJS($this->_path . '/js/front.js');
        $this->context->controller->addCSS($this->_path . '/css/front.css');

    }

    public function hookDisplayHeader() {
        $this->context->controller->addCSS($this->_path . 'css/findAPan.css');
        $this->context->controller->addJS($this->_path . 'js/jquery.validate.js');
	/* Place your code here. */
	if(Tools::getValue('module') == "instantquote" && Tools::getValue('controller') == "price"){
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.validate.min.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.ui.widget.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.iframe-transport.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.qtip.min.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.fileupload.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.fileupload-process.js');
			 $this->context->controller->addJS($this->_path . 'views/js/jquery.fileupload-validate.js');


       $this->context->controller->addJS($this->_path . '/js/draw.js');
       $this->context->controller->addJS($this->_path . 'views/js/front.js');
		     $page = $this->context->smarty->getTemplateVars('page');
		     $page['meta']['title'] = 'Custom Drip Pan Instant Quote';
		     $page['meta']['description'] = 'Use our custom drip pan quote form to design the pan which fits your needs. All of our products are made in the USA!';
		     $this->context->smarty->assign('page', $page);
        }
    }

    /**
     * Function to add Admin menus for Instant Quote while Install
     * @return boolean
     */
    public function registerTab() {
        // Insert Parent Tab
        $data = array(
            'class_name' => 'AdminParentInstantQuote',
            'module' => $this->name,
            'id_parent' => 0,
            'position' => 15, 'active' => 1,
        );
        $res = Db::getInstance()->insert('tab', $data);
        $id_tab_parent = Db::getInstance()->Insert_ID();
        $data_lang = array(
            'id_tab' => $id_tab_parent,
            'id_lang' => Configuration::get('PS_LANG_DEFAULT'),
            'name' => 'Instant Quote'
        );
        $res &= Db::getInstance()->insert('tab_lang', $data_lang);

        // Insert Child Tab Material Type
        $data = array(
            'class_name' => 'AdminMaterialType',
            'module' => $this->name,
            'id_parent' => $id_tab_parent,
            'position' => 1, 'active' => 1,
        );
        $res = Db::getInstance()->insert('tab', $data);
        $id_tab = Db::getInstance()->Insert_ID();
        $data_lang = array(
            'id_tab' => $id_tab,
            'id_lang' => Configuration::get('PS_LANG_DEFAULT'),
            'name' => 'Material Type'
        );
        $res &= Db::getInstance()->insert('tab_lang', $data_lang);

        // Insert Child Tab Material Size
        $data = array(
            'class_name' => 'AdminMaterialSize',
            'module' => $this->name,
            'id_parent' => $id_tab_parent,
            'position' => 2, 'active' => 1,
        );
        $res = Db::getInstance()->insert('tab', $data);
        $id_tab = Db::getInstance()->Insert_ID();
        $data_lang = array(
            'id_tab' => $id_tab,
            'id_lang' => Configuration::get('PS_LANG_DEFAULT'),
            'name' => 'Material Thickness'
        );
        $res &= Db::getInstance()->insert('tab_lang', $data_lang);

        // Insert Child Tab Shape
        $data = array(
            'class_name' => 'AdminShape',
            'module' => $this->name,
            'id_parent' => $id_tab_parent,
            'position' => 3, 'active' => 1,
        );
        $res = Db::getInstance()->insert('tab', $data);
        $id_tab = Db::getInstance()->Insert_ID();
        $data_lang = array(
            'id_tab' => $id_tab,
            'id_lang' => Configuration::get('PS_LANG_DEFAULT'),
            'name' => 'Shape'
        );
        $res &= Db::getInstance()->insert('tab_lang', $data_lang);
        // Insert Child Tab CRU

        $data = array(
          'class_name' => 'AdminCru',
          'module' => $this->name,
          'id_parent' => $id_tab_parent,
          'position' => 4, 'active' => 1,
        );
        $res = Db::getInstance()->insert('tab', $data);
        $id_tab = Db::getInstance()->Insert_ID();
        $data_lang = array(
          'id_tab' => $id_tab,
          'id_lang' => Configuration::get('PS_LANG_DEFAULT'),
          'name'=>'CRU'
        );
        $res &= Db::getInstance()->insert('tab_lang', $data_lang);

        return true;
    }

    /**
     * Function to remove Admin menus for Instant Quote while Uninstall
     * @return boolean
     */
    public function uninstallTab() {
        $idTab = Tab::getIdFromClassName('AdminParentInstantQuote');
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
        $idTab = Tab::getIdFromClassName('AdminMaterialSize');
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
        $idTab = Tab::getIdFromClassName('AdminMaterialType');
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
        $idTab = Tab::getIdFromClassName('AdminShape');
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
        return true;
    }

}
