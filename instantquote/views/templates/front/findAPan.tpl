
<div id="jb_wrap">
			<h1>Find Your Pan</h1>
<div class="swiper-container">

			<form action="" id="mtrl_form"  onchange="displayGauge()">
				<div class="swiper">
				<h3>Material</h3>
				<p>Please select the material type and gauge before moving on to the next section</p>




<div style="float:left">


	<h3>Material Type</h3>
	<input type="radio" id="A" name="material" value="Aluminum">
	<label for="A">Aluminum</label><br><br>



	<input type="radio" id="GS" name="material" value="Galvanized Steel">
	<label for="GS">Galvanized Steel</label><br><br>



	<input type="radio" id="SS" name="material" value="Stainless Steel">
	<label for="SS">Stainless Steel</label><br><br>



	<input type="radio" id="CRS" name="material" value="Steel(RAW)">
	<label for="CRS">Steel(RAW)</label><br><br>



	<input type="radio" id="WCRS" name="material" value="Gloss White Steel(RAW)">
	<label for="WCRS">Gloss White Steel(RAW)</label><br><br>



	<input type="radio" id="BCRS" name="material" value="Gloss Black Steel(RAW)">
	<label for="BCRS">Gloss Black Steel(RAW)</label><br><br>



	<input type="radio" id="FCRS" name="material" value="Faux Stainless Steel(RAW)">
	<label for="FCRS">Faux Stainless Steel(RAW)</label><br><br>



</div>

<div style="float:right; font-size:22px; padding-left:75px">
	<h3>Material Thickness
		<div class="jb_tooltip">?
		<span class="jb_tooltiptext">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum."</span>
		</div>
	</h3>
	<input type="radio" id="14GA" name="gauge" value="14GA">
	<label for="14GA" id="14">14GA</label><br><br>
	<input type="radio" id="18GA" name="gauge" value="18GA">
	<label for="18GA" id="18">18GA</label><br><br>
	<input type="radio" id="20GA" name="gauge" value="20GA">
	<label for="20GA" id="20">20GA</label><br><br>




<br><br>

<label for="quantity">Quantity</label><br>
<input type="number" id="quantity" name="quantity" value="1">
</div>
			</div>

			<div class="swiper">
			<h3>Pan Design
				<div class="jb_tooltip">?
				<span class="jb_tooltiptext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum.</span>
				</div>
			</h3>
			<div style="float:left; padding-right:75px">
				<h3 style="font-size:22px">Front Load or Flat Pan</h3>
				<label for="flatPan">Flat</label>
				<input type="radio" id="flatPan" name="pan" onclick="showFront()"><br>
				<label for="frontPan">Front Load</label>
				<input type="radio" id="frontPan" name="pan" onclick="showFront()">
				<br><br>
			</div>

			<div style="float:right;">
				<h3 style="font-size:22px">Drain Hole?</h3>
				<label for="yesHole" style="font-size:22px">Yes</label>
				<input type="radio" id="yesHole" name="holes" onclick="showMe()"><br>
				<label for="noHole" style="font-size:22px">No</label>
				<input type="radio" id="noHole" name="holes" onclick = "showMe()" checked>
				<br><br>
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
		</div>
	</div>

		<div class="swiper">
				<h3>Dimensions
					<div class="jb_tooltip">?
					<span class="jb_tooltiptext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ultricies sem ac nisl efficitur auctor. In ligula erat, eleifend bibendum risus at, bibendum varius nisl. Nam nec eros a nunc fringilla scelerisque. Nulla facilisi. Aenean nunc elit, consequat et leo ut, facilisis elementum nisl. Cras ultricies enim id est consectetur molestie. Mauris et nisl lobortis, sodales nisi ut, accumsan ipsum.</span>
					</div>
				</h3>
		<div class="dimensions" style="float:left; padding-right:20px">

					<label for="lng">Length (in)</label><br>
					<input type="number" id="lng" name="lng" size="2" required><br>

				<label for="wid">Width (in)</label><br>
				<input type="number" id="wid" name="wid" required><br>
				<label for="hit" >Height (in)</label><br>
				<input type="number" id="hit" name="hit" required><br>
				<label for="front_height" id="front" style="display: none">Front Height</label><br>
				<input type="number" id="front_height" name="front_height" style="display: none"><br>

			</div>
			<img src="http://localhost/srp-web/modules/instantquote/images/productimages/flat.png" id="flatPic" style="display:none">
			<img src="http://localhost/srp-web/modules/instantquote/images/productimages/front.png" id="frontPic" style="display:none">
			</div>
			<script>
			function drawFlat(){

				if(document.getElementById("flatPan").checked == true){
					document.getElementById("flatPic").style.display = "inline";
					document.getElementById("frontPic").style.display = "none";
				}
				if(document.getElementById("frontPan").checked == true){
					document.getElementById("frontPic").style.display = "inline";
					document.getElementById("flatPic").style.display = "none";
				}
			}
			document.getElementById("flatPan").addEventListener("change", drawFlat);
			document.getElementById("frontPan").addEventListener("change", drawFlat);

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
				<button class="btn" type="button" onclick="finalCost()">Find Your Pan</button><br>
			</div>
			</div>
