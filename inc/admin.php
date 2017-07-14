<?php
class typeahead{
public function __construct() {
				 register_activation_hook( TYPEAHEAD_DIR, array( $this, 'activate' ) );//安装插件时添加设置
				 register_uninstall_hook(TYPEAHEAD_DIR, array( $this, 'delete_options' ) );//删除插件时删除设置
				 register_deactivation_hook( TYPEAHEAD_DIR, array( $this, 'delete_options' ) ); 
				 add_filter('plugin_action_links',array( $this, 'settings_link' ),10,2);
				 add_action( 'admin_menu', array( $this, 'menu' ) );
				 add_action( 'admin_init', array( $this, 'admin_init' ) );
}

public function activate(){
  $option_defaults=array('number'=>10 ,'jquery'=>true,'cdn'=>false,'compress'=>false); //默认设置
	add_option('typeahead', $option_defaults);
}

public function delete_options() {
        delete_option('typeahead');
}

public function settings_link($action_links,$plugin_file){
	if($plugin_file==plugin_basename(TYPEAHEAD_DIR)){
		$settings_link = '<a href="options-general.php?page=typeahead">'.__("Settings").'</a>';
		array_unshift($action_links,$settings_link);
	}
	return $action_links;
}



//管理界面

public function menu() {
    add_options_page( 'typeahead设置', 'typeahead设置', 'manage_options', 'typeahead', array( $this, 'options_page' ));
}

public function options_page() {
    ?>
    <div class="wrap">
        <h2>typeahead设置</h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'typeahead-group' ); ?>
            <?php do_settings_sections( 'typeahead' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


public function admin_init() {
    register_setting( 'typeahead-group', 'typeahead' );
    add_settings_section( 'typeahead-basic', '基本设置', array( $this, 'basic_callback' ), 'typeahead' );
		add_settings_section( 'typeahead-suggest', '意见反馈', array( $this, 'suggest_callback' ), 'typeahead' );
    add_settings_field( 'typeahead-item-number', '下拉提示词条数量', array( $this, 'item_number_callback' ), 'typeahead', 'typeahead-basic' );
		add_settings_field( 'typeahead-jquery', '是否加载jquery',array( $this, 'jquery_callback' ) , 'typeahead', 'typeahead-basic' );
}

public function suggest_callback() {
    echo '你的意见是我不断成长的动力，欢迎给我<a href="http://binaryoung.com/typeahead">留言</a>，报告BUG或提出好的建议或功能需求，或许你想要的功能下一个版本就会实现哦！';
}

public function basic_callback() {
    echo '';
}

public function item_number_callback() {
    $settings = (array) get_option( 'typeahead' );
    $number = (int) esc_attr( $settings['number'] );
    echo '<input type="text" name="typeahead[number]" value="'.$number.'" />';
}

public function jquery_callback() {
    $settings = (array) get_option( 'typeahead' );
    $jquery = (bool) esc_attr( $settings['jquery'] );
    echo '<input type="checkbox" name="typeahead[jquery]" value="1"'.checked($jquery,true,false).'/><br/><br/>本插件使用typeahead插件提供搜索下拉词条提示功能，需加载jquery。如网站已加载jquery则无需勾选此项，若勾选此项，插件则会加载jquery。';
}

}
?>