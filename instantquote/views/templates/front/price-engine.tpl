<div class="iq-cart-section">
    <div class="section_mob_center" id="spansku" style="display:none">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <span class="prod_sku">
            <span>We stand behind our products and services. If you have any questions or require any information pertaining to manufacturing processes or volume discounts, we are here to help. <br>Give us a call at 877-801-7417 to speak with a representative </span><br><br>
                <span class="">SKU : </span>

                <span class="" id="spanskuValue"></span>
            </span>
            <div class="clearfix"></div>
            <span id="spanFinalPrice" style="display:none">
                {* <span class="label-price-sec">Price per unit </span> *}

                <span class="iq-price-sec">
                    <span id="display_price"></span>
                    <span id="discounted_display_price" class="hide"></span>
                </span>

            </span>
        </div>
        <span class="buttons_sec m-0">
            <!-- <input type="button" id="add_material"  value="Get Price" name="add_material"> -->
            <div id="spanstockcheck" style="font-size: 12px;font-weight: bold;height: 4px;"></div>

            <button id="addtocart" class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button"
                style="display:none">
                <i class="fto-glyph icon_btn"></i><span>Add to cart</span>
            </button><br><br>
            <p id='quantityMessage' style=''>Check out or discounts for higher volume purchases</p>
            <p id='discount5' style=''></p>
            <span>
            Note: By adding to cart and making purchase you have approved all specifications shown below and the part will be sent to production. Custom parts are not returnable. 
            </span><br>
            <input type="hidden" id="ajax" value="true" name="ajax">
            <input type="hidden" id="shapeId" value="{$shapeClassData.id_iq_shape}" name="shapeId">
            <input type="hidden" id="shapeNameHiden" value="{$shapeClassData.display_name}" name="shapeName">
            <input type="hidden" id="productWeight" value="0" name="shapeName">
            <input type="hidden" id="methode" value="price_engine" name="methode">
            <input type="hidden" id="imageFileName" value="" name="imageFileName">
            <input type="hidden" id="imageData" value="" name="imageData">

        </span>
    </div>

    <div id="extraerrors"></div>
    <div id="warnings"></div>

    <div id="extraCartBtn" hidden>
        <a id="extraCartBtnChild" class="ajax_add_to_cart_button hover_fly_btn  btn-spin " href="javascript:void(0)"
            rel="nofollow" title="Add to cart" data-id-product="0" data-id-product-attribute="0"
            data-minimal-quantity="1">
            <div class="hover_fly_btn_inner"><i class="fto-glyph icon_btn"></i><span>Add to cart</span>
            </div>
        </a>
    </div>
</div>

<canvas id="myCanvas" class="myCanvas" width="1000" height="1000" style="top:0">
    <p>canvas not supported boooo </p>
</canvas>
