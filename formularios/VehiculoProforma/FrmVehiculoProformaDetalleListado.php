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
if (!isset($_SESSION['InsVehiculoProformaDetalle'.$Identificador])){
	$_SESSION['InsVehiculoProformaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

	/*
	SesionObjeto-VehiloListaPrecioDetalle
	Parametro1 = VpdId
	Parametro2 = EinId
	Parametro3 = 
	Parametro4 = VmaId
	Parametro5 = VmoId
	Parametro6 = VveId
	
	Parametro7 = VpdTiempoCreacion
	Parametro8 = VpdTiempoModificacion
	
	Parametro9 = VpdCosto
	Parametro10 = 
	Parametro11 = 
	
	Parametro12 = VmaNombre
	Parametro13 = VmoNombre
	Parametro14 = VveNombre
	Parametro15 = EinVIN
	Parametro16 = EinColor
	Parametro17 = EinAnoFabricacion
	Parametro18 = EinAnoModelo
	
	Parametro19 = EinNumeroMotor
	*/

$RepSesionObjetos = $_SESSION['InsVehiculoProformaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="11%">VIN</th>
  <th width="7%">Marca</th>
  <th width="7%">Modelo</th>
  <th width="15%">Version</th>
  <th width="10%">Num. Motor</th>
  <th width="11%">Color</th>
  <th width="11%">Año Fabricacion</th>
  <th width="11%">Año Modelo</th>
<th width="10%"> Precio Proformado</th>
<th colspan="2"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$Total = 0;
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<tr>
<td align="right" ><?php echo $c;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro15;?></td>

<td align="right" ><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right" >
<?php echo $DatSesionObjeto->Parametro14;?>

</td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro19;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro16;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro17;?></td>
<td align="right" ><?php echo $DatSesionObjeto->Parametro18;?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro9,2);?></td>
<td width="2%" align="center">
  
  <?php
if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncVehiculoProformaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');">
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
	<a href="javascript:FncVehiculoProformaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
	<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" />
    </a>
<?php
}
?>

</td>
</tr>
<?php
  $Total = $Total + $DatSesionObjeto->Parametro9;

$c++;
}

?>
</tbody>
</table>



        <br />
        <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
        <tbody class="EstTablaTotalBody">
        <tr>
          <td width="17%" align="right" class="Total">&nbsp;</td>
          <td width="7%" align="left" >&nbsp;</td>
          <td width="65%" align="right" class="Total">Total:</td>
          <td width="11%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
          
        </tr>
        </tbody>
        </table>


<?php
}
?>
