<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style="gap: 20px;">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}"><span class="flaticon-pawprint-1 mr-2"></span>HomePet</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fa fa-bars"></span> Menu
    </button>
    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
        <li class="nav-item {{ request()->is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
        <li class="nav-item {{ request()->is('Adopt') ? 'active' : '' }}"><a href="{{ route('adopt.index') }}" class="nav-link">Adopt</a>
        <li class="nav-item {{ request()->is('search') ? 'active' : '' }}"><a href="{{ url('/search') }}" class="nav-link">Search</a></li>
        <li class="nav-item {{ request()->is('gallery') ? 'active' : '' }}"><a href="{{ url('/gallery') }}" class="nav-link">Gallery</a></li>
        <li class="nav-item {{ request()->is('blog') ? 'active' : '' }}"><a href="{{ url('/blog') }}" class="nav-link">Blog</a></li>
        <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}"><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
      </ul>
    </div>
  </div>

        @guest
          <a href="{{ route('register') }}" class="btn text-white py-2 px-3 me-2"
             style="background-color: #28A745; border-radius: 50px;">SignUp</a>
          <a href="{{ route('login') }}" class="btn btn-outline-success py-2 px-3"
             style="border-radius: 50px;">LogIn</a>
        @else
          @php
            $nameParts = explode(' ', Auth::user()->name);
            $initials = strtoupper(substr($nameParts[0], 0, 1));
            if (count($nameParts) > 1) {
              $initials .= strtoupper(substr($nameParts[1], 0, 1));
            }
          @endphp

          <div class="dropdown me-3">
            <a href="#" class="btn btn-profile border border-success text-success rounded-circle d-flex align-items-center justify-content-center"
               style="width: 40px; height: 40px; font-weight: bold; font-size: 1rem; text-transform: uppercase; background-color: white;"
               id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ $initials }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="{{ route('home') }}">Profile</a></li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Sign Out
                </a>
              </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        @endguest
        <div style="width: 400px;">
          <a href="{{ route('pets.create') }}"
             class="btn text-white py-2 px-4 w-full text-center block"
             style="background-color: rgb(11, 90, 33); border-radius: 50px;">
            <strong>+</strong> Add a Pet
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
