<div class="container">
	<div class="row align-items-center justify-content-center">
		<form method="post" class="form-inline" action="<?php echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=approve');?>" enctype="multipart/form-data">
			<input type="hidden" id="files" name="filesForApproval" value="3487">
	<button type="submit" id="approveButton" name="approveImage" value="approve" class="btn btn-default btn-md edit btn-outline-primary">
          <span class="oi oi-check" title="check" aria-hidden="true"></span>Approve
        </button>
<div class="col-1"></div>
<button type="submit" id="deleteButton" name="deleteImage" value="delete" class="btn btn-default btn-md edit btn-outline-danger">
          <span class="oi oi-x" title="x" aria-hidden="true"></span> Remove 
</button>
</form>
</div>
</div>