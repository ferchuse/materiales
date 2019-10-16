<?php
	include("../login/login_success.php");
	include("../funciones/generar_select.php");
	include("../conexi.php");
	
	$link = Conectarse();
	$menu_activo = $_GET["tipo_movimiento"];
	
	switch($_GET["tipo_movimiento"]){
		
		case 'ENTRADA':
		$bg = "bg-success";
		$display = "none";
		break;
		case 'SALIDA':
		$bg = "bg-danger";
		$display = "none";
		break;
		case 'VENTA':
		$bg = "bg-info";
		$display = "";
		break;
		
	}
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<style>
			.tabla_totales .row{
			margin-bottom: 10px;
			}
			
			.tab-pane {
			display: block;
			overflow: auto;
			overflow-x: hidden;
			height: 350px;
			width: 100%;
			padding: 10px;				
			}			
		</style> 
		
		
		<style>
			.venta{
			display: <?php echo $display;?>;
			}
		</style> 
		
		
		
    <title>Nueva Venta</title>
    <?php include("../styles.php");?>
	</head>
  <body>
		<?php include("../menu.php");?>
		
		<form id="form_agregar_producto" class="" autocomplete="off">
		</form>
		<div class="container-fluid d-print-none">
			<div class="row">
				
				<div class="col-md-3" hidden>
					<label for="">Código del Producto:</label>
					
					<input id="codigo_producto" form="form_agregar_producto"   type="search" class="form-control" placeholder="Presiona Enter para agregar" >
					
				</div>
				<div class="col-sm-3">
					
					<label for="">Descripción del Producto:</label>
					<input id="buscar_producto"  form="form_agregar_producto" autofocus type="search" class="form-control"  placeholder="Escriba para buscar">
					
				</div>
				
				<div class="col-sm-2 ">
					<div class="form-group">
						<label for="">Fecha:</label>
						<input id="fecha_movimiento"   type="date" class="form-control" value="<?php echo date("Y-m-d")?>" >
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group " >
						<label for="">Vendedor</label>
						<?php echo generar_select($link, "vendedores", "id_vendedores", "nombre_vendedores");?>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="">Cliente:</label>
						<?php echo generar_select($link, "clientes", "id_clientes", "razon_social_clientes");?>
					</div>
				</div>
				
				<div class="col-sm-2 d-none">
					<div class="form-group">
						<label for="">Movimiento:</label>
						<input id="tipo_movimiento" type="text" class="form-control" value="<?php echo $_GET["tipo_movimiento"]?>" readonly>
					</div>
				</div>
				
			</div>
			
			
			<div class="row">
				<div class="col-md-12">
				<div class="tab-pane">
					<table id="tabla_venta" class="table table-bordered table-condensed">
						<thead class="<?php echo $bg;?> text-white">
							<tr>
								<th class="text-center">Cantidad</th>
								
								<th class="text-center">Descripcion del Producto</th>
								
								<th class="text-center venta">Precio</th>
								<th class="text-center venta">Importe</th>
								<th class="text-center">Existencia</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody >
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<br>
		<section id="footer">
			<form id="form_movimientos" autocomplete="off">
				<div class="row">
					<div class="col-sm-1 col-6 h3 text-right">
						<label for="">Artículos: </label> 
					</div>
					<div class="col-sm-1 col-6 h3">
						<input readonly  id="articulos" type="text" class="form-control input-lg text-right " value="0" name="articulos">
					</div>
					
					
					<div class="col-sm-6 col-6 h3 text-right ">
						<label class="venta" for="">Subtotal:</label>  <br>
						<label class="venta" for="">IVA:</label> <br>
						<label class="venta" for="">Total:</label> 
					</div>
					<div class="col-sm-2 col-6 h3 venta">
						<input readonly  id="subtotal" type="text" class="form-control input-lg text-right venta" value="0" >
						<input readonly  id="iva" type="text" class="form-control input-lg text-right venta" value="0">
						<input readonly  id="total" type="text" class="form-control input-lg text-right venta" value="0" >
					</div>
					
					
					<div class="col-sm-2 col-12 text-right">
						<button class="btn btn-success btn-lg btn-block" type="submit" id="cerrar_venta">F12 - Guardar</button>
					</div>
				</div>
			</form>
		</section>
		
	</div>
	
	<div id="ticket" class="visible-print">
		
	</div>
	<?php  include('../scripts.php'); ?>
	<?php include('modal_cantidad.php'); ?>
	<script src="nueva_venta.js"></script>
	
</body>
</html>				