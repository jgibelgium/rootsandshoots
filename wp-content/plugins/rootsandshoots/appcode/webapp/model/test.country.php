<?php

define('RS_DIR_PATH', __DIR__."\\");
echo "mappad: ".RS_DIR_PATH;
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");
echo "pluginpad: ".RS_PLUGIN_PATH;
require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'country.class.php';

//selectAll testen
/*
$countryObject = new Country();
$countries = $countryObject->selectAll(); 
print_r($countries);
*/

//selectCountryById testen
$countryObject = new Country();
$country = $countryObject->selectCountryById(2);
print_r($country);




?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <!--
        <p>Test select all</p>
        <ul>
            <li>Message: <?php echo $countryObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $countryObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $countryObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <caption>Alle landen</caption>
            <tr>
                <th>CountryId</th>
                <th>Country</th>
                
            </tr>
            <?php
                foreach ($countries as $country)
                {
                    ?>
            <tr>
                <td style="width:  100px"><?php echo $country['CountryId'] ?></td>
                <td style="width:  100px"><?php echo $country['Country'] ?></td>
                
            </tr>

            <?php
                }
            ?>
        </table>
        -->
        
         
        <p>Test selectCountryById</p>
        <ul>
            <li>Message: <?php echo $countryObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $countryObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $countryObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <tr>
                <th>CountryId</th>
                <th>Country</th>
                
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $country[0]['CountryId']; ?></td>
                <td style="width:  100px"><?php echo $country[0]['Country']; ?></td>
               
            </tr>
        </table>
        

    </body>
</html>


