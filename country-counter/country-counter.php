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
    
  // This function creates nice Facebook Page Like box in Header or Footer
  public function widget($args, $instance) {
    $ccw_title = apply_filters('ccw_title', $instance['ccw_title']);
    $ccw_world = apply_filters('ccw_world', $instance['ccw_world']);
    $ccw_north_am = apply_filters('ccw_north_am', $instance['ccw_north_am']);
    $crunchify_facebook_showface  = $instance['crunchify_facebook_showface'] ? 'true' : 'false';
    
    $ccw_body = $ccw_world;
    
    echo $before_widget;
    echo $before_title . '<h4 class="widget-title">' . $ccw_title . '</h4>' . $after_title;
    echo $ccw_body;
    echo $after_widget;
  }
  
  // Create Instance and Assign Values
  public function form($instance) {
    if (isset($instance['ccw_title'])) {
      $ccw_title = $instance['ccw_title'];
    }

    if (isset($instance['ccw_world'])) {
      $ccw_world = $instance['ccw_world'];
    } else {
      $ccw_world = '0';
    }
    
    if (isset($instance['ccw_north_am'])) {
      $ccw_north_am = $instance['ccw_north_am'];
    } else {
      $ccw_north_am = '0';
    }

    $instance['crunchify_facebook_showface'] = $instance['crunchify_facebook_showface'] ? 'true' : 'false';
    
?>
 
<!--  This is Crunchify Widget Form -->
<p>
  <label for="<?php echo $this->get_field_id('ccw_title'); ?>"> <?php _e('Title');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_title');?>" name="<?php echo $this->get_field_name('ccw_title');?>" type="text" value="<?php echo esc_attr($ccw_title);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_world'); ?>"> <?php _e('Total countries been to');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_world');?>" name="<?php echo $this->get_field_name('ccw_world');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_world);?>" />
 
  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_north_am'); ?>"> <?php _e('Countries been to in North America');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_north_am');?>" name="<?php echo $this->get_field_name('ccw_north_am');?>" type="number" min="0" max="20" value="<?php echo esc_attr($ccw_north_am);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_south_am'); ?>"> <?php _e('Countries been to in South America');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_south_am');?>" name="<?php echo $this->get_field_name('ccw_south_am');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_south_am);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_europe'); ?>"> <?php _e('Countries been to in Europe');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_europe');?>" name="<?php echo $this->get_field_name('ccw_europe');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_europe);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_africa'); ?>"> <?php _e('Countries been to in Africa');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_africa');?>" name="<?php echo $this->get_field_name('ccw_africa');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_africa);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_asia'); ?>"> <?php _e('Countries been to in Asia');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_asia');?>" name="<?php echo $this->get_field_name('ccw_asia');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_asia);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_oceania'); ?>"> <?php _e('Countries been to in Oceania');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_oceania');?>" name="<?php echo $this->get_field_name('ccw_oceania');?>" type="number" min="0" max="197" value="<?php echo esc_attr($ccw_oceania);?>" />

  <br /> <br />
	<label for="<?php echo $this->get_field_id('ccw_antarctica'); ?>"> <?php _e('Have you been to Antarctica');?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('ccw_antarctica');?>" name="<?php echo $this->get_field_name('ccw_antarctica');?>" type="number" min="0" max="1" value="<?php echo esc_attr($ccw_antarctica);?>" />
 
</p>
 
<?php
  }
    
  // Updating widget replacing old instances with new
  function update($new_instance, $old_instance) {
    $instance                           = array();
    $instance['ccw_title'] = (!empty($new_instance['ccw_title'])) ? strip_tags($new_instance['ccw_title']) : '';
    $instance['ccw_world'] = (!empty($new_instance['ccw_world'])) ? strip_tags($new_instance['ccw_world']) : '';
  
    $instance['ccw_north_am'] = (!empty($new_instance['ccw_north_am'])) ? strip_tags($new_instance['ccw_north_am']) : '';;
    $instance['crunchify_facebook_showface']  = $new_instance['crunchify_facebook_showface'];
    return $instance;
  }
}
 
function country_counter_plugin() {
  register_widget('country_counter_widget');
}
 
// Initialize Plugin
add_action('widgets_init', 'country_counter_plugin');
 
?>