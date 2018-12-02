//fires the script after the dom ready
jQuery(document).ready(function ($) {
    console.log('hit inventory.js file');

    function showValues() {
        var form_values = $('form#inventory_form').serializeArray();
        // console.log(form_values);
        var quantity    = form_values[1].value;
        var unit_price  = form_values[3].value;
        var discount  = form_values[4].value;

        var tax = (quantity * unit_price) * 15 /100;
        var total_price = (quantity * unit_price) + tax - discount;

        $('#tax_amount').text(tax);
        $('#total').text(total_price);
    }

    $( "input[type='checkbox'], input[type='radio']" ).on( "click", showValues );
    $( "select, input[type='text'], input[type='number']",  ).on( "keyup", showValues );
    showValues();

});//end of document ready function