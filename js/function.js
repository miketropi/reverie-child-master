function setProductCalulator() {
    var calculate_width = jQuery("#calculate_width").val();
    var calculate_length = jQuery("#calculate_length").val();
    var calculate_cost = jQuery("input[name='calculate_cost']:checked").val();

    var calculate_area_cover = jQuery("#calculate_area_cover").val();
    var calculate_area_cover_coat = jQuery("#calculate_area_cover_coat").val();

    var calculate_quantity_size = jQuery("input[name='quantity']").val();
    var calculate_attribute_pa_size = jQuery("#pa_size").val();
    if (calculate_attribute_pa_size != "" && typeof calculate_attribute_pa_size != "undefined") {
        calculate_attribute_pa_size = jQuery.trim(calculate_attribute_pa_size.replace('l', ''));
    }else{
        calculate_attribute_pa_size=1;
    }
    //alert(calculate_attribute_pa_size);
    /*---------------------------------------------------------------------*/
    var total_area_m2 = calculate_width * calculate_length;
    //var calculate_value = calculate_attribute_pa_size / total_lt_color;
    var calculate_cover_value = total_area_m2 / calculate_area_cover;

    if (calculate_area_cover_coat != "" && calculate_cost == "yes") {
        //var calculate_cover_value = calculate_value + total_area_m2 / calculate_area_cover_coat;
        calculate_cover_value = calculate_cover_value + total_area_m2 / calculate_area_cover_coat;
    }
    
    var calculate_value = calculate_cover_value; // calculate_cover_value.toFixed(1);

    var quantity_value = calculate_value / calculate_attribute_pa_size;
    //quantity_value = Math.ceil(quantity_value);

    jQuery("#calculate-value").html(quantity_value.toFixed(1));
    jQuery("input[name='quantity']").val(Math.ceil(quantity_value));

}