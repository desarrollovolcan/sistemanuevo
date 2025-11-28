<?php
include_once "../../assest/config/validarUsuarioExpo.php";
include_once "../../assest/controlador/USUARIO_ADO.php";
include_once "../../assest/controlador/EMPRESA_ADO.php";
include_once "../../assest/controlador/PLANTA_ADO.php";
include_once "../../assest/controlador/NOTIFICACION_ADO.php";
include_once "../../assest/modelo/NOTIFICACION.php";

$USUARIO_ADO = new USUARIO_ADO();
$EMPRESA_ADO = new EMPRESA_ADO();
$PLANTA_ADO = new PLANTA_ADO();
$NOTIFICACION_ADO = new NOTIFICACION_ADO();
$NOTIFICACION = new NOTIFICACION();

$ARRAYNOTIFICACIONES = $NOTIFICACION_ADO->listarNotificaciones();
$ARRAYUSUARIOS = $USUARIO_ADO->listarUsuarioCBX();
$ARRAYEMPRESAS = $EMPRESA_ADO->listarEmpresaCBX();
$ARRAYPLANTAS = $PLANTA_ADO->listarPlantaCBX();

$IDOP = "";
$OP = "";
$MENSAJE = "";
$DESTINO_TIPO = "usuario";
$DESTINO_ID = "";
$PRIORIDAD = 2;
$FECHA_INICIO = "";
$FECHA_FIN = "";
$DISABLED = "";

if (isset($_GET["id"])) {
    $IDOP = $_GET["id"];
}
if (isset($_GET["a"])) {
    $OP = $_GET["a"];
}

if ($OP == "editar" && $IDOP) {
    $ARRAYEDIT = $NOTIFICACION_ADO->verNotificacion($IDOP);
    if ($ARRAYEDIT) {
        $MENSAJE = $ARRAYEDIT[0]['MENSAJE'];
        $DESTINO_TIPO = $ARRAYEDIT[0]['DESTINO_TIPO'];
        $DESTINO_ID = $ARRAYEDIT[0]['DESTINO_ID'];
        $PRIORIDAD = $ARRAYEDIT[0]['PRIORIDAD'];
        $FECHA_INICIO = $ARRAYEDIT[0]['FECHA_INICIO'];
        $FECHA_FIN = $ARRAYEDIT[0]['FECHA_FIN'];
    }
}

if ($OP == "deshabilitar" && $IDOP) {
    $NOTIFICACION->__SET('ID_NOTIFICACION', $IDOP);
    $NOTIFICACION_ADO->deshabilitar($NOTIFICACION);
    echo "<script type='text/javascript'> location.href ='registroNotificacion.php';</script>";
}
if ($OP == "habilitar" && $IDOP) {
    $NOTIFICACION->__SET('ID_NOTIFICACION', $IDOP);
    $NOTIFICACION_ADO->habilitar($NOTIFICACION);
    echo "<script type='text/javascript'> location.href ='registroNotificacion.php';</script>";
}

