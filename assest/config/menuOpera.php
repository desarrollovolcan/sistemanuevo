<header class="main-header shared-app-header">
  <div class="d-flex align-items-center logo-box pl-20">
    <a href="#" class="waves-effect waves-light nav-link rounded d-none d-md-inline-block push-btn" data-toggle="push-menu" role="button">
      <img src="../../api/cryptioadmin10/html/images/svg-icon/collapse.svg" class="img-fluid svg-icon" alt="">
    </a>
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- logo-->
      <div class="logo-lg">
        <span class="light-logo"><img src="../../assest/img/logo.png" alt="logo"></span>
        <span class="dark-logo"><img src="../../assest/img/logo.png" alt="logo"></span>
      </div>
    </a>
  </div>
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top pl-10 shared-app-navbar">
    <!-- Sidebar toggle button-->
    <div class="app-menu">
      <ul class="header-megamenu nav">
        <li class="btn-group nav-item d-md-none">
          <a href="#" class="waves-effect waves-light nav-link rounded push-btn" data-toggle="push-menu" role="button">
            <img src="../../api/cryptioadmin10/html/images/svg-icon/collapse.svg" class="img-fluid svg-icon" alt="">
          </a>
        </li>
        <li class="btn-group nav-item">
          <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded full-screen" title="Full Screen">
            <img src="../../api/cryptioadmin10/html/images/svg-icon/fullscreen.svg" class="img-fluid svg-icon" alt="">
          </a>
        </li>
        <li class="btn-group nav-item">
          <div class="search-bx ml-10">
            <div class="session-meta">
              <div class="meta-block">
                <span class="meta-label">Empresa</span>
                <span class="meta-value">
                  <?php
                  if (isset($_SESSION["NOMBRE_USUARIO"])) {
                    $ARRAYEMPRESAS = $EMPRESA_ADO->verEmpresa($EMPRESAS);
                    if ($ARRAYEMPRESAS) {
                      echo $ARRAYEMPRESAS[0]['NOMBRE_EMPRESA'];
                    } else {
                      echo "<script type='text/javascript'> location.href ='iniciarSessionSeleccion.php';</script>";
                    }
                  } else {
                    echo "<script type='text/javascript'> location.href ='iniciarSession.php';</script>";
                  }
                  ?>
                </span>
              </div>
              <div class="meta-block">
                <span class="meta-label">Planta</span>
                <span class="meta-value">
                  <?php
                  if (isset($_SESSION["NOMBRE_USUARIO"])) {
                    $ARRAYPLANTAS = $PLANTA_ADO->verPlanta($PLANTAS);
                    if ($ARRAYPLANTAS) {
                      echo $ARRAYPLANTAS[0]['NOMBRE_PLANTA'];
                    } else {
                      echo "<script type='text/javascript'> location.href ='iniciarSessionSeleccion.php';</script>";
                    }
                  } else {
                    echo "<script type='text/javascript'> location.href ='iniciarSession.php';</script>";
                  }
                  ?>
                </span>
              </div>
              <div class="meta-block">
                <span class="meta-label">Temporada</span>
                <span class="meta-value">
                  <?php
                  if (isset($_SESSION["NOMBRE_USUARIO"])) {
                    $ARRAYTEMPORADAS = $TEMPORADA_ADO->verTemporada($TEMPORADAS);
                    if ($ARRAYTEMPORADAS) {
                      echo $ARRAYTEMPORADAS[0]['NOMBRE_TEMPORADA'];
                    } else {
                      echo "<script type='text/javascript'> location.href ='iniciarSession.php';</script>";
                    }
                  } else {
                    echo "<script type='text/javascript'> location.href ='iniciarSession.php';</script>";
                  }
                  ?>
                </span>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="navbar-custom-menu r-side">
      <ul class="nav navbar-nav">
        <!-- User Account-->
        <li class="dropdown user user-menu">
          <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="Mi Cuenta">
            <img src="../../api/cryptioadmin10/html/images/svg-icon/user.svg" class="rounded svg-icon" alt="" />
            <span class="user-toggle-label">Mi Cuenta</span>
          </a>
          <ul class="dropdown-menu animated flipInX">
            <!-- User image -->
            <li class="user-header bg-img" style="background-image: url(../../api/cryptioadmin10/html/images/user-info.jpg)" data-overlay="3">
              <div class="flexbox align-self-center">
                <img src="../../api/cryptioadmin10/html/images/avatar/7.jpg" class="float-left rounded-circle" alt="User Image">
                <h4 class="user-name align-self-center">

                  <?php

                  if (isset($_SESSION["NOMBRE_USUARIO"])) {


                    $ARRAYNOMBRESUSUARIOSLOGIN = $USUARIO_ADO->ObtenerNombreCompleto($IDUSUARIOS);
                    $NOMBRESUSUARIOSLOGIN = $ARRAYNOMBRESUSUARIOSLOGIN[0]["NOMBRE_COMPLETO"];
                  }
                  ?>
                  <span> <?php echo $NOMBRESUSUARIOSLOGIN; ?> </span>
                  <br>
                  <small>
                    <?php
                    if (isset($_SESSION["NOMBRE_USUARIO"])) {
                      $ARRAYTUSUARIO = $TUSUARIO_ADO->verTusuario($_SESSION["TIPO_USUARIO"]);

                      if ($ARRAYTUSUARIO) {
                        echo $ARRAYTUSUARIO[0]['NOMBRE_TUSUARIO'];
                      }
                    } else {
                      session_destroy();
                      echo "<script type='text/javascript'> location.href ='iniciarSession.php';</script>";
                    }
                    ?>
                  </small>
                </h4>
              </div>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <a class="dropdown-item" href="verUsuario.php"><i class="ion ion-person"></i> Mi Perfil</a>              
              <a class="dropdown-item" href="editarUsuario.php"><i class="ion ion-email-unread"></i> Editar Perfil</a>
              <a class="dropdown-item" href="editarUsuarioClave.php"><i class="ion ion-settings"></i> Cambiar Contrasena</a>              
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="verUsuarioActividad.php"><i class="ion ion-bag"></i> Mi Actividad</a>              
              <div class="dropdown-divider"></div>
              <div class="dropdown-header text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: .04em;">
                Cambiar de módulo
              </div>
              <a class="dropdown-item" href="../../fruta/"><i class="ti-angle-right"></i> Fruta</a>
              <a class="dropdown-item" href="../../exportadora/"><i class="ti-angle-right"></i> Exportador</a>
              <a class="dropdown-item" href="../../estadistica/"><i class="ti-angle-right"></i> Estadísticas</a>
              <a class="dropdown-item" href="../../material/"><i class="ti-angle-right"></i> Materiales</a>
              <div class="dropdown-divider"></div>

              <div class="p-10">
                <center>
                  <form method="post">
                    <button type="submit" class="btn btn-rounded btn-danger " name="CERRARS" value="CERRARS">
                      <i class="ion-log-out"></i>
                      Cerrar Sesion
                    </button>
                  </form>
                </center>
              </div>
            </li>
          </ul>
        </li>
        <?php //include_once "../../config/menuOperaExtra.php"; 
        ?>
        <!-- Control Sidebar Toggle Button -->
          <!--      
        <li>
          <a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect waves-light">
            <img src="../../api/cryptioadmin10/html/images/svg-icon/settings.svg" class="img-fluid svg-icon" alt="">
          </a>
        </li>-->        
      </ul>
      
    </div>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">
    <!-- sidebar menu-->
    <ul class="sidebar-menu" data-widget="tree">
      <li>
        <a href="index.php">
          <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/dashboard.svg" class="svg-icon" alt="">
          <span>Inicio</span>
        </a>
      </li>      
      <?php if($PESTADISTICA=="1"){ ?>
        <li class="header">Modulo</li>  
        <?php if($PESTAPRODUCTOR=="1"){ ?>
          <li class="treeview">
            <a href="#">
              <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/layout.svg" class="svg-icon" alt="">
              <span>Informe</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="listarProductorRecepcionmp.php">Recepción MP</i></a></li>
              <li><a href="listarRecepcionmpDetalladoProductor.php">Detallado Recepción MP</i></a></li>
              <li><a href="listarProductorRecepcionind.php">Recepción IND</i></a></li>
              <li><a href="listarRecepcionindDetalladoProductor.php">Detallado Recepción IND</i></a></li>
              <li><a href="listarProductorProceso.php">Proceso</i></a></li>
            </ul>
          </li>   
        <?php  } ?>
        <?php if($PESTAINFORME=="1"){ ?>
          <li class="treeview">
            <a href="#">
              <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/layout.svg" class="svg-icon" alt="">
              <span>Informe</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="listarProceso.php">Proceso</i></a></li>
              <li><a href="listarReembalajeEx.php">Reembalaje</i></a></li>
            </ul>
          </li>              
          <li class="treeview">
            <a href="#">
              <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/reports.svg" class="svg-icon" alt="">
              <span>Detallado</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="listarRecepcionmpDetallado.php">Detallado Recepcion MP</i></a></li>
              <li><a href="listarRecepcionindDetallado.php">Detallado Recepcion IND</i></a></li>
              <li><a href="listarRecepcionptDetallado.php">Detallado Recepcion PT</i></a></li>              
              <li><a href="listarDespachompDetallado.php">Detallado Despacho MP</i></a></li>
              <li><a href="listarDespachoindDetallado.php">Detallado Despacho IND</i></a></li>
              <li><a href="listarDespachoptDetallado.php">Detallado Despacho PT</i></a></li>
              <li><a href="listarDespachoexDetallado.php">Detallado Despacho Expo</i></a></li>
            </ul>
          </li>   
        <?php  } ?>
        <?php if($PESTAEXISTENCIA=="1"){ ?>
          <li class="treeview">
            <a href="#">
              <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/pages.svg" class="svg-icon" alt="">
              <span>Existencia</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview">
                <a href="#">Disponible
                  <span class="pull-left-container">
                    <i class=" fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="listarEximateriaprima.php">Materia Prima</i></a></li>
                  <li><a href="listarExiexportacion.php">Producto Terminado</i></a></li>
                  <li><a href="listarExiindustrial.php">Producto Industrial</i></a></li>
                </ul>
              </li>
            </ul>
          </li>   
        <?php  } ?>


        <?php if($PESTAPRODUCTOR=="1"){ ?>
          <li>
            <a href="listaDocumento.php">
              <img src="../../api/cryptioadmin10/html/images/svg-icon/sidebar-menu/pages.svg" class="svg-icon" alt="">
              <span>Mis Documentos</span>
            </a>
          </li>   
        <?php  } ?>


      <?php  } ?>
    </ul>
  </section>
</aside>