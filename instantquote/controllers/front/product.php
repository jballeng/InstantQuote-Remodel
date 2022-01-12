<?php

require 'modules/instantquote/pricecalculators/autoload.php';
require_once _PS_MODULE_DIR_ . 'instantquote/config.php';

class InstantquoteproductModuleFrontController extends ModuleFrontControllerCore 
{

    public function initContent() 
    {
        parent::initContent();
        $validate['status'] = "error";
        $validate['data'] = array();
        $productId = 0;
        $this->ajax = true;
        $storeId = $this->context->shop->id;

        if ($this->ajax) {
            //special variable to check if the call is ajax
            // if ($post_methode == 'price_engine') {
            //         $sku = "KM-36-36-4141C1";
            
            $sku = !empty($_POST['sku']) ? $_POST['sku'] : "";
            $shapeName = !empty($_POST['shapeName']) ? $_POST['shapeName'] : "";
            $qty = !empty($_POST['qty']) ? $_POST['qty'] : 0;
            $shapeId = !empty($_POST['shapeId']) ? (int) $_POST['shapeId'] : 0;
            $imageFileName = !empty($_POST['imageFileName']) ? $_POST['imageFileName'] : 0;
            $imageData = !empty($_POST['imageData']) ? $_POST['imageData'] : NULL;
            $productWeight = !empty($_POST['productWeight']) ? $_POST['productWeight'] : 0;
            $materialType = !empty($_POST['material']) ? $_POST['material'] : NULL;
            //new changes ..taking from db
            $sqlClass = "SELECT price_engine_path,id_iq_shape,shape_image,display_name,title,note FROM " . _DB_PREFIX_ . "iq_shapes WHERE store_id = $storeId AND id_iq_shape = $shapeId  AND is_active = 1";
            $shapeClassData = Db::getInstance()->getRow($sqlClass);

            require_once _PS_MODULE_DIR_ . 'instantquote/pricecalculators/Srp/CostCalculation/KmPanCostProcessor.php';
            $shapeClass = $shapeClassData['price_engine_path'];
            $post_param['sku'] = $sku;
            $post_param['qty'] = $qty;
            $meterial_data = new KmPanCostProcessor($post_param);
            $fieldData = $meterial_data->getFieldValues();
            $fieldDetails = $fieldData['data']['fields'];
            $priceData = $meterial_data->getPrice();

            $productLength = !empty($fieldDetails['L']) ? $fieldDetails['L'] : "";
            $productHeight = !empty($fieldDetails['H']) ? $fieldDetails['H'] : "";
            $productWidth = !empty($fieldDetails['W']) ? $fieldDetails['W'] : "";
            $productWeight = !empty($priceData['data']['weight']) ? $priceData['data']['weight'] : "";
            $odoo=new Odoo();

            
            if (!empty($sku)) {
                $sql = "SELECT id_product, id_category_default FROM " . _DB_PREFIX_ . "product WHERE reference = '$sku' ";
                $product_data = Db::getInstance()->executeS($sql);
                if (!empty($product_data)) {
                    
                    $validate['status'] = "ok";
                    $productId = $product_data[0]['id_product'];
                    $sqlUpdate = "UPDATE " . _DB_PREFIX_ . "product SET `weight`='{$productWeight}', `active`= 1 WHERE `id_product`='{$productId}';";
                    $productUpdate = Db::getInstance()->execute($sqlUpdate);
                    $sqlUpdate2 = "UPDATE " . _DB_PREFIX_ . "product_shop SET `active`= 1 WHERE active = 0 AND `id_product`='{$productId}';";
                    $productUpdate2 = Db::getInstance()->execute($sqlUpdate2);

                    $product = new Product((int) $productId);
                    $categoryProductData = $product->getWsCategories();
                    if(empty($categoryProductData)) {
                        $product->setWsCategories(array($product_data[0]['id_category_default']));
                    }

                    $attachments = Product::getAttachmentsStatic($this->context->language->id, $productId);
                    foreach ($attachments as $row) {
                        $attachmentId = $row['id_attachment'];
                        break;
                    }
                    if(!empty($attachmentId))
                        $this->syncProductToOdoo($productId, $attachmentId);

                } else {
                    $validate['status'] = "ok";
                    $product = new Product();
                    $link_rewrite = preg_replace('/\.+/', '_', $sku);

                    $product->sku = $sku;
                    $product->active =1;
                    $product->reference = $sku;
                    $product->link_rewrite[$this->context->cookie->id_lang] = $link_rewrite;
                    $product->name[$this->context->cookie->id_lang] = $shapeName;
                    $product->description = $shapeName;
                    $product->quantity = $qty;
                    $product->procure_method = "made_to_order";
                    $product->is_iq_genarated = 1;
                    $product->shape_id = $shapeId;
                    $product->weight = $productWeight;
                    $product->height = $productHeight;
                    $product->width = $productWidth;
                    $product->depth = $productLength;
                    $product->id_tax_rules_group = 0;//IQ_DEFAULT_TAXRULE;
                    //$product->price = $priceData['data']['orig_price'];
                    $product->id_category_default =Configuration::get('IQ_DEFAULT_CATEGORY');
                    $product->material_type = $materialType;

                    //  $sqltaxCheck = "SELECT id_tax_rules_group FROM " . _DB_PREFIX_ . "tax_rules_group WHERE id_tax_rules_group = " . IQ_DEFAULT_TAXRULE . ";";
                    //  $taxCheck = Db::getInstance()->getRow($sqltaxCheck);

                    //   if (empty($taxCheck)) {
                    //        $validate['status'] = "error";
                    //       goto end;
                    //   }

                    $product->add();
                    $product->setWsCategories(array($product->id_category_default));
                    $productId = $product->id;

                    $imageFilePath = _PS_ROOT_DIR_ . "/download/" . $imageFileName;
                    $bin = base64_decode($imageData, true);
                    file_put_contents($imageFilePath, $bin);
                    $uniqid = $imageFileName;
                    $mime = mime_content_type($imageFilePath);

                    $sqlAttachment = "SELECT id_attachment FROM " . _DB_PREFIX_ . "attachment WHERE `file_name` = '{$uniqid}';";
                    $attachment = Db::getInstance()->getRow($sqlAttachment);
                    if (empty($attachment['id_attachment'])) {
                        $attachment = new Attachment();
                        foreach (Language::getLanguages(false) as $language) {
                            $attachment->name[(int) $language['id_lang']] = $uniqid;
                            $attachment->description[(int) $language['id_lang']] = $uniqid;
                        }
                        $attachment->file = $uniqid;
                        $attachment->mime = $mime;
                        $attachment->file_name = $uniqid;
                        $attachment->file_type = 'Drawing';
                        $res = $attachment->add();

                    } else {
                        $attachment = new Attachment($attachment['id_attachment']);
                    }
                    $attachment->attachProduct($productId);
                    $this->syncProductToOdoo($productId, $attachment->id);
                }
            }
            $validate['data']['productId'] = $productId;
            //end:
            //  $validate['data'] = array();
            // $validate['status'] = "error";
        }
        echo json_encode($validate);
    }

