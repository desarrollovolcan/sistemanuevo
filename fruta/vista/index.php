<?php
include_once "../../assest/config/validarUsuarioFruta.php";



//LLAMADA ARCHIVOS NECESARIOS PARA LAS OPERACIONES
include_once "../../assest/controlador/CONSULTA_ADO.php";


//INICIALIZAR CONTROLADOR
$CONSULTA_ADO =  NEW CONSULTA_ADO;

//INCIALIZAR VARIBALES A OCUPAR PARA LA FUNCIONALIDAD

$kilosMpTotales = 0;
$nombrePlanta = "";
$kilosMpTotalesEmpresaPlanta = [];
$kilosMpProcesadosAgrupado = [];

$query_kilosMpTotales = $CONSULTA_ADO->TotalKgMpRecepcionadosPlanta($TEMPORADAS, $PLANTAS);
$query_datosPlanta = $CONSULTA_ADO->verPlanta($PLANTAS);
$query_kilosMpTotalesEmpresaPlanta = $CONSULTA_ADO->TotalKgMpRecepcionadosEmpresaPlanta($TEMPORADAS, $PLANTAS);
$query_kilosMpProcesadosAgrupado = $CONSULTA_ADO->TotalKgMpProcesadoAgrupado($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_totalPtExportacion = $CONSULTA_ADO->TotalKgPtExportacionPlanta($TEMPORADAS, $PLANTAS);
$query_existenciaMpEmpresa = $CONSULTA_ADO->TotalExistenciaMpEmpresaPlanta($TEMPORADAS, $PLANTAS);

//recepciones
$query_recepcionAbiertaMP = $CONSULTA_ADO->TotalRecepcionMpAbiertas($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_recepcionAbiertaIND = $CONSULTA_ADO->TotalRecepcionIndAbiertas($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_despachoAbiertoMP = $CONSULTA_ADO->TotalDespachoMpAbiertas($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_despachoAbiertoIND = $CONSULTA_ADO->TotalDespachoIndAbiertas($TEMPORADAS, $EMPRESAS, $PLANTAS);

//proceso
$query_procesoAbierto = $CONSULTA_ADO->TotalProcesosAbiertos($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_reembalajeAbierto = $CONSULTA_ADO->TotalReembalajesAbiertos($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_repaletizajeAbierto = $CONSULTA_ADO->TotalRepaletizajesAbiertos($TEMPORADAS, $EMPRESAS, $PLANTAS);

//acumulado
$query_acumuladoMP = $CONSULTA_ADO->TotalKgMpRecepcionadoAcumulado($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_acumuladoMPDiaAnterior = $CONSULTA_ADO->TotalKgMpRecepcionadoDiaAnterior($TEMPORADAS, $EMPRESAS, $PLANTAS);

$query_acumuladoMPProcesado = $CONSULTA_ADO->TotalKgMpProcesado($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_acumuladoMPProcesadoDiaAnterior = $CONSULTA_ADO->TotalKgMpProcesadoDiaAnterior($TEMPORADAS, $EMPRESAS, $PLANTAS);

if ($query_kilosMpTotales) {
    $kilosMpTotales = $query_kilosMpTotales[0]["TOTAL"];
}

if ($query_datosPlanta) {
    $nombrePlanta = $query_datosPlanta[0]['NOMBRE_PLANTA'];
}

if ($query_kilosMpTotalesEmpresaPlanta) {
    $kilosMpTotalesEmpresaPlanta = $query_kilosMpTotalesEmpresaPlanta;
}

if ($query_kilosMpProcesadosAgrupado) {
    $kilosMpProcesadosAgrupado = $query_kilosMpProcesadosAgrupado;
}

$recepcionesMpAbiertas = $query_recepcionAbiertaMP ? $query_recepcionAbiertaMP[0]["NUMERO"] : 0;
$recepcionesIndAbiertas = $query_recepcionAbiertaIND ? $query_recepcionAbiertaIND[0]["NUMERO"] : 0;
$despachosMpAbiertos = $query_despachoAbiertoMP ? $query_despachoAbiertoMP[0]["NUMERO"] : 0;
$despachosIndAbiertos = $query_despachoAbiertoIND ? $query_despachoAbiertoIND[0]["NUMERO"] : 0;

$procesosAbiertos = $query_procesoAbierto ? $query_procesoAbierto[0]["NUMERO"] : 0;
$reembalajesAbiertos = $query_reembalajeAbierto ? $query_reembalajeAbierto[0]["NUMERO"] : 0;
$repaletizajesAbiertos = $query_repaletizajeAbierto ? $query_repaletizajeAbierto[0]["NUMERO"] : 0;

$acumuladoMp = $query_acumuladoMP ? $query_acumuladoMP[0]["TOTAL"] : 0;
$acumuladoMpDiaAnterior = $query_acumuladoMPDiaAnterior ? $query_acumuladoMPDiaAnterior[0]["TOTAL"] : 0;

$mpProcesado = $query_acumuladoMPProcesado ? $query_acumuladoMPProcesado[0]["TOTAL"] : 0;
$mpProcesadoDiaAnterior = $query_acumuladoMPProcesadoDiaAnterior ? $query_acumuladoMPProcesadoDiaAnterior[0]["TOTAL"] : 0;

$ptExportacion = $query_totalPtExportacion ? $query_totalPtExportacion[0]["TOTAL"] : 0;
$porcentajeExportacion = $mpProcesado > 0 ? round((round($ptExportacion, 0) * 100) / round($mpProcesado, 0), 1) : 0;






/*$RECEPCION=0;
$RECEPCIONMP=0;
$RECEPCIONIND=0;
$RECEPCIONPT=0;
$DESPACHO=0;
$PROCESO=0;
$REEMBALAJE=0;
$REPALETIZAJE=0;

//INICIALIZAR ARREGLOS
$ARRAYREGISTROSABIERTOS="";
$ARRAYAVISOS1=$AVISO_ADO->listarAvisoActivosCBX();
//$ARRAYAVISOS2=$AVISO_ADO->listarAvisoActivosFijoCBX();



//DEFINIR ARREGLOS CON LOS DATOS OBTENIDOS DE LAS FUNCIONES DE LOS CONTROLADORES
$ARRAYREGISTROSABIERTOS=$CONSULTA_ADO->contarRegistrosAbiertosFruta($EMPRESAS,$PLANTAS,$TEMPORADAS);
if($ARRAYREGISTROSABIERTOS){
    $RECEPCION=$ARRAYREGISTROSABIERTOS[0]["RECEPCION"];
    $RECEPCIONMP=$ARRAYREGISTROSABIERTOS[0]["RECEPCIONMP"];
    $RECEPCIONIND=$ARRAYREGISTROSABIERTOS[0]["RECEPCIONIND"];
    $RECEPCIONPT=$ARRAYREGISTROSABIERTOS[0]["RECEPCIONPT"];
    $DESPACHO=$ARRAYREGISTROSABIERTOS[0]["DESPACHO"];
    $DESPACHOMP=$ARRAYREGISTROSABIERTOS[0]["DESPACHOMP"];
    $DESPACHOIND=$ARRAYREGISTROSABIERTOS[0]["DESPACHOIND"];
    $DESPACHOPT=$ARRAYREGISTROSABIERTOS[0]["DESPACHOPT"];
    $DESPACHOEXPO=$ARRAYREGISTROSABIERTOS[0]["DESPACHOEXPO"];
    $PROCESO=$ARRAYREGISTROSABIERTOS[0]["PROCESO"];
    $REEMBALAJE=$ARRAYREGISTROSABIERTOS[0]["REEMBALAJE"];
    $REPALETIZAJE=$ARRAYREGISTROSABIERTOS[0]["REPALETIZAJE"];
}*/


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
        <!- LLAMADA AL MENU PRINCIPAL DE LA PAGINA-!>
            <?php include_once "../../assest/config/menuFruta.php"; ?>
            <!- LLAMADA ARCHIVO DEL DISEÑO DEL FOOTER Y MENU USUARIO -!>
            <div class="content-wrapper">
                <div class="container-full">
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="page-title">Dashboard kilos netos</h3>
                                <p class="mb-0 text-muted">Planta <?php echo strtoupper($nombrePlanta); ?> · Temporada <?php echo $TEMPORADAS; ?></p>
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
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body text-center">
                                        <p class="mb-0 text-muted">Kilos netos recepcionados</p>
                                        <h2 class="text-primary mb-0"><?php echo number_format(round($kilosMpTotales, 0), 0, ",", "."); ?> kg</h2>
                                    </div>
                                    <div class="box-body bg-light py-10 text-center">
                                        <small class="text-muted">Resumen planta</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <p class="text-muted mb-10">Recepciones y despachos abiertos</p>
                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                            <span>Recepción MP</span>
                                            <span class="badge badge-primary"><?php echo $recepcionesMpAbiertas; ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                            <span>Recepción IND</span>
                                            <span class="badge badge-primary"><?php echo $recepcionesIndAbiertas; ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                            <span>Despacho MP</span>
                                            <span class="badge badge-primary"><?php echo $despachosMpAbiertos; ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Despacho IND</span>
                                            <span class="badge badge-primary"><?php echo $despachosIndAbiertos; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <p class="text-muted mb-10">Kilos netos acumulados</p>
                                        <div class="d-flex justify-content-between align-items-center mb-15">
                                            <span>Acumulado</span>
                                            <strong><?php echo number_format(round($acumuladoMp, 0), 0, ",", "."); ?> kg</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Día anterior</span>
                                            <strong><?php echo number_format(round($acumuladoMpDiaAnterior, 0), 0, ",", "."); ?> kg</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <p class="text-muted mb-10">Kilos netos procesados</p>
                                        <div class="d-flex justify-content-between align-items-center mb-15">
                                            <span>Procesado</span>
                                            <strong><?php echo number_format(round($mpProcesado, 0), 0, ",", "."); ?> kg</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-15">
                                            <span>Día anterior</span>
                                            <strong><?php echo number_format(round($mpProcesadoDiaAnterior, 0), 0, ",", "."); ?> kg</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-15">
                                            <span>PT exportación</span>
                                            <strong><?php echo number_format(round($ptExportacion, 0), 0, ",", "."); ?> kg</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-15">
                                            <span>% exportación vs procesado</span>
                                            <strong><?php echo $porcentajeExportacion; ?>%</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Procesos abiertos</span>
                                            <span class="badge badge-warning"><?php echo $procesosAbiertos; ?></span>
                                        </div>
                                    </div>
                                    <div class="box-body bg-light py-10 text-center">
                                        <small class="text-muted">Reembalajes: <?php echo $reembalajesAbiertos; ?> · Repaletizajes: <?php echo $repaletizajesAbiertos; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Distribución de kilos netos por empresa</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th class="text-right">Kilos netos</th>
                                                        <th class="text-right">Participación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($kilosMpTotalesEmpresaPlanta) : ?>
                                                        <?php foreach ($kilosMpTotalesEmpresaPlanta as $rowsKilosTotalesEmpresaPlanta) :
                                                            $porcentaje = $kilosMpTotales > 0 ? round((round($rowsKilosTotalesEmpresaPlanta["TOTAL"], 0) * 100) / round($kilosMpTotales, 0), 1) : 0;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowsKilosTotalesEmpresaPlanta["NOMBRE_EMPRESA"]; ?></td>
                                                                <td class="text-right"><?php echo number_format(round($rowsKilosTotalesEmpresaPlanta["TOTAL"], 0), 0, ",", "."); ?> kg</td>
                                                                <td class="text-right"><?php echo $porcentaje; ?>%</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">Sin kilos netos registrados para la planta seleccionada.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Procesos agrupados por tipo</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo de proceso</th>
                                                        <th class="text-right">Kilos netos</th>
                                                        <th class="text-right">Participación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($kilosMpProcesadosAgrupado) : ?>
                                                        <?php foreach ($kilosMpProcesadosAgrupado as $rowsProcesoAgrupado) :
                                                            $porcentajeProceso = $mpProcesado > 0 ? round((round($rowsProcesoAgrupado["TOTAL"], 0) * 100) / round($mpProcesado, 0), 1) : 0;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowsProcesoAgrupado["NOMBRE_TPROCESO"]; ?></td>
                                                                <td class="text-right"><?php echo number_format(round($rowsProcesoAgrupado["TOTAL"], 0), 0, ",", "."); ?> kg</td>
                                                                <td class="text-right"><?php echo $porcentajeProceso; ?>%</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">Sin procesos registrados para la planta seleccionada.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Existencia de materia prima por empresa</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th class="text-right">Kilos netos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($query_existenciaMpEmpresa) : ?>
                                                        <?php foreach ($query_existenciaMpEmpresa as $rowsExistenciaMpEmpresa) : ?>
                                                            <tr>
                                                                <td><?php echo $rowsExistenciaMpEmpresa["NOMBRE_EMPRESA"]; ?></td>
                                                                <td class="text-right"><?php echo number_format(round($rowsExistenciaMpEmpresa["TOTAL"], 0), 0, ",", "."); ?> kg</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted">Sin existencia de materia prima para la planta seleccionada.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
<?php include_once "../../assest/config/footer.php"; ?>
            <?php include_once "../../assest/config/menuExtraFruta.php"; ?>
    </div>
    <!- LLAMADA URL DE ARCHIVOS DE DISEÑO Y JQUERY E OTROS -!>
        <?php include_once "../../assest/config/urlBase.php"; ?>
        <!--<script>
    Morris.Bar({
        element: 'graficofrigorifico',
        data: [{
            y: 'Angus',
            a: 17600,
            b: 9500
        }, {
            y: 'BBCH',
            a: 8000,
            b: 7000
        }, {
            y: 'Greenvic',
            a: 550,
            b: 4500
        }, {
            y: 'Volcan Foods',
            a: 800,
            b: 450
        }, {
            y: 'LLF',
            a: 55000,
            b: 45000
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['D. Exportación', 'D. Interplanta'],
        barColors:['#ff3f3f', '#0080ff'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
            </script>
-->
</body>
</html>