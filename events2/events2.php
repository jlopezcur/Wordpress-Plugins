<?php
/*
Plugin Name: Events2 0.1.0
Description: Plugin para Conservatorio de Almería
Author: Javier López Úbeda
Version: 0.1.0
Author URI: http://www.s3server.net
*/

define('EVENTS_PATH', '__FILE__');
define('EVENTS_URL', get_bloginfo('url').'/wp-content/plugins/events2');

include_once('utils.php');
include_once('functions.php');

class Events2 {
	var $meta_fields = array("date","time","allday","place","duration");
	
	function Events2() {
		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		
		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
	}
	
	function admin_init() {
		add_meta_box("events-meta", "Asignación", array(&$this, "events_meta_box"), "post", "normal", "high");
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker',  EVENTS_URL . '/js/ui.datepicker.min.js', array('jquery','jquery-ui-core') );
		wp_enqueue_script('jquery-ui-timepicker',  EVENTS_URL . '/js/ui.timepickr.min.js', array('jquery','jquery-ui-core') );
		wp_enqueue_style('jquery-ui', EVENTS_URL.'/css/ui/blitzer/jquery-ui-1.8.5.custom.css');
		wp_enqueue_style('jquery-ui-timepicker', EVENTS_URL.'/css/ui/ui.timepickr.css');
	}

	function events_meta_box() {
		global $post;
		$custom = get_post_custom($post->ID);
		
		echo '<div class="events-box">';

		for ($j=0;$j<count($custom["date"]);$j++) {
			
			$date = $custom["date"][$j];
			$time = $custom["time"][$j];
			$allday = $custom["allday"][$j];
			$place = $custom["place"][$j];
			$duration = $custom["duration"][$j];
		
			// Verify
			//echo'<input type="hidden" name="ch_link_url_noncename" id="ch_link_url_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			
			// Fields for data entry
			?>
			
			<div class="single-event-box" style="border: 1px solid #aaa; padding: 5px;margin-bottom:5px;">
				<table width="100%">
					<tr>
						<td>
							<label style="margin-right: 5px;">Cuando:</label>
							<input type="text" name="date[]" class="event-date" value="<?php echo $date; ?>" size="11" />
							<input type="text" name="time[]" class="event-time" value="<?php echo $time; ?>" size="5"<?php if ($allday) : ?> disabled="true"<?php endif; ?> />
							Todo el día <input type="checkbox" name="allday[]" class="event-allday" value="true"<?php if ($allday) : ?> checked="checked"<?php endif; ?> />
						</td>
						<td>
							<label style="margin-right: 5px;">Duración (Apróx.)[mín]:</label>
							<input type="text" name="duration[]" value="<?php echo $duration; ?>" size="5" />			
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label style="margin-right: 5px;">Donde:</label>
							<input type="text" name="place[]" value="<?php echo $place; ?>" size="100%" />
						</td>
						<td style="text-align: right;">
							<a href="#" class="button removeEventBox">Eliminar</a>
						</td>
					</tr>
				</table>
			</div>
			
		<?php } ?>
		
		</div>
		<script type="text/javascript">
			function addMechanism() {
				jQuery(".event-date").datepicker({
					dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
					dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
					dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
					monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
					monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
					firstDay: 1,
					nextText: 'Siguiente',
					prevText: 'Anterior'
				});
				
				jQuery(".event-time").timepickr({
					dropslide: {'trigger': 'click'}
				});
			}
			function addEventBox() {
				jQuery(".events-box").append(
					'<div class="single-event-box" style="border: 1px solid #aaa; padding: 5px;margin-bottom:5px;">' +
						'<table width="100%">'+
							'<tr>'+
								'<td>'+
									'<label style="margin-right: 5px;">Cuando:</label>' +
									'<input type="text" name="date[]" class="event-date" value="" size="11" />'+
									'<input type="text" name="time[]" class="event-time" value="" size="5" />'+
									'Todo el día <input type="checkbox" name="allday[]" class="event-allday" value="true" />'+
								'</td>'+
								'<td>'+
									'<label style="margin-right: 5px;">Duración (Apróx.)[mín]:</label>' +
									'<input type="text" name="duration[]" value="" size="5" />' +
								'</td>'+
								'<td>'+
								'</td>'+
							'</tr>'+
							'<tr>'+
								'<td colspan="2">'+
									'<label style="margin-right: 5px;">Donde:</label>' +
									'<input type="text" name="place[]" value="" size="100%" />' +
								'</td>'+
								'<td style="text-align: right;">'+
									'<a href="#" class="button removeEventBox">Eliminar</a>' +
								'</td>'+
							'</tr>'+
						'</table>'+
					'</div>'
				);
				
				addMechanism();
				
				jQuery(".removeEventBox").click(function () {
					jQuery(this).parent().parent().parent().parent().parent().remove();
				});
			}
			addMechanism();
		</script>
		<div style="margin-top:10px;text-align:right;">
			<a href="javascript:addEventBox();" class="button">Añadir asignación</a>
		</div>
		
		<?php
	}
	
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)	{
		//print_r($post_id);
		//print_r($post);
		if ($post->post_type == "post") {
			// Loop through the POST data
			foreach ($this->meta_fields as $key) {
				$value = @$_POST[$key];
				//echo $key." = ".$value.";";
				if (empty($value)) {
					delete_post_meta($post_id, $key);
					continue;
				}

				// If value is a string it should be unique
				if (!is_array($value)) {
					// Update meta
					if (!update_post_meta($post_id, $key, $value)) {
						// Or add the meta data
						add_post_meta($post_id, $key, $value);
					}
				} else {
					// If passed along is an array, we should remove all previous data
					delete_post_meta($post_id, $key);
					
					// Loop through the array adding new values to the post meta as different entries with the same name
					foreach ($value as $entry)
						add_post_meta($post_id, $key, $entry);
				}
			}
		}
	}
}

// Initiate the plugin
add_action("init", "Events2Init");
function Events2Init() { global $events2; $events2 = new Events2(); }

?>