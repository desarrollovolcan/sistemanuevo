<?php
include_once "../../assest/config/validarUsuarioExpo.php";

//LLAMADA ARCHIVOS NECESARIOS PARA LAS OPERACIONES

//INICIALIZAR CONTROLADOR

//INCIALIZAR VARIBALES A OCUPAR PARA LA FUNCIONALIDAD


//INICIALIZAR ARREGLOS


//DEFINIR ARREGLOS CON LOS DATOS OBTENIDOS DE LAS FUNCIONES DE LOS CONTROLADORES



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <title>INICIO</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="">
    <meta name="author" content="">
    <!- LLAMADA DE LOS ARCHIVOS NECESARIOS PARA DISEÑO Y FUNCIONES BASE DE LA VISTA -!>
        <?php include_once "../../assest/config/urlHead.php"; ?>
        <!- FUNCIONES BASES -!>
            <script type="text/javascript">
                //REDIRECCIONAR A LA PAGINA SELECIONADA
                function irPagina(url) {
                    location.href = "" + url;
                }
                //FUNCION PARA OBTENER HORA Y FECHA
              
            </script>

</head>
<body class="hold-transition light-skin fixed sidebar-mini theme-primary" >
    <div class="wrapper">
        <?php include_once "../../assest/config/menuExpo.php"; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="page-title">Inicio</h3>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>                                      
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <?php include_once "../../assest/config/verIndicadorEconomico.php"; ?>
                    </div>
                </div>
                <section class="content">
                    <?php $TOTALNOTIDASH = $ARRAYNOTIFICACIONESCABECERA ? count($ARRAYNOTIFICACIONESCABECERA) : 0; ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert-summary mb-3">
                                <strong><?php echo $TOTALNOTIDASH; ?> notificaciones activas</strong> filtradas por el usuario, empresa y planta actuales.
                                <span class="d-block">Visualiza prioridad, destinatario y vigencia directamente en el tablero.</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-velzon table-velzon">
                                <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="card-subtitle mb-1 text-muted">Centro de alertas</p>
                                        <h4 class="card-title mb-0">Notificaciones según sesión</h4>
                                    </div>
                                    <a href="registroNotificacion.php" class="btn btn-primary btn-sm">Crear / Gestionar</a>
                                </div>
                                <div class="card-body">
                                    <?php if($TOTALNOTIDASH>0){ ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Notificación</th>
                                                        <th>Dirigida a</th>
                                                        <th>Prioridad</th>
                                                        <th>Vigencia</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ARRAYNOTIFICACIONESCABECERA as $noti) : ?>
                                                        <?php
                                                            $prioridadTexto = $noti['PRIORIDAD']==1 ? 'Alta' : ($noti['PRIORIDAD']==3 ? 'Baja' : 'Media');
                                                            $prioridadClase = $noti['PRIORIDAD']==1 ? 'badge-soft-danger' : ($noti['PRIORIDAD']==3 ? 'badge-soft-success' : 'badge-soft-warning');
                                                            $destino = ucfirst($noti['DESTINO_TIPO']).' #'.$noti['DESTINO_ID'];
                                                            $vigencia = $noti['FECHA_INICIO'];
                                                            if($noti['FECHA_FIN']){ $vigencia .= ' - '.$noti['FECHA_FIN']; }
                                                            $estado = $noti['ESTADO_REGISTRO']==1 ? 'Activa' : 'Inactiva';
                                                            $estadoClase = $noti['ESTADO_REGISTRO']==1 ? 'badge-soft-success' : 'badge-soft-danger';
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $noti['MENSAJE']; ?></td>
                                                            <td><span class="badge-destino text-uppercase"><?php echo $destino; ?></span></td>
                                                            <td><span class="badge <?php echo $prioridadClase; ?>"><?php echo $prioridadTexto; ?></span></td>
                                                            <td><?php echo $vigencia; ?></td>
                                                            <td><span class="badge <?php echo $estadoClase; ?>"><?php echo $estado; ?></span></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center text-muted py-4">
                                            No hay notificaciones asignadas al usuario, empresa o planta activos.
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!- LLAMADA ARCHIVO DEL DISEÑO DEL FOOTER Y MENU USUARIO -!>
        <?php include_once "../../assest/config/footer.php"; ?>
        <?php include_once "../../assest//config/menuExtraExpo.php"; ?>
    </div>
    <?php include_once "../../assest/config/urlBase.php"; ?>
</body>

</html>