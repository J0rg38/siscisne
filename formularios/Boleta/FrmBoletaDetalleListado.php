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
if (!isset($_SESSION['InsBoletaDetalle'.$Identificador])){
	$_SESSION['InsBoletaDetalle'.$Identificador] = new ClsSesionObjeto();	
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
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeImpuestoSelectivo
Parametro25 = BdeImpuestoSelectivo
*/

$RepSesionObjetos = $_SESSION['InsBoletaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="18" rowspan="2" valign="middle">#</th>
  <th width="35" rowspan="2" valign="middle">Tipo</th>
  <th width="96" rowspan="2" valign="middle">Codigo</th>
  <th width="357" rowspan="2" valign="middle"> Descripci&oacute;n</th>
  <th width="68" rowspan="2" valign="middle">U.M.</th>
  <th width="63" rowspan="2" valign="middle">p/unitario</th>
  <th width="60" rowspan="2" valign="middle">Cantidad</th>
  <th width="48" rowspan="2" valign="middle">Desc.</th>
  <th width="65" rowspan="2" valign="middle">V. Venta</th>
  <th width="73" rowspan="2" valign="middle">Importe</th>
  <th colspan="3" valign="middle">Opciones</th>
  <th width="70" rowspan="2" valign="middle"> Acc.</th>
</tr>
<tr>
  <th width="31" valign="middle">GRAT</th>
  <th width="48" valign="middle">EXO</th>
  <th width="35" valign="middle">ISC</th>
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
  if(!empty($_SESSION['InsBoletaDatoAdicional13'.$Identificador]) or !empty($_SESSION['InsBoletaDatoAdicional7'.$Identificador]) or !empty($_SESSION['InsBoletaDatoAdicional1'.$Identificador])){
  ?>
  (
  <?php
  }
  ?>
  
  
  <?php
  if(!empty($_SESSION['InsBoletaDatoAdicional13'.$Identificador])){
  ?>
	Nro. VIN o CHASIS:
	<?php echo $_SESSION['InsBoletaDatoAdicional13'.$Identificador]?>,
  
	<?php
  }
  ?>
  
  
  <?php
  if(!empty($_SESSION['InsBoletaDatoAdicional7'.$Identificador])){
  ?>

  Nro. Motor:
  <?php echo $_SESSION['InsBoletaDatoAdicional7'.$Identificador]?>,
  
  <?php
  }
  ?>
  
  
   <?php
  if(!empty($_SESSION['InsBoletaDatoAdicional1'.$Identificador])){
  ?>

 Marca:
  <?php echo $_SESSION['InsBoletaDatoAdicional1'.$Identificador]?>
  
  <?php
  }
  ?>
  
  <?php
  if(!empty($_SESSION['InsBoletaDatoAdicional13'.$Identificador]) or !empty($_SESSION['InsBoletaDatoAdicional7'.$Identificador]) or !empty($_SESSION['InsBoletaDatoAdicional1'.$Identificador])){
  ?>
  )
   
  <?php
  }
  ?>
  <?php
  $DatSesionObjeto->Parametro2 = str_replace("|","<br>",$DatSesionObjeto->Parametro2);
  ?>
	
  <?php echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
</td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td width="63" align="right" valign="top">
  
 
  <?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  </td>
<td width="60" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="48" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro21,2);?></td>
<td width="65" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro19,2);?></td>
<td width="73" align="right" valign="top">
 
  <?php echo number_format($DatSesionObjeto->Parametro6,2);?> 
 
</td>
<td width="31" align="center" valign="top">

<?php 
switch($DatSesionObjeto->Parametro22){
	case "1":
?>
Si
<?php		
	break;
	
	case "2":
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
<td width="48" align="center" valign="top"><?php 
switch($DatSesionObjeto->Parametro23){
	case "1":
?>
Si
  <?php		
	break;
	
	case "2":
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
<td width="35" align="center" valign="top">

<?php 
switch($DatSesionObjeto->Parametro24){
	case "1":
?>
Si
  <?php		
	break;
	
	case "2":
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
<td width="70" align="center" valign="top">
<?php
if($POST_Editar==1){
?>
	<a class="EstSesionObjetosItem" href="javascript:FncBoletaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>


<?php
if($POST_Eliminar==1){
?>
	
	<a href="javascript:FncBoletaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
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
	Parametro19 = BdeValorVenta
	Parametro20 = BdeImpuesto
	Parametro21 = BdeDescuento
	Parametro22 = BdeGratuito
	Parametro23 = BdeExonerado
	Parametro24 = BdeIncluyeImpuestoSelectivo
	Parametro25 = BdeImpuestoSelectivo
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
      <td width="36%"><?php echo $_SESSION['InsBoletaDatoAdicional1'.$Identificador]?></td>
      <td width="15%">Tracción</td>
      <td width="1%">:</td>
      <td width="34%"><?php echo $_SESSION['InsBoletaDatoAdicional2'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Modelo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional3'.$Identificador]?></td>
      <td>Carroceria</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional4'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Año Mod.</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional27'.$Identificador]?></td>
      <td>No. Puertas</td>
      <td>&nbsp;</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional6'.$Identificador]?></td>
    </tr>
    <tr>
      <td height="23">No. Motor</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional7'.$Identificador]?></td>
      <td>Combustible</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional8'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Cilindros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional9'.$Identificador]?></td>
      <td>Peso Bruto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional10'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional11'.$Identificador]?></td>
      <td>Carga Util</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional12'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Chasis</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional13'.$Identificador]?></td>
      <td>Peso Seco</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional14'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Color</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional15'.$Identificador]?></td>
      <td>Alto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional16'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cilindrada</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional17'.$Identificador]?></td>
      <td>Largo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional18'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Asientos</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional19'.$Identificador]?></td>
      <td>Ancho</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional20'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cap. Pasajeros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional21'.$Identificador]?></td>
      <td>Dist. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional22'.$Identificador]?></td>
      </tr>
    <tr>
      <td>No. Poliza</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional23'.$Identificador]?></td>
      <td>Numero de Ruedas</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional24'.$Identificador]?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Potencia de Motor</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional25'.$Identificador]?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Clase</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsBoletaDatoAdicional26'.$Identificador]?></td>
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
