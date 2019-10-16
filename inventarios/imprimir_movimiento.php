<?php
	
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "compras";
	
	if ("{$_GET['tipo_movimiento']}" == "ENTRADA") {
		$consulta = "SELECT * FROM entradas
		LEFT JOIN entradas_productos USING (id_entradas)
		LEFT JOIN productos USING (id_productos)
		WHERE id_entradas={$_GET["id_movimiento"]}";
		
		$result = mysqli_query($link, $consulta);
		
		while ($fila = mysqli_fetch_assoc($result)) {
			$filas[] = $fila;
		}
		
	} 
	else {
		$consulta =  "SELECT * FROM salidas
		LEFT JOIN salidas_productos USING (id_salidas)
		LEFT JOIN productos USING (id_productos)
		WHERE id_salidas={$_GET["id_movimiento"]}";
		
		$result = mysqli_query($link, $consulta);
		
		while ($fila = mysqli_fetch_assoc($result)) {
			$filas[] = $fila;
		}
		
		
	}
	
?>

<!DOCTYPE html>
<html lang="es">
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php if ("{$_GET['tipo_movimiento']}" == "ENTRADA") { ?>
			<title>Imprimir Vale de Entrada</title>
			<?php } else { ?>
			<title>Imprimir Vale de Salida</title>
		<?php } ?>
		
		<?php include("../styles.php"); ?>
		<link rel="stylesheet" href="imprimir_movimiento.css">
	</head>
	
	<body>
		<div class="container h4">
			<section class="mt-3 ">
				<div class="row">
					
					<?php if ("{$_GET['tipo_movimiento']}" == "ENTRADA") { ?>
						<div class="col-12">
							<h3 class="text-center">
								<strong>Vale de Entrada</strong>
							</h3>
						</div>
						
						<div class="col-12">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-3"><strong>Folio:</strong></div>
										<div class="col-sm-8"><?php echo $filas[0]["id_entradas"] ?></div>
									</div>
									
									<div class="row">
										<div class="col-sm-3"><strong>Fecha:</strong></div>
										<div class="col-sm-8"><?php echo date("d/m/Y", strtotime($filas[0]["fecha_entradas"])); ?></div>
									</div>
									<div class="row">
										<div class="col-sm-3"><strong>Referencia:</strong></div>
										<div class="col-sm-8"><?php echo($filas[0]["referencia"]); ?></div>
									</div>
								</div>				
								
								<div class="col-2 text-right">
									<img class="img-fluid" src="../img/logo.png" alt="">
								</div>
							</div>
						</div>
						<?php 
						} 
						else { ?>
						<div class="col-12">
							<h3 class="text-center">
								<strong>Vale de Salida</strong>
							</h3>
						</div>
						
						<div class="col-12">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-3"><strong>Folio:</strong></div>
										<div class="col-sm-8"><?php echo $filas[0]["id_salidas"] ?></div>
									</div>
									
									<div class="row">
										<div class="col-sm-3"><strong>Fecha:</strong></div>
										<div class="col-sm-8"><?php echo date("d/m/Y", strtotime($filas[0]["fecha_salidas"])); ?></div>
									</div>
									<div class="row">
										<div class="col-sm-3"><strong>Referencia:</strong></div>
										<div class="col-sm-8"><?php echo($filas[0]["referencia"]); ?></div>
									</div>
								</div>				
								
								<div class="col-2 text-right">
									<img  class="img-fluid" src="../img/logo.png" alt="">
								</div>
							</div>
						</div>
					<?php } ?>
					
				</div>
				
				<div class="mt-3 row">
					<table id="tabla_venta" class="col-12 table table-hover table-bordered table-condensed">
						<?php if ("{$_GET['tipo_movimiento']}" == "ENTRADA") { ?>
							<thead class="bg-success">
								<?php } else { ?>
								<thead class="bg-danger">
								<?php } ?>
								
								<tr>
									<th class="text-center">Código</th>
									<th class="text-center">Descripción</th>
									<th class="text-center">Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach ($filas as $i => $producto) { ?>
									<tr>
										<th class="text-center"><?php echo $producto["codigo_productos"] ?></th>
										<th class="text-center"><?php echo $producto["descripcion_productos"] ?></th>
										<th class="text-center"><?php echo $producto["cantidad"] ?></th>
									</tr>
									<?php 
									}
								?>
							</tbody>
						</table>
					</div>
				</section>
				
				<section class="mt-5 container">
					<div class="row">
						<div class="col-3">Artículos: <?php echo $filas[0]["articulos"]?></div>
						
						<div class="col-6 "></div>
						<div class="col-3 border-top border-dark text-center">Recibe</div>
					</div>
				</section>
				<pre hidden>
					<?php print_r($filas)?>
				</pre>
				
			</div>
		</body>
		
	</html>					