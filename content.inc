
	<div class="bg-contact2" style="background-image: url('images/bg-01.jpg');">
		<div class="container-contact2">
			<div class="wrap-contact2">
								<span class="contact2-form-title">
						Image Gallery
					</span>
					
				<form class="contact2-form validate-form" id="uploadForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?page=form';?>" enctype="multipart/form-data" >


					<div class="wrap-input2 validate-input <?php if(checkErrorName('first-name') === 1){echo 'alert-validate';} elseif (checkErrorName('first-name') === 2){echo 'error';}else {echo '';} ?>" data-validate="First name is required" data-error-validate="Letters and spaces only">
						<input class="input2" type="text" name="first-name" value="<?php if (isset($_POST['first-name'])){echo $_POST['first-name'];} ?>">
						<span class="focus-input2 " data-placeholder="FIRST NAME"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php if(checkErrorName('last-name') === 1){echo 'alert-validate';} elseif (checkErrorName('last-name') === 2){echo 'error';} else {echo '';} ?>" data-validate="Last name is required" data-error-validate=" Letters and spaces only">
						<input class="input2" type="text" name="last-name" value="<?php if (isset($_POST['last-name'])){echo $_POST['last-name'];} ?>">
						<span class="focus-input2" data-placeholder="LAST NAME"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkImageOk($uploadOk) ? 'error' : '' ?>" id="file-container" data-validate = "File upload is required" data-error-validate="<?php echo $errorImage ?>">
						<input  id="file-upload" type="file" name="file" >
						<span class="focus-input2" id="file-input" data-placeholder="IMAGE UPLOAD"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkError('description') ? 'data-alert-validate' : '' ?>" data-validate = "Photo description is required">
						<textarea class="input2" name="description"><?php if (isset($_POST['description'])){echo $_POST['description'];} ?></textarea>
						<span class="focus-input2" data-placeholder="PHOTO DESCRIPTION"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php echo checkError('tag') ? 'data-alert-validate' : '' ?>" data-validate = "Photo tags are required">
						<textarea class="input2" name="tag"><?php if (isset($_POST['tag'])){echo $_POST['tag'];} ?></textarea>
						<span class="focus-input2" data-placeholder="PHOTO TAGS (SEPERATE WITH , )"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php echo checkError('copyright') ? 'data-alert-validate' : '' ?>" data-validate = "Checkbox must be marked">
						<input id="button" type="checkbox" name="copyright" <?php if (isset($_POST['copyright']) && $_POST['copyright'] == "right") echo "checked";?> value="right"> <span id="copyrightmessage">
						I retain the copyright to this image and release it for use on this site.
						</span>
						<span id="button-input"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkError('access') ? 'data-alert-validate' : '' ?>" data-validate = "Checkbox must be marked">
						<input class="radio" id="public" type="radio" name="access" <?php if (isset($_POST['access']) && $_POST['access'] == "public") echo "checked";?> value="public" >
						 <span id="publicmessage"> Public </span>
						<br>
						<input class="radio" id="private" type="radio" name="access" <?php if (isset($_POST['access']) && $_POST['access'] == "private") echo "checked";?> value="private"> <span id="privatemessage"> Private </span>
						<span id="radio-input"></span>
					</div>

					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn"></div>
							<button type="submit" name="submit" class="contact2-form-btn">
								Submit
							</button>
						</div>
					</div>
					
					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn-reset"></div>
							<button type="reset" name="reset" id="reset-button" class="contact2-form-btn">
								 Reset Form
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>