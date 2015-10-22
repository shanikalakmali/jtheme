<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.2.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

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
	//$testimonial_field=get_post_meta($post->ID,'testimonial_custom',true);
	
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


class Testimonial_Widget extends WP_Widget{
function __construct() {
	parent::__construct(
		'testimonial_widget', // Base ID
		'Testimonial Widget', // Name
		array('description' => __( 'Displays your latest Testimonials'),
		)
		
	   );
}
function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberOfTestimonial'] = strip_tags($new_instance['numberOfTestimonial']);
		$instance['show_image'] = strip_tags($new_instance['show_image']);
		$instance['show_name'] = strip_tags($new_instance['show_name']);
		$instance['show_designation'] = strip_tags($new_instance['show_designation']);
		$instance['category_select'] = strip_tags($new_instance['category_select']);
		return $instance;
}


function form($instance) {
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberOfTestimonial = esc_attr($instance['numberOfTestimonial']);
		$show_image = esc_attr($instance['show_image']);
	    $show_name = esc_attr($instance['show_name']);
	    $show_designation = esc_attr($instance['show_designation']);
		$category_select = esc_attr($instance['category_select']);
		
	} else {
		$title = '';
		$numberOfTestimonial = '';
		$show_image = '';
		$show_name = '';
		$show_designation = '';
		$category_select='';
		
	}
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'testimonial_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('numberOfTestimonial'); ?>"><?php _e('Number of Testimonial:', 'testimonial_widget'); ?></label>
		<select id="<?php echo $this->get_field_id('numberOfTestimonial'); ?>"  name="<?php echo $this->get_field_name('numberOfTestimonial'); ?>">
			<?php for($x=1;$x<=10;$x++): ?>
			<option <?php echo $x == $numberOfTestimonial ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
			<?php endfor;?>
		</select>

		</p>
        <p>
		<input id="<?php echo ( $this->get_field_id( 'show_image' ) ); ?>" type="checkbox" name="<?php echo ( $this->get_field_name( 'show_image' ) ); ?>" value="1" <?php checked( $instance['show_image'] ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php _e( 'Show Featured Image', 'testimonial_widget' ); ?></label>
		</p>
		<p>
		<input id="<?php echo ( $this->get_field_id( 'show_name' ) ); ?>" type="checkbox" name="<?php echo ( $this->get_field_name( 'show_name' ) ); ?>" value="1" <?php checked( $instance['show_name'] ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_name' ) ); ?>"><?php _e( 'Show Title', 'testimonial_widget' ); ?></label>
		</p>
		<p>
		<input id="<?php echo ( $this->get_field_id( 'show_designation' ) ); ?>" type="checkbox" name="<?php echo ( $this->get_field_name( 'show_designation' ) ); ?>" value="1" <?php checked( $instance['show_designation'] ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_designation' ) ); ?>"><?php _e( 'Show Designation', 'testimonial_widget' ); ?></label>
		</p>
		<p>
        <label for="<?php echo $this->get_field_id('category_select'); ?>"><?php _e('Category', 'lang'); ?></label>
		<select id="<?php echo $this->get_field_id('category_select'); ?>" name="<?php echo $this->get_field_name('category_select'); ?>" class="widefat" style="width:100%;">
            <option value="0">All</option>
			<?php foreach(get_terms('testimonial','parent=0&hide_empty=0') as $term) { ?>
            <option <?php selected( $category_select, $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
            <?php } ?>      
        </select>
		</p>
                    
<?php
  
}

    function widget($args, $instance) 
	{
	extract( $args );
	$title = apply_filters('widget_title', $instance['title']);
	$numberOfTestimonial = $instance['numberOfTestimonial'];
	$show_image = $instance['show_image'];
	$show_name = $instance['show_name'];
	$show_designation = $instance['show_designation'];
	$category_select = $instance['category_select'];
	echo $before_widget;
	if ( $title ) 
	{
		echo $before_title . $title . $after_title;
	}
	$this->getRealtyTestimonial($numberOfTestimonial, $show_image, $show_name, $show_designation, $category_select);
	
	
	echo $after_widget;
	
    }
	

function getRealtyTestimonial($numberOfTestimonial, $show_image, $show_name, $show_designation, $category_select) { 
	global $post;
	
	add_image_size( 'testimonial_widget_size', 85, 45, false );
	
	if($category_select!='0'){
		$args = array(
			  'post_type' => 'testimonial_type',
			  'post_status'=>'publish',
			  'showposts'=>$numberOfTestimonial,
			  'tax_query' => array(
					array(
						'taxonomy' => 'testimonial',
						'field' => 'id',
						'terms' => $category_select
					)
				)
			  
			);
	}else{
		$args = array(
			  'post_type' => 'testimonial_type',
			  'post_status'=>'publish',
			  'showposts'=>$numberOfTestimonial  
			);
	}
	
	$listings = new WP_Query($args);
	if($listings->have_posts()) {
		echo '<ul class="testimonial_widget">';
			while ($listings->have_posts()) {
				$listings->the_post();
				
				$term_list = wp_get_post_terms( $post->ID, 'testimonial',array("fields" => "all"));
				$name=get_post_meta($post->ID,'uname_custom',true);
				$designation=get_post_meta($post->ID,'designation_custom',true);
				$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'testimonial_widget_size') : '<img width="80" height="80" src="'.get_stylesheet_directory_uri().'/images/defaults/default_user.jpg" class="wp-post-image" alt="thumbnail">';
				if(!empty($show_image)){
					$listItem = '<li>'.$image.'<br/>' ;}
				else{ $listItem = '<li>';}
				//$listItem .= '<a href="' . get_permalink() . '">'.get_the_title() . '</a><br/>';
				if(!empty($show_name)){
					$listItem .= '<span> Name : ' . $name . '</span><br/>';
				}
				if(!empty($show_designation)){
					$listItem .= '<span> Designation : ' . $designation . '</span><br/>';
				}
				
				$listItem .= '<span> ' . get_the_date() . '</span></li>';
				$listItem .= '<li><span> ' . get_the_content() . '</span></li>';
				echo $listItem;
			
				
				
				
			}
			      
		echo '</ul>';
		wp_reset_postdata();
	}else{
		echo '<p style="padding:25px;">No testimonial found</p>';
	}
}

} //end class Realty_Widget

register_widget('Testimonial_Widget');