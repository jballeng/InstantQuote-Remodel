<?php

class instantquoteCustomerQuoteModuleFrontController extends ModuleFrontControllerCore
{
    public function initContent() {
        parent::initContent();
    }


    public function displayAjaxsaveCustomerQuote()
    {
        $first_name = trim(Tools::getValue('first_name'));
        $last_name = trim(Tools::getValue('last_name'));
        $company_name = trim(Tools::getValue('company_name'));
        $contact_number = trim(Tools::getValue('contact_number'));
        $contact_email = trim(Tools::getValue('contact_email'));
        $business_personal = trim(Tools::getValue('business_personal'));
        $rfqDetails=array(
            'first_name' => $first_name,
            'last_name' =>$last_name,
            'company_name' =>$company_name,
            'contact_number' => $contact_number,
            'contact_email' =>$contact_email,
        );
        $mail_data = array(
            '{first_name}' => $first_name,
            '{last_name}' => $last_name,
            '{company_name}' => $company_name,
            '{contact_number}' => $contact_number,
            '{contact_email}' => $contact_email,
            '{purpose_type}' => $business_personal,
        );
        $id_shop = $this->context->shop->id;
        $database_data = array(
            'first_name' => pSQL(utf8_decode($first_name)),
            'last_name' => pSQL(utf8_decode($last_name)),
            'company' => pSQL(utf8_decode($company_name)),
            'phone' => pSQL(utf8_decode($contact_number)),
            'email' => pSQL(utf8_decode($contact_email)),
            'purpose_type' => $business_personal,
            'shop_id' => $id_shop,
            'quote_type' => 'instantquote'

        );
        if(!empty($this->context->customer->id)) {
            $database_data['user_id'] = $this->context->customer->id;
        }
        $sql = sprintf(
            'INSERT INTO `'._DB_PREFIX_.'request_quote` (%s) VALUES ("%s")',
            implode(',',array_keys($database_data)),
            implode('","',array_values($database_data))
        );
        $result = Db::getInstance()->Execute($sql);

        $odooParams=array('crm.lead','RfqFromPrestashop',$id_shop,$rfqDetails);
        $odoo=new Odoo();
        $odooResult=  $odoo->sendDataToOdoo($odooParams);
        $customer = $this->context->customer;
        if (!$customer->id) {
            $customer->getByEmail($contact_email);
        }
        $mailFiles=array();
        if (!Mail::Send($this->context->language->id, 'instant_quote', Mail::l('Instant Quote Request'), $mail_data, Configuration::get('PS_SHOP_EMAIL'), Configuration::get('PS_SHOP_NAME'), Configuration::get('PS_SHOP_EMAIL'), ($customer->id ? $customer->firstname . ' ' . $customer->lastname : ''), $mailFiles)) {
            $response['status'] = true;
            $response['message'] = "Your request has been processed but there was some error in sending email confirmation.";
        }
        else{
            $response['status'] = true;
            $response['message'] = "Quote added successfully.";
        }
        echo json_encode($response);
    }
}