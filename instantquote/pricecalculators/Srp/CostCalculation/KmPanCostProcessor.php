<?php

/**
 * KmPanCostProcessor is defined to validate and give back the custom price for a material shped in Pan
 *
 * @category    prestashop
 * @author      Shabeeb <faiz@confianzit.biz>
 * @package     instantQuote
 * @version     Release:1.0 V
 *
 *
 */

//namespace Srp\CostCalculation;

class KmPanCostProcessor {
    /*
     * Shape id of material
     * @param type : int
     *      */

    private $shapeId = 1;

    /*
     * Length of the Material
     * @param type : float
     *      */
    private $L;
    /*
     * width of the Material
     * @param type : float
     *      */
    private $W;
    /*
     * Height of the Material
     * @param type : float
     *      */
    private $H;
    /*
     * Material Type
     *
     *      */
    private $M;

    /*
     * field name for Legth parameter
     *
     * */
    private $lengthField = "L";
    /*
     * field name for width parameter
     *
     * */
    private $widthField = "W";
    /*
     * field name for Height parameter
     *
     * */
    private $heigthField = "H";
    /*
     * Type of the Material
     * @param type : int ->id of material type
     *
     * */
    private $materialType;

    /*
     * field name for Type of the Material parameter
     *
     * */
    private $materialTypeField = "material_type";
    /*
     * Size of the Material
     * @param type : int ->id of material size
     */
    private $materialSize;
    /*
     * field name for size of the Material parameter
     *
     * */
    private $materialSizeField = "material_size";
    /*
     * Qty of the Material
     * @param type : int
     */
    private $materialQty;

    /*
     * field name for Qty of the Material parameter
     *
     * */
    private $materialQtyField = "material_qty";

    /*
     * Array to store all validation errors
     * @param type : array
     *
     * */
    private $validatErrors = array();

    /*
     * validation status
     * @param type : bool
     *
     * */
    private $validatStatus = true;

    /*
     * Array to store all validation errors
     * @param type : array
     *
     * */
    private $validatWarnings = array();


    /*
     * Maximum Height of material
     * @param type : Int
     *
     * */
    private $maximumHeight = 8;

    /*
     * Minimum Height of material
     * @param type : float
     *
     * */
    private $minimumHeight = 0.25;

    /*
     * Minimum qty of material to show warning
     * @param type : int
     *
     * */
    private $maxQty = 10;

    /*
     * maximum price to show eligblity for bulk order reduction
     * @param type : int
     *
     * */
    private $maxCutoffPrice = 1000;

    /*
     * Check for exception error
     * @param type : bool
     *
     * */
    private $_exceptionsErrors = false;

    /*
     * set this array when exception occuers
     * @param type : bool
     *
     * */
    private $_exceptionReason = array();

    /*
     * prefix for SKU
     * @param type : string
     *
     * */
    private $_skuPrefix = "KM";

    /*
     * sepration for SKU
     * @param type : string
     *
     * */
    private $_skuSep = "-";

    /*
     * additional cost
     * @param type : int
     *
     * */
    private $_aditionalCost = 30;

     /*
     * max length to set additional cost
     * @param type : int
     *
     * */
    private $_maxLength = 60;

    /*
     * swap field
     * @param type : array
     *
     * */
    private $_swapFields = array();


    /*

     * constructor will accept the parameter  and set all private variables
     *
     *
     * @access public
     * @param  :
     * @returntype array
     * @return will set the parameter
     */

    public function __construct($params = array()) {

        if (isset($params['sku'])) {

            $this->setSkuValues($params['sku'], $params['qty']);
        } else {


            $this->L = isset($params['L']) ? trim($params['L']) : "";
            $this->W = isset($params['W']) ? trim($params['W']) : "";
            $this->H = isset($params['H']) ? trim($params['H']) : "";

            $this->materialType = isset($params['material_type']) ? trim($params['material_type']) : ""; //$params['material_type']; //$material_type;
            $this->materialSize = isset($params['material_size']) ? trim($params['material_size']) : ""; //$params['material_size']; //$material_size;
            $this->materialQty = isset($params['material_qty']) ? trim($params['material_qty']) : ""; //$params['material_qty']; //$material_qty;

            if ($this->W > $this->L) {
                $this->validatWarnings[] = "Length and Width have been switched. For simplicity all Killarney Pans are considered longer than they are wide.";

                // swapping the fields

                $width = $this->W;
                $length = $this->L;

                $this->W = $length;
                $this->L = $width;


                $this->_swapFields[$this->widthField] = $this->lengthField;
                // $this->_swapFields[$this->heigthField] = $this->lengthField;
            }
        }


    }

