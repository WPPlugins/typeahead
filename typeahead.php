<?php
/*
Plugin Name: typeahead
Plugin URI: http://binaryoung.com/typeahead
Description: 为您的网站搜索框添加搜索下拉词条建议功能。
Author: young
Version: 0.2
Author URI: http://binaryoung.com/
*/

//CODE IS POETRY

define('TYPEAHEAD_PLUGIN_VERSION', '0.2');
define('TYPEAHEAD_SCRIPTS_VERSION', '0.1');
define('TYPEAHEAD_DIR', __FILE__);


function typeahead_get_class(){
if(defined('DOING_AJAX') && DOING_AJAX){
return 'ajax';
}else 
if(is_admin()){
return 'admin';
}else{
return 'front';
}
}

spl_autoload_register('typeahead_load_class'); 

function typeahead_load_class($classname){
if($classname=='typeahead'){
 include_once(WP_PLUGIN_DIR.'/typeahead/inc/'.typeahead_get_class().'.php');
}
}

$typeahead = new typeahead();













?>