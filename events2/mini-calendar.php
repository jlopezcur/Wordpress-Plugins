</div><!-- #container -->
<?php include_once(TEMPLATEPATH . "/libs/actuaciones.php"); ?>
<?php wp_reset_query() ?>
<div id="primary" class="aside main-aside sidebar">
<?php arras_above_sidebar() ?>  
	<ul class="xoxo">
		
		<?php if (is_home()) : ?>
		<li class="widgetcontainer clearfix">
			<h5 class="widgettitle" style="text-align:center;background-image:none;background-color:#CE0909;color:#FFF;font-size:16px;font-weight:bold;">
				ABIERTO PLAZO DE INSCRIPCI&Oacute;N
			</h5>
			<div class="widgetcontent">
			<div class="textwidget">
				<div style="text-align:center;margin-bottom:20px;">
					La Escuela de Teatro Liberarte ha abierto el plazo de matriculaci&oacute;n para el curso 2010-11 de <br />
					TEATRO PARA NI&Ntilde;OS<br />
					INICIACI&Oacute;N AL TEATRO PARA ADULTOS<br />
					ESCUELA DE CINE<br />
					puedes ver los cursos en la secci&oacute;n de <a href="http://www.teatroliberarte.com/escuela/">Escuela</a><br />
					y los monogr&aacute;ficos actuales en la secci&oacute;n de <a href="http://www.teatroliberarte.com/secciones/monograficos/">Monogr&aacute;ficos</a> (dentro de <a href="http://www.teatroliberarte.com/escuela/">Escuela</a>)
				</div>
			</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php if (!is_single()) : ?>
        <li class="widgetcontainer clearfix">
			
        	<div id="mini-calendar"></div>
            <script type="text/javascript">
			jQuery(document).ready(function() {
				var options = {
					dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
					dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
					dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
					monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
					monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
					firstDay: 1,
					nextText: 'Siguiente',
					prevText: 'Anterior',
					beforeShowDay: setScheduledDays,
					//onChangeMonthYear: setToolTip,
					onSelect: function(dateText, inst) {
						var dateSelected = new Date(dateText);
						window.location = "<?php bloginfo('url'); ?>/calendario/"+dateSelected.getDate()+
							"/"+dateSelected.getMonth()+
							"/"+dateSelected.getFullYear();
					}
				};
				
				jQuery('#mini-calendar').datepicker(options);
				
				/*jQuery("#tooltip-test a").tooltip({ 
				    track: true,
				    delay: 0,
				    showURL: false, 
				    showBody: " - ", 
				    fade: 250
				});*/
			});
			
			/*function setToolTip(year, month, inst) {
				//alert("Joe");
				jQuery(".ui-datepicker .event").tooltip({ 
				    track: true, 
				    delay: 0, 
				    showURL: false,
				    fade: 250
				});
			}*/
			
			var scheduledDays = [<?php
$query = new WP_Query('cat=3');
$out = "";
while ($query->have_posts()) {
	$query->the_post();
	
	$today = time(); 
	for ($i=1;$i<=getGroupDuplicates('fecha');$i++) {
		$fecha_inicio = strtotime(get('fecha', $i, 1, false));
		$anio = date('Y', $fecha_inicio);
		$mes = date('n', $fecha_inicio);
		$dia = date('j', $fecha_inicio);
		if (get('hora', $i, 1, false)) {
			$hora = get('hora', $i, 1, false);
		} else {
			$hora = 0;
		}
		if (get('minuto', $i, 1, false)) {
			$minuto = get('minuto', $i, 1, false);
		} else {
			$minuto = 0;
		}
		
		$out .= "[$mes, $dia, $anio, 'event', '".get_the_title()."'],";		
	}
}
if ($out != "") $out = substr($out, 0, strlen($out)-1);
echo $out;
?>];
			var holidayDays = [];
			
			function setScheduledDays(date) {
				var isScheduled = false;
				var isHoliday = false;
				var scheduleStatus = "";
				var scheduleToolTip = "";
				
				// Check for scheduled day
				for (i = 0; i < scheduledDays.length; i++) {
					if (date.getMonth() == scheduledDays[i][0] - 1 &&
						date.getDate() == scheduledDays[i][1] &&
						date.getFullYear() == scheduledDays[i][2]) {

						isScheduled = true;
						scheduleStatus = scheduledDays[i][3];
						scheduleToolTip += scheduledDays[i][4]+"<br />";
					}
				}
				
				// Check for holidays
				if (holidayDays != null) {
					for (i = 0; i < holidayDays.length; i++) {
						if (date.getMonth() == holidayDays[i][0] - 1 &&
							date.getDate() == holidayDays[i][1] &&
							date.getFullYear() == holidayDays[i][2]) {
							
							isHoliday = true;
						}
					}
				}   
				
				if (isHoliday)
					return [false, 'holiday'];
				else if (isScheduled) {
					//return [true, scheduleStatus, scheduleToolTip];
					return [true, scheduleStatus];
				 } else
					return [false, 'nothing'];
			}  
			</script>
            <div style="text-align:center" id="tooltip-test">
            	<a href="<?php bloginfo('url'); ?>/calendario/">VER CALENDARIO COMPLETO</a>
            </div>
			
		</li>
		
		<li style="height:10px;"></li>
		<?php endif; ?>
        
        <?php /* ****************************************************************************** */ ?>
		<?php /*                                Equipo                                          */ ?>
		<?php /* ****************************************************************************** */ ?>
        
        <?php if (is_page('Equipo')) : ?>
		<li class="widgetcontainer clearfix">
            <h5 class="widgettitle">Equipo</h5>
            <div class="widgetcontent">
                <p>
                    <b>YOLANDA LOPEZ GARCIA</b><br />
                    Direccion Ejecutiva, Direcci&oacute;n Art&iacute;stica-Creativa, Direcci&oacute;n de Grupo, Profesora Teatro Adultos<br />
                    <a href="mailto:info@teatroliberarte.com">info@teatroliberarte.com</a>
                </p>
                
                <p>
                    <b>SUSANA HIDALGO</b><br />
                    Direccion Escuela, Psicologa y Pedagoga,  Profesora de Teatro Infantil, Iniciaci&oacute;n Teatro, Teatro Adultos<br />
                    <a href="mailto:escuela@teatroliberarte.com">escuela@teatroliberarte.com</a>
                </p>
                
                <p>
                    <b>MARTA NARVAEZ</b><br />
                    Direccion Prensa y Comunicaci&oacute;n.<br />
                    <a href="mailto:prensa@teatroliberarte.com">prensa@teatroliberarte.com</a>
                </p>
                
                <p>
                    <b>ALFONSO DIAZ</b><br />
                    Direcci&oacute;n Creativo Audiovisual, Director Largometrajes y Cortometrista. Montador audivisual y t&eacute;cnico.<br />
                    <a href="mailto:alfonsodiaz@teatroliberarte.com">alfonsodiaz@teatroliberarte.com</a><br />
                    <a href="http://alfonsodiaz.es/neweb/?page_id=2" target="_blank">http://alfonsodiaz.es/neweb/?page_id=2</a>
                </p>
                
                <p>
                    <b>ELENA DIAZ NOVILLO</b><br />
                    Responsable Departamento  Grafico, fotografa, dise&ntilde;o creativo<br />
                    <a href="http://www.flickr.com/photos/lna_8" target="_blank">http://www.flickr.com/photos/lna_8</a><br />
                    <a href="http://elena.nuzart.com" target="_blank">http://elena.nuzart.com</a>
                </p>
                
                <p>
                    <b>REBECA CABEZON</b><br />
                    Profesora de danza oriental, pilates, pre -danza Infantil
                </p>
                
                <p>
                    <b>YUDESKIA LLANES AJETE</b><br />
                    Profesora de Ritmos Latinos, Salsa Casino, Salsa Cubana, Folklorica, Ritmos Latinos, Infantil
                </p>
                
                <p>
                    <b>WILMA</b><br />
                    Equipo de trabajo
                </p>
                
                <p>
                	<b>JAVIER LÓPEZ ÚBEDA</b><br />
                	Mantenimiento web<br />
                	<a href="mailto:jlopez@s3server.net">jlopez@s3server.net</a><br />
                	<a href="http://www.s3server.net" target="_blank">http://www.s3server.net</a>
                </p>
				
            </div>
        </li>
		<?php endif; ?>

		
		<?php /* ****************************************************************************** */ ?>
		<?php /*                                Programaci�n                                    */ ?>
		<?php /* ****************************************************************************** */ ?>
		
		<?php /* Cartel */ ?>
		<?php if (is_single() && get('cartel')) : ?>
		<li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Cartel</h5>
			<div class="widgetcontent">
			<div class="textwidget" style="text-align:center;">
				<a href="<?=get('cartel')?>"><img src="<?=pt();?>?src=<?=get('cartel')?>&w=280&h=200" /></a>
			</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php /* Ficha t�cnica-art�stica */ ?>
		<?php if (is_single() && get('sheet')) : ?>
		<li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Ficha T&eacute;cnica-Art&iacute;stica</h5>
			<div class="widgetcontent">
			<div class="textwidget">
				<?=get('sheet')?>
			</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php /* Sesiones */ ?>
		<?php if (is_single() && get('fecha', 1, 1, true)) : ?>
		<li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Sesiones</h5>
			<div class="widgetcontent">
			<div class="textwidget">
                <?php showSesiones(); ?>
			</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php /* ****************************************************************************** */ ?>
		<?php /*                                 General                                        */ ?>
		<?php /* ****************************************************************************** */ ?>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Reserva y venta de entradas</h5>
			<div class="widgetcontent">
			<div class="textwidget">
                <b>En el tlf. 91-7330029 / 687938505 o en</b>
				<table style="border: 0px;">
                	<tr>
                    	<td style="text-align:center;background: none; border: none;">
                        	<a href="http://www.entradas.com/asterix/eventosRecinto.do?idRecinto=10151&entidad=1" target="_blank" style="text-decoration:none;">
                            	<img src="<?php bloginfo('template_url') ?>/images/entradas.png" />entradas.com
							</a>
						</td>
                        <td style="text-align:center;background: none; border: none;">
                        	<a href="http://www.atrapalo.com/entradas/liberarte_l34/" target="_blank" style="text-decoration:none;">
                            	<img src="<?php bloginfo('template_url') ?>/images/atrapalo.png" />atrapalo.com
							</a>
						</td>
					</tr>
				</table>
                <p>(*) Se abre la taquilla una hora antes de la funci&oacute;n.</p>
			</div>
			</div>
		</li>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">&iquest;donde estamos?</h5>
			<div class="widgetcontent">
			<div class="textwidget">
                <iframe width="278" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=teatro+liberarte&amp;sll=40.396764,-3.713379&amp;sspn=11.941891,28.54248&amp;ie=UTF8&amp;hq=teatro+liberarte&amp;hnear=&amp;ll=40.467584,-3.701706&amp;spn=0.078357,0.0951&amp;z=12&amp;output=embed"></iframe><br />
                <small><a href="http://maps.google.es/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=teatro+liberarte&amp;sll=40.396764,-3.713379&amp;sspn=11.941891,28.54248&amp;ie=UTF8&amp;hq=teatro+liberarte&amp;hnear=&amp;ll=40.467584,-3.701706&amp;spn=0.078357,0.0951&amp;z=12" style="color:#0000FF;text-align:left">Ver mapa m&aacute;s grande</a></small><br/>
				<div align="right"><a href="http://www.teatroliberarte.com/contacto">+ info</a></div>
			</div>
			</div>
		</li>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Socios</h5>
			<div class="widgetcontent">
			<div class="textwidget">
                <img src="<?php bloginfo('template_url') ?>/images/carnet.jpg" />
				Hazte el carnet de socio y aprov&eacute;chate de descuentos y muchas otras ventajas
			</div>
			</div>
		</li>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Cumplea&ntilde;os teatrales</h5>
			<div class="widgetcontent">
			<div class="textwidget">
                <a href="http://www.teatroliberarte.com/cumpleanos-teatrales/"><img src="<?php bloginfo('template_url') ?>/images/cumple.jpg" /></a>
				Celebra con nosotros tu cumplea&ntilde;os
			</div>
			</div>
		</li>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Trabaja con nosotros</h5>
			<div class="widgetcontent">
			<div class="textwidget">
            	Estamos buscando espect&aacute;culos de peque&ntilde;o y mediano formato. <a href="http://www.teatroliberarte.com/trabaja-con-nosotros/">m&aacute;s informaci&oacute;n</a>
			</div>
			</div>
		</li>
        
        <li class="widgetcontainer clearfix">
			<h5 class="widgettitle">Horario de Oficina</h5>
			<div class="widgetcontent">
			<div class="textwidget">
				<p>
                	(Lunes cerrado) Martes a Viernes:<br />
					de 11.00h a 14.00h y de 16.30h a 19.30h
                </p>
			</div>
			</div>
		</li>

	</ul>		

</div><!-- #primary -->

<div id="secondary" class="aside main-aside sidebar">

    <ul class="xoxo">

        <!-- Widgetized sidebar, if you have the plugin installed.  -->

        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary Sidebar #1') ) : ?>              

        <?php endif; ?>

		

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary Sidebar #2') ) : ?>

		<?php endif; ?>

    </ul>

	<?php arras_below_sidebar() ?>  

</div><!-- #secondary -->

