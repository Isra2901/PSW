<?php
require_once('../../Models/Conexion.php');
$conexion = new Conexion();

$jsonUsuarios = $conexion->MostarUsuarios();

$jsonFinal = json_decode($jsonUsuarios);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../JS/usuarios/usuarios.js"></script>
    <title>Usuarios</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 table-responsive">  
                 
                    <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Update</th>                    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jsonFinal as $row) {
                        ?> 
                            <tr>
                                <td><?php echo $row->id?></td>            
                                <td><?php echo $row->username?></td>
                                <td><?php echo $row->nombre?></td>
                                <td><?php echo $row->email?></td>
                                <td><?php echo $row->password_hash?></td>   
                                <td>
                                <button type="button" class="btn btn-primary btnDesplegarModal" idRegistro='<?php echo $row->id?>' data-bs-toggle="modal" data-bs-target="#modalRegistro">
                                    Editar
                                </button>
                                    <form action="../../Models/funciones.php" method = "post" id="formEliminar">
                                        <button type="submit" class="btn btn-secondary btnEliminarRegistro" name="action" value="eliminarRegistro"  idRegistro='<?php echo $row->id?>'>Eliminar</button>
                                    </form>
                                </td>   
                                        
                            </tr>    
                            
                        <?php    
                        }
                        ?>
                    </tbody>
                    </table>
                
            </div>    
        </div>    
    </div>



    
  <!-- Modal -->
  <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">registro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <h3 class="text-center mb-4 mt-3">Ingrese los siguientes datos:</h3>
            <form action="../../Models/funciones.php" method="post" class="form-card px-3 py-1" id="formulario_registro">
                <div class="form-row mb-3">
                    <div class="col-md-12 d-flex flex-wrap justify-content-around">
                    <div class="col-md-12 mb-3">
                            <label for="IngresarNombre" class="form-control-label px-3">Nombre:</label>
                            <input type="text" class="form-control" name="nombre"  id="nombre" placeholder="Usuario" required>
                        </div>
        
                        <div class="col-md-4 mb-3">
                            <label for="IngresarNombre" class="form-control-label px-3">usuario:</label>
                            <input type="text" class="form-control" name="inputUsuario" id="username" placeholder="Usuario" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ingresarCorreo" class="form-control-label px-3">Correo:</label>
                            <input type="mail" class="form-control" name="inputCorreo" id="email" placeholder="Correo" required>
        
                        </div>
                    </div>
        
        
                </div>
        
                <div class="form-row mb-3">
                    <div class="col-md-12 d-flex flex-wrap justify-content-around">
        
                        <div class="col-md-4 mb-3">
                            <label for="pass" class="form-control-label px-3">Contraseña:</label>
                            <input type="password" class="form-control" name="inputContra" id="contraseña1" placeholder="Contraseña" required>
                        </div>
                        <div class="col-md-4">
                            <label for="ingresarCorreo" class="form-control-label px-3">Contraseña:</label>
                            <input type="password" class="form-control" name="inputContraValida" id="contraseña2" placeholder="Contraseña" required>
        
                        </div>
                    </div>
        
                </div>
        
              
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnEditarRegistro" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden"  id="inputHiden">
        

</body>
</html>
