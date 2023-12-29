<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Menu</h3>
    <ul class="nav side-menu">

      <li><a href="/index"><i class="fa fa-home"></i> Beranda</a></li>
      
      @if ($roleinfo->id == $adminRoleId)
      <li><a href="/roleconfig"><i class="fa fa-user"></i> Konfigurasi Role</a></li>
      <li><a><i class="fa fa-edit"></i> Manajemen Data <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="/pekerjaan">Master Pekerjaan</a></li>
          <li><a href="/member">Master Member</a></li>
          <li><a href="/tindakan">Master Tindakan</a></li>
          <li><a href="/satuan">Master Satuan Obat</a></li>
          <li><a href="/obat">Master Obat</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-stethoscope"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="/pasien">Registrasi Pasien</a></li>
            <li><a href="/datapasien">Transaksi Pasien</a></li>
            <li><a href="/pembayaran">Transaksi Pembayaran</a></li>
        </ul>
      </li>
      <li><a href="/profile"><i class="fa fa-cog"></i> Pengaturan Akun</a></li>
      @else
          @if ($roleinfo->pekerjaanpg == 'none' &&
          $roleinfo->nakespg == 'none' &&
          $roleinfo->tindakanpg == 'none' &&
          $roleinfo->satuanpg == 'none' &&
          $roleinfo->obatpg == 'none')
              
          @else
          <li><a><i class="fa fa-edit"></i> Manajemen Data <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              @if ($roleinfo->pekerjaanpg != 'none')
                <li><a href="/pekerjaan">Master Pekerjaan</a></li>
              @endif
              @if ($roleinfo->nakespg != 'none')
                <li><a href="/member">Master Member</a></li>
              @endif
              @if ($roleinfo->tindakanpg != 'none')
                <li><a href="/tindakan">Master Tindakan</a></li>
              @endif
              @if ($roleinfo->satuanpg != 'none')
                <li><a href="satuan">Master Satuan Obat</a></li>
              @endif
              @if ($roleinfo->obatpg != 'none')
                <li><a href="/obat">Master Obat</a></li>
              @endif
            </ul>
          </li>
          @endif
          @if ($roleinfo->pasienTranspg == 'none' &&
          $roleinfo->paymentTranspg	 == 'none' &&
          $roleinfo->regpasienpg == 'none')
              
          @else
          <li><a><i class="fa fa-stethoscope"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              @if ($roleinfo->regpasienpg != 'none')
                <li><a href="/pasien">Registrasi Pasien</a></li>
              @endif
              @if ($roleinfo->pasienTranspg != 'none')
                <li><a href="/datapasien">Transaksi Pasien</a></li>
              @endif
              @if ($roleinfo->paymentTranspg != 'none')
                <li><a href="/pembayaran">Transaksi Pembayaran</a></li>
              @endif
                          
            </ul>
          </li>
          @endif
          @if ($roleinfo->profilepg != 'none')
            <li><a href="/profile"><i class="fa fa-cog"></i> Pengaturan Akun</a></li>
          @endif
      @endif
    </ul>
  </div>    
</div>
<!-- /sidebar menu -->

<div class="sidebar-footer hidden-small text-center">
  <p>KMB | {{ $infos->nama }}</p>
</div>
