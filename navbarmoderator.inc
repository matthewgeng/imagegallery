		<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php?page=moderator">Image Gallery</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item " id="home">
        <a class="nav-link" href="?page=moderator">Home <span class="sr-only">(current)</span></a>
      </li>
	   <li class="nav-item" id="user">
        <a class="nav-link" href="index.php">User <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" id="approve">
        <a class="nav-link"  href="?page=approve">Approve Images <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" id="edit">
        <a class="nav-link"  href="?page=moderator&edit=true">Edit <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Image Type
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			
			<label class="dropdown-item imageType" id="labelPrivateCheck">
			  <input class="form-check-input accessCheck" type="checkbox" name="access" id="privateCheck" value="private"> Private
			</label>
			
			  <label class="dropdown-item imageType"  id="labelPublicCheck">
			  <input class="form-check-input  accessCheck" type="checkbox" name="access" id="publicCheck" value="public"> Public
			  </label>

			<div class="dropdown-divider"></div>
			
			<label class="dropdown-item imageType"  id="labelAllCheck">
			  <input class="form-check-input  accessCheck" type="checkbox" name="access" id="allCheck" value="all"> All
			</label>
		</div>
      </li>


      <li class="nav-item" id="download">
        <a class="nav-link" href="uploadedImages.zip" > Download All <span class="sr-only">(current)</span></a>
      </li>

    </ul>

    <ul class="navbar-nav navbar-right">

           <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSort" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="oi oi-random"></span>
                Sort
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownSort">
          <form method="post" action="<?php if ($isEditing=== "true"){
          echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=' . $page .'&edit=' . $isEditing);
        }else{
          echo (htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=' . $page);
      } ?>">
            <button class="dropdown-item" type="submit" id="sortbyfirstname" name="sortbyfirstname">
                  Sort by First Name
            </button>
            <button class="dropdown-item" type="submit" id="sortbylastname" name="sortbylastname" >
                  Sort by Last Name
            </button>
            <button class="dropdown-item" type="submit" id="sortbyuploaddate" name="date">
                  <span class="oi oi-clock"></span> Sort by Upload Date
            </button>
          </form>

            </div>

            </li>
    </ul>

    <form class="form-inline my-2 my-lg-0" id="searchbar" >
      <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search tag" name="search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>