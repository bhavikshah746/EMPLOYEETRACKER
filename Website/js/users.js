
//When dashboard the page has loaded.
$(document).ready(function(){
    
    //Perform Ajax request.
    $.ajax({
        dataType: "json",
        url: 'AppOperation.php',
        type: 'POST',
        data: {ActionType:"getEmployeeData"},
        success: function(response){
            
            //If the success function is execute,
            //then the Ajax request was successful.
            //Add the data we received in our Ajax
            //request to the "content" div.
            var dataArray = response;
            createTable(dataArray["Data"], "userTbl");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            
          }
    });



});

 
//a common function to create table
//parameters are data object, table name respectively
function createTable(dataObj,tblName){
    
    var tbl = $("#"+tblName);
  
    for(emp in dataObj){        
        //console.log(dataObj[emp]);
        //creating new tr for user table
        
        var tr = $("<tr></tr>").attr("id",emp);

        /*creating new table data column for each user */

        var empNametd = $("<td></td>");
        empNametd.html(dataObj[emp].fName+" "+dataObj[emp].lName);
        tr.append(empNametd);

        var empUserID = $("<td></td>");
        empUserID.html(dataObj[emp].uName);
        tr.append(empUserID);

        var empMobile = $("<td></td>");
        empMobile.html(dataObj[emp].mobile);
        tr.append(empMobile);
        
        var empEmail = $("<td></td>");
        empEmail.html(dataObj[emp].mailID);
        tr.append(empEmail);
        
        var actions = $("<td></td>");
        
        var aLinkEdit = $("<a></a>").attr("href","#");
        var aLinkDeactive = $("<a></a>").css({"cursor":"pointer","color":"royalblue"}).attr("onClick","deleteUser("+emp+")","href","");
        
        var iLinkEdit = $("<i></i>").addClass("mdi mdi-account-details menu-icon mdi-24px");
        var iLinkDeactive = $("<i></i>").addClass("mdi mdi-delete menu-icon mdi-24px");
        
        //Appending i tag to the anchor tag//
        aLinkEdit.append(iLinkEdit);
        aLinkDeactive.append(iLinkDeactive);

        //appending achor tag to the Action TD
        actions.append(aLinkEdit); 
        actions.append("&emsp;&emsp;")
        actions.append(aLinkDeactive); 
        /*End creating data column*/
        
        tr.append(actions);
        /*End appending table data */
        
        tbl.append(tr);        
    }
}

//A function to delete user

function deleteUser(id){
    
    $.ajax({
        data:{"ActionType":"deleteEmp","delete":id},
        dataType:"json",
        url: "AppOperation.php",
        method: "POST",
        success: function(response){
            if(response["error"]== "false" && response["operation"] == "success"){
                alert("Record deleted successfully.")
            }
        },
        error: function(xhr){

        }
    });
}

