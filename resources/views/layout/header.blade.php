<header class="p-3 mb-3 border-bottom">
    <div class="container-fluid">
      <div class="d-flex flex-wrap justify-content-start">
        <a href="#menu-toggle" id="menu-toggle" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <i class="fas fa-bars"></i>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-left mb-md-0">
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://paimon.moe/images/characters/kaedehara_kazuha.png" alt="pfp" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Log out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>