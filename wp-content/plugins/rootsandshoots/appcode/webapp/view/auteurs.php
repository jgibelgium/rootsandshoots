<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/auteur.class.php');
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']) || $_SESSION['lidstatus'] == 1)
{
   if($_SESSION['lidstatus'] == 1)
   {
       //sessionid wissen
       include('../help/sessie.class.php');
       $sessieObject1 = new Sessie();
       $sessieObject1->setId(1);
       $sessieObject1->setLidId($_SESSION['lidid']);
       $sessieObject1->setSessionId(NULL);
       $time = time();
       $sessieObject1->setLastActivity($time);
       $sessieObject1->setModifiedBy($_SESSION['username']);
       $sessieObject1->update();

       //gecachte bestanden wissen
       $files = glob('../view/cached/*');//array van bestanden in de cached folder
       foreach($files as $file)
       {
        if(is_file($file))
        {
            unlink($file);
        }    
       }
   }
   //alle sessie variabelen wissen
   session_destroy();
   header('Location: ../../../index.php');
}
else
{
    $lidStatus = $_SESSION['lidstatus']; 
    include('../help/sessie.class.php');
    Sessie::checkSessionId();
    Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
}

$auteurObject = new Auteur();
$auteursLijst = $auteurObject->selectAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Auteurs</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/auteurs.css" type="text/css">
        <?php include ('../help/jquery.php');?>
        <script>
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
                var tabel = $("#auteursTabel");
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
                });

                //4. knoppen in actie kolom
                $(".btndelete").button(
                    {
                        icons: { primary: "ui-icon-trash" }
                    });

                $(".btnedit").button(
                    {
                        icons: { primary: "ui-icon-pencil" }
                    });

                //5. auteur verwijderen
                $("table").on("click", "button.btndelete", verwijderAuteur);

                //6.paginatie
                $("#aantalPaginas").change(function () {
                    var ps = $("select option:selected").text();
                    if (ps == "") {
                        $('#auteursTabel').datatable('destroy');
                    }
                    else {
                        $('#auteursTabel').datatable({
                            pageSize: ps,
                            pagingNumberOfPages: 5
                        });
                    };
                });

                //7. dialog widget messages
                if ($("#message").text().trim().length != 0) {
                    $("#message").dialog({
                    buttons: {
                        "OK": function () { $(this).dialog("close"); }
                    }
                }); //einde dialog
                };//einde if

                //8.tooltips
                $('.btndelete').tooltip();
                $('.btnedit').tooltip();

            }); //einde ready event

            function verwijderAuteur() {
                var btnid = $(this).attr("id"); //attribuut lezen in jQuery
                var id = btnid.substring(15);
                //dialog widget bij verwijderen record
                $("#warningDeletion").dialog(
                {
                    buttons: [
                {
                    text: "Ja",
                    click: function () { window.location.href = '../control/auteur.control.php?auteurid=' + id; }
                },
                {
                    text: "Nee",
                    click: function () { $(this).dialog("close"); }
                }]
                });
            } //einde verwijderAuteur

        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
            <div class="welcoming">Administrator</div>
        </div>
        </div>
            <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Auteurs: <?php echo count($auteursLijst)?> rijen</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
            </div>
            <p><a href="auteur_formulier.php" class="buttonadd">&nbsp;Auteur toevoegen</a>
            </p><br />
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
            <table id="auteursTabel">
                    <thead>
                        <tr>
                        <th class="sorteer alfabet Naam">NAAM</th>
                        <th class="sorteer alfabet Voornaam">VOORNAAM</th>
                        <th class="sorteer alfabet Info">INFO AUTEUR</th>
                        <th class="Actie">ACTIE</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($auteursLijst as $auteur)
                    {
                        $i=$auteur['AuteurId'];
                    ?>
                    <tr id="<?php echo "auteurRij".$i ?>">
                        <td id="<?php echo "auteurNaam".$i ?>"><?php echo $auteur['AuteurNaam'] ?></td>
                        <td id="<?php echo "auteurVoornaam".$i ?>"><?php echo $auteur['AuteurVoornaam'] ?></td>
                        <td id="<?php echo "auteurInfo".$i ?>"><?php echo $auteur['AuteurInfo'] ?></td>
                        <td id="<?php echo "auteurActie".$i?>"><a id="<?php echo "auteurLinkDelete".$i?>" title="wis"><button id="<?php echo "auteurBtnDelete".$i?>" type="button" class="btndelete"></button></a><form id="<?php echo "auteurEdit".$i?>" method="post" action="auteur_formulier.php"><input id="auteurid" name="auteurid" value="<?php echo $i;?>"><button id="<?php echo "auteurBtnEdit".$i?>" type="submit" class="btnedit" title="edit"></button></form></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
             <div class="paging"></div>
            <div id="warningDeletion">Bent u zeker om deze auteur te verwijderen?</div>
            <div id="message"><?php if(isset ($_SESSION['message'])) {echo $_SESSION['message'];}; unset($_SESSION['message']);?></div>
            <div class="push"></div> 
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>         
    </body>
</html>