    public function syncProductToOdoo($productId, $attachmentId) {
        $self_api_key = $this->getSelfAPIKey();
        $opt['resource'] = 'products';
        $opt['id'] = $productId;
        $odoo = new Odoo();
        $erp_connection_params = unserialize(Configuration::get('ERP_CONNECTION_PARAMS'));
        if(empty($erp_connection_params)){
            return;
        }

        $product_data =   $odoo->getDataFromSelfAPI($opt, $self_api_key);
        //attachments
        $opt2['resource'] = 'attachment';
        $opt2['id'] = $attachmentId;
        // print_r($opt2);
        $attachment_data =   $odoo->getDataFromSelfAPI($opt2, $self_api_key);
        /**/
        // For sending static image as cover for IQ product
        $iq_image_path = _PS_IMG_DIR_.'iq/iq_default.jpg';
        $iq_image_data = file_get_contents($iq_image_path);
        $iq_image_base64 = base64_encode($iq_image_data);

        $method_name = "ImportIQProductFromPrestashop";
        $shop_id = $this->context->shop->id;
        $table_name = 'product.product';
        try {
            $odooParams = ['product.product', 'ImportIQProductFromPrestashop', $shop_id, $product_data->asXML(),$attachment_data->asXML(), $iq_image_base64];
            $status = $odoo->sendDataToOdoo($odooParams);
        } catch (Exception $e) {
            $log_content = array("method" => "IQ product add", "message" => "Exception on Adding Product", "error_description" => $e->getMessage());
            $odoo->createErpLog($log_content);
        }
    }

    public function getDataFromSelfAPI($opt, $self_api_key) {
        $erp_connection_params = unserialize(Configuration::get('ERP_CONNECTION_PARAMS'));
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $base_debug = false;
        $base_url=str_replace('https://','http://',$base_url);
        $webService = new PrestaShopWebservice($base_url, $self_api_key, $base_debug);
        $result = $webService->get($opt);
        return $result;
    }

    /**
     * Function to establish a connection with ERP
     * @param String $user, String $password, String $dbname, String $server_url,
     * @return SimpleXmlObject
     * @author Renjith SK <renjithsk.confianzit.biz>
     */
    function erpConnection($user, $password, $dbname, $server_url) {
        $sock = new xmlrpc_client($server_url . 'xmlrpc/common');
        $msg = new xmlrpcmsg('login');
        $msg->addParam(new xmlrpcval($dbname, "string"));
        $msg->addParam(new xmlrpcval($user, "string"));
        $msg->addParam(new xmlrpcval($password, "string"));
        $resp = $sock->send($msg);
        if ($resp->errno == 0) {
            $val = $resp->value();
            $id = $val->scalarval();
            if ($id > 0) {
                return $id;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function getSelfAPIKey() {
        /*
         * Get the webservice api
         */
         $sql = 'SELECT ws_acc.key FROM ' . _DB_PREFIX_ . 'webservice_account ws_acc'
                . ' RIGHT JOIN ' . _DB_PREFIX_ . 'webservice_account_shop ws_acs ON ws_acs.id_shop = ' . (int) $this->context->shop->id . ' AND ws_acs.id_webservice_account = ws_acc.id_webservice_account'
                . ' RIGHT JOIN ' . _DB_PREFIX_ . 'webservice_permission ws_pms'
                . ' ON ws_pms.id_webservice_account = ws_acc.id_webservice_account AND ws_pms.resource IN ('
                . '\'customers\',\'orders\',\'order_details\') AND ws_pms.method = \'GET\''
                . ' WHERE ws_acc.active = 1 GROUP BY ws_acc.key';
        $self_api_key = Db::getInstance()->executeS($sql);
        $shop_id = $this->context->customer->id_shop;



        if (empty($self_api_key)) {
            return;
        }
        $self_api_key = $self_api_key[0]['key'];
        return $self_api_key;
    }
}