    /*

     * Methode to get price
     *
     *
     * @access public
     * @param  :
     * @returntype array
     * @return validation error or price details
     */

    public function getPrice() {


        if ($this->validate()) {
            $this->validatStatus = false;
            $totalCost = $this->getTotalCost();
            $totalCostOriginal = $this->getTotalCostWithoutMargin();

            $result['data']['sku'] = $this->getSku();
            $skuPrice = $this->getProductPriceBySKU($result['data']['sku']);
            $stockMethod = $this->getProductStock($result['data']['sku']);
            // echo $stockMethode;
            //  print_r($stockMethod);
            $costReturn = (!$skuPrice) ? $totalCost : $skuPrice;
            //$result['data']['price'] =  \Tools::ps_round($costReturn, 2);
            $result['data']['price'] = number_format($costReturn, 2);
            $result['data']['orig_price'] = (float) round($costReturn, 2);
            $result['data']['stock'] = ((isset($stockMethod['methode']) && $stockMethod['methode'] == 'IN_STOCK') && (isset($stockMethod['quantity']) && $stockMethod['quantity'] > 0 )) ? "In Stock" : "";
            $result['data']['weight'] = (float) $this->getWeight();
            $result['data']['priceWithoutMargin'] = (float) $totalCostOriginal;
            $totalPrice = $result['data']['price'] * $this->materialQty;

            //Get dealer/distributor discount from group
            $id_group = (int) \Group::getCurrent()->id;
            $discountedPrice = $result['data']['orig_price'] * ((100 - \Group::getReductionByIdGroup($id_group)) / 100);
            if ($discountedPrice < $result['data']['orig_price']) {
                $result['data']['discounted_price'] = number_format($discountedPrice, 2);
            }

            if ( $totalPrice > $this->maxCutoffPrice) {
                //$this->validatErrors[$this->materialQtyField] = "Instant pricing is not available for volume orders. A Killarney Metals representative will quote your requirement and contact you shortly.";
                $this->validatWarnings[] = "You are eligible for volume discounts. Please contact us";
            }
        } else {

            $result['fieldErrors'] = $this->validatErrors;
        }

        if ($this->_exceptionsErrors) {
            $this->validatStatus = true;
            $result['errors'][] = "Something went wrong";
        }


        $result['isError'] = $this->validatStatus;
        $result['warnings'] = $this->validatWarnings;
        $result['commends'][]['swap']['arg'] = $this->_swapFields;
        return $result;
    }

    /*

     * Methode to get weight
     *
     *
     * @access public
     * @param  :
     * @returntype array
     * @return validation error or price details
     */

    public function getWeight() {


        $thickness = $maxWidth = $this->getMaterialAttribute('thickness');
        $density = $this->getDensity();
        $packingMaterial = $this->getPackingData(); // + 2*(Width*(Height+0.5)
        $weight = (($this->L * $this->W) + 2 * ($this->L * ($this->H + 0.5)) + 2 * ($this->W * ($this->H + 0.5)) ) * $thickness * $density + $packingMaterial;

        //  $weight = 25;
        return $weight;
    }

    /*

     * Methode to get price
     *
     *
     * @access public
     * @param  :
     * @returntype array
     * @return sku of product
     */

    public function getSku() {


        //  KM-36-36-4-18G
        $measurement = $this->getMaterialAttribute('measurement');
        $sku = $this->_skuPrefix . $this->_skuSep . $this->L . $this->_skuSep . $this->W . $this->_skuSep . $this->H . $this->_skuSep . $measurement;


        return $sku;
    }

    /*

     * Methode to get all field values
     *
     *
     * @access public
     * @param  :
     * @returntype array
     * @return
     */

