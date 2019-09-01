//JS File for login functions and actions

function login_Validation(){
    uname = $("#username").val();
    password = $("#password").val();

    if(uname=='' || password ==''){
        alert("Username Or Password not entered.!");
    }

}
