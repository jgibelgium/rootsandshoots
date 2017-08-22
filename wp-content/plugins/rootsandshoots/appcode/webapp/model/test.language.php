 <?php

define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'language.class.php';

//selectAll testen
/*
$languageObject = new Language();
$languages = $languageObject->selectAll(); 
print_r($languages);
*/

//selectLanguageById testen

$languageObject = new Language();
$language = $languageObject->selectLanguageById(2);

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
            <li>Message: <?php echo $languageObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $languageObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $languageObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <caption>Alle talen</caption>
            <tr>
                <th>LanguageId</th>
                <th>Language</th>
                
            </tr>
            <?php
                foreach ($languages as $language)
                {
                    ?>
            <tr>
                <td style="width:  100px"><?php echo $language['LanguageId'] ?></td>
                <td style="width:  100px"><?php echo $language['Language'] ?></td>
                
            </tr>

            <?php
                }
            ?>
        </table>
        -->
        
         
        <p>Test selectLanguageById</p>
        <ul>
            <li>Message: <?php echo $languageObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $languageObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $languageObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <tr>
                <th>LanguageId</th>
                <th>Language</th>
                
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $language[0]['LanguageId']; ?></td>
                <td style="width:  100px"><?php echo $language[0]['Language']; ?></td>
               
            </tr>
        </table>
             

    </body>
</html>


