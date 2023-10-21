<?php 
/*
 * Plugin Name:       Ann's Simple Restaurant Menu
 * Plugin URI:        https://github.com/a-newcomer
 * Description:       A plugin to create a menu on site.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ann Newcomer
 * Author URI:        https://annssite.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       afn-simple-restaurant-menu
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC')) {
    die;
}

define( 'AFN_VERSION', '1.0.0' );
define( 'AFNDOMAIN', 'simple-restaurant-menu' );
define( 'AFNPATH', plugin_dir_path( __FILE__ ) );

require_once( AFNPATH . '/post-types/register.php');
add_action( 'init', 'afn_register_menu_type' );

/*
 * Tell WordPress to use Page templates from here in plugin templates file "afn-simple-restaurant-menu"
 */

 function afn_include_template($template) {
    if (get_post_type() == 'menu_section') {
        if (is_single()) {
            if ($theme_file = locate_template(['single-menu_section.php'])) {
                $template = $theme_file;
            } else {
                $template = AFNPATH . 'templates/single-menu_section.php';
            }
        } elseif (is_archive()) {
            if ($theme_file = locate_template(['archive-menu_section.php'])) {
                $template = $theme_file;
            } else {
                $template = AFNPATH . 'templates/archive-menu_section.php';
            }
        }
    }
    return $template;
}
add_filter('template_include', 'afn_include_template');

//add a page template or templates that can be used for a list of menu sections:
    function menu_template_array() {
        $templates = [];
        $templates['menu-page-template.php'] = 'Menu Page Template';
        return $templates;
    }
    function menu_template_register($page_templates, $theme, $post) {
        $template_arr = menu_template_array();

        foreach($template_arr as $tk=>$tv) {
            $page_templates[$tk] = $tv;
        }
        return $page_templates;
    }
    add_filter('theme_page_templates', 'menu_template_register', 10, 3);

    //help wordpress find the template
    function select_menu_template($template) {
        global $post, $wp_query, $wpdb;

        $page_temp_slug = get_page_template_slug( $post->ID );
        $templates = menu_template_array();
        if(isset($templates[$page_temp_slug]) ) {
            $template = AFNPATH . 'templates/' . $page_temp_slug;
        }
        return $template;
    }
    add_filter('template_include', 'select_menu_template', 99);
// add styles
function add_menu_section_stylesheet() {
	wp_register_style('menu-section-styles', plugins_url('/afn-simple-restaurant-menu/menu-section-styles/menu-section-styles.css') );
	wp_enqueue_style('menu-section-styles');
}
add_action('wp_enqueue_scripts', 'add_menu_section_stylesheet');

//use ACF files as json in the plugin
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point($path) {
    $path = AFNPATH . '/acf-json';

    return $path;
}

//load the json files from the plugin
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point($paths) {
    //remove original path
    unset( $paths[0] );

    //append our new path
    $paths[] = AFNPATH . '/acf-json';
    
    return $paths;
}