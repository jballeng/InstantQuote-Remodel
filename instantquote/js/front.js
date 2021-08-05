/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

var relProSwiper = {};
      $(document).ready(function () {
          $('body').on('keydown', '.roundto2', function (evt) {
              decimals = 3;
              var n = $(this).val();
              var charCode = (evt.which) ? evt.which : event.keyCode
              //num = n.replace(/[^0-9\.]/g, '');
              removedcodes = [8, 9, 13, 16, 17, 18, 20, 27, 32, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145, 19];

              if (!(removedcodes.indexOf(charCode) > -1)) { //&&  charCode != 48 &&  charCode != 96
                  //var num = Math.round(num * 100) / 100
                  var dotPos = n.indexOf('.');
                  if (dotPos > 0 && n.substring(dotPos, n.length).length > decimals) {
                      evt.preventDefault();
                  }
              }

          });
          setTimeout(function(){materialChange();}, 400);
          $('#nextStep2').on("click", function () {
              var shapeId = $('input:radio[name=shapeType]:checked').val();
              $.ajax({
                  url: base_url + 'module/instantquote/priceEngine',
                  type: 'post',
                  data: {shapeId: shapeId, ajax: true, methode: "shape_details"},
                  success: function (res) {
                      $('#step2').html(res);
                      $('#step1').hide();
                  }
              });
          });
          $("#material_type_form").validate();
          $('body').on('click', '#backtomaterials', function () {
              $('#step2').show();
          });
          function materialChange(mSizeId) {
              var material_type_id = $('#material_type_id').val();
              var shapeId = $("#shapeId").val();
              $("#material_size_id").html($("<option></option>").attr("value", "").text("Please Select"));
              $.ajax({
                  url: base_url + 'module/instantquote/priceEngine',
                  type: 'post',
                  data: {material_type_id: material_type_id, shapeId: shapeId, ajax: true, methode: "meterial_design"},
                  success: function (res) {

                      obj = $.parseJSON(res);
                      if (obj.status == 'error') {
                          console.log("Error");
                      } else {
                          var itemlist = obj.data;
                          $.each(itemlist, function (index, item) {
                              if ((mSizeId) && (item.id_iq_material_size == mSizeId)) {
                                  $("#material_size_id").append($("<option></option>").attr("value", item.id_iq_material_size).text(item.display_name).attr("selected", "selected"));
                              } else {
                                  $("#material_size_id").append($("<option></option>").attr("value", item.id_iq_material_size).text(item.display_name));
                              }
                          });
                      }
                      $("#material_size_id").trigger('change');
                  }
              });
          }

          suggesteProdAjax = null;

          function getProductSuggetion() {
              var l = $('#attribute_L').val();
              var h = $('#attribute_H').val();
              var w = $('#attribute_W').val();
              if (suggesteProdAjax != null) {
                  suggesteProdAjax.abort();
              }
              $('#iq_suggested_product').html("");
              suggesteProdAjax = $.ajax({
                  url: base_url + 'module/instantquote/productSuggestion',
                  type: 'post',
                  data: {ajax:true,length:l,height:h,width:w},
                  success: function (res) {
                      obj = $.parseJSON(res);
                      if(obj.status) {

                          $('#iq_suggested_product').html(obj.preview);
                          initializeSwiperSuggestedProd();
                      } else {

                          $('#iq_suggested_product').html("");
                      }
                  }
              });
          }

          priceAjax = null;
          function getPrice() {

              var formdata = $('#material_type_form').serialize();

              if (priceAjax != null) {
                  priceAjax.abort();
              }

              priceAjax = $.ajax({
                  url: base_url + 'module/instantquote/priceEngine',
                  type: 'post',
                  data: formdata,
                  success: function (res) {
                      $('#price_display_value').html("");
                      $('#spanskuValue').html("");
                      $('#addtocart').hide();
                      $('#spanFinalPrice').hide();
                      $('#spansku').hide();
                      $(".error").remove();
                      $('#warnings').html('');
                      obj = $.parseJSON(res);




                      if (obj.warnings) {
                          $.each(obj.warnings, function (index, item) {
                              $('#warnings').append('<div class="warning">' + item + '</div>');
                          });
                      }

                      if (obj.commends) {
                          $.each(obj.commends, function (index1, item1) {

                              if (item1.swap) {
                                  $.each(item1.swap.arg, function (index, item) {
                                      var indexVal = $('[name="' + index + '"]').val();
                                      var itemVal = $('[name="' + item + '"]').val();
                                      $('[name="' + index + '"]').val(itemVal);
                                      $('[name="' + item + '"]').val(indexVal);

                                      var hasFocusindex = $('[name="' + index + '"]').is(':focus');
                                      var hasFocusitem = $('[name="' + item + '"]').is(':focus');

                                      if (hasFocusindex || hasFocusitem) {

                                          if (hasFocusindex)
                                              $('[name="' + item + '"]').focus();
                                          else if (hasFocusitem)
                                              $('[name="' + index + '"]').focus();
                                      }
                                  });
                              }
                          });
                      }




                      if (obj.isError == true) {
                          if (obj.fieldErrors) {
                              $.each(obj.fieldErrors, function (index, item) {
                                  $('[name="' + index + '"]').after('<div class="error">' + item + '</div>');
                              });
                          }

                          if (obj.errors) {
                              $.each(obj.errors, function (index, item) {
                                  $('#extraerrors').append('<div class="error">' + item + '</div>');
                              });
                          }
                      } else {


                          var result_data = obj.data;

                          $('#spanskuValue').html(result_data.sku);
                          $('#spanstockcheck').html(result_data.stock);
                          $('#productWeight').val(result_data.weight);

                          if (result_data.discounted_price) {
                              $('#discounted_display_price').removeClass('hide').html("$" + result_data.discounted_price);
                              $('#display_price').addClass('old_price')
                          }
                          $('#display_price').html("$" + result_data.price);

                          $('#addtocart').show();
                          $('#spanFinalPrice').show();
                          $('#spansku').show();
                          var c = document.getElementById("myCanvas");
                          var ctx = c.getContext("2d");
                          ctx.fillText(result_data.sku, 700, 800);
                      }
                  }
              });
          }



          var timer = 0;
          function validate() {
              var formValidated = true;
              $("#material_type_form input:text,#material_type_form select").each(function (index) {
                  if (!$(this).val()) {
                      formValidated = false;
                      return false;
                  }
              });
              if (formValidated) {
                  allInputGiven = true;
              }

              if (allInputGiven) {


                  if (timer != 0)
                      clearTimeout(timer);

                  timer = setTimeout(function () {
                      getPrice();
                  }, 250);
              }
          }

          var allInputGiven = false;
          $('body').on("keyup", '#material_type_form input', function () {
              $("#material_type_form")
              if( $('#attribute_W').val() &&  $('#attribute_L').val()&&  $('#attribute_H').val() && $('#attribute_W').val()>0 && $('#attribute_H').val()>0 && $('#attribute_L').val()>0) {
                  getProductSuggetion();
              }
              validate();
          });
          $('body').on("change", '#material_type_form select', function () {
              validate();
          });

          $('body').on("click", '#addtocart', function () {
              var sku = $('#spanskuValue').html();
              var shapeName = $('#shapeNameHiden').val();
              var qty = $('#material_qty').val();
              var shapeId = $("#shapeId").val();
              var productWeight = $("#productWeight").val();
              $.ajax({
                  url: base_url + 'module/instantquote/product',
                  type: 'post',
                  data: {sku: sku, shapeName: shapeName,material_qty:qty, qty: qty, shapeId: shapeId, productWeight: productWeight, methode: 'cart', ajax: true},
                  success: function (res) {

                      obj = $.parseJSON(res);
                      if (obj.status == 'error') {
                          //console.log("Error");
                          $('#extraerrors').append('<div class="error">Some technical issue occurred, Please try after sometime ...</div>');
                          $("#extraerrors").show();
                      } else {
                              $("#extraCartBtn a").data('id-product',obj.data.productId);
                              $("#extraCartBtn a").data('minimal-quantity',$("#material_qty").val());
                              setTimeout(function(){
                                  $(".ajax_add_to_cart_button").trigger("click");
                                  $( "#extraCartBtnChild" ).click();
                              })
                      }
                  },
                  beforeSend:function(){
                      $("#addtocart").addClass('active disabled');
                  },complete: function (jqXHR, textStatus) {
                        $("#addtocart").removeClass('active');
                        $("#addtocart").removeClass('disabled');


              }
              });
          });


          //material type
          var materialTypeID = $('#material_type_id').val();
          if (materialTypeID != "") {
              materialChange(skuMaterialSizeId);
          }

          $('body').on('change', '#material_type_id', function () {
              materialChange();
          });
      });

      function initializeSwiperSuggestedProd(){
               relProSwiper = new Swiper('.suggested_products_container .pro_gallery_suggested_prod', {
              id_st: '.pro_gallery_suggested_prod',
              spaceBetween: 10,
              slidesPerView: 4,
              nextButton: '.pro_gallery_suggested_prod .swiper-button-next',
              prevButton: '.pro_gallery_suggested_prod .swiper-button-prev',
              loop: false,
              slideToClickedSlide: true,
              watchSlidesProgress: true,
              watchSlidesVisibility: true,
              breakpoints: {
                  1600: {
                  slidesPerView: 4,
                  spaceBetween: 20,
                  },
                  1440: {
                  slidesPerView: 4,
                  spaceBetween: 20,
                  },
                  1200: {
                  slidesPerView: 3,
                  spaceBetween: 20,
                  },
                  992: {
                  slidesPerView: 3,
                  spaceBetween: 20,
                  },
                  768: {
                  slidesPerView: 2,
                  spaceBetween: 20,
                  },
                  480: {
                  slidesPerView: 1,
                  spaceBetween: 20,
                  },
              },
              onSlideChangeEnd: function(swiper){
                if(typeof($('.pro_gallery_suggested_prod ')[0].swiper)!=='undefined')
                  $('.pro_gallery_suggested_prod ')[0].swiper.slideTo(swiper.activeIndex);
              },
              onInit : function (swiper) {
                  if($(swiper.slides).length==$(swiper.slides).filter('.swiper-slide-visible').length)
                  {
                      $(swiper.params.nextButton).hide();
                      $(swiper.params.prevButton).hide();
                  }
                  else
                  {
                      $(swiper.params.nextButton).show();
                      $(swiper.params.prevButton).show();
                  }
              },
              onClick: function(swiper){
              },
              roundLengths: true,
              lazyLoading: true,
              lazyLoadingInPrevNext: true,
              lazyLoadingInPrevNextAmount: 2,
              initialSlide: 0
          });
          setTimeout(function(){relProSwiper.update();}, 400);

      }
