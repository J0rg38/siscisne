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
$POST_MonedaId = $_POST['MonedaId'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();	
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

$RepSesionObjetos = $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoPlanchados = $RepSesionObjetos['Datos'];

?>

<?php
if(empty($ArrCotizacionProductoPlanchados)){
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
    <th width="66%"> Descripcion
    </th>
    <th width="11%">Importe</th>
    <th width="9%">Verificado</th>
    <th width="7%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">


<?php
$c = 1;
$TotalBruto = 0;
foreach($ArrCotizacionProductoPlanchados as $DatCotizacionProductoPlanchado){
?>

<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatCotizacionProductoPlanchado->Parametro1;?></td>
<td align="right">
  <?php echo $DatCotizacionProductoPlanchado->Parametro2;?> 
</td>
<td align="right">
<?php echo number_format($DatCotizacionProductoPlanchado->Parametro5,2);?>
</td>
<td align="center">

<?php
switch($DatCotizacionProductoPlanchado->Parametro6){
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
?>


</td>
<td align="center">

<?php
if($POST_Editar==1){
?>
<a class="EstSesionObjetosItem" href="javascript:FncCotizacionProductoPlanchadoEscoger('<?php echo $DatCotizacionProductoPlanchado->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>

<?php
if($POST_Eliminar==1){
?>
<a href="javascript:FncCotizacionProductoPlanchadoEliminar('<?php echo $DatCotizacionProductoPlanchado->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php
}
?>

</td>
</tr>

<?php
	
	$TotalBruto = $TotalBruto + $DatCotizacionProductoPlanchado->Parametro5;
	
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
  <td width="66%" align="right" class="Total">Total Planchado:</td>
  <td width="10%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>

<?php
}
?>