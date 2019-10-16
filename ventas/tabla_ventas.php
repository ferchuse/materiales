<?php 
	include('../conexi.php');
	$link = Conectarse();
	
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin = $_POST['fecha_fin'];
	
	
	function dameRegistros($link, $fecha_inicio, $fecha_fin){
		
		$filas = [];
		
		$consulta = "
		SELECT
		*
		FROM
		ventas LEFT JOIN
		clientes USING(id_clientes)
		WHERE
		DATE(fecha_ventas) BETWEEN '{$fecha_inicio}'
		AND '{$fecha_fin}'
		
		ORDER BY
		id_ventas DESC";
		
		
		$result = mysqli_query($link,$consulta_movimientos) or die ("<pre>Error en $consulta". mysqli_error($link). "</pre>");
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas[] = $fila;
			
		}
		
		return $filas;
	}
	
	$ventas = $dameRegistros($link, $_POST['fecha_inicio'], $_POST['fecha_fin']);
	
?>
<?php 
	if(mysqli_num_rows($result_movimientos) < 1){
	?>
	<br>
	
	<div class="alert alert-warning text-center">
	  <strong>No hay registros</strong> 
	</div>
	<?php		
	}
	else{
	?>
	
	
	<div class="col-4">
		<div class="card ">
			<div class="card-header bg-info text-white">
				<h4 class="text-center">
					Movimientos <?php echo $ventas[0]["nombre_departamentos"];?>
				</h4>
			</div>
			<div class="card-body" >
				<div class="table-responsive">
					
					<table class="table table-hover">
						<tr>
							<th class="text-center">Código</th>
							<th class="text-center">Entradas</th>
							<th class="text-center">Salidas</th>
							<th class="text-center">Saldo</th>
						</tr>
						<?php 
							
							foreach($ventas AS $i => $fila_movimientos){
							?>
							<tr class="text-center">
								
								<td><?php echo $fila_movimientos["codigo_productos"];?></td>
								<td><?php echo $fila_movimientos["entradas"];?></td>
								<td><?php echo $fila_movimientos["salidas"];?></td>
								<td><?php echo $fila_movimientos["entradas"]- 	$fila_movimientos["salidas"];?></td>
								
							</tr>
							<?php
								
							}
							
						?>
						
						
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="col-4">
		<div class="card ">
			<div class="card-header bg-success text-white">
				<h4 class="text-center">
					Entradas
				</h4>
			</div>
			<div class="card-body" >
				<div class="table-responsive">
					
					<table class="table table-hover">
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Folio</th>
							<th class="text-center">Código</th>
							<th class="text-center">Cantidad</th>                                                         
						</tr>
						<?php 
							$total = 0;
							foreach($entradas AS $i => $fila_entradas){
								$total+=$fila_entradas["cantidad"];
							?>
							<tr class="text-center">
								<td><?php echo date("d/m/Y", strtotime($fila_entradas["fecha_movimiento"]));?></td>
								<td><?php echo $fila_entradas["folio"];?></td>
								<td><?php echo $fila_entradas["codigo_productos"];?></td>
								<td><?php echo $fila_entradas["cantidad"];?></td>
								
							</tr>
							<?php
								
							}
							
						?>
						<tfoot> 
							<tr class="text-center h3">
								<td colspan="2"><b>TOTAL</b></td>
								<td><b><?php echo $total;?></b></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="col-sm-4">
		<div class="card ">
			<div class="card-header bg-danger text-white">
				<h4 class="text-center">
					Salidas
				</h4>
			</div>
			<div class="card-body" >
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Código</th>
							<th class="text-center">Cantidad</th>                                                         
						</tr>
						<?php 
							$total = 0;
							foreach($salidas AS $i => $fila_salidas){
								$total+=$fila_salidas["cantidad"];
							?>
							<tr class="text-center">
								<td><?php echo date("d/m/Y", strtotime($fila_salidas["fecha_movimiento"]));?></td>
								<td><?php echo $fila_salidas["codigo_productos"];?></td>
								<td><?php echo $fila_salidas["cantidad"];?></td>
							</tr>
							<?php
								
							}
							
						?>
						<tfoot> 
							<tr class="text-center h3">
								<td colspan="2"><b>TOTAL</b></td>
								<td><b><?php echo $total;?></b></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
}
?>


