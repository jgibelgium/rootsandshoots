function removeProject()
{
         alert('arrived');
                var btnid = jQuery(this).attr("id"); //attribuut lezen in jQuery
                var id = btnid.substring(16);
                alert(id);
            var r = confirm("Remove project?");
                if(r == true)
                {
                     window.location.href = 'http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/project.control.php?projectid=' + id;
                }
}    


jQuery(document).ready(function () {

    //1. snel sorteren dankzij de expando sortKey
    var tabel = jQuery("#documentenTabel");
    jQuery('th', tabel).each(function (columnIndex) {
        if (jQuery(this).is('.sorteer')) {
            var col = this;
            jQuery(this).click(function () {
                var rijen = tabel.find('tbody > tr');
                /*vooraf opslaan van keyA en keyB in sortKey*/
                jQuery.each(rijen, function (index, rij) {

                    if (jQuery(col).is('.alfabet')) {
                        rij.sortKey = jQuery(rij).children('td').eq(columnIndex).text().toUpperCase();
                    }

                    if (jQuery(col).is('.getal')) {
                        var waarde = jQuery(rij).children('td').eq(columnIndex).text();
                        rij.sortKey = parseFloat(waarde);
                    }
                });

                rijen.sort(function (a, b) {
                    if (a.sortKey < b.sortKey) return -1;
                    if (a.sortKey > b.sortKey) return 1;
                    return 0;
                });

                jQuery.each(rijen, function (index, rij) {
                    tabel.children('tbody').append(rij);
                    rij.sortKey = null;
                });

            }); //einde click event
        } //einde if sorteer


    }); //einde each

    //2. hide red bar
    jQuery("#closeinfo").click(function () {
        alert('hi2');
        jQuery("#redbar").hide();
    });

    //3. show error message
    if (jQuery("#message").text().trim().length != 0) {
        $text = jQuery("#message").text();
        alert($text);
    }; //einde if

    //4. remove a project
    jQuery("table").on("click", "button.btndelete", removeProject);

});   //einde ready event


        

