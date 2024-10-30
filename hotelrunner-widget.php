<?php
/**
 * Plugin Name:	HotelRunner Booking Button Widget
 * Description: This plugin adds HotelRunner Booking Widget to your website.
 * Version:	1.6
 * Author: HotelRunner
 * Author URI:	https://hotelrunner.com
 * License:	GPLv2 or later
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: hotelrunner
 * Domain Path: /languages
 *
 */

  // Exit if directly accessed files.
  if ( ! defined( 'ABSPATH' ) )
  {
    exit;
  }
  defined( 'ABSPATH' ) or die( 'You do not have any permission!' );

  define( 'HOTELRUNNER_VERSION' , '1.6' );
  define( 'HOTELRUNNER_FILE', __FILE__ );
  define( 'HOTELRUNNER_PATH', wp_normalize_path( plugin_dir_path( HOTELRUNNER_FILE ) ) );
  define( 'HOTELRUNNER_URL', plugin_dir_url( HOTELRUNNER_FILE ) );
  define( 'HOTELRUNNER_BASENAME', plugin_basename( HOTELRUNNER_FILE ) );
  define( 'HOTELRUNNER_DIR_NAME', dirname( HOTELRUNNER_BASENAME ) );
  define( 'HOTELRUNNER_TEXT_DOMAIN', 'hotelrunner' );

  // Load text domain.
  function hotelrunner_load_textdomain()
  {
    load_plugin_textdomain( HOTELRUNNER_TEXT_DOMAIN, false, HOTELRUNNER_PATH . 'languages' );
  }

  if( !function_exists( 'add_action' ) )
  {
    echo "You do not have any permission!";
    exit;
  }

  // Load Class
  require_once(plugin_dir_path(__FILE__).'/inc/hotelrunner-class.php');

  // Register Widget
  function register_hotelrunner()
  {
    register_widget('HotelRunner_Widget');
  }
  add_action( 'widgets_init', 'register_hotelrunner'  );
  add_action( 'init', 'hotelrunner_load_textdomain'   );

  add_action( 'wp_enqueue_scripts', 'enqueue_wp');
  add_action( 'admin_enqueue_scripts', 'enqueue_admin');

  /* ADMIN SCRIPTS AND STYLES */
  function enqueue_admin()
  {
   	wp_enqueue_script( 'hotelrunner-admin-script', plugins_url( '/assets/js/jscolor.js', __FILE__ ) );
    $hotelrunner_admin_css = date( "ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/hotelrunner-style.css' ) );
    $hotelrunner_bootstrap_css = 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css';
    wp_register_style( 'hotelrunner-admin-style', plugins_url( 'assets/css/hotelrunner-style.css', __FILE__ ), false, $hotelrunner_admin_css );
    wp_register_style( 'hotelrunner-bootstrap-style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', false, $hotelrunner_bootstrap_css );
    wp_enqueue_style ( 'hotelrunner-admin-style' );
    //wp_enqueue_style ( 'hotelrunner-bootstrap-style' );
  }

  function enqueue_wp()
  {
    $hotelrunner_book_css = 'https://d2uyahi4tkntqv.cloudfront.net/assets/shared.booknow.css';
    wp_register_style( 'hotelrunner-book-style', 'https://d2uyahi4tkntqv.cloudfront.net/assets/shared.booknow.css', false, '' );
    wp_enqueue_style ( 'hotelrunner-book-style' );

    $hotelrunner_search_css = 'https://d2uyahi4tkntqv.cloudfront.net/assets/search_widget.css';
    wp_register_style( 'hotelrunner-search-style', 'https://d2uyahi4tkntqv.cloudfront.net/assets/search_widget.css', false, '' );
    wp_enqueue_style( 'hotelrunner-search-style' );
    wp_enqueue_script( 'hotelrunner-search-script', plugins_url( '/assets/js/search_widget.js', __FILE__ ) );
  }

  require_once( 'inc/hotelrunner-admin-functions.php' );

	function load_hotelrunner_widget( $atts )
  {
    $hrcode      = get_option( 'hr-hotel_code', 'hr-template' );
    $hrwl        = get_option( 'hr-widget_layout', 'inline' );
    // replace 'Square' to 'square'
    $hrwl2       = str_replace( "square", "square", $hrwl );
    $hrdrop      = get_option( 'hr-drop', 'down' );
    $bgcolor     = get_option( 'hr-bgcolor', '#111' );
    $inputcolor  = get_option( 'hr-inputcolor', '#333' );
    $textcolor   = get_option( 'hr-textcolor', '#fff' );
    $hrlang      = get_option( 'hotelrunner_lang', 'en-US' );
    $hr_currency = get_option( 'hotelrunner_currency', 'USD' );
    $hr_target   = get_option( 'hotelrunner_target_link', '_blank' );
    $hotelrunner_target_domain = get_option( 'hotelrunner_target_domain', '' );

    extract(shortcode_atts( array(
      /* PARAMETER   || DEFAULTS */
      'propertycode' => $hrcode,
      'layout'       => $hrwl2,
      'drop'         => $hrdrop,
      'bg'           => $bgcolor,
      'inputcolor'   => $inputcolor,
      'lang'         => $hrlang,
      'textcolor'    => $textcolor,
      'target'       => $hr_target,
      'currency'     => $hr_currency,
      'target_domain'     => $hotelrunner_target_domain
    ), $atts ));
    if(empty("{$layout}")) {
      $hlayout = $hrwl2;
    }
    else {
      $hlayout = "{$layout}";
    }

    if(empty("{$inputbg}")) {
      $inputclr = $inputcolor;
    }
    else {
      $inputclr = "{$inputbg}";
    }

    // TRUE or FALSE = is shortcode or not
    $widgetcontent = load_widget( true, "{$bg}", "{$inputcolor}", "{$textcolor}", "{$layout}", "{$drop}", "{$lang}", "{$propertycode}", "{$target}", "{$currency}" , "{$target_domain}");
    return $widgetcontent;
	}

  add_shortcode( 'hotel_runner', 'load_hotelrunner_widget'       );
	add_shortcode( 'hotelrunner_widget', 'load_hotelrunner_widget' );
	add_shortcode( 'hotelrunner', 'load_hotelrunner_widget'        );

	// Load the init file.
	require( HOTELRUNNER_PATH . 'inc/init.php' );
