
<?php
$url = $_SERVER["REQUEST_URI"];
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-1 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?= ($url == '/siim/index.php')?'active':'' ?>" aria-current="page" href="/siim/index.php">
            <i class="bi bi-file-ruled-fill"></i> Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($url == '/siim/reporte.php')?'active':'' ?>" aria-current="page" href="/siim/reporte.php">
            <i class="bi bi-bar-chart-line-fill"></i> Obras e infraestructura
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($url == '/siim/reporte_municipal.php')?'active':'' ?>" aria-current="page" href="/siim/reporte_municipal.php">
            <i class="bi bi-pin-map-fill"></i> Reporte Municipal
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($url == '/siim/agregar.php')?'active':'' ?>" aria-current="page" href="/siim/agregar.php">
            <i class="bi bi-clipboard2-plus-fill"></i> Agregar acción
            </a>
          </li>
      
     
        </ul>
       
      </div>
    </nav>