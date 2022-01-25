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
                    <h4>Material Type</h4>
                    <br>
                    <div id="radioDiv" name="radioDiv" class="radioDiv">
                        {foreach from=$material_types item=type}
                        <label>
                        <input type="radio" class="js-material-type" id="{$type.material_type_name}" name="material_type" value="{$type.id_iq_material_type}" data-attr-name="{$type.material_type_name}">
                        {$type.material_type_name}
                        </label>
                        <br><br>
                        {/foreach}
                    </div>
                    <small id="js-material-type-error" class="js-error"></small>
                </div>
                <div id="materialSizeDiv" style="float:right; font-size:22px; padding-left:75px">
                    <h4>
                        Material Thickness
                        
                    </h4>
                    <br>
                    <select id="material_size_id" name="material_size">
                        <option value="">Please Select</option>
                    </select>
                    <small id="js-material-size-error" class="js-error"></small>
                    <br><br>
                    <h4>Quantity</h4><br>
                    <input type="text" id="material_qty" name="material_qty" size="12" maxlength="3" value="1" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
                    <small id="js-material-qty-error" class="js-error"></small>
                </div>
            </div>
            <div class="swiper">
                <h3>
                    Pan Design
                    
                </h3>
                <div id="panDesign" style="">
                    <h3 style="font-size:22px">Front Load or Flat Pan</h3>
                    <label for="flatPan">
                    <input type="radio" id="flatPan" name="pan" onclick="showFront()">
                    Flat</label>
                    <br>
                    <label for="frontPan">
                    <input type="radio" id="frontPan" name="pan" onclick="showFront()">
                    Front Load</label>
                    <br>
                    <small id="js-pan-error" class="js-error"></small>
                    <br>
                    <br>
                    <h3 style="font-size:22px">Drain Hole?</h3>
                    <label for="yesHole" style="font-size:22px">
                    <input type="radio" id="yesHole" name="holes" onclick="showMe()">
                    Yes</label>
                    <br>
                    <label for="noHole" style="font-size:22px">
                    <input type="radio" id="noHole" name="holes" onclick = "showMe()" checked>
                    No</label>
                    <br><br>
                </div>
                <div id="img1" style="float:right">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/flat.png" id="flatPic" style="display:none" width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/frontHole.png" id="frontHole" style="display:none" width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/front.png" id="frontPic" style="display:none"width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/holePan.png" id="holePan" style="display:none" width="600" height="400">
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
                <h3>
                    Dimensions
                    
                </h3>
                <div class="wlbox" id="lwh" style="">
                    {foreach from=$shapeInputsData item=inputshape}
                    {$inputshape.display_name}<br>
                    <input type="text" class="form-control AttributeInput {str_replace(",", " ",$inputshape.properties)}" id="attribute_{$inputshape.param}" size="10" maxlength="7" value="{if isset($fieldDetails[$inputshape.param])}{$fieldDetails[$inputshape.param]}{/if}" name="{$inputshape.param}" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
                    {/foreach}
                    <label for="front_height" id="front" style="display: none">Front Height</label><br>
                    <input type="text" class="form-control" id="front_height" name="front_height" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9]/, '')" style="display: none" >
                    <div id="holes" style="display: none">
                        <label for="holeLocation" id="holeLabel">Hole Location</label><br>
                        <select name="holeLocation" id="holeLocation" style="width:75px">
                            <option value="" selected disabled hidden>Please Select</option>
                            <option id="upper" value="upper">A</option>
                            <option id="right" value="right">B</option>
                            <option id="lower" value="lower">C</option>
                            <option id="left" value="left">D</option>
                            <option id="bottom" value="bottom">E</option>
                        </select>
                        <label for="distance" id="distance_label">Distance From</label><br>
                        <input type="text" class="form-control" id="distance" name="distance" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
                        <label for="distance2" id="distance2_label" style="display: none">Distance From Flange A</label>
                        <input type="text" class="form-control" id="distance2" name="distance2" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9]/, '')" style="display: none">
                        <label for="diameter" id="diam_label" >Hole Diameter:</label>
                        <input type="text" class="form-control" id="diameter" name="diameter" maxlength="7" onkeyup="this.value = this.value.replace(/[^0-9]/, '')">
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
                <div style="float:right; padding-left:150px; padding-bottom:70px; display:inline" class="dimension-image">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/flat.png" id="flatPic2" style="display:none" width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/front.png" id="frontPic2" style="display:none" width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/frontHole.png" id="frontHole2" style="display:none" width="600" height="500">
                    <img src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/holePan.png" id="holePan2" style="display:none" width="600" height="400">
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
                    <h3 style="margin-bottom:40px">
                        Add Ons
                        
                    </h3>
                    <div class="form-group">                       
                        <label for="DPF1" class="form-check-label"> <input type="checkbox" id="DPF1" value="5.97"> Drain Pan Fitting - 1" NPT-PVC</label>
                    </div>
                    <div class="form-group">                          
                        <label for="DPF2" class="form-check-label"><input type="checkbox" id="DPF2" value="9.69"> Drain Pan Fitting - 3/4" NPT-PVC</label>
                    </div>
                    <div class="form-group"> 
                        <label for="DPF3" class="form-check-label"><input type="checkbox" id="DPF3"  value="9.69"> Drain Pan Fitting 1-1/4" NPT-PVC</label>
                    </div>

                    <div class="form-group"> 
                        <label for="leakAlert" class="form-check-label"><input type="checkbox" id="leakAlert" value="34.99"> Leak Alert Device - Wifi Water Alarm</label>
                    </div>
                    <div class="form-group">                         
                        <label for="holeKit" class="form-check-label"> <input type="checkbox" id="holeKit" value="34.78"> Drain Pan Hole Drill Kit</label>
                    </div>
                    <div class="form-group"> 
                        <label for="avPad" class="form-check-label"><input type="checkbox" id="avPad" value="49.49">  Anti-Vibration Pad with Adhesive - 30" x 32"</label>
                    </div>
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
            <div class="swiper-controls">
                <a class="prev" id="prev"  data-tab-index="-1">Previous</a>
                <a class="next" id="next"  data-tab-index="1">Next</a>
            </div>
    </div>
    
    </form>