</form>
		</div>
			<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" onclick="plusSlides(1)">&#10095;</a>

			<center>
<div class="jb_breadcrumb">
	<a id="default" class="jb_breadcrumbItem" onclick="currentSlide(1)">Material</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(2)">Design</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(3)">Dimensions</a>
	<a class="jb_breadcrumbItem" onclick="currentSlide(4)">Add Ons</a>
</div>
<br><br>

</center>
<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</div>
<script>
slideIndex = 1;
</script>

		<div id="right" class="right-column">

			<div id="tabs" style="display:none">
				<div class="tab">
					<button class="tablinks" id="defaultOpen" onclick="openTab(event, 'suggested')" style="color:white">Suggested Products</button>
					<button class="tablinks" onclick="openTab(event, 'custom')" style="color:white">Custom Quote</button>
					<button class="tablinks" onclick="openTab(event, 'faq')" style="color:white">FAQ</button>
				</div>
				<div id="faq" class="tabcontent">
					<h1>Testing</h1>

				</div>
				<div id="custom" class="tabcontent">



					<div>
						<p id="cost-container">



							<span id="addOn"></span><br><br>


						</p>
						<canvas id="myCanvas" class="myCanvas" width="1000" height="1000" style="top:0">
							<p>canvas not supported boooo </p>
						</canvas>
						<h5 id="final" style="float:left">Sale Price: </h5>
					</div>
				</div>
				<img id="flPan" src="http://localhost/srp-web/modules/instantquote/images/productimages/flPan.png" width="250" height="250" style="display: none">
					<img id="panD" src="http://localhost/srp-web/modules/instantquote/images/productimages/pan.png" width="250" height="250" style="display: none">
					<img id="km" src="http://localhost/srp-web/modules/instantquote/images/productimages/km2.png" width="1000" height="1000" style="display:none">
					<img id="pow" src="http://localhost/srp-web/modules/instantquote/images/productimages/powdercoat.png" style="display:none">
				<div id="suggested" class="tabcontent">
					<h2>Product Match</h2>

					<p>suggested products populated based on the input of customers needs</p>

					<table style="width:100%">
						<tr>
							<th colspan="3">Suggested Products</th>
						</tr>
						<tr>
							<td>
								<p>x difference same material</p>
								<img src="http://localhost/srp-web/modules/instantquote/images/productimages/pan1.jpg" width="100" length="100"><br>

								<p>Stock Price: <strong>$200.00</strong></p>
								<button  id="addtocart"  class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button">
										<i class="fto-glyph icon_btn"></i><span>Add to cart</span>
								</button>
							</td>
							<td>
								<p>x difference different material</p>
								<img src="http://localhost/srp-web/modules/instantquote/images/productimages/pan2.jpg" width="100" length="100">

								<p>Stock Price: <strong>$150.00</strong></p>
								<ul>
									<li>Reason 1</li><br>
									<li>Reason 2</li><br>
									<li>Reason 3</li>
								</ul><br>
								<button  id="addtocart"  class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button">
										<i class="fto-glyph icon_btn"></i><span>Add to cart</span>
								</button>
							</td>
							<td>
								<p>x difference different material</p>
								<img src="http://localhost/srp-web/modules/instantquote/images/productimages/pan3.jpg" width="100" length="100">

								<p>Stock Price: <strong>$99.99</strong></p>
								<ul>
									<li>Reason 1</li><br>
									<li>Reason 2</li><br>
									<li>Reason 3</li>
								</ul><br>
								<button  id="addtocart"  class="btn btn-secondary py-2  btn-spin" name="addtocart" type="button">
										<i class="fto-glyph icon_btn"></i><span>Add to cart</span>
								</button>
							</td>
						</tr>
					</table>
					<h2>Fill remaining white space with products</h2>
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
