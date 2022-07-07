<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  
$miUpp = $_SESSION['dependencia'];
$libretaActual = $_GET['libreta'];

$denominacionUPP = $cnx->EncuentraUpp($miUpp);
while ($row=mysqli_fetch_object($denominacionUPP)){
  $nombreMiUpp=$row->denominacion;
}

$consultaLibreta = $cnx->abreLibreta($libretaActual);
while ($row=mysqli_fetch_object($consultaLibreta)){
  $libretaAutor=$row->autor;
  $libretaNombre=$row->nombre;
  $libretaDescripcion=$row->descripcion;
  $libretaFechaCreacion=$row->fechaRegistro;
}

?>

<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rodrigo Torres">
    <title>Acuerdos DGEM</title>

    <!-- Bootstrap core CSS -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Favicons -->
    <meta name="theme-color" content="#fff">
    <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Acuerdos DGEM</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="col-8"><p class="saludo">¡Hola <?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>! -  <?= $nombreMiUpp ?>.</p></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap btn">
                <a href="../src/logout.php">
                    <div class="nav-link px-3">Cerrar sesión</div>
                </a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                                <span data-feather="home"></span>
                                <i class="bi bi-inbox-fill"></i> Bandeja de entrada
                            </a>
                        </li>
                        <hr>
                        <div class="card text-dark bg-light mb-3" style="max-width: 92%; margin-left:4%;">
                          <div class="card-header">Mis libretas</div>
                          <div class="card-body">
                          <?php
                        
                        $lstLibretas = $cnx->seleccionaLibretas($miUpp);
                        while ($row=mysqli_fetch_object($lstLibretas)){
                          $idLibreta=$row->id;
                          $nombreLibreta=$row->nombre;
                          echo "<li class='nav-item'>
                          <a class='nav-link' aria-current='page' href='libreta.php?libreta=".$idLibreta."'>
                              <span data-feather='home'></span>
                              <i class='bi bi-inbox-fill'></i> ".$nombreLibreta." 
                          </a>
                      </li>";
                        }

                        ?>
                          </div>
                        </div>
                        
                    </ul>
                </div>
                <div class="text-center mt-3">
                <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#nuevaLibreta' data-bs-whatever='libreta'> 
                <i class='bi bi-plus-square-fill'></i> Nueva libreta</button>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    

                    <?php
        if($miUpp == 3){
          echo "<button style='margin:0 0 0 10px' type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#nuevoAcuerdo' data-bs-whatever='acuerdo'> <i class='bi bi-plus-square-fill'></i> Agregar nuevo acuerdo</button>";
        }
        ?>

                </div>
                
                <!-- INICIA LIBRETA -->
                <div class="d-flex justify-content-between">
                <div class="mb-3"><span class="badge bg-success" style="font-size: 1.5em;"><b>Libreta: </b><?=$libretaNombre?></span> | <b>Autor:</b><?=$libretaAutor?></div>
                <div><a href="borrarLibreta.php?libreta=<?=$libretaActual?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> eliminar libreta</a></div>
                </div>

                <div class='row'>
                    <!-- //NUEVOS ACUERDOS -->
                    <div class='col-4'>
                        <div class='text-center text-center bg-secondary text-light'
                            style='border-radius: 15px 15px 0 0; padding:5px'>
                            <h4>Nuevos <i class="bi bi-chat-left-quote"></i></h4>
                        </div>
                        <?php 
            

            $LitarAcuerdosLibreta = $cnx->listarTodosAcuerdosLibreta($libretaActual);
            while ($row=mysqli_fetch_object($LitarAcuerdosLibreta)){
            $idAcuerdo=$row->idAcuerdo;
            $uppResponsable=$row->uppResponsable;

            $nombreUppResponsable = $cnx->EncuentraUpp($uppResponsable);
            while ($row2=mysqli_fetch_object($nombreUppResponsable)){
              $denominacionUppResponsable=$row2->denominacion;
              $siglasUppResponsable=$row2->siglas;
            }

            $acuerdo=$row->acuerdo;
            $fechaRegistro=$row->fechaRegistro;
            $fechaTermino=$row->fechaTermino;
            $comentario=$row->comentario;
            echo "
            <div class='card mb-2'>
            <div class='card-body'>
            <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsable." </b>| ".$acuerdo."</p>
            <p style='padding:2px 5px' class='d-flex justify-content-between'>
            <a href='acuerdoBorrar.php?idAcuerdo=".$idAcuerdo."&libreta=".$libretaActual."' class='btn btn-sm btn-danger' data-bs-toggle='tooltip' data-bs-placement='top' title='Elminar acuerdo'><i class='bi bi-trash'></i></a>

            <button style='margin:0 0 0 1px' type='button' class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#agregarColaborador' data-bs-whatever='".$idAcuerdo."'><i class='bi bi-person-plus-fill'></i></button>
            
            Fecha registro:<b> <i class='bi bi-calendar-event'></i>  ".$fechaRegistro."</b>
            <a href='acuerdoProceso.php?idAcuerdo=".$idAcuerdo."&libreta=".$libretaActual."' class='btn btn-sm btn-info' data-bs-toggle='tooltip' data-bs-placement='top' title='Enviar a proceso' ><i class='bi bi-gear'></i></a>
            <a href='acuerdoTerminado.php?idAcuerdo=".$idAcuerdo."&libreta=".$libretaActual."' class='btn btn-sm btn-success' data-bs-toggle='tooltip' data-bs-placement='top' title='Terminar acuerdo'><i class='bi bi-check-square-fill'></i></a></p>
            <div class='card-footer'>";
              $colaboradores=$cnx->seleccionaUppColaboradoras($idAcuerdo);
              while ($row3=mysqli_fetch_object($colaboradores)){
                $uppColaboradora=$row3->uppColaboradora;
                $encuentraNombreUppColaboradora = $cnx->EncuentraUpp($uppColaboradora);
                while ($row4=mysqli_fetch_object($encuentraNombreUppColaboradora))
                  {
                  $siglasUppColaboradora=$row4->siglas;
                  echo "<div style='display:inline-block'><span class='badge rounded-pill bg-info text-light m-1'><a href='eliminarColaborador.php?idAcuerdo=".$idAcuerdo."&uppColaboradora=".$uppColaboradora."&libreta=".$libretaActual."' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar colaborador'><i class='bi bi-x-circle-fill'></i></a> ".$siglasUppColaboradora."</span></div>";
                  }
              }
            echo "</div>
            </div>
            </div>";
            }
            ?>

                        <!-- MUESTRA COLABORACIONES ACUERDOS NUEVOS -->
                        <?php 

            if($miUpp != 3)
            {
              echo "<hr><h4>Acuerdos en colaboración</h4>";
              $acuerdosColaborador = $cnx->encuentraColaboracion($miUpp);
              while ($row=mysqli_fetch_object($acuerdosColaborador))
              {
                $idAcuerdoColaboracion=$row->idAcuerdo;

                $muestraColaboracion = $cnx->muestraColaboracion($idAcuerdoColaboracion);
                while ($row=mysqli_fetch_object($muestraColaboracion))
                {
                  $uppResponsableColaboracion=$row->uppResponsable;
                  $fechaRegistroColaboracion=$row->fechaRegistro;
                  $nombreUppResponsableColaboracion = $cnx->EncuentraUpp($uppResponsableColaboracion);
                    while ($row3=mysqli_fetch_object($nombreUppResponsableColaboracion)){
                      $siglasUppResponsableColaboracion=$row3->siglas;
                    }
                  $acuerdoColaboracion=$row->acuerdo;
                  echo "<div class='card mb-2'>
                  <div class='card-body'>
                  <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsableColaboracion." </b>| ".$acuerdoColaboracion."</p>
                  Fecha registro:<b> <i class='bi bi-calendar-event'></i>  ".$fechaRegistroColaboracion."</b>
                  <div class='card-footer'></div>
                  </div></div>";
                }

                
                }

            }else{
            
            }
            ?>
                    </div>




                    <!-- //PROCESO ACUERDOS -->
                    <div class='col-4'>
                        <div class='text-center text-center bg-info text-light'
                            style='border-radius: 15px 15px 0 0; padding:5px'>
                            <h4>Proceso<i class='bi bi-gear'></i></h4>
                        </div>
                        <?php
            
            $AcuerdoProcesoLibreta = $cnx->listarTodosAcuerdosProcesoUPPLibreta($libretaActual);
            while ($row=mysqli_fetch_object($AcuerdoProcesoLibreta)){
            $idAcuerdo=$row->idAcuerdo;
            $uppResponsable=$row->uppResponsable;
            $nombreUppResponsable = $cnx->EncuentraUpp($uppResponsable);
            while ($row2=mysqli_fetch_object($nombreUppResponsable)){
              $denominacionUppResponsable=$row2->denominacion;
              $siglasUppResponsable=$row2->siglas;
            }
            $acuerdo=$row->acuerdo;
            $fechaRegistro=$row->fechaRegistro;
            $fechaTermino=$row->fechaTermino;
            echo "
            <div class='card mb-2'>
            <div class='card-body'>
            <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsable." </b>| ".$acuerdo."</p>
            <p style='padding:1px 0 0 5px; border-bottom: 1px gray dashed'>Fecha registro: <b> <i class='bi bi-calendar-event'></i>  ".$fechaRegistro."</b></p>
            <p style='padding:5px'>";
              $comentariosGenerales=$cnx->muestraComentarios($idAcuerdo);
              while ($row5=mysqli_fetch_object($comentariosGenerales)){
                $comentarioUpp=$row5->comentario;
                $fechaComentario=$row5->bitacora;
                $uppComento=$row5->upp;
                $encuentraNombreUppComento = $cnx->EncuentraUpp($uppComento);
                while ($row4=mysqli_fetch_object($encuentraNombreUppComento))
                  {
                  $siglasUppComento=$row4->siglas;
                  echo "<b>".$siglasUppComento." comentó: </b>";
                  }

                echo " - ".$comentarioUpp."<br>";
              }
            echo "</p>
            <p style='padding:3px; border-top: 1px gray dashed'>
            <button style='margin:0 0 0 10px' type='button' class='btn btn-sm btn-secondary' data-bs-toggle='modal' data-bs-target='#comentarioNuevo' data-bs-whatever='".$idAcuerdo."'><i class='bi bi-chat-square-quote'></i></button>
            <a href='acuerdoTerminado.php?idAcuerdo=".$idAcuerdo."&libreta=".$libretaActual."' class='btn btn-sm btn-success' data-bs-toggle='tooltip' data-bs-placement='top' title='Terminar acuerdo' ><i class='bi bi-check-square-fill'></i></a></p>
            <div class='card-footer'>";
              $colaboradores=$cnx->seleccionaUppColaboradoras($idAcuerdo);
              while ($row3=mysqli_fetch_object($colaboradores)){
                $uppColaboradora=$row3->uppColaboradora;
                $encuentraNombreUppColaboradora = $cnx->EncuentraUpp($uppColaboradora);
                while ($row4=mysqli_fetch_object($encuentraNombreUppColaboradora))
                  {
                  $siglasUppColaboradora=$row4->siglas;
                  echo "<div style='display:inline-block'><span class='badge rounded-pill bg-info text-light m-1'>".$siglasUppColaboradora."</span></div>";
                  }
              }
            echo "</div>
            </div>
            </div>";
            }
            ?>

                        <!-- MUESTRA COLABORACIONES ACUERDOS EN PROCESO -->
                        <?php 

            if($miUpp != 3)
            {
              echo "<hr><h4>Acuerdos en colaboración</h4>";
              $acuerdosColaboradorProceso = $cnx->encuentraColaboracionProceso($miUpp);
              while ($row=mysqli_fetch_object($acuerdosColaboradorProceso))
              {
                $idAcuerdoColaboracionProceso=$row->idAcuerdo;

                $muestraColaboracionProceso = $cnx->muestraColaboracion($idAcuerdoColaboracionProceso);
                while ($row=mysqli_fetch_object($muestraColaboracionProceso))
                {
                  $uppResponsableColaboracion=$row->uppResponsable;
                  $fechaRegistroColaboracion=$row->fechaRegistro;
                  $nombreUppResponsableColaboracion = $cnx->EncuentraUpp($uppResponsableColaboracion);
                    while ($row3=mysqli_fetch_object($nombreUppResponsableColaboracion)){
                      $siglasUppResponsableColaboracion=$row3->siglas;
                    }
                  $acuerdoColaboracion=$row->acuerdo;
                  echo "<div class='card mb-2'>
                  <div class='card-body'>
                  <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsableColaboracion." </b>| ".$acuerdoColaboracion."</p>
                  <p style='padding:3px; border-bottom: 1px gray dashed'>Fecha registro:<b> <i class='bi bi-calendar-event'></i>  ".$fechaRegistroColaboracion."</b></p>
                  <p style='padding:5px'>";
              $comentariosGenerales=$cnx->muestraComentarios($idAcuerdoColaboracionProceso);
              while ($row5=mysqli_fetch_object($comentariosGenerales)){
                $comentarioUpp=$row5->comentario;
                $fechaComentario=$row5->bitacora;
                $uppComento=$row5->upp;
                $encuentraNombreUppComento = $cnx->EncuentraUpp($uppComento);
                while ($row4=mysqli_fetch_object($encuentraNombreUppComento))
                  {
                  $siglasUppComento=$row4->siglas;
                  echo "<b>".$siglasUppComento." comentó: </b>";
                  }

                echo " - ".$comentarioUpp."<br>";
              }
            echo "</p>
                  <div class='card-footer'>
                  <button style='margin:0 0 0 10px' type='button' class='btn btn-sm btn-secondary' data-bs-toggle='modal' data-bs-target='#comentarioNuevoColaboracion' data-bs-whatever='".$idAcuerdoColaboracionProceso."'><i class='bi bi-chat-square-quote'></i></button>
                  </div>
                  </div></div>";
                }

                
                }

            }else{
            
            }
            ?>
                    </div>


                    <!-- //ATENDIDOS ACUERDOS -->
                    <div class='col-4'>
                        <div class='text-center text-center bg-success text-light'
                            style='border-radius: 15px 15px 0 0; padding:5px'>
                            <h4>Atendidos <i class='bi bi-check-square-fill'></i></h4>
                        </div>
                        <?php

          

            $acuerdosAtendidosLibreta = $cnx->listarTodosAcuerdosAtendidosLibreta($libretaActual);
            while ($row=mysqli_fetch_object($acuerdosAtendidosLibreta)){
            $idAcuerdo=$row->idAcuerdo;
            $uppResponsable=$row->uppResponsable;
              $nombreUppResponsable = $cnx->EncuentraUpp($uppResponsable);
              
              while ($row2=mysqli_fetch_object($nombreUppResponsable)){
                $denominacionUppResponsable=$row2->denominacion;
                $siglasUppResponsable=$row2->siglas;
              }
            $acuerdo=$row->acuerdo;
            $fechaRegistro=$row->fechaRegistro;
            $fechaTermino=$row->fechaTermino;
            $comentario=$row->comentario;
            echo "
            <div class='card mb-2'>
            <div class='card-body'>
            <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsable."</b> | ".$acuerdo."</p>
            <p style='padding:3px; border-bottom: 1px gray dashed'>Fecha registro: <b><i class='bi bi-calendar-event'></i> ".$fechaRegistro."</b> | término: <b>".$fechaTermino."</b></p>";
            

            // TODO: REVISION
            $comentariosAC=$cnx->muestraComentarios($idAcuerdo);
              while ($row5=mysqli_fetch_object($comentariosAC)){
                $comentarioUpp=$row5->comentario;
                $fechaComentario=$row5->bitacora;
                $uppComento=$row5->upp;
                $encuentraNombreUppComento = $cnx->EncuentraUpp($uppComento);
                while ($row4=mysqli_fetch_object($encuentraNombreUppComento))
                  {
                  $siglasUppComento=$row4->siglas;
                  echo "<b>".$siglasUppComento." comentó: </b>";
                  }

                echo " - ".$comentarioUpp."<br>";
              }
            
            echo "
            <p style='padding:3px; border-top: 1px gray dashed'>
            <a href='acuerdoArchivar.php?idAcuerdo=".$idAcuerdo."&libreta=".$libretaActual."' class='btn btn-sm btn-warning' data-bs-toggle='tooltip' data-bs-placement='top' title='Archivar acuerdo'><i class='bi bi-inboxes-fill'></i></a></p>
            <div class='card-footer'>";
              $colaboradores=$cnx->seleccionaUppColaboradoras($idAcuerdo);
              while ($row3=mysqli_fetch_object($colaboradores)){
                $uppColaboradora=$row3->uppColaboradora;
                $encuentraNombreUppColaboradora = $cnx->EncuentraUpp($uppColaboradora);
                while ($row4=mysqli_fetch_object($encuentraNombreUppColaboradora))
                  {
                  $siglasUppColaboradora=$row4->siglas;
                  echo "<div style='display:inline-block'><span class='badge rounded-pill bg-info text-light m-1'>".$siglasUppColaboradora."</span></div>";
                  }
              }
            echo "</div>
            </div>
            </div>
            ";
            }
            ?>

                        <!-- MUESTRA COLABORACIONES ACUERDOS ATENDIDOS-->
                        <?php 

            if($miUpp != 3)
            {
              echo "<hr><h4 class='text-center'>Acuerdos en colaboración</h4>";
              $acuerdosColaboradorTerminado = $cnx->encuentraColaboracionTerminados($miUpp);
              while ($row=mysqli_fetch_object($acuerdosColaboradorTerminado))
              {
                $idAcuerdoColaboracion=$row->idAcuerdo;

                $muestraColaboracion = $cnx->muestraColaboracion($idAcuerdoColaboracion);
                while ($row=mysqli_fetch_object($muestraColaboracion))
                {
                  $uppResponsableColaboracion=$row->uppResponsable;
                  $fechaRegistroColaboracion=$row->fechaRegistro;
                  $nombreUppResponsableColaboracion = $cnx->EncuentraUpp($uppResponsableColaboracion);
                    while ($row3=mysqli_fetch_object($nombreUppResponsableColaboracion)){
                      $siglasUppResponsableColaboracion=$row3->siglas;
                    }
                  $acuerdoColaboracion=$row->acuerdo;
                  echo "<div class='card mb-2'>
                  <div class='card-body'>
                  <p style='padding:3px; border-bottom: 1px gray dashed'><b style='color: #900C3F'>".$siglasUppResponsableColaboracion." </b>| ".$acuerdoColaboracion."</p>
                  Fecha registro:<b> <i class='bi bi-calendar-event'></i>  ".$fechaRegistroColaboracion."</b>
                  <div class='card-footer'></div>
                  </div></div>";
                }

                
                }

            }else{
            
            }
            ?>
                    </div>

                    <!-- Agregar ACUERDO  Modal -->
                    <div class="modal fade" id="nuevoAcuerdo" tabindex="-1" aria-labelledby="faseModallLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="faseModallLabel">a</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="guardarAcuerdoNuevo.php" method="post">
                                    <input type="hidden" name="libreta" id="libreta" value="<?=$libretaActual?>" />
                                      <input type="hidden" name="autor" id="autor" value="<?=$_SESSION['name']?>" />

                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Descripción del
                                                acuerdo:</label>
                                            <textarea class="form-control" id="acuerdo" name="acuerdo"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Dependencia
                                                responsable:</label>
                                            <select name='uppResponsable' id='uppResponsable' class='form-select'>
                                                <?php
                        $lstUpps = $cnx->EnlistarUPP();
                        while ($row=mysqli_fetch_object($lstUpps)){
                          $numeroUpp=$row->upp;
                          $denominacionUpp=$row->denominacion;
                          echo "<option value='".$numeroUpp."'>".$denominacionUpp."</option>";
                        }
                        ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">cancelar</button>
                                    <button type="submit" class="btn btn-primary ">Agregar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Agregar COMENTARIO  Modal -->
                    <div class="modal fade" id="comentarioNuevo" tabindex="-1" aria-labelledby="faseModallLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="faseModallLabel">a</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="guardarComentarioNuevo.php" method="post">
                                        <input type="hidden" name='uppComento' id='uppComento' value='<?= $miUpp ?>'>
                                        <input type="hidden" name='idAcuerdo' id='idAcuerdo' value='<?= $idAcuerdo ?>'>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Comentario:</label>
                                            <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">cancelar</button>
                                    <button type="submit" class="btn btn-primary ">Agregar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Agregar COMENTARIO  Modal -->
                    <div class="modal fade" id="comentarioNuevoColaboracion" tabindex="-1"
                        aria-labelledby="faseModallLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="faseModallLabel">a</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="guardarComentarioNuevo.php" method="post">
                                        <input type="hidden" name='uppComento' id='uppComento' value='<?= $miUpp ?>'>
                                        <input type="hidden" name='idAcuerdo' id='idAcuerdo' value='<?= $idAcuerdo ?>'>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Comentario:</label>
                                            <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">cancelar</button>
                                    <button type="submit" class="btn btn-primary ">Agregar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Agregar COLABORADOR  Modal -->
                    <div class="modal fade" id="agregarColaborador" tabindex="-1" aria-labelledby="faseModallLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="faseModallLabel">a</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="agregarColaborador.php" method="post">
                                    <input type="hidden" name="libreta" id="libreta" value="<?=$libretaActual?>" />
                                      <input type="hidden" name="autor" id="autor" value="<?=$_SESSION['name']?>" />
                                        <input type="hidden" name='idAcuerdo' id='idAcuerdo' value='<?= $idAcuerdo ?>'>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Selecciona una upp
                                                colaboradora</label>
                                            <select name='uppColaboradora' id='uppColaboradora' class='form-select'>
                                                <?php
                        $lstUpps = $cnx->EnlistarUPP();
                        while ($row=mysqli_fetch_object($lstUpps)){
                          $numeroUpp=$row->upp;
                          $denominacionUpp=$row->denominacion;
                          echo "<option value='".$numeroUpp."'>".$denominacionUpp."</option>";
                        }
                        ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">cancelar</button>
                                    <button type="submit" class="btn btn-primary ">Agregar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Agregar COMENTARIO  Modal -->
                    <div class="modal fade" id="nuevaLibreta" tabindex="-1" aria-labelledby="faseModallLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="faseModallLabel">a</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="crearLibreta.php" method="post">
                                        <input type="hidden" name='uppLibreta' id='uppLibreta' value='<?= $miUpp ?>'>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Nombre libreta</label>
                                            <input class="form-control" id="nombreLibreta" name="nombreLibreta" required />
                                        </div>

                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Descripción</label>
                                            <input class="form-control" id="descripcionLibreta" name="descripcionLibreta" />
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">cancelar</button>
                                    <button type="submit" class="btn btn-primary ">Crear libreta</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>






            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script src="../assets/js/script.js"></script>
    <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    var nuevoAcuerdo = document.getElementById('nuevoAcuerdo')
    nuevoAcuerdo.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
        var modalTitle = nuevoAcuerdo.querySelector('.modal-title')
        var modalBodyInput = nuevoAcuerdo.querySelector('.modal-body #idFase')
        modalTitle.textContent = 'Agregar nuevo ' + recipient
        modalBodyInput.value = recipient
    })

    var comentarioNuevo = document.getElementById('comentarioNuevo')
    comentarioNuevo.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
        var modalTitle = comentarioNuevo.querySelector('.modal-title')
        var modalBodyInput = comentarioNuevo.querySelector('.modal-body #idAcuerdo')
        modalTitle.textContent = 'Agregar nuevo comentario al acuerdo ' + recipient
        modalBodyInput.value = recipient
    })

    var comentarioNuevoColaboracion = document.getElementById('comentarioNuevoColaboracion')
    comentarioNuevoColaboracion.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
        var modalTitle = comentarioNuevoColaboracion.querySelector('.modal-title')
        var modalBodyInput = comentarioNuevoColaboracion.querySelector('.modal-body #idAcuerdoColaboracion')
        modalTitle.textContent = 'Agregar nuevo comentario ' + recipient
        modalBodyInput.value = recipient
    })


    var agregarColaborador = document.getElementById('agregarColaborador')
    agregarColaborador.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
        var modalTitle = agregarColaborador.querySelector('.modal-title')
        var modalBodyInput = agregarColaborador.querySelector('.modal-body #idAcuerdo')
        modalTitle.textContent = 'Agregar colaborador al acuerdo ' + recipient
        modalBodyInput.value = recipient
    })

    var nuevaLibreta = document.getElementById('nuevaLibreta')
    nuevaLibreta.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
        var modalTitle = nuevaLibreta.querySelector('.modal-title')
        var modalBodyInput = nuevaLibreta.querySelector('.modal-body #idAcuerdo')
        modalTitle.textContent = 'Crear una nueva ' + recipient
        modalBodyInput.value = recipient
    })
    </script>



</body>

</html>