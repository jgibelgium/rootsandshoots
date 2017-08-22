<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
 <?php echo "testpage1 ";
 
 $userid = get_current_user_id();
 echo "current userid: ".$userid;
 
 $memberObject = new Member();
 
  ?>
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>