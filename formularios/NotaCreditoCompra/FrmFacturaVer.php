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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFactura.css');
</style>
<?php

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFactura.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsFactura = new ClsFactura();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();


if (isset($_SESSION['InsFacturaDetalle'.$Identificador])){	
	$_SESSION['InsFacturaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFacturaEditar.php');

$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios(NULL,NULL,"FtaNumero","DESC",NULL);
$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var FacturaDetalleEditar = 2;
var FacturaDetalleEliminar = 2;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/
	FncFacturaEstablecerMoneda();
	FncFacturaEstablecerCondicionPago();
	FncFacturaEstablecerRegimen();	
	
	FncFacturaDetalleListar();
	
});
</script>


<div class="EstCapMenu">
  <?php
			if($PrivilegioVistaPreliminar){
			?>
            
          
           
           <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
           
           
  <?php
			}
			?>
  <?php
			if($PrivilegioImprimir){
			?>
          
           
           <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
           
           
  <?php
			}
			?>
            
            
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   

<?php
/*if($PrivilegioListadoClientePago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Factura/FrmFacturaPagoListado.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}*/
?>
    <?php
if($PrivilegioAuditoriaVer){
?>

 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>

  <?php
}
?>
         

</div>

<div class="EstCapContenido">

	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td><span class="EstFormularioTitulo">VER
        FACTURA</span></td>
      </tr>
      <tr>
        <td width="961">		
        
              
                    <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFactura->FacTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFactura->FacTiempoModificacion;?></span></td>
            <td>&nbsp;</td>
            <td>Creado por: </td>
            <td>
			
			  <span class="EstFormularioDatoRegistro"><?php echo $InsFactura->UsuUsuario;?></span>			</td>
          </tr>
        </table>
        
        </div>   
		
		<br />
		
<ul class="tabs">
	<li><a href="#tab1">Factura</a></li>

	<li><a href="#tab3">Regimen</a></li>
    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
      
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la Factura </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="2" align="center">R.U.C. <?php echo $EmpresaCodigo;?></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="2" align="center">FACTURA
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="right">
               
               <select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
               <option value="">-</option>
                   <?php
			  foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
			  ?>
                   <option <?php if($InsFactura->FtaId == $DatFacturaTalonario->FtaId){ echo 'selected="selected"';}?> value="<?php echo $DatFacturaTalonario->FtaId;?>" ><?php echo $DatFacturaTalonario->FtaNumero;?></option>
                   <?php
			  }
			  ?>
                 </select>               </td>
               <td align="left"><input readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsFactura->FacId;?>" size="20" maxlength="20" />               </td>
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
             <tr>
               <td>&nbsp;</td>
               <td>Se&ntilde;ores:                 </td>
               <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsFactura->CliNombre;?> <?php echo $InsFactura->CliApellidoPaterno;?> <?php echo $InsFactura->CliApellidoMaterno;?>" />
                   <!--       <br /><br />
        <a href="javascript:void(0);" onclick="popupCssShow('default.php?page=pagina-2', 460);" title="Abrir PopUp 1">Abrir PopUp 2</a>-->               </td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>R.U.C. N&deg;:                 </td>
               <td><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsFactura->CliNumeroDocumento;?>" />
               </label></td>
               <td>&nbsp;</td>
               <td>Guia de Remisi&oacute;n</td>
               <td>
               
               
               <!--<select disabled="disabled" name="CmpGuiaRemision" id="CmpGuiaRemision" class="EstFormularioCombo">
            <option value="">Ninguna</option>
            <?php
			/*foreach($ArrGuiaRemisiones as $DatGuiaRemision){
			?>
            <option <?php if($InsFactura->GreId == $DatGuiaRemision->GreId){ echo 'selected="selected"';}?>value="<?php echo $DatGuiaRemision->GreId;?>"><?php echo $DatGuiaRemision->GrtNumero;?> - <?php echo $DatGuiaRemision->GreId;?></option>
            <?php
			}*/
			?>
            </select>-->
            
            <input readonly="readonly" maxlength="20" class="EstFormularioCaja" type="text" name="CmpGuiaRemision" id="CmpGuiaRemision" value="<?php  if(!empty($InsFactura->GrtNumero) and !empty($InsFactura->GreId)){ echo $InsFactura->GrtNumero." - ".$InsFactura->GreId; }?>" />
              <input type="hidden" size="5" id="CmpGreId" name="CmpGreId" value="<?php echo $InsFactura->GreId;?>" />
              <input type="hidden" size="5" id="CmpGrtId" name="CmpGrtId" value="<?php echo $InsFactura->GrtId;?>" />
              <input type="hidden" size="5" id="CmpGrtNumero" name="CmpGrtNumero" value="<?php echo $InsFactura->GrtNumero;?>" />            </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Direccion:</td>
               <td><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsFactura->FacDireccion;?>" />
                 </label></td>
               <td>&nbsp;</td>
               <td>Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsFactura->FacFechaEmision)){ echo date("d/m/Y");}else{ echo $InsFactura->FacFechaEmision; }?>" size="15" maxlength="10" />
                  </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observac&oacute;n Interna:</td>
               <td><textarea readonly="readonly" name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsFactura->FacObservacion);?></textarea></td>
               <td>&nbsp;</td>
               <td valign="top">Observac&oacute;n Impresa:</td>
               <td><textarea readonly="readonly" name="CmpObservacionImpresa" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsFactura->FacObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td>Incluye Impuesto:</td>
               <td><?php
