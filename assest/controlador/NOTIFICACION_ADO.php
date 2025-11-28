<?php
//INICIALIZAR VARIABLES
$HOST="";
$DBNAME="";
$USER="";
$PASS="";

//ESTRUCTURA DEL CONTROLADOR
class NOTIFICACION_ADO {

    //ATRIBUTO
    private $conexion;

    //LLAMADO A LA BD Y CONFIGURAR PARAMETROS
    public function __CONSTRUCT()
    {
        try
        {
            $BDCONFIG = new BDCONFIG();
            $HOST = $BDCONFIG->__GET('HOST');
            $DBNAME = $BDCONFIG->__GET('DBNAME');
            $USER = $BDCONFIG->__GET('USER');
            $PASS = $BDCONFIG->__GET('PASS');

            $this->conexion = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME, $USER ,$PASS);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->crearTablaNotificaciones();

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    private function crearTablaNotificaciones(){
        $sql = "CREATE TABLE IF NOT EXISTS usuario_notificacion (
            ID_NOTIFICACION INT AUTO_INCREMENT PRIMARY KEY,
            MENSAJE TEXT NOT NULL,
            DESTINO_TIPO VARCHAR(20) NOT NULL,
            DESTINO_ID INT NULL,
            PRIORIDAD TINYINT DEFAULT 2,
            FECHA_INICIO DATE NULL,
            FECHA_FIN DATE NULL,
            LEIDO TINYINT DEFAULT 0,
            INGRESO DATETIME DEFAULT CURRENT_TIMESTAMP,
            MODIFICACION DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            ESTADO_REGISTRO TINYINT DEFAULT 1,
            ID_USUARIOI INT NULL,
            ID_USUARIOM INT NULL,
            INDEX idx_destino (DESTINO_TIPO, DESTINO_ID),
            INDEX idx_estado (ESTADO_REGISTRO)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->conexion->exec($sql);
    }

    //FUNCIONES BASICAS
    public function listarNotificaciones(){
        try{
            $datos=$this->conexion->prepare("SELECT * FROM usuario_notificacion ORDER BY INGRESO DESC;");
            $datos->execute();
            $resultado = $datos->fetchAll();
            $datos=null;
            return $resultado;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function listarNotificacionesActivas($idUsuario, $idEmpresa, $idPlanta){
        try{
            $datos=$this->conexion->prepare(
                "SELECT * FROM usuario_notificacion 
                  WHERE ESTADO_REGISTRO = 1
                  AND (FECHA_INICIO IS NULL OR FECHA_INICIO <= CURDATE())
                  AND (FECHA_FIN IS NULL OR FECHA_FIN >= CURDATE())
                  AND (
                      (DESTINO_TIPO = 'usuario' AND DESTINO_ID = :usuario)
                      OR (DESTINO_TIPO = 'planta' AND DESTINO_ID = :planta)
                      OR (DESTINO_TIPO = 'empresa' AND DESTINO_ID = :empresa)
                  )
                  ORDER BY PRIORIDAD ASC, INGRESO DESC
                  LIMIT 8;"
            );
            $datos->execute(array(
                ':usuario' => $idUsuario,
                ':planta' => $idPlanta,
                ':empresa' => $idEmpresa
            ));
            $resultado = $datos->fetchAll();
            $datos=null;
            return $resultado;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function verNotificacion($ID){
        try{
            $datos=$this->conexion->prepare("SELECT * FROM usuario_notificacion WHERE ID_NOTIFICACION = :id;");
            $datos->execute([':id' => $ID]);
            $resultado = $datos->fetchAll();
            $datos=null;
            return $resultado;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function agregarNotificacion(NOTIFICACION $NOTIFICACION){
        try{
            $query = "INSERT INTO usuario_notificacion (
                        MENSAJE, DESTINO_TIPO, DESTINO_ID,
                        PRIORIDAD, FECHA_INICIO, FECHA_FIN,
                        ID_USUARIOI, ID_USUARIOM
                    ) VALUES (?,?,?,?,?,?,?,?);";
            $this->conexion->prepare($query)
                ->execute(array(
                    $NOTIFICACION->__GET('MENSAJE'),
                    $NOTIFICACION->__GET('DESTINO_TIPO'),
                    $NOTIFICACION->__GET('DESTINO_ID'),
                    $NOTIFICACION->__GET('PRIORIDAD'),
                    $NOTIFICACION->__GET('FECHA_INICIO'),
                    $NOTIFICACION->__GET('FECHA_FIN'),
                    $NOTIFICACION->__GET('ID_USUARIOI'),
                    $NOTIFICACION->__GET('ID_USUARIOM')
                ));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarNotificacion(NOTIFICACION $NOTIFICACION){
        try{
            $query = "UPDATE usuario_notificacion SET
                        MENSAJE = ?,
                        DESTINO_TIPO = ?,
                        DESTINO_ID = ?,
                        PRIORIDAD = ?,
                        FECHA_INICIO = ?,
                        FECHA_FIN = ?,
                        MODIFICACION = SYSDATE(),
                        ID_USUARIOM = ?
                      WHERE ID_NOTIFICACION = ?;";
            $this->conexion->prepare($query)
                ->execute(array(
                    $NOTIFICACION->__GET('MENSAJE'),
                    $NOTIFICACION->__GET('DESTINO_TIPO'),
                    $NOTIFICACION->__GET('DESTINO_ID'),
                    $NOTIFICACION->__GET('PRIORIDAD'),
                    $NOTIFICACION->__GET('FECHA_INICIO'),
                    $NOTIFICACION->__GET('FECHA_FIN'),
                    $NOTIFICACION->__GET('ID_USUARIOM'),
                    $NOTIFICACION->__GET('ID_NOTIFICACION')
                ));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function deshabilitar(NOTIFICACION $NOTIFICACION){
        try{
            $query = "UPDATE usuario_notificacion SET ESTADO_REGISTRO = 0 WHERE ID_NOTIFICACION = ?;";
            $this->conexion->prepare($query)
                ->execute(array($NOTIFICACION->__GET('ID_NOTIFICACION')));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function habilitar(NOTIFICACION $NOTIFICACION){
        try{
            $query = "UPDATE usuario_notificacion SET ESTADO_REGISTRO = 1 WHERE ID_NOTIFICACION = ?;";
            $this->conexion->prepare($query)
                ->execute(array($NOTIFICACION->__GET('ID_NOTIFICACION')));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}
?>
