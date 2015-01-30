<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Baseline' );
define( 'CHILD_THEME_URL', 'http://thestizmedia.com/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Enqueue Javascript files
add_action( 'wp_enqueue_scripts', 'baseline_enqueue_scripts' );
function baseline_enqueue_scripts() {
	wp_enqueue_script( 'baseline-global', get_stylesheet_directory_uri() . '/assets/js/global.js', array( 'jquery' ), '1.0.0', true );
	// Sidr slide out menu
	wp_enqueue_script( 'sidr',  get_stylesheet_directory_uri() . '/assets/js/jquery.sidr.min.js', array( 'jquery' ), '1.2.1', true );
}

//* Enqueue CSS files
add_action( 'wp_enqueue_scripts', 'baseline_enqueue_styles' );
function baseline_enqueue_styles() {
	wp_enqueue_style( 'google-font-roboto', '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic|Roboto+Condensed:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'baseline-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3' );
}

// Include our extra files to stay organized
include_once('includes/navigation.php');
include_once('includes/remove.php');

// Add new image size
// add_image_size( 'one-half', 565, 275, TRUE );

//* Activate After Entry widget area and display it on single posts
add_theme_support( 'genesis-after-entry-widget-area' );

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'baseline_post_info_filter' );
function baseline_post_info_filter($post_info) {
	$post_info = '[post_date] [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {
	return '200';
}

//* Modify the size of the Gravatar in comments
add_filter( 'genesis_comment_list_args', 'sp_comments_gravatar' );
function sp_comments_gravatar( $args ) {
	$args['avatar_size'] = 160;
	return $args;
}

// Change breadcrumb text/args
add_filter( 'genesis_breadcrumb_args', 'bl_breadcrumb_args' );
function bl_breadcrumb_args( $args ) {
    $args['home']                    = 'Home';
    $args['sep']                     = ' <div class="dashicons dashicons-arrow-right-alt2"></div> ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['prefix']                  = '<div class="breadcrumb">';
    $args['suffix']                  = '</div>';
    $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
    $args['heirarchial_categories']  = true; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['labels']['prefix']        = '';
    $args['labels']['author']        = '';
    $args['labels']['category']      = ''; // Genesis 1.6 and later
    $args['labels']['tag']           = '';
    $args['labels']['date']          = '';
    $args['labels']['search']        = 'Search for ';
    $args['labels']['tax']           = '';
    $args['labels']['post_type']     = '';
    $args['labels']['404']           = 'Not found: '; // Genesis 1.5 and later
    return $args;
}

// Customize the credits
add_filter( 'genesis_footer_creds_text', 'tsm_custom_footer_creds_text' );
function tsm_custom_footer_creds_text() {
?>
    <div class="creds">
    	<p>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> &middot; All Rights Reserved &middot; Website by <a href="http://thestizmedia.com" title="The Stiz Media, LLC">The Stiz Media, LLC</a>
		</p>
	</div>
<?php
}

/**
 * Change login logo
 * Max image width should be 320px
 * @link http://andrew.hedges.name/experiments/aspect_ratio/
 */
add_action('login_head',  'tsm_custom_dashboard_logo');
function tsm_custom_dashboard_logo() {
	echo '<style  type="text/css">
		.login h1 a {
			background-image:url('.get_stylesheet_directory_uri().'/images/logo.png)  !important;
			background-size: 320px 82px !important;
			width: 320px !important;
			height: 82px !important;
		}
	</style>';
}

// Change login link
add_filter('login_headerurl','tsm_loginpage_custom_link');
function tsm_loginpage_custom_link() {
	return get_site_url();
}