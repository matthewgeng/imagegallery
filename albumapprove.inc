<div class="container p-4">
  <div class="alert alert-primary" role="alert">
  Hold ctrl and click to select images
</div>
</div>


<div class="container p-2">
	<div class="row align-items-center justify-content-center">
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
      <div class="btn-group mr-4" role="group" aria-label="First group">
        <button type="button" id="selectAll" class="btn btn-default btn-md edit btn-light">
          <span class="oi oi-menu-selected" title="select all" aria-hidden="true"></span>Select All
        </button>
        <button type="button" id="selectOpposite" class="btn btn-default btn-md edit btn-light">
          <span class="oi oi-menu-selected" title="select oppositell" aria-hidden="true"></span>Select Opposite
        </button>
      </div>
        <form method="post" class="form-inline" action="<?php echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=approve');?>" >

      <div class="btn-group mr-4" role="group" aria-label="Second group">
            <input type="hidden" id="files" name="filesForApproval" value="">
        <button type="submit" id="approveButton" name="approveImage" value="approve" class="btn btn-default btn-md edit btn-primary ">
                <span class="oi oi-check" title="check" aria-hidden="true"></span> Approve
              </button>
              <button type="submit" id="disapproveButton" name="disapproveImage" value="disapprove" class="btn btn-default btn-md edit btn-warning ">
                <span class="oi oi-check" title="check" aria-hidden="true"></span> Disapprove
              </button>
        <button type="submit" id="deleteButton" name="deleteImage" value="delete" class="btn btn-default btn-md edit btn-danger">
                  <span class="oi oi-x" title="x" aria-hidden="true"></span> Remove 
        </button>
      </div>
      </form>

</div>

		
</div>
</div>
<div class="container p-2">
</div>
<div class="container p-4">
  <div class="alert alert-info" role="alert">
  Unapproved Images
</div>
</div>