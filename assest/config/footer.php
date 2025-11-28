<?php 
$api_url = 'https://mscode.cl/api/version.php?getVersionNumber'; 

// Realizar la solicitud GET a la API
$curl = curl_init($api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 5); // Timeout de 5 segundos
$api_response = curl_exec($curl);
$curl_error = curl_error($curl);
curl_close($curl);

// Decodificar la respuesta JSON y validar
$api_data = null;
$remoteVersion = "No disponible";

if (!$curl_error && $api_response !== false) {
    $api_data = json_decode($api_response, true);
    if (is_array($api_data) && isset($api_data['version'])) {
        $remoteVersion = $api_data['version'];
    }
}

$localVersion = "1.1.50";


?>
<footer class="main-footer footer-modern">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            &copy; 2025 <a href="#" class="text-muted">Desarrollado por CreativeAgro</a>. Todos los derechos reservados.
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="version-chip">
                <i class="material-icons" style="font-size:16px;">verified</i>
                <?php
                    if($remoteVersion === $localVersion){
                        echo 'Versión '.$localVersion.' · Actualizado';
                    }else{
                        echo 'Versión '.$localVersion.' · Actualización disponible';
                    }
                ?>
            </span>
            <a href="https://wa.me/56952157840" target="_blank" class="support-pill">
                <i class="ti-headphone-alt"></i> Soporte
            </a>
        </div>
    </div>
</footer>
