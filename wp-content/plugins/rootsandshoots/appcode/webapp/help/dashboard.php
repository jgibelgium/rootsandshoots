<?php
if(isset($_SESSION['lidstatus']))
{
?>
<ul id=jMenu class="pull-left">
            <li><a href="welkom.php" class="fNiv">Thuis</a></li>
            <li><a class="fNiv">Documenten</a>
                <ul>
                    <li><a href="beschikbare_documenten.php">Beschikbare documenten</a></li>
                    <li><a href="mijn_documenten.php">Mijn documenten</a></li>
                </ul>
            </li>
            <li><a href="zoek_formulier.php" class="fNiv">Geavanceerde zoek</a></li>
            <li><a class="fNiv">Deal</a>
                <ul>
                    <li><a href="start_aankoop.php">Start aankoop</a></li>
                    <li><a href="mijn_hangende_deals.php">Mijn hangende deals</a></li>
                    <li><a href="mijn_vorige_deals.php">Mijn vorige deals</a></li>
                </ul>
            </li>
            <li><a class="fNiv">Uitwisseling</a>
                <ul>
                    <li><a href="start_ontlening.php">Start ontlening</a></li>
                    <li><a href="mijn_hangende_uitwisselingen.php">Mijn hangende uitwisselingen</a></li>
                    <li><a href="mijn_vorige_uitwisselingen.php">Mijn vorige uitwisselingen</a></li>
                </ul>
            </li>
            <?php
            if($_SESSION['lidstatus'] == 1)
            {
            ?>
            <li><a href="mijn_account.php" class="fNiv">Mijn account</a></li>
            <?php
            }
            elseif($_SESSION['lidstatus'] == 2)
            {   
            ?> 
            <li><a class="fNiv">Configuratie</a>
                <ul>
                    <li><a href="auteurs.php">Auteurs</a></li>
                    <li><a href="uitgevers.php">Uitgevers</a></li>
                    <li><a href="documenttypes.php">Document types</a></li>
                    <li><a href="woonplaatsen.php">Woonplaatsen</a></li>
                </ul>
            </li>
            <?php
            }
            ?>
            <li><a href="reglement.php" class="fNiv">Reglement</a></li>
            <li><a class="fNiv">Contact</a>
                <ul>
                    <li><a href="leden.php">Leden</a></li>
                    <li><a href="contact_formulier.php">Contact formulier</a></li>
                </ul>
            </li>
            <li><a href="../control/logout.control.php" class="fNiv">Afmelden</a></li>
</ul>
<?php
}
else
{
?>
<ul id=jMenu class="pull-left">
<li><a href="welkom.php" class="fNiv">Thuis</a></li>
<li><a class="fNiv">Documenten</a>
      <ul>
           <li><a href="beschikbare_documenten.php">Beschikbare documenten</a></li>
      </ul>
</li>
<li><a href="zoek_formulier.php" class="fNiv">Geavanceerde zoek</a></li>
<li><a href="inschrijving.php" class="fNiv">Inschrijving</a></li>
<li><a href="reglement.php" class="fNiv">Reglement</a></li>
</ul>
<?php
} 
?>