</div>
<script>
    slideIndex = 1;
    
</script>
<div id="right" class="right-column">
    <div id="tabs" style="display:none">
        <div class="tab">
            <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'suggested')"
                style="color:white">Suggested Products</button>
            <button class="tablinks" id="custom-quote"  style="color:white">Custom Quote</button>
            <button class="tablinks" onclick="openTab(event, 'faq')" style="color:white">FAQ</button>
        </div>
        <div id="custom" class="tabcontent">
            {include file='module:instantquote/views/templates/front/price-engine.tpl'}
            <div id="contact-modal" class="contactModal" style="display:none">
                <div class="contact-modal-content">
                    <span class="close">&times;</span>
                    <h3 class="pt-2">Contact Form</h3>
                    <div class="contact-form iq-contact-form-p">
                        <form id="srpcustomerRequestQuote">
                            <h5>Our sales team is here to help! In order to access your custom quote we require the following information so our team can provide you with the best service possible.
                            </h5>
                            <br>
                            <div role="alert" id="flash-message" style="display:none;"></div>
                            <br><br>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fname">First Name</label>
                                    <input placeholder="First Name *" type="text" id="first_name"
                                        class="rquiredFiled form-control" required name="first_name"
                                        value="{if isset($smarty.post.first_name)}{$smarty.post.first_name}{elseif !empty($first_name)}{$first_name}{/if}" />
                                </div>   
                                <div class="form-group col-md-6">
                                    <label for="lname">Last Name</label>
                                    <input placeholder="Last Name *" type="text" id="last_name"
                                        class="rquiredFiled form-control" required name="last_name"
                                        value="{if isset($smarty.post.last_name)}{$smarty.post.last_name}{elseif !empty($last_name)}{$last_name}{/if}" />
                                </div>                          
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6"> 
                                    <label for="contactEmail">Email Address</label>
                                    <input placeholder="Email *" type="text" id="contact_email"
                                        class="rquiredFiled form-control" required name="contact_email"
                                        value="{if isset($smarty.post.contact_email)}{$smarty.post.contact_email}{elseif !empty($contact_email)}{$contact_email}{/if}" />
                                </div>  
                                <div class="form-group col-md-6">  
                                    <label for="contactEmail">Company</label>
                                    <input placeholder="Company" type="text" class="form-control" id="company_name"
                                        name="company_name"
                                        value="{if isset($smarty.post.company_name)}{$smarty.post.company_name}{elseif !empty($company)}{$company}{/if}" />
                                </div>
                                <div class="form-group col-md-6">   
                                <label for="contactCompany">Phone</label>
                                <input placeholder="Phone *" type="text" id="contact_number"
                                    class="rquiredFiled form-control" required name="contact_number"
                                    value="{if isset($smarty.post.contact_number)}{$smarty.post.contact_number}{elseif !empty($contact_number)}{$contact_number}{/if}" />
                                </div>
                            </div>                            

                            <div class="form-group text-left mb-0">      
                                <button type="submit" class="btn btn-primary" id="js-customer-contact-submit">Submit</button>
                            </div>
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
                        openTab(event, 'suggested');
                        document.getElementById("defaultOpen").classList.add("active");
                    }
                }
                
            </script>
        </div>
    </div>
    <div id="faq" class="tabcontent">
        <h1>Testing</h1>
    </div>
    <img id="flPan"
        src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/flPan.png"
        width="250" height="250" style="display: none">
    <img id="panD"
        src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/pan.png"
        width="250" height="250" style="display: none">
    <img id="km"
        src="{$smarty.const._PS_BASE_URL_}{$smarty.const.__PS_BASE_URI__}modules/instantquote/images/productimages/km2.png"
        width="1000" height="1000" style="display:none">
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>

