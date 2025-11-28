<?php
/*
* MODELO DE CLASE DE LA ENTIDAD  NOTIFICACION
*/

//ESTRUCTURA DE LA CLASE
class NOTIFICACION {

    //ATRIBUTOS DE LA CLASE
    private $ID_NOTIFICACION;
    private $MENSAJE;
    private $DESTINO_TIPO;
    private $DESTINO_ID;
    private $PRIORIDAD;
    private $FECHA_INICIO;
    private $FECHA_FIN;
    private $LEIDO;
    private $INGRESO;
    private $MODIFICACION;
    private $ESTADO_REGISTRO;
    private $ID_USUARIOI;
    private $ID_USUARIOM;

    //FUNCIONES GET Y SET
    public function __GET($k){ return $this->$k; }
    public function __SET($k, $v){ return $this->$k = $v; }
}
?>
