<?php

use Dompdf\Dompdf;

include("../../bd.php");


if(isset($_GET['txtID'])){  // ES PARA EDITAR LOS EMPLEADOS AÑADIDOS
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT *,(SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idpuesto LIMIT 1) as puesto FROM tbl_empleados WHERE id=:id");


    
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute(); 
    $resgistro=$sentencia->fetch(PDO:: FETCH_LAZY);
     //juntamos los datos para que se almacen en los input del formulario de los empleados 
    $primernombre=$resgistro["primernombre"];
    $segundonombre=$resgistro["segundonombre"];
    $primerapellido=$resgistro["primerapellido"];
    $segundoapellido=$resgistro["segundoapellido"];
    $nombredelpuesto=$resgistro["nombredelpuesto"];

    $nombrecompleto=$primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;
    
    $foto=$resgistro["foto"];
    $cv=$resgistro["cv"];

    $idpuesto=$resgistro["idpuesto"];
    $puesto=$resgistro["puesto"];
    $fechadeingreso=$resgistro["fechadeingreso"];

    $fechaInicio=new DateTime($fechadeingreso);
    $fechaFin=new DateTime(date('y-m-d'));
    $diferenacia=date_diff($fechaInicio,$fechaFin);

}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi carta de presentacion</title>
</head>
<body>
    <h1>Mi carta de recomendacion </h1>
    <br/>
    <h2>Buenos Aires, Argentina <strong><?php echo date('d/ m /y')?></strong></h2>
    <h3>A quien pueda interezar:</h3>
    <h4>Le doy un cordial saludo</h4>
    <p>A travez de este medio le hago saber que el/la sr <strong><?php echo $nombrecompleto?></strong>, a quein laburo en mi organizacion dusrante <strong> <?php echo $diferenacia->y;?>Años</strong> es un cuidadano de gran calibre , con un compromiso exelente, gran trabajador, responsable y fiel cumplidor con sus tareas. Simpre tien ese rool de querer mejorar en todo aspecto, en conocimiento,trabajo y de mas </p>
      <br/>
     <P>Durante estos años se desenpeño como : <strong><?php echo $puesto?></strong></P>
     <p>Por eso considero esta recomendacion porque esta y lo va estar a la altura en lo que necesite.
      sin mas nada que aportar espero que mi recomendacion sirva porque realmente es asi, dejo mi contacto por si desea comunicarse. 
     </p>    
    <br/><br/><br/><br/>
    <h5>Att: ING. Andres Martinez</h5>
</body>
</html>

<?php
$HTML=ob_get_clean();
require_once("../../libreria/autoload.inc.php");
//use Dompdf∖Dompdf;
$dompdf= new Dompdf();
$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));
$dompdf->setOptions($opciones);
$dompdf->loadHtml($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));



?>