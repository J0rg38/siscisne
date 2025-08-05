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
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_VerEstado = $_POST['VerEstado'];

$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];

session_start();
if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraDetalle'.$Identificador])){
	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


/*
SesionObjeto-OrdenCompraPedido
Parametro1 = PcoId
Parametro2 = PcoFecha
*/
	
$ResOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraPedidos = $ResOrdenCompraPedido['Datos'];
$OrdenCompraPedidoTotal = $RepSesionObjetos['Total'];
$OrdenCompraPedidoTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId


//$RepOrdenCompraDetalle = $_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
//$ArrOrdenCompraDetalles = $RepOrdenCompraDetalle['Datos'];
//deb($ArrOrdenCompraDetalles);
?>

<?php
if(empty($ArrOrdenCompraPedidos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $OrdenCompraPedidoTotalSeleccionado;?> elemento(s)-->

<?php
$TotalBruto = 0;
foreach($ArrOrdenCompraPedidos as $DatSesionObjeto){
?>

<?php
$InsPedidoCompra = new ClsPedidoCompra();
$InsPedidoCompra->PcoId = $DatSesionObjeto->Parametro1;
$InsPedidoCompra->MtdObtenerPedidoCompra();
?>

<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tbody>
	<tr>
	  <td width="7%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Cot.:</td>
	  <td width="8%" align="left" valign="top"  >
      
	  <a href="principal.php?Mod=CotizacionProducto&amp;Form=Listado&amp;Fil=<?php echo $InsPedidoCompra->CprId;?>">
      <?php echo $InsPedidoCompra->CprId;?>
      </a>
      
      
<?php
if(!empty($InsPedidoCompra->CprId)){
?>
	<br /><a href="javascript:FncCotizacionProductoVistaPreliminar('<?php echo $InsPedidoCompra->CprId;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>
<?php	
}
?>


      </td>
	  <td align="left" valign="top" class="EstFormularioEtiquetaFondo">Ord. Ven.:</td>
	  <td align="left" valign="top">
      
      
		<a href="principal.php?Mod=VentaDirecta&amp;Form=Listado&amp;Fil=<?php echo $InsPedidoCompra->VdiId;?>">
		<?php echo $InsPedidoCompra->VdiId;?>
		</a>
        
<?php
if(!empty($InsPedidoCompra->VdiId)){
?>
<br /><a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $InsPedidoCompra->VdiId;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>

<?php
}
?>
	</td>
	  <td width="7%" height="26" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Pedido:</td>
	  <td width="10%" align="left" valign="top" >


<a href="principal.php?Mod=PedidoCompra&Form=Listado&Fil=<?php echo $InsPedidoCompra->PcoId;?>"><?php echo $InsPedidoCompra->PcoId;?></a>


<?php
if(!empty($InsPedidoCompra->PcoId)){
?>
<br />
<a href="javascript:FncPedidoCompraVistaPreliminar('<?php echo $InsPedidoCompra->PcoId;?>')"><img src="imagenes/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" align="absmiddle" /> </a>

<?php
}
?>


      
      
      </td>
	  <td width="9%" align="left" valign="top" class="EstFormularioEtiquetaFondo">O/C Ref.:</td>
	  <td width="10%" align="left" valign="top">
      
	   <a target="_blank" href="principal.php?Mod=VentaDirecta&Form=Listado&Fil=<?php echo $InsPedidoCompra->VdiOrdenCompraNumero;?>">
	  <?php echo $InsPedidoCompra->VdiOrdenCompraNumero;?>
      </a>
      </td>
	  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Cliente:</td>
	  <td align="left" valign="top">
	  
       <a target="_blank" href="principal.php?Mod=Cliente&Form=Listado&Fil=<?php echo $InsPedidoCompra->CliId;?>">
	  <?php echo $InsPedidoCompra->CliNombre;?> <?php echo $InsPedidoCompra->CliApellidoPaterno;?> <?php echo $InsPedidoCompra->CliApellidoMaterno;?>
      </a>
      
      </td>
    </tr>
	<tr>
	  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
	  <td align="left" valign="top"  >
      <?php echo $InsPedidoCompra->CprFecha;?>
      </td>
	  <td width="8%" align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
	  <td width="10%" align="left" valign="top"><?php echo $InsPedidoCompra->VdiFecha;?></td>
	  <td align="left" valign="top" class="EstFormularioEtiquetaFondo" >Fecha:</td>
	  <td align="left" valign="top" ><?php echo $InsPedidoCompra->PcoFecha;?></td>
	  <td align="left" valign="top" class="EstFormularioEtiquetaFondo">Fecha:</td>
	  <td align="left" valign="top">
<?php echo $InsPedidoCompra->VdiOrdenCompraFecha;?>
</td>
	  <td width="7%" align="left" valign="top">&nbsp;</td>
	  <td width="24%" align="right" valign="top">
        <a href="javascript:FncPedidoCompraCargarFormulario('<?php echo ($POST_Editar==1)?'Editar':'Ver' ?>','<?php echo $InsPedidoCompra->PcoId?>');"  title=""><img src="imagenes/acciones/editar.gif" width="15" height="15" border="0" align="absmiddle"  /> [Editar Pedido]</a>
        </td>
	</tr>
</tbody>
</table>

<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="3%">Id</th>
  <th width="3%">Cod. GM</th>
  <th width="5%">Cod. Orig.</th>
  <th width="3%">Cod. Alt.</th>
  <th width="15%"> Nombre </th>
  <th width="5%">U.M.</th>
  <th width="4%">Año</th>
  <th width="6%">Modelo</th>
  <th width="5%"> Precio </th>
  <th width="6%"> Cantidad</th>
  <th width="6%">Importe</th>

<?php
if($POST_VerEstado==1){
?>
  <th width="7%">Pendiente</th>
  <th width="7%">Cant. Despacho</th>
  <th width="9%">Despacho Fecha</th>
  <th width="5%">Mov. Alm.</th>
  
<?php
}
?>

<?php
if($POST_VerEstado<>1){
?>
 
<th width="9%">Acc.</th>  
   <?php
}
?>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">


<?php
$c = 1;
//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId

//deb($ArrOrdenCompraDetalles);
if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
	foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){

		//deb($DatPedidoCompraDetalle->ProId." - ".$DatPedidoCompraDetalle->AmdCantidad." - ".$DatPedidoCompraDetalle->NodCantidad);
		
		$CantidadLlegadaReal = $DatPedidoCompraDetalle->AmdCantidad - $DatPedidoCompraDetalle->NodCantidad;
	
		if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
			$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
		}else{
			$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
		}

		if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
			$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra->PcoTipoCambio;
		}else{
			$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
		}
?>



<?php
if($POST_VerEstado == 1){
?>

<?php
//	if(empty($DatPedidoCompraDetalle->AmdCantidad)){
//		$fondo = "#F30";
//	}else if($DatPedidoCompraDetalle->AmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
//		$fondo = "#6F3";
//	}else if($DatPedidoCompraDetalle->AmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
//		$fondo = "#FC0";		
//	}else{
//		$fondo = "";	
//	}

	if(empty($CantidadLlegadaReal)){
		$fondo = "#F30";
	}else if($CantidadLlegadaReal >= $DatPedidoCompraDetalle->PcdCantidad){
		$fondo = "#6F3";
	}else if($CantidadLlegadaReal < $DatPedidoCompraDetalle->PcdCantidad){
		$fondo = "#FC0";		
	}else{
		$fondo = "";	
	}
?>
    
<?php
}else{
	$fondo = "";	
}
?>


	<tr>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $c;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->ProId;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>">
			<?php echo $DatPedidoCompraDetalle->PcdCodigo;?>
</td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->ProCodigoAlternativo;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->PcdAno;?></td>
		<td align="right"bgcolor="<?php echo $fondo;?>"><?php echo $DatPedidoCompraDetalle->PcdModelo;?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>">
			<?php echo number_format($DatPedidoCompraDetalle->PcdPrecio,2);?>
		</td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
		<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>

		<?php
		if($POST_VerEstado==1){
		?>
		
		<td align="right" >
        	
            <?php
			if(($DatPedidoCompraDetalle->PcdCantidadPendiente)>0){
			?>
	            <span class="EstOrdenCompraDetalleCantidadPendiente">
				<?php echo number_format($DatPedidoCompraDetalle->PcdCantidadPendiente,2);?>
				</span>
            <?php	
			} 
			?>
            
        </td>
		<td align="right" >
        
        
        
<?php
$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=null)
$ResPedidoCompraLlegadaDetalle = $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,'PldId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatPedidoCompraDetalle->PcdId);
$ArrPedidoCompraLlegadaDetalles = $ResPedidoCompraLlegadaDetalle['Datos'];

?>

<?php
if(!empty($ArrPedidoCompraLlegadaDetalles)){
	foreach($ArrPedidoCompraLlegadaDetalles as $DatPedidoCompraLlegadaDetalle){
?>
		<?php echo number_format($DatPedidoCompraLlegadaDetalle->PldCantidad,2);?>
<?php
	}
}
?>

        
        
        </td>
		<td align="right" >
        
<?php


$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=null)
$ResPedidoCompraLlegadaDetalle = $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,'PldId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatPedidoCompraDetalle->PcdId);
$ArrPedidoCompraLlegadaDetalles = $ResPedidoCompraLlegadaDetalle['Datos'];


