<?php include("../../bd.php");


if(isset($_GET['txtID'])){  // ES PARA ELIMINAR LOS EMPLEADOS AÑADIDOS 
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    //SE BUSCA EL ARCHIVO DE EL EMPLEADO 
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_recuperado= $sentencia->fetch(PDO::FETCH_LAZY);
    print_r($registro_recuperado);

    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!=""){
       if(file_exists("./".$registro_recuperado["foto"])){
           unlink("./".$registro_recuperado["foto"]);
       };
    }
     
      
    if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
        if(file_exists("./".$registro_recuperado["cv"])){
            unlink("./".$registro_recuperado["cv"]);
        };
     }
 


       $sentencia=$conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
       $sentencia->bindParam(":id",$txtID);
       $sentencia->execute(); 
       $mensaje="Registro Actualizado";
       header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT *,(SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idpuesto LIMIT 1) as puesto FROM `tbl_empleados`");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);


?>


<?php include("../../templates/header.php"); ?>
<br />

<main class="card tabla">
    <section class="card-header">
        <a name="" id="" class="btn btn-success" href="crear.php" role="button">Agregar Registros</a>
    </section>
    <section class="card-body">
        <hgroup class="table-responsive-lg">
            <table class="table table-hover" id="tabla_id">
                <thead class="table table-lg">
                    <tr>
                        <th scope="col">Id<i class="bi bi-people-fill"></i></th>
                        <th scope="col">Nombres <i class="bi bi-people-fill"></i></th>
                        <th scope="col">Foto <i class="bi bi-camera-fill"></i></th>
                        <th scope="col">Cv <i class="bi bi-file-text"></i></th>
                        <th scope="col">Puesto 🤔</th>
                        <th scope="col">Fecha de ingreso <i class="bi bi-calendar3"></i></th>
                        <th scope="col">Acciones <i class="bi bi-gear-fill"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista_tbl_empleados as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id']; ?></td>
                            <td scope="row">

                                <?php echo $registro['primernombre']; ?>
                                <?php echo $registro['segundonombre']; ?>
                                <?php echo $registro['primerapellido']; ?>
                                <?php echo $registro['segundoapellido']; ?>

                            </td>
                            <td>
                                <img src="<?php echo $registro['foto'];?>" width="40" class="img-fluid rounded" alt="Foto usuario" />
                            </td>
                            <td> <a href="<?php echo $registro['cv']; ?> " target="_blank" ><?php echo $registro['cv']; ?></a></td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['fechadeingreso']; ?></td>
                            <td>
                                <a  class="btn btn-primary editar" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>|
                                <!-- <input name="btneliminar" id="btneliminar" class="btn btn-danger" type="button" value="Eliminar"> -->
                                <a name="" id="" class="btn btn-warning" href="carta_recomendacion.php?txtID=<?php echo $registro['id']; ?>" role="button">Carta</a>
                                <a  class="btn btn-danger rojo" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
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
  
    table{
        background-color:blue;
       
    }

</style>

<?php include("../../templates/footer.php"); ?>