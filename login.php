<?php
session_start();
//print_r($_POST);
if ($_POST) {

    include("./bd.php");

    $sentencia = $conexion->prepare("SELECT *, count(*) as n_usuarios FROM `tbl_usuarios` WHERE usuarios=:usuarios AND password=:password");

    $usuarios = $_POST["usuarios"];
    $password = $_POST["contraseña"];

    $sentencia->bindParam(":usuarios", $usuarios);
    $sentencia->bindParam(":password", $password);


    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    if ($registro["n_usuarios"] > 0) {
        $_SESSION['usuario'] = $registro["usuarios"];
        $_SESSION['logueado'] = true;
        header("Location:index.php");
    } else {
        $mensaje = "Error el usuario o la contraseña es incorrecta";
    }
   // print_r($lista_tbl_usuarios);
}


?>


<!doctype html>
<html lang="en">

<head>
    <title>Login</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>

    </header>
    <main class="container">

        <section class="row">

            <div class="col-md-4">

            </div>

            <div class="col-md-4">

                <br />
                <article class="card">
                    <h4 class="card-header">Login</h4>
                    <div class="card-body">
                      <?php if(isset($mensaje)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $mensaje;?></strong> 
                        </div>
                        <?php }?>
                        <form action="" method="post">
                            <hgroup class="mb-3">
                                <label for="usuarios" class="form-label">Usuarios</label>
                                <input type="text" class="form-control" name="usuarios" id="usuarios" aria-describedby="helpId" placeholder="Ingresar" />
                            </hgroup>

                            <hgroup class="mb-3">
                                <label for="contraseña" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="contraseña" id="contraseña" aria-describedby="helpId" placeholder="Contraseña" />
                            </hgroup>
                            <button class="btn btn-success" type="submit">Iniciar sesion</button>
                        </form>
                    </div>
                </article>
            </div>
        </section>



    </main>
    <footer>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>