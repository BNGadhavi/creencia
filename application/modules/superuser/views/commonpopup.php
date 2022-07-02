<div class="modal fade" id="searchmodel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content border-primary">
			<div class="modal-header bg-primary">
			<h5 class="modal-title text-white"><i class="fa fa-star"></i>Search</h5>
			<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo $AdminUrl.$submitUrl ?>">
					<div class="form-group row">
					  <label for="input-8" class="col-sm-4 col-form-label">Date From</label>
					  <div class="col-sm-6">
					   <div class="input-group mb-6">
					    <input type="text" autocomplete="off" class="form-control" id="dateStart" name="dateStart">
					  </div>
					  </div>
					</div>

					<div class="form-group row">
					  <label for="input-8" class="col-sm-4 col-form-label">Date To</label>
					  <div class="col-sm-6">
					   <div class="input-group mb-6">
					    <input type="text" autocomplete="off" class="form-control" id="dateEnd" name="dateEnd">
					  </div>
					  </div>
					</div>
					<input type="submit" name="submit" value="Submit" class="btn btn-success">
				</form>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-inverse-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>