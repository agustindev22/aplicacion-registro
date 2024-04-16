<?php include("../../bd.php");
 
 if(isset($_GET['txtID'])){  // ES PARA EDITAR LOS EMPLEADOS AÑADIDOS
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute(); 
    $resgistro=$sentencia->fetch(PDO:: FETCH_LAZY);

     //juntamos los datos para que se almacen en los input del formulario de los empleados 
    $primernombre=$resgistro["primernombre"];
    $segundonombre=$resgistro["segundonombre"];
    $primerapellido=$resgistro["primerapellido"];
    $segundoapellido=$resgistro["segundoapellido"];
    $nombredelpuesto=$resgistro["nombredelpuesto"];
    
    $foto=$resgistro["foto"];
    $cv=$resgistro["cv"];

    $idpuesto=$resgistro["idpuesto"];
    $fechadeingreso=$resgistro["fechadeingreso"];


    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);  
}

if($_POST){

      $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
      $primernombre=(isset($_POST["primernombre"])?$_POST["primernombre"]:"");
      $segundonombre=(isset($_POST["segundonombre"])?$_POST["segundonombre"]:"");
      $primerapellido=(isset($_POST["primerapellido"])?$_POST["primerapellido"]:"");
      $segundoapellido=(isset($_POST["segundoapellido"])?$_POST["segundoapellido"]:"");
      $idpuesto=(isset($_POST["idpuesto"])?$_POST["idpuesto"]:"");
      $fechadeingreso=(isset($_POST["fechadeingreso"])?$_POST["fechadeingreso"]:"");

    //   //CUANDO TENEMOS ARCHIVOS COMO FOTO CV DOCUMENTOS SE CAMBIA EL "POST" O "GET" POR (FILES) !!
    //   $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
    //   $cv=(isset($_FILES["cv"]['name'])?$_FILES["cv"]['name']:"");

      //Preparar la insercion de los datos
      $sentencia=$conexion->prepare(" UPDATE tbl_empleados SET
        primernombre=:primernombre,
        segundonombre=:segundonombre,
        primerapellido=:primerapellido,
        segundoapellido=:segundoapellido,
        idpuesto=:idpuesto,
        fechadeingreso=:fechadeingreso
        WHERE id=:id "); 
     
      $sentencia->bindParam(":primernombre",$primernombre);
      $sentencia->bindParam(":segundonombre",$segundonombre);
      $sentencia->bindParam(":primerapellido",$primerapellido);
      $sentencia->bindParam(":segundoapellido",$segundoapellido);
      $sentencia->bindParam(":idpuesto",$idpuesto);
      $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
      $sentencia->bindParam(":id",$txtID);
      $sentencia->execute();


      $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
       $fecha_= new DateTime(); 
       // <  1 BLOQUE DE FOTO
       $nombreArchivo_foto=($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]["name"]:"";
       $tmp_foto=$_FILES["foto"]["tmp_name"];
      
          //sir para elimar mlas fotos cuando querramos actualizar la foto de los empleados
       if($tmp_foto!=''){
         move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);
        
        $sentencia = $conexion->prepare("SELECT foto FROM `tbl_empleados` WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $registro_recuperado= $sentencia->fetch(PDO::FETCH_LAZY);
         print_r($registro_recuperado);
     
         if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!=""){
            if(file_exists("./".$registro_recuperado["foto"])){
                unlink("./".$registro_recuperado["foto"]); //hace que elimineeñ registro
            };
         }
          //se actualiza con una foto nueva
         $sentencia=$conexion->prepare(" UPDATE tbl_empleados SET foto=:foto WHERE id=:id "); 
         $sentencia->bindParam(":foto",$nombreArchivo_foto); //TIPO FILES
         $sentencia->bindParam(":id",$txtID);
         $sentencia->execute();
       } // />




      $cv=(isset($_FILES["cv"]['name'])?$_FILES["cv"]['name']:"");
       //SIRVE PARA CARGAR LOS DATOS DEL ARCHIVO (CV)
          //< 2 BLOQUE DEL CV
          $nombreArchivo_cv=($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]["name"]:"";
          $tmp_cv=$_FILES["cv"]["tmp_name"];
          if($tmp_cv!=''){
            move_uploaded_file($tmp_cv,"./".$nombreArchivo_cv);
              
            //SE BUSCA EL ARCHIVO DE EL EMPLEADO 
            $sentencia = $conexion->prepare("SELECT cv FROM `tbl_empleados` WHERE id=:id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $registro_recuperado= $sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
                if(file_exists("./".$registro_recuperado["cv"])){
                    unlink("./".$registro_recuperado["cv"]);
                };
             }
                 
           
            $sentencia=$conexion->prepare(" UPDATE tbl_empleados SET cv=:cv WHERE id=:id ");
            $sentencia->bindParam(":cv",$nombreArchivo_cv);//TIPO FILES
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
       
          }
             // />
             $mensaje="Actualizado Correctamente";
             header("Location:index.php?mensaje=".$mensaje);
         

}


