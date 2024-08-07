<?php
require_once('modelo.php');

class funciones extends modeloCredencialesBD {
    public function __construct() {
        parent::__construct();
    }

    public function obtener_todo($cadena) {
        $query = "CALL sp_" . "$cadena";
        $consulta = $this->_db->query($query);

        if ($consulta) {
            $resultado = $consulta->fetch_all(MYSQLI_ASSOC);
            $consulta->close();
            return $resultado;
        } else {
            return array();
        }
    }

    public function verificar_login($username, $password) {
        $query = "CALL sp_verificar_login('$username')";
        $result = $this->_db->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_hash = $row['contrasena'];
    
            // Verificar la contraseña utilizando password_verify
            if (password_verify($password, $stored_hash)) {
                $result->close(); 
                return true;
            }
        }
    
        return false;
    }

    public function registrar_usuario($id_cedula, $nombre, $username, $password) {
        // Hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "CALL sp_registrar(?, ?, ?, ?)";
        $stmt = $this->_db->prepare($query);
        $stmt->bind_param("ssss", $id_cedula, $nombre, $username, $hashed_password);
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }

    public function registrar_cliente($id_cedula, $nombre, $telefono, $correo) {
        $query = "CALL sp_registrar_cliente(?, ?, ?, ?)";
        $stmt = $this->_db->prepare($query);
        $stmt->bind_param("ssss", $id_cedula, $nombre, $telefono, $correo);
        $result = $stmt->execute();
        $stmt->close(); 
    
        return $result;
    }

    public function insertar_prestamo($cedula_cliente, $cantidad_prestada, $interes, $plazo) {
        $query = "CALL sp_insertar_prestamo(?, ?, ?, ?)";
        $stmt = $this->_db->prepare($query);
        $stmt->bind_param("sssi", $cedula_cliente, $cantidad_prestada, $interes, $plazo);
        $result = $stmt->execute();
        $stmt->close(); 

        return $result;
    }

    public function buscar_todo($cadena, $search, $search_field) {
        $procedure = "CALL sp_buscar_"."$cadena('$search', '$search_field')";
        $consulta = $this->_db->query($procedure);

        if ($consulta) {
            $resultados = $consulta->fetch_all(MYSQLI_ASSOC);
            $consulta->close(); 
            return $resultados;
        } else {
            return array();
        }
    }

    public function insertar_pago($cedula_cliente, $capital, $interes) {
        $query = "CALL sp_prueba(?, ?, ?)";
        $stmt = $this->_db->prepare($query);
        $stmt->bind_param("sdd", $cedula_cliente, $capital, $interes);
        $result = $stmt->execute();

        if (!$result) {
            echo "Error al ejecutar el procedimiento almacenado: " . $stmt->error;
        }

        $stmt->close(); 
        return $result;
    }

    public function getUserEmail($username) {
        $query = "CALL sp_get_user_email(?)";
        $stmt = $this->_db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close(); 

        return $email;
    }
}

?>
