function fn_save_task(){

    var task_Name = $("#taskName").val()
    var task_details = $("#taskDetails").val()
    var user_id = $("#userSelect").children(":selected").attr("id")
    var lat = $("#lat").val();
    var lng = $("#lng").val();
    var location_address = $("#location").text();
    var street_address = $("#streetAddress").val();
    var locality = $("#locality").val();
    var area_lev2 = $("#administrative_area_level_2").val();
    var area_lev1 = $("#administrative_area_level_1").val();
    var post_code = $("#postal_code").val();

   if(task_Name ==""){
        alert("Please add Task Name"); return;
    }

    if(task_details ==""){
        alert("Please add Task Details"); return;
    }

    if(user_id == "" || user_id == 0 || !Number(user_id)){
        alert("Invalid value provided. Please try again");return;
    }
    

    if(lat=="" || lng=="" || location_address== ""){
        alert("Please select a Location for task.");return;
    }

    if(!Number(lat) || !Number(lng)){
        alert("Invalid value provided. Please try again");return;
    }
   
    var taskData = {ActionType:"AddTask", 
                    taskName:task_Name, 
                    taskDetails:task_details, 
                    lat: lat, lng:lng,
                    userID: user_id,
                    streetAddress:street_address,
                    suburb:locality,
                    city :area_lev2,
                    State:area_lev1,
                    postal_code:post_code
                   };
    
    $.ajax({
        dataType: "json",
        url: 'AppOperation.php',
        type: 'POST',
        data: taskData,
        success: function(response){
            
            //If the success function is execute,
            //then the Ajax request was successful.
            //Add the data we received in our Ajax
            //request to the "content" div.
            alert(JSON.stringify(response["Msg"]));
            $(location).attr('href','task.php');

        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            
          }
    });    
}