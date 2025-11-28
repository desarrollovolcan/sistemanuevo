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
$kilosMpPorVariedad = [];
$RECEPCION = 0;
$RECEPCIONMP = 0;
$RECEPCIONIND = 0;
$RECEPCIONPT = 0;
$DESPACHO = 0;
$DESPACHOMP = 0;
$DESPACHOIND = 0;
$DESPACHOPT = 0;
$DESPACHOEXPO = 0;
$PROCESO = 0;
$REEMBALAJE = 0;
$REPALETIZAJE = 0;
$TOTAL_EXISTENCIA_MP = 0;
$TOTAL_VARIEDAD = 0;
$variacionRecepcion = 0;
$variacionProcesado = 0;

$query_kilosMpTotales = $CONSULTA_ADO->TotalKgMpRecepcionadosPlanta($TEMPORADAS, $PLANTAS);
$query_datosPlanta = $CONSULTA_ADO->verPlanta($PLANTAS);
$query_kilosMpTotalesEmpresaPlanta = $CONSULTA_ADO->TotalKgMpRecepcionadosEmpresaPlanta($TEMPORADAS, $PLANTAS);
$query_kilosMpProcesadosAgrupado = $CONSULTA_ADO->TotalKgMpProcesadoAgrupado($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_kilosMpPorVariedad = $CONSULTA_ADO->TotalKgMpPorVariedad($TEMPORADAS, $EMPRESAS, $PLANTAS);
$query_totalPtExportacion = $CONSULTA_ADO->TotalKgPtExportacionPlanta($TEMPORADAS, $PLANTAS);
$query_existenciaMpEmpresa = $CONSULTA_ADO->TotalExistenciaMpEmpresaPlanta($TEMPORADAS, $PLANTAS);
$empresasConMovimiento = 0;

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
$ARRAYREGISTROSABIERTOS = $CONSULTA_ADO->contarRegistrosAbiertosFruta($EMPRESAS, $PLANTAS, $TEMPORADAS);
$TOTALNOTIDASH = $ARRAYNOTIFICACIONESCABECERA ? count($ARRAYNOTIFICACIONESCABECERA) : 0;
$contadorPrioridad = [
    'alta' => 0,
    'media' => 0,
    'baja' => 0
];

if ($query_kilosMpTotales) {
    $kilosMpTotales = $query_kilosMpTotales[0]["TOTAL"];
}

if ($query_datosPlanta) {
    $nombrePlanta = $query_datosPlanta[0]['NOMBRE_PLANTA'];
}

if ($query_kilosMpTotalesEmpresaPlanta) {
    $kilosMpTotalesEmpresaPlanta = $query_kilosMpTotalesEmpresaPlanta;
    $empresasConMovimiento = count($kilosMpTotalesEmpresaPlanta);
}

if ($query_kilosMpProcesadosAgrupado) {
    $kilosMpProcesadosAgrupado = $query_kilosMpProcesadosAgrupado;
}

if ($query_kilosMpPorVariedad) {
    $kilosMpPorVariedad = $query_kilosMpPorVariedad;
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
$variacionRecepcion = $acumuladoMpDiaAnterior > 0 ? round((($acumuladoMp - $acumuladoMpDiaAnterior) * 100) / $acumuladoMpDiaAnterior, 1) : 0;
$variacionProcesado = $mpProcesadoDiaAnterior > 0 ? round((($mpProcesado - $mpProcesadoDiaAnterior) * 100) / $mpProcesadoDiaAnterior, 1) : 0;
$claseTrendRecepcion = $variacionRecepcion > 0 ? 'trend-up' : ($variacionRecepcion < 0 ? 'trend-down' : 'trend-neutral');
$claseTrendProcesado = $variacionProcesado > 0 ? 'trend-up' : ($variacionProcesado < 0 ? 'trend-down' : 'trend-neutral');

if ($query_existenciaMpEmpresa) {
    $TOTAL_EXISTENCIA_MP = array_sum(array_column($query_existenciaMpEmpresa, 'TOTAL'));
}

if ($kilosMpPorVariedad) {
    $TOTAL_VARIEDAD = array_sum(array_column($kilosMpPorVariedad, 'TOTAL'));
}

$kilosNoProcesados = max($kilosMpTotales - $mpProcesado, 0);
$porcentajeProcesoSobreRecepcion = $kilosMpTotales > 0 ? round(($mpProcesado * 100) / $kilosMpTotales, 1) : 0;
$porcentajeStockSobreRecepcion = $kilosMpTotales > 0 ? round(($TOTAL_EXISTENCIA_MP * 100) / $kilosMpTotales, 1) : 0;

if ($ARRAYNOTIFICACIONESCABECERA) {
    foreach ($ARRAYNOTIFICACIONESCABECERA as $notificacion) {
        if ($notificacion['PRIORIDAD'] == 1) {
            $contadorPrioridad['alta']++;
        } elseif ($notificacion['PRIORIDAD'] == 3) {
            $contadorPrioridad['baja']++;
        } else {
            $contadorPrioridad['media']++;
        }
    }
}

if ($ARRAYREGISTROSABIERTOS) {
    $RECEPCION = $ARRAYREGISTROSABIERTOS[0]["RECEPCION"];
    $RECEPCIONMP = $ARRAYREGISTROSABIERTOS[0]["RECEPCIONMP"];
    $RECEPCIONIND = $ARRAYREGISTROSABIERTOS[0]["RECEPCIONIND"];
    $RECEPCIONPT = $ARRAYREGISTROSABIERTOS[0]["RECEPCIONPT"];
    $DESPACHO = $ARRAYREGISTROSABIERTOS[0]["DESPACHO"];
    $DESPACHOMP = $ARRAYREGISTROSABIERTOS[0]["DESPACHOMP"];
    $DESPACHOIND = $ARRAYREGISTROSABIERTOS[0]["DESPACHOIND"];
    $DESPACHOPT = $ARRAYREGISTROSABIERTOS[0]["DESPACHOPT"];
    $DESPACHOEXPO = $ARRAYREGISTROSABIERTOS[0]["DESPACHOEXPO"];
    $PROCESO = $ARRAYREGISTROSABIERTOS[0]["PROCESO"];
    $REEMBALAJE = $ARRAYREGISTROSABIERTOS[0]["REEMBALAJE"];
    $REPALETIZAJE = $ARRAYREGISTROSABIERTOS[0]["REPALETIZAJE"];
}

$tarjetasRegistrosAbiertos = [
    ["titulo" => "Recepción MP", "valor" => $RECEPCIONMP],
    ["titulo" => "Recepción IND", "valor" => $RECEPCIONIND],
    ["titulo" => "Recepción PT", "valor" => $RECEPCIONPT],
    ["titulo" => "Despacho MP", "valor" => $DESPACHOMP],
    ["titulo" => "Despacho IND", "valor" => $DESPACHOIND],
    ["titulo" => "Despacho PT", "valor" => $DESPACHOPT],
    ["titulo" => "Despacho EXPO", "valor" => $DESPACHOEXPO],
    ["titulo" => "Proceso", "valor" => $PROCESO],
    ["titulo" => "Reembalaje", "valor" => $REEMBALAJE],
    ["titulo" => "Repaletizaje", "valor" => $REPALETIZAJE],
];






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
        <style>
            .kpi-card {
                border-radius: 10px;
                box-shadow: 0 6px 14px rgba(2, 6, 23, .08);
                height: 100%;
            }
            .kilos-dashboard .kpi-card {
                border: none;
                overflow: hidden;
            }
            .kilos-dashboard .kpi-card .box-body {
                position: relative;
                padding: 20px;
            }
            .kilos-dashboard .kpi-card .kpi-badge {
                background: rgba(255, 255, 255, 0.18);
                border-radius: 999px;
                padding: 4px 10px;
                font-size: 11px;
                color: #fff;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }
            .kilos-dashboard .kpi-card .kpi-number {
                font-size: 28px;
                color: #fff;
            }
            .kilos-dashboard .kpi-card .kpi-label {
                color: rgba(255, 255, 255, 0.82);
                margin-bottom: 6px;
            }
            .kilos-dashboard .kpi-card .kpi-meta {
                color: rgba(255, 255, 255, 0.9);
                font-size: 13px;
            }
            .bg-kilos-1 { background: linear-gradient(135deg, #2563eb 0%, #5b8def 100%); }
            .bg-kilos-2 { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
            .bg-kilos-3 { background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%); }
            .bg-kilos-4 { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
            .trend-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 3px 8px;
                border-radius: 999px;
                font-size: 12px;
                background: rgba(255, 255, 255, 0.2);
                color: #fff;
            }
            .trend-up::before { content: '▲'; font-size: 10px; }
            .trend-down::before { content: '▼'; font-size: 10px; }
            .trend-neutral::before { content: '■'; font-size: 10px; }
            .kpi-card .box-body {
                padding: 18px 20px;
            }
            .kpi-title {
                font-size: 14px;
                color: #7b8190;
                margin-bottom: 4px;
            }
            .progress-lite {
                height: 6px;
                border-radius: 30px;
                background-color: #eef1f6;
                overflow: hidden;
            }
            .progress-lite .bar {
                height: 100%;
                background: linear-gradient(90deg, #5b8def 0%, #55c2ff 100%);
            }
            .progress-lite.white { background: rgba(255,255,255,0.25); }
            .progress-lite.white .bar { background: rgba(255,255,255,0.9); }
            .notifications-row .card {
                border: 1px solid #e9eef5;
                box-shadow: 0 4px 12px rgba(15, 23, 42, .06);
            }
            .badge-prioridad.alta { background: #ffe6e6; color: #c53030; }
            .badge-prioridad.media { background: #fff7e6; color: #d97706; }
            .badge-prioridad.baja { background: #e7f5ff; color: #2563eb; }
            .badge-destino { background: #f3f6fb; color: #41506b; }
            .alert-summary { background: #f1f5f9; border: 1px dashed #d5d9e0; padding: 10px 15px; border-radius: 8px; }
            .icon-pill {
                width: 42px;
                height: 42px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
            }
            .gap-10 { gap: 10px; }
            .font-weight-600 { font-weight: 600; }
            .table-progress { width: 160px; }
            .kilos-flow .flow-step {
                border-right: 1px solid #edf1f7;
            }
            .kilos-flow .flow-step:last-child { border-right: none; }
            .kilos-flow .flow-value { font-size: 22px; margin-bottom: 4px; }
            .kilos-flow .progress-lite .bar.export { background: linear-gradient(90deg, #0ea5e9 0%, #22d3ee 100%); }
            .kilos-flow .progress-lite .bar.stock { background: linear-gradient(90deg, #8b5cf6 0%, #a78bfa 100%); }
        </style>
</head>
<body class="hold-transition light-skin fixed sidebar-mini theme-primary module-fruta" >
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
                        <div class="row mb-15 kilos-dashboard">
                            <div class="col-xl-3 col-md-6 col-12 mb-10">
                                <div class="box kpi-card bg-kilos-1 text-white">
                                    <div class="box-body">
                                        <span class="kpi-badge"><i class="ti-package"></i> Recepción</span>
                                        <p class="kpi-label mb-5">Kilos netos recepcionados</p>
                                        <h3 class="kpi-number mb-5"><?php echo number_format(round($kilosMpTotales, 0), 0, ",", "."); ?> kg</h3>
                                        <p class="kpi-meta mb-0"><?php echo $empresasConMovimiento; ?> empresas aportando · Promedio <?php echo $empresasConMovimiento>0 ? number_format(round($kilosMpTotales / $empresasConMovimiento, 0), 0, ",", ".") : 0; ?> kg</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 mb-10">
                                <div class="box kpi-card bg-kilos-2 text-white">
                                    <div class="box-body">
                                        <span class="kpi-badge"><i class="ti-stats-up"></i> Recepción diaria</span>
                                        <p class="kpi-label mb-5">Acumulado temporada</p>
                                        <h3 class="kpi-number mb-5"><?php echo number_format(round($acumuladoMp, 0), 0, ",", "."); ?> kg</h3>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="trend-pill <?php echo $claseTrendRecepcion; ?>"><?php echo $variacionRecepcion; ?>%</span>
                                            <span class="kpi-meta">Día anterior: <?php echo number_format(round($acumuladoMpDiaAnterior, 0), 0, ",", "."); ?> kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 mb-10">
                                <div class="box kpi-card bg-kilos-3 text-white">
                                    <div class="box-body">
                                        <span class="kpi-badge"><i class="ti-pie-chart"></i> Procesos</span>
                                        <p class="kpi-label mb-5">Kilos netos procesados</p>
                                        <h3 class="kpi-number mb-5"><?php echo number_format(round($mpProcesado, 0), 0, ",", "."); ?> kg</h3>
                                        <div class="d-flex align-items-center justify-content-between mb-10">
                                            <span class="trend-pill <?php echo $claseTrendProcesado; ?>"><?php echo $variacionProcesado; ?>%</span>
                                            <span class="kpi-meta">Día anterior: <?php echo number_format(round($mpProcesadoDiaAnterior, 0), 0, ",", "."); ?> kg</span>
                                        </div>
                                        <div>
                                            <small class="kpi-meta d-block mb-5">PT exportación: <?php echo number_format(round($ptExportacion, 0), 0, ",", "."); ?> kg (<?php echo $porcentajeExportacion; ?>%)</small>
                                            <div class="progress-lite white">
                                                <div class="bar" style="width: <?php echo $porcentajeExportacion; ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 mb-10">
                                <div class="box kpi-card bg-kilos-4 text-white">
                                    <div class="box-body">
                                        <span class="kpi-badge"><i class="ti-archive"></i> Disponibilidad</span>
                                        <p class="kpi-label mb-5">Stock de materia prima</p>
                                        <h3 class="kpi-number mb-5"><?php echo number_format(round($TOTAL_EXISTENCIA_MP, 0), 0, ",", "."); ?> kg</h3>
                                        <?php $porcentajeExistenciaSobreRecepcion = $kilosMpTotales>0 ? round(($TOTAL_EXISTENCIA_MP*100)/$kilosMpTotales, 1) : 0; ?>
                                        <p class="kpi-meta mb-10">Equivale al <?php echo $porcentajeExistenciaSobreRecepcion; ?>% de lo recepcionado</p>
                                        <div class="progress-lite white">
                                            <div class="bar" style="width: <?php echo min(100, $porcentajeExistenciaSobreRecepcion); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-20">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Flujo de kilos netos</h4>
                                        <div class="box-controls pull-right d-md-flex d-none align-items-center gap-10">
                                            <span class="badge badge-primary-light">Recepción base</span>
                                            <span class="badge badge-success-light">Procesado</span>
                                            <span class="badge badge-info-light">Exportación</span>
                                            <span class="badge badge-secondary-light">Stock</span>
                                        </div>
                                    </div>
                                    <div class="box-body kilos-flow">
                                        <div class="row text-center align-items-center">
                                            <div class="col-md-3 col-6 flow-step mb-15 mb-md-0">
                                                <p class="text-muted mb-5">Recepción acumulada</p>
                                                <div class="flow-value text-primary mb-5"><?php echo number_format(round($kilosMpTotales, 0), 0, ",", "."); ?> kg</div>
                                                <small class="text-muted">Base para los demás indicadores</small>
                                            </div>
                                            <div class="col-md-3 col-6 flow-step mb-15 mb-md-0">
                                                <p class="text-muted mb-5">Procesado</p>
                                                <div class="flow-value text-success mb-5"><?php echo number_format(round($mpProcesado, 0), 0, ",", "."); ?> kg</div>
                                                <div class="progress-lite">
                                                    <div class="bar" style="width: <?php echo $porcentajeProcesoSobreRecepcion; ?>%"></div>
                                                </div>
                                                <small class="text-muted">Equivale al <?php echo $porcentajeProcesoSobreRecepcion; ?>% de lo recepcionado</small>
                                            </div>
                                            <div class="col-md-3 col-6 flow-step mb-15 mb-md-0">
                                                <p class="text-muted mb-5">Exportación PT</p>
                                                <div class="flow-value text-info mb-5"><?php echo number_format(round($ptExportacion, 0), 0, ",", "."); ?> kg</div>
                                                <div class="progress-lite">
                                                    <div class="bar export" style="width: <?php echo $porcentajeExportacion; ?>%"></div>
                                                </div>
                                                <small class="text-muted"><?php echo $porcentajeExportacion; ?>% del total procesado</small>
                                            </div>
                                            <div class="col-md-3 col-6 mb-15 mb-md-0">
                                                <p class="text-muted mb-5">Stock disponible</p>
                                                <div class="flow-value mb-5" style="color:#8b5cf6;"><?php echo number_format(round($TOTAL_EXISTENCIA_MP, 0), 0, ",", "."); ?> kg</div>
                                                <div class="progress-lite">
                                                    <div class="bar stock" style="width: <?php echo $porcentajeStockSobreRecepcion; ?>%"></div>
                                                </div>
                                                <small class="text-muted"><?php echo number_format(round($kilosNoProcesados, 0), 0, ",", "."); ?> kg sin procesar aún</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-15 notifications-row">
                            <div class="col-12 mb-10">
                                <div class="alert-summary d-flex justify-content-between flex-wrap align-items-center">
                                    <div>
                                        <strong><?php echo $TOTALNOTIDASH; ?> notificaciones activas</strong>
                                        <span class="text-muted">filtradas por usuario, empresa y planta actuales.</span>
                                    </div>
                                    <div class="d-flex gap-10 align-items-center">
                                        <span class="badge badge-prioridad alta">Alta: <?php echo $contadorPrioridad['alta']; ?></span>
                                        <span class="badge badge-prioridad media">Media: <?php echo $contadorPrioridad['media']; ?></span>
                                        <span class="badge badge-prioridad baja">Baja: <?php echo $contadorPrioridad['baja']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card notifications-board table-velzon">
                                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <p class="card-subtitle mb-1 text-muted">Centro de alertas</p>
                                            <h4 class="card-title mb-0">Notificaciones según sesión</h4>
                                        </div>
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
                                                                $prioridadClase = 'badge-prioridad '.($noti['PRIORIDAD']==1 ? 'alta' : ($noti['PRIORIDAD']==3 ? 'baja' : 'media'));
                                                                $destino = ucfirst($noti['DESTINO_TIPO']).' #'.$noti['DESTINO_ID'];
                                                                $vigencia = $noti['FECHA_INICIO'];
                                                                if($noti['FECHA_FIN']){ $vigencia .= ' - '.$noti['FECHA_FIN']; }
                                                                $estado = $noti['ESTADO_REGISTRO']==1 ? 'Activa' : 'Inactiva';
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-start gap-10">
                                                                        <span class="icon-pill bg-primary-light text-primary"><i class="ti-bell"></i></span>
                                                                        <div>
                                                                            <div class="font-weight-600 text-dark"><?php echo $noti['MENSAJE']; ?></div>
                                                                            <small class="text-muted">Creada por <?php echo $noti['USUARIO_CREADOR']; ?></small>
                                                                        </div>
                                                                    </div>
                                                                </td>
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
                            <div class="col-12 mb-15">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Resumen rápido de kilos</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-12 mb-15">
                                                <div class="box kpi-card">
                                                    <div class="box-body">
                                                        <p class="kpi-title">Kilos netos recepcionados</p>
                                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                                            <h3 class="mb-0 text-primary"><?php echo number_format(round($kilosMpTotales, 0), 0, ",", "."); ?> kg</h3>
                                                            <span class="badge badge-primary-light">Planta</span>
                                                        </div>
                                                        <div class="progress-lite">
                                                            <div class="bar" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-12 mb-15">
                                                <div class="box kpi-card">
                                                    <div class="box-body">
                                                        <p class="kpi-title">Kilos netos procesados</p>
                                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                                            <h3 class="mb-0 text-success"><?php echo number_format(round($mpProcesado, 0), 0, ",", "."); ?> kg</h3>
                                                            <span class="badge badge-success-light"><?php echo $procesosAbiertos; ?> procesos</span>
                                                        </div>
                                                        <div class="progress-lite">
                                                            <?php $anchoProceso = $kilosMpTotales>0 ? min(100, round(($mpProcesado*100)/$kilosMpTotales,1)) : 0; ?>
                                                            <div class="bar" style="width: <?php echo $anchoProceso; ?>%"></div>
                                                        </div>
                                                        <small class="text-muted">Equivale al <?php echo $anchoProceso; ?>% de lo recepcionado.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-12 mb-15">
                                                <div class="box kpi-card">
                                                    <div class="box-body">
                                                        <p class="kpi-title">Producto terminado exportación</p>
                                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                                            <h3 class="mb-0 text-info"><?php echo number_format(round($ptExportacion, 0), 0, ",", "."); ?> kg</h3>
                                                            <span class="badge badge-info-light"><?php echo $porcentajeExportacion; ?>%</span>
                                                        </div>
                                                        <div class="progress-lite">
                                                            <div class="bar" style="width: <?php echo $porcentajeExportacion; ?>%"></div>
                                                        </div>
                                                        <small class="text-muted">Porcentaje respecto al procesado.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-12 mb-15">
                                                <div class="box kpi-card">
                                                    <div class="box-body">
                                                        <p class="kpi-title">Existencia de materia prima</p>
                                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                                            <h3 class="mb-0 text-dark"><?php echo number_format(round($TOTAL_EXISTENCIA_MP, 0), 0, ",", "."); ?> kg</h3>
                                                            <span class="badge badge-secondary-light">Stock</span>
                                                        </div>
                                                        <div class="progress-lite">
                                                            <?php $anchoExistencia = $kilosMpTotales>0 ? min(100, round(($TOTAL_EXISTENCIA_MP*100)/$kilosMpTotales,1)) : 0; ?>
                                                            <div class="bar" style="width: <?php echo $anchoExistencia; ?>%"></div>
                                                        </div>
                                                        <small class="text-muted">Disponible versus recepcionado.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <div class="row mb-15">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-header with-border" style="padding: 7px 1.5rem!important;">
                                        <h4 class="box-title">Registros abiertos por módulo</h4>
                                    </div>
                                    <div class="box-body pt-15 pb-5">
                                        <div class="row">
                                            <?php foreach ($tarjetasRegistrosAbiertos as $registro) : ?>
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-15">
                                                    <div class="p-15 bg-light rounded h-100">
                                                        <p class="text-muted mb-5"><?php echo $registro["titulo"]; ?></p>
                                                        <h4 class="mb-0 text-primary"><?php echo $registro["valor"]; ?></h4>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
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
                                                            <th class="text-right">Avance</th>
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
                                                                <td class="text-right table-progress">
                                                                    <div class="progress-lite">
                                                                        <div class="bar" style="width: <?php echo $porcentaje; ?>%"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">Sin kilos netos registrados para la planta seleccionada.</td>
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
                                                            <th class="text-right">Avance</th>
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
                                                                <td class="text-right table-progress">
                                                                    <div class="progress-lite">
                                                                        <div class="bar" style="width: <?php echo $porcentajeProceso; ?>%"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">Sin procesos registrados para la planta seleccionada.</td>
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
                                                            <th class="text-right">Participación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if ($query_existenciaMpEmpresa) : ?>
                                                        <?php foreach ($query_existenciaMpEmpresa as $rowsExistenciaMpEmpresa) : ?>
                                                            <tr>
                                                                <td><?php echo $rowsExistenciaMpEmpresa["NOMBRE_EMPRESA"]; ?></td>
                                                                <td class="text-right"><?php echo number_format(round($rowsExistenciaMpEmpresa["TOTAL"], 0), 0, ",", "."); ?> kg</td>
                                                                <?php $porcentajeExistencia = $TOTAL_EXISTENCIA_MP > 0 ? round((round($rowsExistenciaMpEmpresa["TOTAL"], 0) * 100) / round($TOTAL_EXISTENCIA_MP, 0), 1) : 0; ?>
                                                                <td class="text-right table-progress">
                                                                    <div class="progress-lite">
                                                                        <div class="bar" style="width: <?php echo $porcentajeExistencia; ?>%"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">Sin existencia de materia prima para la planta seleccionada.</td>
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
                                        <h4 class="box-title">Distribución de kilos por variedad</h4>
                                    </div>
                                    <div class="box-body">
                                        <?php $totalVariedad = array_sum(array_column($kilosMpPorVariedad, 'TOTAL')); ?>
                                        <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Variedad</th>
                                                            <th class="text-right">Kilos netos</th>
                                                            <th class="text-right">Participación</th>
                                                            <th class="text-right">Avance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if ($kilosMpPorVariedad) : ?>
                                                        <?php foreach ($kilosMpPorVariedad as $rowsVariedad) :
                                                            $porcentajeVariedad = $totalVariedad > 0 ? round((round($rowsVariedad["TOTAL"], 0) * 100) / round($totalVariedad, 0), 1) : 0;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $rowsVariedad["NOMBRE_VESPECIES"]; ?></td>
                                                                <td class="text-right"><?php echo number_format(round($rowsVariedad["TOTAL"], 0), 0, ",", "."); ?> kg</td>
                                                                <td class="text-right"><?php echo $porcentajeVariedad; ?>%</td>
                                                                <td class="text-right table-progress">
                                                                    <div class="progress-lite">
                                                                        <div class="bar" style="width: <?php echo $porcentajeVariedad; ?>%"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">Sin registros de recepción por variedad para la planta seleccionada.</td>
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