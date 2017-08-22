<?php
if (isset($_POST['memberAgeBtn'])) {
    echo "ok";
    if($_POST['memberformage'] == 1)
    {
          header('Location: http://localhost:8080/rootsandshootseurope/register');
    }
    else
    {
        header('Location: http://localhost:8080/rootsandshootseurope/register?role=parent');
    
    }
    
}

?>