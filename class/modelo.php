<?php
require_once('db.php');

class modeloCredencialesBD {
    protected $_db;

    public function __construct() {
        $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->_db->connect_errno) {
            echo "Fallo al conectar a la base de datos: " . $this->_db->connect_error;
            return;
        }
    }

    public function __destruct() {
        if ($this->_db) {
            $this->_db->close();
        }
    }
}
?>
