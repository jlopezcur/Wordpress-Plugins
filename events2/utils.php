<?php
class EventDate {
	var $date;
	function EventDate($date) {	$this->date = strtotime($date); }
	function getDay() {	return date('j', $this->date);	}
	function getMonth() { return date('n', $this->date); }
	function getMonthName() {
		switch($this->getMonth()) {
			case 1: return "Enero"; break;
			case 2: return "Febrero"; break;
			case 3: return "Marzo"; break;
			case 4: return "Abril"; break;
			case 5: return "Mayo"; break;
			case 6: return "Junio"; break;
			case 7: return "Julio"; break;
			case 8: return "Agosto"; break;
			case 9: return "Septiembre"; break;
			case 10: return "Octubre"; break;
			case 11: return "Noviembre"; break;
			case 12: return "Diciembre"; break;
		}
		return "";
	}
	function getYear() { return date('Y', $this->date); }
}
class EventTime {
	var $time;
	function EventTime($time) {	$this->time = $time; }
	function getHours() { $parts = explode(':', $this->time); return $parts[0]; }
	function getMinutes() { $parts = explode(':', $this->time); return $parts[1]; }
}

function getAllEventsForCalendar() {
	$out = "";
	$query = new WP_Query('post_type=event');
	/*while ($query->have_posts()) {
		$query->the_post(); 
		for ($i=1;$i<=getGroupDuplicates('date');$i++) {
			$d = new EventDate((get_post_meta(get_the_ID(), 'date', false))[$i]);
			$t = new EventTime((get_post_meta(get_the_ID(), 'time', false))[$i]);
			$title = get_the_title();
			$url = get_permalink();
			$out .= "{ title: $title, start: new Date($d->getYear(), $d->getMonth(), $d->getDay(), $t->getHours(), $t->getMinutes()), allDay: false, url: $url },";  
		}
	}*/
	return $out;
}

function minutesToString($minutes) {
	$out = "";
	$hours = floor($minutes / 60);
	if ($hours > 0) $out .= $hours."h. ";
	$minutes = fmod($minutes, 60);
	if ($minutes > 0) $out .= $minutes."'";
	return $out;
}

function dateToString($date) {
	$d = new EventDate($date);
	return $d->getDay()." de ".$d->getMonthName()." de ".$d->getYear();
}
?>