
dataObj =[]; //create a Global Object to store Data
dataID =""; //to store the record ID

//Array of all fields of form element [To enable edit mode when user clicks edit profile option]
fieldsArray = ["fName","lName","uName","DOB","gender","mobile","email","addr1","addr2","pCode","city","state","btnSubmit"];

//When dashboard the page has loaded.
$(document).ready(function(){
    
    //Perform Ajax request.
    $.ajax({
        dataType: "json",
        url: 'AppOperation.php',
        type: 'POST',
        data: {ActionType:"getProfileData"},
        success: function(response){
            
            //If the success function is execute,
            //then the Ajax request was successful.
            //Add the data we received in our Ajax
            //request to the "content" div.
            
            //Assign response to dataObj which is Global object
            dataObj = response["empData"];
            setProfile();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            
          }
    });



});

 
//a common function to create table
//parameters are data object, table name respectively
function setProfile(){

    for(empID in dataObj){        

        //function call to set first name in form
        fn_set_field_value(empID,"fName");

        //call to function set value the last name in form
        fn_set_field_value(empID,"lName");

        //call to function set value of user name in form
        fn_set_field_value(empID,"uName");

        //call to function set value of DOB in form
        fn_set_field_value(empID,"DOB");

        //call to function set value of gender in form
        fn_set_field_value(empID,"gender");

        //call to function set value of mobile in form
        fn_set_field_value(empID,"mobile");

        //call to function set value of email in form
        fn_set_field_value(empID,"email");

        //call to function set value of address1 in form
        fn_set_field_value(empID,"addr1");

        //call to function set value of address2 in form
        fn_set_field_value(empID,"addr2");

        //call to function set value of postcode in form
        fn_set_field_value(empID,"pCode");

        //call to function set value of city in form
        fn_set_field_value(empID,"city");
  
        //call to function set value of state in form
        fn_set_field_value(empID,"state");
        dataID = empID;
    }
}


//function condition to check the data value & assign it to filed value 
function fn_set_field_value(empID,fieldID){
    
    if((dataObj[empID][fieldID]) && dataObj[empID][fieldID]!=""){
    
        if(fieldID == "gender"){
            if(dataObj[empID][fieldID] == "M"){
                $("maleRadio").prop("checked",true);
            }else{
                $("femaleRadio").prop("checked",true);
            }
        }else if(fieldID == "state") {console.log(fieldID);
            state = dataObj[empID][fieldID]
            $("#state option[value="+state+"]").prop("selected",true);
        }else{        
            $("#"+fieldID).val(dataObj[empID][fieldID]);
            
        }   
    }
    $("#"+fieldID).attr("disabled","disabled");
}

//function to enable profile edit mode
function fn_enable_edit(){
    $.each(fieldsArray, function(index, value){
        if(value!="uName")
            $("#"+value).prop("disabled",false);
    });
}

//function to Save details of user after update
function fn_save_profile(){

    validateForm(); //function call to validate form values

    updateArr = [];

    $.each(fieldsArray, function(index, value){
        
        if(value == "gender"){
            newVal = $("input[name='gender']:checked").val();
        }else if (value=="state"){
            newVal = $("#state option:selected").val();
        }else{
            newVal = $("#"+value).val();
        }
        
        if(newVal != dataObj[dataID][value]){
            updateArr ["value"] = newVal;
        }
    });
    
}

//A function call to validate form values
function validateForm(){
    $.each(fieldsArray, function(index, value){
        
        if(value == "gender"){
            newVal = $("input[name='gender']:checked").val();
        }else if (value=="state"){
            newVal = $("#state option:selected").val();
        }else{
            newVal = $("#"+value).val();
        }
        
        if($("#value").val()==""){
            //
        }
    });
}