?>
<?php include("../../templates/header.php");?>

<br />
<main class="card">
    <h4 class="card-header">Datos del empleado</h4>
    <section class="card-body">
        <form action="" method="post" enctype="multipart/form-data"> <!--enctype sirve para adjuntar el cv y fotosi no ponemos " enctype="multipart/form-data" " no se va poder enlazar los pdf.  -->
                         
            <hgroup class="mb-3">
                <label for="txtID" class="form-label">Id:</label>
                <input type="text" value="<?php echo $txtID;?>" class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" />
            </hgroup>
             
            <hgroup class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre:</label>
                <input type="text" value="<?php echo $primernombre;?>" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer Nombre" />
            </hgroup>

            <hgroup class="mb-3">
                 <label for="segundonombre" class="form-label">Segundo Nombre:</label>   <!-- SE PONE LOS VALUES ADENTRO DE LOS INPUT PARA SABER LOS DATOS--->
                <input type="text"  value="<?php echo $segundonombre;?>" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="primerapellido" class="form-label">Primer Apellido:</label>
                <input type="text"   value="<?php echo $primerapellido;?>" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apellido" />

            </hgroup>
            <hgroup class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo Apellido:</label>
                <input type="text"   value="<?php echo $segundoapellido;?>" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apellido" />
            </hgroup>

            <hgroup class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <br/>
                <img src="<?php echo $foto;?>" width="60" class="rounded" alt="Foto usuario" /> <br/> <br/> <!-- LOS TIPOS FILES COMO LA FOTO Y EL CV VAN AFUERA--->
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Tu foto">
            </hgroup>

            <hgroup class="mb-3">
                <label for="" class="form-label">CV(PDF):</label>
                 <a href="<?php echo $cv;?>"><?php echo $cv;?></a>
                <input type="file"   class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
            </hgroup>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puestos:</label>
                <select class="form-select form-select-ms" name="idpuesto" id="idpuesto">
                <?php foreach ($lista_tbl_puestos as $registro) { ?>  <!-- Si el idpuesto el igual al id si es correcto imprime selectes de que no sea asi no imprime nada--->
                    <option  <?php echo($idpuesto==$registro['id'])?"selected":""?>  value="<?php echo $registro['id']?>"><?php echo $registro['nombredelpuesto']?></option>
                  
                <?php  } ?>   
                </select>
            </div>

            <hgroup class="mb-3">    <!-- SE PONE LOS VALUES ADENTRO DE LOS INPUT PARA SABER LOS DATOS--->
                <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                <input type="date" value="<?php echo $fechadeingreso;?>" class="form-contrmberol" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso" />
            </hgroup>

            <button type="submit" class="btn btn-success">Actualizar</button>
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
<?php include("../../templates/footer.php");?>