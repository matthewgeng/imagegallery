<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
	   <li class="nav-item">
	  <form class="form-inline">
	  <div class="form-check form-check-inline" id="privateCheck">
		  <input class="form-check-input" type="checkbox" id="check" value="private">
		  <label class="form-check-label" for="check">Private</label>
		</div>
		</form>
	</li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


	<div class="bg-contact2" style="background-image: url('images/bg-01.jpg');">
		<div class="container-contact2">
			<div class="wrap-contact2">
								<span class="contact2-form-title">
						Image Gallery
					</span>
			
					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn"></div>
							<button name="album" class="contact2-form-btn">
								<a href="index.php">Home</a>
							</button>
						</div>
					</div>
					
				<form class="contact2-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" >


					<div class="wrap-input2 validate-input <?php if(checkErrorName('first-name') === 1){echo 'alert-validate';} elseif (checkErrorName('first-name') === 2){echo 'error';}else {echo '';} ?>" data-validate="First name is required" error-validate="Letters and spaces only">
						<input class="input2" type="text" name="first-name" value="<?php if (isset($_POST['first-name'])){echo $_POST['first-name'];} ?>">
						<span class="focus-input2 " data-placeholder="FIRST NAME"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php if(checkErrorName('last-name') === 1){echo 'alert-validate';} elseif (checkErrorName('last-name') === 2){echo 'error';} else {echo '';} ?>" data-validate="Last name is required" error-validate=" Letters and spaces only">
						<input class="input2" type="text" name="last-name" value="<?php if (isset($_POST['last-name'])){echo $_POST['last-name'];} ?>">
						<span class="focus-input2" data-placeholder="LAST NAME"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkImageOk($uploadOk) ? 'error' : '' ?>" id="file-container" data-validate = "File upload is required" error-validate="<?php echo $errorImage ?>">
						<input  id="file-upload" type="file" name="file" value="<?php if (isset($_POST['file'])){echo $_POST['file'];}?>">
						<span class="focus-input2" id="file-input" data-placeholder="IMAGE UPLOAD"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkError('description') ? 'alert-validate' : '' ?>" data-validate = "Photo description is required">
						<textarea class="input2" name="description"><?php if (isset($_POST['description'])){echo $_POST['description'];} ?></textarea>
						<span class="focus-input2" data-placeholder="PHOTO DESCRIPTION"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php echo checkError('tag') ? 'alert-validate' : '' ?>" data-validate = "Photo tags are required">
						<textarea class="input2" name="tag"><?php if (isset($_POST['tag'])){echo $_POST['tag'];} ?></textarea>
						<span class="focus-input2" data-placeholder="PHOTO TAGS (SEPERATE WITH , )"></span>
					</div>
					
					<div class="wrap-input2 validate-input <?php echo checkError('copyright') ? 'alert-validate' : '' ?>" data-validate = "Checkbox must be marked">
						<input class="button " type="checkbox" name="copyright" <?php if (isset($_POST['copyright']) && $_POST['copyright'] == "right") echo "checked";?> value="right"> 
						I retain the copyright to this image and release it for use on this site.
						<br>
						<span class="button-input"></span>
					</div>

					<div class="wrap-input2 validate-input <?php echo checkError('access') ? 'alert-validate' : '' ?>" data-validate = "Checkbox must be marked">
						<input class="radio" id="public" type="radio" name="access" <?php if (isset($_POST['access']) && $_POST['access'] == "public") echo "checked";?> value="public" > Public
						<br>
						<input class="radio" id="private" type="radio" name="access" <?php if (isset($_POST['access']) && $_POST['access'] == "private") echo "checked";?> value="private"> Private
						<br>
						<span class="radio-input"></span>
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
							<div class="contact2-form-bgbtn"></div>
							<button type="reset" name="reset" id="reset-button" class="contact2-form-btn">
								 Reset Form
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>