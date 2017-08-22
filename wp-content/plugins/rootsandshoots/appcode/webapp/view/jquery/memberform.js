//btns save en update in jquery wisselen


jQuery(document).ready(function () {
	
    //1. hide red bar
    jQuery("#closeinfo").click(function () {
        jQuery("#redbar").hide();
    });
    
    //2. ajax test javascript
    /*
    jQuery('#btnNotesUpdate,#btnNotesSave').click(function(){
    	
    	var notes = jQuery('#notes').val();
    	alert(notes);	
    	var userId = jQuery('#userId').val();
       	alert('userId: ' + userId);
    	
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
             	alert(xmlhttp.readyState);
               	alert(xmlhttp.status);
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    	alert(xmlhttp.responseText);
                        document.getElementById("notes").innerHTML = xmlhttp.responseText; 
                        
                    }
        };
              
        xmlhttp.open("GET", "http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/view/ajax.php?notes=" + notes + "&userid=" + userId, true); 
        xmlhttp.send();//noodzaakt get methode
        });
    */
    
    
   
   //3. ajax test jquery
   
    jQuery('#btnNotesUpdate,#btnNotesSave').click(function(){
    	
    	var notes = jQuery('#notes').val();
    	alert(notes);	
    	var userId = jQuery('#userId').val();
       	alert('userId: ' + userId);
       	
       	var response = jQuery.ajax({
       		type: "GET",
       		url: "http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/view/ajaxjquery.php?q=" + notes,
       		data: "jan",
        	success: myCallback,
            error: function(jqXHR, textStatus, errorThrown)
             {
        		console.log(JSON.stringify(jqXHR));
        		console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
 			}
      	}).responseText;
        	alert("response: " + response);
        	
   		 });//einde click
    
   
    //data: Data to be sent to the server. It is converted to a query string, if not already a string. It's appended to the url for GET-requests. Misschien ook string van JSON.
   	
   
   

	});             //einde ready event

            

function myCallback(result){
	alert('result: ' + result);
}