switch($InsFactura->FacIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
                 <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  disabled="disabled"  >
                   <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                   <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                 </select></td>
               <td>&nbsp;</td>
               <td>Impuesto:</td>
               <td><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsFactura->FacPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsFactura->FacPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" />
(%)</td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td>Moneda:</td>
               <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                 <option value="">Escoja una opcion</option>
                 <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                 <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFactura->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                 <?php
			  }
			  ?>
               </select></td>
               <td>&nbsp;</td>
               <td>Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
               <td>
               
               <table>
               <tr>
               <td>
               
               <input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncFacturaDetalleListar();" value="<?php if (empty($InsFactura->FacTipoCambio)){ echo "";}else{ echo $InsFactura->FacTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
               
               </td>
               <td>
               
               </td>
               </tr>
               </table>
               
               </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Condicion de Pago:</td>
               <td><select disabled="disabled" name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                 <option <?php if($InsFactura->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                 <?php  
					}
					?>
                 </select></td>
               <td>&nbsp;</td>
               <td>Cantidad de Dias:</td>
               <td><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsFactura->FacCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Estado:</td>
               <td><?php
			switch($InsFactura->FacEstado){
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
                   <option <?php echo $OpcEstado7;?> value="7">Reservado</option>                     
                   </select>               </td>
               <td>&nbsp;</td>
               <td>Cancelado:</td>
               <td><?php
			switch($InsFactura->FacCancelado){
				case 1:
					$OpcCancelado1 = 'selected="selected"';
				break;
			
				case 2:
					$OpcCancelado2 = 'selected="selected"';
				break;

			
			}
?>
                 <select  disabled="disabled" class="EstFormularioCombo" id="CmpCancelado" name="CmpCancelado">
                   <option <?php echo $OpcCancelado1;?> value="1">Si</option>
                   <option <?php echo $OpcCancelado2;?> value="2">No</option>
                   </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Obsequio:</td>
               <td><?php
			switch($InsFactura->FacObsequio){
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
               <td>Operacion  sujeta a SPOT:</td>
               <td><?php
			switch($InsFactura->FacSpot){
					case 1:
					$OpcSpot1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcSpot2 = 'selected="selected"';
				break;
				
			}
			?>
                 <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpSpot" name="CmpSpot">
                   <option <?php echo $OpcSpot1;?> value="1">Si</option>
                   <option <?php echo $OpcSpot2;?> value="2">No</option>
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
               <td width="4">&nbsp;</td>
               <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">Almacen/Taller: Documentos relacionados </span></td>
               <td width="5">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Ord. Trabajo:</td>
               <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsFactura->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                 <input size="3" type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsFactura->FccId;?>" /></td>
               <td align="left" valign="top">Cotizacion:</td>
               <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsFactura->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Orden Venta:</td>
               <td align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsFactura->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Ficha Salida:</td>
               <td align="left" valign="top"><input name="CmpAlmacenMovimientoSalidaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaId"  tabindex="3" value="<?php  echo $InsFactura->AmoId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">Vehiculos: Documentos relacionados </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proforma Vehiculo:</td>
               <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Orden Venta Vehiculo:</td>
               <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="4">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td width="5">&nbsp;</td>
               <td width="5">&nbsp;</td>
               <td width="5">&nbsp;</td>
               <td width="5">&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td colspan="2"><div class="EstFormularioAccion" id="CapFacturaDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="46%"><span class="EstFormularioSubTitulo"> Items
                 que componen la factura</span> </td>
               <td width="52%" align="right"><a href="javascript:FncFacturaDetalleListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
                   <input type="hidden" name="CmpFacturaDetalleAccion" id="CmpFacturaDetalleAccion" value="AccFacturaDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapFacturaDetalles" class="EstCapFacturaDetalles" > </div></td>
               <td><div id="CapFacturaDetallesResultado"> </div></td>
             </tr>
           </table>
         </div></td>
         </tr>
       
              <tr>
                <td width="51%" valign="top">
                
                <div class="EstFormularioArea">
                <table width="100%" border="0" cellpadding="2" cellspacing="2"   class="EstFormulario">
                  <tr>
                    <td width="2%">&nbsp;</td>
                    <td colspan="2"><div class="EstFormularioAccion" id="CapFacturaAlmacenMovimientoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="2%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="64%"><span class="EstFormularioSubTitulo">Movimientos de Almacen Relacionados </span></td>
                    <td width="32%" align="right"><a href="javascript:FncFacturaAlmacenMovimientoListar();"> <img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
                        <input type="hidden" name="CmpFacturaAlmacenMovimientoAccion" id="CmpFacturaAlmacenMovimientoAccion" value="AccFacturaAlmacenMovimientoRegistrar.php" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapFacturaAlmacenMovimientos" class="EstCapFacturaAlmacenMovimientos" > </div></td>
                    <td><div id="CapFacturaAlmacenMovimientosResultado"> </div></td>
                  </tr>
                </table>
                </div>                </td>
                <td width="49%" valign="top">&nbsp;</td>
              </tr>
              <tr>
         <td colspan="2" valign="top">
         
         
         <!--<div class="EstFormularioArea" >
           <table width="62%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="3%">&nbsp;</td>
               <td width="97%" align="left"><span class="EstFormularioSubTitulo">Notas de Entrega</span></td>
             </tr>
             <tr>
               <td height="100">&nbsp;</td>
               <td align="left" valign="top"><div id="CapNotaEntregas"></div></td>
             </tr>
           </table>
         </div>-->         </td>
         </tr>
         </table>
		 
	
 	
    </div>
    
    

     <div id="tab3" class="tab_content">
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td width="97%" valign="top"><div class="EstFormularioArea">
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="7"><span class="EstFormularioSubTitulo">Datos del Regimen</span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="3">&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="center">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>Numero del Comprobante:</td>
                 <td colspan="3"><input name="CmpRegimenComprobanteNumero" type="text" class="EstFormularioCaja" id="CmpRegimenComprobanteNumero" tabindex="5" value="<?php echo $InsFactura->FacRegimenComprobanteNumero;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 <td>Fecha de Comprobante:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                 <td align="center"><input name="CmpRegimenComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpRegimenComprobanteFecha" tabindex="6" value="<?php echo $InsFactura->FacRegimenComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>Regimen:</td>
                 <td colspan="3"><select disabled="disabled" class="EstFormularioCombo" name="CmpRegimenId" id="CmpRegimenId">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrRegimenes as $DatRegimen){
			?>
                   <option value="<?php echo $DatRegimen->RegId?>" <?php if($InsFactura->RegId==$DatRegimen->RegId){ echo 'selected="selected"';} ?> ><?php echo $DatRegimen->RegNombre?></option>
                   <?php
			}
			?>
                 </select></td>
                 <td><div id="CapRegimenBuscar"></div></td>
                 <td>Porcentaje de Regimen:</td>
                 <td><input name="CmpRegimenPorcentaje" type="text"  class="EstFormularioCaja" id="CmpRegimenPorcentaje" value="<?php if (empty($InsFactura->FacRegimenPorcentaje)){ echo "";}else{ echo $InsFactura->FacRegimenPorcentaje; } ?>" size="10" maxlength="10" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaRegimenMonto"></span></span>):</td>
                 <td colspan="3"><input name="CmpRegimenMonto" type="text"  class="EstFormularioCaja" id="CmpRegimenMonto" value="<?php if (empty($InsFactura->FacRegimenMonto)){ echo "";}else{ echo number_format($InsFactura->FacRegimenMonto,2); } ?>" size="15" maxlength="10" readonly="readonly" /></td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="center"></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="3">&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="center"></td>
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

