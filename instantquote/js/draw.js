
window.onload = document.getElementById("default").click();
var slideIndex = 1;
function plusSlides(n) {
  showSlides(slideIndex += n);
}
function currentSlide(n) {
  showSlides(slideIndex = n);
}
function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("swiper");
  var dots = document.getElementsByClassName("jb_breadcrumbItem");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}


function validateForm(length, width, height, diameter, material, thickness){
  var hemWidth = 0.5;
  //BL is the blank or true length needed for sheet sizes
  var bl = (2*height + length + 2*hemWidth)+1;
  //BW is the blank or true width needed for sheet sizes
  var bw = (2*height + width + 2*hemWidth)+1;
  if(material == "none" || thickness == "none"){
    document.getElementById("errorMessage").style.display = "inline";
    document.getElementById("errorMessage").innerHTML = "ERROR: Please make sure you have material and thickness selected";
    //document.getElementById("clear").style.display = "none";
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    return false;
  }
  else if(isNaN(height) || isNaN(width) || isNaN(length)){
    document.getElementById("errorMessage").style.display = "inline";
    document.getElementById("errorMessage").innerHTML = "Please provide all dimension values";
    //document.getElementById("clear").style.display = "none";
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    return false;
  }
  else if(height > length || height > width){
    document.getElementById("errorMessage").style.display = "inline";
    document.getElementById("errorMessage").innerHTML = "ERROR: The height cannot be greater than the length or width";
    //document.getElementById("clear").style.display = "none";
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    return false;
  }
  else if(height > 8 || height < 0.8){
    document.getElementById("errorMessage").style.display = "inline";
    document.getElementById("errorMessage").innerHTML = 'ERROR: Max height is 8" Minimum height is 0.8"';
    //document.getElementById("clear").style.display = "none";
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    return false;
  }
  else if(document.getElementById("frontPan").checked == true){
    if(document.getElementById("front_height").value == ""){
      document.getElementById("errorMessage").style.display = "inline";
      document.getElementById("errorMessage").innerHTML = "ERROR: Please provide values for both heights on the pan";
      //document.getElementById("clear").style.display = "none";
      var c = document.getElementById("myCanvas");
      var ctx = c.getContext("2d");
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      return false;
    }else{
    return true;
  }
}
//Needs the smallest possible hole size
  else if(document.getElementById("yesHole").checked == true){
    if(diameter == "" || document.getElementById("holeLocation").value == "none" || document.getElementById("distance").value == ""){
      document.getElementById("errorMessage").style.display = "inline";
      document.getElementById("errorMessage").innerHTML = "ERROR: Please enter all values needed for hole";
      //document.getElementById("clear").style.display = "none";
      var c = document.getElementById("myCanvas");
      var ctx = c.getContext("2d");
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      return false;
    }
    else if(diameter > height-0.9){
      document.getElementById("errorMessage").style.display = "inline";
      document.getElementById("errorMessage").innerHTML = "ERROR: Diameter too large";
      //document.getElementById("clear").style.display = "none";
      var c = document.getElementById("myCanvas");
      var ctx = c.getContext("2d");
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      return false;
    }else{
      return true;
    }
  }
  else if(bl > 120 || bw > 60){
    document.getElementById("largePan").style.display = "inline";
    document.getElementById("sizeError").style.display = "inline";
    document.getElementById("sizeError").innerHTML = "Sheet size exceeds 120X60 talk to Josh";
    document.getElementById("largePan").innerHTML = "Current Blank Dimensions: " + bl + "X" + bw;
    //document.getElementById("clear").style.display = "none";
    document.getElementById("cost-container").style.display = "none";
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    return false;
  }else{
    //document.getElementById("clear").style.display = "inline";
    return true;
  }
}
function changeSide(){
  if(document.forms["mtrl_form"]["holeLocation"].value == "left" || document.forms["mtrl_form"]["holeLocation"].value == "right"){
    document.getElementById("distance_label").innerHTML = "Distance From Top Wall";
  }else{
    document.getElementById("distance_label").innerHTML = "Distance From Left Wall";
  }
}
//If user selects to add a hole then the hole options unhide themselves
function showMe(){
  if(document.getElementById("yesHole").checked == true){
    document.getElementById("holes").style.display = "inline";
  }else {
    document.getElementById("holes").style.display = "none";
  }
}
//Shows the front load options when selected
function showFront(){
  if(document.getElementById("frontPan").checked == true){
    document.getElementById("front").style.display = "inline";
    document.getElementById("front_height").style.display = "inline";
    document.getElementById("bottom").style.display = "none";
    document.getElementById("left").style.display = "none";
    document.getElementById("right").style.display = "none";
  }else{
    document.getElementById("front").style.display = "none";
    document.getElementById("front_height").style.display = "none";
    document.getElementById("bottom").style.display = "inline";
    document.getElementById("left").style.display = "inline";
    document.getElementById("right").style.display = "inline";
  }
}
function validateDiameter(diameter, height){

  if(diameter > height){
    return false;
  }else{
    return true;
  }
}
//First basic function to handle validating user inputs
function validateDimensions(length, width, height){
  if(length<1 || width<1 || height<0.8 || height>8){
    return false;


  }else{
    return true;
  }
}
//Function that ensures the user has selected material and thickness
function validateMaterials(a, b){
  if(a == "none" || b == "none"){
    return false;
  }else{
    return true;
  }
}
//Drawing function for pans accepting inputs in final function
function draw(width, length, height, gauge, material){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if(document.getElementById("yesHole").checked == true && document.getElementById("frontPan").checked == true){
    ctx.beginPath();
    ctx.lineWidth = "1";
    ctx.rect(300, 75, 375, 450);
    ctx.rect(300, 45, 375, 30);
    ctx.rect(300, 525, 375, 10);
    ctx.stroke();
    ctx.moveTo(675, 75);
    ctx.lineTo(705, 75);
    ctx.stroke();
    ctx.moveTo(675, 525);
    ctx.lineTo(685, 525);
    ctx.stroke();
    ctx.moveTo(705, 75);
    ctx.lineTo(685,525);
    ctx.stroke();
    ctx.moveTo(300, 75);
    ctx.lineTo(270, 75);
    ctx.stroke();
    ctx.moveTo(270, 75);
    ctx.lineTo(290, 525);
    ctx.stroke();
    ctx.moveTo(290, 525);
    ctx.lineTo(300, 525);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 487.5, 25);
    ctx.fillText(length.toFixed(1) + '"', 240, 300);
    var km = document.getElementById("km");
    var img = document.getElementById("flPan");
    ctx.drawImage(img, 800, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(gauge + " " + material, 560, 850);
  }
  if(document.getElementById("yesHole").checked == true && document.getElementById("flatPan").checked == true){
    ctx.beginPath();
    ctx.lineWidth = "1";
    ctx.rect(300, 75, 375, 450);
    ctx.rect(300, 45, 375, 30);
    ctx.rect(675, 75, 30, 450);
    ctx.rect(675, 525, -375, 30);
    ctx.rect(300, 525, -30, -450);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 487.5, 15);
    ctx.fillText(length.toFixed(1) + '"', 220, 300);
    var km = document.getElementById("km");
    var img = document.getElementById("panD");
    ctx.drawImage(img, 800, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(gauge + " " + material, 560, 850);
  }
  if(document.getElementById("frontPan").checked == true && document.getElementById("yesHole").checked == false){
    ctx.beginPath();
    ctx.lineWidth = "1";
    ctx.rect(300, 75, 375, 450);
    ctx.rect(300, 45, 375, 30);
    ctx.rect(300, 525, 375, 10);
    ctx.stroke();
    ctx.moveTo(675, 75);
    ctx.lineTo(705, 75);
    ctx.stroke();
    ctx.moveTo(675, 525);
    ctx.lineTo(685, 525);
    ctx.stroke();
    ctx.moveTo(705, 75);
    ctx.lineTo(685,525);
    ctx.stroke();
    ctx.moveTo(300, 75);
    ctx.lineTo(270, 75);
    ctx.stroke();
    ctx.moveTo(270, 75);
    ctx.lineTo(290, 525);
    ctx.stroke();
    ctx.moveTo(290, 525);
    ctx.lineTo(300, 525);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 487.5, 25);
    ctx.fillText(length.toFixed(1) + '"', 240, 300);
    var km = document.getElementById("km");
    var img = document.getElementById("flPan");
    ctx.drawImage(img, 800, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(gauge + " " + material, 560, 850);
  }
  if(document.getElementById("flatPan").checked == true && document.getElementById("yesHole").checked == false){
    ctx.beginPath();
    ctx.rect(200, 75, 375, 450);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 387.5, 60);
    ctx.fillText(length.toFixed(1) + '"', 170, 300 );
    var img = document.getElementById("panD");
    var km = document.getElementById("km");
    ctx.drawImage(img, 700, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(gauge + " " + material, 560, 850);
  }
  if(document.forms["mtrl_form"]["material"].value == "PCRS"){

    if(document.getElementById("WCRS").selected == true){
      ctx.fillText("Powder Coat: EDPS010- Gloss White", 570, 680);
    }
    if(document.getElementById("BCRS").selected == true){
      ctx.fillText("Powder Coat: EDPS006- Gloss Black", 570, 680);
    }
    if(document.getElementById("FCRS").selected == true){
      ctx.fillText("Powder Coat: EDPS066- Britebond Faux Stainless", 530, 680)
    }
  }
  if(material == "Stainless Steel" && gauge == "14GA"){
    gauge = "14S";
  }
  if(material == "Stainless Steel" && gauge == "18GA"){
    gauge = "18S";
  }
  if(material == "Stainless Steel" && gauge == "20GA"){
    gauge = "20S";
  }
  if(material == "Galvanized Steel" && gauge == "14GA"){
    gauge = "14G";
  }
  if(material == "Galvanized Steel" && gauge == "18GA"){
    gauge = "18G";
  }
  if(material == "Galvanized Steel" && gauge == "20GA"){
    gauge = "20G";
  }
  if(material == "CRS" || material == "PCRS"&& gauge == "14GA"){
    gauge = "14C";
  }
  if(material == "CRS" || material == "PCRS" && gauge == "18GA"){
    gauge = "18C";
  }
  if(material == "CRS" || material == "PCRS" && gauge == "20GA"){
    gauge = "20C";
  }
  if(material == "Aluminum" && gauge == "14GA"){
    gauge = "14A";
  }
  if(material == "Aluminum" && gauge == "18GA"){
    gauge = "18A";
  }
  if(material == "Aluminum" && gauge == "20GA"){
    gauge = "20A";
  }
  ctx.fillText("KM-" + length + "-" + width + "-" + height + "-" + gauge, 875, 800);

}
function drawHole(d1, d2, d3, d4, d5, d6, d7){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.lineWidth = "1";
  ctx.font = "15px Arial";
  ctx.textAlign = "center";
  var holeLocation = document.forms["mtrl_form"]["holeLocation"].value;
  if(document.getElementById("yesHole").checked == true){
    ctx.fillText("Hole Diameter: " + d6 + '"', 200, 15);
    switch(holeLocation){
      case "top":
        ctx.moveTo(300, 40);
        ctx.lineTo(300, 20);
        ctx.stroke();
        ctx.moveTo(300, 25);
        ctx.lineTo((d1+240)/2, 25);
        ctx.stroke();
        ctx.moveTo(d1, 40);
        ctx.lineTo(d1, 20);
        ctx.stroke();
        ctx.moveTo(d1-10, 25);
        ctx.lineTo((d1+ 340)/2, 25);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(d1, 60, 10, 0, 2*Math.PI);
        ctx.stroke();
        ctx.fillText(d3 + '"', (d1+300)/2, 30);
        break;
      case "bottom":
        ctx.moveTo(300, 565);
        ctx.lineTo(300, 585);
        ctx.stroke();
        ctx.moveTo(310, 575);
        ctx.lineTo((d1+260)/2, 575);
        ctx.stroke();
        ctx.moveTo(d1, 565);
        ctx.lineTo(d1, 585);
        ctx.stroke();
        ctx.moveTo(d1-10, 575);
        ctx.lineTo((d1+ 340)/2, 575);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(d1, 540, 10, 0, 2*Math.PI);
        ctx.stroke();
        ctx.fillText(d3 + '"', (d1+300)/2, 580);
        break;
      case "left":
        ctx.moveTo(260, 75);
        ctx.lineTo(240, 75);
        ctx.stroke();
        ctx.moveTo(250, 75);
        ctx.lineTo(250, (d7+50)/2);
        ctx.stroke();
        ctx.fillText(d3 + '"', 250, (d7+85)/2);
        ctx.stroke();
        ctx.moveTo(260, d7);
        ctx.lineTo(240, d7);
        ctx.stroke();
        ctx.moveTo(250, (d7+100)/2);
        ctx.lineTo(250, d7);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(285, d7, 10, 0, 2*Math.PI);
        ctx.stroke();
        break;
      case "right":
        ctx.moveTo(715, 75);
        ctx.lineTo(735, 75);
        ctx.stroke();
        ctx.moveTo(725, 75);
        ctx.lineTo(725, (d7+50)/2)
        ctx.fillText(d3 + '"', 725, (d7+85)/2);
        ctx.stroke();
        ctx.moveTo(715, d7);
        ctx.lineTo(735, d7);
        ctx.stroke();
        ctx.moveTo(725, (d7+100)/2);
        ctx.lineTo(725, d7);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(690, d7, 10, 0, 2*Math.PI);
        ctx.stroke();
        break;
    }
  }
}
function drawHeight(x, y){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.lineWidth = "1";
  ctx.font = "15px Arial";
  ctx.textAlign = "center";
  if (document.getElementById("flatPan").checked == true) {
    ctx.beginPath();
    ctx.rect(60, 75, 40, 450);
    ctx.stroke();
    ctx.fillText(x + '"', 80, 545);
  }else{
    ctx.moveTo(60, 75);
    ctx.lineTo(100, 75);
    ctx.stroke();
    ctx.moveTo(100, 75);
    ctx.lineTo(100, 525);
    ctx.stroke();
    ctx.moveTo(100, 525);
    ctx.lineTo(85, 525);
    ctx.stroke();
    ctx.moveTo(85, 525);
    ctx.lineTo(60, 75);
    ctx.stroke();
    ctx.fillText(x + '"', 80, 55);
    ctx.fillText(y + '"', 92.5, 545);
  }


}
function download(){
  var height = parseFloat(document.forms["mtrl_form"]["hit"].value);
  var length = parseFloat(document.forms["mtrl_form"]["lng"].value);
  var width = parseFloat(document.forms["mtrl_form"]["wid"].value);
  var gauge = document.forms["mtrl_form"]["thickness"].value;
  var material = document.forms["mtrl_form"]["material"].value;
  if(material == "Stainless Steel" && gauge == "14GA"){
    gauge = "14S";
  }
  if(material == "Stainless Steel" && gauge == "18GA"){
    gauge = "18S";
  }
  if(material == "Stainless Steel" && gauge == "20GA"){
    gauge = "20S";
  }
  if(material == "Galvanized Steel" && gauge == "14GA"){
    gauge = "14G";
  }
  if(material == "Galvanized Steel" && gauge == "18GA"){
    gauge = "18G";
  }
  if(material == "Galvanized Steel" && gauge == "20GA"){
    gauge = "20G";
  }
  if(material == "CRS" || material == "PCRS" && gauge == "14GA"){
    gauge = "14C";
  }
  if(material == "CRS" || material == "PCRS"  && gauge == "18GA"){
    gauge = "18C";
  }
  if(material == "CRS" || material == "PCRS"  && gauge == "20GA"){
    gauge = "20C";
  }
  if(material == "Aluminum" && gauge == "14GA"){
    gauge = "14A";
  }
  if(material == "Aluminum" && gauge == "18GA"){
    gauge = "18A";
  }
  if(material == "Aluminum" && gauge == "20GA"){
    gauge = "20A";
  }
  var link = document.createElement('a');
  link.download = "KM-" + length + "-" + width + "-" + height + "-" + gauge + ".jpeg";
  link.href = document.getElementById("myCanvas").toDataURL();
  return link.click();
}
function sheetCost(length, width, height, thickness, material, quantity){
  var hemWidth = 0.5;
  var sheet;
  var cru;
  if(thickness == "14GA" && material == "Galvanized Steel"){
    thickness = 0.0785;
  }
  if(thickness == "18GA" && material == "Galvanized Steel"){
    thickness = 0.0516;
  }
  if(thickness == "20GA" && material == "Galvanized Steel"){
    thickness = 0.0396;
  }
  if(thickness == "14GA" && material == "CRS"){
    thickness = .0747;
  }
  if(thickness == "18GA" && material == "CRS"){
    thickness = .0478;
  }
  if(thickness == "20GA" && material == "CRS"){
    thickness = .0359;
  }
  if(thickness == "14GA" && material == "PCRS"){
    thickness = 0.0747;
  }
  if(thickness == "18GA" && material == "PCRS"){
    thickness = 0.0478;
  }
  if(thickness == "20GA" && material == "PCRS"){
    thickness = 0.0359;
  }
  if(thickness == "14GA" && material == "Stainless Steel"){
    thickness = 0.07812;
  }
  if(thickness == "18GA" && material == "Stainless Steel"){
    thickness = 0.050;
  }
  if(thickness == "20GA" && material == "Stainless Steel"){
    thickness = 0.0396;
  }

  //BL is the blank or true length needed for sheet sizes
  var bl = (2*height + length + 2*hemWidth)+1;
  //BW is the blank or true width needed for sheet sizes
  var bw = (2*height + width + 2*hemWidth)+1;

  switch(material){
    case "Galvanized Steel":
      if(bl <= 24 && bw <= 24){
        sheet = 24*24*thickness*0.284;

      }
      if(bl > 24 && bl <=48 && bw <= 24){
        sheet = 48*24*thickness*0.284;

      }
      if(bl > 24 && bl <=48 && bw > 24 && bw <= 48){
        sheet = 48*48*thickness*0.284;

      }
      if(bl > 48 && bl <= 120 && bw > 24 && bw <= 48){
        sheet = 120*48*thickness*0.284;

      }
      if(bl > 48 && bl <= 120 && bw > 48 && bw <= 60){
        sheet = 120*60*thickness*0.284;

      }

      break;
    case "CRS":
      if(bl <= 24 && bw <= 24){
        sheet = 24*24*thickness*0.284;

      }
      if(bl > 24 && bl <=48 && bw <= 24){
        sheet = 48*24*thickness*0.284;

      }
      if(bl > 24 && bl <=48 && bw > 24 && bw <= 48){
        sheet = 48*48*thickness*0.284;

      }
      if(bl > 48 && bl <= 120 && bw > 24 && bw <= 48){
        sheet = 120*48*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 120x48";
      }
      if(bl > 48 && bl <= 120 && bw > 48 && bw <= 60){
        sheet = 120*60*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 120x60";
      }
      break;
    case "PCRS":
      if(bl <= 24 && bw <= 24){
        sheet = 24*24*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 24X24";
      }
      if(bl > 24 && bl <=48 && bw <= 24){
        sheet = 48*24*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 48X24";
      }
      if(bl > 24 && bl <=48 && bw > 24 && bw <= 48){
        sheet = 48*48*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 48X48";
      }
      if(bl > 48 && bl <= 120 && bw > 24 && bw <= 48){
        sheet = 120*48*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 120x48";
      }
      if(bl > 48 && bl <= 120 && bw > 48 && bw <= 60){
        sheet = 120*60*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 120x60";
      }
      break;
    case "Stainless Steel":
      if(bl <= 36 && bw <= 30){
        sheet = 36*30*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 36X30";
      }
      else if(bl > 36 && bl <= 40 && bw <= 36){
        sheet = 40*36*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 40X36";
      }
      else if(bl > 40 && bl <= 60 && bw <= 36){
        sheet = 60*36*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 60X36";
      }
      else if(bl > 60 && bl <= 120 && bw <= 36){
        sheet = 120*36*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 120X36";
      }
      else if(bl > 40 && bl <= 48 && bw > 36 && bw <= 48){
        sheet = 48*48*thickness*0.284;
        //document.getElementById("sheetSize").innerHTML = "Sheet Size Used: 48X48";
      }
      break;
  }

  if(material == "Galvanized Steel"){
    cru = 1914;
  }
  if(material == "CRS" || material == "PCRS"){
    cru = 1919;
  }
  if(material == "Stainless Steel"){
    cru = 10000;
  }
  var priceLb = cru/2000;
  var extra = 0;
  if(bl > 90){
    extra = 25*quantity;
  }

  material_cost = (sheet * (priceLb * 1.25) * 1.3) + extra;

  return material_cost;
}
function paint(material, height, length, width, quantity){
  //BL is the blank or true length needed for sheet sizes
  var hemWidth = 0.5;
  var bl = (2*height + length + 2*hemWidth)+1;
  //BW is the blank or true width needed for sheet sizes
  var bw = (2*height + width + 2*hemWidth)+1;
  var paint = 0;
  if(bl <= 24 && bw <= 24 && material == "PCRS"){
    paint = 16.25*quantity;

  }
  if(bl > 24 && bl <=48 && bw <= 24 && material == "PCRS"){
    paint = 32.50*quantity;

  }
  if(bl > 24 && bl <=48 && bw > 24 && bw <= 48 && material == "PCRS"){
    paint = 65*quantity;

  }
  if(bl > 48 && bl <= 120 && bw > 24 && bw <= 48 && material == "PCRS"){
    paint = 130*quantity;
  }
  if(bl > 48 && bl <= 120 && bw > 48 && bw <= 60 && material == "PCRS"){
    paint = 150*quantity;
  }
  return paint;
}

