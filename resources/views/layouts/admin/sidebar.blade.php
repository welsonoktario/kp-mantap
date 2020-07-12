<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link bg-primary">
      <img src="/images/AdminLTELogo.png" alt="Dashboard" class="brand-image img-circle elevation-3"
            style="opacity: .8">
      <span class="brand-text font-weight-light">Dashboard</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->

        <li class="nav-item">
          <router-link tag="a" to="/home" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Home</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link tag="a" to="/dompet" class="nav-link">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Dompet</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link tag="a" to="/kategori" class="nav-link">
            <i class="nav-icon fas fa-grip-horizontal"></i>
            <p>Kategori</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link tag="a" to="/transaksi" class="nav-link">
            <i class="nav-icon fas fa-money-bill-wave-alt"></i>
            <p>Transaksi</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link tag="a" to="/aktivitas" class="nav-link">
            <i class="nav-icon fas fa-poll-h"></i>
            <p>Aktivitas</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link tag="a" to="/laporan" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Laporan</p>
          </router-link>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->

  </div>
  <!-- /.sidebar -->
</aside>
