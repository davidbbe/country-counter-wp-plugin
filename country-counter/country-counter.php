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
      'classname' => 'ccw-widget', 'description' => __('Display the percentage and graph of countries been to.', 'country_counter_plugin_domain')
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
  
    $ccw_world_group = '
      <div class="ccw-container">
        <div class="charts-container">
          <p class="ccw-intro"><span id="ccw-intro-num"></span> Countries Visited</p>
          <div class="pie-wrapper">
            <span class="ccw-label"><span id="ccw-num-percent"></span><span class="ccw-smaller">%</span></span>
            <div id="ccw-pie" class="ccw-pie">
              <div id="ccw-left-side" class="ccw-left-side ccw-half-circle"></div>
              <div class="ccw-right-side ccw-half-circle"></div>
            </div>
            <div class="ccw-shadow"></div>
          </div>
        </div>

        <ul class="ccw-bar-graph">
          <li id="ccw-na" class="ccw-na"></li>
          <li id="ccw-sa" class="ccw-sa"></li>
          <li id="ccw-eu" class="ccw-eu"></li>
          <li id="ccw-af" class="ccw-af"></li>
          <li id="ccw-as" class="ccw-as"></li>
          <li id="ccw-oc" class="ccw-oc"></li>
        </ul>

      </div>
      
      <style>
      /* bar graph */
      .ccw-bar-graph {
        list-style: none;
        padding-top: 20px;
        width:560px;
      }
      
      .ccw-bar-graph li {
        height: 35px;
        width: 50%;
        color: white;
        text-align: left;
        font-style: italic;
        font-weight:bolder;
        font-size: 14px;
        line-height: 35px;
        padding: 0;
        margin-bottom: 5px;
      }
      
      .ccw-bar-graph li span {
        position: absolute;
        color: #7f8c8d;
        padding: 0px 20px;
      }
      .ccw-bar-graph .ccw-na {
        background: rgba(85, 239, 196,.4);
      }
      .ccw-bar-graph .ccw-sa {
        background: rgba(116, 185, 255,.4);
      }
      .ccw-bar-graph .ccw-eu {
        background: rgba(162, 155, 254,.4);
      }
      .ccw-bar-graph .ccw-af {
        background: rgba(253, 203, 110,.4);
      }
      .ccw-bar-graph .ccw-as {
        background: rgba(255, 118, 117,.4);
      }
      .ccw-bar-graph .ccw-oc {
        background: rgba(178, 190, 195,.4);
      }
      
      
      .ccw-container *,
      .ccw-container *:before,
      .ccw-container *:after {
        box-sizing: border-box;
      }
      .ccw-widget {
      
      }
      .ccw-container {
        color: #444;
        font-family: "Lato", Tahoma, Geneva, sans-serif;
        font-size: 16px;
        padding: 10px;
      }
      .ccw-container .charts-container {
        font-size: 160px;
      }
      .ccw-intro {
        font-size: 18px;
        margin-bottom: 15px;
        text-align: center;
        color: #7f8c8d;
        font-weight: 600;
      }
      .ccw-container .charts-container:after {
        clear: both;
        content: "";
        display: table;
      }
      .ccw-container .pie-wrapper {
        height: 1em;
        width: 1em;
        margin-left: auto;
        margin-right: auto;
        position: relative;
      }
      .ccw-container .ccw-pie {
        height: 100%;
        width: 100%;
        clip: rect(0, 1em, 1em, 0.5em);
        left: 0;
        position: absolute;
        top: 0;
      }
      .ccw-container .ccw-pie .ccw-half-circle {
        height: 100%;
        width: 100%;
        border: 0.1em solid #3498db;
        border-color: #1abc9c;
        border-radius: 50%;
        clip: rect(0, 0.5em, 1em, 0);
        left: 0;
        position: absolute;
        top: 0;
      }
      .ccw-container .ccw-label {
        background: none;
        border-radius: 50%;
        bottom: 0.4em;
        color: #7f8c8d;
        cursor: default;
        display: block;
        font-size: 0.25em;
        left: 0.4em;
        line-height: 2.6em;
        position: absolute;
        right: 0.4em;
        text-align: center;
        top: 0.4em;
      }
      .ccw-container .ccw-label .ccw-smaller {
        color: #bdc3c7;
        font-size: .45em;
        padding-bottom: 20px;
        vertical-align: super;
      }
      .ccw-container .ccw-shadow {
        height: 100%;
        width: 100%;
        border: 0.1em solid #bdc3c7;
        border-radius: 50%;
      }
      .pie-wrapper .ccw-pie .ccw-right-side {
        display: none;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
      }
      /* toggle class .ccw-above-180 if above 180 */
      .pie-wrapper .ccw-above-180 {
        clip: rect(auto, auto, auto, auto);
      }
      /* This needs to stay at 180 */
      .pie-wrapper .ccw-pie.ccw-above-180 .ccw-right-side {
        display: block;
      }
      </style>
      
      <script>
        var ccwTotal = ' . $ccw_world . ';
        
        if(ccwTotal) {
    
          document.getElementById("ccw-intro-num").innerHTML = (ccwTotal).toString();
          var ccwPercent100 = ccwTotal/194;
          var ccwPercent100 =  Math.round(ccwPercent100 * 100) / 100;
          document.getElementById("ccw-num-percent").innerHTML = (ccwPercent100 * 100).toString();
          var ccwPercent360 = 360 * ccwPercent100;
          var ccwPercent360 = Math.round(ccwPercent360);
          var ccwPercent360 = ccwPercent360.toString();
          var ccwOver180Left = document.getElementById("ccw-left-side");
          ccwOver180Left.setAttribute("style", "-webkit-transform: rotate(" + ccwPercent360 + "deg);transform: rotate(" + ccwPercent360 + "deg);");
          if(ccwPercent360 > 180) {
            var ccwOver180Pie = document.getElementById("ccw-pie");
            ccwOver180Pie.classList.add("ccw-above-180");
          }
        }
      
        if(ccwTotal) {
          var ccwNa = 21;
          var ccwNaEl = document.getElementById("ccw-na");
          ccwNaEl.innerHTML = "<span>North America " + ccwNa.toString() + "/23</span>";
          ccwNa = Math.round((ccwNa/23) * 100);
          ccwNaEl.setAttribute("style", "width:" + ccwNa + "%;");
          console.log(ccwNa);
      
          var ccwSa = 2;
          var ccwSaEl = document.getElementById("ccw-sa");
          ccwSaEl.innerHTML = "<span>South America " + ccwSa.toString() + "/12</span>";
          ccwSa = Math.round((ccwSa/12) * 100);
          ccwSaEl.setAttribute("style", "width:" + ccwSa + "%;");
          console.log(ccwSa);
      
          var ccwEu = 22;
          var ccwEuEl = document.getElementById("ccw-eu");
          ccwEuEl.innerHTML = "<span>Europe " + ccwEu.toString() + "/47</span>";
          ccwEu = Math.round((ccwEu/47) * 100);
          ccwEuEl.setAttribute("style", "width:" + ccwEu + "%;");
          console.log(ccwEu);
      
          var ccwAf = 1;
          var ccwAfEl = document.getElementById("ccw-af");
          ccwAfEl.innerHTML = "<span>Africa " + ccwAf.toString() + "/54</span>";
          ccwAf = Math.round((ccwAf/54) * 100);
          ccwAfEl.setAttribute("style", "width:" + ccwAf + "%;");
          console.log(ccwAf);
      
          var ccwAs = 11;
          var ccwAsEl = document.getElementById("ccw-as");
          ccwAsEl.innerHTML = "<span>Asia " + ccwAs.toString() + "/44</span>";
          ccwAs = Math.round((ccwAs/44) * 100);
          ccwAsEl.setAttribute("style", "width:" + ccwAs + "%;");
          console.log(ccwAs);
      
          var ccwOc = 5;
          var ccwOcEl = document.getElementById("ccw-oc");
          ccwOcEl.innerHTML = "<span>Oceania " + ccwOc.toString() + "/14</span>";
          ccwOc = Math.round((ccwOc/14) * 100);
          ccwOcEl.setAttribute("style", "width:" + ccwOc + "%;");
          console.log(ccwOc);
        }
      </script>
    ';
    $ccw_continents_group = 'blah';
    
    echo $before_widget;
    echo $before_title . '<h4 class="widget-title">' . $ccw_title . '</h4>' . $after_title;
    echo ($instance['ccw_show_world_group'] ? $ccw_world_group : '');
    echo ($instance['ccw_show_continents_group'] ? $ccw_continents_group : '');
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

    $instance['ccw_show_world_group'] = $instance['ccw_show_world_group'] ? 'true' : 'false';
    $instance['ccw_show_continents_group'] = $instance['ccw_show_continents_group'] ? 'true' : 'false';
