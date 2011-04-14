<?php
/*  Copyright 2011  Javier López Úbeda  (email : jlopez@s3server.net)

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

/*
Plugin Name: Flags 0.1.0
Description: Use this plugin to mark one post as important (other flags can be developed in the future)
Author: Javier López Úbeda
Version: 0.1.0
Author URI: http://www.s3server.net
*/

class Flags {
	
	var $meta_fields = array("important");
	
	function Flags() {
		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		
		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
	}
	
	function admin_init() {
		add_meta_box("flags", "Banderas", array(&$this, "flags_meta_box"), "post", "side", "high");
	}

	function flags_meta_box() {
		global $post;
		$custom = get_post_custom($post->ID);
		
		$important = $custom["important"][0];
		
		?>
		
		<div class="single-flag-box" style="border: 1px solid #aaa; padding: 5px;margin-bottom:5px;">
			<label for="importante" style="margin-right: 5px;">Importante</label>
			<input type="checkbox" name="important"<?php if (!empty($important)) {?> checked<?php } ?> />
		</div>
			
		<?php
	}
	
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)	{
		if ($post->post_type == "post") {
			foreach ($this->meta_fields as $key) {
				$value = @$_POST[$key];
				if (empty($value)) {
					delete_post_meta($post_id, $key);
					continue;
				}

				if (!is_array($value)) {
					if (!update_post_meta($post_id, $key, $value)) {
						add_post_meta($post_id, $key, $value);
					}
				} else {
					delete_post_meta($post_id, $key);
					
					foreach ($value as $entry)
						add_post_meta($post_id, $key, $entry);
				}
			}
		}
	}
}

// Initiate the plugin
add_action("init", "FlagsInit");
function FlagsInit() { global $flags; $flags = new Flags(); }

function is_post_important() {
	global $query;
	$cfk = get_post_custom_keys();
	foreach ($cfk as $key) {
		if (strtolower($key) == "important") return true;
	}
	return false;
}