<?php
/*
Plugin Name: 自动文章目录
Plugin URI: http://hcsem.com/jquery-content-directory/
Description: 自动为文章添加目录。
Version: 1.0
Author: 聪崽
Author URI: http://hcsem.com/
*/

DEFINE("JQUERY_CD_URL", WP_PLUGIN_URL . "/jquery-content-directory");

if(!is_admin()){
	add_action('init', 'jquery_cd_init');
}
add_action('admin_init', 'jquery_cd_options_init');
add_action('admin_menu', 'jquery_cd_options_menu');


register_activation_hook( __FILE__, 'jquery_cd_activate' );
register_uninstall_hook( __FILE__, 'jquery_cd_uninstall' );

function jquery_cd_activate() {
		  $options = get_option('jquery_cd_options');
		  foreach (array(
		    'source_selector' => '.single .entry',
		    'header_tag' => 'h2',
		    'output_id' => 'jquery_cd',
		    'output_title' => '目录',
		  ) as $option_name => $default) {
		    if ($options[$option_name] == '') { $options[$option_name] = $default; }
		  }
		  update_option('jquery_cd_options', $options);
}

function jquery_cd_uninstall() {
  delete_option('jquery_cd_options');
}

function jquery_cd_init() {
  wp_enqueue_script('jquery-cd', JQUERY_CD_URL . '/jquery-cd.js', array('jquery'));
  wp_localize_script('jquery-cd', 'jQueryCD', get_option('jquery_cd_options'));
  wp_enqueue_style('jquery-cd', '/wp-content/plugins/jquery-content-directory/jquery-cd.css');
}

function jquery_cd_options_init() {
  register_setting('jquery_cd_options', 'jquery_cd_options');

  add_settings_section('jquery_cd_section_theme', '风格设置', 'jquery_cd_section_theme', 'jquery_cd');
  add_settings_field('jquery_cd_field_source_selector', '文章选择器：', 'jquery_cd_field_source_selector', 'jquery_cd', 'jquery_cd_section_theme');
  add_settings_field('jquery_cd_field_header_tag', '分段标签：', 'jquery_cd_field_header_tag', 'jquery_cd', 'jquery_cd_section_theme');

  add_settings_section('jquery_cd_section_output', '生成设置：', 'jquery_cd_section_output', 'jquery_cd');
  add_settings_field('jquery_cd_field_output_title', '目录标题：', 'jquery_cd_field_output_title', 'jquery_cd', 'jquery_cd_section_output');
  add_settings_field('jquery_cd_field_output_id', 'CSS名称：', 'jquery_cd_field_output_id', 'jquery_cd', 'jquery_cd_section_output');
}

function jquery_cd_options_menu() {
  add_options_page('jQuery TOC Options', '自动文章目录设置', 'edit_themes', 'jquery_cd', 'jquery_cd_options_page');

}

function jquery_cd_options_page() {
  ?>
  <div class="wrap">
    <h2>自动文章目录设置</h2>
      <p>支持聪崽的：<a href="http://www.hcsem.com/">广西SEO</a></p>
    <form method="post" action="options.php">
      <?php 
        settings_fields('jquery_cd_options');
        do_settings_sections('jquery_cd');
      ?>
      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('保存设置') ?>" />
      </p>
    </form>
  </div>
  <?php 
}
        
function jquery_cd_section_theme() { 
  ?>
  <p>您需要针对你的文章页风格来对本插件进行设置。</p>
  <?php
}

function jquery_cd_field_source_selector() {
  $options = get_option('jquery_cd_options');
  ?>
  <p><input type="text" name="jquery_cd_options[source_selector]" 
            value="<?php echo $options['source_selector']; ?>" /></p>
  <p>本插件需要知道您的文章正文是在哪个标签之中间，这样才能正确分析您的文章段落是如何分布的。默认为 <code>.single .entry</code></p>
  <?php
}

function jquery_cd_field_header_tag() {
  $options = get_option('jquery_cd_options');
  ?>
  <p><input type="text" name="jquery_cd_options[header_tag]" 
           value="<?php echo $options['header_tag']; ?>" /></p>
  <p>您希望通过哪个标签区分文章段落的，默认为 <code>h2</code>。
  <?php
}

function jquery_cd_section_output() { 
  ?>
  <p>设置目录格式：</p>
  <?php
}

function jquery_cd_field_output_title() {
  $options = get_option('jquery_cd_options');
  ?>
  <p><input type="text" name="jquery_cd_options[output_title]" 
           value="<?php echo $options['output_title']; ?>" /></p>
  <p>您希望的目录的标题。</p>
  <?php
}

function jquery_cd_field_output_id() {
  $options = get_option('jquery_cd_options');
  ?>
  <p><input type="text" name="jquery_cd_options[output_id]" 
           value="<?php echo $options['output_id']; ?>" /></p>
  <p>设置目录所在标签的ID值，默认为 <code>jquery_cd</code> ，可以在jquery-cd.css中修改样式达到不同的样式效果，也可以在 style.css 文件中设置。</p>
  <?php
}

?>