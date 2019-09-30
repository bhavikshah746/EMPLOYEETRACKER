
//When dashboard the page has loaded.
$(document).ready(function(){
    
    //Perform Ajax request.
    $.ajax({
        dataType: "json",
        url: 'AppOperation.php',
        type: 'POST',
        data: {ActionType:"getDashboardData",},
        success: function(response){
            
            //If the success function is execute,
            //then the Ajax request was successful.
            //Add the data we received in our Ajax
            //request to the "content" div.

            var dataArray = (response);
            getData(dataArray);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            
          }
    });



});

//function to add data to the tables Recently added task and Completed Task
function getData(JSONData){
    
    var Data = JSONData["Data"];

    if(typeof Data.recentTask!=="undefined"){
        createTable(Data.recentTask,"recentTaskTbl");
    }

    if(typeof Data.completedTask!=="undefined"){
        createTable(Data.completedTask,"completedTaskTbl");
    }
}
 
//a common function to create table
//parameters are data object, table name respectively
function createTable(dataObj,tblName){

    var tbl = $("#"+tblName);

    for(task in dataObj){        
       
        for(taskElement in task){
           
            var tr = document.createElement("tr");

            var empNametd = document.createElement("td");
            empNametd.innerHTML= dataObj[task].user;

            var taskNametd = document.createElement("td");
            taskNametd.innerHTML= dataObj[task].taskName;

            var taskIDtd = document.createElement("td");
            taskIDtd.innerHTML= dataObj[task].taskCreated;       
            
            tr.appendChild(empNametd);
            tr.appendChild(taskNametd);
            tr.appendChild(taskIDtd);
            tbl.append(tr);
       }  
    }
}

