<?php 

	function getRowsById($link, $tabla, $campo, $id){
		$respuesta = Array();
		$consulta = "SELECT *  FROM $tabla WHERE $campo = '$id'";
		
		
		$result = mysqli_query( $link, $consulta ) ;
		
		$respuesta["error"] = mysqli_error($link);
		$respuesta["consulta"] = $consulta;
		
		while($fila = mysqli_fetch_assoc($result)) {
			
			$respuesta["filas"][] = $fila ;
			
		}
		return $respuesta;
		
	}
	

