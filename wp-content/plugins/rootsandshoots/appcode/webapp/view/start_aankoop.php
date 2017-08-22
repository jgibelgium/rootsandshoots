<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
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

//alle verkopers ophalen
$lidObject = new Lid();
$verkopers = $lidObject->selectVerkopers($_SESSION['lidid']);

$mailMessage = isset($_SESSION['mailmessagedeal'])? $_SESSION['mailmessagedeal'] : "";
unset($_SESSION['mailmessagedeal']);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Start aankoop</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/startaankoop.css" type="text/css">
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
                var tabel = $("#aankoopTabel");
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
                $("#btnKoop").button(
                    {
                        icons: { primary: "ui-icon-transferthick-e-w" }
                    });

                //5. form validatie
                $("#btnKoop").button().click(function () {
                    if (($('#ddlVerkopers option:selected').text() != '') && ($(".uniform:checked").length == 0)) {
                        $("#warningFrm").dialog("open");
                        return false;
                    };
                });

                $("#warningFrm").dialog({
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    buttons: {
                        "OK": function () {
                            $(this).dialog("close");
                        }
                    }
                });

                //6. border van koopwaarTabel doen verdwijnen bij laden pagina
                $("#koopwaarTabel thead tr th").css('border-style', 'hidden');

                //6. ajax testen
                //data en status zijn variabelen inherent aan ajax
                //data bevat resultaat van functie in string
                /*
                $("#ddlVerkopers").change(function () {
                var verkoperId = $("#ddlVerkopers").val();
                var uRL = "../control/aankoop.control.php?q=" + verkoperId; //herladen van deze pagina lukte niet

                $.get(uRL, function (data) {
                //data is a keyword in de callback functie van $.get
                //parseJSON takes a well-formed JSON string and returns the resulting JavaScript value. Echter geen verschil te zien.
                alert(data);
                for (var i = 0; i < data.length; i++) {
                alert(data[i][0] + " " + data[i][1] + " " + data[i][2] + " " + data[i][3] + " " + data[i][4]);
                }

                var docId = res['DocId'];
                var titel = res['Titel'];
                var auteur = res['AuteurNaam'];
                var docType = res['DocType'];
                var prijs = res['Prijs'];
                //var rij = "<tr><td>" + docId + "</td><td>" + titel + "</td><td>" + auteur + "</td><td>" + docType + "</td><td>" + prijs + "</td><tr>";
                //$("#docRij1").append(rij);

                //opbouw van lege tabel
                $("table tbody").empty();
                for (var x = 1; x <= 10; x++) {
                $("tbody").append("<tr></tr>");
                };
                //onderstaande selector selecteert 10 elementen
                $("tbody > tr").attr({
                id: function (index) {
                return "docRij" + index;
                }
                }); //einde attr
                for (var y = 1; y <= 5; y++) {
                $("tbody tr").append("<td></td>");
                }


                $("#docRij1").append("<td>" + docId + "</td>").append("<td>" + titel + "</td>").
                append("<td>" + auteur + "</td>").append("<td>" + docType + "</td>").append("<td>" + prijs + "</td>").
                append("<td></td>");

                }); //einde $.get

                }); //einde change event
                */
            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });


        </script>
        <script type="text/javascript">
            function berekenPrijs() {
                var orderBedrag = 0;
                var aantalDocs = 0;

                var oRows = document.getElementById('kwBody').getElementsByTagName('tr');
                var aantalRijen = oRows.length;
                for (var i = 0; i < aantalRijen; i++) {
                    var tag = document.getElementById('cb' + i);

                    if (tag.checked == true) {
                        var prijs = document.getElementById("kwPrijs" + i).innerHTML;
                        orderBedrag += parseFloat(prijs);
                        aantalDocs += 1; ;
                    }
                }

                document.getElementById("orderBedrag").value = Math.round(orderBedrag * 100) / 100;
                document.getElementById("transportKost").value = aantalDocs * 2;
            }

            function tableCreate(response) {
                $("#koopwaarTabel thead").empty();
                $("#koopwaarTabel tbody").empty();
                if (response.length == 0) {
                    $("#koopwaarTabel thead").append("<tr><th>Geen documenten</th></tr>");
                }
                else {
                    $("#koopwaarTabel thead").append("<tr><th class='Id'>Nr</th><th>Titel</th><th class='Auteur'>Auteur</th><th class='Type'>Document Type</th><th class='Prijs'>Prijs (€)</th><th class='Actie'>Koop</th></tr>");
                    for (var i = 0; i < response.length; i++) {
                        var docid = response[i].docid;
                        var titel = response[i].titel; /*required*/
                        var type = response[i].doctype; /*required*/
                        if (response[i].auteurnaam === null) {
                            var auteur = "";
                        }
                        else {
                            var auteur = response[i].auteurnaam;
                        }
                        if (response[i].prijs === null) {
                            var prijs = "";
                        }
                        else {
                            var prijs = response[i].prijs;
                        }
                        $("#koopwaarTabel tbody").append("<tr><td>" + docid + "</td><td>" + titel + "</td><td>" + auteur + "</td><td>" + type + "</td><td id='kwPrijs" + i + "'>" + prijs + "<td><input id='cb" + i + "' type='checkbox' class='uniform' name='selector[]' value='" + docid + "' onchange='berekenPrijs()'></td></tr>");
                    }
                } //einde else
                //onderstaande regels gaan niet over tabel creatie, maar herinitialiseren de form
                $("#orderBedrag").val('');
                $("#transportKost").val('');
                $('input[name="tpt"]').prop('checked', false);
            }

            //Javascript ajax ter ophaling van koopwaar van verkoper
            function showKoopwaar(str) {
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
                        document.write(ar[i][4] + " ");
                        document.write("<br />");
                        }
                        */
                    }
                    tableCreate(ar);
                    /*gaat niet*/
                    /*
                    $("#orderBedrag").attr("value","");
                    $("#transportKost").attr("value","");
                    */
                    /*
                    document.getElementById("orderBedrag").setAttribute("value", "");
                    document.getElementById("transportKost").setAttribute("value", "");
                    */
                };
                xmlhttp.open("GET", "ajax.view.php?verkoperid=" + str, true); //get duidt op gebruik van querystring; true duidt op ansynchroniciteit
                xmlhttp.send();
            }


        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming"><?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo $lid[0]['LidNaam']." ".$lid[0]['LidVoornaam'];} elseif($lidStatus == 0) {echo "bezoeker";}?></div>
        </div>
        </div>
        <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Documenten te koop</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <form id="frmAankoopDocs" method="post" action="../control/aankoop.control.php" class="form-horizontal">
        <div class="control-group">
        <label for="ddlVerkopers" class="control-label">Verkopers:</label>
        <div class="controls">
        <select id="ddlVerkopers" name="verkoperid" required onchange="showKoopwaar(this.value)">
                <option></option>
                <?php
                foreach($verkopers as $verkoper)
                {
                ?>
                <option value="<?php echo $verkoper['LidId'];?>"><?php echo $verkoper['LidNaam']." ".$verkoper['LidVoornaam'];?></option>
                <?php
                }
                ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">documenten:</label>
        <div class="controls">
         
        <table id="koopwaarTabel">
                <thead><tr><th>&nbsp;</th></tr></thead>
                <tbody id="kwBody"></tbody>
        </table>
        </div>
        </div>

        <div class="control-group">
        <label class="control-label">Prijs documenten (€):</label>
        <div class="controls"><input id="orderBedrag" name="orderBedrag" type="text" value="" readonly="true"></div>
        </div>

        <div class="control-group">
        <label class="control-label">Transportkost (€):</label>
        <div class="controls"><input id="transportKost" name="transportKost" type="text" value="" readonly="true"></div>
        </div>

        <div class="control-group">
        <label class="control-label">&nbsp;Verzenden:</label>
        <div class="controls"><div><input type="radio" name="tpt" value="send" required></div></div>
        </div>
        
        <div class="control-group">
        <label class="control-label">&nbsp;Afhalen (geen transportkost):</label>
        <div class="controls"><div><input type="radio" name="tpt" value="get"></div></div>
        </div>
        <br />
        <br />
        <div class="control-group">
        <div class="controls">
        <button id="btnKoop" name="btnKoop" type="submit">Bericht aan verkoper</button>
        </div>
        </div>  
        </form>
        <div id="mailMessage"><?php echo $mailMessage;?></div>
        <div id="warningFrm">Gelieve tenminste één document aan te vinken bij een koop.</div>
        <div class="push"></div> 
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>    
    </body>
</html>
