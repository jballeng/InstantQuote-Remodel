<!DOCTYPE html>
<div id="jb_wrap">
			<h1>Find Your Pan</h1>
			<center>
<div id="jb_breadcrumb" class="jb_breadcrumb">
	<a id="default" class="jb_breadcrumbItem" onclick="currentSlide(1)">Material</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(2)">Design</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(3)">Dimensions</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(4)">Add Ons</a>
</div>
<br><br>


</center>
<div id="swiperContainerDiv" class="swiper-container">

			<form action="" id="material_type_form"  onchange="" class="std" name="material_type_form" method="post">
				<div id="material_swiper" name="material_swiper" class="swiper">
				<h3>Material</h3>
				<p>Please select the material type and gauge before moving on to the next section</p>


<div id="materialDiv" style="float:left">

	<h3>Material Type</h3>

<div id="radioDiv" name="radioDiv" class="radioDiv">
	{foreach from=$material_types item=type}

	<input type="radio" id="{$type.material_type_name}" name="material_type" value="{$type.id_iq_material_type}"

	>
					{$type.material_type_name}<br><br>
	{/foreach}

</div>




</div>

<div id="materialSizeDiv" style="float:right; font-size:22px; padding-left:75px">
	<h3>Material Thickness
		<div class="jb_tooltip">?
		<span class="jb_tooltiptext">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum."</span>
		</div>
	</h3>
	<br>
	<select id="material_size_id" name="material_size">
	<option value="">Please Select</option>
	</select>
<br><br>
<br><br>

<label for="material_qty">Quantity</label><br>
<input type="text" id="material_qty" name="material_qty" size="12" maxlength="3" value="1" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
</div>
			</div>


			<div class="swiper">
			<h3>Pan Design
				<div class="jb_tooltip">?
				<span class="jb_tooltiptext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum.</span>
				</div>
			</h3>
			<div id="panDesign" style="float:left; padding-right:75px;">
				<h3 style="font-size:22px">Front Load or Flat Pan</h3>
				<label for="flatPan">Flat</label>
				<input type="radio" id="flatPan" name="pan" onclick="showFront()"><br>
				<label for="frontPan">Front Load</label>
				<input type="radio" id="frontPan" name="pan" onclick="showFront()">
				<br><br>
				<h3 style="font-size:22px">Drain Hole?</h3>
				<label for="yesHole" style="font-size:22px">Yes</label>
				<input type="radio" id="yesHole" name="holes" onclick="showMe()"><br>
				<label for="noHole" style="font-size:22px">No</label>
				<input type="radio" id="noHole" name="holes" onclick = "showMe()" checked>
				<br><br>

			</div>

			<div id="img1" style="float:right">
				<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/flat.png" id="flatPic" style="display:none" width="600" height="500">
				<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/frontHole.png" id="frontHole" style="display:none" width="600" height="500">
				<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/front.png" id="frontPic" style="display:none"width="600" height="500">
				<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/holePan.png" id="holePan" style="display:none" width="600" height="400">
		</div>
	</div>
	<script>

	function showHole(){
		if(document.getElementById("yesHole").checked == true){
			document.getElementById("holes").style.display = "inline";

		}
		if(document.getElementById("noHole").checked == true){
			document.getElementById("holes").style.display = "none";

		}

	}


	document.getElementById("yesHole").addEventListener("click", showHole);
	document.getElementById("noHole").addEventListener("click", showHole);

	</script>

		<div class="swiper">

				<h3>Dimensions
					<div class="jb_tooltip">?
					<span class="jb_tooltiptext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum.</span>
					</div>
				</h3>


				<div class="wlbox" id="lwh" style="float:left">
					{foreach from=$shapeInputsData item=inputshape}
					{$inputshape.display_name}<br>
					<input type="text" class="AttributeInput {str_replace(",", " ",$inputshape.properties)}" id="attribute_{$inputshape.param}" size="10" maxlength="7" value="{if isset($fieldDetails[$inputshape.param])}{$fieldDetails[$inputshape.param]}{/if}" name="{$inputshape.param}" onkeyup="this.value = this.value.replace(/[^0-9, .]/, '')">
					{/foreach}



					<label for="front_height" id="front" style="display: none">Front Height</label><br>
					<input type="text" id="front_height" name="front_height" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9, .]/, '')" style="display: none">
					<div id="holes" style="display: none">
					<label for="holeLocation" id="holeLabel">Hole Location</label><br>
					<select name="holeLocation" id="holeLocation" style="width:75px">
						<option value="none" selected disabled hidden>Please Select</option>
						<option id="upper" value="upper">A</option>
						<option id="right" value="right">B</option>
						<option id="lower" value="lower">C</option>
						<option id="left" value="left">D</option>
						<option id="bottom" value="bottom">E</option>
					</select>
					<label for="distance" id="distance_label">Distance From</label><br>
					<input type="text" id="distance" name="distance" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9, .]/, '')">
					<label for="distance2" id="distance2_label" style="display: none">Distance From Flange A</label><br>
						<input type="text" id="distance2" name="distance2" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9, .]/, '')" style="display: none"><br>
					<label for="diameter" id="diam_label" >Hole Diameter:</label><br>
					<input type="text" id="diameter" name="diameter" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9, .]/, '')">
				</div>
				</div>

				<script>
							function flange(){
								var side = document.forms["material_type_form"]["holeLocation"].value;
								var label = document.getElementById("distance_label");


								if(side == "right" || side == "left"){
									label.innerHTML = "Distance From Flange A";
									document.getElementById("distance2_label").style.display = "none";
									document.getElementById("distance2").style.display = "none";
								}
								if(side == "upper" || side == "lower"){
									label.innerHTML = "Distance From Flange D";
									document.getElementById("distance2_label").style.display = "none";
									document.getElementById("distance2").style.display = "none";
								}
								if(side == "bottom"){
									label.innerHTML = "Distance From Flange D";
									document.getElementById("distance2_label").style.display = "inline";
									document.getElementById("distance2").style.display = "inline";
								}

							}
							document.forms["material_type_form"]["holeLocation"].addEventListener("change", flange);


							//setTimeout(validateDimension, 400);
							//document.getElementById("attribute_L").addEventListener("change", validateDimension);
							//document.getElementById("attribute_W").addEventListener("change", validateDimension);
							</script>



