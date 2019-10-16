<form id="form_granel" autocomplete="off">
	<div id="modal_granel" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-title text-center">Ingresa Cantidad</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-body">
					<div class="form-group " hidden>
						<label for="">100 gramos:</label> $<span id="ciengramos"></span><br>
						<label for="">1/4 Kilo:</label> $<span id="cuartogramos"></span><br>
						<label for="">1/2 Kilo:</label> $<span id="mediogramos"></span>
					</div>
					<div class="form-group col-sm-12 " hidden>
						<label for="precio">1 Kg:</label>
						<input class="form-control" name="precio" id="precio">
					</div>
					<div class="form-group col-sm-12">
						<label for="unidad_granel">Cantidad:</label>
						<input  type="number" value="10"  step="0.001" class="form-control input-lg text-center" name="cantidad" id="cantidad">
					</div>
					<div class="form-group col-sm-6 " hidden>
						<label for="costo_granel">Importe:</label>
						<input  type="number" step=".01" class="form-control input-lg" name="importe" id="importe">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success" id="agregar_granel"><i class="fa fa-check"></i> Aceptar</button>
				</div>
			</div>
			
		</div>
	</div>
</form>