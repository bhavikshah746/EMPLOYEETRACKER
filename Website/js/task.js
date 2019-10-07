
//When dashboard the page has loaded.
$(document).ready(function(){
    loadTable();
});

 function loadTable(taskStatus = "ongoing"){
    //Perform Ajax request.
    
    $.ajax({
        dataType: "json",
        url: 'AppOperation.php',
        type: 'POST',
        data: {ActionType:"getPortalTasks", TaskStatus: taskStatus},
        success: function(response){
            
            //If the success function is execute,
            //then the Ajax request was successful.
            //Add the data we received in our Ajax
            //request to the "content" div.
            var dataArray = response;
            createTable(dataArray["taskData"], "taskTbl");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            
          }
    });
 }
//a common function to create table
//parameters are data object, table name respectively
function createTable(dataObj,tblName){
    
    var tbl = $("#"+tblName);
    $("#"+tblName+ " tbody").empty();
    for(taskID in dataObj){        
        //console.log(dataObj[emp]);
        //creating new tr for user table
        
        var tr = $("<tr></tr>").attr("id",taskID);

        /*creating new table data column for each user */
        console.log(0);
        var taskNametd = $("<td></td>");
        taskNametd.html(dataObj[taskID].taskname);
        tr.append(taskNametd);

        var taskAssignedTo = $("<td></td>");
        taskAssignedTo.html(dataObj[taskID].task_assigned_to);
        tr.append(taskAssignedTo);

        var taskAssignedBy = $("<td></td>");
        taskAssignedBy.html(dataObj[taskID].task_assigned_by);
        tr.append(taskAssignedBy);
        
        var date_task_created = $("<td></td>");
        date_task_created.html(dataObj[taskID].date_created);
        tr.append(date_task_created);
        
        var date_task_started = $("<td></td>");
        date_task_started.html(dataObj[taskID].task_started_date);
        tr.append(date_task_started);
        
        var actions = $("<td></td>");
        
        var aLinkEdit = $("<a></a>").attr("href","#");
        var aLinkDeactive = $("<a></a>").css({"cursor":"pointer","color":"royalblue"}).attr("onClick","deleteUser("+taskID+")","href","");
        
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

