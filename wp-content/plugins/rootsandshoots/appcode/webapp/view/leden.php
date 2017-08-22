<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
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

$lidObject = new Lid();
$lidObject->setLidId($_SESSION['lidid']);
$lid = $lidObject->selectLidById();
$ledenLijst = $lidObject->selectAll();

$deleteMessage = isset($_SESSION['deletemessage'])? $_SESSION['deletemessage'] : "";
unset($_SESSION['deletemessage']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Leden</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/leden.css" type="text/css">
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
                var tabel = $("#ledenTabel");
                $('th', tabel).each(function (columnIndex) {
                    if ($(this).is('.sorteer.alfabet')) {
                        $(this).click(function () {
                            var rijen = tabel.find('tbody > tr');

                            /*vooraf opslaan van keyA en keyB in sortKey*/
                            $.each(rijen, function (index, rij) {
                                rij.sortKey = $(rij).children('td').eq(columnIndex).text().toUpperCase();
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

                        });
                    }
                }); //einde each

                //3. filteren
                $("#filter").change(function () {
                    var tekst = $(this).val();
                    $("tbody tr").hide();
                    $("tbody tr td:contains('" + tekst + "')").parent().show();
                })

                //4. knoppen in actie kolom
                $(".btndelete").button(
                    {
                        icons: { primary: "ui-icon-trash" }
                    });

                $(".btnedit").button(
                    {
                        icons: { primary: "ui-icon-pencil" }
                    });

                //5. lid verwijderen
                $("table").on("click", "button.btndelete", verwijderLid);

                //6.paginatie
                $("#aantalPaginas").change(function () {
                    var ps = $("select option:selected").text();
                    if (ps == "") {
                        $('#ledenTabel').datatable('destroy');
                    }
                    else {
                        $('#ledenTabel').datatable({
                            pageSize: ps,
                            pagingNumberOfPages: 5
                        });
                    };
                });

                //7. dialog widget no deletion possible
                if ($("#deleteMessage").text().trim().length != 0) {
                    $("#deleteMessage").dialog({
                        buttons: {
                            "OK": function () { $(this).dialog("close"); }
                        }
                    }); //einde dialog
                }; //einde if

                //8.tooltip
                $('a[title="wis"]').tooltip();
                $('a[title="edit"]').tooltip();

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });

            function verwijderLid() {
                var btnid = $(this).attr("id"); //attribuut lezen in jQuery
                var id = btnid.substring(12);
                //dialog widget bij verwijderen record
                $("#warningDeletion").dialog(
                {
                    buttons: [
                {
                    text: "Ja",
                    click: function () { window.location.href = '../control/lid.control.php?lidid=' + id; }
                },
                {
                    text: "Nee",
                    click: function () { $(this).dialog("close"); }
                }]
                });
            } //einde verwijderLid
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
                <strong>&nbsp;Leden: <?php echo count($ledenLijst)?> rijen</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
            <?php
            if($lidStatus == 2){
            ?>
            <p><a href="lid_formulier.php" class="buttonadd">&nbsp;Lid toevoegen</a></p>
            <?php
            }
            ?>
            <br />
            <div class="row-fluid">
                <label id="paginatie">
                    <select size="1" id="aantalPaginas">
                        <option></option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>&nbsp;rijen per pagina
                </label>
                <label id="filtering">
                Zoek:&nbsp;<input type="text" id="filter">
                </label>
            </div>
            <table id="ledenTabel">
                    <thead>
                        <tr>
                        <th class="sorteer alfabet Cel">NAAM</th>
                        <th class="sorteer alfabet Cel">VOORNAAM</th>
                        <?php 
                        if($lidStatus == 2){
                        ?>
                        <th class="sorteer alfabet Cel">GEBRUIKERSNAAM</th>
                        <th class="sorteer alfabet">WACHTWOORD</th>
                        <th class="Actie">ACTIE</th>
                        <?php
                        }
                        elseif($lidStatus == 1)
                        {
                        ?>
                        <th class="sorteer alfabet Cel">E-MAIL ADRES</th>
                        <th class="sorteer alfabet">TELEFOON</th>
                        <th class="sorteer alfabet Cel">SKYPE NAAM</th>
                        <?php
                        }
                        ?>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($ledenLijst as $lid)
                    {
                        $i=$lid['LidId'];
                    ?>
                    <tr id="<?php echo "lidRij".$i ?>">
                        <td id="<?php echo "lidNaam".$i ?>"><?php echo $lid['LidNaam'] ?></td>
                        <td id="<?php echo "lidVoornaam".$i ?>"><?php echo $lid['LidVoornaam'] ?></td>
                        <?php
                        if($lidStatus == 2){
                        ?>
                        <td id="<?php echo "lidGebruikersNaam".$i ?>"><?php echo $lid['GebruikersNaam'] ?></td>
                        <td id="<?php echo "lidWachtwoord".$i ?>"><?php echo $lid['Wachtwoord'] ?></td>
                        <td id="<?php echo "lidActie".$i?>"><a id="<?php echo "lidLinkDelete".$i?>" title="wis"><button id="<?php echo "lidBtnDelete".$i?>" type="button" class="btndelete"></button></a><a id="<?php echo "lidLinkEdit".$i?>" href="lid_formulier.php?lidid=<?php echo $i;?>" title="edit"><button id="<?php echo "lidBtnEdit".$i?>" type="button" class="btnedit"></button></a></td>
                        <?php
                        }
                        elseif($lidStatus == 1)
                        {
                        ?>
                        <td id="<?php echo "lidEmail".$i ?>"><?php echo $lid['Email'] ?></td>
                        <td id="<?php echo "lidTel".$i ?>"><?php echo $lid['Telefoon'] ?></td>
                        <td id="<?php echo "lidSkype".$i?>"><?php echo $lid['SkypeNaam'];?></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
             <div class="paging"></div>
            <div id="warningDeletion">Bent u zeker om dit lid te verwijderen?</div>
            <div id="deleteMessage"><?php echo $deleteMessage; ?></div>
            <div class="push"></div>      
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>    
    </body>
</html>
