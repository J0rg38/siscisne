<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPedidoCompra.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPedidoCompra.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsPedidoCompra = new ClsPedidoCompra();
$InsTipoOperacion = new ClsTipoOperacion();
$InsClienteTipo = new ClsClienteTipo();

$InsMoneda = new ClsMoneda();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();

$InsTipoDocumento = new ClsTipoDocumento();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsPedidoCompraDetalle'.$Identificador])){	
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPedidoCompraDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPedidoCompraEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false,$oSinSucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$_SESSION['SesionSucursal'],1,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];
?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncPedidoCompraDetalleListar();
		
});

var PedidoCompraDetalleEditar = 2;
var PedidoCompraDetalleEliminar = 2;
var PedidoCompraDetalleVerEstado = 1;

</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPedidoCompra->PcoId;?>&Su=<?php echo $InsPedidoCompra->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER ESTADO DE PEDIDO DE COMPRA</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPedidoCompra->PcoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPedidoCompra->PcoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Pedido de Compra</a></li>

</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Pedido de Compra
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPedidoCompra->PcoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Tipo de Pedido: </td>
               <td align="left" valign="top"><?php
switch($InsPedidoCompra->PcoTipoPedido){

	case "1-ZGAR":
		$OpcTipoPedido1 = 'selected = "selected"';
	break;
	
	case "2-ZVOR":
		$OpcTipoPedido2 = 'selected = "selected"';						
	break;
	
		case "3-YRUSH":
		$OpcTipoPedido3 = 'selected = "selected"';						
	break;
	
		case "4-STK":
		$OpcTipoPedido4 = 'selected = "selected"';						
	break;

}
?>
                 <select disabled="disabled"   class="EstFormularioCombo" name="CmpTipoPedido" id="CmpTipoPedido"    >
                   <option <?php echo $OpcTipoPedido1;?> value="1-ZGAR">ZGAR (GARANTIAS)</option>
                   <option <?php echo $OpcTipoPedido2;?> value="2-ZVOR">ZVOR (VEHICULO DETENIDO)</option>
                   <option <?php echo $OpcTipoPedido3;?> value="3-YRUSH">YRUSH (EMERGENCIA)</option>
                   <option <?php echo $OpcTipoPedido4;?> value="4-STK">STK (STOCK)</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsPedidoCompra->PcoFecha)){ echo date("d/m/Y");}else{ echo $InsPedidoCompra->PcoFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Hora :<br />
                 <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
               <td align="left" valign="top"><input name="CmpHora" type="text" class="EstFormularioCajaHora" id="CmpHora" value="<?php  echo $InsPedidoCompra->PcoHora;?>" size="15" maxlength="10" readonly="readonly" />
                 <!--   <a href="javascript:FncCitaCalendarioCargarFormulario('VerCalendarioFull')"><img src="imagenes/acciones/calendario_full.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" /></a>
              --></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo Doc.:
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsPedidoCompra->CliId;?>" size="3" /></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                 <option value="">Escoja una opcion</option>
                 <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                 <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPedidoCompra->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                 <?php
	}
	?>
               </select></td>
               <td align="left" valign="top">Num. Doc.:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="sprytextfield5">
                     <input tabindex="4" class="EstFormularioCajaDeshabilitada" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsPedidoCompra->CliNumeroDocumento;?>"   />
                     </span></td>
                   <td><div id="CapClienteBuscar"></div></td>
                   </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td align="left" valign="top"><span id="sprytextfield2">
                 <label>
                   <input  tabindex="2" class="EstFormularioCajaDeshabilitada" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsPedidoCompra->CliNombre;?> <?php echo $InsPedidoCompra->CliApellidoPaterno;?> <?php echo $InsPedidoCompra->CliApellidoMaterno;?>"  />
                   </label>
                 </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPedidoCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncPedidoCompraDetalleListar();" value="<?php if (empty($InsPedidoCompra->PcoTipoCambio)){ echo "";}else{ echo $InsPedidoCompra->PcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Impuesto (%):</td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncFacturaDetalleListar();" value="<?php echo $InsPedidoCompra->PcoPorcentajeImpuestoVenta;?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsPedidoCompra->PcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 31:
							$OpcEstado31 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                    <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
					<option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                    <option <?php echo $OpcEstado31;?> value="31">Correo Enviado</option>
					<option <?php echo $OpcEstado6;?> value="3">Anulado</option>
                   </select>
               </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsPedidoCompra->PcoObservacion;?></textarea></td>
               <td align="left" valign="top">Origen:</td>
               <td align="left" valign="top"><!-- <input type="hidden" name="CmpOrigen" id="CmpOrigen" value="<?php echo $InsPedidoCompra->PcoOrigen;?>" size="3" />-->
                 <?php
                    switch($InsPedidoCompra->PcoOrigen){
						case "PCO":
						  $OpcOrigen1 = 'selected = "selected"';
						break;
						
						case "VDI":
						  $OpcOrigen2 = 'selected = "selected"';
						break;
						
						case "LLA":
						  $OpcOrigen3 = 'selected = "selected"';
						break;
                    }
                    ?>
                 <select  class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen" disabled="disabled" >
                   <option <?php echo $OpcOrigen1;?> value="PCO">Ped. Compra Normal</option>
                   <option <?php echo $OpcOrigen2;?> value="VDI">Ord. Venta</option>
                   <option <?php echo $OpcOrigen3;?> value="LLA">Llamada de Cliente</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Documentos relacionados </span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN"  tabindex="3" value="<?php  echo $InsPedidoCompra->EinVIN;?>" size="20" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. Venta:</td>
               <td align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsPedidoCompra->VdiId;?>" size="20" maxlength="25" readonly="readonly" />
/
  <input name="CmpVentaDirectaOrdenCompraNumero" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaOrdenCompraNumero"  tabindex="3" value="<?php  echo $InsPedidoCompra->VdiOrdenCompraNumero;?>" size="20" maxlength="25" readonly="readonly" /></td>
               <td align="left" valign="top">Orden de Compra: </td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td>&nbsp;</td>
                   <td><input name="CmpOrdenCompraId" id="CmpOrdenCompraId" type="hidden"   tabindex="3" value="<?php  echo $InsPedidoCompra->OcoId;?>" size="20" maxlength="20" />
                     <input name="CmpOrdenCompra" type="text" class="EstFormularioCaja" id="CmpOrdenCompra"  tabindex="3" value="<?php  echo $InsPedidoCompra->OcoId;?>" size="25" maxlength="25" readonly="readonly" /></td>
                   <td>&nbsp;</td>
                   <td></td>
                   </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. Trab./Modalidad</td>
               <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsPedidoCompra->FinId;?>" size="20" maxlength="25" readonly="readonly" />
                 /
                 <input name="CmpFichaIngresoModalidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoModalidad"  tabindex="3" value="<?php  echo $InsPedidoCompra->MinNombre;?>" size="20" maxlength="45" readonly="readonly" />
                 <span class="EstFormularioSubTitulo">
                   <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php  echo $InsPedidoCompra->FccId;?>" />
                 </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><input type="hidden" name="CmpPedidoCompraDetalleAccion" id="CmpPedidoCompraDetalleAccion" value="AccPedidoCompraDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="50%"><span class="EstFormularioSubTitulo">PRODUCTOS	</span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncPedidoCompraDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="0%"><div id="CapPedidoCompraDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapPedidoCompraDetalles" class="EstCapPedidoCompraDetalles" > </div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       </table>
    </div>    
    

    
   
    
    
<div>		
 
 
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
