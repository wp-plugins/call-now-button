<?php
/*
Plugin Name: Call Now Button
Plugin URI: http://callnowbutton.com
Description: Mobile visitors will see a call now button at the bottom of your site
Version: 0.0.1
Author: Jerry G. Rietveld
Author URI: http://www.jgrietveld.com
License: GPL2
*/
?>
<?php
/*  Copyright 2012  Jerry G. Rietveld  (email : jerry@jgrietveld.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

add_action('admin_menu', 'register_cnb_page');
add_action('admin_init', 'cnb_options_init');

function register_cnb_page() {
	add_submenu_page('options-general.php', 'Call Now Button', 'Call Now Button', 'manage_options', 'call-now-button', 'call_now_settings_page');
}

function cnb_options_init() {
	register_setting('cnb_options','cnb');
}
function call_now_settings_page() { ?>
<div class="wrap">
<h2>Call Now Button</h2>
        <form method="post" action="options.php">
            <?php settings_fields('cnb_options'); ?>
            <?php $options = get_option('cnb'); ?>
            <table class="form-table">
                <tr valign="top"><th scope="row">Call Now Button enabled:</th>
                    <td><input name="cnb[active]" type="checkbox" value="1" <?php checked('1', $options['active']); ?> /></td>
                </tr>
                <tr valign="top"><th scope="row">Phone number:</th>
                    <td><input type="text" name="cnb[number]" value="<?php echo $options['number']; ?>" /></td>
                </tr>
            </table>
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php }
if(get_option('cnb') && !is_admin()) {
	$options = get_option('cnb');
	if(isset($options['active'])) $enabled = $options['active']; else $enabled = 0;
	if($enabled == '1') {
		// it's enables so put footer stuff here
		function cnb_head() {			
			echo "\n<!-- Call Now Button 0.0.1 by Jerry Rietveld (callnowbutton.com) -->\n<style>#callnowbutton {display:none;} @media screen and (max-width:650px){#callnowbutton {display:block; width:100px; height:80px; position:fixed; right:0; bottom:-20px; border-bottom-left-radius:40px; border-top-left-radius:40px; border-top:2px solid #0C0; background:url(" .plugins_url( 'callbutton01.png' , __FILE__ ). ") center 10px no-repeat #090; text-decoration:none; -webkit-box-shadow:0 0 5px #888; z-index:9999;}}</style>\n";
		}
		add_action('wp_head', 'cnb_head');
		
		function cnb_footer() {
			$alloptions = get_option('cnb');
			echo '<a href="tel:'.$alloptions['number'].'" id="callnowbutton">&nbsp;</a>';
		}
		add_action('wp_footer', 'cnb_footer');
	}
} ?>