<div style="float:right; padding-left:150px; padding-bottom:150px; display:inline">
<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/flat.png" id="flatPic2" style="display:none" width="600" height="500">
<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/front.png" id="frontPic2" style="display:none" width="600" height="500">
<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/frontHole.png" id="frontHole2" style="display:none" width="600" height="500">
<img src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/holePan.png" id="holePan2" style="display:none" width="600" height="400">
</div>
			</div>
			<script>
			function drawFlat(){
				let flat = document.getElementById("flatPan");
				let front = document.getElementById("frontPan");
				let yes = document.getElementById("yesHole");
				let no = document.getElementById("noHole");
				if(flat.checked == true){
					document.getElementById("frontPic").style.display = "none";
					document.getElementById("frontPic2").style.display = "none";
					document.getElementById("frontHole").style.display = "none";
					document.getElementById("frontHole2").style.display = "none";
					document.getElementById("holePan").style.display = "none";
					document.getElementById("holePan2").style.display = "none";
					document.getElementById("flatPic").style.display = "inline-block";
					document.getElementById("flatPic2").style.display = "inline-block";
					if(yes.checked == true){
						document.getElementById("frontPic").style.display = "none";
						document.getElementById("frontPic2").style.display = "none";
						document.getElementById("frontHole").style.display = "none";
						document.getElementById("frontHole2").style.display = "none";
						document.getElementById("flatPic2").style.display = "none";
						document.getElementById("flatPic2").style.display = "none";
						document.getElementById("flatPic").style.display = "none";
						document.getElementById("holePan").style.display = "inline-block";
						document.getElementById("holePan2").style.display = "inline-block";
					}else{
						document.getElementById("frontPic").style.display = "none";
						document.getElementById("frontPic2").style.display = "none";
						document.getElementById("frontHole").style.display = "none";
						document.getElementById("frontHole2").style.display = "none";
						document.getElementById("flatPic2").style.display = "none";
						document.getElementById("holePan").style.display = "none";
						document.getElementById("holePan2").style.display = "none";
						document.getElementById("flatPic").style.display = "inline-block";
						document.getElementById("flatPic2").style.display = "inline-block";
					}
				}
				if(front.checked == true){
					document.getElementById("frontPic").style.display = "inline";
					document.getElementById("frontPic2").style.display = "inline";
					document.getElementById("flatPic2").style.display = "none";
					document.getElementById("flatPic").style.display = "none";
					document.getElementById("holePan").style.display = "none";
					document.getElementById("holePan2").style.display = "none";
					document.getElementById("frontHole").style.display = "none";
					document.getElementById("frontHole2").style.display = "none";
					if(yes.checked == true){
						document.getElementById("frontPic").style.display = "none";
						document.getElementById("frontPic2").style.display = "none";
						document.getElementById("flatPic2").style.display = "none";
						document.getElementById("flatPic").style.display = "none";
						document.getElementById("holePan").style.display = "none";
						document.getElementById("holePan2").style.display = "none";
						document.getElementById("frontHole").style.display = "inline";
						document.getElementById("frontHole2").style.display = "inline";

					}else{
						document.getElementById("frontPic").style.display = "inline";
						document.getElementById("frontPic2").style.display = "inline";
						document.getElementById("flatPic2").style.display = "none";
						document.getElementById("flatPic").style.display = "none";
						document.getElementById("holePan").style.display = "none";
						document.getElementById("holePan2").style.display = "none";


						document.getElementById("frontHole").style.display = "none";
						document.getElementById("frontHole2").style.display = "none";
					}
				}

			}
			document.getElementById("flatPan").addEventListener("change", drawFlat);
			document.getElementById("frontPan").addEventListener("change", drawFlat);
			document.getElementById("yesHole").addEventListener("change", drawFlat);
			document.getElementById("noHole").addEventListener("change", drawFlat);


			</script>
			<div id="swiper" class="swiper">
