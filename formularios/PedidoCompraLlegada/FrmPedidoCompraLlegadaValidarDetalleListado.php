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
$POST_PedidoCompraLlegadaId = $_POST['PedidoCompraLlegadaId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsUnidadMedida = new ClsUnidadMedida();

//MtdObtenerPedidoCompraLlegadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PldId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oPedidoCompraLlegada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oPedidoCompraDetalle=NULL,$oPedidoCompraLlegadaEstado =NULL) {
$InsPedidoCompraLlegadaDetalle = new ClsPedidoCompraLlegadaDetalle();
$ResPedidoCompraLlegadaDetalle = $InsPedidoCompraLlegadaDetalle->MtdObtenerPedidoCompraLlegadaDetalles(NULL,NULL,'PldId','Desc',1,NULL,$POST_PedidoCompraLlegadaId,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPedidoCompraLlegadaDetalles  = $ResPedidoCompraLlegadaDetalle['Datos'];

?>

		<?php
		if(empty($ArrPedidoCompraLlegadaDetalles)){
		?>
        	No se encontraron elementos
        <?php
        }else{
        ?>

            <table class="EstTablaListado" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th>#</th>
              <th>Ord. Compra</th>
              <th>Cod. Orig.</th>
              <th> Nombre
            </th>
              <th>Cliente</th>
            <th>U.M.</th>
            <th>
              Cant. Rec.</th>
            <th>Ref.:</th>
            <th>Conformidad de Recepcion</th>
            <th>Observacion</th>
            <th>Cant. Entregada</th>
            <th>Acciones</th>
            <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
            <?php
            $c = 1;
            foreach($ArrPedidoCompraLlegadaDetalles as $DatPedidoCompraLlegadaDetalle){
            ?>
          
            <tr>
            <td align="left" valign="top"><?php echo $c;?></td>
            <td align="left" valign="top"><input class="<?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'EstFormularioCaja':'EstFormularioCajaDeshabilitada');?>"  name="CmpOrdenCompraId_<?php echo $c;?>" type="text" id="CmpOrdenCompraId_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->PldOrdenCompraId;?>" size="20" maxlength="25" readonly="readonly" /></td>
            <td align="left" valign="top">

<input name="CmpProductoId_<?php echo $c;?>" type="hidden" id="CmpProductoId_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->ProId;?>" size="20" maxlength="20" readonly="readonly" />
        <input name="CmpPedidoCompraLlegadaDetalleId_<?php echo $c;?>" type="hidden" id="CmpPedidoCompraLlegadaDetalleId_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->PldId;?>" size="20" maxlength="20" readonly="readonly" />    
            
<input class="<?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'EstFormularioCaja':'EstFormularioCajaDeshabilitada');?>"  name="CmpProductoCodigoOriginal_<?php echo $c;?>" type="text" id="CmpProductoCodigoOriginal_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->ProCodigoOriginal;?>" size="10" maxlength="20" readonly="readonly" />
			
			</td>
            <td align="left" valign="top">
            
			<input class="<?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'EstFormularioCaja':'EstFormularioCajaDeshabilitada');?>"  name="CmpProductoNombre_<?php echo $c;?>" type="text"  id="CmpProductoNombre_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->ProNombre;?>" size="30" maxlength="255" readonly="readonly" />
            
            </td>
            <td align="left" valign="top"><input class="<?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'EstFormularioCaja':'EstFormularioCajaDeshabilitada');?>"  name="CmpClienteNombre_<?php echo $c;?>" type="text"  id="CmpClienteNombre_<?php echo $c;?>" value="<?php echo $DatPedidoCompraLlegadaDetalle->CliNombre;?>" size="25" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">
			

<?php
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$DatPedidoCompraLlegadaDetalle->RtiId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];

?>
            
<select class="EstFormularioCombo" <?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'':'disabled="disabled"');?>    name="CmpProductoUnidadMedida_<?php echo $c;?>" id="CmpProductoUnidadMedida_<?php echo $c;?>" >

<option value="">Escoja una opcion</option>

	<?php
    foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
    ?>
		<option <?php echo (($DatPedidoCompraLlegadaDetalle->UmeId == $DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>    
	
    <?php	
    }
    ?>
</select>

            
            
            
            
            </td>
            <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpPedidoCompraLlegadaDetalleCantidad_<?php echo $c;?>" type="text" id="CmpPedidoCompraLlegadaDetalleCantidad_<?php echo $c;?>" value="<?php echo number_format($DatPedidoCompraLlegadaDetalle->PldCantidad,2);?>" size="4" maxlength="10" /></td>
            <td align="left" valign="top">
            
            <?php //echo $DatPedidoCompraLlegadaDetalle->VdiOrdenCompraNumero;?>
            
            
            <?php            
if(!empty($DatPedidoCompraLlegadaDetalle->VdiArchivo)){
	
	$extension = strtolower(pathinfo($DatPedidoCompraLlegadaDetalle->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($DatPedidoCompraLlegadaDetalle->VdiArchivo, '.'.$extension);  
?>
                 
                  
<a href="subidos/venta_directa/<?php echo $DatPedidoCompraLlegadaDetalle->VdiArchivo;?>" target="_blank" title="">
				<?php echo ($DatPedidoCompraLlegadaDetalle->VdiOrdenCompraNumero);?>
</a>
              
                  
<?php	
}else{
?>
	<?php echo ($DatPedidoCompraLlegadaDetalle->VdiOrdenCompraNumero);?>
<?php	
}
?>



            </td>
            <td align="left" valign="top">
            
            
            
            <select class="EstFormularioCombo"   name="CmpPedidoCompraLlegadaDetalleEstado_" id="CmpPedidoCompraLlegadaDetalleEstado_<?php echo $c;?>" >
              <option value="">Escoja una opcion</option>

<?php

$PedidoCompraLlegadaDetalleEstado1 = '';
$PedidoCompraLlegadaDetalleEstado3 = '';
$PedidoCompraLlegadaDetalleEstado7 = '';
$PedidoCompraLlegadaDetalleEstado8 = '';
$PedidoCompraLlegadaDetalleEstado9 = '';

switch($DatPedidoCompraLlegadaDetalle->PldEstado){
	case 1://PENDIENTE
		$PedidoCompraLlegadaDetalleEstado1 = 'selected="selected"';
	break;
	
	case 3://CONFORME (CANTIDADES)
		$PedidoCompraLlegadaDetalleEstado3 = 'selected="selected"';
	break;
	
	case 7://NO LLEGO
		$PedidoCompraLlegadaDetalleEstado7 = 'selected="selected"';
	break;
	
	case 8://LLEGO INCOMPLETO
		$PedidoCompraLlegadaDetalleEstado8 = 'selected="selected"';
	break;
	
	case 9://LLEGO DAÑADO
		$PedidoCompraLlegadaDetalleEstado9 = 'selected="selected"';
	break;
	
}
?>				
				<option <?php echo $PedidoCompraLlegadaDetalleEstado3;?> value="3">Conforme</option>
				<option <?php echo $PedidoCompraLlegadaDetalleEstado1;?> value="1">Pendiente</option>
				<option <?php echo $PedidoCompraLlegadaDetalleEstado7;?> value="7">No Llego</option>
                <option <?php echo $PedidoCompraLlegadaDetalleEstado8;?> value="8">Incompleto</option>
                <option <?php echo $PedidoCompraLlegadaDetalleEstado9;?> value="9">Dañado</option>

            </select></td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpPedidoCompraLlegadaDetalleObservacion_<?php echo $c;?>" cols="18" rows="2"  id="CmpPedidoCompraLlegadaDetalleObservacion_<?php echo $c;?>"><?php echo $DatPedidoCompraLlegadaDetalle->PldObservacion;?></textarea></td>
            <td align="left" valign="top">

<input class="EstFormularioCaja"  name="CmpPedidoCompraLlegadaDetalleCantidadEntregada_<?php echo $c;?>" type="text" id="CmpPedidoCompraLlegadaDetalleCantidadEntregada_<?php echo $c;?>" value="<?php echo number_format($DatPedidoCompraLlegadaDetalle->PldCantidadEntregada,2);?>" size="4" maxlength="10" />
            </td>
            <td align="left" valign="top">
              
  <!--<a id="BtnPedidoCompraLlegadaIdentificar_<?php echo $c;?>" href="javascript:FncPedidoCompraLlegadaValidarDetalleGuardar('<?php echo $c;?>');">
<img src="imagenes/guardar.gif" width="22" height="22" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a>
   
<a id="BtnPedidoCompraLlegadaEliminar_<?php echo $i;?>" href="javascript:FncPedidoCompraLlegadaValidarDetalleEliminar('<?php echo $c;?>');">
<img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="22" height="22" border="0" /></a>
            -->
              
              <input type="button" name="BtnPedidoCompraLlegadaDetalleGuardar_<?php echo $c;?>" id="BtnGuardar_<?php echo $c;?>" value="Guardar" onclick="FncPedidoCompraLlegadaValidarDetalleGuardar('<?php echo $c;?>');" />
              
            </td>
            <td align="left" valign="top">
            <div id="CapPedidoCompraLlegdaDetalleAccion_<?php echo $c;?>"></div>
            
            
            </td>
            </tr>
            <?php                           
            $c++;
            }
            ?>
            
            <?php
			for($i=$c;$i<=($c+5);$i++){
			?>
            <tr>
            <td align="left" valign="top"><?php echo $i;?></td>
            <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpOrdenCompraId_<?php echo $i;?>" type="text" id="CmpOrdenCompraId_<?php echo $i;?>" value="" size="20" maxlength="25" /></td>
            <td align="left" valign="top">

<input name="CmpPedidoCompraDetalleId_<?php echo $i;?>" type="hidden" id="CmpPedidoCompraDetalleId_<?php echo $i;?>" value="" size="20" maxlength="20" readonly="readonly" />    

<input name="CmpProductoId_<?php echo $i;?>" type="hidden" id="CmpProductoId_<?php echo $i;?>" value="" size="20" maxlength="20" readonly="readonly" />
<input name="CmpPedidoCompraLlegadaDetalleId_<?php echo $i;?>" type="hidden" id="CmpPedidoCompraLlegadaDetalleId_<?php echo $i;?>" value="" size="20" maxlength="20" readonly="readonly" />    
            
<input class="EstFormularioCaja"  name="CmpProductoCodigoOriginal_<?php echo $i;?>" type="text" id="CmpProductoCodigoOriginal_<?php echo $i;?>" value="" size="10" maxlength="20" />
			
			</td>
            <td align="left" valign="top">
            
			<input class="EstFormularioCaja"  name="CmpProductoNombre_<?php echo $i;?>" type="text"  id="CmpProductoNombre_<?php echo $i;?>" value="" size="30" maxlength="255" />
            
            </td>
            <td align="left" valign="top"><input class="<?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'EstFormularioCaja':'EstFormularioCajaDeshabilitada');?>"  name="CmpClienteNombre_<?php echo $i;?>" type="text"  id="CmpClienteNombre_<?php echo $i;?>" value="" size="25" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">
			

<?php
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$DatPedidoCompraLlegadaDetalle->RtiId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];

?>
            
<select class="EstFormularioCombo" <?php echo (empty($DatPedidoCompraLlegadaDetalle->PldId)?'':'disabled="disabled"');?>    name="CmpProductoUnidadMedida_<?php echo $i;?>" id="CmpProductoUnidadMedida_<?php echo $i;?>" >

<option value="">Escoja una opcion</option>

	<?php
    foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
    ?>
		<option <?php echo (($DatPedidoCompraLlegadaDetalle->UmeId == $DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>    
	
    <?php	
    }
    ?>
</select>

            
            
            
            
            </td>
            <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpPedidoCompraLlegadaDetalleCantidad_<?php echo $i;?>" type="text" id="CmpPedidoCompraLlegadaDetalleCantidad_<?php echo $i;?>" value="" size="4" maxlength="10" /></td>
            <td align="left" valign="top">-</td>
            <td align="left" valign="top">
            
            <select class="EstFormularioCombo"   name="CmpPedidoCompraLlegadaDetalleEstado_<?php echo $i;?>" id="CmpPedidoCompraLlegadaDetalleEstado_<?php echo $i;?>" >
              <option value="">Escoja una opcion</option>

				<option selected="selected" value="3">Conforme</option>
                
				<option value="1">Pendiente</option>
				<option value="7">No Llego</option>
                <option value="8">Incompleto</option>
                <option value="9">Dañado</option>
                <option value="10">Error/Eliminar</option>
                
            </select></td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpPedidoCompraLlegadaDetalleObservacion_<?php echo $i;?>" cols="18" rows="2"  id="CmpPedidoCompraLlegadaDetalleObservacion_<?php echo $i;?>"></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">
              
              
  <input type="button" name="BtnPedidoCompraLlegadaDetalleGuardar_<?php echo $i;?>" id="BtnPedidoCompraLlegadaDetalleGuardar_<?php echo $i;?>" value="Identificar" onclick="FncPedidoCompraLlegadaValidarDetalleGuardar('<?php echo $i;?>');" />
              
  <!--<input type="button" name="BtnPedidoCompraLlegadaDetalleEliminar_<?php echo $i;?>" id="BtnEliminar_<?php echo $i;?>" value="Eliminar" onclick="FncPedidoCompraLlegadaValidarDetalleEliminar('<?php echo $i;?>');" />-->
              
  <!--<a  href="javascript:FncPedidoCompraLlegadaValidarDetalleGuardar('<?php echo $i;?>');">
<img id="BtnPedidoCompraLlegadaIdentificar_<?php echo $i;?>" src="imagenes/acciones/identificar2.png" width="22" height="22" border="0" title="Identificar" alt="[Identificar]" align="absmiddle" />
</a>

<a href="javascript:FncPedidoCompraLlegadaValidarDetalleGuardar('<?php echo $i;?>');">
<img  id="BtnPedidoCompraLlegadaGuardar_<?php echo $i;?>"  style="visibility:hidden;"  src="imagenes/acciones/identificar2.png" width="22" height="22" border="0" title="Identificar" alt="[Identificar]" align="absmiddle" />
</a>
 
<a  href="javascript:FncPedidoCompraLlegadaValidarDetalleEliminar('<?php echo $i;?>');">
<img id="BtnPedidoCompraLlegadaEliminar_<?php echo $i;?>"  style="visibility:hidden;"  align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="22" height="22" border="0" />
</a>-->
              
</td>
            <td align="left" valign="top">
 
            <div id="CapPedidoCompraLlegdaDetalleAccion_<?php echo $c;?>"></div>
            
            </td>
            </tr>
            
            <?php
			
			}
			?>
            
            
            
            </tbody>
            </table>
    <br />
    <?php
        }
        ?>
        

