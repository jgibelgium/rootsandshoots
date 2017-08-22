<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../../webapp/model/doc.class.php');
include('../help/time.php');
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
   header('Location: ../../../index.php');
}
else
{
    $lidStatus = $_SESSION['lidstatus']; 
    include('../help/sessie.class.php');
    Sessie::checkSessionId();
    Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
}

//tbv welcoming
if(isset($_SESSION['lidid']))
{
    $lidObject = new Lid();
    $lidObject->setLidId($_SESSION['lidid']);
    $lid = $lidObject->selectLidById();
}

//alle verleners ophalen
$lidObject = new Lid();
$verleners = $lidObject->selectVerleners($_SESSION['lidid']);

$mailMessage = isset($_SESSION['mailmessageexchange'])? $_SESSION['mailmessageexchange'] : "";
unset($_SESSION['mailmessageexchange']);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Start ontlening</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/startontlening.css" type="text/css">
         <?php include ('../help/jquery.php');?>
      
        <script type="text/javascript">
            $(document).ready(function () {
                //1. menu
                $("#jMenu").jMenu(
                {
                    ulWidth: '220px',
                    effects: {
                        effectSpeedOpen: 300,
                        effectTypeClose: 'slide'
                    },
                    animatedText: true
                });

                //2. snel sorteren dankzij de expando sortKey
                var tabel = $("#leenTabel");
                $('th', tabel).each(function (columnIndex) {
                    if ($(this).is('.sorteer')) {
                        var col = this;
                        $(this).click(function () {
                            var rijen = tabel.find('tbody > tr');
                            /*vooraf opslaan van keyA en keyB in sortKey*/
                            $.each(rijen, function (index, rij) {

                                if ($(col).is('.alfabet')) {
                                    rij.sortKey = $(rij).children('td').eq(columnIndex).text().toUpperCase();
                                }

                                if ($(col).is('.getal')) {
                                    var waarde = $(rij).children('td').eq(columnIndex).text();
                                    rij.sortKey = parseFloat(waarde);
                                }
                            });

                            rijen.sort(function (a, b) {
                                if (a.sortKey < b.sortKey) return -1;
                                if (a.sortKey > b.sortKey) return 1;
                                return 0;
                            });

                            $.each(rijen, function (index, rij) {
                                tabel.children('tbody').append(rij);
                                rij.sortKey = null;
                            });

                        }); //einde click event
                    } //einde if sorteer


                }); //einde each

                //3. filteren
                $("#filter").change(function () {
                    var tekst = $(this).val();
                    $("tbody tr").hide();
                    $("tbody tr td:contains('" + tekst + "')").parent().show();
                })

                //4. knoppen 
                $("#btnLeen").button(
                    {
                        icons: { primary: "ui-icon-transferthick-e-w" }
                    });

                //5. kalender
                $("#duedate").datepicker({ 
                    inline: true,
                    minDate: new Date(2015, 1 - 1, 1)
                 });

                //6. form validatie
                $("#btnLeen").button().click(function () {
                    if (($('#ddlVerleners option:selected').text() != '') && ($(".uniform:checked").length == 0)) {
                        $("#warningFrm1").dialog("open");
                        return false;
                    }
                    else if ($(".uniform:checked").length > 3) {
                        $("#warningFrm2").dialog("open");
                        return false;
                    };
                    });

                $("#warningFrm1").dialog({
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    buttons: {
                        "OK": function () {
                            $(this).dialog("close");
                        }
                    }
                });
                $("#warningFrm2").dialog({
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    buttons: {
                        "OK": function () {
                            $(this).dialog("close");
                        }
                    }
                });

            }); //einde ready event


            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });
        </script>
        <script type="text/javascript">
            /*response is een JSON array*/
            function tableCreate(response) {
                $("#leenwaarTabel thead").empty();
                $("#leenwaarTabel tbody").empty();

                if (response.length == 0) {
                    $("#leenwaarTabel thead").append("<tr><th>Geen documenten</th></tr>");
                }
                else {
                    $("#leenwaarTabel thead").append("<tr><th class='Id'>Nr</th><th>Titel</th><th class='Auteur'>Auteur</th><th class='Type'>Document Type</th><th class='Actie'>Leen</th></tr>");
                    for (var i = 0; i < response.length; i++) {
                        var docid = response[i].docid;
                        var titel = response[i].titel;
                        var type = response[i].doctype;
                        if (response[i].auteurnaam === null) {
                            var auteur = "";
                        }
                        else {
                            var auteur = response[i].auteurnaam;
                        }
                        $("#leenwaarTabel tbody").append("<tr><td>" + docid + "</td><td>" + titel + "</td><td>" + auteur + "</td><td>" + type + "</td><td><input type='checkbox' class='uniform' name='selector[]' value='" + docid + "'></td></tr>"); /*4 rijen toe*/
                    }
                } //einde else
                $("#duedate").val('');
            }

            //Javascript ajax ter ophaling van leenwaar van verlener 
            function showLeenwaar(str) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var ar = JSON.parse(xmlhttp.responseText); //ar is een JSON object
                        //JSON object inkijken
                        /*
                        for (var i = 0; i < ar.length; i++) {
                        document.write(ar[i][0] + " ");
                        document.write(ar[i][1] + " ");
                        document.write(ar[i][2] + " ");
                        document.write(ar[i][3] + " ");
                        document.write("<br />");
                        }
                        */
                    }
                    tableCreate(ar);
                };
                xmlhttp.open("GET", "ajax.view.php?verlenerid=" + str, true); //get duidt op gebruik van querystring; true duidt op ansynchroniciteit
                xmlhttp.send();
            }


        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming"><?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} elseif($lidStatus == 0) {echo "bezoeker";}?></div>
        </div>
        </div>
            <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Documenten te leen</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
            </div>
            <form id="frmOntleningDocs" method="post" action="../control/ontlening.control.php" class="form-horizontal">
            <div class="control-group">
            <label for="ddlVerleners" class="control-label">Verleners:&nbsp;</label>
            <div class="controls">
            <select id="ddlVerleners" name="verlenerid" required onchange="showLeenwaar(this.value)">
                <option></option>
                <?php
                    foreach($verleners as $verlener)
                    {
                ?>
                <option value="<?php echo $verlener['LidId'];?>"><?php echo $verlener['LidNaam']." ".$verlener['LidVoornaam'];?></option>
                <?php
                    }
                ?>
            </select>
            </div>
            </div>

            <div class="control-group">
            <label for="duedate" class="control-label">Due date:&nbsp;</label>
            <div class="controls">
                 <input id="duedate" name="duedate" required><!--verschijnt in html5 datumformaat-->
            </div>
            </div>
            
            <div class="control-group"> 
            <label class="control-label">Documenten:&nbsp;</label>
            <div class="controls">       
            <table id="leenwaarTabel">
                <thead></thead>
                <tbody></tbody>
            </table>
            </div>
            </div> 
            
            <br />
            <br />
            <div class="control-group">
                <div class="controls">
                <button id="btnLeen" name="btnLeen" type="submit">Bericht aan verlener</button>
                </div>
            </div>  

            </form>
            <div id="mailMessage"><?php echo $mailMessage; ?></div>
            <div id="warningFrm1">Gelieve tenminste één document aan te vinken bij een uitwisseling.</div>
            <div id="warningFrm2">Maximaal 3 documenten bij een uitwisseling.</div>
            <div class="push"></div> 
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>        
    </body>
</html>
