$(document).ready(function () {
    calculateMaterialPrice();
    $('.field_mt_size').on("change blur", function () {
        calculateMaterialPrice();
    });
});

function calculateMaterialPrice() {
    var material_type = $('#material_type_id').val();
    var thickness = $('#material_thickness').val();
    $.ajax({
        url: instant_quote_module,
        type: "POST",
        data: 'material_type=' + material_type +
                '&thickness=' + thickness,
        success: function (response) {
            $('#material_price').val(response);
        }
    });
}
