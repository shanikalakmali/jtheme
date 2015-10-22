<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';

/*create custom taxonomy -for testimonials*/

//create new post type
function postype_testimonial_init(){

	$labels=array(
			'name'=>'Testimonials',
			'all_items'=>'All Testimonials',
			'add_new'=>'Add New',
			'add_new_item'=>'Add New Testimonial'
	);
	

	register_post_type( 
		'testimonial_type',
		array(
			'labels'=>$labels,
			'description'=>'post type for testiomonials',
			'public'=>true,
			'publicly_queryable'=>true,
			'show_ui'=>true,
			'menu_position'=>5,
			'menu_icon'=>'dashicons-awards',
			'capability_type'=>'post',
			'hierarchical'=>true,
			'supports'=>array('title','editor','thumbnail','custom-feilds','page_attributes','custom-fields','revisions','excerpt')
		)
	);


}

add_action('init','postype_testimonial_init');



//create new taxonomy
function testimonial_init(){
	
	$labels=array(
		'add_new_item'=>'Add New Category',
		'parent_item'=>__('Parent Category'),
		'parent_item_colon'=>__('Parent Category:'),
		'search_items'=>__('Search Category')
	);
	
	register_taxonomy(
		'testimonial',
		'testimonial_type',
		array(
			'label'=>__('Categories'),
			'labels'=>$labels,
			'hierarchical'=>true,
			'rewrite'=>array('slug'=>'testimonial'),
			'capabilities'=>array(
				'assign_terms'=>true,
				'edit_terms'=>true,
				'manage_terms'=>true,
				'delete_terms'=>true
			)
		)
	);
}

add_action('init','testimonial_init');

//create custom fields

add_action('add_meta_boxes','addJCustomFields');
add_action('save_post','saveJCuctomFields',1,2);

//remove default custom feilds
add_action( 'do_meta_boxes','removeDefaultCustomFields', 10, 3 );

function removeDefaultCustomFields( $type, $context, $post ) {
    foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
        
            remove_meta_box( 'postcustom', 'testimonial_type', $context );
        
    }
}
	
//create custom fields -continue	
function addJCustomFields(){
	add_meta_box('jcustom-feilds','Custom Feilds','displayJCustomFeilds','testimonial_type','normal','high');
	wp_nonce_field( 'jcustom-cretate','jcustom-cretate-nonce');
}
		
function displayJCustomFeilds($post){
	wp_nonce_field( 'jcustom-cretate','jcustom-display-nonce');
			
	$uname_feild=get_post_meta($post->ID,'uname_custom',true);
	$designation_feild=get_post_meta($post->ID,'designation_custom',true);
	$testimonial_field=get_post_meta($post->ID,'testimonial_custom',true);
	
	?>
	<div class="wrap">
	<label for="jnew_feild1">Name</label><br/>
	<input type="text" id="uname_custom" name="uname_custom" value="<?php echo $uname_feild; ?>"/>
	</div>
	
	<div class="wrap">
	<label for="jnew_feild2">Designation</label><br/>
	<input type="text" id="designation_custom" name="designation_custom" value="<?php echo $designation_feild; ?>"/>
	</div>
	
	<!--<div class="wrap">
	<label for="jnew_feild3">Testimonial</label><br/>
	<textarea id="testimonial_custom" name="testimonial_custom" rows="10" cols="40"><?php echo $testimonial_feild; ?></textarea>
	</div>-->
	<?php
			
}
		
function saveJCuctomFields($post_id,$post){
	if (!isset($_POST['jcustom-display-nonce'])||!wp_verify_nonce($_POST['jcustom-display-nonce'],'jcustom-cretate')){
		return $post_id;
	}
			
	$post_type=get_post_type_object($post->post_type);
			
	if(!current_user_can($post_type->cap->edit_post,$post_id))
		return $post_id;
	
	
		$uname=sanitize_text_field($_POST['uname_custom']);
		update_post_meta($post_id,'uname_custom',$uname);
	
		$udesignation=sanitize_text_field($_POST['designation_custom']);
		update_post_meta($post_id,'designation_custom',$udesignation);
	
		/*$utestimonial=$_POST['testimonial_custom'];
		update_post_meta($post_id,'testimonial_custom',$utestimonial);*/
	
			
}

/*create testimonial widget*/
class Testimonial_Widget extends WP_Widget{
function __construct() {
	parent::__construct(
		'testimonial_widget', // Base ID
		'Testimonial Widget', // Name
		array('description' => __( 'Displays your latest listings. Outputs the post thumbnail, title and date per listing'))
	   );
}
function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberOfTestimonial'] = strip_tags($new_instance['numberOfTestimonial']);
		return $instance;
}


function form($instance) {
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberOfTestimonial = esc_attr($instance['numberOfTestimonial']);
	} else {
		$title = '';
		$numberOfTestimonial = '';
	}
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'testimonial_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('numberOfTestimonial'); ?>"><?php _e('Number of Testimonial:', 'realty_widget'); ?></label>
		<select id="<?php echo $this->get_field_id('numberOfTestimonial'); ?>"  name="<?php echo $this->get_field_name('numberOfTestimonial'); ?>">
			<?php for($x=1;$x<=10;$x++): ?>
			<option <?php echo $x == $numberOfTestimonial ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
			<?php endfor;?>
		</select>
		</p>
	<?php
	}

function widget($args, $instance) {
	extract( $args );
	$title = apply_filters('widget_title', $instance['title']);
	$numberOfTestimonial = $instance['numberOfTestimonial'];
	echo $before_widget;
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}
	$this->getRealtyTestimonial($numberOfTestimonial);
	echo $after_widget;
}

function getRealtyTestimonial($numberOfTestimonial) { //html
	global $post;
	add_image_size( 'testimonial_widget_size', 85, 45, false );
	$listings = new WP_Query();
	$listings->query('post_type=testimonial_type&posts_per_page=' . $numberOfTestimonial );
	if($listings->found_posts > 0) {
		echo '<ul class="testimonial_widget">';
			while ($listings->have_posts()) {
				$listings->the_post();
				$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'testimonial_widget_size') : '<div class="noThumb"></div>';
				$listItem = '<li>' . $image;
				$listItem .= '<a href="' . get_permalink() . '">';
				$listItem .= get_the_title() . '</a>';
				$listItem .= '<span> ' . get_the_date() . '</span></li>';
				$listItem .= '<span> ' . get_the_content() . '</span></li>';
				echo $listItem;
			}
		echo '</ul>';
		wp_reset_postdata();
	}else{
		echo '<p style="padding:25px;">No listing found</p>';
	}
}

} //end class testimonial Widget
register_widget('Testimonial_Widget');



