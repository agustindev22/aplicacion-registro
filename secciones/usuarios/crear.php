<?php 
include("../../bd.php");
if($_POST){
  
    //Recolectamos los datos del metodo post
    $usuarios=(isset($_POST["usuarios"])?$_POST["usuarios"]:"");
    $password=(isset($_POST["password"])?$_POST["password"]:"");
    $correo=(isset($_POST["correo"])?$_POST["correo"]:"");

    $sentencia=$conexion->prepare("INSERT INTO tbl_usuarios (id,usuarios,password,correo) VALUES (NULL, :usuarios, :password, :correo)"); 
    //Asignando los nombres que tiene las variables ($asuarios $password $correo)
    $sentencia->bindParam(":usuarios",$usuarios);
    $sentencia->bindParam(":password",$password);
    $sentencia->bindParam(":correo",$correo);
    $sentencia->execute();
    $mensaje="Usuario Agregado";
    header("Location:index.php?mensaje=".$mensaje);

   
}

?>



<?php include("../../templates/header.php");?>
<br/>

<main class="card ">
    <h3 class="card-header">Datos del Usuario</h3>
    <section class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <hgroup class="mb-3">
                <label for="usuarios" class="form-label">Nombre del Usuario <i class="bi bi-person-circle"></i>:</label>
                <input type="text" class="form-control" name="usuarios" id="usuarios" aria-describedby="helpId" placeholder="Nombre del Usuario" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="password" class="form-label">Password <i class="bi bi-person-fill-lock"></i>:</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    aria-describedby="helpId"
                    placeholder="Escriba su contraseña"
                />
            </hgroup>

            <hgroup class="mb-3">
                <label for="correo" class="form-label">Correo <i class="bi bi-envelope-at-fill"></i>:</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id="correo"
                    aria-describedby="helpId"
                    placeholder="Escriba su Correo"
                />
            </hgroup>
            


            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>

        </form>
    </section>
</main>

<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    body {
        background-color: #323232;
    }
    h1{
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
<?php include("../../templates/footer.php");?>