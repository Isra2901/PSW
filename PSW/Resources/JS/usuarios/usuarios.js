$(document).ready(function() {
    
    //evento de eliminar
    $('.btnEliminarRegistro').click(function(e){
        e.preventDefault();
        let idRegistro = $(this).attr('idRegistro');
        Swal.fire({
            title: "Esta Seguro?",
            text: "Se eliminará el registro "+idRegistro,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si Eliminar!"
          }).then((result) => {
        const idRegistro = $(this).attr('idRegistro');      

        $.ajax({
            url: '../../Models/funciones.php',
            type: 'POST',
            data: {
                action: 'eliminarRegistro',
                idRegistro: idRegistro
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error al eliminar el registro.');
                console.log(error);
            }
        });
          });

    });


    $('.btnDesplegarModal').click(function(e){
        e.preventDefault();
        let idRegistro = $(this).attr('idRegistro');
        
        $('#inputHiden').val(idRegistro);
        console.log("valor es:"+ $('#inputHiden').val());  
        $('#modalRegistro').modal('show');

    });


    $('#btnEditarRegistro').click(function(e){
        e.preventDefault();
        
        const idRegistro = $('#inputHiden').val();    
        let username = $('#username').val();
        let email = $('#email').val();
        let nombre = $('#nombre').val();
        let contraseña1 = $('#contraseña1').val();
        let contraseña2 = $('#contraseña2').val();


        if(username.trim() == '' || email.trim() == '' ||  nombre.trim() == '' || contraseña1.trim() == '' || contraseña2.trim() == '' ){
            Swal.fire({
                title: "Error!",
                text: "Debe llenar el formulario antes de continuar",
                icon: "info"
              });

              return 0;
        }

        if(contraseña1 != contraseña2){
            Swal.fire({
                title: "Error!",
                text: "Las contraseñas no coinciden",
                icon: "info"
              });
              return 0;
        }

        Swal.fire({
            title: "Esta Seguro?",
            text: "Se actualizará el registro "+idRegistro,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si Eliminar!"
          }).then((result) => {


            $.ajax({
                url: '../../Models/funciones.php',
                type: 'POST',
                data: {
                    action: 'actualizarRegistro',
                    idRegistro: idRegistro,
                    username: username,
                    email: email,
                    nombre: nombre,
                    contraseña:contraseña1
                },
                success: function(response) {
                    console.log(response);
                    if(response){
                        var titulo = 'Exito';
                        var mensaje = 'Registro actualizado';
                        var icono = 'success';
                    }else{

                        var titulo = 'error';
                        var mensaje = 'Registro no actualizado, propiedades duplicadas';
                        var icono = 'error';
                    }

                    Swal.fire({
                        title: titulo,
                        text: mensaje,
                        icon: icono
                      });
                },
                error: function(xhr, status, error) {
                    alert('Error al eliminar el registro.');
                    console.log(error);
                }
            });
          });

    });





});