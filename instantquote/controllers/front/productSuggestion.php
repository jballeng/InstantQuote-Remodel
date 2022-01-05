<?php

require _PS_MODULE_DIR_ . 'instantquote/pricecalculators/autoload.php';
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class instantquoteProductSuggestionModuleFrontController extends ModuleFrontControllerCore
{
    
    public function initContent()
    {
        parent::initContent();
        $results = [];
        $preview = "";        
        
        if ($this->ajax) { //special variable to check if the call is ajax
            $range = PS_PROD_SUGGESTION_RANGE;
            $id_shop = $this->context->shop->id;
            $id_lang = $this->context->language->id;
            $length = $_POST['length'];
            $width =  $_POST['width'];
            $height =  $_POST['height'];
            $material =  $_POST['material'];
            $length_upperbond = $length+$range;
            $length_lowerbond = (($length-$range) < 0) ? 0: ($length-$range);
            $width_upperbond = $width+$range;
            $width_lowerbond = (($width-$range) < 0) ? 0: ($width-$range);
            $height_upperbond = $height+$range;
            $height_lowerbond = (($height-$range) < 0) ? 0: ($height-$range);
            $sql = "SELECT DISTINCT p.id_product, p.material_type
            FROM " . _DB_PREFIX_ . "product p
            ".Shop::addSqlAssociation('product', 'p')."
            JOIN "._DB_PREFIX_."category_product cp ON p.id_product = cp.id_product  
            WHERE id_shop_default = {$id_shop} AND (ABS(p.height) BETWEEN {$height_lowerbond} AND {$height_upperbond} )  AND (ABS(p.width) BETWEEN {$width_lowerbond} AND {$width_upperbond} ) AND (ABS(p.depth) BETWEEN {$length_lowerbond}  AND  {$length_upperbond} ) 
            AND  p.drip_pan_without_holes = 1 AND p.available_for_order = 1  AND product_shop.active = 1 AND product_shop.visibility IN ('both', 'search') ORDER BY CASE WHEN p.material_type = '{$material}' THEN 0 ELSE 1 END ASC,
            material_type ASC";
            $items = Db::getInstance()->executeS($sql);
            if ($items) {
                $related_products_ids = array_column($items,'id_product');
                if (count($related_products_ids)) {
                    $assembler = new ProductAssembler($this->context);
                    $presenterFactory = new ProductPresenterFactory($this->context);
                    $presentationSettings = $presenterFactory->getPresentationSettings();
                    $presenter = new ProductListingPresenter(
                        new ImageRetriever(
                            $this->context->link
                        ),
                        $this->context->link,
                        new PriceFormatter(),
                        new ProductColorsRetriever(),
                        $this->context->getTranslator()
                    );

                    if (is_array($related_products_ids)) {
                        foreach ($related_products_ids as $productId) {
                            if (!$productId) {
                                continue;
                            }
                            $prod = new Product((int) $productId);
                            if (!$prod->id) {
                                continue;
                            }
                            $products[] = $presenter->present(
                                $presentationSettings,
                                $assembler->assembleProduct(array(
                                    'id_product' => $productId,
                                    'id_product_attribute' => Product::getDefaultAttribute($productId),
                                )),
                                $this->context->language
                            );
                        }
                    }
                }
                $this->context->smarty->assign('products',$products);
                $preview = $this->context->smarty->fetch('module:instantquote/views/templates/front/suggested_products.tpl');
            } 
                
            $this->ajaxDie(Tools::jsonEncode(array(         
                'preview' => $preview,
                'status' => (!empty($products) ? true : false)
            )));
        }
    }
}
