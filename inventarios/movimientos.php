<?php
	include("../login/login_success.php");
	include("../funciones/generar_select.php");
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "reportes";
	
	$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	if(isset($_GET["fecha_inicial"])){
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
		
	}
	else{
		
		$fecha_inicial = $dt_fecha_inicial->format("Y-m-d");
		$fecha_final = $dt_fecha_final->format("Y-m-d");
		
	}
	
	
	
	if($_GET["tipo_movimiento"] == "ENTRADA"){
		
		$consulta = "SELECT
		id_entradas AS folio,
		fecha_entradas AS fecha_movimiento,
		referencia ,
		'entradas' as tabla ,
		'id_entradas' as id_campo 
		FROM
		entradas
		WHERE
		DATE(fecha_entradas) BETWEEN '$fecha_inicial'
		AND '$fecha_final'
		
		ORDER BY fecha_entradas DESC
		";
		
		
		$tabla = "entradas";
		$pk = "id_entradas";
		// $folio = "id_entradas";
		
	}
	else{
		
		$consulta = "SELECT
		id_salidas AS folio,
		fecha_salidas AS fecha_movimiento,
		referencia ,
		'salidas' as tabla ,
		'id_salidas' as id_campo 
		FROM
		salidas
		WHERE
		DATE(fecha_salidas) BETWEEN '$fecha_inicial'
		AND '$fecha_final'
		
		ORDER BY fecha_salidas DESC
		";
		
		
		$tabla = "salidas";
		$pk = "id_salidas";
	}
	
	
	$result = mysqli_query($link,$consulta) or die ("<pre>Error en $consulta". mysqli_error($link). "</pre>");
	
	while($fila = mysqli_fetch_assoc($result)){
		
		$movimientos[] = $fila;
		
	}
	
	$registros = count($movimientos);
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Movmientos</title>
		
		<?php include("../styles.php");?>
		
	</head>
	<body>
		<?php include("../menu.php");?>
		
		<pre hidden>
			<?php echo var_dump($movimientos)?>
		</pre>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">
						<?php echo $_GET["tipo_movimiento"]?>S
						
					</h3>
					<a href="nuevo_movimiento.php?tipo_movimiento=<?php echo $_GET["tipo_movimiento"]?>" class="btn btn-success" >
						<i class="fa fa-plus"></i> Nueva
					</a>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form id="form_reportes" class="form-inline">
						<input type="hidden" name="tipo_movimiento" value="<?php echo $_GET["tipo_movimiento"]?>">
						<div class="form-group mr-2">
							<label for="fecha_inicial">Desde:</label>
							<input type="date" name="fecha_inicial" id="fecha_inicial" class="form-control" value="<?php echo $fecha_inicial;?>">
						</div>
						<div class="form-group mr-2">
							<label for="fecha_final">Hasta:</label>
							<input type="date" name="fecha_final" id="fecha_final" class="form-control" value="<?php echo $fecha_final;?>">
						</div>
						<button  class="btn btn-primary" id="btn_buscar">
							<i class="fa fa-search"></i> Buscar
						</button>
						
					</form>
				</div>
			</div>
			<hr>
			
			<div class="col-10 mx-auto">
				<div class="card ">
					
					<div class="card-body" >
						<div class="table-responsive">
							
							<table class="table table-hover table-condensed table-bordered">
								<tr>
									<th class="text-center">Folio</th>                                                      
									<th class="text-center">Fecha</th>
									<th class="text-center">Referencia</th>
									<th class="text-center">Acciones</th>
								</tr>
								<?php 
									$total = 0;
									foreach($movimientos AS $i => $fila){
										
									?>
									<tr class="text-center">
										<td><?php echo $fila["folio"];?></td>
										<td><?php echo date("d/m/Y", strtotime($fila["fecha_movimiento"]));?></td>
										<td><?php echo $fila["referencia"];?></td>
										<td>
											<a href="imprimir_movimiento.php?id_movimiento=<?php echo $fila["folio"];?>&tipo_movimiento=<?php echo $_GET["tipo_movimiento"]?>" class="btn btn-sm btn-info btn_imprimir" target="_blank" 
											data-tabla="<?php echo $fila["tabla"]?>" 
											data-id_registro="<?php echo $fila["folio"]?>" 
											
											>
												<i class="fas fa-print" ></i> Reimprimir
											</a>
											
											
											<a href="nuevo_movimiento.php?tipo_movimiento=<?php echo $_GET["tipo_movimiento"]?>&tabla=<?php echo $tabla?>&folio=<?php echo $fila["folio"]?>" class="btn btn-sm btn-warning btn_editar" type="button" >
												<i class="fas fa-edit" ></i> Editar
											</a>
											
											<button class="btn btn-sm btn-danger btn_borrar" type="button" 
											data-id_registro="<?php echo $fila["folio"]?>"
											data-tabla="<?php echo $fila["tabla"]?>" 
											data-id_campo="<?php echo $fila["id_campo"]?>" 
											>
												<i class="fas fa-trash" ></i> Eliminar
											</button>
											
										</td>
										
									</tr>
									<?php
										
									}
									
								?>
								<tfoot class="bg-secondary text-white"> 
									<tr class="text-left">
										<td colspan="4"><b><?php echo $registros;?> Registro(s)</b></td>
										
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div >
		
		
		<?php  include('../scripts.php'); ?>
		<?php  include('modal_remision.php'); ?>
		<script src="movimientos.js"></script>
	</body>
</html>	