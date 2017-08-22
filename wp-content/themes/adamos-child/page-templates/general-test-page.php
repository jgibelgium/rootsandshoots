<?php
/*
Template Name: General test page
Description: A Page Template to test the model methods.
*/

get_header(); ?>

<div id="primary_home" class="content-area">
<div id="content" class="fullwidth" role="main">
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'page' ); ?>
<?php comments_template( '', true );?>
<?php 

//testen van databankconnectie
//do_action('rs_backend_hook');

//testen van selectprojectsBymember
//$memberId = 1;
//do_action('rs_backend_hook', $memberId);

//testen van selectie van projecttypes
//do_action('rs_projecttypes_hook');

//testen van selectProjectTypeById
//$projectTypeId = 1;
//do_action('rs_projecttypebyid_hook', $projectTypeId);



//testen filterprojects1
//$languageId = 1;
//$countryId = NULL;
//$projectTypeId = NULL;
//$key = "op";
//do_action('rs_backend_hook', $languageId, $countryId, $projectTypeId, $key);

//testen filterprojects1
//$languageId = 1;
//$countryId = NULL;
//$targetGroupId = 1;
//$key = "op";
//do_action('rs_backend_hook', $languageId, $countryId, $targetGroupId, $key);

//andere testen
do_action('rs_generaltest_hook');

?>
<?php endwhile; // end of the loop. ?>

</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->