?>

<?php
if(!empty($ArrPedidoCompraLlegadaDetalles)){
	foreach($ArrPedidoCompraLlegadaDetalles as $DatPedidoCompraLlegadaDetalle){
?>
		<?php echo $DatPedidoCompraLlegadaDetalle->PleFecha;?>
<?php
	}
}
?>




        
        <?php //echo number_format($DatPedidoCompraDetalle->PcdCantidadPendienteLlegada,2);?>
        
        
        </td>
		
        <td align="right" >
           <?php
			if(($DatPedidoCompraDetalle->AmdCantidad)>0){
			?>
            
<!--<a href="formularios/OrdenCompra/DiaAlmacenMovimientoEntradaListado.php?height=440&width=850&PcoId=<?php echo $DatPedidoCompraDetalle->PcoId;?>" class="thickbox" title=""><img src="imagenes/acciones/enlace.gif" align="Enlace" title="Enlace" border="0" width="18" height="18" /> Mov. Alm.</a>-->

			<?php
			}
			?>
            
            
            
            
<?php
if(($CantidadLlegadaReal)>0){
?>
<a href="formularios/OrdenCompra/DiaAlmacenMovimientoEntradaListado.php?height=440&width=850&PcdId=<?php echo $DatPedidoCompraDetalle->PcdId;?>" class="thickbox" title=""><img src="imagenes/acciones/enlace.gif" align="Enlace" title="Enlace" border="0" width="18" height="18" /> Mov. Alm.</a>
<?php
}
?>
            
		</td>
        
