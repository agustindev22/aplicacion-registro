<?php
include("../../bd.php"); //se conecta a nuestra base de datos , que esta en bd.php

if(isset($_GET['txtID'])){  // ES PARA ELIMINAR LOS USUARIOS AÑADIDOS 
    $txtID=(($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute(); 
    
    header("Location:index.php");

}



$sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
$sentencia->execute();
$lista_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);



?>
<?php include("../../templates/header.php"); ?>
<br />
<main class="card">
    <h3 class="card-header"><a name="" id="" class="btn btn-success" href="crear.php" role="button">Agregar Usuarios</a></h3>
    <section class="card-body">
        <hgroup class="table-responsive-sm">
            <table class="table" id="tabla_id" >
                <thead>
                    <tr>
                        <th scope="col"> 🆔</th>
                        <th scope="col">Nombre de usuario <i class="bi bi-person"></i></th>
                        <th scope="col">Contraseña <i class="bi bi-lock"></i></th>
                        <th scope="col">Correo <i class="bi bi-envelope-at"></i></th>
                        <th scope="col">Acciones <i class="bi bi-gear-fill"></i></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_tbl_usuarios as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['usuarios']; ?></td>
                        <td>*****</td>
                        <td><?php echo $registro['correo']; ?></td>
                        <td>
                        <a  class="btn btn-primary" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>|
                        <a  class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php  } ?>
            </table>
        </hgroup>
    </section>
</main>

<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    body {
        background-color: #323232;
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

<?php include("../../templates/footer.php"); ?>