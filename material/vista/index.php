<?php
include_once "../../assest/config/validarUsuarioMaterial.php";



//LLAMADA ARCHIVOS NECESARIOS PARA LAS OPERACIONES
include_once "../../assest/controlador/CONSULTA_ADO.php";


//INICIALIZAR CONTROLADOR
$CONSULTA_ADO =  NEW CONSULTA_ADO;
//INCIALIZAR VARIBALES A OCUPAR PARA LA FUNCIONALIDAD
$RECEPCIONE=0;
$RECEPCIONM=0;
$DESPACHOE=0;
$DESPACHOM=0;


//INICIALIZAR ARREGLOS
$ARRAYREGISTROSABIERTOS="";


//DEFINIR ARREGLOS CON LOS DATOS OBTENIDOS DE LAS FUNCIONES DE LOS CONTROLADORES
$ARRAYREGISTROSABIERTOS=$CONSULTA_ADO->contarRegistrosAbiertosMateriales($EMPRESAS,$PLANTAS,$TEMPORADAS);
if($ARRAYREGISTROSABIERTOS){
    $RECEPCIONE=$ARRAYREGISTROSABIERTOS[0]["RECEPCIONE"];
    $RECEPCIONM=$ARRAYREGISTROSABIERTOS[0]["RECEPCIONM"];
    $DESPACHOE=$ARRAYREGISTROSABIERTOS[0]["DESPACHOE"];
    $DESPACHOM=$ARRAYREGISTROSABIERTOS[0]["DESPACHOM"];
}



include_once "../../assest/config/ValidardatosUrl.php";

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
            </script>

</head>

<body class="hold-transition light-skin fixed sidebar-mini theme-primary" >
    <div class="wrapper">
        <?php include_once "../../assest/config/menuMaterial.php"; ?>
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
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <?php include_once "../../assest/config/verIndicadorEconomico.php"; ?>
                    </div>
                </div>
                <section class="content">
                        <?php $TOTALNOTIDASH = $ARRAYNOTIFICACIONESCABECERA ? count($ARRAYNOTIFICACIONESCABECERA) : 0; ?>
                        <div class="row mb-15">
                            <div class="col-12">
                                <div class="alert-summary mb-3">
                                    <strong><?php echo $TOTALNOTIDASH; ?> notificaciones activas</strong> filtradas por el usuario, empresa y planta actuales.
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card notifications-board table-velzon">
                                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <p class="card-subtitle mb-1 text-muted">Centro de alertas</p>
                                            <h4 class="card-title mb-0">Notificaciones según sesión</h4>
                                        </div>
                                        <a href="../../exportadora/vista/registroNotificacion.php" class="btn btn-primary btn-sm">Crear / Gestionar</a>
                                    </div>
                                    <div class="card-body">
                                        <?php if($TOTALNOTIDASH>0){ ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0 table-velzon">
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
                                                                $prioridadClase = 'badge-prioridad';
                                                                $destino = ucfirst($noti['DESTINO_TIPO']).' #'.$noti['DESTINO_ID'];
                                                                $vigencia = $noti['FECHA_INICIO'];
                                                                if($noti['FECHA_FIN']){ $vigencia .= ' - '.$noti['FECHA_FIN']; }
                                                                $estado = $noti['ESTADO_REGISTRO']==1 ? 'Activa' : 'Inactiva';
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $noti['MENSAJE']; ?></td>
                                                                <td><span class="badge-destino text-uppercase"><?php echo $destino; ?></span></td>
                                                                <td><span class="badge <?php echo $prioridadClase; ?>"><?php echo $prioridadTexto; ?></span></td>
                                                                <td><?php echo $vigencia; ?></td>
                                                                <td><span class="badge badge-destino"><?php echo $estado; ?></span></td>
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
                        <div class="row">
                            <?php if($PMRABIERTO=="1"){ ?>                            
                                <?php if($PMATERIALES=="1"){ ?>            
                                    <?php if($PMMRECEPION=="1"){ ?>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 col-xs-6">                           
                                            <div class="box pull-up  ribbon-box       ">
                                                <div class="box-body ">
                                                    <div class="ribbon ribbon-warning"><span>Recepciones Materiales </span></div>  
                                                    <p class="my-2 mb-0 pt-5 ">
                                                        <div class="text-center my-2">
                                                            <div class="font-size-40"><?php echo $RECEPCIONM; ?></div>
                                                            <span>Abiertos</span>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>   
                                        </div>	                                 
                                    <?php  } ?>        
                                    <?php if($PMMDEAPCHO=="1"){ ?>                     
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 col-xs-6">                                            
                                            <div class="box pull-up  ribbon-box       ">
                                                <div class="box-body ">
                                                    <div class="ribbon ribbon-warning"><span>Despacho Materiales </span></div>  
                                                    <p class="my-2 mb-0 pt-5 ">
                                                        <div class="text-center my-2">
                                                            <div class="font-size-40"><?php echo $DESPACHOM; ?></div>
                                                            <span>Abiertos</span>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>   
                                        </div>                                    
                                    <?php  } ?>                                      
                                <?php  } ?>            
                                <?php if($PMENVASE=="1"){ ?>      
                                    <?php if($PMERECEPCION=="1"){ ?>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 col-xs-6">                                 
                                            <div class="box pull-up  ribbon-box      ">
                                                <div class="box-body ">
                                                    <div class="ribbon ribbon-warning"><span>Recepciones Envases </span></div>  
                                                    <p class="my-2 mb-0 pt-5 ">
                                                        <div class="text-center my-2">
                                                            <div class="font-size-40"><?php echo $RECEPCIONE; ?></div>
                                                            <span>Abiertos</span>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>   
                                        </div>	 	           
                                    <?php  } ?>        
                                    <?php if($PMEDESPACHO=="1"){ ?>                           
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 col-xs-6">                                     
                                            <div class="box pull-up  ribbon-box       ">
                                                <div class="box-body ">
                                                    <div class="ribbon ribbon-warning"><span>Despacho Envases </span></div>  
                                                    <p class="my-2 mb-0 pt-5 ">
                                                        <div class="text-center my-2">
                                                            <div class="font-size-40"><?php echo $DESPACHOE; ?></div>
                                                            <span>Abiertos</span>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>   
                                        </div>  	           
                                    <?php  } ?>                                   
                                <?php  } ?>   
                            <?php  } ?>      
                        </div>  
                </section>
            </div>
        </div>
        <!- LLAMADA ARCHIVO DEL DISEÑO DEL FOOTER Y MENU USUARIO -!>
            <?php include_once "../../assest/config/footer.php"; ?>
            <?php include_once "../../assest/config/menuExtraMaterial.php"; ?>
    </div>
    <?php include_once "../../assest/config/urlBase.php"; ?>
</body>
</html>