    public function getFieldValues() {
        $fieldsData = array();

        //if ($this->validate()) {



        $fieldsData[$this->lengthField] = trim($this->L);
        $fieldsData[$this->widthField] = trim($this->W);
        $fieldsData[$this->heigthField] = trim($this->H);
        $fieldsData[$this->materialTypeField] = trim($this->materialType);
        $fieldsData[$this->materialSizeField] = trim($this->materialSize);
        $fieldsData[$this->materialQtyField] = trim($this->materialQty);
        $result['data']['fields'] = $fieldsData;

        $this->validatStatus = false;
        /* $totalCost = $this->getTotalCost();
          $result['data']['price'] = (float) $totalCost;
          $result['data']['weight'] = (float) $this->getWeight();
          $result['data']['sku'] = $this->getSku(); */

        // } else {
        //   $result['fieldErrors'] = $this->validatErrors;
        // }

        if ($this->_exceptionsErrors) {
            $this->validatStatus = true;
            $result['errors'][] = "Something went wrong";
        }


        $result['isError'] = $this->validatStatus;
        $result['warnings'] = $this->validatWarnings;
        $result['commends'][]['swap']['arg'] = $this->_swapFields;
        return $result;
    }

    /*

     * Methode to validate all fields and conditions
     *
     *
     * @access private
     * @param  : null
     * @return bool
     */

    private function validate() {

        $this->isEmpty($this->lengthField, $this->L);
        $this->isEmpty($this->widthField, $this->W);
        $this->isEmpty($this->heigthField, $this->H);

        $this->isNumeric($this->lengthField, $this->L);
        $this->isNumeric($this->widthField, $this->W);
        $this->isNumeric($this->heigthField, $this->H);

        $this->isEmpty($this->materialTypeField, $this->materialType);
        $this->isEmpty($this->materialSizeField, $this->materialSize);
        $this->isEmpty($this->materialQtyField, $this->materialQty);


        if (empty($this->validatErrors)) {


            $this->L = (float) $this->L;
            $this->W = (float) $this->W;
            $this->H = (float) $this->H;


            $this->validateWidth();
            $this->validateHeight();
            $this->validateLength();
            $this->validateQuantity();

            if (empty($this->validatErrors)) {
                return true;
            }
        }

        return false;
    }

    /*
     * Validation methode to check if the field is filled or not
     *
     *
     * @access private
     * @param  : $input_name = name of the fields
     * @param  : $value = value of teh field to check
     * @param  : $fieldname = field name to mention on validation error message
     * @param  : $message = custom validation error message
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function isEmpty($input_name, $value, $fieldname = "This", $message = "") {
        if (empty($value)) {
            if (empty($message))
                $this->validatErrors[$input_name] = $fieldname . " field is required";
            else
                $this->validatErrors[$input_name] = $message;
        }
    }

    /*
     * Validation methode to check if the field contain number only  or not
     *
     *
     * @access private
     * @param  : $input_name = name of the fields
     * @param  : $value = value of teh field to check
     * @param  : $fieldname = field name to mention on validation error message
     * @param  : $message = custom validation error message
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function isNumeric($input_name, $value, $fieldname = "This", $message = "") {
        if (!is_numeric($value)) {
            if (empty($message))
                $this->validatErrors[$input_name] = $fieldname . " field should contain numbers only";
            else
                $this->validatErrors[$input_name] = $message;
        }
    }

    /*
     * Validation methode to check the width calulation of field
     *
     *
     * @access private
     * @param  :
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function validateWidth() {

        $maxWidth = $this->getMaterialAttribute('max_width');

        $sizeLimit = ($this->W + (2 * ($this->H)) + 1);
        if ($sizeLimit > $maxWidth) {
            $this->validatErrors[$this->widthField] = "Pan exceeds maximum width for this material.";
        }

        return false;
    }

    /*
     * Validation methode to check the height calulation of field
     *
     *
     * @access private
     * @param  :
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function validateHeight() {

        //cheking the extra constions
        if (($this->H > $this->maximumHeight)) {
            $this->validatErrors[$this->heigthField] = "Pan exceeds maximum height";
        } elseif ($this->H < $this->minimumHeight) {
            $this->validatErrors[$this->heigthField] = "Pan does not meet minimum height";
        }

        //setting warnings

        if ($this->H <= 0.5) {
            $this->validatWarnings[] = "Pans 0.5 inches tall and below cannot receive hemmed edges. Edges may be sharp.";
        } elseif ($this->H <= 2.5) {
            // $this->validatWarnings[] = "Pans less than 2.5 inches high cannot have drain holes in the side with bulkhead fittings. Bulkhead fittings must be attached to holes in the bottom of the pan.";
        }



        return false;
    }

    /*
     * Validation methode to check the Length calulation of field
     *
     *
     * @access private
     * @param  :
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function validateLength() {


        $maxLength = $this->getMaterialAttribute('max_length');
        $lenghtLimit = ($this->L + (2 * ($this->H)) + 1);

        if (($lenghtLimit > $maxLength)) {
            $this->validatErrors[$this->lengthField] = "Pan exceeds maximum length for this material.";
        }



        return false;
    }

    /*
     * Validation methode to check the qty of material needed
     *
     *
     * @access private
     * @param  :
     * @returntype
     * @return  :  set the validation error corresponding to the field
     */

