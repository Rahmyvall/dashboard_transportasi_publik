 {{-- Sidebar Menu --}}
 <div id="sidebar-menu">
     <ul class="metismenu list-unstyled" id="side-menu">

         <li class="menu-title text-white-50">Menu Transportasi</li>

         {{-- DASHBOARD --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-dashboard-3-line text-white"></i>
                 <span>Dashboard</span>
                 <span class="badge bg-light text-primary float-end">Main</span>
             </a>

             <ul class="sub-menu">
                 <li><a href="{{ route('dashboard') }}" class="text-white-50">Ringkasan</a></li>
                 <li><a href="{{ route('dashboard.armada') }}" class="text-white-50">Armada Aktif</a></li>
                 <li><a href="{{ route('dashboard.perjalanan') }}" class="text-white-50">Perjalanan Hari Ini</a></li>
                 <li><a href="{{ route('dashboard.penumpang') }}" class="text-white-50">Penumpang</a></li>
                 <li><a href="{{ route('dashboard.peta') }}" class="text-white-50">Peta Realtime</a></li>
             </ul>
         </li>


         {{-- DATA MASTER --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-database-2-line text-white"></i>
                 <span>Data Master</span>
                 <span class="badge bg-light text-primary float-end">Data</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="{{ route('admin.operators.index') }}" class="text-white-50">Operator</a></li>
                 <li><a href="{{ route('admin.transport-modes.index') }}" class="text-white-50">Transport Mode</a></li>

                 <li><a href="{{ route('admin.routes.index') }}" class="text-white-50">Rute</a></li>
                 <li><a href="#" class="text-white-50">Halte / Stasiun</a></li>
                 <li><a href="#" class="text-white-50">Rute Stop</a></li>

                 <li><a href="#" class="text-white-50">Armada</a></li>
                 <li><a href="#" class="text-white-50">Driver</a></li>

             </ul>
         </li>


         {{-- OPERASIONAL --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-road-map-line text-white"></i>
                 <span>Operasional</span>
                 <span class="badge bg-light text-primary float-end">Ops</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="#" class="text-white-50">Jadwal</a></li>
                 <li><a href="#" class="text-white-50">Perjalanan</a></li>
                 <li><a href="#" class="text-white-50">Perjalanan Aktif</a></li>
                 <li><a href="#" class="text-white-50">Riwayat</a></li>

                 <li><a href="#" class="text-white-50">Penumpang</a></li>
                 <li><a href="#" class="text-white-50">Tiket</a></li>

             </ul>
         </li>


         {{-- MONITORING --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-radar-line text-white"></i>
                 <span>Monitoring</span>
                 <span class="badge bg-warning text-dark float-end">Live</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="#" class="text-white-50">GPS Armada</a></li>
                 <li><a href="#" class="text-white-50">Keterlambatan</a></li>
                 <li><a href="#" class="text-white-50">Kepadatan</a>
                 </li>

                 <li><a href="#" class="text-white-50">Insiden</a></li>
                 <li><a href="#" class="text-white-50">Alert</a></li>

                 <li><a href="#" class="text-white-50">Notifikasi</a>
                 </li>

             </ul>
         </li>


         {{-- MAINTENANCE --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-tools-line text-white"></i>
                 <span>Maintenance</span>
                 <span class="badge bg-light text-primary float-end">MT</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="#" class="text-white-50">Perawatan</a></li>
                 <li><a href="#" class="text-white-50">Jadwal</a></li>
                 <li><a href="#" class="text-white-50">Riwayat</a></li>

             </ul>
         </li>


         {{-- FEEDBACK --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-chat-smile-2-line text-white"></i>
                 <span>Feedback</span>
                 <span class="badge bg-light text-primary float-end">User</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="#" class="text-white-50">Semua Feedback</a></li>
                 <li><a href="#" class="text-white-50">Ditinjau</a></li>
                 <li><a href="#" class="text-white-50">Selesai</a></li>

             </ul>
         </li>


         {{-- LAPORAN --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-file-chart-line text-white"></i>
                 <span>Laporan</span>
                 <span class="badge bg-light text-primary float-end">Report</span>
             </a>

             <ul class="sub-menu">

                 <li><a href="#" class="text-white-50">Perjalanan</a></li>
                 <li><a href="#" class="text-white-50">Penumpang</a></li>
                 <li><a href="#" class="text-white-50">Tiket</a></li>

                 <li><a href="#" class="text-white-50">Insiden</a></li>
                 <li><a href="#" class="text-white-50">Performa Rute</a>
                 </li>
                 <li><a href="#" class="text-white-50">Maintenance</a></li>
                 <li><a href="#" class="text-white-50">Feedback</a></li>

                 <li><a href="#" class="text-white-50">KPI
                         Dashboard</a></li>

             </ul>
         </li>


         {{-- PENGATURAN --}}
         <li>
             <a href="javascript:void(0);" class="has-arrow waves-effect text-white">
                 <i class="ri-settings-3-line text-white"></i>
                 <span>Pengaturan</span>
                 <span class="badge bg-light text-primary float-end">Admin</span>
             </a>

             <ul class="sub-menu">
                 <li><a href="{{ route('admin.users.index') }}" class="text-white-50">User</a></li>
                 <li><a href="{{ route('admin.roles.index') }}" class="text-white-50">Role</a></li>
             </ul>
         </li>

     </ul>
 </div>
