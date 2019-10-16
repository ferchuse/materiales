$(document).ready(function(){
	// $('#form_reportes').submit(enviarFormulario);
	$('.btn_borrar').click(confirmaBorrar);
	// $('.btn_nota').click(nuevaRemisión);
	// $('#form_remision').submit(guardarRemision);
	
});




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