<?php
session_start();
//echo "ok";
//mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);
$enlace = mysql_connect("localhost:3306","admsistema","fabrica");

mysql_select_db("wwwrjlal_sisca",$enlace);

$CODIGO = $GET_CB;

if(!empty($CODIGO)){



$sql = "
SELECT * FROM inventario
WHERE codigo = '".$CODIGO."'
";

$query =  mysql_query($sql,$enlace);
?>



<table border="1" cellpadding="2" cellspacing="2">
<tr>
<td>CODIGO</td>
<td>FECHA Y HORA</td>
<td>NOMBRE</td>
<td>CANT.</td>
<td>UBIC.</td>
<td>USU.</td>
<td>FOTO</td>
<td>ACC</td>
</tr>
<?php
while($datos = mysql_fetch_array($query)){
?>
<tr>
<td><?php echo $datos['codigo']?></td>
<td><?php echo $datos['tiempo']?></td>
<td><?php echo ($datos['nombre'])?></td>
<td><?php echo $datos['cantidad']?></td>
<td><?php echo $datos['ubicacion']?></td>
<td><?php echo $datos['usuario']?></td>
<td>
<?php //echo $datos['foto'];?><br>
<?php
if(!empty($datos['foto'])){
?>
<a targe="_blank" href="subidos/producto_fotos/<?php echo $datos['foto'];?>">
<img src="subidos/producto_fotos/<?php echo $datos['foto'];?>" width="50" height="50" />
</a>
<?php	
}
?>


</td>
<td><a href="editar.php?id=<?php echo $datos['id']?>">Editar</a></td>
</tr>
<?php	
}
?>
</table>

<?php

	
}


?>
