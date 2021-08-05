

<form id="material_type_form" class="std"  name="material_type_form" method="post" >
    <fieldset class="block center">
        <h3 class="title_block">
            <i class="icon-edit icon-small"></i>

            {$shapeClassData.title}

        </h3>

        <div class="step2TD2 fl">

            <div class="step2curvebox ">

                <div class="step2midcurve">

                    <table class="step2CurveTable">
                        <tbody>

                            <tr>
                                <td colspan="2">

                                </td>
                            </tr>

                            <tr>
                                <td class="holenumers text-left" colspan="2">
                                    {if !empty($shapeClassData.note)}
                                        <label>Notes:</label>
                                        <p> 
                                            {$shapeClassData.note|nl2br}

                                        </p>
                                    {/if}
                                    <br>
                                </span><span id="spanMaterialType"><label>Material Type:</label>
                                <select id="material_type_id" onchange="" name="material_type"> 
                                    <option value="">Please Select</option>
                                    {foreach from=$material_types item=type}
                                        <option value="{$type.id_iq_material_type}"
                                                {if isset($fieldDetails['material_type']) && ($fieldDetails['material_type'] == $type.id_iq_material_type)}selected="selected" {/if}
                                                >
                                            {$type.material_type_name}</option>
                                        {/foreach}
                                </select>

                                
                            </span><span id="spanMaterialSize"><label>Material Thickness:</label>
                                <select id="material_size_id" name="material_size">
                                    <option value="">Please Select</option>
                                </select>
                                
                            </span>
                            <span id="spanQuantity"><label>Quantity Needed:</label>
                                <input type="text" id="material_qty" size="12" maxlength="7" value="1" name="material_qty">
                           </span>    


                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>
                                
</div>
 <div class="span12" style="font-style: italic;text-align: left">
     
                                    <p><br/><strong>*Disclaimer :</strong> All custom pan orders require a 2-4 week lead time. Length of lead time will be determined based on order specifications and production schedule.</p>
                                </div>                               
<div class="step1Table">
    <div class="quoteshapebox">

        <div class="customAttributes showit" id="PT422">
            <div style="position: relative; margin: 0 0 20 0" id="attributes">

              
                {foreach from=$shapeInputsData item=inputshape}

                    <div class="wlbox" style="top: {$inputshape.y_position}px; left: {$inputshape.x_position}px;">
                        {$inputshape.display_name}<br>
                        <input type="text" class="AttributeInput {str_replace(",", " ",$inputshape.properties)}" id="attribute_{$inputshape.param}" size="10" maxlength="10" value="{if isset($fieldDetails[$inputshape.param])}{$fieldDetails[$inputshape.param]}{/if}" name="{$inputshape.param}">

                    </div>
                    <!--       <div class="wlbox" style="top: 430px; left: 200px;">
                               Width<br>
                               <input type="text" class="AttributeInput" id="attribute_width" size="10" maxlength="10" value="" name="W">
                           </div>
                           <div class="wlbox" style="top: 450px; left: 390px;">
                               Max Height<br>
                               <input type="text" class="AttributeInput" id="attribute_height" size="10" maxlength="10" value="" name="H">
                           </div>-->

                {/foreach}          

                <table cellspacing="1" cellpadding="1" border="0" style="border-color: #A9C6E2; border-width: 2px;
                       border-style: None; width: 100%;">
                    <tbody><tr>
                            <td style="width: 360px; height: 350px; background-image: url(../../modules/instantquote/images/productimages/{$shapeImage});
                                background-repeat: no-repeat; background-size:contain; background-position:center;" colspan="4">
                            </td>

                        </tr>

                    </tbody></table>
            </div>
        </div>


    </div>
</div>
<div class="clr"> </div>
<br/>
</fieldset> 
<div class="clr"> </div>
<div class="section_mob_center">
    <div class="final-price fl final-price-custom">
        <span id="spansku" style="display:none" class="priceStyle">
            <span class="label-price-sec">SKU </span>

            <span class="span-price-sec" id="spanskuValue"></span>
        </span>
        <div class="clearfix"></div>
        <span id="spanFinalPrice" style="display:none">
            <span class="label-price-sec">Price per unit </span>

            <span class="span-price-sec">
                <span id="display_price"></span>
                <span id="discounted_display_price" class="hide"></span>
            </span>

        </span>    
    </div>
    <span class="buttons_sec" >
        <!-- <input type="button" id="add_material"  value="Get Price" name="add_material"> -->
         <div id="spanstockcheck" style="font-size: 12px;font-weight: bold;height: 4px;"></div>    
        
        <input type="button" id="addtocart"  class="exclusive_large btn" value="Add to Cart" name="addtocart" style="display:none">
        <input type="hidden" id="ajax"  value="true" name="ajax">
        <input type="hidden" id="shapeId"  value="{$shapeClassData.id_iq_shape}" name="shapeId">
        <input type="hidden" id="shapeNameHiden"  value="{$shapeClassData.display_name}" name="shapeName">
        <input type="hidden" id="productWeight"  value="0" name="shapeName">
        <input type="hidden" id="methode"  value="price_engine" name="methode">

    </span>
</div>

<div id="extraerrors"></div>
<div id="warnings"></div>  



</form>
