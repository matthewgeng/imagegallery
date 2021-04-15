		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="?page=moderator">Home <span class="sr-only">(current)</span></a>
      </li>
	   <li class="nav-item active">
        <a class="nav-link" href="index.php">User <span class="sr-only">(current)</span></a>
      </li>
  <li class="nav-item active">
        <a class="nav-link" href="?page=edit">Edit <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Image Type
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<div>
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
		
			<div>

          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>

    </ul>
    <form class="form-inline my-2 my-lg-0" id="searchbar" >
      <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search tag" name="search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>