<div class="lastStep">
			<h3>Add Ons
				<div class="jb_tooltip">?
				<span class="jb_tooltiptext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum.</span>
				</div>

			</h3>

				<input type="checkbox" id="DPF1" value="5.97">
				<label for="DPF1">Drain Pan Fitting - 1" NPT-PVC</label><br><br>
				<input type="checkbox" id="DPF2" value="9.69">
				<label for="DPF2">Drain Pan Fitting - 3/4" NPT-PVC</label><br><br>
				<input type="checkbox" id="DPF3"  value="9.69">
				<label for="DPF3">Drain Pan Fitting 1-1/4" NPT-PVC</label><br><br>
				<input type="checkbox" id="leakAlert" value="34.99">
				<label for="leakAlert">Leak Alert Device - Wifi Water Alarm</label><br><br>
				<input type="checkbox" id="holeKit" value="34.78">
				<label for="holeKit">Drain Pan Hole Drill Kit</label><br><br>
				<input type="checkbox" id="avPad" value="49.49">
				<label for="avPad">Anti-Vibration Pad with Adhesive - 30" x 32"</label><br><br>
			</div>


			<div class="findPan">
				<button class="btn" type="button" id="submit"onclick="finalCost()">Find Your Pan</button><br>
			</div>
			</div>

			<div class="iq-cart-section">
			<span class="button_sec">
			<input type="hidden" id="ajax"  value="true" name="ajax">
			<input type="hidden" id="shapeId"  value="{$shapeClassData.id_iq_shape}" name="shapeId">
			<input type="hidden" id="shapeNameHiden"  value="{$shapeClassData.display_name}" name="shapeName">
			<input type="hidden" id="productWeight"  value="0" name="shapeName">
			<input type="hidden" id="methode"  value="price_engine" name="methode">
			</span>
			<div id="extraerrors"></div>
			<div id="warnings"></div>
			</div>
		</div>
			<a class="prev" id="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" id="next" onclick="plusSlides(1)">&#10095;</a>


