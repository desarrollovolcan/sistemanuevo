<?php
include_once "../../assest/config/validarUsuarioFruta.php";

include_once '../../assest/controlador/EXIMATERIAPRIMA_ADO.php';

include_once '../../assest/modelo/EXIMATERIAPRIMA.php';

$EXIMATERIAPRIMA_ADO =  new EXIMATERIAPRIMA_ADO();

$EXIMATERIAPRIMA =  new EXIMATERIAPRIMA();

$IDEXIMATERIAPRIMA = "";
$FOLIO = "";
$FOLION = "";
$CODIGO = "";
$MOTIVO = "";
$MENSAJE = "";
$MENSAJEENVIO = "";

$ARRAYEXISTENCIA = $EXIMATERIAPRIMA_ADO->listarEximateriaprimaEnExistencia($EMPRESAS, $PLANTAS, $TEMPORADAS);

if ($_POST) {
    if (isset($_REQUEST['IDEXIMATERIAPRIMA'])) {
        $IDEXIMATERIAPRIMA = $_REQUEST['IDEXIMATERIAPRIMA'];
    }
    if (isset($_REQUEST['FOLION'])) {
        $FOLION = $_REQUEST['FOLION'];
    }
    if (isset($_REQUEST['CODIGO'])) {
        $CODIGO = $_REQUEST['CODIGO'];
    }
    if (isset($_REQUEST['MOTIVO'])) {
        $MOTIVO = $_REQUEST['MOTIVO'];
    }
}

$ARRAYFOLIOSELECCIONADO = array_filter($ARRAYEXISTENCIA, function ($registro) use ($IDEXIMATERIAPRIMA) {
    return $registro['ID_EXIMATERIAPRIMA'] == $IDEXIMATERIAPRIMA;
});

if ($ARRAYFOLIOSELECCIONADO) {
    $DATOSFOLIO = array_values($ARRAYFOLIOSELECCIONADO)[0];
    $FOLIO = $DATOSFOLIO['FOLIO_EXIMATERIAPRIMA'];
}

if (isset($_REQUEST['SOLICITAR'])) {
    if (!$IDEXIMATERIAPRIMA) {
        $MENSAJE = "Debe seleccionar un folio para solicitar el código.";
    } else {
        $CODIGOVERIFICACION = random_int(100000, 999999);
        $_SESSION['GESTION_FOLIO_MP_CODIGO'] = $CODIGOVERIFICACION;
        $_SESSION['GESTION_FOLIO_MP_TIEMPO'] = time();

        $correoDestino = 'maperez@fvolcan.cl, eisla@fvolcan.cl';
        $asunto = 'Código de autorización - Cambio de folio materia prima';
        $mensajeCorreo = "Se ha solicitado un código para cambiar el folio de materia prima.\n\n" .
            "Usuario: " . $_SESSION['NOMBRE_USUARIO'] . "\n" .
            "Planta: " . $NOMBREPLANTA . "\n" .
            "Empresa: " . $NOMBREEMPRESA . "\n" .
            "Folio actual: " . $FOLIO . "\n" .
            (empty($MOTIVO) ? "" : "Motivo: " . $MOTIVO . "\n") .
            "Código de autorización: " . $CODIGOVERIFICACION . "\n\n" .
            "Este código es válido por 15 minutos.";
        $cabecera = "From: sistema@fvolcan.cl\r\n";
        $cabecera .= "Content-Type: text/plain; charset=UTF-8\r\n";

        @mail($correoDestino, $asunto, $mensajeCorreo, $cabecera);
        $MENSAJEENVIO = "Código enviado a los correos autorizados.";
    }
}

