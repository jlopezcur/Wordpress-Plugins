<?php
/*
Template Name: Calendario
*/
?>

<?php
global $wp_query;
$daySelected = $wp_query->query_vars['dia'];
$monthSelected = $wp_query->query_vars['mes'];
$yearSelected = $wp_query->query_vars['anio'];
?>

<?php get_header(); ?>
<div id="content" class="section" style="width: 970px;">
<?php arras_above_content() ?>

<script type='text/javascript'>
jQuery(document).ready(function() {
	jQuery('#calendar').fullCalendar({
		<?php if (isset($daySelected)) : ?> date: <?php echo $daySelected; ?>, <?php endif; ?>
		<?php if (isset($monthSelected)) : ?> month: <?php echo $monthSelected; ?>, <?php endif; ?>
		<?php if (isset($yearSelected)) : ?> year: <?php echo $yearSelected; ?>, <?php endif; ?>
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		timeFormat: 'H:mm{ - H:mm}',
		agenda: 'H:mm{ - H:mm}',
		axisFormat: 'H:mm{ - H:mm}',
		allDayText: 'Todo el día',
		titleFormat: {
			month: 'MMMM yyyy',                             // September 2009
    		week: "MMMM, d[ yyyy]{ '&#8212;'[ MMMM] d yyyy}", // Sep 7 - 13 2009
    		day: 'dddd, d MMMM yyyy'
		},
		firstHour: 10,
		editable: false,
		events: [<?php echo getAllEventsForCalendar(); ?>]
	});
	<?php if (isset($anioSelected)&&isset($diaSelected)&&isset($mesSelected)) : ?> jQuery('#calendar').fullCalendar('changeView', 'agendaDay'); <?php endif; ?>
});
</script>

<div class="single-post">
	<h1 class="entry-title">Calendario</h1>
	<div class="entry-content">
		<div id='calendar'></div>
	</div>
</div>
<?php arras_below_content() ?>
</div><!-- #content -->
</div>
<?php //get_sidebar(); ?>

<?php get_footer(); ?>