</form>
</div>
<script>
slideIndex = 1;

</script>

		<div id="right" class="right-column">

			<div id="tabs" style="display:none">

				<div class="tab">
					<button class="tablinks" id="defaultOpen" onclick="openTab(event, 'suggested')" style="color:white">Suggested Products</button>
					<button class="tablinks" id="custom-quote"  style="color:white">Custom Quote</button>
					<button class="tablinks" onclick="openTab(event, 'faq')" style="color:white">FAQ</button>
				</div>

				<div id="custom" class="tabcontent">


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

					<button  id="addtocart"  class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button" style="display:none">
                <i class="fto-glyph icon_btn"></i><span>Add to cart</span>
            </button>

					</span>
					</div>



						<canvas id="myCanvas" class="myCanvas" width="1000" height="1000" style="top:0">
							<p>canvas not supported boooo </p>
						</canvas>
						<div id="contact-modal" class="contactModal" style="display:none">
							<div class="contact-modal-content">
								<span class="close">&times;</span>
								<h3>Contact Form</h3>
								<div class="contact-form">
  								<form>
										<h5>In the event of any issues that come up with your custom pan,
											we require the following basic information.</h5><br>

										<label for="business-personal">Are you purchasing for personal or business needs</label>
    								<select id="business-personal" name="business-personal">
											<option value="none" selected disabled hidden>Please Select</option>
      								<option value="business">Business</option>
      								<option value="personal">Personal</option>
    								</select>
										<label for="fname">First Name</label>
    								<input type="text" id="fname" name="firstname" placeholder="Your name.." maxlength="20" onkeyup="this.value = this.value.replace(/[^a-z, A-Z, -]/, '')">

    								<label for="lname">Last Name</label>
    								<input type="text" id="lname" name="lastname" placeholder="Your last name.." maxlength="20" onkeyup="this.value = this.value.replace(/[^a-z, A-Z, -]/, '')">

										<label for="contactEmail">Email Address</label>
										<input type="email" id="contactEmail" placeholder="Email Address..">
    								<input type="submit" value="Submit">
  							</form>
							</div>
							</div>
						</div>
							<script>
							var modal = document.getElementById("contact-modal");
							var contactOpen = document.getElementById("custom-quote");
							var close = document.getElementsByClassName("close")[0];
							contactOpen.onclick = function(){
								openTab(event, 'custom');
							}
							contactOpen.addEventListener("click", function(){
								modal.style.display = "block";
							});
							close.onclick = function(){
							  modal.style.display = "none";
								openTab(event, 'suggested');
								document.getElementById("defaultOpen").classList.add("active");
							}
							window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

							</script>
						</div>

				</div>
				<div id="faq" class="tabcontent">
					<h1>Testing</h1>

				</div>

				<img id="flPan" src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/flPan.png" width="250" height="250" style="display: none">
					<img id="panD" src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/pan.png" width="250" height="250" style="display: none">
					<img id="km" src="http://srpdemo.confianzit.org/modules/instantquote/images/productimages/km2.png" width="1000" height="1000" style="display:none">

				<div id="suggested" class="tabcontent">
					<div id="iq_suggested_product" class="px-3 pt-3">
					</div>
				</div>
			</div>

<script>
function openTab(evt, tabName){
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for(i = 0; i < tabcontent.length; i++){
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for(i = 0; i < tablinks.length; i++){
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<script>
		const canvas = document.querySelector('.myCanvas');
		let c = document.getElementById("myCanvas");
		let context = canvas.getContext("2d");
</script>
