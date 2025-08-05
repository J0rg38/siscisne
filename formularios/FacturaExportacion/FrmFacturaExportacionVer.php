<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php //$PrivilegioListadoClientePago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Listado"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionDetalleFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaExportacionAlmacenMovimientoFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFacturaExportacion.css');
</style>
<?php

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFacturaExportacion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsFacturaExportacion = new ClsFacturaExportacion();
$InsFacturaExportacionTalonario = new ClsFacturaExportacionTalonario();
$InsTipoDocumento = new ClsTipoDocumento();

$InsCondicionPago = new ClsCondicionPago();

$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();

if (isset($_SESSION['InsFacturaExportacionDetalle'.$Identificador])){	
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaExportacionDetalle'.$Identificador]);
}
	
if (isset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFacturaExportacionEditar.php');

$ResFacturaExportacionTalonario = $InsFacturaExportacionTalonario->MtdObtenerFacturaExportacionTalonarios(NULL,NULL,"FetNumero","DESC",NULL,$_SESSION['SisSucId']);
$ArrFacturaExportacionTalonarios = $ResFacturaExportacionTalonario['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var FacturaExportacionDetalleEditar = 2;
var FacturaExportacionDetalleEliminar = 2;

//var FacturaExportacionAlmacenMovimientoEliminar = 2;
//var FacturaExportacionNotaEntregaEliminar = 2;


$().ready(function (){
/*
Configuracion carga de datos y animacion
*/	
	FncFacturaExportacionEstablecerMoneda();
	FncFacturaExportacionEstablecerCondicionPago();
	FncFacturaExportacionEstablecerRegimen();	
			
	FncFacturaExportacionDetalleListar();
	
	FncFacturaExportacionAlmacenMovimientoListar();


});


</script>

<div class="EstCapMenu">
	<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            
<div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>','<?php echo ($InsFacturaExportacion->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>




        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
       <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFacturaExportacion->FexId;?>','<?php echo $InsFacturaExportacion->FetId;?>','<?php echo ($InsFacturaExportacion->FetNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
     
     
     
			<?php
			}
			?>   
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            <?php
if($PrivilegioListadoClientePago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>FacturaExportacion/FrmFacturaExportacionPagoListado.php?Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}
?>
<?php
if($PrivilegioAuditoriaVer){
?>
<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsFacturaExportacion->FexId;?>&Ta=<?php echo $InsFacturaExportacion->FetId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>  
  <?php
}
?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER FACTURA DE EXPORTACION</span></td>
      </tr>
      <tr>
        <td>		
        
        
                     
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->FexTiempoCreacion;?></span></td>
            <td></td>
			<td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->FexTiempoModificacion;?></span></td>
			<td></td>
			<td>Creado por:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsFacturaExportacion->UsuUsuario;?></span></td>
          </tr>
        </table>
		</div>                                
        
        
 <br />
	
  <ul class="tabs">
	<li><a href="#tab1">Factura</a></li>
   
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->         
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td width="100%" colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td width="4">&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo"> Datos de la factura
                 
               </span></td>
               <td width="4">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="137">&nbsp;</td>
               <td width="308">&nbsp;</td>
               <td width="4">&nbsp;</td>
               <td colspan="2" align="center">R.U.C. <?php echo $EmpresaCodigo;?></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="2" align="center">FACTURA DE EXPORTACION
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td width="110" align="right" valign="bottom"><select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
               <option value="">-</option>
                   <?php
			  foreach($ArrFacturaExportacionTalonarios as $DatFacturaExportacionTalonario){
			  ?>
                   <option <?php if($InsFacturaExportacion->FetId==$DatFacturaExportacionTalonario->FetId){ echo 'selected="selected"';}?> value="<?php echo $DatFacturaExportacionTalonario->FetId;?>" ><?php echo $DatFacturaExportacionTalonario->FetNumero;?></option>
                   <?php
			  }
			  ?>
                 </select>               </td>
               <td width="172" align="left" valign="bottom">Nº
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsFacturaExportacion->FexId;?>" size="20" maxlength="20" />               </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Se&ntilde;ores: </td>
               <td colspan="4"><table>
                 <tr>
                   <td><a href="javascript:FncClienteNuevo();"></a></td>
                   <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                     <option <?php if($InsFacturaExportacion->TdoId==$DatTipoDocumento->TdoId){ echo 'selected="selected"';}?> value="<?php echo $DatTipoDocumento->TdoId; ?>">[<?php echo $DatTipoDocumento->TdoCodigo; ?>] <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                     <?php
			}			
			?>
                     </select></td>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsFacturaExportacion->CliNumeroDocumento;?>" /></td>
                   <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"></a></td>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsFacturaExportacion->CliNombre;?> <?php echo $InsFacturaExportacion->CliApellidoPaterno;?> <?php echo $InsFacturaExportacion->CliApellidoMaterno;?>" /></td>
                   <td>&nbsp;</td>
                   <td><div id="CapClienteBuscar"></div></td>
                   </tr>
                 <tr> </tr>
               </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsFacturaExportacion->FexDireccion;?>" />
                 </label></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsFacturaExportacion->FexFechaEmision)){ echo date("d/m/Y");}else{ echo $InsFacturaExportacion->FexFechaEmision; }?>" size="15" maxlength="10" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaci&oacute;n Interna:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFacturaExportacion->FexObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsFacturaExportacion->FexObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Impuesto: <br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsFacturaExportacion->FexPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsFacturaExportacion->FexPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
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
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFacturaExportacion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                   </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncFacturaExportacionDetalleListar();" value="<?php if (empty($InsFacturaExportacion->FexTipoCambio)){ echo "";}else{ echo $InsFacturaExportacion->FexTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Condicion de Pago:</td>
               <td align="left" valign="top"><select disabled="disabled" name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                 <option <?php if($InsFacturaExportacion->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                 <?php  
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Cantidad de Dias:</td>
               <td align="left" valign="top"><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsFacturaExportacion->FexCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado:</td>
               <td align="left" valign="top"><?php
			switch($InsFacturaExportacion->FexEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 5:
					$OpcEstado5 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
				
				case 7:
					$OpcEstado7 = 'selected="selected"';
				break;

			
			}
			?>
                   <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                     <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                     <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
					<option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                    <option <?php echo $OpcEstado7;?> value="7">Anulado</option>
                   </select>               </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Obsequio:</td>
               <td align="left" valign="top"><?php
			switch($InsFacturaExportacion->FexObsequio){
				case 1:
					$OpcObsequio1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcObsequio2 = 'selected="selected"';
				break;
				
			
			}
			?>
                 <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpObsequio" name="CmpObsequio">
                   <option <?php echo $OpcObsequio1;?> value="1">Si</option>
                   <option <?php echo $OpcObsequio2;?> value="2">No</option>
                 </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             </table>
         </div></td>
       </tr>

       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS RELACIONADOS</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="4">&nbsp;</td>
               <td colspan="8" align="left" valign="top">Almacen/Taller</td>
               <td width="5">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. Trabajo:</td>
               <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                 <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsFacturaExportacion->FccId;?>" /></td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Orden Venta:</td>
               <td width="5" align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td width="5" align="left" valign="top">Ficha Salida:</td>
               <td width="5" align="left" valign="top"><input name="CmpAlmacenMovimientoSalidaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaId"  tabindex="3" value="<?php  echo $InsFacturaExportacion->AmoId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Otras Fichas:</td>
               <td colspan="7" align="left" valign="top"><div id="CapFacturaExportacionAlmacenMovimientos" class="EstCapFacturaExportacionAlmacenMovimientos" ></div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
         </div></td>
       </tr>
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapFacturaExportacionDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncFacturaExportacionDetalleListar();">
                 <input type="hidden" name="CmpFacturaExportacionDetalleAccion" id="CmpFacturaExportacionDetalleAccion" value="AccFacturaExportacionDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="1%"><div id="CapFacturaExportacionDetallesResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapFacturaExportacionDetalles" class="EstCapFacturaExportacionDetalles" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
            </table>
		 
	
	
     
   </div>

	
</div>              
        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
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