    private function validateQuantity() {

        if (!is_numeric($this->materialQty)) {
            $this->validatErrors[$this->materialQtyField] = "Quantity Needed field should be number";
        }
//        if (( $this->materialQty > 10)) {
//            //$this->validatErrors[$this->materialQtyField] = "Instant pricing is not available for volume orders. A Killarney Metals representative will quote your requirement and contact you shortly.";
//            $this->validatWarnings[] = "Instant pricing is not available for volume orders. A Killarney Metals representative will quote your requirement and contact you shortly.";
//        }
        return false;
    }

    /*

     * Methode to set all material constant such as  setup cost,welding cost, labour cost
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return set all constants
     */

    private function getAllConstants() {
        static $constants = array();
        //$constants = array();
        if (empty($constants)) {
            $sql = "SELECT  constant_name,constant_value FROM  " . _DB_PREFIX_ . "iq_shapes_constants WHERE id_iq_shape = " . $this->shapeId . " AND is_active = 1 ";
            $constantData = \Db::getInstance()->executeS($sql);

            foreach ($constantData as $constant) {
                $constants[$constant['constant_name']] = $constant['constant_value'];
            }
        }
        return $constants;
    }

    /*

     * Methode to get  material constant such as  setup cost,welding cost, labour cost
     *
     *
     * @access private
     * @param  : $key - name of the constant
     * @returntype number
     * @return value of the constant
     */

    private function getConstant($key) {
        $constants = $this->getAllConstants();
        if (isset($constants[$key])) {
            return $constants[$key];
        } else {
            $this->setInternalError($key . " value is not set");
            return false;
        }
    }

    /*

     * Methode to get  material constant such as  max width , Max length, and price
     *
     *
     * @access private
     * @param  :
     * @returntype array
     * @return set all constants
     */

    private function getMaterialData() {
        static $materialSize = array();
        // $materialSize = array();
        if (empty($materialSize[$this->materialSize])) {
            $sql = "SELECT  max_width,max_length,material_price,material_measurement,material_thickness FROM  " . _DB_PREFIX_ . "iq_material_size WHERE id_iq_material_size = " . $this->materialSize . " AND is_active = 1 ";
            $materialData = \Db::getInstance()->getRow($sql);

            $materialData[$this->materialSize] = array();
            $materialSize[$this->materialSize]['max_width'] = $materialData['max_width'];
            $materialSize[$this->materialSize]['max_length'] = $materialData['max_length'];
            $materialSize[$this->materialSize]['price'] = $materialData['material_price'];
            $materialSize[$this->materialSize]['measurement'] = $materialData['material_measurement'];
            $materialSize[$this->materialSize]['thickness'] = $materialData['material_thickness'];
        }
        return $materialSize[$this->materialSize];
    }

    /*

     * Methode to get  material attribute from  constants such as  setup cost,welding cost, labour cost
     *
     *
     * @access private
     * @param  : $key - name of the constant
     * @returntype number
     * @return value of the constant
     */

    private function getMaterialAttribute($key) {
        $materialSize = $this->getMaterialData();
        if (isset($materialSize[$key])) {
            return $materialSize[$key];
        } else {
            $this->setInternalError($key . " value is not set");
            return false;
        }
    }

    /*

     * Methode to get total cost for the material including setup cost. Labour cost, Material Cost
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return validation error or price details
     */

