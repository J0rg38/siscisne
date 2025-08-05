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
$POST_TipoCambio = $_POST['TipoCambio'];

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador])){
	$_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion
Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista
Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia


*/

$RepSesionObjetos = $_SESSION['InsVehiculoListaPrecioDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="5%">Marca</th>
  <th width="13%">Modelo</th>
  <th width="19%">Version</th>
<th width="5%"> Fuente</th>
<th width="10%">Precio Wholesale sin IGV.</th>
<th width="9%">Precio Cierre con IGV</th>
<th width="9%">Precio Lista con IGV</th>
<th width="8%">Bono GM</th>
<th width="8%">Bono Dealer</th>
<th width="7%">Descuento Comercial</th>
<th colspan="2"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<tr>
<td align="right" ><?php echo $c;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right" >
<span title="<?php echo $DatSesionObjeto->Parametro6;?>">
<?php echo $DatSesionObjeto->Parametro14;?>
</span>

</td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro9,2);?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro10,2);?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro11,2);?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro16,2);?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro17,2);?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro18,2);?></td>
<td width="2%" align="center">
  
  <?php
if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncVehiculoListaPrecioDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');">
    <img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  />
    </a>
  <?php
}
?>
  
  
  
</td>
<td width="3%" align="center">  

<?php
if($POST_Eliminar==1){
?>
	<a href="javascript:FncVehiculoListaPrecioDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
	<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" />
    </a>
<?php
}
?>

</td>
</tr>
<?php


$c++;
}

?>
</tbody>
</table>


<?php
}
?>
