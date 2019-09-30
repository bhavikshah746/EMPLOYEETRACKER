//JS File for login functions and actions

function login_Validation(){
    uname = $("#username").val();
    password = $("#password").val();

    if(uname=='' || password ==''){ 
       
       $("#msgBox").css("display","");
       $("#alertMsg").html("<strong>Oops!</strong> Username Or Password not entered.!");
       
    }else{

        uName = $("#username").val();
        pass = $("#password").val();

        //Data = {ActionType:"checkLogIn", logInType: "portalLogin",userName : uName, passWord:pass}; 
        //jsonData = JSON2.stringify(Data);

        $.ajax({    
            dataType:"json",
            url: "AppOperation.php",
            type:"POST",
            data: {ActionType:"checkLogIn", logInType: "portalLogin",username : uName, password:pass}, 
            success: function(response){
                
                //if error the notify user about it else redirect to dashboard page
                if(response["error"] == true){
                    $("#msgBox").css("display","");
                    $("#alertMsg").html(response["Msg"]);

                }else{
                   var url = "dashboard.php";
                   $(location).attr('href',url);

                }
            },
            error: function(xhr, ajaxOptions){

            },
        });
    }

}
