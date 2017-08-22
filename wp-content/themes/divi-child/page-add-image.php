<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">

 <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Foto formulier</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
</div>
        <p>
            <a href="documentfotos_view.php?documentid=<?php echo $docId;?>" class="buttonterug">&nbsp;Terug</a>
        </p>
        <form class="form-horizontal">
            <?php
            if(isset($_GET['documentid']))
            {
            ?>
            <div class="control-group">
                <label for="fotoid" class="control-label">foto nr:</label>
                <div class="controls"><input id="fotoid" name="fotoid" type="text" value="<?php echo $fotoObject->getFotoId();?>" readonly="true"></div>
            </div>
            <?php
            }
            ?>
            
            <div class="control-group">
                <label for="nieuwenaam" class="control-label">naam:</label>
                <div class="controls"><input id="nieuwenaam" name="nieuwenaam" type="text" value="<?php echo $fotoNaam;?>" readonly="true"></div>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <img id="<?php echo $fotoNaam;?>" alt="<?php echo $fotoNaam;?>" title="<?php echo $fotoNaam;?>" src="<?php echo $fotoURL.$fotoNaam;?>"/>
                </div>
            </div>

            
            <input type="hidden" id="url" name="url" value="<?php echo $fotoURL;?>" /> 
            <input type="hidden" id="docid" name="docid" value="<?php echo $docId;?>" />
            </form>
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>