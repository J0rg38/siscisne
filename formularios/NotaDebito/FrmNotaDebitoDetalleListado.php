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

$POST_TotalDescuento = $_POST['TotalDescuento'];


session_start();
if (!isset($_SESSION['InsNotaDebitoDetalle'.$Identificador])){
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

	
		
/*
SesionObjeto-NotaDebitoDetalleListado
Parametro1 = NddId
Parametro2 = NddDescripcion
Parametro3 = 
Parametro4 = NddPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NddTipo

Parametro13 = NddUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NddCodigo
Parametro19 = NddValorVenta
Parametro20 = NddImpuesto
Parametro21 = NddDescuentom
Parametro22 = NddGratuito
Parametro23 = NddExonerado	
*/


$RepSesionObjetos = $_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="17">#</th>
  <th width="94">Codigo</th>
  <th width="471"> Descripci&oacute;n</th>
  <th width="59">U.M.</th>
  <th width="77">p/unitario</th>
  <th width="66">Cantidad</th>
  <th width="53">Desc.</th>
  <th width="57">V. Venta</th>
  <th width="53">Importe</th>

<th width="73"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;

$TotalExonerado = 0;
$TotalGravado = 0;
$TotalDescuento = 0;

$TotalItems = 0;


foreach($ArrSesionObjetos as $DatSesionObjeto){



//$DescuentoUnitario = $DatSesionObjeto->Parametro4 * $_POST['Descuento'];
//$PrecioNeto = $DatSesionObjeto->Parametro4 - $DescuentoUnitario;
//$ImporteNeto = $DatSesionObjeto->Parametro5 * $PrecioNeto;
?>

<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro18;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="53" align="right"><?php echo number_format($DatSesionObjeto->Parametro21,2);?></td>
<td width="57" align="right"><?php echo number_format($DatSesionObjeto->Parametro19,2);?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>

<td align="center">
<?php
if($_POST['Editar']==1){
?>
<!--<a class="EstSesionObjetosItem" href="javascript:FncNotaDebitoDetalleEscoger('<?php echo $DatSesionObjeto->Parametro2;?>','<?php echo $DatSesionObjeto->Parametro5;?>','<?php echo $DatSesionObjeto->Parametro6;?>','<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>-->

<a class="EstSesionObjetosItem" href="javascript:FncNotaDebitoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>


<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncNotaDebitoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>


<?php
}
?>
</td>
</tr>
<?php
	$TotalItems++;
	
	
		
		
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
	
$c++;
}


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
      <td width="36%"><?php echo $_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador]?></td>
      <td width="15%">Tracción</td>
      <td width="1%">:</td>
      <td width="34%"><?php echo $_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Modelo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador]?></td>
      <td>Carroceria</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Año Fabric.</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador]?></td>
      <td>No. Puertas</td>
      <td>&nbsp;</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador]?></td>
    </tr>
    <tr>
      <td height="23">No. Motor</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador]?></td>
      <td>Combustible</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Cilindros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador]?></td>
      <td>Peso Bruto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador]?></td>
      <td>Carga Util</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Chasis</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador]?></td>
      <td>Peso Seco</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Color</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador]?></td>
      <td>Alto</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cilindrada</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador]?></td>
      <td>Largo</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Asientos</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador]?></td>
      <td>Ancho</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador]?></td>
    </tr>
    <tr>
      <td>Cap. Pasajeros</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador]?></td>
      <td>Dist. Ejes</td>
      <td>:</td>
      <td><?php echo $_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador]?></td>
    </tr>
    <tr>
      <td>No. Poliza</td>
      <td>:</td>
      <td colspan="4"><?php echo $_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador]?></td>
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
