<?php

require _PS_MODULE_DIR_.'instantquote/pricecalculators/autoload.php';

class instantquotePriceEngineModuleFrontController extends ModuleFrontControllerCore {

    public function initContent() {
        parent::initContent();

        $validate['status'] = "error";
        $post_methode = (Tools::getIsset('methode')) ? Tools::getValue('methode') : "";
        $jsondata = true;

        if ($this->ajax) { //special variable to check if the call is ajax
            if ($post_methode == 'price_engine') {

                $shapeId = !empty($_POST['shapeId']) ? $_POST['shapeId'] : 0;

                $sqlClass = "SELECT price_engine_path,id_iq_shape FROM " . _DB_PREFIX_ . "iq_shapes WHERE id_iq_shape = $shapeId AND is_active = 1";
                $shapeClassData = Db::getInstance()->getRow($sqlClass);
                $sqlClass2 = "SELECT id_product, procure_method FROM " . _DB_PREFIX_ . "product WHERE store_id = $storeId {$sql_single} AND id_product > 0";
                $item = Db::getInstance()->executeS($sqlClass2);
                $shapeClass = $shapeClassData['price_engine_path'];
                $item2 = $item['id_product'];
                if (!empty($shapeClass)) {
                    $post_param = $_POST;
                    $meterial_data = new KmPanCostProcessor($post_param);
                    $validate = $meterial_data->getPrice();
                    unset($validate['data']['priceWithoutMargin']);
                    // print_r($validate);
                } else {
                    $returndata['error_val'] = "Somethign went wrong";
                    $validate['data'] = $returndata;
                }
            } else if ($post_methode == 'meterial_design') {
                $validate['status'] = "ok";
                $material_type_id = (int) Tools::getValue('material_type_id');
                $shapeId = (int) Tools::getValue('shapeId');
                //    $sql = "SELECT id_iq_material_size,display_name  FROM " . _DB_PREFIX_ . "iq_material_size WHERE is_active = 1 AND material_type_id =$material_type_id ";
                if (!empty($material_type_id)) {

                    $sqlType = "SELECT thickness_order FROM " . _DB_PREFIX_ . "iq_material_type WHERE id_iq_material_type = $material_type_id";
                    $typeResult = Db::getInstance()->getRow($sqlType);

                    $orderby = ($typeResult['thickness_order'] == 'ASC' || $typeResult['thickness_order'] == 'DESC' ) ? $typeResult['thickness_order'] : 'ASC';
                    $sql = "SELECT id_iq_material_size,display_name
                        FROM " . _DB_PREFIX_ . "iq_material_size T1
                        JOIN " . _DB_PREFIX_ . "iq_material_type T2
                        ON T1.material_type_id = T2.id_iq_material_type
                        JOIN " . _DB_PREFIX_ . "iq_material_size_shape_map T3
                        ON T1.id_iq_material_size = T3.material_size_id
                        WHERE T1.is_active = 1
                        AND T3.shape_id = $shapeId
                        AND T1.material_type_id =  $material_type_id  ORDER BY material_thickness  {$orderby}";
                    $result = Db::getInstance()->executeS($sql);
                } else {
                    $result = array();
                }
                $validate['data'] = $result;
            } else if ($post_methode == 'shape_details') {
                $jsondata = false;

                $shapeId = !empty($_POST['shapeId']) ? $_POST['shapeId'] : 0;
                $shapeId = (int) $shapeId;

                $sqlClass = "SELECT price_engine_path,id_iq_shape,shape_image,title,note FROM " . _DB_PREFIX_ . "iq_shape WHERE id_iq_shape = $shapeId AND is_active = 1";
                $shapeClassData = Db::getInstance()->getRow($sqlClass);

                $shapeImage = $shapeClassData['shape_image'];

                $sqlShapeInputs = "SELECT param,id_iq_shape,x_position,y_position,display_name,properties FROM " . _DB_PREFIX_ . "iq_shape_input WHERE id_iq_shape = $shapeId AND is_active=1 ORDER BY input_order ASC;";
                $shapeInputsData = Db::getInstance()->executeS($sqlShapeInputs);


                // $sql = "SELECT material_type_name,id_iq_material_type,price_per_volume  FROM " . _DB_PREFIX_ . "iq_material_type WHERE is_active = 1";
                //   $material_types_list = Db::getInstance()->executeS($sql);


                $sql = "SELECT material_type_name,id_iq_material_type,price_per_volume
                        FROM " . _DB_PREFIX_ . "iq_material_type T1
                        JOIN " . _DB_PREFIX_ . "iq_material_size T2
                        ON T1.id_iq_material_type = T2.material_type_id
                        JOIN " . _DB_PREFIX_ . "iq_material_size_shape_map T3
                        ON T2.id_iq_material_size = T3.material_size_id
                        WHERE T1.is_active = 1 AND T3.shape_id = $shapeId AND T2.is_active = 1 GROUP BY id_iq_material_type  ORDER BY material_type_name ";
                $material_types_list = Db::getInstance()->executeS($sql);



                $this->context->smarty->assign('item', $item);
                $this->context->smarty->assign('item2', $item2);
                $this->context->smarty->assign('shapeImage', $shapeImage);
                $this->context->smarty->assign('shapeClassData', $shapeClassData);
                $this->context->smarty->assign(array('material_types' => $material_types_list, 'shapeInputsData' => $shapeInputsData));
                //$this->setTemplate('instantquote.tpl');
                $this->smartyOutputContent($this->getTemplatePath() . 'jake.tpl');
            } else if ($post_methode == 'productSku') {
                $jsondata = false;

                $productSku = !empty($_POST['productSku']) ? $_POST['productSku'] : "";


                /* $shapeId = (int) $shapeId;

                  $sqlClass = "SELECT price_engine_path,id_iq_shape,shape_image,title,note FROM " . _DB_PREFIX_ . "iq_shape WHERE id_iq_shape = $shapeId AND is_active = 1";
                  $shapeClassData = Db::getInstance()->getRow($sqlClass);

                  $shapeImage = $shapeClassData['shape_image'];

                  $sqlShapeInputs = "SELECT param,id_iq_shape,x_position,y_position,display_name FROM " . _DB_PREFIX_ . "iq_shape_input WHERE id_iq_shape = $shapeId AND is_active=1 ORDER BY input_order ASC;";
                  $shapeInputsData = Db::getInstance()->executeS($sqlShapeInputs);


                  // $sql = "SELECT material_type_name,id_iq_material_type,price_per_volume  FROM " . _DB_PREFIX_ . "iq_material_type WHERE is_active = 1";
                  //   $material_types_list = Db::getInstance()->executeS($sql);


                  $sql = "SELECT material_type_name,id_iq_material_type,price_per_volume
                  FROM " . _DB_PREFIX_ . "iq_material_type T1
                  JOIN " . _DB_PREFIX_ . "iq_material_size T2
                  ON T1.id_iq_material_type = T2.material_type_id
                  JOIN " . _DB_PREFIX_ . "iq_material_size_shape_map T3
                  ON T2.id_iq_material_size = T3.material_size_id
                  WHERE T1.is_active = 1 AND T3.shape_id = $shapeId AND T2.is_active = 1 GROUP BY id_iq_material_type  ORDER BY material_type_name ";
                  $material_types_list = Db::getInstance()->executeS($sql);




                  $this->context->smarty->assign('shapeImage', $shapeImage);
                  $this->context->smarty->assign('shapeClassData', $shapeClassData);
                  $this->context->smarty->assign(array('material_types' => $material_types_list, 'shapeInputsData' => $shapeInputsData));
                  //$this->setTemplate('instantquote.tpl');
                  $this->smartyOutputContent($this->getTemplatePath() . 'single_shape.tpl'); */
            } else {
                die("No Access");
            }
        } else {
            die("No Access");
        }
        if ($jsondata)
            echo json_encode($validate);


        die();
    }

    //
    /*
     * function : validation function
     * shabeeb
     *
     *       */
    function is_empty($value, $fieldname = "This", $message = "") {

        if (!empty($value)) {
            return "";
        }
        if (empty($message))
            return $fieldname . " field is required";
        else
            return $message;
    }

}
