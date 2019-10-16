<?php
header("Content-Type: application/json"); 
include('../conexi.php');
$link = Conectarse();
$repuesta = array();


$consulta = "SELECT *, 
	COALESCE (entradas, 0) AS entradas,
	COALESCE (salidas, 0) AS salidas,
	COALESCE (entradas, 0) - COALESCE (salidas, 0) AS saldo
	
	FROM productos
	LEFT JOIN departamentos USING (id_departamentos) 
	LEFT JOIN (
	SELECT
	id_productos,
	SUM(cantidad) AS entradas
	FROM
	entradas LEFT JOIN
	entradas_productos USING(id_entradas)
	
	GROUP BY id_productos
	)
	AS t_entradas USING (id_productos)
	
	LEFT JOIN (
	SELECT
	id_productos,
	SUM(cantidad) AS salidas
	FROM
	salidas
	LEFT JOIN salidas_productos USING(id_salidas)
	GROUP BY id_productos
	) AS t_salidas USING (id_productos)
	


WHERE {$_POST['campo']} = '{$_POST['valor']}'";

$mensaje_error = 'no encontrado';

$result_complete = mysqli_query($link, $consulta)
or die ("Error al ejecutar consulta: $consulta".mysqli_error($link));

$numero_filas = mysqli_num_rows($result_complete);
$contador = 0;

while($fila = mysqli_fetch_assoc($result_complete)){
	$contador++;

	$respuesta["fila"] = $fila;	
}

$respuesta['numero_filas'] = "$numero_filas";

$respuesta['mensaje'] = $numero_filas < 1 ? $mensaje_error:'OK';
$respuesta["encontrado"] =  $numero_filas < 1 ? 0 : 1;
$respuesta['consulta'] = $consulta;

print(json_encode($respuesta));

?>