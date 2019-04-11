<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// Get Bones Core Up & Running!
// core functions (don't remove)
require_once('assets/bones.php');
// Shortcodes
require_once('assets/shortcodes.php');
// Blog
require_once('blog/blog-functions.php');

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;


/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'featured', 'auto', 'auto', false );
// add_image_size( 'featured-thumb', 700, 466, false);

// Woocommerce sizes 500x800 ratio
// 250x350, 500x700, 1000x1400, 1500x2100, 2000x2800
add_image_size( 'product-image-xl', 2000, 2800, true );
add_image_size( 'product-image-lg', 1500, 2100, true );
add_image_size( 'product-image-md', 500, 700, true );

// disable responsive images
add_filter('wp_get_attachment_image_attributes', function($attr) {
    if (isset($attr['sizes'])) unset($attr['sizes']);
    if (isset($attr['srcset'])) unset($attr['srcset']);
    return $attr;
}, PHP_INT_MAX);
add_filter('wp_calculate_image_sizes', '__return_false', PHP_INT_MAX);
add_filter('wp_calculate_image_srcset', '__return_false', PHP_INT_MAX);
remove_filter('the_content', 'wp_make_content_images_responsive');


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function wp_bootstrap_register_sidebars() {
  register_sidebar(array(
  	'id' => 'sidebar1',
  	'name' => 'Filter',
  	'description' => 'Product filter for category pages',
  	'before_widget' => '<div id="%1$s" class="widget %2$s">',
  	'after_widget' => '</div>'
  ));

  register_sidebar(array(
  	'id' => 'sidebar2',
  	'name' => 'Search',
  	'description' => 'Search widget',
  	'before_widget' => '<div id="%1$s" class="widget %2$s">',
  	'after_widget' => '</div>'
  ));
}



/************* SEARCH FORM LAYOUT *****************/

/****************** password protected post form *****/

add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<div class="clearfix"><form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
	' . '<p>' . __( "This post is password protected. To view it please enter your password below:" ,'wpbootstrap') . '</p>' . '
	<label for="' . $label . '">' . __( "Password:" ,'wpbootstrap') . ' </label><div class="input-append"><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" class="btn btn-primary" value="' . esc_attr__( "Submit",'wpbootstrap' ) . '" /></div>
	</form></div>
	';
	return $o;
}


/*********** update standard wp tag cloud widget so it looks better ************/

add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );

function my_widget_tag_cloud_args( $args ) {
	$args['number'] = 20; // show less tags
	$args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
	$args['smallest'] = 9.75;
	$args['unit'] = 'px';
	return $args;
}


// filter tag clould output so that it can be styled by CSS
function add_tag_class( $taglinks ) {
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";

    foreach( $tags as $tag ) {
    	$tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag );
    }

    $taglinks = implode('</a>', $tagn);

    return $taglinks;
}

add_action( 'wp_tag_cloud', 'add_tag_class' );

add_filter( 'wp_tag_cloud','wp_tag_cloud_filter', 10, 2) ;

function wp_tag_cloud_filter( $return, $args )
{
  return '<div id="tag-cloud">' . $return . '</div>';
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

// Disable jump in 'read more' link
function remove_more_jump_link( $link ) {
	$offset = strpos($link, '#more-');
	if ( $offset ) {
		$end = strpos( $link, '"',$offset );
	}
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end-$offset );
	}
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// Add the Meta Box to the homepage template
function add_homepage_meta_box() {
	global $post;

	// Only add homepage meta box if template being used is the homepage template
	// $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : "");
	$post_id = $post->ID;
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

	if ( $template_file == 'page-homepage.php' ){
	    add_meta_box(
	        'homepage_meta_box', // $id
	        'Optional Homepage Tagline', // $title
	        'show_homepage_meta_box', // $callback
	        'page', // $page
	        'normal', // $context
	        'high'); // $priority
    }
}

add_action( 'add_meta_boxes', 'add_homepage_meta_box' );

// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Homepage tagline area',
        'desc'  => 'Displayed underneath page title. Only used on homepage template. HTML can be used.',
        'id'    => $prefix.'tagline',
        'type'  => 'textarea'
    )
);

