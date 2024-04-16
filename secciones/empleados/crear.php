<?php include("../../bd.php"); 

if($_POST){

    // print_r($_POST);
    // print_r($_FILES);

      //Recolectamos los datos del metodo post
      $primernombre=(isset($_POST["primernombre"])?$_POST["primernombre"]:"");
      $segundonombre=(isset($_POST["segundonombre"])?$_POST["segundonombre"]:"");
      $primerapellido=(isset($_POST["primerapellido"])?$_POST["primerapellido"]:"");
      $segundoapellido=(isset($_POST["segundoapellido"])?$_POST["segundoapellido"]:"");
      
      $idpuesto=(isset($_POST["idpuesto"])?$_POST["idpuesto"]:"");
      $fechadeingreso=(isset($_POST["fechadeingreso"])?$_POST["fechadeingreso"]:"");

      //CUANDO TENEMOS ARCHIVOS COMO FOTO CV DOCUMENTOS SE CAMBIA EL "POST" O "GET" POR (FILES) !!
      $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
      $cv=(isset($_FILES["cv"]['name'])?$_FILES["cv"]['name']:"");

      //Preparar la insercion de los datos
      $sentencia=$conexion->prepare("INSERT INTO 
      `tbl_empleados` (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
      VALUES (NULL,:primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechadeingreso);"); 
     
      $sentencia->bindParam(":primernombre",$primernombre);
      $sentencia->bindParam(":segundonombre",$segundonombre);
      $sentencia->bindParam(":primerapellido",$primerapellido);
      $sentencia->bindParam(":segundoapellido",$segundoapellido);

      //SIRVE PARA CARGAR LOS DATOS DEL ARCHIVO (FOTO)
      $fecha_= new DateTime(); //DateTime $fecha_ se puede usar varia veces por ejemplo para FOTO Y EL CV 
      // <  1 BLOQUE DE FOTO
      $nombreArchivo_foto=($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]["name"]:"";
      $tmp_foto=$_FILES["foto"]["tmp_name"];

      if($tmp_foto!=''){
        move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);
      }
      // />
      $sentencia->bindParam(":foto",$nombreArchivo_foto); //TIPO FILES


       //SIRVE PARA CARGAR LOS DATOS DEL ARCHIVO (CV)
          //< 2 BLOQUE DEL CV
      $nombreArchivo_cv=($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]["name"]:"";
      $tmp_cv=$_FILES["cv"]["tmp_name"];
      if($tmp_cv!=''){
        move_uploaded_file($tmp_cv,"./".$nombreArchivo_cv);
      }
         // />
      $sentencia->bindParam(":cv",$nombreArchivo_cv);//TIPO FILES


      $sentencia->bindParam(":idpuesto",$idpuesto);
      $sentencia->bindParam(":fechadeingreso",$fechadeingreso);

      $sentencia->execute();
      $mensaje="Empleado Agregado";
      header("Location:index.php?mensaje=".$mensaje);
  
}


$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);



?>


<?php include("../../templates/header.php"); ?>

<br />
<main class="card">
    <h4 class="card-header">Datos del empleado</h4>
    <section class="card-body">
        <form action="" method="post" enctype="multipart/form-data"> <!--enctype sirve para adjuntar el cv y fotosi no ponemos " enctype="multipart/form-data" " no se va poder enlazar los pdf.  -->

            <hgroup class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre:</label>
                <input type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer Nombre" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="segundonombre" class="form-label">Segundo Nombre:</label>
                <input type="text" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="primerapellido" class="form-label">Primer Apellido:</label>
                <input type="text" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apellido" />

            </hgroup>
            <hgroup class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo Apellido:</label>
                <input type="text" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apellido" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Tu foto">
            </hgroup>

            <hgroup class="mb-3">
                <label for="" class="form-label">CV(PDF):</label>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
            </hgroup>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puestos:</label>
                <select class="form-select form-select-ms" name="idpuesto" id="idpuesto">
                <?php foreach ($lista_tbl_puestos as $registro) { ?>
                    <option value="<?php echo $registro['id']?>"><?php echo $registro['nombredelpuesto']?></option>
                    <!-- <option selected>Select one</option>
                    <option value="">Istanbul</option>
                    <option value="">Jakarta</option> -->
                <?php  } ?>   
                </select>
            </div>

            <hgroup class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                <input type="date" class="form-contrmberol" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso" />
            </hgroup>

            <button type="submit" class="btn btn-success">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar Registros</a>


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
<br />
<?php include("../../templates/footer.php"); ?>