?>
 
<!--  This is the widget form -->
<div class="">
  <style>.widgets-holder-wrap .widget-inside{padding:7px;}</style>

  <div style="padding:7px;background-color:rgba(85, 239, 196,.2);">
    <label for="<?php echo $this->get_field_id('ccw_title'); ?>"> <?php _e('Title');?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('ccw_title');?>" name="<?php echo $this->get_field_name('ccw_title');?>" type="text" value="<?php echo esc_attr($ccw_title);?>" />
    <br />
  </div>

  <br />

  <div style="padding:7px;background-color:rgba(129, 236, 236,.2);">
    <label for="<?php echo $this->get_field_id('ccw_show_world_group');?>"><?php _e('Show total countries been percent?'); ?></label>
    <input class="checkbox" type="checkbox" <?php checked($instance['ccw_show_world_group'], 'true'); ?> id="<?php echo $this->get_field_id('ccw_show_world_group'); ?>" name="<?php echo $this->get_field_name('ccw_show_world_group'); ?>" />

    <br /> <br />

    <label for="<?php echo $this->get_field_id('ccw_world'); ?>"> <?php _e('Total countries been to (194 possible)');?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('ccw_world');?>" name="<?php echo $this->get_field_name('ccw_world');?>" type="number" min="0" max="194" value="<?php echo esc_attr($ccw_world);?>" />
    <br />
  </div>

  <br />

  <div style="padding:7px;background-color:rgba(116, 185, 255,.2);">
    <label for="<?php echo $this->get_field_id('ccw_show_continents_group');?>"><?php _e('Show countries been percent by continent?'); ?></label>
    <input class="checkbox" type="checkbox" <?php checked($instance['ccw_show_continents_group'], 'true'); ?> id="<?php echo $this->get_field_id('ccw_show_continents_group'); ?>" name="<?php echo $this->get_field_name('ccw_show_continents_group'); ?>" />

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
  </div>
  <br />
</div>
 
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
    $instance['ccw_show_world_group']  = $new_instance['ccw_show_world_group'];
    $instance['ccw_show_continents_group']  = $new_instance['ccw_show_continents_group'];
    return $instance;
  }
}
 
function country_counter_plugin() {
  register_widget('country_counter_widget');
}
 
// Initialize Plugin
add_action('widgets_init', 'country_counter_plugin');
 
?>