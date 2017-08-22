<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<?php
echo "di testpage4";
//wp_mail( string|array $to, string $subject, string $message, string|array $headers = '', string|array $attachments = array() )
//wp_mail('ronald.eelbode@telenet.be','subject','message');

$to = 'ronald.eelbode@telenet.be';
$subject = 'The subject';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name <support@example.com');
 
wp_mail( $to, $subject, $body, $headers );

//message transger agent need to be installe don localhost
//https://wordpress.stackexchange.com/questions/195827/wp-mail-is-not-working-in-localhost
//https://www.youtube.com/watch?v=qXvGKnWXH5A
?>
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>

