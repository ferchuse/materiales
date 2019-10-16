<?php
	include("../login/login_success.php");
	include("../funciones/generar_select.php");
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "reportes";
	
	$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	$fa_inicial = $dt_fecha_inicial->format("Y-m-d");
	$fa_final = $dt_fecha_final->format("Y-m-d");
	
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
    <title>Reportes</title>
		
		<?php include("../styles.php");?>
		
	</head>
  <body>
		<?php include("../menu.php");?>
		<div class="container-fluid">
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">Reporte de Movimientos</h3>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form id="form_reportes" class="form-inline">
						<div class="form-group mr-2">
							<label for="fecha_inicio">Desde:</label>
							<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo $fa_inicial;?>">
						</div>
						<div class="form-group mr-2">
							<label for="fecha_fin">Hasta:</label>
							<input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo $fa_final;?>">
						</div>
						<div class="form-group mr-2">
							<label for="id_departamentos">Categoria:</label>
							<?php echo generar_select($link, "departamentos", "id_departamentos", "nombre_departamentos", false, false, true)?>
						</div>
						<button type="submit" class="btn btn-success" id="btn_buscar">
							<i class="fa fa-search"></i> Buscar
						</button>
						
					</form>
				</div>
			</div>
			<hr>
			<div class="row text-center" id="contenedor_tabla">
				
			</div>
			
		</div >
		
		
		<?php  include('../scripts.php'); ?>
		<script >
			
			$(document).ready(function(){
				$('#form_reportes').submit(enviarFormulario);
				
			});
			
			
			function enviarFormulario(event){
				event.preventDefault();
				$('#contenedor_tabla').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
				var boton = $(this).find(':submit');
				var icono = boton.find('.fa');
				var formulario = $(this).serialize();
				$.ajax({
					url: 'tabla_movimientos.php',
					method: 'POST',
					dataType: 'HTML',
					data: formulario
					}).done(function(respuesta){
					$('#contenedor_tabla').html(respuesta);
				});
			}
			
		
	</script>
</body>
</html>