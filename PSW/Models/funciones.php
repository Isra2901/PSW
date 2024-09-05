<?php 

require_once 'Conexion.php'; 
$conexion = new Conexion();

// Obtener la acción del formulario
$action = isset($_POST['action']) ? $_POST['action'] : '';

//validacion para loguearses
if ($action === 'login') {

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if ($conexion->login($username, $password)) {
        header('Location: ../Resources/Views/usuarios.php'); 
        exit;
    } else {
        echo "Login fallido. Usuario o contraseña incorrectos.";
    }

} elseif ($action === 'crearRegistro') {
    
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';


    $conexion->crearUsuario($username, $email, $nombre, $contraseña);
    

} 
//validacion para eliminar usuarios
elseif ($action === 'eliminarRegistro') {
    $idRegistro = isset($_POST['idRegistro']) ? intval($_POST['idRegistro']) : 0;

    if ($idRegistro > 0) {        
        $conexion->eliminarRegistro($idRegistro);
    } else {
        echo "ID de registro inválido.";
    }

}
//validacion para crear usuarios
elseif ($action === 'actualizarRegistro') {
    $idRegistro = isset($_POST['idRegistro']) ? intval($_POST['idRegistro']) : 0;
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';


    if ($idRegistro > 0) {        
        $conexion->actualizarRegistro($idRegistro,$username,$nombre,$email,md5($contraseña));
    } else {
        echo "ID de registro inválido.";
    }

}

//Mensaje por default
else {
    echo "Acción no reconocida.";
}

$conexion->close();  // Cerramso la conexxion
?>
