<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<div id="message">
<?php
if (isset($_SESSION['message'])) {echo $_SESSION['message'];
}; unset($_SESSION['message']);
?>
</div>
</section>
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>














