//fires the script after the dom ready
jQuery(document).ready(function ($) {
console.log('hit main.js file');


$('.table tbody').on('click', '#view_btn', function () {
    // console.log('button clicked');
    var currow = $(this).closest('tr');

    var quantityValue = $('input#quantity').val();
    var itemValue = $('input#item').val();
    var descriptionValue = $('input#description').val();
    var unitPriceValue = $('input#unit_price').val();
    var taxValue = $('input#tax').val();

    //total price calculation
    var total = quantityValue * unitPriceValue ;
    var tax = 15 * total / 100;
    total = total + tax;

    // console.log(total);

    // console.log(quantityValue + "" + itemValue + "" + descriptionValue + "" + unitPriceValue + "" + taxValue);

    var col1 = currow.find('td:eq(0)').text();
    var col2 = currow.find('td:eq(1)').text();
    var col3 = currow.find('td:eq(2)').text();
    var col4 = currow.find('td:eq(3)').text();
    var col5 = currow.find('td:eq(4)').text(tax);
    var col6 = currow.find('td:eq(5)').text(total);

    $('#subtotal').text(total);

    // var result = col1 + '/n' + col2 + '/n' + col3 + '/n' + col4  + '/n' + col5;
    // alert(col1.val());
    // var col1 = currow.find('td:eq(5)').text();

});//end of view button function

// $('#add_item').on('click', function () {
//     var ele = $('#input_row').clone(true);
//     $('#input_row').after(ele);
// });//end of add_item click button function


    // //Get
    // var bla = $('#txt_name').val();
    //
    // //Set
    // $('#txt_name').val(bla);

});//end of document ready function