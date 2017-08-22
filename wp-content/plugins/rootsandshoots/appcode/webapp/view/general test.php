<?php

function rs_GeneralTest()
{
    echo "$_SESSION: "."<br />";
    print_r($_SESSION);
}


add_action('rs_generaltest_hook', 'rs_GeneralTest');
?>