<?php
}
?>


<?php
if($POST_VerEstado<>1){
?>

      
  <td align="center">
  
  
<?php
/*	if($POST_Editar==1){
?>

	<a class="EstSesionObjetosItem" href="javascript:FncOrdenCompraDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  />
    </a>

<?php
	}*/
?>

  </td>    

	  <?php
}
?>
	</tr>

<?php
	$TotalBruto = $TotalBruto + $DatPedidoCompraDetalle->PcdImporte;
$c++;
	}
}
?>
</tbody>
</table>
<br /><br />
<?php
	

}



if($InsPedidoCompra->PcoIncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}


//if($POST_IncluyeImpuesto == 2){
//	
//	$SubTotal = $TotalBruto;
//	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
//	$Total = $SubTotal + $Impuesto;
//	
//}else{
//	
//	$Total = $TotalBruto;
//	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	
//
//}

?>



<?php
if($POST_VerEstado<>1){
?>


<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">Sub Total:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">Impuesto (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
</tr>
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="right" class="Total">&nbsp;</td>
  <td width="61%" align="right" class="Total">Total:</td>
  <td width="15%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>
<?php
}
?>


<?php
}
?>


<?php
if($POST_VerEstado == 1){
?>
<table border="0" cellpadding="2" cellspacing="2" class="EstPanelTablaListado">
<tbody class="EstPanelTablaListadoBody">
<tr>

<td>
<span class="EstPanelTablaListadoTitulo">LEYENDA: </span>
</td>
<td><div style="background-color:#F30; width:30px;">&nbsp;</div></td>


<td width="120">
<span class="EstPanelTablaListadoEtiqueta">No Llego</span>
</td>
<td><div style="background-color:#FC0; width:30px;">&nbsp;</div></td>
<td width="120">
<span class="EstPanelTablaListadoEtiqueta">Llegada Parcial</span>
</td>
<td><div style="background-color:#6F3; width:30px;">&nbsp;</div></td>
<td width="120">
  <span class="EstPanelTablaListadoEtiqueta">Llegada Completa</span>
</td>
</tr>
</tbody>
</table>
<?php
}
?>

