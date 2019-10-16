<?php
	include ('../conexi.php');
	$link = Conectarse();
	
	
	$respuesta= array();
	// TODO
	// HACER DINAMICO id_ y nombre_ para que se adapte a cualquier TABLA
	
	$query = "INSERT INTO departamentos
	SET
	id_departamentos = '{$_POST["id_departamentos"]}',
	nombre_departamentos = '{$_POST["nombre_departamentos"]}',
	notas = '{$_POST["notas"]}'
	
	ON DUPLICATE KEY UPDATE 
	
	id_departamentos = '{$_POST["id_departamentos"]}',
	nombre_departamentos = '{$_POST["nombre_departamentos"]}',
	notas = '{$_POST["notas"]}'
	";
	$result = mysqli_query($link, $query);
	
	if($result){
		$respuesta["status"] = "success";
		$respuesta["mensaje"] = "Se guardó correctamente";
	}
	else{
		$respuesta["status"] = "error";
		$respuesta["mensaje"] = "Error en la consulta $query". mysqli_error($link);
		
	}
	
	echo json_encode($respuesta);
?>