if (isset($_REQUEST['CAMBIAR'])) {

    $errores = array();
    if (!$IDEXIMATERIAPRIMA) {
        $errores[] = "Debe seleccionar un folio en existencia.";
    }
    if (!$FOLION) {
        $errores[] = "Ingrese el nuevo folio.";
    }
    if (!$CODIGO) {
        $errores[] = "Debe ingresar el código recibido.";
    }

    if (!empty($_SESSION['GESTION_FOLIO_MP_CODIGO'])) {
        if ($_SESSION['GESTION_FOLIO_MP_CODIGO'] != $CODIGO) {
            $errores[] = "El código de autorización no coincide.";
        }
        if (!empty($_SESSION['GESTION_FOLIO_MP_TIEMPO']) && (time() - $_SESSION['GESTION_FOLIO_MP_TIEMPO']) > 900) {
            $errores[] = "El código de autorización ha expirado.";
        }
    } else {
        $errores[] = "Debe solicitar un código antes de cambiar el folio.";
    }

    if (!$errores) {
        $EXIMATERIAPRIMA->__SET('FOLIO_EXIMATERIAPRIMA', $FOLION);
        $EXIMATERIAPRIMA->__SET('FOLIO_AUXILIAR_EXIMATERIAPRIMA', $FOLION);
        $EXIMATERIAPRIMA->__SET('ALIAS_DINAMICO_FOLIO_EXIMATERIAPRIMA', $FOLION);
        $EXIMATERIAPRIMA->__SET('ALIAS_ESTATICO_FOLIO_EXIMATERIAPRIMA', $FOLION);
        $EXIMATERIAPRIMA->__SET('ID_EXIMATERIAPRIMA', $IDEXIMATERIAPRIMA);
        $EXIMATERIAPRIMA_ADO->cambioFolio($EXIMATERIAPRIMA);

        $descripcionAccion = "" . $_SESSION["NOMBRE_USUARIO"] . ", Cambio de folio de materia prima";
        if (!empty($MOTIVO)) {
            $descripcionAccion .= " (Motivo: " . $MOTIVO . ")";
        }

        $AUSUARIO_ADO->agregarAusuario2("NULL", 1, 2, $descripcionAccion, "fruta_eximateriaprima", $IDEXIMATERIAPRIMA, $_SESSION["ID_USUARIO"], $_SESSION['ID_EMPRESA'], $_SESSION['ID_PLANTA'], $_SESSION['ID_TEMPORADA']);

        unset($_SESSION['GESTION_FOLIO_MP_CODIGO']);
        unset($_SESSION['GESTION_FOLIO_MP_TIEMPO']);

        echo '<script>
                    Swal.fire({
                        icon:"success",
                        title:"Folio actualizado",
                        text:"El folio de materia prima fue modificado correctamente.",
                        showConfirmButton:true,
                        confirmButtonText:"Cerrar"
                    }).then((result)=>{
                        if(result.value){
                            location.href ="registroGestionFolioMp.php";
                        }
                    })
                </script>';
    } else {
        $MENSAJE = implode(" ", $errores);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de folios materia prima</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include_once "../../assest/config/urlHead.php"; ?>
    <script type="text/javascript">
        function validacion() {
            var FOLIOSELECCION = document.getElementById("IDEXIMATERIAPRIMA").value;
            var FOLION = document.getElementById("FOLION").value;
            var CODIGO = document.getElementById("CODIGO").value;

            document.getElementById('val_folio').innerHTML = "";
            document.getElementById('val_fn').innerHTML = "";
            document.getElementById('val_codigo').innerHTML = "";

            if (FOLIOSELECCION == null || FOLIOSELECCION.length == 0 || /^\s+$/.test(FOLIOSELECCION)) {
                document.form_reg_dato.IDEXIMATERIAPRIMA.focus();
                document.getElementById('val_folio').innerHTML = "Seleccione un folio en existencia";
                return false;
            }

            if (FOLION == null || FOLION.length == 0 || /^\s+$/.test(FOLION)) {
                document.form_reg_dato.FOLION.focus();
                document.form_reg_dato.FOLION.style.borderColor = "#FF0000";
                document.getElementById('val_fn').innerHTML = "No ha ingresado folio nuevo";
                return false;
            }
            document.form_reg_dato.FOLION.style.borderColor = "#4AF575";

            if (FOLION.length > 10) {
                document.form_reg_dato.FOLION.focus();
                document.form_reg_dato.FOLION.style.borderColor = "#FF0000";
                document.getElementById('val_fn').innerHTML = "No se permiten más de 10 dígitos";
                return false;
            }
            document.form_reg_dato.FOLION.style.borderColor = "#4AF575";

            if (CODIGO == null || CODIGO.length == 0 || /^\s+$/.test(CODIGO)) {
                document.form_reg_dato.CODIGO.focus();
                document.form_reg_dato.CODIGO.style.borderColor = "#FF0000";
                document.getElementById('val_codigo').innerHTML = "Debe ingresar el código de autorización";
                return false;
            }
            document.form_reg_dato.CODIGO.style.borderColor = "#4AF575";

        }

        function actualizarFolio() {
            var seleccion = document.getElementById("IDEXIMATERIAPRIMA");
            var folioActual = seleccion.options[seleccion.selectedIndex].getAttribute('data-folio');
            document.getElementById("FOLIO").value = folioActual ? folioActual : "";
        }
    </script>
</head>

<body class="hold-transition light-skin fixed sidebar-mini theme-primary">
    <div class="wrapper">
        <?php include_once "../../assest/config/menuFruta.php"; ?>
        <div class="content-wrapper">
            <div class="container-full">
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="page-title">Gestión de folios</h3>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Módulo</li>
                                        <li class="breadcrumb-item" aria-current="page">Gestión de folios</li>
                                        <li class="breadcrumb-item active" aria-current="page">Materia prima</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <?php include_once "../../assest/config/verIndicadorEconomico.php"; ?>
                    </div>
                </div>
                <section class="content">
                    <div class="box">
                        <div class="box-header with-border bg-warning">
                            <h4 class="box-title">Cambiar folio de materia prima</h4>
                        </div>
                        <form class="form" role="form" method="post" name="form_reg_dato" id="form_reg_dato">
                            <div class="box-body form-element">
                                <?php if ($MENSAJE) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo htmlspecialchars($MENSAJE, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Folio en existencia</label>
                                            <select class="form-control select2" id="IDEXIMATERIAPRIMA" name="IDEXIMATERIAPRIMA" style="width: 100%" onchange="actualizarFolio();">
                                                <option value="">Seleccione un folio</option>
                                                <?php foreach ($ARRAYEXISTENCIA as $r) : ?>
                                                    <option value="<?php echo $r['ID_EXIMATERIAPRIMA']; ?>" data-folio="<?php echo htmlspecialchars($r['FOLIO_EXIMATERIAPRIMA'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $IDEXIMATERIAPRIMA == $r['ID_EXIMATERIAPRIMA'] ? 'selected' : ''; ?>>
                                                        <?php echo $r['FOLIO_EXIMATERIAPRIMA']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label id="val_folio" class="validacion"> </label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Folio actual</label>
                                            <input type="number" class="form-control" placeholder="Folio actual" id="FOLIO" name="FOLIO" value="<?php echo htmlspecialchars($FOLIO, ENT_QUOTES, 'UTF-8'); ?>" disabled style='background-color: #eeeeee;' />
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Folio nuevo</label>
                                            <input type="number" class="form-control" placeholder="Folio nuevo" id="FOLION" name="FOLION" value="<?php echo htmlspecialchars($FOLION, ENT_QUOTES, 'UTF-8'); ?>" />
                                            <label id="val_fn" class="validacion"> <?php echo htmlspecialchars($MENSAJE, ENT_QUOTES, 'UTF-8'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Código de autorización</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Ingrese código enviado" id="CODIGO" name="CODIGO" value="<?php echo htmlspecialchars($CODIGO, ENT_QUOTES, 'UTF-8'); ?>" />
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary" name="SOLICITAR" value="SOLICITAR">Solicitar código</button>
                                                </div>
                                            </div>
                                            <label id="val_codigo" class="validacion"> </label>
                                            <?php if ($MENSAJEENVIO) { ?>
                                                <small class="text-success"><?php echo htmlspecialchars($MENSAJEENVIO, ENT_QUOTES, 'UTF-8'); ?></small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                        <label>Motivo</label>
                                        <textarea class="form-control" rows="1" placeholder="Motivo del cambio" id="MOTIVO" name="MOTIVO"><?php echo htmlspecialchars($MOTIVO, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="btn-group btn-rounded btn-block col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12" role="group" aria-label="Acciones generales">
                                        <button type="button" class="btn  btn-success" data-toggle="tooltip" title="Volver" name="CANCELAR" value="CANCELAR" Onclick="irPagina('index.php');">
                                            <i class="ti-back-left "></i> Volver
                                        </button>
                                        <button type="submit" class="btn btn-warning" data-toggle="tooltip" title="Cambiar" name="CAMBIAR" value="CAMBIAR" onclick="return validacion()">
                                            <i class="ti-save-alt"></i> Cambiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <?php include_once "../../assest/config/footer.php"; ?>
        <?php include_once "../../assest/config/menuExtraFruta.php"; ?>
    </div>
    <?php include_once "../../assest/config/urlBase.php"; ?>
</body>

</html>