function manufacturingCost(quantity, length, height){
  var cost;
  //BL is the blank or true length needed for sheet sizes
  var hemWidth = 0.5;
  var bl = (2*height + length + 2*hemWidth)+1;
  if(bl<=48){
    if(quantity == 1){
      cost = 148.68;
    }
    if(quantity > 1 && quantity < 5){
      cost = 86.28;
    }
    if(quantity >= 5 && quantity < 10){
      cost = 48.85;
    }
    if(quantity >= 10 && quantity < 25){
      cost = 36.37;
    }
    if(quantity >= 25 && quantity < 50){
      cost = 28.88;
    }
    if(quantity >= 50 && quantity < 75){
      cost = 25.74;
    }
    if(quantity >= 75 && quantity < 100){
      cost = 24.93;
    }
    if(quantity >= 100){
      cost = 24.12;
    }
  }else{
    if(quantity == 1){
      cost = 164.43;
    }
    if(quantity > 1 && quantity < 5){
      cost = 102.03;
    }
    if(quantity >= 5 && quantity < 10){
      cost = 64.60;
    }
    if(quantity >= 10 && quantity < 25){
      cost = 52.12;
    }
    if(quantity >= 25 && quantity < 50){
      cost = 44.63;
    }
    if(quantity >= 50 && quantity < 75){
      cost = 41.25;
    }
    if(quantity >= 75 && quantity < 100){
      cost = 40.45;
    }
    if(quantity >= 100){
      cost = 39.48;
    }
  }
  return cost;

}
//Takes the values from manufacturing cost and material cost and creates the final cost
function finalCost(){


  var distance = parseFloat(document.forms["mtrl_form"]["distance"].value);
  var d1 = distance*15+300;
  var d7 = distance*15+75;
  var d2 = d1 + 20;
  var gauge = document.forms["mtrl_form"]["gauge"].value;
  var diameter = document.forms["mtrl_form"]["diameter"].value;
  var length = parseFloat(document.forms["mtrl_form"]["lng"].value);
  var width = parseFloat(document.forms["mtrl_form"]["wid"].value);
  var height = parseFloat(document.forms["mtrl_form"]["hit"].value);
  var material = document.forms["mtrl_form"]["material"].value;
  var thickness = document.forms["mtrl_form"]["gauge"].value;
  var quantity = document.forms["mtrl_form"]["quantity"].value;
  var d3 = length - distance;
  var d4 = width - distance;
  var l = length * 15;
  var w = width * 15;
  var h = height * 15;
  var total_manufacturing_cost = manufacturingCost(quantity);

  var sheet_cost = parseFloat(sheetCost(length, width, height, thickness, material, quantity));
  var paint_cost = parseFloat(paint(material, height, length, width, quantity));
  console.log("Sheet: " + sheet_cost);
  console.log("Paint: " + paint_cost);
  console.log("Combined Cost: " + (sheet_cost + paint_cost));

  var sheet_cost = sheet_cost + paint_cost;

  var final = total_manufacturing_cost + sheet_cost;
  var finalPlus = final * quantity;
  var frontHeight = parseFloat(document.forms["mtrl_form"]["front_height"].value);


    if(validateForm(length, width, height, diameter, material, thickness) == false){
      validateForm(length, width, height, diameter, material, thickness);
    }else{
      document.getElementById("jb_wrap").style.display = "none";
      //document.getElementById("right").style.display = "inline";
      //document.getElementById("myCanvas2").style.display = "none";
      //document.getElementById("largePan").style.display = "none";
      //document.getElementById("sizeError").style.display = "none";
      document.getElementById("cost-container").style.display = "inline";
      //document.getElementById("clear").style.display = "inline";
      //document.getElementById("errorMaterial").style.display = "none";
      //document.getElementById("errorMessage").style.display = "none";
      //document.getElementById("pan").style.display = "none";
      if(quantity > 1){
        document.getElementById("final").innerHTML = "Individual Price: " + final.toFixed(2);
        //document.getElementById("multiple").innerHTML = "Total Price: " + finalPlus.toFixed(2);
      }else{
        document.getElementById("final").innerHTML = "Final Cost: $" + final.toFixed(2);
      }


      document.getElementById("tabs").style.display = "block";
      document.getElementById("defaultOpen").click();


    draw(width, length, height, gauge, material);
    drawHeight(height, frontHeight);
    drawHole(d1, d2, distance, d4, d3, diameter, d7);
    }



}
function displayGauge(){
  var material = document.forms["mtrl_form"]["material"].value;
  if(material == "Aluminum"){

    document.getElementById("14").innerHTML = "0.04 (1.016mm)";
    document.getElementById("18").innerHTML = "0.06 (1.63mm)";
    document.getElementById("20").innerHTML = "0.09 (2.30mm)";
  }
  if(material == "Galvanized Steel"){
    document.getElementById("14").innerHTML = "14GA (0.0785) (2mm)";
    document.getElementById("18").innerHTML = "18GA (0.0516) (1.25mm)";
    document.getElementById("20").innerHTML = "20GA (0.0396) (0.9mm)";
  }
  if(material == "Stainless Steel"){
    document.getElementById("14").innerHTML = "14GA (0.07812) (2mm)";
    document.getElementById("18").innerHTML = "18GA (0.050) (1.25mm)";
    document.getElementById("20").innerHTML = "20GA (0.0375) (0.9mm)";
  }
  if(material == "CRS" || material == "PCRS"){
    document.getElementById("14").innerHTML = "14GA (0.0747) (2mm)";
    document.getElementById("18").innerHTML = "18GA (0.0478) (1.25mm)";
    document.getElementById("20").innerHTML = "20GA (0.0359) (0.9mm)";

  }
  //document.getElementById("mtrl_gauge").style.display = "inline";

}