    private function getTotalCost() {


        $materialCost = $this->getMaterialCost();
        $manufacturingCost = $this->getManufacturingCost();
        $labourCost = $this->getLabourCost();
        $setUpCost = $this->getSetUpCost();
        $aditionalCost = ($this->L >= $this->_maxLength) ? $this->_aditionalCost : 0;


        //adding all cost together.
        $totalMaterial = $materialCost + $manufacturingCost;
/*
        $marginCost = $this->getMargin();
        if (!empty($marginCost)) {
            $total = ($totalMaterial / (1 - $marginCost));
            // $total = \Tools::ps_round($total, 2);
            //$total = number_format($total, 2);
            return $total;
        }
        return false;
        */
        $total = $totalMaterial;
        return $total;
    }

    /*

     * Methode to get total cost for the material including setup cost. Labour cost, Material Cost
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return validation error or price details
     */

    private function getTotalCostWithoutMargin() {


        $materialCost = $this->getMaterialCost();
        $labourCost = $this->getLabourCost();
        $setUpCost = $this->getSetUpCost();

           $aditionalCost = ($this->L >= $this->_maxLength) ? $this->_aditionalCost : 0;
        //adding all cost together.
        $totalMaterial = $materialCost + $labourCost + $setUpCost + $aditionalCost;


        $total = \Tools::ps_round($totalMaterial, 2);
        return $total;
    }

    /*

     * Methode to get Material cost for the material
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return material cost
     */

     /*
     * Material cost function has been updated due to a change in our pricing formula
     * notes below detail the changes and what the significant values are
     * minor changes to database and back office will be required
     */
    private function getMaterialCost() {
        $quan = $this->materialQty;
        $thick = $this->getMaterialAttribute('thickness');
        /*
        * cru is the industry standard material cost for various metals
        * it is a per ton dollar amount divided by 2000 to get the per pound cost
        * going forward this value will need to be added to the back office as it changes monthly
        * it may be easier to add it to the material type table since the gauge does not alter its price
        */
        $cru = $this->getSingleMaterialPrice();
        /*
        * bl and bw refer to blank length and blank width
        * with the new pricing structure these values are used to calculate the sheet used
        * the cost of the sheet is the new material cost
        */
        $bl = (2 * $this->H + $this->L + 1) + 1;
        $bw = (2 * $this->H + $this->W + 1) + 1;
        //stainless steel has different sheet sizes compared to other materials
        if($this->materialType == 1){
          if($bl <= 36 && $bw <= 30){
            $sheet_cost = 36 * 30 * $thick * 0.284;
          }
          elseif($bl <= 40 && $bw <= 36){
            $sheet_cost = 40 * 36 * $thick * 0.284;
          }
          elseif($bl <= 48 && $bw <= 48){
            $sheet_cost = 48 * 48 * $thick * 0.284;
          }
        elseif($bl <= 60 && $bw <= 36){
          $sheet_cost = 60 * 36 * $thick * 0.284;
        }
        elseif($bl <= 120 && $bw <= 36){
          $sheet_cost = 120 * 36 * $thick * 0.284;
        }
      }else{
        if($bl <= 24 && $bw <= 24){
          $sheet_cost = 24 * 24 * $thick * 0.284;
        }
        elseif($bl <=48 && $bw <= 24){
          $sheet_cost = 48 * 24 * $thick * 0.284;
        }
        elseif($bl <=48 && $bw <= 48){
          $sheet_cost = 48 * 48 * $thick * 0.284;
        }
        elseif($bl <= 120 && $bw <= 48){
          $sheet_cost = 120 * 48 * $thick * 0.284;
        }
        elseif($bl <= 120 && $bw <= 60){
          $sheet_cost = 120 * 60 + $thick * 0.284;
        }
      }
      // updated formula to handle the cost of material
        $materialCost = $sheet_cost * (($cru/2000) * 1.25) * 1.3;
        $totalMaterialCost = $materialCost * $quan;

        return $totalMaterialCost;
    }

    /*
    * New function to get the price of manufacting Pans
    * in the new pricing structure manufacturing cost is a fixed set of prices
    * these are based off the overall size of the pan as well as quantity
    * I am only using blank length for the size assuming it will accept
    * the correct value if length and width are switched
    * if not this can be easily adjusted
    */

