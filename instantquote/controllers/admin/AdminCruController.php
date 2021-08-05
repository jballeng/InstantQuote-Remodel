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

class AdminCruController extends AdminController {

    public function __construct() {
        $this->table = 'iq_cru';
        $this->className = 'cru';
        $this->currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
        $this->fields_list = array(
            'id_iq_cru' => array(
                'title' => ('ID'),
                'align' => 'center',
                'width' => 25,
            ),
            'material_name' => array(
                'title' => ('Material Name'),
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
