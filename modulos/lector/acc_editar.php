<?php
session_start();
//echo "ok";
//mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);
$enlace = mysql_connect("localhost:3306","admsistema","fabrica");

mysql_select_db("wwwrjlal_sisca",$enlace);

//var_dump($_POST);


$Id = $_POST['CmpId'];

$Codigo = $_POST['CmpCodigo'];
$Nombre= strtoupper($_POST['CmpNombre']);
$Cantidad = $_POST['CmpCantidad'];
$Ubicacion = strtoupper($_POST['CmpUbicacion']);
$Usuario = $_POST['CmpUsuario'];
$Observacion = $_POST['CmpObservacion'];

$Foto =  $_SESSION['SesProFotoSolo'];

$sql = "
UPDATE inventario
SET codigo = '".$Codigo."',
nombre = '".$Nombre."',
ubicacion = '".$Ubicacion."',
observacion = '".$Observacion."',
cantidad = '".$Cantidad."',
foto= '".$Foto."',
tiempo_editado = '".date("Y-m-d H:i:s")."'
WHERE id = '".$Id."';
";

//echo $sql;

if(mysql_query($sql,$enlace)){
	
	echo "<h1>";
	echo "Editado correctamente";	
	echo "</h1>";
	
}else{

	echo mysql_error($enlace);		
	echo "<br>";
	
	echo "<h1>";
	echo "No se pudo editar";	
	echo "</h1>";
}




?>


<a href="LeerCodigoBarra.php?CB=<?php echo $Codigo?>">Regresar</a>
