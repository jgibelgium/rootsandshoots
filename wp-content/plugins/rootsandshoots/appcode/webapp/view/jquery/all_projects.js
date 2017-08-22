function removeProject()
     {
                var btnid = jQuery(this).attr("id"); //attribuut lezen in jQuery
                alert(btnid);
                var id = btnid.substring(16);
                alert(id);
                var r = confirm("Do you want to remove project with its product types, target groups, project members and stuffs?");
                if(r == true)
                {
                    window.location.href = 'http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/project.control.php?projectid=' + id;
                    return false;
                }
     }    


jQuery(document).ready(function () {

    //1. snel sorteren dankzij de expando sortKey
    var tabel = jQuery("#projectsTable");
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
        jQuery("#redbar").hide();
    });

    //3. filteren
    jQuery("#filter").change(function () {
         var tekst = jQuery(this).val();
         jQuery("tbody tr").hide();
         jQuery("tbody tr td:contains('" + tekst + "')").parent().show();
    });

    //4. remove a project
    jQuery("table").on("click", "button.btndelete", removeProject);
    
    //5. export to excel
    jQuery("#btnexcel").click(function(){
        alert('hi');
        jQuery("#projectsTable").table2excel({
        // exclude CSS class
        exclude: ".noExl",
        name: "All projects",
        filename: "all_projects", //do not include extension
        fileext: ".xls"
        });
     });

     //6.paginatie
     jQuery("#aantalPaginas").change(function () {
         alert('hi');
                    var ps = jQuery("select option:selected").text();
                    alert(ps);
                    if (ps == "") {
                        jQuery("#projectsTable").datatable('destroy');
                    }
                    else {
                        jQuery("#projectsTable").datatable({
                            pageSize: ps,
                            pagingNumberOfPages: 5
                        });
                    };
      });

});   //einde ready event


        

