<div class="doctabs">
        <?php
        if(isset($_SESSION['lidstatus']))
        {
        if(($_SESSION['lidid'] == $lidId) || ($lidId == NULL))//eigenaar 
        {
        if($docId != NULL)//bestaand document
        {
        if(transactieChecken($docId))
        {
        ?>
        <ul id="tabs" class="pull-left">
              <li><a href="document_view.php?documentid=<?php echo $docId;?>">Details</a></li>
              <li><a href="documentkenmerken_view.php?documentid=<?php echo $docId;?>">Specifieke kenmerken</a></li>
              <li><a href="documentfotos_view.php?documentid=<?php echo $docId;?>">Foto's</a></li>
        </ul>
        <?php
        }
        else
        {
        ?>
        <ul id="tabs" class="pull-left">
              <li><a href="document_formulier.php?documentid=<?php echo $docId;?>">Details</a></li>
              <li><a href="documentkenmerken_formulier.php?documentid=<?php echo $docId;?>">Specifieke kenmerken</a></li>
              <li><a href="documentfotos_view.php?documentid=<?php echo $docId;?>">Foto's</a></li>
        </ul>
        <?php
        }
        }
        else//nieuw document
        {
        ?>
        <ul id="tabs" class="pull-left">
              <li><a href="document_formulier.php">Details</a></li>
        </ul> 
        <?php
        }
        }//einde eigenaar  
        else //leden die geen eigenaar zijn
        {
        ?>
        <ul id="tabs" class="pull-left">
              <li><a href="document_view.php?documentid=<?php echo $docId;?>">Details</a></li>
              <li><a href="documentkenmerken_view.php?documentid=<?php echo $docId;?>">Specifieke kenmerken</a></li>
              <li><a href="documentfotos_view.php?documentid=<?php echo $docId;?>">Foto's</a></li>
        </ul>
        <?php   
        }
        }
        else //bezoekers
        {
        ?>
        <ul id="tabs" class="pull-left">
              <li><a href="document_view.php?documentid=<?php echo $docId;?>">Details</a></li>
              <li><a href="documentkenmerken_view.php?documentid=<?php echo $docId;?>">Specifieke kenmerken</a></li>
              <li><a href="documentfotos_view.php?documentid=<?php echo $docId;?>">Foto's</a></li>
        </ul>
        <?php
        }
        ?>
</div>
