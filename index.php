<?php include("templates/header.php");?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="libreria/img/php-icon.png" type="image/x-icon">
    <title>Aplicacion PHP</title>
   </head>
   <body>
    
        <br/>
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <p>Bievenid@ <?php echo $_SESSION['usuario'];?></p>
                <h1 class="display-5 fw-bold">Soy Agustin Martinez</h1>
                <p class="col-md-8 fs-4">
                Esto es una practica de PHP con una Base de datos, es un registro de empleados . Que tiene secciones como Empleados, Puestos y Usuarios.
                Ademas se puede editar, egregar o eliminar en cada una de las secciones .
                Por ultimo tiene Abrir y Cerrar sesion.
                </p>
                <button class="btn btn-dark btn-lg" type="button">
                   <a href="https://github.com/agustindev22" target="_blank">Mi github</a>
                </button>
            </div>
        </div>
        </body>
   </html>


                            <!-- ESTILO CSS MALA PRACTICA  -->
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

    body {
        background-color: #323232;
    }

   button a{
    color: whitesmoke;
   }

    footer a {
        color: whitesmoke;
        text-align: center;
        font-size: 20px;
    }

    footer {
        display: flex;
        justify-content: center;
    }
</style>
<?php include("templates/footer.php");?>
   