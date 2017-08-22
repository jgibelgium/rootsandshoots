<?php
   $votes = get_post_meta($post->ID, "votes", true);
   //votes is a metakey retrieved from the table postmeta 
   $votes = ($votes == "") ? 0 : $votes;
?>
This post has <div id='vote_counter'><?php echo $votes ?></div> votes<br>

<?php
    $nonce = wp_create_nonce("my_user_vote_nonce");
	//wp_create_nonce generates and returns a nonce
	//a nonce is an identifying token
    $link = admin_url('admin-ajax.php?action=my_user_vote&post_id='.$post->ID.'&nonce='.$nonce);
	//admin-ajax.php is enkel in staat tot ajax avn een post in de tabel wp_posts
	//admin_url retrieves the url to the admin area for the current site with the appropriate protocol, 'https' if is_ssl() and 'http' otherwise.
	// If scheme is 'http' or 'https', is_ssl() is overridden.
    echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post->ID . '" href="' . $link . '">vote for this article</a>';
?>