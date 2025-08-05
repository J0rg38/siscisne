<?php
session_start();
//echo "ok";
//mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);
$enlace = mysql_connect("localhost:3306","admsistema","fabrica");

mysql_select_db("wwwrjlal_sisca",$enlace);

//var_dump($_POST);

$Codigo = $_POST['CmpCodigo'];
$Nombre= strtoupper($_POST['CmpNombre']);
$Cantidad = $_POST['CmpCantidad'];
$Ubicacion = strtoupper($_POST['CmpUbicacion']);
$Usuario = $_POST['CmpUsuario'];
$Observacion = $_POST['CmpObservacion'];

$Foto =  $_SESSION['SesProFotoSolo'];

$sql = "
INSERT INTO inventario
(
usuario,
codigo,
nombre,
cantidad,
ubicacion,
observacion,
tiempo,
foto
)
VALUES(
'".$Usuario."',
'".$Codigo."',
'".$Nombre."',
'".$Cantidad."',
'".$Ubicacion."',

'".$Observacion."',
'".date("Y-m-d H:i:s")."',
'".$Foto."'

);
";

//echo $sql;

if(mysql_query($sql,$enlace)){
	
	echo "<h1>";
	echo "Guardado correctamente";	
	echo "</h1>";
	
}else{

	echo mysql_error($enlace);		
	echo "<br>";
	
	echo "<h1>";
	echo "No se pudo guardar";	
	echo "</h1>";
}




?>


<a href="LeerCodigoBarra.php?CB=<?php echo $Codigo?>">Regresar</a>
