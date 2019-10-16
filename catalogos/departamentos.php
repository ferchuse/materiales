<?php
	
	include("../login/login_success.php");
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "catalogos";
	$consulta = "SELECT * FROM departamentos ";
	$result = mysqli_query($link, $consulta);
	
	if($result){
		while($fila = mysqli_fetch_assoc($result)){
			$departamentos[] = $fila;
		}
	}
	else{ 
		die("Error en la consulta $consulta". mysqli_error($link));
	}
	// echo "<script> console.log()"
	
?>

<!DOCTYPE html>
<html lang="es">
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			#btn_buscar {
			position: relative;
			top: 25px;
			}
		</style>
		<title>Categorías</title>
		
		<?php include("../styles.php"); ?>
		
	</head>
	
	<body>
		
		<?php include("../menu.php"); ?>
		
		<section class="container">
			<strong>
				<h2>Categorías</h2>
			</strong>
			<hr>
			<div class="col-md-12 text-right">
				<button id="nuevo" type="button" class="btn btn-success" >
					<i class="fa fa-plus"></i> Nuevo
				</button>
			</div >
		</section>
		<br>
		
		<section class="container">
			<table class="table table-striped">
				<tr class="success">
					<td><strong>ID</strong></td>
					<td><strong>Categorías</strong></td>
					<td><strong>Características</strong></td>
					<td><strong>Acciones</strong></td>
				</tr>
				<?php foreach($departamentos AS $i=>$fila){	?>
					<tr class="">
						<td><?php echo $fila["id_departamentos"] ?></td> 
						<td><?php echo $fila["nombre_departamentos"] ?></td> 
						<td><?php echo $fila["notas"] ?></td> 
						<td>
							<button class="btn btn-warning btn_editar" type="button" 
							data-id_registro="<?php echo $fila["id_departamentos"]?>"	>
								<i class="fas fa-edit" ></i> Editar
							</button>
							
							<button class="btn btn-danger btn_borrar" type="button" 
							data-id_registro="<?php echo $fila["id_departamentos"]?>"	>
								<i class="fas fa-trash" ></i> Borrar
							</button>
							
						</td> 
					</tr>
					<?php
					}
				?>
			</table>
		</section>
		
		<?php include('../scripts.php'); ?>
		<?php include('form_departamentos.php'); ?>
		
		<pre hidden id="debug">
			<?php print_r ($departamentos)?>
			// <?php echo var_dump ($departamentos)?>
		</pre>
		
	</body>
	<script>
		$("#nuevo").click(function(){
			$("#modal_edicion").modal("show")
			
		});
		
		$("#form_edicion").submit(guardarRegistro);
		$(".btn_editar").click(cargarDatos);
		$(".btn_borrar").click(confirmaBorrar);
		
		function cargarDatos(event){
			console.log("event", event);
			let $boton = $(this);
			let $icono = $(this).find(".fas");
			let $id_registro = $(this).data("id_registro");				
			$boton.prop("disabled", true);
			$icono.toggleClass("fa-edit fa-spinner fa-spin");				
			$.ajax({ 
				"url": "../funciones/fila_select.php",
				"dataType": "JSON",
				"data": {
					"tabla": "departamentos",
					"id_campo": "id_departamentos",
					"id_valor": $id_registro						
				}
				}).done( function alTerminar (respuesta){					
				console.log("respuesta", respuesta);
				$boton.prop("disabled", false);
				$icono.toggleClass("fa-edit fa-spinner fa-spin"); 
				$("#modal_edicion").modal("show")
				$("#id_departamentos").val(respuesta.data.id_departamentos);                        
				$("#nombre_departamentos").val(respuesta.data.nombre_departamentos );              
				$("#notas").val(respuesta.data.notas);                        
				
			})
		}
		
		function guardarRegistro(event){
			console.log("guardarRegistro")
			event.preventDefault()
			let $boton = $(this).find(':submit');
			let $icono = $(this).find(".fas");
			$boton.prop("disabled", true);
			$icono.toggleClass("fa-save fa-spinner fa-spin");
			
			$.ajax({ 
				"url": "guardar_catalogo.php",
				"dataType": "JSON",
				"method": "POST",
				"data": $("#form_edicion").serializeArray()
				}).done( function alTerminar (respuesta){
				console.log("respuesta", respuesta);
				$("#modal_edicion").modal("hide");
				window.location.reload(true);
				}).fail(function(xhr, textEstatus, error){
				console.log("textEstatus", textEstatus);
				console.log("error", error);
				
				}).always(function(){
				
				$boton.prop("disabled", false);
				$icono.toggleClass("fa-save fa-spinner fa-spin"); 
			});
			
		}		
		function confirmaBorrar(event){
			console.log("confirmaBorrar")
			let $boton = $(this);
			let $fila = $(this).closest('tr');
			let $icono = $(this).find(".fas");
			$boton.prop("disabled", true);
			$icono.toggleClass("fa-trash fa-spinner fa-spin");
			
			if(confirm("¿Estás Seguro?")){
				$.ajax({ 
					"url": "../funciones/fila_delete.php",
					"dataType": "JSON",
					"method": "POST",
					"data": {
						"tabla": "departamentos",
						"id_campo": "id_departamentos",
						"id_valor": $boton.data("id_registro")
					}
					}).done( function alTerminar (respuesta){
					console.log("respuesta", respuesta);
					
					$fila.remove();
					}).fail(function(xhr, textEstatus, error){
					console.log("textEstatus", textEstatus);
					console.log("error", error);
					
					}).always(function(){
					
					$boton.prop("disabled", false);
					$icono.toggleClass("fa-trash fa-spinner fa-spin"); 
				});
			}
		}		
	</script>
</html>