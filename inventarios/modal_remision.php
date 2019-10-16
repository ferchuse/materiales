<form id="form_remision" autocomplete="off">
	<div id="modal_remision" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">Nueva Nota de Remisión</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-body">
					<div class="form-group " >
						
					</div>
					<div class="form-group " >
						<label for="">Vendedor</label>
							<?php echo generar_select($link, "vendedores", "id_vendedores", "nombre_vendedores");?>
					</div>
					<div class="form-group">
						<label for="">Cliente:</label>
						<?php echo generar_select($link, "clientes", "id_clientes", "razon_social_clientes");?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success" ><i class="fa fa-save"></i> Guardar</button>
				</div>
			</div>
			
		</div>
	</div>
</form>