    private function getManufacturingCost(){
      $bl = (2 * $this->H + $this->L + 1) + 1;
      $quantity = $this->materialQty;
      if($bl <= 48){
        if($quantity == 1){
          $cost = 148.68;
        }
        elseif($quantity > 1 && $quantity < 5){
          $cost = 86.28;
        }
        elseif($quantity < 10){
          $cost = 48.85;
        }
        elseif($quantity < 25){
          $cost = 36.37;
        }
        elseif($quantity < 50){
          $cost = 28.88;
        }
        elseif($quantity < 75){
          $cost = 25.74;
        }
        elseif($quantity < 100){
          $cost = 24.93;
        }
        elseif($quantity >= 100){
          $cost = 24.12;
        }
      }else{
        if($quantity == 1){
          $cost = 164.43;
        }
        elseif($quantity > 1 && $quantity < 5){
          $cost = 102.03;
        }
        elseif($quantity < 10){
          $cost = 64.60;
        }
        elseif($quantity < 25){
          $cost = 52.12;
        }
        elseif($quantity < 50){
          $cost = 44.63;
        }
        elseif($quantity < 75){
          $cost = 41.25;
        }
        elseif($quantity < 100){
          $cost = 40.45;
        }
        elseif($quantity >= 100){
          $cost = 39.48;
        }
      }
      $total_cost = $cost * $quantity;
      return $total_cost;
    }


    /*

     * Methode to get the [margin]rpduct  cost of a material by sku.
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return material margin value
     */

    private function getProductPriceBySKU($sku = "") {

        if (!empty($sku)) {
            $sql = "SELECT id_product,price FROM " . _DB_PREFIX_ . "product WHERE reference = '$sku' and is_iq_genarated = 0 ";
            $productData = \Db::getInstance()->getRow($sql);
            // print_r($productData);
            if (!empty($productData['id_product'])) {
                $productCost = $productData['price'];

                return $productCost;
            }
        }
        return false;
    }

    /*

     * Methode tocheck the product is instock or made to order or out of stock
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return material margin value
     */

    private function getProductStock($sku = "") {
        $procure_method = array();
        if (!empty($sku)) {
            $sql = "SELECT p.id_product,procure_method,s.quantity  FROM " . _DB_PREFIX_ . "product p LEFT JOIN " . _DB_PREFIX_ . "stock_available s  ON p.id_product = s.id_product  WHERE reference = '$sku' ";
            $productData = \Db::getInstance()->getRow($sql);

            if (!empty($productData['procure_method'])) {
                $procure_method['methode'] = $productData['procure_method'];
                $procure_method['quantity'] = $productData['quantity'];

                return $procure_method;
            }
        }
        return $procure_method;
    }

    /*

     * Methode to get Material cost for a volum area
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return material cost  for a volum area
     */

    private function getSingleMaterialPrice() {
        $materialPrice = $this->getMaterialAttribute('price');
        return $materialPrice;
    }

    /*

     * Methode to get Labour cost for the material
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return Labour cost
     */

    private function getLabourCost() {
        $laboutConst = $this->getConstant('KM_PAN_LABOUR_CONST');
        $weldConst = $this->getConstant('KM_PAN_WELD_CONST');

        $labourCost = $laboutConst + ($weldConst * $this->H);
        return $labourCost;
    }

    /*

     * Methode to get Setup cost for the material
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return Setup cost
     */

    private function getSetUpCost() {

        $setupConstant = $this->getConstant('KM_PAN_SETUP_CONST');
        $setupcost = $setupConstant / $this->materialQty;
        return $setupcost;
    }

    /*

     * Methode to get the margin cost of a material.
     *
     *
     * @access private
     * @param  :
     * @returntype number
     * @return material margin value
     */

    private function getMargin() {



        $sql = "SELECT  margin FROM  " . _DB_PREFIX_ . "iq_shapes WHERE id_iq_shape = " . $this->shapeId . " AND is_active = 1 ";
        $marginData = \Db::getInstance()->getRow($sql);

        if (!empty($marginData['margin'])) {
            $margin = $marginData['margin'];
            if ($margin <= 0 || $margin >= 1) {
                $this->setInternalError("margin value should be between 0 and 1");
            }
            return $margin;
        } else {
            $this->setInternalError(" margin shape value is not set");
        }
        return false;
    }

