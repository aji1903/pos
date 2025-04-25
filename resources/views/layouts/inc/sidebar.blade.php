 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link collapsed" href="/dashboard">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li><!-- End Dashboard Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-menu-button-wide"></i><span>Administrator</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="/categories">
                         <i class="bi bi-circle"></i><span>Category</span>
                     </a>
                 </li>
                 <li>
                     <a href="/user">
                         <i class="bi bi-circle"></i><span>User</span>
                     </a>
                 </li>
                 <li>
                     <a href="/product">
                         <i class="bi bi-circle"></i><span>Produk</span>
                     </a>
                 </li>
                 <li>
                     <a href="/levels">
                         <i class="bi bi-circle"></i><span>Level</span>
                     </a>
                 </li>

             </ul>
         </li><!-- End Components Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-journal-text"></i><span>Kasir</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 {{--  <li>
                     <a href="{{ route('pos.create') }}">
                         <i class="bi bi-circle"></i><span>Penjualan</span>
                     </a>
                 </li>  --}}
                 <li>
                     <a href="/sale" target='_blank'>
                         <i class="bi bi-circle"></i><span>Sale</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('stock') }}">
                         <i class="bi bi-circle"></i><span>Stock</span>
                     </a>
                 </li>

             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-layout-text-window-reverse"></i><span>Pimpinan</span><i
                     class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                 <li>
                     <a href="{{ route('pos.index') }}">
                         <i class="bi bi-circle"></i><span>Report Sale</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('report.daily') }}">
                         <i class="bi bi-circle"></i><span>Report Harian</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('report.monthly') }}">
                         <i class="bi bi-circle"></i><span>Report Bulanan</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('report.weekly') }}">
                         <i class="bi bi-circle"></i><span>Report Mingguan</span>
                     </a>
                 </li>

             </ul>
         </li><!-- E



         <li class="nav-heading">Pages</li>

         <li class="nav-item">
             <a class="nav-link collapsed" href="users-profile.html">
                 <i class="bi bi-person"></i>
                 <span>Profile</span>
             </a>
         </li><!-- End Profile Page Nav -->



     </ul>

 </aside><!-- End Sidebar-->