// The Homepage Meta Box Callback
function show_homepage_meta_box() {
  global $custom_meta_fields, $post;

  // Use nonce for verification
  wp_nonce_field( basename( __FILE__ ), 'wpbs_nonce' );

  // Begin the field table and loop
  echo '<table class="form-table">';

  foreach ( $custom_meta_fields as $field ) {
      // get value of this field if it exists for this post
      $meta = get_post_meta($post->ID, $field['id'], true);
      // begin a table row with
      echo '<tr>
              <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
              <td>';
              switch($field['type']) {
                  // text
                  case 'text':
                      echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="60" />
                          <br /><span class="description">'.$field['desc'].'</span>';
                  break;

                  // textarea
                  case 'textarea':
                      echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="80" rows="4">'.$meta.'</textarea>
                          <br /><span class="description">'.$field['desc'].'</span>';
                  break;
              } //end switch
      echo '</td></tr>';
  } // end foreach
  echo '</table>'; // end table
}

// Save the Data
function save_homepage_meta( $post_id ) {

    global $custom_meta_fields;

    // verify nonce
    if ( !isset( $_POST['wpbs_nonce'] ) || !wp_verify_nonce($_POST['wpbs_nonce'], basename(__FILE__)) )
        return $post_id;

    // check autosave
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    // check permissions
    if ( 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
    }

    // loop through fields and save the data
    foreach ( $custom_meta_fields as $field ) {
        $old = get_post_meta( $post_id, $field['id'], true );
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta( $post_id, $field['id'], $new );
        } elseif ( '' == $new && $old ) {
            delete_post_meta( $post_id, $field['id'], $old );
        }
    } // end foreach
}
add_action( 'save_post', 'save_homepage_meta' );

// Add thumbnail class to thumbnail links
function add_class_attachment_link( $html ) {
    $postid = get_the_ID();
    $html = str_replace( '<a','<a class="thumbnail"',$html );
    return $html;
}
add_filter( 'wp_get_attachment_link', 'add_class_attachment_link', 10, 1 );

// Menu output mods
class Bootstrap_walker extends Walker_Nav_Menu{

  function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0){

	 global $wp_query;
	 $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

	 $class_names = $value = '';

		// If the item has children, add the dropdown class for bootstrap
		if ( $args->has_children ) {
			$class_names = "dropdown ";
		}

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

   	$output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';

   	$attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
   	$attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
   	$attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
   	$attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

   	// if the item has children add these two attributes to the anchor tag
   	// if ( $args->has_children ) {
		  // $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
    // }

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before .apply_filters( 'the_title', $object->title, $object->ID );
    $item_output .= $args->link_after;

    // if the item has children add the caret just before closing the anchor tag
    if ( $args->has_children ) {
    	$item_output .= '<b class="caret"></b></a>';
    }
    else {
    	$item_output .= '</a>';
    }

    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
  } // end start_el function

  function start_lvl(&$output, $depth = 0, $args = Array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
    $id_field = $this->db_fields['id'];
    if ( is_object( $args[0] ) ) {
        $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    }
    return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }
}

add_editor_style('editor-style.css');

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item
add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );

function add_active_class($classes, $item) {
	if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
    $classes[] = "active";
	}

  return $classes;
}



 ////////////////////
 // SCRIPT DEQUEUE //
 ////////////////////
