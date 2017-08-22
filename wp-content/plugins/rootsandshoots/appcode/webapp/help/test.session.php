<?php
    include('../../helpers/feedback.class.php');
    include('../../helpers/base.class.php');
    include('class.session.php');

    //update testen
    /*
    session_start();
    $sessionId = session_id();
    echo "sessionId: ".$sessionId."<br>";
    $objectU = new Session();
    $time = time();
    echo "nu: ".$time;
    $objectU->update(1, $sessionId, 1, $time, 'admin');
    */
    
    //testen van selectSessionById()
    /*
    $objectS = new Sessie();
    $objectS->setId(1);
    $result = $objectS->selectSessieById();
    */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <!--
        <p>Test update session</p>
        <ul>
            <li>Message: <?php echo $objectU->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectU->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectU->getErrorCode(); ?></li>
        </ul>
        -->

        <!--
        <p>Test selectSessionById</p>
        <ul>
            <li>Message: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
        </ul>

        <table border="1">
            <tr>
                <th>Id</th>
                <th>SessionId</th>
                <th>LidId</th>
                <th>Last Login</th>
                <th>ModifiedBy</th>
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $objectS->getId(); ?></td>
                <td style="width:  100px"><?php echo $objectS->getSessionId(); ?></td>
                <td style="width:  100px"><?php echo $objectS->getLidId(); ?></td>
                <td style="width:  100px"><?php echo $objectS->getLastActivity(); ?></td>                                                                    
                <td style="width:  200px"><?php echo $objectS->getModifiedBy(); ?></td>
            </tr>
        </table>
        -->

        

    </body>
</html>
