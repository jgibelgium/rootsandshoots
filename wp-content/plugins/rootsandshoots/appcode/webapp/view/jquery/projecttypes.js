            jQuery(document).ready(function () {

                //1.temporary feedback message
                if (jQuery("#message").text().trim().length != 0) {
                    var message = jQuery("#message").text();
                    alert(message);
                };//einde if

                //2. buttons in action column
                /*
                $(".btndelete").button(
                    {
                        icons: { primary: "ui-icon-trash" }
                    });

                $(".btnedit").button(
                    {
                        icons: { primary: "ui-icon-pencil" }
                    });
                    */

                //3. remove projecttype
                jQuery("table").on("click", "button.btndelete", deleteProjectType);

                

                //1bis. dialog widget messages
                /*
                if ($("#message").text().trim().length != 0) {
                    $("#message").dialog({
                    buttons: {
                        "OK": function () { $(this).dialog("close"); }
                    }
                }); //einde dialog
                };//einde if
                */

                

            }); //einde ready event

            function deleteProjectType() {
                var btnid = jQuery(this).attr("id"); //attribuut lezen in jQuery
                var id = btnid.substring(11);
                alert(id);
                //dialog widget bij verwijderen record
                /*
                $("#warningDeletion").dialog(
                {
                    buttons: [
                {
                    text: "Yes",
                    click: function () { window.location.href = '../control/projecttype.control.php?projecttypeid=' + id; }
                },
                {
                    text: "No",
                    click: function () { $(this).dialog("close"); }
                }]
                });
                */

                var r = confirm("Are you sure to remove this project type?");
                if(r == true)
                {
                    window.location.href = 'http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/projecttype.control.php?projecttypeid=' + id;
                    return false; //to prevent window.location.href is assigned badly;
                }
                             
                                
            } //end deleteProjectType

            jQuery(function() {
                jQuery("#closeinfo").click(function () {
                    jQuery("#redbar").hide();
                });
            });

 