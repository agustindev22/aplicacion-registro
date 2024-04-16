<?php include("../../bd.php");

if($_POST){
    print_r($_POST);

    //Recolectamos los datos del metodo post
    $nombredelpuesto=(isset($_POST["nombredelpuesto"])?$_POST["nombredelpuesto"]:"");
    //Preparar la insercion de los datos
    $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) VALUES (null, :nombredelpuesto)"); 
    //Asignando los metodos que vienen del metodo post(los que vienen del formulario)
    $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
    $sentencia->execute();
    header("Location:index.php");

}   
?>


<?php include("../../templates/header.php"); ?>
<br/>
<main class="card ">
    <h3 class="card-header">Puestos</h3>
    <section class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <hgroup class="mb-3">
                <label for="nombredelpueto" class="form-label">Nombre del puesto:</label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto" />
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