if( !function_exists("enqueue_dequeue_scripts_styles") ) {
  function enqueue_dequeue_scripts_styles() {

    if (!is_admin()) {
      // by deregistering jquery, no other plugin JS should load too.
      // uncomment to see what scripts should load in what order
      // disable the widget 'Meta' in the backend to remove additional scripts loading in footer from Disable Comments plugin
      // comment this out to check which scripts are loaded on the page where
      // wp_deregister_script('jquery');
      // wp_deregister_script( 'wp-embed' );

      // load custom scripts
      wp_register_script('scripts', get_template_directory_uri() . '/assets/js/scripts-min.js', false, '',true);
      wp_register_script('scripts_blog', get_template_directory_uri() . '/blog/assets/blog.min.js', false, '',true);
      wp_enqueue_script('scripts');
      wp_enqueue_script('scripts_blog');
    }
    // enqueue custom stylesheet
    wp_register_style( 'stylesheet', get_template_directory_uri() . '/assets/css/styles.css', array(), '1.0', 'all' );
    wp_register_style( 'stylesheet_blog', get_template_directory_uri() . '/blog/assets/blog.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'stylesheet' );
    wp_enqueue_style( 'stylesheet_blog' );

    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

    if( function_exists( 'is_woocommerce' ) ){
      wp_dequeue_style( 'pac-styles');
      wp_dequeue_style( 'pac-layout-styles');
      wp_dequeue_style( 'yith-wcan-frontend');
      wp_dequeue_style( 'yith_wcas_frontend');
      wp_dequeue_style( 'woocommerce_frontend_styles' );
   		wp_dequeue_style( 'woocommerce-general');
   		wp_dequeue_style( 'woocommerce-layout' );
   		wp_dequeue_style( 'woocommerce-smallscreen' );
   		wp_dequeue_style( 'woocommerce_fancybox_styles' );
   		wp_dequeue_style( 'woocommerce_chosen_styles' );
   		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
   		wp_dequeue_style( 'select2' );
  	}
  }
}
add_action( 'wp_enqueue_scripts', 'enqueue_dequeue_scripts_styles' );


function wp_bootstrap_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() ) {
    return $title;
  }

  // Add the site name.
  $title .= get_bloginfo( 'name' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title = "$title $sep $site_description";
  }

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 ) {
    $title = "$title $sep " . sprintf( __( 'Page %s', 'wpbootstrap' ), max( $paged, $page ) );
  }

  return $title;
}
add_filter( 'wp_title', 'wp_bootstrap_wp_title', 10, 2 );


//
// Adjust excerpt length
//
function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


//
// Add wrapper for iFrame embeds
//
function div_wrapper($content) {
    // match any iframes
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="video-container">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;
}
add_filter('the_content', 'div_wrapper');


// login screen
function my_login_logo() { ?>
  <style type="text/css">
      #login h1 a, .login h1 a {
        background-image: url(' data:image/png;base64,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');
        padding-bottom: 10px;
      }
      .wp-core-ui .button.button-large, .wp-core-ui .button.button-large:hover,  .wp-core-ui .button.button-large:focus {
        outline: 0;
        border: 0 none;
        text-shadow: none;
        background-color: black;
        box-shadow: none;
      }
  </style>
<?php } add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() {
    return 'My custom title';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );



//
// Only search for posts/products
//
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','SearchFilter');


// add woocommerce body class
function my_custom_body_class($classes) {
    $classes[] = 'woocommerce';
    return $classes;
}

// add my custom class via body_class filter
add_filter('body_class','my_custom_body_class');

// remove unwanted html comments
function callback($buffer) {
    $buffer = preg_replace('/<!--(.|s)*?-->/', '', $buffer);
    return $buffer;
}
function buffer_start() {
    ob_start("callback");
}
function buffer_end() {
    ob_end_flush();
}
add_action('get_header', 'buffer_start');
add_action('wp_footer', 'buffer_end');


// remove sorting
/*
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
*/

// sort catalogue by SKU number
/*
add_filter('woocommerce_get_catalog_ordering_args', 'am_woocommerce_catalog_orderby');
function am_woocommerce_catalog_orderby( $args ) {
    $args['meta_key'] = '_sku';
    $args['orderby'] = 'meta_value';
    $args['order'] = 'desc';
    return $args;
}
*/

// remove tabs
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );
    unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}

// Remove Add To Cart Button on Catalog Pages
add_action('wp_head', 'remove_add_cart_button_shop_page');
function remove_add_cart_button_shop_page(){
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10);
}

// Custom exerpt length
/*
function wpdocs_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );
*/

// Ajaxify cart
/*
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
  <div onclick="ga('send', 'event', { eventCategory: 'Conversion', eventAction: 'Cart open', eventLabel: 'Clicked'});" class="cart-contents" id="btn-open-cart" title="<?php _e( 'View your shopping cart' ); ?>">Cart (<?php echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?>)</div>
	<?php
  $fragments['.cart-contents'] = ob_get_clean();
	return $fragments;
}
*/

// Remove sale badges from loop
/*
add_filter('woocommerce_sale_flash', 'woo_custom_hide_sales_flash');
function woo_custom_hide_sales_flash() {
  return false;
}
*/


// remove breadcrumbs
/*
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
*/

