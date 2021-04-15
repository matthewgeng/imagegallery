
<div class="container p-4">
  <div class="alert alert-primary" role="alert">
  Hold ctrl and click to select images
</div>
</div>

<div class="container p-2">
	<div class="row align-items-center justify-content-center">
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
      
        <form method="post" class="form-inline" action="<?php echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=moderator&edit=true');?>" >


            <input type="hidden" id="files" name="filesForApproval" value="">

        <button type="submit" id="deleteButton" name="deleteImage" value="delete" class="btn btn-default btn-md edit btn-danger">
                  <span class="oi oi-x" title="x" aria-hidden="true"></span> Remove 
        </button>

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

		<form method="post" class="form-inline" action="<?php echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=moderator&&edit=true');?>" >
