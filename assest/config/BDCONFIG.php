<?php
class BDCONFIG {

    private $HOST;
    private $USER;
    private $PASS;
    private $DBNAME;
    private $PORT;

    public function __construct()
    {
        $this->HOST = getenv('DB_HOST') ?: '190.13.179.171';
        $this->USER = getenv('DB_USER') ?: 'sm_produccion';
        $this->PASS = getenv('DB_PASS') ?: 'D6zZPo9cS*5DXW@S';
        $this->DBNAME = getenv('DB_NAME') ?: 'smartberry_produccion';
        $this->PORT = getenv('DB_PORT') ?: '3306';
    }

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        $this->$k = $v;
    }

    public function conectar() {
        try {
            $dsn = "mysql:host={$this->HOST};port={$this->PORT};dbname={$this->DBNAME};charset=utf8mb4";
            $link = new PDO($dsn, $this->USER, $this->PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 15,
            ]);
            return $link;
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            return null;
        }
    }
}
