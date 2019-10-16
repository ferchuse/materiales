<?php
	include("../login/login_success.php");
	include("../funciones/generar_select.php");
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "reportes";
	
	$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	$fecha_inicial = $dt_fecha_inicial->format("Y-m-d");
	$fecha_final = $dt_fecha_final->format("Y-m-d");
	
	
	
	$consulta = "SELECT
	*
	FROM
	ventas
	LEFT JOIN clientes USING(id_clientes)
	LEFT JOIN vendedores ON ventas.id_vendedores = vendedores.id_vendedores
	WHERE
	DATE(fecha_ventas) BETWEEN '$fecha_inicial'
	AND '$fecha_final'
	
	ORDER BY id_ventas DESC
	";
	
	
	
	
	
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
		
		<title>Ventas</title>
		
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
						VENTAS
						
					</h3>
					<a href="nueva_venta.php?tipo_movimiento=VENTA" class="btn btn-success" >
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
							<label for="fecha_inicio">Desde:</label>
							<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo $fecha_inicial;?>">
						</div>
						<div class="form-group mr-2">
							<label for="fecha_fin">Hasta:</label>
							<input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo $fecha_final;?>">
						</div>
						<button  class="btn btn-primary" id="btn_buscar">
							<i class="fa fa-search"></i> Buscar
						</button>
						
					</form>
				</div>
			</div>
			<hr>
			
			
			
			<div class="table-responsive">
				
				<table class="table table-hover table-condensed table-bordered">
					<tr>
						<th class="text-center">Folio</th>                                                      
						<th class="text-center">Fecha</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Total</th>
						<th class="text-center">Estatus</th>
						<th class="text-center">Facturada</th>
						<th class="text-center">Acciones</th>
					</tr>
					<?php 
						$total = 0;
						foreach($movimientos AS $i => $fila){
							
						?>
						<tr class="text-center">
							<td><?php echo $fila["id_ventas"];?></td>
							<td><?php echo date("d/m/Y", strtotime($fila["fecha_ventas"]));?></td>
							<td><?php echo $fila["razon_social_clientes"];?></td>
							<td class="text-right"><?php echo number_format($fila["total"],2);?></td>
							<td>
								
								<select class="form-control estatus_ventas" data-id_registro="<?php echo $fila["id_ventas"];?>">
									<option <?php echo $fila["estatus_ventas"] == "APROBACIÓN PENDIENTE" ? "selected" : "";?>>
										APROBACIÓN PENDIENTE 
									</option>
									<option <?php echo $fila["estatus_ventas"] == "PEDIDO SURTIDO" ? "selected" : "";?>>PEDIDO SURTIDO </option>
									<option <?php echo $fila["estatus_ventas"] == "ENTREGADO A CLIENTE" ? "selected" : "";?>>ENTREGADO A CLIENTE </option>
									<option <?php echo $fila["estatus_ventas"] == "SURTIDO PARCIAL" ? "selected" : "";?>>SURTIDO PARCIAL </option>
									<option <?php echo $fila["estatus_ventas"] == "CANCELADA" ? "selected" : "";?>>CANCELADA</option>
									
								</select>
								
								
							</td>
							<td><?php echo $fila["facturada"] == 0 ? "NO" : "SI";?></td>
							
							
							<td>
								<a href="imprimir_ventas.php?id_registro=<?php echo $fila["id_ventas"];?>" class="btn btn-sm btn-info btn_imprimir" target="_blank" 
								>
									<i class="fas fa-print" ></i> Reimprimir
								</a>
								
								<a href="../facturacion/facturas_nueva.php?id_ventas=<?php echo $fila["id_ventas"];?>" class="btn btn-sm btn-primary" target="_blank" 
								
								>
									<i class="fas fa-dollar-sign" ></i> Facturar
								</a>
								
								<a href="../inventarios/nuevo_movimiento.php?tipo_movimiento=SALIDA&tabla=ventas&folio=<?php echo $fila["id_ventas"]?>" class="btn btn-sm btn-success convertir_a_salida" type="button" 
								
								>
									<i class="fas fa-arrow-right" ></i>  Vale de Salida
								</a>
								
								
								<button class="btn btn-sm btn-warning btn_editar" type="button" 
								data-id_registro="<?php echo $fila["id_ventas"]?>"
								data-tabla="ventas" 
								data-id_campo="id_ventas" 
								>
									<i class="fas fa-edit" ></i> Editar
								</button>
								
								<button class="btn btn-sm btn-danger btn_borrar" type="button" 
								data-id_registro="<?php echo $fila["id_ventas"]?>"
								data-tabla="ventas" 
								data-id_campo="id_ventas" 
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
							<td colspan="5"><b><?php echo $registros;?> Registro(s)</b></td>
							
						</tr>
					</tfoot>
				</table>
			</div>
			
			
			
		</div >
		
		
		<?php  include('../scripts.php'); ?>
		<script src="index.js"></script>
	</body>
</html>	