// get gallery on all category products

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
	function woocommerce_get_product_thumbnail( $size = 'product-image-md', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post, $product,$woocommerce;
		if ( has_post_thumbnail() ) {
      $attachment_ids = $product->get_gallery_attachment_ids();
      $feature_image_alt = 'Product image for '.get_the_title();
      if ( $attachment_ids ) {
        $i=0;
        echo '<div class="mini-gallery"><div class="mini-gallery__hover">';
        foreach ( $attachment_ids as $attachment_id ) {
          if ($i<2) {
            $image_link = wp_get_attachment_image_src( $attachment_id, 'shop_catalog')[0];
            if ( ! $image_link )
              continue;
            $image_title = esc_attr( get_the_title( $attachment_id ) );
            echo apply_filters( 'woocommerce_get_product_thumbnail', sprintf( '<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="%s" data-index="%s" alt="%s">', $image_link, $i, $feature_image_alt), $attachment_id, $post->ID);
            $i++;
          }
        }
        echo '</div>';
      }
		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $size );
		}
	}
}

$shop_page_url = get_permalink( woocommerce_get_page_id( 'catalogue' ) );


// remove telephone number field in checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_phone']);
  return $fields;
}
function custom_override_billing_fields( $fields ) {
  unset($fields['billing']['billing_phone']);
  return $fields;
}

// number of items per page in catalogue
// remove_filter( 'loop_shop_per_page', 'storefront_products_per_page' );
// add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 99 );


// number of related products seen on PDP
/*
function woo_related_products_limit() {
  global $product;
	$args['posts_per_page'] = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 3 related products
	$args['columns'] = 1; // 1 column
	return $args;
}
*/


// get rid of WordPress SEO metabox
// function prefix_remove_wp_seo_meta_box() {
//   remove_meta_box( 'wpseo_meta', 'post', 'normal' );
//   remove_meta_box( 'wpseo_meta', 'product', 'normal' );
//   remove_meta_box( 'wpseo_meta', 'page', 'normal' );
// }
// add_action( 'add_meta_boxes', 'prefix_remove_wp_seo_meta_box', 100000 );

// hide some woocommerce options in the backend
function hide_woocommerce_options() { ?>
<style>
  .column-wpseo-score,
  .column-wpseo-title,
  .column-wpseo-metadesc,
  .column-wpseo-focuskw,
  .column-featured,
  .column-product_tag {
    display: none !important;
  }
</style>
<?php
}
add_action('admin_head', 'hide_woocommerce_options');


// remove related products (we will be using cross sell products)
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);

// change position of thumbnails
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
// remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_thumbnails', 100);


// change Woocommerce quantity input with a select dropdown
// function woocommerce_quantity_input($data) {
//     global $product;
//   $defaults = array(
//     'input_name'    => $data['input_name'],
//     'input_value'   => $data['input_value'],
//     'max_value'   => apply_filters( 'woocommerce_quantity_input_max', '', $product ),
//     'min_value'   => apply_filters( 'woocommerce_quantity_input_min', '', $product ),
//     'step'    => apply_filters( 'woocommerce_quantity_input_step', '1', $product ),
//     'style'   => apply_filters( 'woocommerce_quantity_style', 'display: inline;', $product )
//   );
//   if ( ! empty( $defaults['min_value'] ) )
//     $min = $defaults['min_value'];
//   else $min = 1;
//   if ( ! empty( $defaults['max_value'] ) )
//     $max = $defaults['max_value'];
//   else $max = 10;
//   if ( ! empty( $defaults['step'] ) )
//     $step = $defaults['step'];
//   else $step = 1;
//   $options = '';
//   for ( $count = $min; $count <= $max; $count = $count+$step ) {
//     $selected = $count === $defaults['input_value'] ? ' selected' : '';
//     $options .= '<option value="' . $count . '"'.$selected.'>' . $count . '</option>';
//   }
//   echo '<div class="quantity_select" style="' . $defaults['style'] . '"><select name="' . esc_attr( $defaults['input_name'] ) . '" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="qty">' . $options . '</select></div>';
// }


// function change_postsscreen_postcount(){
//   global $per_page, $wp_query;
//   $per_page = 500;
//   $posts_per_page = 100;
//   $wp_query->query('showposts='. $posts_per_page);
// }
// add_action('admin_head', 'change_postsscreen_postcount');

// Remove WooCommerce Updater
remove_action('admin_notices', 'woothemes_updater_notice');

// Ship to a different address closed by default
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

// USERS AND PRIVILEGES
// get the the role object
$role_object = get_role( 'shop_manager' );
$role_object->add_cap( 'edit_theme_options' );
?>
