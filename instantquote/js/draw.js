
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

function changeSide(){
  if(document.forms["material_type_form"]["holeLocation"].value == "left" || document.forms["material_type_form"]["holeLocation"].value == "right"){
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

//Drawing function for pans accepting inputs in final function
function draw(width, length, height, gauge, material){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  var label;

  if(gauge == "14" || gauge == "12" || gauge == "19"){
    label = "14G";
  }
  if(gauge == "15" || gauge == "13" || gauge == "18"){
    label = "18G";
  }
  if(gauge == "16" || gauge == "11" || gauge == "17"){
    label = "20G";
  }

  if(material == "1"){
    material = "Stainless Steel";
    if(gauge == "14"){
      gauge = "14S";
    }
    if(gauge == "15"){
      gauge = "18S";
    }
    if(gauge == "16"){
      gauge = "20S";
    }
  }
  if(material == "2"){
    material = "Steel(RAW)";
    if(gauge == "7"){
      gauge == "14C";
    }
    if(gauge == "10"){
      gauge = "18C";
    }
    if(gauge == "9"){
      gauge = "20C";
    }
  }
  if(material == "3"){
    material = "Galvanized Steel";
  }
  if(material == "4"){
    material = "Aluminum";
    if(gauge == "19"){
      gauge = "30A";
    }
    if(gauge == "18"){
      gauge = "60A";
    }
    if(gauge == "17"){
      gauge = "90A";
    }
  }
  if(material == "5"){
    material = "Gloss White Steel(RAW)";
  }
  var sku = "KM-" + length + "-" + width + "-" + height + "-" + gauge;
  if(document.getElementById("yesHole").checked == true && document.getElementById("frontPan").checked == true){
    ctx.beginPath();
    ctx.lineWidth = "1";
    ctx.rect(300, 115, 375, 450);
    ctx.rect(300, 85, 375, 30);
    ctx.rect(300, 565, 375, 10);
    ctx.stroke();
    ctx.moveTo(300,75);
    ctx.lineTo(300, 3);
    ctx.stroke();
    ctx.moveTo(300, 10);
    ctx.lineTo(450, 10);
    ctx.stroke();
    ctx.moveTo(675, 75);
    ctx.lineTo(675, 3);
    ctx.stroke();
    ctx.moveTo(675, 10);
    ctx.lineTo(520, 10);
    ctx.stroke();
    ctx.moveTo(260, 115);
    ctx.lineTo(180, 115);
    ctx.stroke()
    ctx.moveTo(180,115);
    ctx.lineTo(180,270);
    ctx.stroke();
    ctx.moveTo(260,565);
    ctx.lineTo(180,565);
    ctx.stroke();
    ctx.moveTo(180,565);
    ctx.lineTo(180,320);
    ctx.stroke();
    ctx.moveTo(675, 115);
    ctx.lineTo(705, 115);
    ctx.stroke();
    ctx.moveTo(675, 565);
    ctx.lineTo(685, 565);
    ctx.stroke();
    ctx.moveTo(705, 115);
    ctx.lineTo(685,565);
    ctx.stroke();
    ctx.moveTo(300, 115);
    ctx.lineTo(270, 115);
    ctx.stroke();
    ctx.moveTo(270, 115);
    ctx.lineTo(290, 565);
    ctx.stroke();
    ctx.moveTo(290, 565);
    ctx.lineTo(300, 565);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 485, 15);
    ctx.fillText(length.toFixed(1) + '"', 180, 300);
    var km = document.getElementById("km");
    var img = document.getElementById("flPan");
    ctx.drawImage(img, 800, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(label + " " + material, 560, 850);
    ctx.fillText(sku, 875, 800);
  }
  if(document.getElementById("yesHole").checked == true && document.getElementById("flatPan").checked == true){
    ctx.beginPath();
    ctx.lineWidth = "1";
    ctx.rect(300, 115, 375, 450);
    ctx.rect(300, 85, 375, 30);
    ctx.rect(675, 115, 30, 450);
    ctx.rect(675, 565, -375, 30);
    ctx.rect(300, 565, -30, -450);
    ctx.stroke();
    ctx.moveTo(300, 75);
    ctx.lineTo(300, 3);
    ctx.stroke();
    ctx.moveTo(300, 10);
    ctx.lineTo(450, 10);
    ctx.stroke();
    ctx.moveTo(675, 75);
    ctx.lineTo(675, 3);
    ctx.stroke();
    ctx.moveTo(675, 10);
    ctx.lineTo(520, 10);
    ctx.stroke();
    ctx.moveTo(260, 115);
    ctx.lineTo(180, 115);
    ctx.stroke()
    ctx.moveTo(180,115);
    ctx.lineTo(180,270);
    ctx.stroke();
    ctx.moveTo(260,565);
    ctx.lineTo(180,565);
    ctx.stroke();
    ctx.moveTo(180,565);
    ctx.lineTo(180,320);
    ctx.stroke();
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    ctx.fillText(width.toFixed(1) + '"', 485, 15);
    ctx.fillText(length.toFixed(1) + '"', 180, 300);
    var km = document.getElementById("km");
    var img = document.getElementById("panD");
    ctx.drawImage(img, 800, 75);
    ctx.drawImage(km, 0, 600);
    ctx.fillText(label + " " + material, 560, 850);
    ctx.fillText(sku, 875, 800);
  }
  if(document.getElementById("frontPan").checked == true && document.getElementById("yesHole").checked == false){
    //var km = document.getElementById("km");
    //ctx.drawImage(km, 0, 200);
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
    ctx.fillText(label + " " + material, 560, 850);
    ctx.fillText(sku, 875, 800);
  }
  if(document.getElementById("flatPan").checked == true && document.getElementById("yesHole").checked == false){
    ctx.beginPath();
    //var km = document.getElementById("km");
    //ctx.drawImage(km, 0, 200);
    //ctx.lineWidth = "1";
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
    ctx.fillText(label + " " + material, 560, 850);
    ctx.fillText(sku, 875, 800);

  }
  if(document.forms["material_type_form"]["material_type"].value == "5"){


      ctx.fillText("Powder Coat: EDPS010- Gloss White", 570, 680);

/*
    if(document.getElementById("BCRS").selected == true){
      ctx.fillText("Powder Coat: EDPS006- Gloss Black", 570, 680);
    }
    if(document.getElementById("FCRS").selected == true){
      ctx.fillText("Powder Coat: EDPS066- Britebond Faux Stainless", 530, 680)
    }
    */
  }


}
function drawHole(d1, d2, d3, d4, d5, d6, d7, d8, d9){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.lineWidth = "1";
  ctx.font = "15px Arial";
  ctx.textAlign = "center";
  var holeLocation = document.forms["material_type_form"]["holeLocation"].value;
  if(document.getElementById("yesHole").checked == true){
    ctx.fillText("Hole Diameter: " + d6 + '"', 200, 15);
    switch(holeLocation){
      case "upper":
        ctx.moveTo(300, 45);
        ctx.lineTo((d1+300)/2-12, 45);
        ctx.stroke();
        ctx.moveTo(d1, 100);
        ctx.lineTo(d1, 45);
        ctx.stroke();
        ctx.moveTo(d1, 45);
        ctx.lineTo((d1+ 300)/2+12, 45);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(d1, 100, 10, 0, 2*Math.PI);
        ctx.stroke();
        ctx.fillText(d3 + '"', (d1+300)/2, 50);
        break;
      case "lower":
        ctx.moveTo(300, 600);
        ctx.lineTo(300, 625);
        ctx.stroke();
        ctx.moveTo(300, 625);
        ctx.lineTo((d1+300)/2-12, 625);
        ctx.stroke();
        ctx.moveTo(d1, 580);
        ctx.lineTo(d1, 625);
        ctx.stroke();
        ctx.moveTo(d1, 625);
        ctx.lineTo((d1+ 300)/2+12, 625);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(d1, 580, 10, 0, 2*Math.PI);
        ctx.stroke();
        ctx.fillText(d3 + '"', (d1+300)/2, 630);
        break;
      case "left":
        ctx.moveTo(250, 115);
        ctx.lineTo(250, (d7+115)/2-10);
        ctx.stroke();
        ctx.fillText(d3 + '"', 240, (d7+115)/2+10);
        ctx.stroke();
        ctx.moveTo(285, d7);
        ctx.lineTo(250, d7);
        ctx.stroke();
        ctx.moveTo(250, (d7+115)/2+10);
        ctx.lineTo(250, d7);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(285, d7, 10, 0, 2*Math.PI);
        ctx.stroke();
        break;
      case "right":

        ctx.moveTo(715, 115);
        ctx.lineTo(735, 115);
        ctx.stroke();
        ctx.moveTo(735, 115);
        ctx.lineTo(735, (d7+115)/2-15)
        ctx.fillText(d3 + '"', 735, (d7+115)/2);
        ctx.stroke();
        ctx.moveTo(690, d7);
        ctx.lineTo(735, d7);
        ctx.stroke();
        ctx.moveTo(735, (d7+115)/2+15);
        ctx.lineTo(735, d7);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(690, d7, 10, 0, 2*Math.PI);
        ctx.stroke();
        break;
      case "bottom":
        ctx.lineWidth = 1;
        ctx.moveTo(d1, 45);
        ctx.lineTo(d1, d8);
        ctx.stroke();
        ctx.moveTo(d1, 45);
        ctx.lineTo((d1+300)/2+10, 45);
        ctx.stroke();
        ctx.moveTo(300, 45);
        ctx.lineTo((d1+300)/2-10, 45);
        ctx.stroke();
        ctx.moveTo(240, d8);
        ctx.lineTo(d1, d8);
        ctx.stroke();
        ctx.moveTo(240, d8);
        ctx.lineTo(240, (d8+115)/2+10);
        ctx.stroke();
        ctx.moveTo(240, 115);
        ctx.lineTo(240, (d8+115)/2-10);
        ctx.stroke();
        ctx.fillText(d3 +'"', (d1+300)/2, 35);
        ctx.stroke();
        ctx.fillText(d9 + '"', 230, (d8+115)/2+5);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(d1, d8, 10, 0, 2*Math.PI);
        ctx.stroke();
        break;
    }
  }
}
function drawHeight(x, y){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.strokeStyle = "black";
  ctx.font = "15px Arial";
  ctx.textAlign = "center";
  if (document.getElementById("flatPan").checked == true) {
    ctx.beginPath();
    ctx.lineWidth = 1;
    ctx.rect(60, 75, 40, 450);
    ctx.stroke();
    ctx.beginPath();
    ctx.lineWidth = 0.75;
    ctx.moveTo(60, 530);
    ctx.lineTo(60, 560);
    ctx.stroke();
    ctx.beginPath();
    ctx.lineWidth = 0.75;
    ctx.moveTo(100, 530);
    ctx.lineTo(100, 560);
    ctx.stroke();
    ctx.beginPath();
    ctx.lineWidth = 0.75;
    ctx.moveTo(60, 560);
    ctx.lineTo(70, 560);
    ctx.stroke();
    ctx.beginPath();
    ctx.lineWidth = 0.75;
    ctx.moveTo(100, 560);
    ctx.lineTo(90, 560);
    ctx.stroke();
    ctx.beginPath();
    ctx.fillText(x + '"', 80, 565);
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
    ctx.moveTo(60, 70);
    ctx.lineTo(60, 50);
    ctx.stroke();
    ctx.moveTo(60, 50);
    ctx.lineTo(70, 50);
    ctx.stroke();
    ctx.moveTo(100, 70);
    ctx.lineTo(100, 50);
    ctx.stroke();
    ctx.moveTo(100, 50);
    ctx.lineTo(90, 50);
    ctx.stroke();
    ctx.moveTo(85, 530);
    ctx.lineTo(85, 545);
    ctx.stroke();
    ctx.moveTo(85, 545);
    ctx.lineTo(91, 545);
    ctx.stroke();
    ctx.moveTo(100, 530);
    ctx.lineTo(100, 545);
    ctx.stroke();
    ctx.moveTo(100, 545);
    ctx.lineTo(94, 545);
    ctx.stroke();
    ctx.fillText(x + '"', 81, 55);
    ctx.fillText(y + '"', 92.5, 560);
  }
}

function download(){
  var height = parseFloat(document.forms["material_type_form"]["hit"].value);
  var length = parseFloat(document.forms["material_type_form"]["lng"].value);
  var width = parseFloat(document.forms["material_type_form"]["wid"].value);
  var gauge = document.forms["material_type_form"]["thickness"].value;
  var material = document.forms["material_type_form"]["material"].value;
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

//Takes the values from manufacturing cost and material cost and creates the final cost
function finalCost(){

  var length = parseFloat(document.forms["material_type_form"]["attribute_L"].value);
  var width = parseFloat(document.forms["material_type_form"]["attribute_W"].value);
  var height = parseFloat(document.forms["material_type_form"]["attribute_H"].value);
  var distance = parseFloat(document.forms["material_type_form"]["distance"].value);
  var distance2 = parseFloat(document.forms["material_type_form"]["distance2"].value);
  var d9 = (distance2/length *450)+115;
  var d1 = (distance/width * 375)+300;
  var d7 = (distance/length * 450)+115;
  var d2 = d1 + 20;

  var diameter = document.forms["material_type_form"]["diameter"].value;

  var gauge = document.forms["material_type_form"]["material_size_id"].value;
  var material = document.forms["material_type_form"]["material_type"].value;
  var thickness = document.forms["material_type_form"]["material_size_id"].value;
  var quantity = document.forms["material_type_form"]["material_qty"].value;

  var d3 = length - distance;
  var d4 = width - distance;
  var l = length * 15;
  var w = width * 15;
  var h = height * 15;
  var frontHeight = parseFloat(document.forms["material_type_form"]["front_height"].value);
      document.getElementById("jb_wrap").style.display = "none";
      document.getElementById("tabs").style.display = "block";
      document.getElementById("defaultOpen").click();
    draw(width, length, height, gauge, material, distance2);
    drawHeight(height, frontHeight);
    drawHole(d1, d2, distance, d4, d3, diameter, d7, d9, distance2);
}
