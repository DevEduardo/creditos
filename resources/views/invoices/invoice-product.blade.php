<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<h4>Resumen</h4>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-sm-12 col-lg-12">
		<table class="table table-hover table-responsive table-bordered" style="margin-bottom: 8px; ">

			<tbody class="table-products">
				
			</tbody>

			<tfoot>
				<tr>
					<th colspan="2" class="text-right">Descuentos</th>
					<th colspan="2" class="text-right" discount>0.00</th>
				</tr>
				<tr>
					<th colspan="2" class="text-right">Impuestos</th>
					<th colspan="2" class="text-right" taxes>0.00</th>
				</tr>
				<tr>
					<th colspan="2" class="text-right">Total</th>
					<th colspan="2" class="text-right" total>0.00</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>


<div class="row">
	<div class="col-sm-6 col-lg-6">
		<button class="btn btn-block bg-olive" finish-invoice>
			Finalizar
		</button>
	</div>

	<div class="col-sm-6 col-lg-6">
		@isset($invoice)
			<button class="btn btn-block bg-red" cancel-invoice>
		@else
			<button class="btn btn-block bg-red" cancel-invoice disabled>
		@endisset
			Cancelar
		</button>
	</div>
</div>