if ($_POST) {
    if (isset($_REQUEST['MENSAJE'])) {
        $MENSAJE = $_REQUEST['MENSAJE'];
    }
    if (isset($_REQUEST['DESTINO_TIPO'])) {
        $DESTINO_TIPO = $_REQUEST['DESTINO_TIPO'];
    }
    if (isset($_REQUEST['DESTINO_ID'])) {
        $DESTINO_ID = $_REQUEST['DESTINO_ID'];
    }
    if (isset($_REQUEST['PRIORIDAD'])) {
        $PRIORIDAD = $_REQUEST['PRIORIDAD'];
    }
    if (isset($_REQUEST['FECHA_INICIO'])) {
        $FECHA_INICIO = $_REQUEST['FECHA_INICIO'];
    }
    if (isset($_REQUEST['FECHA_FIN'])) {
        $FECHA_FIN = $_REQUEST['FECHA_FIN'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Notificaciones</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include_once "../../assest/config/urlHead.php"; ?>
</head>

<body class="hold-transition light-skin fixed sidebar-mini theme-primary">
    <div class="wrapper">
        <?php include_once "../../assest/config/menuExpo.php"; ?>
        <div class="content-wrapper">
            <div class="container-full">
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="page-title">Centro de notificaciones</h3>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"> <a href="index.php"> <i class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Módulo</li>
                                        <li class="breadcrumb-item active" aria-current="page"> Notificaciones</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="row">
                        <div class="col-xl-4 col-lg-12">
                            <div class="box box-solid bg-primary" style="border-radius: 14px;">
                                <div class="box-header with-border">
                                    <h4 class="box-title text-white mb-0"><?php echo $OP == "editar" ? "Editar notificación" : "Nueva notificación"; ?></h4>
                                </div>
                                <div class="box-body" style="background: linear-gradient(135deg,#1e293b,#0f172a); color:#e2e8f0;">
                                    <form class="form" method="post">
                                        <div class="form-group">
                                            <label>Mensaje</label>
                                            <textarea class="form-control" name="MENSAJE" id="MENSAJE" rows="3" placeholder="Escribe el mensaje de la notificación" required><?php echo $MENSAJE; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de destino</label>
                                            <select class="form-control" name="DESTINO_TIPO" id="DESTINO_TIPO" onchange="this.form.submit()">
                                                <option value="usuario" <?php if ($DESTINO_TIPO=="usuario") {echo "selected";} ?>>Usuario específico</option>
                                                <option value="planta" <?php if ($DESTINO_TIPO=="planta") {echo "selected";} ?>>Planta específica</option>
                                                <option value="empresa" <?php if ($DESTINO_TIPO=="empresa") {echo "selected";} ?>>Empresa específica</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Destino</label>
                                            <select class="form-control select2" name="DESTINO_ID" id="DESTINO_ID" required>
                                                <option value="">Seleccione</option>
                                                <?php if($DESTINO_TIPO=="usuario"){ foreach ($ARRAYUSUARIOS as $r) { ?>
                                                    <option value="<?php echo $r['ID_USUARIO']; ?>" <?php if($DESTINO_ID==$r['ID_USUARIO']){ echo "selected"; } ?>><?php echo $r['NOMBRE_COMPLETO']; ?></option>
                                                <?php }} ?>
                                                <?php if($DESTINO_TIPO=="planta"){ foreach ($ARRAYPLANTAS as $r) { ?>
                                                    <option value="<?php echo $r['ID_PLANTA']; ?>" <?php if($DESTINO_ID==$r['ID_PLANTA']){ echo "selected"; } ?>><?php echo $r['NOMBRE_PLANTA']; ?></option>
                                                <?php }} ?>
                                                <?php if($DESTINO_TIPO=="empresa"){ foreach ($ARRAYEMPRESAS as $r) { ?>
                                                    <option value="<?php echo $r['ID_EMPRESA']; ?>" <?php if($DESTINO_ID==$r['ID_EMPRESA']){ echo "selected"; } ?>><?php echo $r['NOMBRE_EMPRESA']; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Prioridad</label>
                                                <select class="form-control" name="PRIORIDAD" id="PRIORIDAD">
                                                    <option value="1" <?php if($PRIORIDAD==1){ echo "selected";} ?>>Alta</option>
                                                    <option value="2" <?php if($PRIORIDAD==2){ echo "selected";} ?>>Media</option>
                                                    <option value="3" <?php if($PRIORIDAD==3){ echo "selected";} ?>>Baja</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Vigencia</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <input type="date" class="form-control" name="FECHA_INICIO" value="<?php echo $FECHA_INICIO; ?>">
                                                    <input type="date" class="form-control" name="FECHA_FIN" value="<?php echo $FECHA_FIN; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right mt-3">
                                            <a href="registroNotificacion.php" class="btn btn-secondary">Cancelar</a>
                                            <?php if($OP=="editar"){ ?>
                                                <button type="submit" class="btn btn-warning" name="ACTUALIZAR" value="ACTUALIZAR">Actualizar</button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-success" name="GUARDAR" value="GUARDAR">Guardar</button>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Notificaciones creadas</h4>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="notificaciones" class="table table-hover" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Mensaje</th>
                                                    <th>Destino</th>
                                                    <th>Prioridad</th>
                                                    <th>Vigencia</th>
                                                    <th>Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ARRAYNOTIFICACIONES as $r) : ?>
                                                    <?php
                                                        $prioridadTexto = $r['PRIORIDAD']==1 ? 'Alta' : ($r['PRIORIDAD']==3 ? 'Baja' : 'Media');
                                                        $prioridadClase = $r['PRIORIDAD']==1 ? 'badge-danger' : ($r['PRIORIDAD']==3 ? 'badge-success' : 'badge-warning');
                                                        $estado = $r['ESTADO_REGISTRO']==1 ? 'Activo' : 'Inactivo';
                                                        $estadoClase = $r['ESTADO_REGISTRO']==1 ? 'bg-success' : 'bg-danger';
                                                        $destinoLabel = ucfirst($r['DESTINO_TIPO']).' #'.$r['DESTINO_ID'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $r['MENSAJE']; ?></td>
                                                        <td><?php echo $destinoLabel; ?></td>
                                                        <td><span class="badge <?php echo $prioridadClase; ?>"><?php echo $prioridadTexto; ?></span></td>
                                                        <td><?php echo $r['FECHA_INICIO']; ?> - <?php echo $r['FECHA_FIN']; ?></td>
                                                        <td><span class="badge <?php echo $estadoClase; ?>"><?php echo $estado; ?></span></td>
                                                        <td class="text-center">
                                                            <a href="registroNotificacion.php?id=<?php echo $r['ID_NOTIFICACION']; ?>&a=editar" class="btn btn-xs btn-primary">Editar</a>
                                                            <?php if($r['ESTADO_REGISTRO']==1){ ?>
                                                                <a href="registroNotificacion.php?id=<?php echo $r['ID_NOTIFICACION']; ?>&a=deshabilitar" class="btn btn-xs btn-warning">Deshabilitar</a>
                                                            <?php }else{ ?>
                                                                <a href="registroNotificacion.php?id=<?php echo $r['ID_NOTIFICACION']; ?>&a=habilitar" class="btn btn-xs btn-success">Habilitar</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
        <?php include_once "../../assest/config/menuExtraExpo.php"; ?>
    </div>
    <?php include_once "../../assest/config/urlBase.php"; ?>
    <script>
      $(document).ready(function(){
        $('#notificaciones').DataTable();
      });
    </script>
</body>
</html>
<?php
//Acciones del formulario
if (isset($_REQUEST['GUARDAR'])) {
    $NOTIFICACION->__SET('MENSAJE', $MENSAJE);
    $NOTIFICACION->__SET('DESTINO_TIPO', $DESTINO_TIPO);
    $NOTIFICACION->__SET('DESTINO_ID', $DESTINO_ID);
    $NOTIFICACION->__SET('PRIORIDAD', $PRIORIDAD);
    $NOTIFICACION->__SET('FECHA_INICIO', $FECHA_INICIO ? $FECHA_INICIO : null);
    $NOTIFICACION->__SET('FECHA_FIN', $FECHA_FIN ? $FECHA_FIN : null);
    $NOTIFICACION->__SET('ID_USUARIOI', $IDUSUARIOS);
    $NOTIFICACION->__SET('ID_USUARIOM', $IDUSUARIOS);
    $NOTIFICACION_ADO->agregarNotificacion($NOTIFICACION);
    echo '<script>Swal.fire({ icon:"success", title:"Notificación creada", timer:2000, showConfirmButton:false}).then(()=>{location.href="registroNotificacion.php";});</script>';
}
if (isset($_REQUEST['ACTUALIZAR'])) {
    $NOTIFICACION->__SET('ID_NOTIFICACION', $IDOP);
    $NOTIFICACION->__SET('MENSAJE', $MENSAJE);
    $NOTIFICACION->__SET('DESTINO_TIPO', $DESTINO_TIPO);
    $NOTIFICACION->__SET('DESTINO_ID', $DESTINO_ID);
    $NOTIFICACION->__SET('PRIORIDAD', $PRIORIDAD);
    $NOTIFICACION->__SET('FECHA_INICIO', $FECHA_INICIO ? $FECHA_INICIO : null);
    $NOTIFICACION->__SET('FECHA_FIN', $FECHA_FIN ? $FECHA_FIN : null);
    $NOTIFICACION->__SET('ID_USUARIOM', $IDUSUARIOS);
    $NOTIFICACION_ADO->actualizarNotificacion($NOTIFICACION);
    echo '<script>Swal.fire({ icon:"success", title:"Notificación actualizada", timer:2000, showConfirmButton:false}).then(()=>{location.href="registroNotificacion.php";});</script>';
}
?>
