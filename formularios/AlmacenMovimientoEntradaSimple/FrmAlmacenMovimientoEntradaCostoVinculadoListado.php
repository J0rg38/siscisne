<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();	
}


/*
SesionObjeto-AlmacenMovimientoEntradaDetalle
Parametro1 = AmdId
Parametro2 = ProId
Parametro3 = Nombre
Parametro4 = Costo
Parametro5 = Cantidad
Parametro4 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = UnidadMedida
*/

$RepSesionObjetos = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

$POST_TotalRecargo = eregi_replace(",","",$_POST['TotalRecargo']);
$POST_TotalFlete = eregi_replace(",","",$_POST['TotalFlete']);
$POST_TotalOtroCosto = eregi_replace(",","",$_POST['TotalOtroCosto']);

//$POST_TotalRecargo = $_POST['TotalRecargo'];
//$POST_TotalFlete = $_POST['TotalFlete'];
//$POST_TotalOtroCosto = $_POST['TotalOtroCosto'];
$POST_TotalImportacion = 0;

$POST_NacionalMonedaId1 = $_POST['MonedaId'];
$POST_NacionalMonedaId2 = $_POST['NacionalMonedaId2'];
$POST_NacionalMonedaId3 = $_POST['NacionalMonedaId3'];


if($POST_NacionalMonedaId1<>$EmpresaMonedaId){
	$POST_TotalRecargo = ($POST_TotalRecargo * $_POST['TipoCambio']);
}

if($POST_NacionalMonedaId2<>$EmpresaMonedaId){
	$POST_TotalFlete = ($POST_TotalFlete * $_POST['TipoCambio']);
}

if($POST_NacionalMonedaId3<>$EmpresaMonedaId){
	$POST_TotalOtroCosto = ($POST_TotalOtroCosto * $_POST['TipoCambio']);
}

?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" rowspan="2" align="center">#</th>
  <th width="2%" rowspan="2" align="center">Id</th>
  <th width="50%" rowspan="2" align="center">Cod. Original</th>
  <th width="50%" rowspan="2" align="center"> Nombre</th>
  <th width="8%" rowspan="2" align="center">Cant.</th>
  <th width="8%" rowspan="2" align="center">Unidad.</th>
  <th width="7%" rowspan="2" align="center">
    
    Valor Unitario</th>
  <th width="6%" rowspan="2" align="center">Valor Total</th>
  <th colspan="4" align="center">Otros Costos Vinculados</th>
  <th width="5%" rowspan="2" align="center">Total Costo</th>
  <th width="5%" rowspan="2" align="center">Costo Unitario</th>
  <th width="5%" rowspan="2" align="center">Costo Anterior Stock</th>
  <th width="5%" rowspan="2" align="center">Costo Promedio</th>
  </tr>
<tr>
  <th width="5%" align="center">Recargo</th>
<th width="5%" align="center">Flete</th>
<th width="5%" align="center">Otro Costo</th>
<th width="5%" align="center">Total Costos Importacion</th>
<?php
if($_POST['MostrarTiempoModificacion']==1){
?>
<?php
}
?>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$SumaValorTotal = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
		
	//if($InsMoneda->MonId<>$EmpresaMonedaId){
	//	$SumaValorTotal += $DatSesionObjeto->Parametro4 * $_POST['TipoCambio'];
	//}else{
		$SumaValorTotal += $DatSesionObjeto->Parametro4;	
	//}

}

if(empty($SumaValorTotal)){
	$SumaValorTotal = 1;
}

$c = 1;
$CantidadTotal = 0;
$TotalItems = 0;
$SumaTotalCosto = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<?php
/*if($InsMoneda->MonId<>$EmpresaMonedaId){
?>

	<?php  $DatSesionObjeto->Parametro4 = ($DatSesionObjeto->Parametro4 * $_POST['TipoCambio']);?>
	<?php  $DatSesionObjeto->Parametro4 = ($DatSesionObjeto->Parametro4 * $_POST['TipoCambio']);?>

<?php	
}*/
?>
                            
                            
                            
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro17;?></td>
<td align="right">
<?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right">
<?php echo number_format($DatSesionObjeto->Parametro5,2);?>
</td>
<td align="right">
<?php echo $DatSesionObjeto->Parametro9;?>
</td>
<td align="right"> 

<?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

</td>
<td align="right">
<?php echo number_format($DatSesionObjeto->Parametro6,2);?>
</td>
<td align="right" bgcolor="#FF0000">
<?php $RecargoUnitario = round(($DatSesionObjeto->Parametro4 * $POST_TotalRecargo)/$SumaValorTotal,2);?>
<?php echo number_format($RecargoUnitario,2);?>
</td>
<td align="right" bgcolor="#FF0000">
<?php $FleteUnitario = round(($DatSesionObjeto->Parametro4 * $POST_TotalFlete)/$SumaValorTotal,2);?>
<?php echo number_format($FleteUnitario,2);?>
</td>
<td align="right" bgcolor="#FF0000">
<?php $OtroCosto = round(($DatSesionObjeto->Parametro4 * $POST_TotalOtroCosto)/$SumaValorTotal,2);?>
<?php echo number_format($OtroCosto,2);?>
</td>
<td align="right" bgcolor="#00FF00">
<?php $TotalImportacion = round(($DatSesionObjeto->Parametro4 * $POST_TotalImportacion)/$SumaValorTotal,2);?>
<?php echo number_format($TotalImportacion,2);?>
</td>
<td align="right">
<?php $SumaTotalCosto += $TotalCosto = round($RecargoUnitario + $FleteUnitario + $OtroCosto + $TotalImportacion + $DatSesionObjeto->Parametro4,2);?>
<?php echo number_format($TotalCosto,2);?>
</td>
<td align="right">
<?php $CostoUnitario = round($TotalCosto /$DatSesionObjeto->Parametro5,2);?>
<?php echo number_format($CostoUnitario,2);?>
</td>
<td align="right" bgcolor="#9D9DBD">
<?php $CostoAnterior = round($DatSesionObjeto->Parametro15,2);?>
<?php echo number_format($CostoAnterior,2);?>
</td>
<td align="right">

  <?php 
  $CostoPromedio = round(($CostoUnitario + $CostoAnterior)/(empty($CostoAnterior)?1:2),2);
  ?>
  
  <?php echo number_format($CostoPromedio,2);?>
</td>
</tr>

<?php
	$TotalItems++;
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro4;
	$CantidadTotal = $CantidadTotal + $DatSesionObjeto->Parametro5;
$c++;
}

?>

<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($SumaValorTotal,2);?></td>
  <td align="right">
  <?php echo number_format($POST_TotalRecargo,2);?>
  </td>
  <td align="right"><?php echo number_format($POST_TotalFlete,2);?></td>
  <td align="right"><?php echo number_format($POST_TotalOtroCosto,2);?></td>
  <td align="right"><?php echo number_format($POST_TotalImportacion,2);?></td>
  <td align="right"><?php echo number_format($SumaTotalCosto,2);?></td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  </tr>

</tbody>
</table>


<?php
}
?>