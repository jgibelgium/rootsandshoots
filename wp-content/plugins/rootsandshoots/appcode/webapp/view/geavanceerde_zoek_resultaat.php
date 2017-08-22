<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/lid.class.php');

session_start();

if(isset($_SESSION['lidstatus']))
{
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

$docObject = new Doc();
//verplicht, maar om niet reguliere toegang via de browserbalk op te vangen
if(!empty($_POST['titel']))
{
    $titelDeel =  $_POST['titel'];
}
else
{
    $titelDeel = NULL;
}

if(!empty($_POST['taalid']))
{
    $taalId = $_POST['taalid'];
}
else
{
    $taalId = NULL;
}

if(!empty($_POST['doctypeid']))
{
    $docTypeId = $_POST['doctypeid'];
}
else
{
    $docTypeId = NULL;
}
$documentenLijst = $docObject->filterAllAvailable($titelDeel, $taalId, $docTypeId);

//tbv auteur van document ophalen
include('../model/auteur.class.php');
function auteurOphalen($auteurId)
{
    $auteurObject = new Auteur();
    $auteurObject->setAuteurId($auteurId);
    $auteurObject->selectAuteurById();
    $auteurNaam=$auteurObject->getAuteurNaam();
    echo $auteurNaam;//gaat niet met return
}

//eigenaar van document ophalen
include('../model/registratie.class.php');
function eigenaarOphalen($docId)
{
    $registratieObject = new Registratie();
    $registratieObject->setDocId($docId);
    $registratieObject->selectRegistratieByDocId();
    $lidId=$registratieObject->getLidId();
    $lidObject1 = new Lid();
    $lidObject1->setLidId($lidId);
    $lidObject1->selectLidById();
    $lidNaam = $lidObject1->getLidNaam();
    $lidVoornaam = $lidObject1->getLidVoornaam();
    echo $lidNaam." ".$lidVoornaam;
}

//documenttype ophalen
include('../model/doctype.class.php');
function docTypeOphalen($docTypeId)
{
    $docTypeObject = new DocType();
    $docTypeObject->setDocTypeId($docTypeId);
    $docTypeObject->selectDocTypeById();
    $docType = $docTypeObject->getDocType();
    echo $docType;
}

function formulierRecht($docId)
{
    if($_SESSION['lidstatus'] != 0)
    { 
            $registratieObject1 = new Registratie();
            $registratieObject1->setDocId($docId);
            $registratieObject1->selectRegistratieByDocId();
            $lidId=$registratieObject1->getLidId();

            if($lidId == $_SESSION['lidid'])
            {
                //eigenaar
                 echo "document_formulier.php?documentid=".$docId;
            }
            else
            {
                //geen eigenaar
                echo "document_view.php?documentid=".$docId;
            }
    }
    else
    {
        //bezoeker
        echo "document_view.php?documentid=".$docId;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Geavanceerde zoek resultaat</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/beschikbaredocumenten.css" type="text/css">
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
                var tabel = $("#documentenTabel");
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

                //4. knoppen in actie kolom
                $(".btnedit").button(
                    {
                        icons: { primary: "ui-icon-pencil" }
                    });

                //6.paginatie
                $("#aantalPaginas").change(function () {
                    var ps = $("select option:selected").text();
                    if (ps == "") {
                        $('#documentenTabel').datatable('destroy');
                    }
                    else {
                        $('#documentenTabel').datatable({
                            pageSize: ps,
                            pagingNumberOfPages: 5
                        });
                    };
                });

                //7.tooltips
                $('a[title="edit"]').tooltip();

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming">
              <?php if (isset($_SESSION['lidstatus']))
              {
                  if($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} 
              }
              else {echo "bezoeker";}?></div>
        </div>
        </div>
            <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Geavanceerde zoek resultaat: <?php echo count($documentenLijst)?> rijen</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
            </div>
            <p><a href="zoek_formulier.php" class="buttonadd">&nbsp;Terug naar zoekformulier</a>
            </p>
            <br />
            <?php
            if(count($documentenLijst) != 0)
            {
            ?>
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
            <table id="documentenTabel">
                    <thead>
                        <tr>
                        <th class="sorteer getal Id">DOC NR.</th>
                        <th class="sorteer alfabet Titel">TITEL</th>
                        <th class="sorteer alfabet Auteur">AUTEUR</th>
                        <th class="sorteer alfabet Type">DOCUMENT TYPE</th>
                        <th class="sorteer alfabet Eigenaar">EIGENAAR</th>
                        <th class="TeKoop">TE KOOP</th>
                        <th class="TeLeen">TE LEEN</th>
                        <th class="Actie">ACTIE</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($documentenLijst as $doc)
                    {
                        $i=$doc['docid'];
                    ?>
                    <tr id="<?php echo "docRij".$i ?>">
                        <td id="<?php echo "docId".$i ?>"><?php echo $doc['docid'] ?></td>
                        <td id="<?php echo "docTitel".$i ?>"><?php echo $doc['titel'] ?></td>
                        <td id="<?php echo "docAuteur".$i ?>"><?php auteurOphalen($doc['auteurid']); ?></td>
                        <td id="<?php echo "docType".$i ?>"><?php docTypeOphalen($doc['doctypeid']); ?></td>
                        <td id="<?php echo "docEigenaar".$i ?>"><?php eigenaarOphalen($doc['docid']); ?></td>
                        <td id="<?php echo "docTeKoop".$i?>"><?php if(isset($doc['tekoop'])) { echo ($doc['tekoop'] == 1) ? "Ja" : "Nee"; }; ?></td>
                        <td id="<?php echo "docTeLeen".$i?>"><?php if(isset($doc['teleen'])) { echo ($doc['teleen'] == 1) ? "Ja" : "Nee"; }; ?></td>
                        <td id="<?php echo "docActie".$i?>"><a id="<?php echo "docLinkEdit".$i?>" href="<?php formulierRecht($i);?>" title="edit"><button id="<?php echo "docBtnEdit".$i?>" type="button" class="btnedit"></button></a></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
            <div class="paging"></div>
            <?php
            }
            ?>
            <div class="push"></div>        
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>      
    </body>
</html>
