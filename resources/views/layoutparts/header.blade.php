@guest
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- container-fluid -->
@else
          <nav class="navbar navbar-expand-lg navbar-light border border-dark rounded">
            <div class="container-fluid">
              <!-- container-fluid -->
@endguest
              <!-- Branding Image -->
              <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('css/img/cmcsm_logo_short.png') }}" width="50px">
              </a>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- navbarSupportedContent -->

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ __('Medical Center') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('scene.index') }}">{{ __('Scenes') }}</a></li>
                    @if (Auth::user()->hasRoleCode('technicians'))
                    <li><a class="dropdown-item" href="{{ route('scenario.index') }}">{{ __('Scenarios') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('laboratorynorms.index') }}">{{ __('Laboratory norms') }}</a></li>
                    @endif
                    </ul>
                  </li>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Personel
                    </a>
                    <ul class="dropdown-menu">
                    <?php
                      if ( ((Auth::user()->hasRoleCode('hroperators')) ||
                        (Auth::user()->hasRoleCode('technicians'))   || 
                        (Auth::user()->hasRoleCode('coordinators'))
                        ))
                        { 
                          $roles_list = App\Models\UserHasRole::get();
                        }
                        else
                        {
                          $roles_list = DB::table('user_roles')
                          ->where('role_code', 'technicians')
                          ->orWhere('role_code', 'instructors')
                          ->orWhere('role_code', 'coordinators')
                          ->get();
                        }
                      ?>
                      @foreach ($roles_list as $row)
                      @if ($row->role_code!='')
                      <li><a class="dropdown-item" href="/users/{{$row->role_code}}">{{$row->role_names}}</a></li>
                      @endif
                      @endforeach
                      @if ( (Auth::user()->hasRoleCode('coordinators')) ||
                      (Auth::user()->hasRoleCode('hroperators')) ||
                      (Auth::user()->hasRoleCode('technicians'))
                      )
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item" href="{_{ route('worktime.month') }_}">Czas pracy</a></li>
                      <li><a class="dropdown-item" href="{_{ route('worktime.statistics_overhours') }_}">Statystyki</a></li>
                      @endif
                      @if (Auth::user()->hasRoleCode('hroperators'))
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <div style="background-color: #FF0;">
                        <li><a class="dropdown-item" href="/users/everybody">Wszyscy</a></li>
                        <li><a class="dropdown-item" href="{_{ route('libraries.user_titles') }_}"> Tytuły naukowe </a></li>
                        <li><a class="dropdown-item" href="{_{ route('libraries.workmonths') }_}"> Miesięczny czas pracy </a></li>
                        <li><a class="dropdown-item" href="{_{ route('worktime.show_attendances') }_}"> Listy obecności </a></li>
                      </div>
                      @endif
                    </ul>
                  </li>


                  @if (Auth::user()->hasRoleCode('administrators'))

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Administracja
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                      @if (Auth::user()->hasRoleCode('administrators')
                      )
                      <li><a class="dropdown-item" href="{{ route('testuj') }}"> TESTY </a></li>
                      <li><a class="dropdown-item" href="{{ route('testuj2') }}"> TESTY2 </a></li>
                      @endif
                    </ul>
                  </li>
                  @endif



                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                  <!-- Authentication Links -->
                  @guest
                  <li><a class="dropdown-item" href="{{ route('login') }}">Logowanie</a></li>
                  <li><a class="dropdown-item" href="{{ route('register') }}">Rejestracja</a></li>
                  @else
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item" href="{{ route('user.mainprofile') }}">
                        {{ __('Profile') }}
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#" id="your-darkmode-button-id">{{ __('Change theme') }}</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
                      </li>
                    </ul>
                  </li>
                  @endguest
                </ul>

              </div> <!-- navbarSupportedContent -->


            </div><!-- container-fluid -->
          </nav>
