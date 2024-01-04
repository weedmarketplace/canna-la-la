 /**=====================
     Quantity 2 js
==========================**/
$( document ).on( "click", ".addcart-button", function(e) {
    //  $(".addcart-button").click(function () {
        $(this).next().addClass("open");
        $(this).next().find(".qty-input").val('1');
        //  $(".add-to-cart-box .qty-input").val('1');
    });
    
    $( document ).on( "click", ".add-to-cart-box", function(e) {
//  $('.add-to-cart-box').on('click', function () {
     var $qty = $(this).siblings(".qty-input");
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal)) {
         $qty.val(currentVal + 1);
     }
 });

 $( document ).on( "click", ".qty-left-minus", function(e) {
//  $('.qty-left-minus').on('click', function () {
     var $qty = $(this).siblings(".qty-input");
     var _val = $($qty).val();
     if (_val == '1') {
         var _removeCls = $(this).parents('.cart_qty');
         $(_removeCls).removeClass("open");
     }
     var currentVal = parseInt($qty.val());
     if (!isNaN(currentVal) && currentVal > 0) {
        if($qty.attr('min') && currentVal <= $qty.attr('min')){
            return false;
        }
        $qty.val(currentVal - 1);
     }
 });

 $( document ).on( "click", ".qty-right-plus", function(e) {
//  $('.qty-right-plus').click(function () {
    //  if ($(this).prev().val() < 9) {
        // console.log($(this).data('max-qty'));
        // console.log($(this).prev().val());
         $(this).prev().val(+$(this).prev().val() + 1);
    //  }
 });