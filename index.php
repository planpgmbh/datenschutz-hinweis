<?php
/*
Plugin Name: Datenschutz Hinweis
Description: Besucher über Datenschutz informieren. ACF und Github Updater erforderlich.
Version: 1.7
Author URI: http://plan-p.de
GitHub Plugin URI: planpgmbh/datenschutz-hinweis
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

add_action('wp_enqueue_scripts', 'callback_for_setting_up_css');
function callback_for_setting_up_css() {
    wp_register_style( 'data-privacy-css', plugins_url( '/inlcude/min/data-privacy-min.css', __FILE__ ));
    wp_enqueue_style( 'data-privacy-css' );
    wp_enqueue_script( 'namespaceformyscript', plugins_url( '/inlcude/min/data-privacy-min.js', __FILE__ ), array( 'jquery' ) );
}

function insert_my_footer() {
    echo '
			<style scoped>
			#data-privacy, button.more-info, button.ok:hover, button.more-info:hover {
				background:'.get_field('first_color_field', 'option').';
			}
			button.ok {
				background:'.get_field('second_color_field', 'option').';
			}
			button.ok {
				color:'.get_field('first_color_field', 'option').';
			}
			#data-privacy p, button.more-info, button.ok:hover, button.more-info:hover {
				color:'.get_field('second_color_field', 'option').';
			}
			button.more-info:hover {
				border-color:'.get_field('first_color_field', 'option').';
			}
			button.ok, button.more-info, button.ok:hover {
				border-color:'.get_field('second_color_field', 'option').';
			}
			</style>';
    echo '<div id="data-privacy">';
		echo '<div id="data-privacy-text"><div class="data-privacy-wrapper">';
    echo get_field('main_text_field', 'option');
		echo '</div></div>';
    echo '<div id="data-privacy-choice"><div class="data-privacy-wrapper">';
    echo '<a href="'.get_field('imprint-page-field', 'option')['url'].'" target="_blank"><button class="more-info">'.get_field('imprint-page-field', 'option')['title'].'</button></a>';
		echo '<a href="'.get_field('data-privacy-page-field', 'option')['url'].'" target="_blank"><button class="more-info">'.get_field('data-privacy-page-field', 'option')['title'].'</button></a>';
    echo '<button class="ok">'.get_field('button_ok_field', 'option').'</button>';
    echo '</div></div>';
    echo '</div>';
}

add_action('wp_footer', 'insert_my_footer');

// Add Shortcode
function opt_out_data_privacy_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
    array(),
		$atts,
		'opt-out-data-privacy'
	);

	// Return only if has ID attribute
	if ( isset( $atts ) ) {
		return '<a href="#">Test</a>';
	}

}
add_shortcode( 'opt-out-data-privacy', 'opt_out_data_privacy_shortcode' );


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Datenschutz Hinweis',
		'menu_title'	=> 'Datenschutz',
		'menu_slug' 	=> 'data-privacy-settings',
		'capability'	=> 'edit_posts',
    'icon_url'    => 'dashicons-lock',
		'redirect'		=> false
	));

}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'text',
	'title' => 'Text',
	'fields' => array (
		array (
			'key' => 'main_text_field',
			'label' => 'Haupttext',
			'name' => 'main_text',
			'type' => 'wysiwyg',
      'toolbar' => 'basic',
      'media_upload' => 0,
      'default_value' => 'Um unsere Website für Sie optimal zu gestalten und fortlaufend verbessern zu können, aber auch für Analysen und zu Werbezwecken, verwenden wir Cookies. Nähere Informationen zu Cookies finden Sie in unserer Datenschutzerklärung. Dort erfahren Sie auch, wie Sie der Verwendung von Cookies widersprechen können.',
		),
    array (
			'key' => 'button_ok_field',
			'label' => 'Button-Text zum Zustimmen',
			'name' => 'button_ok',
			'type' => 'text',
      'default_value' => 'Zustimmen',
		),
    array (
			'key' => 'data-privacy-page-field',
			'label' => 'Link zur Datenschutzerklärung',
			'name' => 'data-privacy-page',
			'type' => 'link'
		),
		array (
			'key' => 'imprint-page-field',
			'label' => 'Link zum Impressum',
			'name' => 'imprint-page',
			'type' => 'link'
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'data-privacy-settings',
			),
		),
	),
  'menu_order' => 1,
));

acf_add_local_field_group(array(
	'key' => 'colors',
	'title' => 'Farbe',
	'fields' => array (
		array (
			'key' => 'first_color_field',
			'label' => 'Erste Farbe',
			'name' => 'first_color',
			'type' => 'color_picker',
		),
    array (
			'key' => 'second_color_field',
			'label' => 'Zweite Farbe',
			'name' => 'second_color',
			'type' => 'color_picker',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'data-privacy-settings',
			),
		),
	),
  'menu_order' => 2,
));
endif;
?>
