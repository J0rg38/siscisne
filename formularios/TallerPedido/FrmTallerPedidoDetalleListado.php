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
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_Descuento = (empty($_POST['Descuento'])?0:$_POST['Descuento']);
$POST_Total = (empty($_POST['Total'])?0:$_POST['Total']);
$POST_SucursalId = $_POST['SucursalId'];


session_start();
if (!isset($_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

if(empty($POST_AlmacenId)){
	die("No ha escogido un almacen.");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();
$InsAlmacen = new ClsAlmacen();
$InsAlmacenStock = new ClsAlmacenStock();


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

			//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha

$ArrAnulados = array();


$RepSesionObjetos = $_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


//$POST_SucursalId = (empty($_SESSION['SesionSucursal'])?$POST_SucursalId:$_SESSION['SesionSucursal']);
//
//if(empty($POST_SucursalId)){
//	exit("No se encontro la sucursal");
//}


$Sucursal  = "";

if(!empty($POST_AlmacenId)){
	
	$InsAlmacen = new ClsAlmacen();
	$InsAlmacen->AlmId = $POST_AlmacenId;
	$InsAlmacen->MtdObtenerAlmacen();
	
	$Sucursal = $InsAlmacen->SucId;
	
}


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];

//deb($ArrSesionObjetos);
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
  <th width="1%" align="center">#</th>
  <th width="1%" align="center">Id</th>
  <th width="4%" align="center">Cod. Original</th>
  <th width="6%" align="center">Cod. Alternativo</th>
  <th width="20%" align="center"> Nombre
</th>
  <th width="6%" align="center">Cant.</th>
  <th width="4%" align="center">U.M.</th>
  <th width="6%" align="center">Precio</th>
  <th width="10%" align="center">Importe</th>
  <th width="7%" align="center">Fecha Salida Física</th>
  <th width="9%" align="center">Almacen</th>
  <th width="4%" align="center">Stk.</th>
  <th width="7%" align="center">Estado</th>
  <th width="5%" align="center">Cierre</th>
  <th width="10%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	
	$DatSesionObjeto->Parametro33 = (empty($DatSesionObjeto->Parametro33)?2:$DatSesionObjeto->Parametro33);//
	$DatSesionObjeto->Parametro34 =  (empty($DatSesionObjeto->Parametro34)?2:$DatSesionObjeto->Parametro34);//
				
	$DatSesionObjeto->Parametro33 = 2;			

	//if($DatSesionObjeto->Parametro28 == 3 ){	

?>
<tr>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $c;?>
  
  <input style="visibility:hidden;" type="checkbox" name="Chk<?php echo $ModalidadIngreso.$c;?>ProductoId" id="Chk<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId" etiqueta="producto" value="<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" item= "<?php echo $DatSesionObjeto->Item;?>" modalidad_sigla="<?php echo $ModalidadIngreso;?>" />
  
  
  <input type="hidden" name="CmpTallerPedidoDetalle_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpTallerPedidoDetalle_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="1" />
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  <input type="hidden"  name="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>AlmacenMovimienntoSalidaDetalleId"  id="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>AlmacenMovimienntoSalidaDetalleId" value="<?php echo $DatSesionObjeto->Parametro1;?>" />
  
  <input type="hidden" name="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId"    id="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId" value="<?php echo $DatSesionObjeto->Parametro2;?>" />
  
  <!--<input type="hidden" name="CmpFichaAccionProductoId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>"    id="CmpFichaAccionProductoId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro2;?>" />
-->
  
  <?php //echo $DatSesionObjeto->Parametro13;?>
   <a href="javascript:FncProductoConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');"><?php echo $DatSesionObjeto->Parametro13;?></a>
   
   
   
   
<!--  
  <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
  <a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>
  -->
  
  
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
	<?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="left" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
	<?php echo $DatSesionObjeto->Parametro3;?>
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><span title="<?php echo number_format($DatSesionObjeto->Parametro5,6,'.','');?>"> <?php echo number_format($DatSesionObjeto->Parametro5,2,'.','');?> </span></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  <?php echo $DatSesionObjeto->Parametro9;?>
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo number_format($DatSesionObjeto->Parametro4,2,'.','');?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo number_format($DatSesionObjeto->Parametro6,2,'.','');?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro32;?>
  <!--<input <?php echo (($_POST['Editar']==2)?'readonly="readonly"':'')?>  name="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" type="text" class="EstFormularioCaja" id="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro30;?>" size="10" maxlength="10" />--></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
<select  <?php echo (($_POST['Editar']==2 or $DatSesionObjeto->Parametro34 == "1")?'disabled="disabled"':'')?>  class="EstFormularioCombo" name="CmpAlmacen_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpAlmacen_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>">
<option value="">Escoja una opcion</option>
<?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
<option value="<?php echo $DatAlmacen->AlmId?>" <?php if($DatSesionObjeto->Parametro31==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
<?php
}
?>
</select>

  <?php
   /* foreach($ArrAlmacenes as $DatAlmacen){
    ?>
  <?php 
			if($DatSesionObjeto->Parametro31==$DatAlmacen->AlmId){ 
			?>
  <?php echo $DatAlmacen->AlmNombre?>
  <?php
            }
            ?>
  <?php
    }*/
    ?>
  
  
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
<?php
if(!empty($DatSesionObjeto->Parametro31)){
?>

  <?php
$StockReal = 0;
//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);
$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($Sucursal,$POST_AlmacenId,date("Y"),$DatSesionObjeto->Parametro2);

$InsUnidadMedida->UmeId = $DatSesionObjeto->Parametro10;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

$CantidadReal = round($DatSesionObjeto->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

if($StockReal < $CantidadReal){		
	$VerificarStock = 1;
}

?>
  
  <a href="javascript:FncAlmacenStockConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');">
    <?php
if($VerificarStock == 1){
?>
    <span style="color:#F00; font-weight:bold;">SIN STOCK </span>
    <?php	
}else{
?>
    EN STOCK 
    <?php	
}
?>
    
    (<?php echo number_format($StockReal,2);?>)
    
    
    </a>
  
  
<?php
}else{
?>
Debes escoger un almacen
<?php	
}
?>


  
  
  
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  <?php
/*switch($DatSesionObjeto->Parametro28){
	case "1":
?>
  Anulado
  <?php	
	break;
	
	case "3":
?>
  Considerar
  <?php
	break;
	
	default:
?>
  -
  <?php
	break;
}*/
?>
  
  <select <?php echo (($_POST['Editar']==2 or  $DatSesionObjeto->Parametro33 == "1" or $DatSesionObjeto->Parametro34 == "1")?'disabled="disabled"':'')?>    class="<?php echo (($DatSesionObjeto->Parametro28=="1")?'EstFormularioComboAnulado':'EstFormularioCombo');?>" name="CmpTallerPedidoDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpTallerPedidoDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>">
    <option value="">-</option>
    <option <?php echo (($DatSesionObjeto->Parametro28=="1")?'selected="selected"':'');?> value="1">Anulado</option>
    <option <?php echo (($DatSesionObjeto->Parametro28=="3")?'selected="selected"':'');?> value="3" >Considerar</option>
    
    </select>
  
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >



<?php            
if($DatSesionObjeto->Parametro34 == "1"){
?>
                  <img  src="imagenes/estado/cerrado.png" alt="" width="18" height="18" border="0" align="Cerrado" title="Cerrado" />
                  <?php	
}
?>



</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >

 
            <?php			
			//deb($TallerPedidoDetalleFacturado." - ".$TallerPedidoDetalleFacturado);
           // if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
            ?>
<?php

//deb($DatSesionObjeto->Parametro33."-".$DatSesionObjeto->Parametro34 );

if($_POST['Editar']==1 and $DatSesionObjeto->Parametro34 == "2" ){
//if($_POST['Editar']==1 and  ($DatSesionObjeto->Parametro33 == "2" and $DatSesionObjeto->Parametro34 == "2")){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncTallerPedidoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1 and $DatSesionObjeto->Parametro34 == "2" ){
//if($_POST['Eliminar']==1 and  ($DatSesionObjeto->Parametro33 == "2" and $DatSesionObjeto->Parametro34 == "2")){
?>
  <a href="javascript:FncTallerPedidoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
		$c++;
		
		if($DatSesionObjeto->Parametro28==3){
			$TotalBruto += $DatSesionObjeto->Parametro6;
		}
		
		// $aux = '';
	//}
	
	//}else{
	//	$ArrAnulados[] = $DatSesionObjeto;
	//}
	
}
if($ModalidadIngreso<>"MA"){
	
	$Total = $TotalBruto - $POST_Descuento;
	
}else{
	
	$Total = $TotalBruto;
	
}
?>



</tbody>
</table>


<br />
            <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
            <tbody class="EstTablaTotalBody">
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td width="64%" align="right" class="Total">Total de Repuestos:</td>
              <td width="12%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalBruto,2);?></td>
            </tr>
            
            <?php
			if($ModalidadIngreso<>"MA"){
			?>
            <tr>
              <td align="right" class="Total">&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" class="Total">Descuento:</td>
              <td align="right">
             <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span>  <?php echo number_format($POST_Descuento,2);?>
              </td>
            </tr>
            <?php	
			}
			?>
            
            
            <tr>
              <td width="17%" align="right" class="Total">&nbsp;</td>
              <td width="7%" align="left" >&nbsp;</td>
              <td align="right" class="Total">Total:</td>
              <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
              </tr>
            </tbody>
            </table>
            
            
<?php
}
?>



<?php
/*if(!empty($ArrAnulados)){
?>

<br />

OTROS ITEMS ANULADOS<br />
<br />


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="2%" align="center">Id</th>
  <th width="6%" align="center">Cod. Original</th>
  <th width="8%" align="center">Cod. Alternativo</th>
  <th width="22%" align="center"> Nombre
</th>
  <th width="6%" align="center">Cant.</th>
  <th width="5%" align="center">U.M.</th>
  <th width="6%" align="center">Precio</th>
  <th width="5%" align="center">Importe</th>
  <th width="6%" align="center">Fecha Salida Física</th>
  <th width="6%" align="center">Almacen</th>
  <th width="10%" align="center">Estado</th>
  <th width="9%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrAnulados as $DatSesionObjeto){
	//if($DatSesionObjeto->Parametro18==1){		

	

?>
<tr>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $c;?>
  
  <input style="visibility:hidden;" type="checkbox" name="Chk<?php echo $ModalidadIngreso.$c;?>ProductoId" id="Chk<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId" etiqueta="producto" value="<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" item= "<?php echo $DatSesionObjeto->Item;?>" />
  
  
  
  <input type="hidden" name="CmpTallerPedidoDetalle_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpTallerPedidoDetalle_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="1" />
  
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  <input type="hidden"  name="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>AlmacenMovimienntoSalidaDetalleId"  id="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>AlmacenMovimienntoSalidaDetalleId" value="<?php echo $DatSesionObjeto->Parametro1;?>" />
  
  <input type="hidden" name="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId"    id="Cmp<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>ProductoId" value="<?php echo $DatSesionObjeto->Parametro2;?>" />
  
  <!--<input type="hidden" name="CmpFichaAccionProductoId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>"    id="CmpFichaAccionProductoId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro2;?>" />
-->
  
  <?php //echo $DatSesionObjeto->Parametro13;?>
   <a href="javascript:FncProductoConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');"><?php echo $DatSesionObjeto->Parametro13;?></a>
   
   
   
   
<!--  
  <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
  <a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>
  -->
  
  
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
	<?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="left" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
	<?php echo $DatSesionObjeto->Parametro3;?>
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><span title="<?php echo number_format($DatSesionObjeto->Parametro5,6,'.','');?>"> <?php echo number_format($DatSesionObjeto->Parametro5,2,'.','');?> </span></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  <?php echo $DatSesionObjeto->Parametro9;?>
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo number_format($DatSesionObjeto->Parametro4,2,'.','');?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><?php echo number_format($DatSesionObjeto->Parametro6,2,'.','');?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" ><!--<input readonly="readonly" name="CmpTallerPedidoDetalleEstado_" type="text" class="EstFormularioCaja" id="CmpTallerPedidoDetalleEstado_" value="<?php echo $DatSesionObjeto->Parametro30;?>" size="10" maxlength="10" />-->
  <?php echo $DatSesionObjeto->Parametro32;?></td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  <!--<select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpAlmacen_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>">
    <option value="">Escoja una opcion</option>
    <?php
    foreach($ArrAlmacenes as $DatAlmacen){
    ?>
    <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($DatSesionObjeto->Parametro29==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
    <?php
    }
    ?>
</select>-->
  <?php
    foreach($ArrAlmacenes as $DatAlmacen){
    ?>
  <?php 
			if($DatSesionObjeto->Parametro31==$DatAlmacen->AlmId){ 
			?>
  <?php echo $DatAlmacen->AlmNombre?>
  <?php
            }
            ?>
  <?php
    }
    ?>
</td>
<td align="right" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  
  
  
  
  <select <?php echo (($_POST['Editar']==2)?'disabled="disabled"':'')?>    class="EstFormularioCombo" name="CmpTallerPedidoDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpTallerPedidoDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>">
    <option value="">-</option>
    <option <?php echo (($DatSesionObjeto->Parametro28=="1")?'selected="selected"':'');?> value="1">Anulado</option>
    <option <?php echo (($DatSesionObjeto->Parametro28=="3")?'selected="selected"':'');?> value="3" >Considerar</option>
    
    </select>
  
  
  
</td>
<td align="center" valign="middle" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>" >
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncTallerPedidoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncTallerPedidoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
		$c++;
		
	
}




?>



</tbody>
</table>

<?php	
}else{
?>

<?php	
}*/
?>


