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
$POST_OvvId = $_POST['OrdenVentaVehiculoId'];

session_start();
if (!isset($_SESSION['InsGuiaRemisionDetalle'.$Identificador])){
	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

/*
SesionObjeto-GuiaRemisionDetalleListado
Parametro1 = GrdId
Parametro2 = GrdCodigo
Parametro3 = GrdDescripcion
Parametro4 = GrdCantidad
Parametro5 = GrdUnidadMedida
Parametro6 = GrdPesoTotal
Parametro7 = GrdTiempoCreacion
Parametro8 = GrdTiempoModificacion
Parametro9 = GrdPesoNeto
*/

$RepSesionObjetos = $_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
?>


<?php
if(!empty($POST_OvvId)){
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

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
  <th width="2%">#</th>
  <th width="7%">C&oacute;digo</th>
  <th width="44%"> Descripci&oacute;n</th>
<th width="7%"> Cantidad</th>
<th width="7%"> U.M.</th>
<th width="8%">Peso Neto</th>
<th width="8%">Peso Total</th>

<th width="7%"> Acciones</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="left">

<?php echo utf8_encode($DatSesionObjeto->Parametro3);?>

<?php
if(!empty($POST_OvvId)){
?>
<table width="502" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="97"><span class="EstFacturaImprimirEtiquetaCaracteristica">Marca:</span></td>
			  <td width="87"><span class="EstFacturaImprimirContenidoCaracteristica">
			<?php echo $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmaNombre;?>			</span>		</td>
			  <td width="10">&nbsp;</td>
			  <td width="80"><span class="EstFacturaImprimirEtiquetaCaracteristica">TRACCI&Oacute;N:</span></td>
			  <td width="68"><span class="EstFacturaImprimirContenidoCaracteristica"> <?php echo $InsOrdenVentaVehiculo->VveCaracteristica7;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Modelo:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica">
			  
			  
			  <?php
	
	$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = preg_replace("/SEDAN/", "", $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
	
	$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = preg_replace("/HATCHBACK/", "", $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
	?>
	
	
	<?php echo $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">CARROCERIA:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica8;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">A&ntilde;o Fabricac.:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinAnoFabricacion;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">NO. puertas:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica9;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Motor:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">combustible:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica10;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Clindros:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica1;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">peso bruto:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica11;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Ejes:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica2;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">carga util:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica12;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Chasis:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica">
			  
			  <a href="javascript:FncVehiculoIngresoCargarFormulario('Editar','<?php echo $InsOrdenVentaVehiculo->EinId;?>')">
			  <?php echo $InsOrdenVentaVehiculo->EinVIN;?>
			  </a>
			  
			  </span>
			  
			  
			  </td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">peso seco:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica13;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Color:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinColor;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">alto:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica14;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Cilindrada:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica3;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">largo:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica15;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Asientos:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica4;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">ancho:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica16;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Cap. Pasajeros:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica5;?></span></td>
			  <td>&nbsp;</td>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">dist. ejes:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica17;?></span></td>
			  </tr>
			<tr>
			  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Poliza:</span></td>
			  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinDUA;?></span></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</table>


<?php  
}
?>

  
  
</td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="right">
<?php echo $DatSesionObjeto->Parametro5;?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro9,2);?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>


<td align="center">
<?php
if($_POST['Editar']==1){
?>

<a class="EstSesionObjetosItem" href="javascript:FncGuiaRemisionDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>
<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncGuiaRemisionDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
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
