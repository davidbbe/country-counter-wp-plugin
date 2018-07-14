<?php
/*
 * Plugin Name: Country Counter
 * Plugin URI: https://wordpress.org/plugins/country-counter
 * Description: Display a percentage and graph of countries you have been to in the world.
 * Version: 1.0
 * Author: David Beauchamp
 * Author URI: https://daveb.co
 * Text Domain: country-counter
 */
 
class country_counter_widget extends WP_Widget {
	// Create Multiple WordPress Widgets
  function __construct() {
    parent::__construct('country_counter_widget', __('Country Counter', 'country_counter_plugin_domain'), array(
      'description' => __('Display the percentage and graph of countries been to.', 'country_counter_plugin_domain')
    ));
  }
    
  // This function creates the output
  public function widget($args, $instance) {
    $ccw_title = apply_filters('ccw_title', $instance['ccw_title']);
    $ccw_world = apply_filters('ccw_world', $instance['ccw_world']);
    $ccw_north_am = apply_filters('ccw_north_am', $instance['ccw_north_am']);
    $ccw_south_am = apply_filters('ccw_south_am', $instance['ccw_south_am']);
    $ccw_europe = apply_filters('ccw_europe', $instance['ccw_europe']);
    $ccw_africa = apply_filters('ccw_africa', $instance['ccw_africa']);
    $ccw_asia = apply_filters('ccw_asia', $instance['ccw_asia']);
    $ccw_oceania = apply_filters('ccw_oceania', $instance['ccw_oceania']);
  
    $ccw_world_group = '';
    $ccw_continents_group = '';
    
    echo $before_widget;
    echo $before_title . '<h4 class="widget-title">' . $ccw_title . '</h4>' . $after_title;
    echo $ccw_world_group;
    echo $ccw_continents_group;
    echo '<p style="font-size:12px;color:#555;line-height:12px;">The 194 countries of the world are based on <a target="_blank" href="https://www.worldatlas.com/cntycont.htm">this list</a>.</p>';
    echo $after_widget;
  }
  
  // Create Instance and Assign Values
  public function form($instance) {
    if (isset($instance['ccw_title'])) {$ccw_title = $instance['ccw_title'];}
    else {$ccw_title = 'The Counter';}

    if (isset($instance['ccw_world'])) {$ccw_world = $instance['ccw_world'];}
    else {$ccw_world = '0';}
    
    if (isset($instance['ccw_north_am'])) {$ccw_north_am = $instance['ccw_north_am'];}
    else {$ccw_north_am = '0';}

    if (isset($instance['ccw_south_am'])) {$ccw_south_am = $instance['ccw_south_am'];}
    else {$ccw_south_am = '0';}

    if (isset($instance['ccw_europe'])) {$ccw_europe = $instance['ccw_europe'];}
    else {$ccw_europe = '0';}
    
    if (isset($instance['ccw_africa'])) {$ccw_africa = $instance['ccw_africa'];}
    else {$ccw_africa = '0';}

    if (isset($instance['ccw_asia'])) {$ccw_asia = $instance['ccw_asia'];}
    else {$ccw_asia = '0';}

    if (isset($instance['ccw_oceania'])) {$ccw_oceania = $instance['ccw_oceania'];}
    else {$ccw_oceania = '0';}
?>
 
<!--  This is the widget form -->
<p>
  <label for="<?php echo $this->get_field_id('ccw_title'); ?>"> <?php _e('Title');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_title');?>" name="<?php echo $this->get_field_name('ccw_title');?>" type="text" value="<?php echo esc_attr($ccw_title);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_world'); ?>"> <?php _e('Total countries been to (194 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_world');?>" name="<?php echo $this->get_field_name('ccw_world');?>" type="number" min="0" max="194" value="<?php echo esc_attr($ccw_world);?>" />
 
  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_north_am'); ?>"> <?php _e('North America (23 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_north_am');?>" name="<?php echo $this->get_field_name('ccw_north_am');?>" type="number" min="0" max="23" value="<?php echo esc_attr($ccw_north_am);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_south_am'); ?>"> <?php _e('South America (12 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_south_am');?>" name="<?php echo $this->get_field_name('ccw_south_am');?>" type="number" min="0" max="12" value="<?php echo esc_attr($ccw_south_am);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_europe'); ?>"> <?php _e('Europe (47 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_europe');?>" name="<?php echo $this->get_field_name('ccw_europe');?>" type="number" min="0" max="47" value="<?php echo esc_attr($ccw_europe);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_africa'); ?>"> <?php _e('Africa (54 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_africa');?>" name="<?php echo $this->get_field_name('ccw_africa');?>" type="number" min="0" max="54" value="<?php echo esc_attr($ccw_africa);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_asia'); ?>"> <?php _e('Asia (44 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_asia');?>" name="<?php echo $this->get_field_name('ccw_asia');?>" type="number" min="0" max="44" value="<?php echo esc_attr($ccw_asia);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_oceania'); ?>"> <?php _e('Oceania (14 possible)');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_oceania');?>" name="<?php echo $this->get_field_name('ccw_oceania');?>" type="number" min="0" max="14" value="<?php echo esc_attr($ccw_oceania);?>" />
 
</p>
 
<?php
  }
    
  // Updating widget replacing old instances with new
  function update($new_instance, $old_instance) {
    $instance = array();
    $instance['ccw_title'] = (!empty($new_instance['ccw_title'])) ? strip_tags($new_instance['ccw_title']) : 'The Counter';
    $instance['ccw_world'] = (!empty($new_instance['ccw_world'])) ? strip_tags($new_instance['ccw_world']) : '0';  
    $instance['ccw_north_am'] = (!empty($new_instance['ccw_north_am'])) ? strip_tags($new_instance['ccw_north_am']) : '0';;
    $instance['ccw_south_am'] = (!empty($new_instance['ccw_south_am'])) ? strip_tags($new_instance['ccw_south_am']) : '0';
    $instance['ccw_europe'] = (!empty($new_instance['ccw_europe'])) ? strip_tags($new_instance['ccw_europe']) : '0';
    $instance['ccw_africa'] = (!empty($new_instance['ccw_africa'])) ? strip_tags($new_instance['ccw_africa']) : '0';
    $instance['ccw_asia'] = (!empty($new_instance['ccw_asia'])) ? strip_tags($new_instance['ccw_asia']) : '0';
    $instance['ccw_oceania'] = (!empty($new_instance['ccw_oceania'])) ? strip_tags($new_instance['ccw_oceania']) : '0';

    return $instance;
  }
}
 
function country_counter_plugin() {
  register_widget('country_counter_widget');
}
 
// Initialize Plugin
add_action('widgets_init', 'country_counter_plugin');
 
?>