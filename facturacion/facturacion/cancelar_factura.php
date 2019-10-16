<?php
header("Content-Type: application/json");
error_reporting(0);
session_start();
date_default_timezone_set('America/Mexico_City');

include_once("../conexi.php");
include_once "sdk2.php";

$link = Conectarse();
$respuesta = array();
$rfc = $_SESSION["rfc_emisores"];

$datos['cancelar']='SI';
$datos['cfdi']='timbrados/'.$rfc."_".$_POST["folio_facturas"].'.xml';
$datos['PAC']['usuario'] = $rfc;
$datos['PAC']['pass'] =  $_SESSION["password"];
$datos['PAC']['produccion'] = 'SI'; //   
$datos['conf']['cer'] = "certificados/$rfc.cer";
$datos['conf']['key'] = "certificados/$rfc.key";
$datos['conf']['pass'] = $_SESSION["password"];

$respuesta["datos"]= $datos;

$respuesta["respuesta_pac"]= cfdi_cancelar($datos);


if($respuesta["respuesta_pac"]["codigo_mf_numero"] == 0){
	
	$mensaje_original_pac_json =  json_decode($respuesta["respuesta_pac"]["mensaje_original_pac_json"] , true);
	
	$acuse = $mensaje_original_pac_json["CancelarCSDResult"];
	
	// Actualizar estatus de Factura a CANCELADO
	$update_factura	= "UPDATE facturas SET 
				cancelada = 1, 
				motivo_cancelacion = '".$_POST["motivo_cancelacion"]."' 
				WHERE id_facturas = '".$_POST["id_facturas"]."'";
	
	if(mysqli_query($link, $update_factura)){
		$respuesta["update_factura"]["estatus"]  = "success";
		$respuesta["update_factura"]["mensaje"]  = "CFDI CANCELADO CORRECTAMENTE";
		$respuesta["update_factura"]["query"]  = $update_factura;
	}
	else{
		$respuesta["update_factura"]["estatus"]  = "error";
		$respuesta["update_factura"]["mensaje"]  = mysqli_error($link);
	
	}
	
	
	if(!file_put_contents("acuses/".$_POST["folio_facturas"].'.xml',$acuse )){
		$respuesta["acuse"]["estatus"]  = "success";
		$respuesta["acuse"]["mensaje"]  = "Acuse Creado Correctamente";
		$respuesta["acuse"]["ruta"]  = "acuses/".$_POST["folio_facturas"].'.xml';
	}
	else{
		$respuesta["acuse"]["estatus"]  = "error";
	}
}

echo json_encode($respuesta);



?>
