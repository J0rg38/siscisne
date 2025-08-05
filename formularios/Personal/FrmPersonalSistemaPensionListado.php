<?php

require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsPersonalSistemaPension'.$Identificador])){
	$_SESSION['InsPersonalSistemaPension'.$Identificador] = new ClsSesionObjeto();	
}


/*
SesionObjeto-PersonalSistemaPensionListado
Parametro1 = PspId
Parametro2 = SpeId
Parametro3 = Fecha
Parametro4 = CodigoUnico
Parametro5 = SpeNombre

Parametro6 = TiempoCreacion
Parametro7 = TiempoModificacion
*/

$RepSesionObjetos = $_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
?>
<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th>#</th>
  <th>Sistema de Pension</th>
  <th>Fecha</th>
  <th> Codigo Unico</th>
<?php
if($_POST['MostrarTiempoModificacion']==1){
?>
  <th>U.A.</th>
<?php
}
?>
  <th> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$SubTotal = 0;
$CantidadTotal = 0;
$TotalItems = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro5;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro4;?></td>
<?php
if($_POST['MostrarTiempoModificacion']==1){
?>
<td align="center"><?php echo $DatSesionObjeto->Parametro7;?></td>
<?php
}
?>
<td align="center">

<?php
if($_POST['Editar']==1){
?>
<a class="EstSesionObjetosItem" href="javascript:FncPersonalSistemaPensionEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>


<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncPersonalSistemaPensionEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php
}
?></td>
</tr>
<?php
	//$TotalItems++;
$c++;
}

?>
</tbody>
</table>
<br />
<!--<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="19%" align="left" class="Total">Total Items:</td>
  <td width="81%" align="left" ><?php echo $TotalItems;?></td>
  </tr>
</tbody>
</table>-->

<?php
}
?>