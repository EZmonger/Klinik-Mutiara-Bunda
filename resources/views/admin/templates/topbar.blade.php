<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle" style="padding: 15%"><i class="fa fa-bars"></i></a>
      </div>        
      <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
            {{-- <img src="/assets/img/admin.png" alt=""> --}}
            <span>{{ $infos->nama }}</span>
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/profile"><i class="fa fa-cog pull-right"></i> Profil</a>              
            <form action="/logoutadminult" method="post">
              @csrf
              <button class="dropdown-item" type="submit"><i class="fa fa-sign-out pull-right"></i>
                  Log Out</button>
            </form>

          </div>
        </li>

        
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->