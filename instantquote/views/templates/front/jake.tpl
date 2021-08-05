<!--<script src = "./js/front.js"></script>-->




  				<h1>Get an Instant Quote</h1>
<div class="left-column">

        <form class="std" method="post" id="material_type_form" name="material_type_form"><br>
	<button class="btn" type="button" onclick="finalCost()">Get Instant Quote</button><br>

          <label>{l s='Material Type:'}</label><br>
  				<select name="material_type" id="material_type_id" required>
  					<option value="">Please Select</option>
            {foreach from=$material_types item=type}
              <option value="{$type.id_iq_material_type}"
                {if isset($fieldDetails['material_type']) && ($fieldDetails['material_type'] == $type.id_iq_material_type)}selected="selected" {/if}
                >
                {$type.material_type_name}</option>
                {/foreach}

            </select>

  				<label>Material Thickness</label><br>
  				<select name="material_size" id="material_size_id" required>
  					<option value="">Please Select</option>
          </select>

          <span id="spanQuantity"><label>Quantity Needed:</label>
            <input type="text" id="material_qty" size="12" maxlength="7" value="1" name="material_qty">
</span>






  				<br><br>
  				<p>Front Load or Flat Pan</p>
  				<label for="flatPan">Flat</label>
  				<input type="radio" id="flatPan" name="pan" onclick="showFront()" checked><br>
  				<label for="frontPan">Front Load</label>
  				<input type="radio" id="frontPan" name="pan" onclick="showFront()">
  				<br><br>

          {$shapeClassData.title}<br><br>
          <label>Length (in)</label><br>
  				<input type="number" class="AttributeInput roundto2" id="attribute_L" name="L"><br>


          <label>Width (in)</label><br>
  				<input type="number" class="AttributeInput roundto2" id="attribute_W" name="W"><br>


          <label>Height (in)</label><br>
  				<input type="number" class="AttributeInput roundto2" id="attribute_H" name="H"><br>


          <label for="front_height" id="front" style="display: none">Front Height</label><br>
  				<input type="number" id="front_height" name="front_height" style="display: none"><br>


          <div id="errorMessage" style="display: none"></div><br>
  				<div id="errorMaterial" style="display: none"></div>
  				<div id="errorDiameter" style="display: none"></div>


          <p>Drain Hole?</p>
  				<label for="yesHole">Yes</label>
  				<input type="radio" id="yesHole" name="holes" onclick="showMe()"><br>
  				<label for="noHole">No</label>
  				<input type="radio" id="noHole" name="holes" onclick = "showMe()" checked>
  				<br><br>
          <!--
  				<div id="holes" style="display: none">
  				<label for="holeLocation" id="holeLabel">Select Desired Hole Location</label><br>
  				<select name="holeLocation" id="holeLocation">
  					<option value="none" selected disabled hidden>Please Select</option>
  					<option id="top" value="top">Top</option>
  					<option id="bottom" value="bottom">Bottom</option>
  					<option id="left" value="left">Left</option>
  					<option id="right" value="right">Right</option>
  				</select>
  				<br><br>
  				<label for="distance" id="distance_label">Distance From Left Wall</label><br>
  				<input type="number" id="distance" name="distance"><br>
  				<label for="diameter" id="diam_label" >Enter Hole Diameter:</label><br>
  				<input type="number" id="diameter" name="diameter"><br><br>
  			</div>
-->

<!--
  			<button class="btn" type="button" onclick="materialCost()" style="display: none;">Get material cost</button><br>
  			<button class="btn" type="button" onclick="manufacturingCost()" style="display: none;">Get Manufacturing Cost</button><br>

  			<button class="btn" type="button" onclick="finalCost()">Get Instant Quote</button><br>




  		<div class="right-column">

  <p id="cost-container" style="display: none"><span id="mCost">Material Cost: </span><span id="manufacturing_cost">Manufacturing Cost: </span><span id="final">Sale Price: </span><br><br>
  			<input type="button" class="btn" id="clear" value="Download Drawing" onclick="download()"></p>
-->

        <div class="iq-cart-section">
    <div class="section_mob_center" id="spansku" style="display:none" >
        <div class="d-flex flex-column justify-content-center align-items-center">
            <span  class="prod_sku">
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
        <span class="buttons_sec m-0" >
            <!-- <input type="button" id="add_material"  value="Get Price" name="add_material"> -->
            <div id="spanstockcheck" style="font-size: 12px;font-weight: bold;height: 4px;"></div>

            <button  id="addtocart"  class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button" style="display:none">
                <i class="fto-glyph icon_btn"></i><span>Add to cart</span>
            </button>
            <input type="hidden" id="ajax"  value="true" name="ajax">
            <input type="hidden" id="shapeId"  value="{$shapeClassData.id_iq_shape}" name="shapeId">
            <input type="hidden" id="shapeNameHiden"  value="{$shapeClassData.display_name}" name="shapeName">
            <input type="hidden" id="productWeight"  value="0" name="shapeName">
            <input type="hidden" id="methode"  value="price_engine" name="methode">

        </span>

    </div>

    <div id="extraerrors"></div>
    <div id="warnings"></div>

    <div id="extraCartBtn" hidden>
            <a id="extraCartBtnChild" class="ajax_add_to_cart_button hover_fly_btn  btn-spin " href="javascript:void(0)" rel="nofollow" title="Add to cart" data-id-product="0" data-id-product-attribute="0" data-minimal-quantity="1"><div class="hover_fly_btn_inner"><i class="fto-glyph icon_btn"></i><span>Add to cart</span></div>
            </a>
        </div>
</div>


<div class="clr"> </div>
<div id="iq_suggested_product" class="px-3 pt-3">

</div>
<div class="clr"> </div>
<br/>

</form>
</div>


<div class="right-column">
  <div style="background-color: white;">
  	<canvas id="myCanvas" class="myCanvas" width="1000" height="1000" style="background-color: white;">
  		<p>canvas not supported boooo </p>
  	</canvas>
  </div>

    <img id="flPan" src="http://localhost/srp-web/modules/instantquote/images/productimages/flPan.png" width="250" height="250" style="display: none">
  	<img id="panD" src="http://localhost/srp-web/modules/instantquote/images/productimages/pan.png" width="250" height="250" style="display: none">
  	<img id="km" src="http://localhost/srp-web/modules/instantquote/images/productimages/km2.png" width="1000" height="1000" style="display:none">
  	<img id="pow" src="http://localhost/srp-web/modules/instantquote/images/productimages/powdercoat.png" style="display:none">
  	<img id="powSpec" src="http://localhost/srp-web/modules/instantquote/images/productimages/powderhole.png" style="display: none">




  <script>
      const canvas = document.querySelector('.myCanvas');
      let c = document.getElementById("myCanvas");
      let context = canvas.getContext("2d");
  </script>
</div>



<!-- /Block mymodule -->
