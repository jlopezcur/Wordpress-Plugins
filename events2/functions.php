<?php
function getEventsDate() { global $post; return get_post_meta(get_the_ID(), 'date', false); }
function getEventsTime() { global $post; return get_post_meta(get_the_ID(), 'time', false); }
function getEventsAllDay() { global $post; return get_post_meta(get_the_ID(), 'allday', false); }
function getEventsPlace() { global $post; return get_post_meta(get_the_ID(), 'place', false); }
function getEventsDuration() { global $post; return get_post_meta(get_the_ID(), 'duration', false); }

/*
 * Pregunta dentro del Loop si el Post tiene eventos
 */
function hasEvent() {
	global $post;
	if (count(getEventsDate())>0) return true;
	return false;
}

/*
 * Obtiene los días de eventos para el mini-calendario
 */
function getEventDays() {
	$out = "";
	
	$query = new WP_Query();
	$query->query(array('post_type'=>'post'));
	
	while ($query->have_posts()) : $query->the_post();
		$dates = getEventsDate();
		
		for ($i=0;$i<count($dates);$i++) {
			$date = strtotime($dates[$i]);
			
			$year = date('Y', $date);
			$month = date('n', $date);
			$day = date('j', $date);
			
			$out .= "[$month, $day, $year, 'event', '".get_the_title()."'],";		
		}
	endwhile;
	if ($out != "") $out = substr($out, 0, strlen($out)-1);
	return $out;
}

/*
 * Obtiene los días de eventos para Fullcalendar
 */
function getEventFullcalendar() {
	global $query;
	$out = "";
	
	$query = new WP_Query();
	$query->query(array('post_type'=>'post'));
	
	while ($query->have_posts()) : $query->the_post();
		$dates = getEventsDate();
		$times = getEventsTime();
		$alldays = getEventsAllDay();
		
		for ($i=0;$i<count($dates);$i++) {
			$date = strtotime($dates[$i]);
			
			$year = date('Y', $date);
			$month = date('n', $date)-1;
			$day = date('j', $date);
			
			$date_chain = $year.", ".$month.", ".$day;
			
			if ($times[$i]) {
				$hour = substr($times[$i], 0, 2);
				$minutes = substr($times[$i], 3, 2);
				$date_chain .= ", ".$hour.", ".$minutes;
			} else {
				$date_chain .= ", 0, 0";
			}
			
			$allday = "false";
			if ($alldays[$i]) $allday = "true";
			
			$out .= "{".
				"title: '".get_the_title()."', ".
				"start: new Date(".$date_chain."), ".
				"allDay: ".$allday.", ".
				"url: '".get_permalink()."'".
			"}, ";		
		}
	endwhile;
	
	if ($out != "") $out = substr($out, 0, strlen($out)-1);
	return $out;
}

/*
 * Obtiene un listado de los eventos de para páginas de listados de Posts
 */
function getEventListSheet() {
	$dates = getEventsDate();
	$times = getEventsTime();
	$alldays = getEventsAllDay();
	$places = getEventsPlace();
	$durations = getEventsDuration();
	
	$out = "";
	for ($i=0;$i<count($dates);$i++) {
		$same_next = false;
		$out .= "<b>Cuando:</b> ".dateToString($dates[$i]);
		
		if (!$alldays[$i] && !empty($times)) {
			$same_times = $times[$i];
			for ($j=$i+1;$j<count($dates);$j++) {
				if ($dates[$j] && $dates[$i]==$dates[$j] && $places[$i] && $places[$j] && $places[$i]==$places[$j]) {
					$same_times .= ", ".$times[$j];
					$same_next = true;
				}	
			}
		}
		
		if ($same_next)
			$out .= " | ".$same_times;
		else
			if ($same_times) $out .= " | ".$times[$i];
		
		$out .= "<br />";
		if ($places[$i]) $out .= "<b>Lugar:</b> ".$places[$i]."<br />";
		if (!$alldays[$i] && $durations[$i]) $out .= "<b>Duración:</b> ".minutesToString($durations[$i])."<br />";
		
		if ($same_next) $i=$j;
	}
	return $out;
}
?>