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

namespace Srp\CostCalculation;

class KmPanCostProcessor2 {
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
     * Hight of the Material
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

     * constructor will accept the parameter  and set all private variables
     * 
     * 
     * @access public
     * @param  : 
     * @returntype array   
     * @return will set the parameter
     */

    public function __construct($params = array()) {

        $this->L = isset($params['L']) ? $params['L'] : "";
        $this->W = isset($params['W']) ? $params['W'] : "";
        $this->H = isset($params['H']) ? $params['H'] : "";

        $this->materialType = isset($params['material_type']) ? $params['material_type'] : ""; //$params['material_type']; //$material_type;
        $this->materialSize = isset($params['material_size']) ? $params['material_size'] : ""; //$params['material_size']; //$material_size;
        $this->materialQty = isset($params['material_qty']) ? $params['material_qty'] : ""; //$params['material_qty']; //$material_qty;
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
            
            $totalCost = $totalCost +100;
            $result['data']['price'] = $totalCost;
            $result['data']['sku'] = $this->getSku();
        } else {

            $result['fieldErrors'] = $this->validatErrors;
        }

        if ($this->_exceptionsErrors) {
            $this->validatStatus = true;
            $result['errors'][] = "Something went wrong";
        }


        $result['isError'] = $this->validatStatus;
        $result['warnings'] = $this->validatWarnings;
        return $result;
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
        $sku = $this->_skuPrefix . $this->_skuSep . $this->L . $this->_skuSep . $this->W . $this->_skuSep . $this->H . $this->_skuSep . $measurement. $this->_skuSep ."Test";

        
        return $sku;
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

        $this->isEmpty($this->materialTypeField, $this->materialType);
        $this->isEmpty($this->materialSizeField, $this->materialSize);
        $this->isEmpty($this->materialQtyField, $this->materialQty);


        if (empty($this->validatErrors)) {

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
            $this->validatWarnings[] = "Pans less than 2.5 inches high cannot have drain holes in the side with bulkhead fittings. Bulkhead fittings must be attached to holes in the bottom of the pan.";
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
        if (( $this->materialQty > 10)) {
            $this->validatErrors[$this->materialQtyField] = "Instant pricing is not available for volume orders. A Killarney Metals representative will quote your requirement and contact you shortly.";
        }
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

        if (empty($constants)) {
            $sql = "SELECT  constant_name,constant_value FROM  " . _DB_PREFIX_ . "iq_shape_constant WHERE id_iq_shape = " . $this->shapeId . " AND is_active = 1 ";
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

        if (empty($materialSize)) {
            $sql = "SELECT  max_width,max_length,material_price,material_measurement FROM  " . _DB_PREFIX_ . "iq_material_size WHERE id_iq_material_size = " . $this->materialSize . " AND is_active = 1 ";
            $materialData = \Db::getInstance()->getRow($sql);


            $materialSize['max_width'] = $materialData['max_width'];
            $materialSize['max_length'] = $materialData['max_length'];
            $materialSize['price'] = $materialData['material_price'];
            $materialSize['measurement'] = $materialData['material_measurement'];
        }
        return $materialSize;
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
        $labourCost = $this->getLabourCost();
        $setUpCost = $this->getSetUpCost();

        //adding all cost together.
        $totalMaterial = $materialCost + $labourCost + $setUpCost;

        $marginCost = $this->getMargin();
        if (!empty($marginCost)) {
            $total = ($totalMaterial / (1 - $marginCost));
            $total = number_format($total, 2);
            return $total;
        }
        return false;
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

    private function getMaterialCost() {


        $M = $this->getSingleMaterialPrice();
        $surfaceArea = (($this->L + (2 * $this->H ) + 2) * ($this->W + (2 * $this->H) + 2));
        $materialCost = $surfaceArea * $M;

        return $materialCost;
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



        $sql = "SELECT  margin FROM  " . _DB_PREFIX_ . "iq_shape WHERE id_iq_shape = " . $this->shapeId . " AND is_active = 1 ";
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

}
