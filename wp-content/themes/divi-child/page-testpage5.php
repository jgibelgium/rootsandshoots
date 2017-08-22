
<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<div id="message">
	
<?php

do_action('testinghook');
do_action('tp5_hook');
do_action('member_hook');
?>
</div>
</section>
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>