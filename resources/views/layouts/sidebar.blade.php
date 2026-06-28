 {{-- Sidebar Menu --}}
 <div id="sidebar-menu">
     <ul class="metismenu list-unstyled" id="side-menu">

         <li class="menu-title text-white-50">Menu Transportasi</li>

         {{-- Dashboard Utama --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-dashboard-3-line text-white"></i>
                 <span>Dashboard Utama</span>
                 <span class="badge bg-light text-primary float-end">Main</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li>
                     <a href="{{ route('dashboard') }}" class="text-white-50">
                         Ringkasan Dashboard
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('dashboard.armada') }}" class="text-white-50">
                         Total Armada Aktif
                     </a>
                 </li>
                 <li><a href="#" class="text-white-50">Total Perjalanan Hari Ini</a></li>
                 <li><a href="#" class="text-white-50">Jumlah Penumpang</a></li>
                 <li><a href="#" class="text-white-50">Jumlah Insiden</a></li>
                 <li><a href="#" class="text-white-50">Peta Realtime Armada</a></li>
             </ul>
         </li>

         {{-- Data Master --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-database-2-line text-white"></i>
                 <span>Data Master</span>
                 <span class="badge bg-light text-primary float-end">Data</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li>
                     <a href="{{ route('admin.operators.index') }}" class="text-white-50">
                         Data Operator
                     </a>
                 </li>
                 <li><a href="#" class="text-white-50">Data Armada</a></li>
                 <li><a href="#" class="text-white-50">Data Pengemudi</a></li>
                 <li><a href="#" class="text-white-50">Data Jenis Transportasi</a></li>
                 <li><a href="#" class="text-white-50">Data Rute</a></li>
                 <li><a href="#" class="text-white-50">Data Halte</a></li>
             </ul>
         </li>

         {{-- Operasional --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-road-map-line text-white"></i>
                 <span>Operasional</span>
                 <span class="badge bg-light text-primary float-end">Ops</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="#" class="text-white-50">Jadwal Operasional</a></li>
                 <li><a href="#" class="text-white-50">Perjalanan Aktif</a></li>
                 <li><a href="#" class="text-white-50">Riwayat Perjalanan</a></li>
                 <li><a href="#" class="text-white-50">GPS Tracking</a></li>
             </ul>
         </li>

         {{-- Monitoring --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-radar-line text-white"></i>
                 <span>Monitoring</span>
                 <span class="badge bg-warning text-dark float-end">Live</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="#" class="text-white-50">Posisi Armada Realtime</a></li>
                 <li><a href="#" class="text-white-50">Keterlambatan</a></li>
                 <li><a href="#" class="text-white-50">Kepadatan Penumpang</a></li>
                 <li><a href="#" class="text-white-50">Insiden Perjalanan</a></li>
                 <li><a href="#" class="text-white-50">Notifikasi Alert</a></li>
             </ul>
         </li>

         {{-- Laporan --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-file-chart-line text-white"></i>
                 <span>Laporan</span>
                 <span class="badge bg-light text-primary float-end">Report</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li><a href="#" class="text-white-50">Laporan Perjalanan</a></li>
                 <li><a href="#" class="text-white-50">Laporan Penumpang</a></li>
                 <li><a href="#" class="text-white-50">Laporan Insiden</a></li>
                 <li><a href="#" class="text-white-50">Laporan Performa Rute</a></li>
                 <li><a href="#" class="text-white-50">Laporan Perawatan Armada</a></li>
             </ul>
         </li>

         {{-- Pengaturan --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-settings-3-line text-white"></i>
                 <span>Pengaturan</span>
                 <span class="badge bg-light text-primary float-end">Admin</span>
             </a>

             <ul class="sub-menu" aria-expanded="false">
                 <li>
                     <a href="{{ route('admin.users.index') }}" class="text-white-50">
                         User
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('admin.roles.index') }}" class="text-white-50">
                         Role
                     </a>
                 </li>
             </ul>
         </li>

     </ul>
 </div>
