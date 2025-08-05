<?php
session_start();
//echo "ok";
//mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);
$enlace = mysql_connect("localhost:3306","admsistema","fabrica");

mysql_select_db("wwwrjlal_sisca",$enlace);

$GET_id = $_GET['id'];

//echo "id: ".$GET_id;
//echo "<br>";

$_SESSION['SesProFotoSolo'] = "";


$sql = "
SELECT 
* 
FROM inventario
WHERE id = '".$GET_id."';";

$query =  mysql_query($sql,$enlace);



?>


<a href="LeerCodigoBarra.php?CB=<?php echo $Codigo?>">Regresar</a>
