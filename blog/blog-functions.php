<?php
// rm blog post support (handled via ACF)
add_action( 'init', 'edit_blog_post_support' );
function edit_blog_post_support() {
  remove_post_type_support('post', 'editor');
	remove_post_type_support('post', 'thumbnail');
}
?>
