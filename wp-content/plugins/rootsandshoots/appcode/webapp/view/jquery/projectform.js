
jQuery(document).ready(function () {

    //1. validation max number of projecttypes
    jQuery(".uniform_pt").change(function () {
        var max = 3;
        if (jQuery(".uniform_pt:checked").length == max) {
            jQuery(".uniform_pt").attr('disabled', 'disabled');
            alert('only 3 project types');
            jQuery(".uniform_pt:checked").removeAttr('disabled');
        }
        else {
            jQuery(".uniform_pt").removeAttr('disabled');
        }
    });

    //2. validatie min number of projecttypes and targetgroups
    jQuery('#frmProject').submit(function () {
        if (jQuery(".uniform_pt:checked").length == 0) 
        {
            alert('Please, choose at least one project type.');
            return false;
        }
        else 
        {
            if (jQuery(".uniform_tg:checked").length == 0) 
            {
                alert('Please, choose at least one target group.');
                return false;
            }
            else 
            {
                return true;
            }
        }
    });

    //3. hide red bar
    jQuery("#closeinfo").click(function () {
        jQuery("#redbar").hide();
    });
    
    //4. ajax test
    jQuery('#btnMemberSave').click(function(){
    	alert('hi');
    	
    });

});             //einde ready event

            
function refreshNotes(){
	alert('hi');
}


