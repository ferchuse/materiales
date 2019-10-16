<?php 
	include("../conexi.php");
	$link = Conectarse();
	

	if($_POST["tipo_movimiento"] == "ENTRADA"){
		$insertar_movimiento = "INSERT INTO entradas SET
		id_entradas = '{$_POST['folio']}',
		fecha_entradas = CONCAT('{$_POST["fecha_movimiento"]}', ' ',CURTIME()),
		id_usuarios = '{$_COOKIE['id_usuarios']}',
		referencia = '{$_POST['referencia']}',
		articulos = '{$_POST['articulos']}'
		
		ON DUPLICATE KEY UPDATE 
		id_entradas = '{$_POST['folio']}',
		fecha_entradas = CONCAT('{$_POST["fecha_movimiento"]}', ' ',CURTIME()),
		id_usuarios = '{$_COOKIE['id_usuarios']}',
		referencia = '{$_POST['referencia']}',
		articulos = '{$_POST['articulos']}'
		";
		
		$borrar = "DELETE FROM entradas_productos WHERE id_entradas = '{$_POST['folio']}'";
	}
	else{
		$insertar_movimiento = "INSERT INTO salidas SET
		id_salidas = '{$_POST['folio']}',
		fecha_salidas = CONCAT('{$_POST["fecha_movimiento"]}', ' ',CURTIME()),
		id_usuarios = '{$_COOKIE['id_usuarios']}',
		referencia = '{$_POST['referencia']}',
		articulos = '{$_POST['articulos']}'
		
		ON DUPLICATE KEY UPDATE 
		
		id_salidas = '{$_POST['folio']}',
		fecha_salidas = CONCAT('{$_POST["fecha_movimiento"]}', ' ',CURTIME()),
		id_usuarios = '{$_COOKIE['id_usuarios']}',
		referencia = '{$_POST['referencia']}',
		articulos = '{$_POST['articulos']}'
		";
		
		$borrar = "DELETE FROM salidas_productos WHERE id_salidas = '{$_POST['folio']}'";
		
	}
	$respuesta['insertar_movimiento'] = $insertar_movimiento;
	$respuesta['borrar']["consulta"] = $borrar;
	
	$result_movimiento = mysqli_query($link, $insertar_movimiento);
	$result_borrar = mysqli_query($link, $borrar);
	
	if($result_movimiento){
		$respuesta['estatus_movimiento'] = 'success';
		$respuesta['mensaje_movimiento'] = 'Movimiento Guardado';
		$folio = mysqli_insert_id($link);
		$respuesta['folio'] = $folio;
	}
	else{
		$respuesta['estatus_movimiento'] = 'error';
		$respuesta['mensaje_movimiento'] = "Error en $insertar_movimiento :".mysqli_error($link);
	}
	
	
	if($result_borrar){
		$respuesta['borrar']["estatus"] = 'success';
		$respuesta["borrar"]['mensaje'] = 'Productos Borrados';
	
	}
	else{
		$respuesta['borrar']["estatus"] = 'error';
		$respuesta["borrar"]['mensaje'] = mysqli_error($link);
		
	}
	
	
6+


	foreach($_POST['productos'] as $indice => $producto){
		
		// $ganancia_pesos = ($producto["precio"] - $producto["costo_proveedor"]) *  $producto["cantidad"];
		// $respuesta["ganancia"][] = $ganancia_pesos;
		
		
		
		//INSERTA productos de cada movimiento
		if($_POST["tipo_movimiento"] == "ENTRADA"){
			$exist_nueva = $producto["existencia_anterior"] + $producto["cantidad"];
			
			$insertar_producto = "INSERT INTO entradas_productos SET
			id_entradas = 	'$folio', 
			id_productos = 	'{$producto["id_productos"]}', 
			cantidad = 	'{$producto["cantidad"]}'
			";
			
		}
		else{
			$exist_nueva = $producto["existencia_anterior"] - $producto["cantidad"];
			
			$insertar_producto = "INSERT INTO salidas_productos SET
			id_salidas = 	'$folio', 
			id_productos = 	'{$producto["id_productos"]}', 
			cantidad = 	'{$producto["cantidad"]}'
			";
		}
		
		$result_productos = mysqli_query( $link, $insertar_producto );
		
		$respuesta["result_productos"] = $result_productos.": ".mysqli_error($link) ;
		
		
		//actualiza existencias
		
		$update_existencia = "UPDATE productos SET existencia_productos = '$exist_nueva''
		WHERE id_productos = '{$producto["id_productos"]}'	"; 
		
		$result_existencia = mysqli_query( $link, $update_existencia );
		
		$respuesta["result_existencia"] = $result_existencia ;
		
	}
	
	echo json_encode($respuesta);
?>		