<?php
class typeahead{
public function __construct() {
				 add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
				 add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
}

//加载脚本
public function enqueue_scripts() {
  $settings = (array) get_option( 'typeahead' );
  $jquery = (bool) esc_attr( $settings['jquery'] );
  $number = (int) esc_attr( $settings['number'] );

	wp_register_script( 'typeahead', plugins_url('/libs/typeahead.min.js' , TYPEAHEAD_DIR ), $jquery?array('jquery-core'):false, '0.10.2', true );
	//wp_enqueue_script( 'typeahead' );

	wp_register_script( 'typeahead_config', plugins_url('config.js' , TYPEAHEAD_DIR), array('typeahead'), TYPEAHEAD_SCRIPTS_VERSION, true );
	wp_enqueue_script( 'typeahead_config' );

	wp_localize_script( 'typeahead_config', 'typeahead_settings', array(
		'ajaxurl'=> admin_url( 'admin-ajax.php' ),
		'number'=>$number,
		'nonce' => wp_create_nonce( 'typeahead' ),
		)
	);

}


//加载样式
public function enqueue_styles() {
	wp_register_style( 'typeahead_styles',plugins_url('styles.css' ,TYPEAHEAD_DIR), false, TYPEAHEAD_SCRIPTS_VERSION );
	wp_enqueue_style( 'typeahead_styles' );

}

}
?>