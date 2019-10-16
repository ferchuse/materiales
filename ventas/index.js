$(document).ready(function(){
	// $('#form_reportes').submit(enviarFormulario);
	$('.btn_borrar').click(confirmaBorrar);
	$('.btn_nota').click(nuevaRemisión);
	$('#form_remision').submit(guardarRemision);
	$('.estatus_ventas').change(cambiarEstatus);
	$('.convertir_a_salida').click(convertirASalida);
	
});


function nuevaRemisión(event){
	
	$('#modal_remision').modal('show');
	
}


function convertirASalida(event){
	console.log("convertirASalida");
	
	var id_registro = $(this).data('id_registro');

	
	$.ajax({
		url: 'convertir_a_salida.php',
		method: 'GET',
		data: {id_ventas: id_registro
			
		}
		}).done(function(respuesta){
		if(respuesta.estatus == "success"){
			window.location.href="../inventarios/nuevo_movimiento.php?tipo_movimiento=SALIDA&folio="+ respuesta.folio;
			alertify.success(respuesta.mensaje);
		}
		else{
			alertify.error(respuesta.mensaje);
			
		}
		}).always(function (){
		
		
	});
}

function cambiarEstatus(event){
	console.log("cambiarEstatus");
	
	var id_registro = $(this).data('id_registro');
	var estatus_ventas = $(this).val();
	
	
	$.ajax({
		url: '../funciones/fila_update.php',
		method: 'POST',
		data: {
			tabla: "ventas",
			id_campo: "id_ventas",
			id_valor: id_registro,
			valores: [
				{"name": "estatus_ventas", "value": estatus_ventas}
			]
			
		}
		}).done(function(respuesta){
		if(respuesta.estatus == "success"){
			
			alertify.success(respuesta.mensaje);
		}
		else{
			alertify.error(respuesta.mensaje);
			
		}
		}).always(function (){
		
		
	});
}

function guardarRemision(event){
	event.preventDefault();
	
	var boton = $(this).find(':submit');
	var icono = boton.find('.fa');
	var formulario = $(this).serialize();
	
	boton.prop("disabled", true);
	
	$.ajax({
		url: '../ventas/guardar_remision.php',
		method: 'POST',
		data: formulario
		}).done(function(respuesta){
		
		}).always(function (){
		
		boton.prop("disabled", false);
	});
}




function confirmaBorrar() {
	console.log("confirmaBorrar()");
	let boton = $(this);
	let icono = boton.find(".fas");
	let tabla = boton.data("tabla");
	let id_campo = boton.data("id_campo");
	let id_registro = boton.data("id_registro");
	
	if(confirm("Está Seguro")){
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-trash fa-spinner fa-spin");
		$.ajax({
			url: "../funciones/fila_delete.php",
			method: "POST",
			dataType: "JSON",
			data: {
				"tabla": tabla,
				"id_campo": id_campo,
				"id_valor": id_registro
				
			}
			
			}).done(function (respuesta) {
			console.log("respuesta", respuesta);
			
			boton.closest("tr").remove();
			
			}).fail(function (xht, error, errnum) {
			
			alertify.error("Error", errnum);
			}).always(function () {
			boton.prop("disabled", false);
			icono.toggleClass("fa-trash fa-spinner fa-spin");
			
		});
	}
	
	
}