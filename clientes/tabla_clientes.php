
<?php
	
	include("../conexi.php");
	$link = Conectarse();
	
	//TODO convertir en funcion
	$lista_clientes = [];
	
	$consulta = "
	SELECT
	*,
	
	
	COALESCE ( suma_cargos, 0 ) - COALESCE ( suma_abonos, 0 ) AS saldo 
	FROM
	clientes
	LEFT JOIN ( SELECT id_clientes, SUM( total ) AS suma_cargos FROM ventas GROUP BY id_clientes ) AS t_cargos USING ( id_clientes )
	LEFT JOIN ( SELECT id_clientes, SUM( importe ) AS suma_abonos FROM abonos GROUP BY id_clientes ) AS t_abonos USING ( id_clientes ) 
	LEFT JOIN vendedores USING(id_vendedores)
	WHERE 1 
	";
	if($_GET["id_vendedores"] != ''){
		
		$consulta.="AND id_vendedores = '{$_GET["id_vendedores"]}'
	";
	}
	$consulta.="
	ORDER BY
	{$_GET["sort"]} {$_GET["order"]}
	";
	
	
	$result = mysqli_query($link, $consulta) or die("<pre>Error en $consulta" . mysqli_error($link) . "</pre>");
	
	while ($fila = mysqli_fetch_assoc($result)) {
		
		$lista_clientes[] = $fila;
	}
?>
<pre hidden>
	<?php echo $consulta; ?>
</pre>

<table class="table table-hover" id="tabla_registros">
	<thead class=" text-white">
		<tr>
			<th class="text-center"><a class="sort" href="#!" data-columna="razon_social_clientes">Razón Social</a> </th>
			<th class="text-center"><a class="sort" href="#!" data-columna="rfc_clientes">RFC</a> </th>
			<th class="text-center"><a class="sort" href="#!" data-columna="nombre_vendedores">Vendedor</a> </th>
			<th class="text-center"><a class="sort" href="#!" data-columna="saldo">Saldo</a> </th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$total_deuda=0;
			foreach ($lista_clientes as $i => $cliente) {
				$total_deuda+=$cliente["saldo"];
			?>
			<tr class="text-center">
				<td><?php echo $cliente["razon_social_clientes"]; ?></td>
				<td><?php echo $cliente["rfc_clientes"]; ?></td>
				<td><?php echo $cliente["nombre_vendedores"]; ?></td>
				<td>$<?php echo number_format($cliente["saldo"]); ?></td>
				<td>
					<button class="btn btn-success btn_cargos" data-id_registro="<?php echo $cliente["id_clientes"] ?>" data-saldo="<?php echo $cliente["saldo"] ?>">
						+ <i class="fa fa-dollar-sign"></i> Cargo
					</button>
					<button class="btn btn-danger btn_abonos" data-id_registro="<?php echo $cliente["id_clientes"] ?>" data-saldo="<?php echo $cliente["saldo"] ?>">
						- <i class="fa fa-dollar-sign"></i> Abono
					</button>
					<button class="btn btn-info btn_historial" data-id_registro="<?php echo $cliente["id_clientes"] ?>" data-nombre="<?php echo $cliente["nombre_clientes"] ?>">
						<i class="fa fa-history"></i> Historial
					</button>
					<button class="btn btn-warning btn_editar" data-id_registro="<?php echo $cliente["id_clientes"] ?>">
						<i class="fa fa-edit"></i> Editar
					</button>
				</td>
				
			</tr>
			<?php
			}
		?>
	</tbody>
	<tfoot>
		<tr class="text-center bg-info text-white h5">
			
			<td colspan="3" class="text-right">DEUDA TOTAL:</td>
			
			<td>$<?php echo number_format($total_deuda); ?></td>
			<td></td>
			
		</tr>
	</tfoot>
</table>
