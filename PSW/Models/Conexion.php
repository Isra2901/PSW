<?php
class Conexion {
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $dbname = "psw";
    private $conn;

    //Establecemos la conexion
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para insertar un usuario
    public function crearUsuario( $username, $email, $nombre, $password_hash, $role_id = 0) {
        $tipo = 1;
        $hash = md5($password_hash);
        $stmt = $this->conn->prepare("CALL CRUD_PSW(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $tipo, $username, $email, $nombre, $password_hash, $role_id);

        if ($stmt->execute()) {
            echo "Nuevo registro insertado correctamente";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Método para validar el login de un usuario
    public function login($username, $password) {
        $password=md5($password);
        $stmt = $this->conn->prepare("SELECT password_hash FROM PSW.users WHERE TRIM(email) = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($password_hash);
            $stmt->fetch();

            return $password == $password_hash ? true:false; 
        } else {
            return false; 
        }

        $stmt->close();
    }

    //Metodo para eliminar usuarios
    public function eliminarRegistro($role_id) {
        $tipo = 3;
        $stmt = $this->conn->prepare("CALL CRUD_PSW(?, '','','','', ?)");
        $stmt->bind_param("ii", $tipo, $role_id);
        if ($stmt->execute()) {
            echo "Registro eliminado";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    //Metodo para actualozar usuarios
    public function actualizarRegistro($idRegistro,$username,$nombre,$email,$contraseña) {
       
       try{
        $tipo = 4;
        $stmt = $this->conn->prepare("CALL CRUD_PSW(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $tipo,$username,$email,$nombre,$contraseña,$idRegistro);
        if ($stmt->execute()) {
            echo "Registro eliminado";
        } else {
            echo "tssssss: " . $stmt->error;
        }

       }catch(Exception $e){
        echo "Llaves duplicadas";

       }

        $stmt->close();
    }
       

    //meotodso para mostrar los usuarios
    public function MostarUsuarios() {
        $tipo = 2; // Tipo 2 para consultar todos los usuarios
        $stmt = $this->conn->prepare("CALL CRUD_PSW(?,'','','','',1)");
        $stmt->bind_param("i", $tipo,);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $users = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; 
            }
        } else {
            $users[] = ["message" => "No se encontraron registros."];
        }

        // Convertir el array a JSON y devolverlo        
        return json_encode($users);

        $stmt->close();
    }



    // Método para cerrar la conexión
    public function close() {
        $this->conn->close();
    }
}
?>