    /*

     * Methode to set internal error if happends
     *
     *
     * @access private
     * @param  : $reason -  reason for the error happend
     * @param  : $key -  key for the error reason
     * @returntype bool
     */

    private function setInternalError($reason, $key = "") {

        $this->_exceptionsErrors = true;
        empty($key) ? $this->_exceptionReason[] = $reason : $this->_exceptionReason[$key] = $reason;

        return true;
    }

    /*

     * Methode to get internal error if happends
     *
     *
     * @access public
     * @param  : $key -  key for the error reason
     * @returntype array
     * @return array of all internal errors or internal error with key
     */

    public function getInternalError($key = "") {

        $this->_exceptionsErrors = true;
        $result = empty($key) ? $this->_exceptionReason : $this->_exceptionReason[$key];

        return $result;
    }

    /*

     * Methode to extract value from sku
     *
     *
     * @access private
     * @param  : $sku -  sku number for a product
     * @returntype array
     */

    private function extractSKU($sku) {

        if (!empty($sku)) {
            //$sku = $this->_skuPrefix . $this->_skuSep . $this->L . $this->_skuSep . $this->W . $this->_skuSep . $this->H . $this->_skuSep . $measurement;
            return $skuArray = explode($this->_skuSep, $sku);
        }

        return false;
    }

    /*

     * Methode to extract value from sku
     *
     *
     * @access private
     * @param  : $sku -  sku number for a product
     * @returntype array
     */

    private function setSkuValues($sku, $qty) {

        if (!empty($sku)) {
            $skuArray = $this->extractSKU($sku);
            // print_r($skuArray);
            $this->L = isset($skuArray[1]) ? trim($skuArray[1]) : "";
            $this->W = isset($skuArray[2]) ? trim($skuArray[2]) : "";
            $this->H = isset($skuArray[3]) ? trim($skuArray[3]) : "";

            if(isset($skuArray[4]))
            {
                $materialIDList = $this->getMaterialIds(trim($skuArray[4]));

                $this->materialType = $materialIDList['material_type_id'] ? trim($materialIDList['material_type_id']) : ""; //$params['material_type']; //$material_type;
                $this->materialSize = $materialIDList['id_iq_material_size'] ? trim($materialIDList['id_iq_material_size']) : ""; //$params['material_type']; //$material_type;
            }
            $this->materialQty = $qty; //$params['material_qty']; //$material_qty;
        }

        return false;
    }

    /*

     * Methode to get  material data such as  material_type_id , id_iq_material_size, and price
     *
     *
     * @access private
     * @param  :
     * @returntype array
     * @return set all constants
     */

    private function getMaterialIds($measurement) {
        static $materialIDList = array();
        //$materialIDList = array();
        if (empty($materialIDList[$measurement])) {
            $sql = "SELECT  material_type_id,id_iq_material_size FROM  " . _DB_PREFIX_ . "iq_material_size WHERE material_measurement = '" . $measurement . "' AND is_active = 1 ";
            $materialData = \Db::getInstance()->getRow($sql);
            $materialIDList[$measurement] = array();

            $materialIDList[$measurement]['material_type_id'] = $materialData['material_type_id'];
            $materialIDList[$measurement]['id_iq_material_size'] = $materialData['id_iq_material_size'];
        }
        return $materialIDList[$measurement];
    }

    /*

     * Methode to get   packing_material value
     *
     *
     * @access private
     * @param  :
     * @returntype int
     * @return set all constants
     */

    private function getPackingData() {

        $sql = "SELECT  packing_material FROM  " . _DB_PREFIX_ . "iq_shapes WHERE id_iq_shape = " . $this->shapeId . " AND is_active = 1 ";
        $materialData = \Db::getInstance()->getRow($sql);
        $packing_material = $materialData['packing_material'];
        return $packing_material;
    }

    /*

     * Methode to get   packing_material value
     *
     *
     * @access private
     * @param  :
     * @returntype int
     * @return set all constants
     */

    private function getDensity() {

        $sql = "SELECT  density FROM  " . _DB_PREFIX_ . "iq_material_type WHERE id_iq_material_type = " . $this->materialType . " AND is_active = 1 ";
        $materialData = \Db::getInstance()->getRow($sql);
        $density = (float) $materialData['density'];
        return $density;
    }

}
