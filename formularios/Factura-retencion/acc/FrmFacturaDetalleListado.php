<?php
//header('Content-Type: text/html; charset=utf-8');

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
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

$POST_OvvId = $_POST['OrdenVentaVehiculoId'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_ImpuestoVenta = $_POST['ImpuestoVenta'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_MonedaSimbolo = $_POST['MonedaSimbolo'];

$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_PorcentajeImpuestoSelectivo = $_POST['PorcentajeImpuestoSelectivo'];

$POST_TotalDescuentoGlobal = $_POST['TotalDescuentoGlobal'];

	

session_start();
if (!isset($_SESSION['InsFacturaDetalle'.$Identificador])){
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();	
}



//deb($POST_PorcentajeDescuento);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeImpuestoSelectivo
Parametro25 = FdeImpuestoSelectivo

*/

$RepSesionObjetos = $_SESSION['InsFacturaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

$VehiculoIngresoId = "";
?>

<?php
if(!empty($POST_OvvId)){
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
	
	$VehiculoIngresoId  = $InsOrdenVentaVehiculo->EinId;

}//deb($TotalDescuento);
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
  <th width="19">#</th>
  <th width="49">Tipo</th>
  <th width="9%">Codigo</th>
  <th width="517"> Descripci&oacute;n</th>
  <th width="61">U.M.</th>
  <th width="78">p/unitario</th>
  <th width="83">Cantidad</th>
  <th width="85">Desc.</th>
  <th width="85">V. Venta</th>
  <th width="85">Importe</th>

<th width="109"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$CantidadTotal = 0;
$TotalItems = 0;
$TotalDescuento = 0;
$TotalImpuestoSelectivo = 0;
$TotalImpuesto = 0;
$TotalGravado = 0;
$TotalDescuentoGlobal = $POST_TotalDescuentoGlobal;

foreach($ArrSesionObjetos as $DatSesionObjeto){

?>

<tr>
<td align="center" valign="top">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
<?php echo $c;?></span></td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" valign="top"><?php echo utf8_encode($DatSesionObjeto->Parametro18);?></td>
<td align="left" valign="top">
  
  <?php
  //$DatSesionObjeto->Parametro2 = str_replace("|","<br>",$DatSesionObjeto->Parametro2);
  ?>
  <?php //echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
  
  
  <?php
  if(!empty($_SESSION['InsFacturaDatoAdicional13'.$Identificador]) or !empty($_SESSION['InsFacturaDatoAdicional7'.$Identificador]) or !empty($_SESSION['InsFacturaDatoAdicional1'.$Identificador])){
  ?>
  (
  <?php
  }
  ?>
  
  
  <?php
  if(!empty($_SESSION['InsFacturaDatoAdicional13'.$Identificador])){
  ?>
	Nro. VIN o CHASIS:
	<?php echo $_SESSION['InsFacturaDatoAdicional13'.$Identificador]?>,
  
	<?php
  }
  ?>
  
  
  <?php
  if(!empty($_SESSION['InsFacturaDatoAdicional7'.$Identificador])){
  ?>

  Nro. Motor:
  <?php echo $_SESSION['InsFacturaDatoAdicional7'.$Identificador]?>,
  
  <?php
  }
  ?>
  
  
   <?php
  if(!empty($_SESSION['InsFacturaDatoAdicional1'.$Identificador])){
  ?>

 Marca:
  <?php echo $_SESSION['InsFacturaDatoAdicional1'.$Identificador]?>
  
  <?php
  }
  ?>
  
  <?php
  if(!empty($_SESSION['InsFacturaDatoAdicional13'.$Identificador]) or !empty($_SESSION['InsFacturaDatoAdicional7'.$Identificador]) or !empty($_SESSION['InsFacturaDatoAdicional1'.$Identificador])){
  ?>
  )
   
  <?php
  }
  ?>
  <?php
  $DatSesionObjeto->Parametro2 = str_replace("|","<br>",$DatSesionObjeto->Parametro2);
  ?>
	
  <?php echo ($DatSesionObjeto->Parametro2);?>
  

</td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td width="78" align="right" valign="top">
  
 
  <?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  </td>
<td width="83" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="85" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro21,2);?></td>
<td width="85" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro19,2);?></td>
<td width="85" align="right" valign="top">
 
  <?php echo number_format($DatSesionObjeto->Parametro6,2);?> 
 
</td>
<td width="109" align="center" valign="top">
<?php
if($POST_Editar==1){
?>
	<a class="EstSesionObjetosItem" href="javascript:FncFacturaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>


<?php
if($POST_Eliminar==1){
?>
	
	<a href="javascript:FncFacturaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>

<?php
}
?>
<?php //echo ($DatSesionObjeto->Parametro24);?> 
</td>
</tr>
<?php
	$TotalItems++;

	/*
	Parametro19 = FdeValorVenta
	Parametro20 = FdeImpuesto
	Parametro21 = FdeDescuento
	Parametro22 = FdeGratuito
	Parametro23 = FdeExonerado
	Parametro24 = FdeIncluyeImpuestoSelectivo
	Parametro25 = FdeImpuestoSelectivo
	*/

	//EXONERADO
	if($DatSesionObjeto->Parametro23 == 1){			
		$TotalExonerado += ($DatSesionObjeto->Parametro19);// - round($DatSesionObjeto->Parametro21,2);
	}

	//GRAVADO
	if($DatSesionObjeto->Parametro23 == 2 and $DatSesionObjeto->Parametro22 == 2){		
		$TotalGravado += ($DatSesionObjeto->Parametro19);// - round($DatSesionObjeto->Parametro21,2);
	}

	//VALOR BRUTO
//	if($DatSesionObjeto->Parametro22 == 2){		
//		//$TotalValorBruto += $DatSesionObjeto->Parametro19 - $DatSesionObjeto->Parametro21;
//		$TotalValorBruto += $DatSesionObjeto->Parametro19;
//	}

	//GRATUITO
	if($DatSesionObjeto->Parametro22 == 1){			
		//$TotalGratuito += round($DatSesionObjeto->Parametro6,2) - round($DatSesionObjeto->Parametro21,2);			
		$TotalGratuito += ($DatSesionObjeto->Parametro19);			
	}

	//INCLUYE SELECTIVO
	if($DatSesionObjeto->Parametro24 == 1){			
		$TotalImpuestoSelectivo += ($DatSesionObjeto->Parametro25);
	}
	
	$TotalDescuento += $DatSesionObjeto->Parametro21;

	//$TotalImpuesto += $DatSesionObjeto->Parametro20;
	

$c++;
}


//if($POST_IncluyeImpuesto == "1"){
//	$TotalDescuentoGlobal = round($TotalDescuentoGlobal / (($POST_PorcentajeImpuestoVenta/100)+1),2);
//}
//
//$TotalDescuento += $TotalDescuentoGlobal;


//$TotalExonerado = round($TotalExonerado,2);
//$TotalGravado = round($TotalGravado,2);
//$TotalValorBruto = round($TotalValorBruto,2);
//$TotalGratuito = round($TotalGratuito,2);
//$TotalImpuestoSelectivo = round($TotalImpuestoSelectivo,2);

//if($POST_PorcentajeDescuento>0){
//
//	$TotalExonerado = $TotalExonerado - ( $TotalExonerado * ($POST_PorcentajeDescuento/100));
//	$TotalGravado =  $TotalGravado - ($TotalGravado * ($POST_PorcentajeDescuento/100));
//	$TotalDescuento = $TotalDescuento + ($TotalValorBruto * ($POST_PorcentajeDescuento/100));

//$Descuento =  ($TotalDescuento);
//$SubTotal =  ($TotalGravado) - ($TotalDescuentoGlobal);
//$ImpuestoVenta = ($SubTotal * ($POST_PorcentajeImpuestoVenta/100));
//$Total =  ($SubTotal + $ImpuestoVenta + $TotalExonerado) ;

$TotalImpuesto = ($TotalGravado + $TotalImpuestoSelectivo) * (($POST_PorcentajeImpuestoVenta/100));

$Total = $TotalGravado + $TotalImpuestoSelectivo + $TotalExonerado + $TotalImpuesto;

?>

</tbody>
</table>

<?php
if(!empty($POST_OvvId)){
?>
	<table width="100%" border="0">
    <tr>
      <td width="13%">Marca</td>
      <td width="1%">:</td>
      <td width="36%"><?php echo $_SESSION['InsFacturaDatoAdicional1'.$Identificador]?></td>
      <td width="15%">Tracción</td>
      <td width="1%">:</td>
      <td width="34%"><?php echo $_SESSION['InsFacturaDatoAdicional2'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Modelo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional3'.$Identificador]?></td>
      <td>Carroceria</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional4'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Año Fabric.</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional5'.$Identificador]?></td>
      <td>No. Puertas</td>
      <td>&nbsp;</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional6'.$Identificador]?></td>
    </tr>
    <tr>
      <td height="23">No. Motor</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional7'.$Identificador]?></td>
      <td>Combustible</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional8'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Cilindros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional9'.$Identificador]?></td>
      <td>Peso Bruto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional10'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional11'.$Identificador]?></td>
      <td>Carga Util</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional12'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Chasis</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional13'.$Identificador]?></td>
      <td>Peso Seco</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional14'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Color</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional15'.$Identificador]?></td>
      <td>Alto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional16'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cilindrada</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional17'.$Identificador]?></td>
      <td>Largo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional18'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Asientos</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional19'.$Identificador]?></td>
      <td>Ancho</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional20'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cap. Pasajeros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional21'.$Identificador]?></td>
      <td>Dist. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional22'.$Identificador]?></td>
      </tr>
    <tr>
      <td>No. Poliza</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional23'.$Identificador]?></td>
      <td>Numero de Ruedas</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional24'.$Identificador]?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Potencia de Motor</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional25'.$Identificador]?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Clase</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsFacturaDatoAdicional26'.$Identificador]?></td>
      </tr>
    <tr>
      <td colspan="6" align="right"><a href="javascript:FncVehiculoIngresoCaracteristicaCargar('<?php echo $VehiculoIngresoId;?>');">[Actualizar Caracteristicas]</a></td>
      </tr>
    </table>

<?php	
}
?>

<br />


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<tbody class="EstTablaListadoBody">
<tr>
  <td colspan="6" align="right">DESCUENTO GLOBAL:</td>
  <td width="153" align="right">
  

    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($TotalDescuento,2);?>
  </td>
  <td width="30" align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right">TOTAL GRAVADO:</td>
  <td align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($TotalGravado,2);?>
    </td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right">TOTAL NO GRAVADO:</td>
  <td align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format(0,2);?>
</td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right">TOTAL EXONERADO:</td>
  <td align="right">
  
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($TotalExonerado,2);?>
  </td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right">TOTAL ISC (<?php echo $POST_PorcentajeImpuestoSelectivo;?> %) </td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($TotalImpuestoSelectivo,2);?>
    </td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right"><span class="Total">TOTAL IGV (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalImpuesto,2);?>
   </td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right"><span class="Total">IMPORTE TOTAL:</span></td>
  <td align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($Total,2);?>
   </td>
  <td align="right">&nbsp;</td>
</tr>
</tbody>
</table>
<?php
}
?>
