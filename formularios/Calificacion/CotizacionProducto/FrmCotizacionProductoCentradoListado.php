<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
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
$POST_MonedaId = $_POST['MonedaId'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];

session_start();
if (!isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();	
}


require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion
$RepSesionObjetos = $_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoCentrados = $RepSesionObjetos['Datos'];


?>

<?php
if(empty($ArrCotizacionProductoCentrados)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
    <th width="2%">#</th>
    <th width="5%">Id</th>
    <th width="65%"> Descripcion
    </th>
    <th width="12%">Importe</th>
    <th width="8%">Verificado</th>
    <th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">


<?php
$c = 1;
$TotalBruto = 0;

foreach($ArrCotizacionProductoCentrados as $DatCotizacionProductoCentrado){
?>


<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatCotizacionProductoCentrado->Parametro1;?></td>
<td align="right">
  <?php echo $DatCotizacionProductoCentrado->Parametro2;?> 
</td>
<td align="right">
<?php echo number_format($DatCotizacionProductoCentrado->Parametro5,2);?>
</td>
<td align="center"><?php
switch($DatCotizacionProductoCentrado->Parametro6){
	case 1:
?>
Si
  <?php
	break;
	
	case 2:
?>
No
<?php
	break;
	
	default:
?>
-
<?php
	break;
}
?></td>
<td align="center">

<?php
if($POST_Editar==1){
?>
<a class="EstSesionObjetosItem" href="javascript:FncCotizacionProductoCentradoEscoger('<?php echo $DatCotizacionProductoCentrado->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/editar.gif" alt="[Editar]" title="Editar" width="15" height="15"  /></a>
<?php
}
?>

<?php
if($POST_Eliminar==1){
?>
<a href="javascript:FncCotizacionProductoCentradoEliminar('<?php echo $DatCotizacionProductoCentrado->Item;?>');" >
<img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0" /></a>
<?php
}
?>


</td>
</tr>



<?php
	
	$TotalBruto = $TotalBruto + $DatCotizacionProductoCentrado->Parametro5;
	
$c++;
}



?>
</tbody>
</table>

	
<?php
	$Total = $TotalBruto;
	
?>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="right" class="Total">&nbsp;</td>
  <td width="66%" align="right" class="Total">Total:</td>
  <td width="10%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>

<?php
}
?>