<?php
include('../../helpers/feedback.class.php');
include('../../helpers/base.class.php');
include('class.loginattempt.php');

/*insert testen*/
/*
$laObject = new LoginAttempt();
$laObject->insert(1, time());
*/

//countMemberIdByTime

$laObject = new LoginAttempt();
$now=time();
$onehourago = $now - 3600;
$result = $laObject->countMemberIdByTime(1, $onehourago);
echo $laObject->getFeedback();
echo "<br> aantal: ".$result[0];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <!--
        <p>Test insert loginattempt</p>
        <ul>
            <li>Message: <?php echo $laObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $laObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $laObject->getErrorCode(); ?></li>
            <li>ID: <?php echo $laObject->getId(); ?></li>
        </ul>
        -->
    </body>
</html>
