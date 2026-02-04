<section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('image/logo.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
          <a href="/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>{{ session()->get('user') }}
           </a>
        </li>


        <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i> <span>Master Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/barang')}}"><i class="fa fa-circle-o"></i>Daftar Barang</a></li>
            <li><a href="{{url('/menu')}}"><i class="fa fa-circle-o"></i>Daftar Menu</a></li>
            <li><a href="{{url('/kategori')}}"><i class="fa fa-circle-o"></i>Kategori Barang</a></li>
            <li><a href="{{url('/stokinventori')}}"><i class="fa fa-circle-o"></i>Stok Inventori</a></li>
          </ul>
        </li>
        <li class="treeview">
        <a href="#">
            <i class="fa fa-table"></i> <span>Master Administrasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/supplier')}}"><i class="fa fa-circle-o"></i>Supplier</a></li>
            <li><a href="{{url('/pelanggan')}}"><i class="fa fa-circle-o"></i>Customer</a></li>
            <li><a href="{{url('/user')}}"><i class="fa fa-circle-o"></i>User</a></li>
          </ul>
        </li>
        <li >
          <a href="{{url('/pembelian')}}">
            <i class="fa fa-calendar"></i> <span>Pembelian</span>
          </a>
        </li>
        <li>
          <a href="{{url('/liveorder')}}">
            <i class="fa fa-calendar"></i> <span>Live Order</span>
          </a>
        </li>
        <li>
          <a href="{{url('/meja')}}">
            <i class="fa fa-calendar"></i> <span>Table</span>
          </a>
        </li>
      
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/laporanpenjualan')}}"><i class="fa fa-circle-o"></i>Laporan Penjualan Harian</a></li>
            <li><a href="{{url('/laporanpenjualanbulanan')}}"><i class="fa fa-circle-o"></i>Laporan Penjualan Bulanan</a></li>
            <li><a href="{{url('/laporanpembelian')}}"><i class="fa fa-circle-o"></i>Laporan Pembelian</a></li>
            <li><a href="{{url('/laporanpembelianbulanan')}}"><i class="fa fa-circle-o"></i>Laporan Pembelian Bulanan</a></li>
            <li><a href="{{url('/laporanpenjualanbarang')}}"><i class="fa fa-circle-o"></i>Laporan Penjualan Barang</a></li>
            <li><a href="{{url('/laporanstokopname')}}"><i class="fa fa-circle-o"></i>Laporan Stok Opname</a></li>
          </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->