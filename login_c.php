<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fruticola Volcan</title>

    <link rel="icon" href="./assest/img/favicon.png">

    <!-- Estilo base -->
    <link rel="stylesheet" type="text/css" href="./assest/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="./assest/css/style.css" />

    <!-- Custom styles -->
    <link rel="stylesheet" href="./assest/css/loginv2.css">
    <link rel="stylesheet" href="./assest/css/login-modern.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./api/bootstrap/css/bootstrap.css" />

    <!-- JS -->
    <script src="./assest/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="./api/bootstrap/js/bootstrap.min.js"></script>

    <!-- sweetalert -->
    <script src="./assest/js/sweetalert2@11.js"></script>

</head>

<body class="login-modern light-skin">
    <div class="container py-4 login-modern">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="card login-modern-card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="brand">
                            <img src="./assest/img/favicon.png" alt="" height="26px">
                            <span>Inicio de sesión</span>
                        </div>
                        <small class="text-muted">Acceso a los módulos</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-5">
                                <div class="login-sidebar h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="./assest/img/volcan-foods-logo-original.png" alt="" height="42px" class="mr-2">
                                        <div>
                                            <p class="mb-1 text-uppercase text-muted" style="letter-spacing: .08em; font-weight: 700;">Frutícola Volcán</p>
                                            <h6 class="mb-0">Control de accesos por módulo</h6>
                                        </div>
                                    </div>
                                    <ul class="privilege-list">
                                        <li>Usuarios habilitados en el módulo</li>
                                        <li>Perfiles y roles vigentes</li>
                                        <li>Operaciones con permisos activos</li>
                                    </ul>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="module-pill"><span class="dot-fruta"></span>Fruta</span>
                                        <span class="module-pill"><span class="dot-material"></span>Materiales</span>
                                        <span class="module-pill"><span class="dot-export"></span>Exportadora</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <!-- Tabs para seleccionar el tipo de login -->
                                <ul class="nav nav-tabs mb-3" id="loginTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="fruta-tab" data-toggle="tab" href="#fruta" role="tab" aria-controls="fruta" aria-selected="true">Fruta</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="materiales-tab" data-toggle="tab" href="#materiales" role="tab" aria-controls="materiales" aria-selected="false">Materiales</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="exportadora-tab" data-toggle="tab" href="#exportadora" role="tab" aria-controls="exportadora" aria-selected="false">Exportadora</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="loginTabContent">
                                    <div class="tab-pane fade show active" id="fruta" role="tabpanel" aria-labelledby="fruta-tab">
                                        <form class="form" role="form" id="loginForm_fruta" name="form_reg_dato">
                                            <input type="hidden" class="form-control" id="MODULO_FRUTA" name="MODULO" value="fruta">
                                            <div class="form-group">
                                                <label for="NOMBRE_FRUTA" class="form-label">Nombre de usuario</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Ingresa tu usuario" id="NOMBRE_FRUTA" name="NOMBRE" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-user"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="CONTRASENA_FRUTA" class="form-label">Contraseña</label>
                                                <div class="input-group mb-4">
                                                    <input type="password" class="form-control" placeholder="********" id="CONTRASENA_FRUTA" name="CONTRASENA" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4" id="ENTRAR" name="ENTRAR">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="materiales" role="tabpanel" aria-labelledby="materiales-tab">
                                        <form class="form" role="form" id="loginForm_material" name="form_reg_dato">
                                            <input type="hidden" class="form-control" id="MODULO_MATERIAL" name="MODULO" value="material">
                                            <div class="form-group">
                                                <label for="NOMBRE_MATERIAL" class="form-label">Nombre de usuario</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Ingresa tu usuario" id="NOMBRE_MATERIAL" name="NOMBRE" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-user"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="CONTRASENA_MATERIAL" class="form-label">Contraseña</label>
                                                <div class="input-group mb-4">
                                                    <input type="password" class="form-control" placeholder="********" id="CONTRASENA_MATERIAL" name="CONTRASENA" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4" id="ENTRAR" name="ENTRAR">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="exportadora" role="tabpanel" aria-labelledby="exportadora-tab">
                                        <form class="form" role="form" id="loginForm_exportadora" name="form_reg_dato">
                                            <input type="hidden" class="form-control" id="MODULO_EXPORTADORA" name="MODULO" value="exportadora">
                                            <div class="form-group">
                                                <label for="NOMBRE_EXPORTADORA" class="form-label">Nombre de usuario</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Ingresa tu usuario" id="NOMBRE_EXPORTADORA" name="NOMBRE" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-user"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="CONTRASENA_EXPORTADORA" class="form-label">Contraseña</label>
                                                <div class="input-group mb-4">
                                                    <input type="password" class="form-control" placeholder="********" id="CONTRASENA_EXPORTADORA" name="CONTRASENA" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4" id="ENTRAR" name="ENTRAR">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<script>
        function registerLoginHandler(formId, nameId, passwordId, moduleId) {
            const form = document.getElementById(formId);
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const nombreUsuario = document.getElementById(nameId).value;
                const contrasena = document.getElementById(passwordId).value;
                const modulo = document.getElementById(moduleId).value;

                const formData = new FormData();
                formData.append("NOMBRE", nombreUsuario);
                formData.append("CONTRASENA", contrasena);
                formData.append("ENTRAR", "ENTRAR");

                fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error("Error en el inicio de sesión");
                })
                .then(() => {
                    window.location.href = "./" + modulo + "/vista/iniciarSession.php";
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Fallo en el inicio de sesión");
                });
            });
        }

        registerLoginHandler("loginForm_fruta", "NOMBRE_FRUTA", "CONTRASENA_FRUTA", "MODULO_FRUTA");
        registerLoginHandler("loginForm_material", "NOMBRE_MATERIAL", "CONTRASENA_MATERIAL", "MODULO_MATERIAL");
        registerLoginHandler("loginForm_exportadora", "NOMBRE_EXPORTADORA", "CONTRASENA_EXPORTADORA", "MODULO_EXPORTADORA");
</script>
