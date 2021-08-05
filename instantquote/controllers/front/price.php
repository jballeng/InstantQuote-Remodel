<?php

require 'modules/instantquote/pricecalculators/autoload.php';

class InstantquotePriceModuleFrontController extends ModuleFrontControllerCore {
public $moduleName;
    public function initContent() {
        parent::initContent();
        $this->moduleName="instantquote";
        $storeId = $this->context->shop->id;
        //$shapeId = 1;
        // http://killarneymetals.loc/module/instantquote/price
        //_DB_PREFIX_
        /* $sqlStore = "SELECT shape_id FROM " . _DB_PREFIX_ . "iq_store_shape_map WHERE store_id = ".$this->context->shop->id." AND is_active = 1";
          $StoreShapelist = Db::getInstance()->executeS($sqlStore);
         */


        $isSingleShape = false;
        $sql_single = "";
        $shapeImage = "";
        $material_types_list = "";
        $shapeInputsData = array();
        if (!empty($_GET['shapeid'])) {
            $shapeId = (int) $_GET['shapeid'];
            $sql_single = " AND id_iq_shape = $shapeId ";
        }

        $skuProduct = false;


        if (!empty($_GET['sku'])) {
            $productSku = trim($_GET['sku']);
            $sqlProduct = "SELECT shape_id,id_product FROM ps_product WHERE reference = '{$productSku}'";
            $sqlProductData = Db::getInstance()->getRow($sqlProduct);

            if (!empty($sqlProductData['shape_id'])) {
                $skuProduct = true;
                $shapeId = $sqlProductData['shape_id'];
                $sql_single = " AND id_iq_shape = $shapeId ";
            }
        }


        $sqlClass = "SELECT price_engine_path,id_iq_shape,shape_image,display_name,title,note FROM " . _DB_PREFIX_ . "iq_shapes WHERE store_id = $storeId {$sql_single} AND is_active = 1";
        $shapeClassData = Db::getInstance()->executeS($sqlClass);
        $sqlClass2 = "SELECT id_product, procure_method FROM " . _DB_PREFIX_ . "product WHERE store_id = $storeId {$sql_single} AND id_product > 0";
        $shapeCount = count($shapeClassData);
        $item = Db::getInstance()->executeS($sqlClass2);
        $item2 = $item['id_product'];

        if ($shapeCount == 1) {
            $isSingleShape = true;
            $shapeClassData = array_shift($shapeClassData);
            $shapeId = $shapeClassData['id_iq_shape'];
            $shapeImage = $shapeClassData['shape_image'];
            if ($isSingleShape) {
                $sqlShapeInputs = "SELECT param,id_iq_shape,x_position,y_position,display_name,properties FROM " . _DB_PREFIX_ . "iq_shapes_inputs WHERE id_iq_shape = $shapeId AND is_active=1 ORDER BY input_order ASC;";
                $shapeInputsData = Db::getInstance()->executeS($sqlShapeInputs);
            }

            $sql = "SELECT material_type_name,id_iq_material_type,price_per_volume
                        FROM " . _DB_PREFIX_ . "iq_material_type T1
                        JOIN " . _DB_PREFIX_ . "iq_material_size T2
                        ON T1.id_iq_material_type = T2.material_type_id
                        JOIN " . _DB_PREFIX_ . "iq_material_size_shape_map T3
                        ON T2.id_iq_material_size = T3.material_size_id
                        WHERE T1.is_active = 1 AND T3.shape_id = $shapeId AND T2.is_active = 1 GROUP BY id_iq_material_type ORDER BY material_type_name ";
            $material_types_list = Db::getInstance()->executeS($sql);
        }



        $productSku = "";
        $fieldDetails = array();
        if (!empty($_GET['sku']) && ($skuProduct)) {
            $productSku = trim($_GET['sku']);

            $shapeClass = $shapeClassData['price_engine_path'];
            $post_param['sku'] = $productSku;
            $post_param['qty'] = 0;
            $meterial_data = new $shapeClass($post_param);
            //$validate = $meterial_data->getPrice();
            $fieldData = $meterial_data->getFieldValues();
            $fieldDetails = $fieldData['data']['fields'];
        }/**/

        $this->registerStylesheet('module-'.$this->moduleName,'/modules/'.$this->moduleName.'/css/'.$this->moduleName.'.css', ['media' => 'all', 'priority' => 50]);
        $this->context->controller->registerJavascript('module-'.$this->moduleName.'-price', '/modules/'.$this->moduleName.'/js/front.js', ['position' => 'bottom', 'priority' => 0]);

        $this->context->smarty->assign('isSingleShape', $isSingleShape);
        $this->context->smarty->assign('shapeImage', $shapeImage);
        $this->context->smarty->assign('shapeClassData', $shapeClassData);
        $this->context->smarty->assign('item2', $item2);
        $this->context->smarty->assign('productSku', $productSku);
        $this->context->smarty->assign('fieldDetails', $fieldDetails);
        $this->context->smarty->assign(array('material_types' => $material_types_list, 'shapeInputsData' => $shapeInputsData));

        $this->setTemplate('module:'.$this->moduleName.'/views/templates/front/instantquote.tpl');

    }

public function postProcess(){

         $this->errors = array();
		if(Tools::isSubmit('instantaddRFQ')){
            if(!ReCaptcha::verifyResponse(Tools::getValue('g-recaptcha-response')))
            {
               $this->context->controller->errors[] = $this->trans('Recaptcha validation error', array(), 'Shop.Notifications.Error');
                return;
            }
            $first_name = trim(Tools::getValue('fullname'));
            $last_name = "";
            $company_name = "";
            $contact_number = trim(Tools::getValue('phone'));
            $contact_email = trim(Tools::getValue('email'));
            $order_quantity = "";
            $order_material = "";
            $product_in_detail = trim(Tools::getValue('product_in_detail'));
            $attachmentArray=[];

            $postedFiles=Tools::getValue('attachmentsServer');

            if(!empty($postedFiles))
            {    $postedFiles=array_filter($postedFiles);
                $attachmentArray=$this->attachFiles($postedFiles);
            }
            $rfqDetails=array(
                'first_name' => $first_name,
                'last_name' =>$last_name,
                'company_name' =>$company_name,
                'contact_number' => $contact_number,
                'contact_email' =>$contact_email,
                'order_quantity' => $order_quantity,
                'order_material' => $order_material,
                'product_in_detail' => $product_in_detail,
                'attachments'=>$attachmentArray
            );
            $mail_data = array(
                '{first_name}' => $first_name,
                '{last_name}' => $last_name,
                '{company_name}' => $company_name,
                '{contact_number}' => $contact_number,
                '{contact_email}' => $contact_email,
                //'{product_name}' => $product_name,
                '{order_quantity}' => $order_quantity,
                '{order_material}' => $order_material,
                '{product_in_detail}' => $product_in_detail
            );
            $id_shop = $this->context->shop->id;
            //store to db
            $files = array();
            foreach($attachmentArray as $file)
            {
                $files[] = $file['basename'];
            }
            $files = implode("," , $files);
            $database_data = array(
                'first_name' => pSQL(utf8_decode($first_name)),
                'last_name' => pSQL(utf8_decode($last_name)),
                'company' => pSQL(utf8_decode($company_name)),
                'phone' => pSQL(utf8_decode($contact_number)),
                'email' => pSQL(utf8_decode($contact_email)),
                'shop_id' => $id_shop,
                'order_quantity' => pSQL(utf8_decode($order_quantity)),
                'material' =>  pSQL(utf8_decode($order_material)),
                'product_detail' => pSQL(utf8_decode($product_in_detail)),
                'files' => $files
            );
            if(!empty($this->context->customer->id))
            {
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
            if(!empty($attachmentArray) && is_array($attachmentArray)){
                foreach ($attachmentArray as $far){
                    $far['name']=$far['name'].'.'.$far['extension'];
                    $mailFiles[]=$far;
                }
            }
            if (!Mail::Send($this->context->language->id, 'request_quote', Mail::l('Quote Request'), $mail_data, Configuration::get('PS_SHOP_EMAIL'), Configuration::get('PS_SHOP_NAME'), Configuration::get('PS_SHOP_EMAIL'), ($customer->id ? $customer->firstname . ' ' . $customer->lastname : ''), $mailFiles)) {
                $this->errors[] = Tools::displayError('Your request has been processed but there was some error in sending email confirmation.');
            }else{
                Tools::redirect($this->context->link->getModuleLink('requestquote','quote',array('confirm'=>'success')));
            }
		}else{
			 parent::postprocess();
		}
    }

      private function attachFiles($files,$upload_dir = "") {
        $cnt = 0;
        $maxfiles = 3;
        $upload_path = _PS_ROOT_DIR_.'/upload/requestquote/';
        $fileAttachments = array();
        $i=0;
        foreach($files as $value){
            if($cnt <= $maxfiles) {
                try {

                    if(!empty($value)) {
                        $fileItem=$upload_path.$value;
                        if( !file_exists($fileItem) || !is_file($fileItem) )
                             continue;
                        $path_parts = pathinfo($fileItem);
                        if(empty($path_parts['extension'])) {
                            continue;
                        }

                        $fileAttachment['name'] = $path_parts['filename'];
                        $fileAttachment['extension'] = $path_parts['extension'];
                        $fileAttachment['mime'] =  @mime_content_type($fileItem);
                        $fileAttachment['basename'] =  $path_parts['basename'];
                        $fileAttachment['content'] = base64_encode(@file_get_contents($fileItem));
                        $fileAttachments["".($i++)] = $fileAttachment;
                    }
                } catch(Exception $ex) {
                    continue;
                }
                $cnt++;
            }
        }

        return $fileAttachments;
    }

}
