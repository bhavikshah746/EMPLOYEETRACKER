//funtion to upadte location, latitute & longitude value in parent window
function SaveLocation(){   
    if(opener){
        
        opener.$("#lat").val($("#lat").val());
        
        opener.$("#lng").val($("#lng").val());

        addr="";

        if(("#street_number").length)
            addr = $("#street_number").val();

        if($("#route").length)
            addr+= " "+route;

        opener.$("#streetAddress").val(addr);


        if($("#locality").length)
            opener.$("#locality").val($("#locality").val());
        
        if($("#administrative_area_level_2").length)
            opener.$("#administrative_area_level_2").val($("#administrative_area_level_2").val());

        if($("#administrative_area_level_1").length)
            opener.$("#administrative_area_level_1").val($("#administrative_area_level_1").val());


        if($("#postal_code").length)
            opener.$("#postal_code").val($("#postal_code").val());

        opener.$("#location").html($("#location").val());
        window.close();
    }
}
