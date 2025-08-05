<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php //$PrivilegioListadoClientePago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Listado"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaAlmacenMovimientoFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssBoleta.css');
</style>
<?php

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjBoleta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsBoleta = new ClsBoleta();
$InsBoletaTalonario = new ClsBoletaTalonario();
$InsTipoDocumento = new ClsTipoDocumento();

$InsCondicionPago = new ClsCondicionPago();

$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();

if (isset($_SESSION['InsBoletaDetalle'.$Identificador])){	
	$_SESSION['InsBoletaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsBoletaDetalle'.$Identificador]);
}
	
if (isset($_SESSION['InsBoletaAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccBoletaEditar.php');

$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,$InsBoleta->SucId,true);
$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var BoletaDetalleEditar = 2;
var BoletaDetalleEliminar = 2;

var BoletaAlmacenMovimientoEliminar = 2;
//var BoletaAlmacenMovimientoEliminar = 2;
//var BoletaNotaEntregaEliminar = 2;


$().ready(function (){
/*
Configuracion carga de datos y animacion
*/	
	FncBoletaEstablecerMoneda();
	FncBoletaEstablecerCondicionPago();
	FncBoletaEstablecerRegimen();	
			
	FncBoletaDetalleListar();
	
	FncBoletaAlmacenMovimientoListar();
	FncBoletaPagoListar();

	FncClienteNotaVerificar();
	
	
});


</script>

<div class="EstCapMenu">
	<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            
<div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>','<?php echo ($InsBoleta->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>




        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
       <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>','<?php echo ($InsBoleta->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
     
     
     
			<?php
			}
			?>   
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            <?php
/*if($PrivilegioListadoClientePago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Boleta/FrmBoletaPagoListado.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}*/
?>
<?php
if($PrivilegioAuditoriaVer){
?>
<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>  
  <?php
}
?>   

	
<?php
if(empty($GET_dia) and !empty($InsBoleta->VdiId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoVentaDirectaCargarFormulario('<?php echo $InsBoleta->VdiId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

<?php	
}
?>

<?php
if(empty($GET_dia) and !empty($InsBoleta->OvvId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('<?php echo $InsBoleta->OvvId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

<?php	
}
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER BOLETA</span></td>
      </tr>
      <tr>
        <td>		
        
        
                     
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->BolTiempoCreacion;?></span></td>
            <td></td>
			<td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->BolTiempoModificacion;?></span></td>
			<td></td>
			<td>Creado por:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->UsuUsuario;?></span></td>
          </tr>
        </table>
		</div>                                
        
        
 <br />
	
  <ul class="tabs">
	<li><a href="#tab1">Boleta</a></li>
    <li><a href="#tab2">Regimen</a></li>
      <li><a href="#tab4">Sunat</a></li>
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->         
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td width="4">&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo"> Datos de la boleta
                 
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td width="4">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="137">&nbsp;</td>
               <td width="308">&nbsp;</td>
               <td width="4">&nbsp;</td>
               <td width="110" align="right" valign="bottom"><select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                 <option value="">-</option>
                 <?php
			  foreach($ArrBoletaTalonarios as $DatBoletaTalonario){
			  ?>
                 <option <?php if($InsBoleta->BtaId==$DatBoletaTalonario->BtaId){ echo 'selected="selected"';}?> value="<?php echo $DatBoletaTalonario->BtaId;?>" ><?php echo $DatBoletaTalonario->BtaNumero;?> (<?php echo $DatBoletaTalonario->BtaDescripcion;?>)</option>
                 <?php
			  }
			  ?>
                 </select>               </td>
               <td width="172" align="left" valign="bottom">Nº
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsBoleta->BolId;?>" size="20" maxlength="20" />               </td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Cliente:</td>
               <td colspan="4">
                 <table>
                   <tr>
                     <td>&nbsp;</td>
                     <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                       <option value="">Escoja una opcion</option>
                       <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                       <option <?php if($InsBoleta->TdoId==$DatTipoDocumento->TdoId){ echo 'selected="selected"';}?> value="<?php echo $DatTipoDocumento->TdoId; ?>">[<?php echo $DatTipoDocumento->TdoCodigo; ?>] <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                       <?php
			}			
			?>
                       </select></td>
                     <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsBoleta->CliNumeroDocumento;?>" /></td>
                     <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsBoleta->CliNombre;?> <?php echo $InsBoleta->CliApellidoPaterno;?> <?php echo $InsBoleta->CliApellidoMaterno;?>" />
                     
                     <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsBoleta->CliId;?>" />
                     
<input type="hidden" name="CmpClienteNombre" id="CmpClienteNombre" value="<?php echo $InsBoleta->CliNombre;?>" />
<input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsBoleta->CliApellidoPaterno;?>" />
<input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsBoleta->CliApellidoMaterno;?>" />


</td>
                     <td>&nbsp;</td>
                     </tr>
                   </table>
                   
                   <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
		if($DatOrdenVentaVehiculoPropietario->CliId<>$InsBoleta->CliId){
			
			echo $DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
			echo "<br>";
		}
	}
}
?>


                 </td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsBoleta->BolDireccion;?>" />
                 </label></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsBoleta->BolFechaEmision)){ echo date("d/m/Y");}else{ echo $InsBoleta->BolFechaEmision; }?>" size="15" maxlength="10" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Email:</td>
               <td align="left" valign="top"><input name="CmpClienteEmail" type="text" class="EstFormularioCaja" id="CmpClienteEmail" tabindex="5" value="<?php echo $InsBoleta->CliEmail;?>" size="45" maxlength="255" readonly="readonly"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaci&oacute;n Interna:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsBoleta->BolObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
               <td align="left" valign="top"><textarea readonly="readonly" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsBoleta->BolObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaci&oacute;n Caja:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionCaja" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionCaja"  tabindex="6"><?php echo $InsBoleta->BolObservacionCaja;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Observado:</td>
               <td align="left" valign="top"><?php
			switch($InsBoleta->BolObservado){
				case 1:
					$OpcObservado1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcObservado2 = 'selected="selected"';
				break;
				
			
			}
			?>
                 <select disabled="disabled" tabindex="9" class="EstFormularioCombo" id="CmpObservado" name="CmpObservado">
                   <option <?php echo $OpcObservado1;?> value="1">Si</option>
                   <option <?php echo $OpcObservado2;?> value="2">No</option>
                 </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Leyenda:<br />
                 <span class="EstFormularioSubEtiqueta">(Transf. Grat., Descts, etc.)</span></td>
               <td align="left" valign="top"><textarea name="CmpLeyenda" cols="25" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpLeyenda" tabindex="7"><?php echo stripslashes($InsBoleta->BolLeyenda);?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">IGV:<br />
                 (%)</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsBoleta->BolPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsBoleta->BolPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
               </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">ISC:<br />
                 (%)</td>
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoSelectivo" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoSelectivo" onchange="FncBoletaDetalleListar();" value="<?php echo $InsBoleta->BolPorcentajeImpuestoSelectivo;?>" size="10" maxlength="10" readonly="readonly" /></td>
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
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsBoleta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncBoletaDetalleListar();" value="<?php if (empty($InsBoleta->BolTipoCambio)){ echo "";}else{ echo $InsBoleta->BolTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Cancelado:</td>
               <td><?php
			switch($InsBoleta->BolCancelado){
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
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Obsequio:</td>
               <td align="left" valign="top"><?php
			switch($InsBoleta->BolObsequio){
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
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Estado:</td>
               <td align="left" valign="top"><?php
			switch($InsBoleta->BolEstado){
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
                 </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">CONDICIONES DE VENTA</span></td>
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
                 <option <?php if($InsBoleta->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                 <?php  
					}
					?>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Cantidad de Dias:</td>
               <td align="left" valign="top"><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsBoleta->BolCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha de Vencimiento:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input readonly="readonly" tabindex="6" class="EstFormularioCajaDeshabilitada" name="CmpFechaVencimiento" type="text" id="CmpFechaVencimiento" value="<?php  echo $InsBoleta->BolFechaVencimiento;?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Descuento:</td>
               <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTotalDescuento" type="text" id="CmpTotalDescuento" size="10" maxlength="10" value="<?php echo number_format($InsBoleta->BolTotalDescuento,2);?>" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS RELACIONADOS</span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top">Almacen/Taller<span class="EstFormularioSubTitulo">
               <input name="CmpAlmacenMovimientoSalidaIdAux" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaIdAux"  tabindex="3" value="<?php  echo $InsBoleta->AmoId;?>" size="20" maxlength="20" readonly="readonly" />
               <input name="CmpPagoId" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpPagoId"  tabindex="3" value="<?php  echo $InsBoleta->PagId;?>" size="20" maxlength="20" readonly="readonly" />
               </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><table>
                 <tr class="EstFormulario">
                   <td align="left" valign="top">Ord. Trabajo:</td>
                   <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsBoleta->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                     <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsBoleta->FccId;?>" /></td>
                   <td align="left" valign="top">Cotizacion:</td>
                   <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsBoleta->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                   <td align="left" valign="top">Orden Venta:</td>
                   <td width="5" align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsBoleta->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                   <td width="5" align="left" valign="top">Abono:</td>
                   <td width="5" align="left" valign="top"><span class="EstFormularioSubTitulo">
                     <input name="CmpPagoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPagoId"  tabindex="3" value="<?php  echo $InsBoleta->PagId;?>" size="20" maxlength="20" readonly="readonly" />
                   </span></td>
                   </tr>
               </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top">Vehiculos</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><table>
                 <tr class="EstFormulario">
                   <td align="left" valign="top">Proforma Vehiculo:</td>
                   <td align="left" valign="top"><input name="CmpCotizacionVehiculoId2" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId2"  tabindex="3" value="<?php  echo $InsBoleta->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                   <td align="left" valign="top">Orden Venta Vehiculo:</td>
                   <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsBoleta->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="6" align="left" valign="top">Usuario/Vendedor</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="6" align="left" valign="top"><table>
                 <tr class="EstFormulario">
                   <td align="left" valign="top">Usuario:</td>
                   <td align="left" valign="top"><input name="CmpUsuario" type="text" class="EstFormularioCajaDeshabilitada" id="CmpUsuario"  tabindex="3" value="<?php  echo $InsBoleta->BolUsuario;?>" size="20" maxlength="20" readonly="readonly" /></td>
                   <td align="left" valign="top">Vendedor:</td>
                   <td align="left" valign="top"><input name="CmpVendedor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVendedor"  tabindex="3" value="<?php  echo $InsBoleta->BolVendedor;?>" size="20" maxlength="20" readonly="readonly" />
                     <input type="hidden" name="CmpNumeroPedido" id="CmpNumeroPedido" value="<?php echo $InsBoleta->BolNumeroPedido;?>" /></td>
                 </tr>
               </table></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">ABONO</span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><input <?php echo (($InsBoleta->BolProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" disabled="disabled" />
Procesar comprobante <br />
<input <?php echo (($InsBoleta->BolEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" disabled="disabled" />
Enviar a SUNAT &nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Monto:</td>
               <td align="left" valign="top"><input name="CmpAbono" type="text" class="EstFormularioCaja" id="CmpAbono" value="<?php echo number_format($InsBoleta->BolAbono,2);?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>

       <tr>
         <td width="74%" valign="top"><div id="CapFacturaDetalle" class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="7"><span class="EstFormularioSubTitulo">Items </span>
                 <input type="hidden" name="CmpFacturaDetalleItem" id="CmpFacturaDetalleItem" />
                 <input type="hidden" name="CmpFacturaDetalleId" id="CmpFacturaDetalleId" />
                 <!--           <input readonly="readonly" name="CmpFacturaDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleProductoId" size="20" maxlength="10" />
                 -->
                 <input readonly="readonly" name="CmpFacturaDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleTiempoCreacion" size="20" maxlength="10" />
                 <input readonly="readonly" name="CmpFacturaDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleVentaDetalleId" size="20" maxlength="10" />
                 <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
         <td width="26%" valign="top"><div id="CapFacturaDetalle2" class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">Fichas </span>
                 <input type="hidden" name="CmpBoletaAlmacenMovimientoItem" id="CmpBoletaAlmacenMovimientoItem" />
                 <input type="hidden" name="CmpBoletaAlmacenMovimientoId" id="CmpBoletaAlmacenMovimientoId" />
                 <input type="hidden" name="CmpAlmacenMovimientoId" id="CmpAlmacenMovimientoId" /></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td rowspan="4" valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapBoletaDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncBoletaDetalleListar();">
                 <input type="hidden" name="CmpBoletaDetalleAccion" id="CmpBoletaDetalleAccion" value="AccBoletaDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="1%"><div id="CapBoletaDetallesResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapBoletaDetalles" class="EstCapBoletaDetalles" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
         </div></td>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="4%">&nbsp;</td>
               <td width="45%"><div class="EstFormularioAccion" id="CapBoletaAlmacenMovimientoAccion">Listo
                 para registrar elementos</div></td>
               <td width="47%" align="right"><a href="javascript:FncBoletaAlmacenMovimientoListar();">
                 <input type="hidden" name="CmpBoletaAlmacenMovimientoAccion" id="CmpBoletaAlmacenMovimientoAccion" value="AccBoletaAlmacenMovimientoRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 <!-- <a href="javascript:FncBoletaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>--></td>
               <td width="4%"><div id="CapBoletaAlmacenMovimientosResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapBoletaAlmacenMovimientos" class="EstCapBoletaAlmacenMovimientos" > </div></td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div id="CapBoletaDetalle" class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">Abonos Relacionados</span></td>
               <td>&nbsp;</td>
               </tr>
             </table>
         </div></td>
         </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapBoletaPagoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncBoletaPagoListar();">
                 <input type="hidden" name="CmpBoletPagoAccion" id="CmpBoletaPagoAccion" value="AccBoletaPagoRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 <!-- <a href="javascript:FncBoletaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>--></td>
               <td width="1%"><div id="CapBoletaPagosResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapBoletaPagos" class="EstCapBoletaPagos" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
         </div></td>
         </tr>
       <tr>
         <td valign="top"></td>
       </tr>
            </table>
		 
	
	
     
   </div>

	<div id="tab2" class="tab_content">

	      <!--Content-->
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
                    <td colspan="3"><input name="CmpRegimenComprobanteNumero" type="text" class="EstFormularioCaja" id="CmpRegimenComprobanteNumero" tabindex="5" value="<?php echo $InsBoleta->BolRegimenComprobanteNumero;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                    <td>&nbsp;</td>
                    <td>Fecha de Comprobante:<br />
                      <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                    <td align="center"><input name="CmpRegimenComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpRegimenComprobanteFecha" tabindex="6" value="<?php echo $InsBoleta->BolRegimenComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
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
                      <option value="<?php echo $DatRegimen->RegId?>" <?php if($InsBoleta->RegId==$DatRegimen->RegId){ echo 'selected="selected"';} ?> ><?php echo $DatRegimen->RegNombre?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td><div id="CapRegimenBuscar"></div></td>
                    <td>Porcentaje de Regimen:</td>
                    <td><input name="CmpRegimenPorcentaje" type="text"  class="EstFormularioCaja" id="CmpRegimenPorcentaje" value="<?php if (empty($InsBoleta->BolRegimenPorcentaje)){ echo "";}else{ echo $InsBoleta->BolRegimenPorcentaje; } ?>" size="10" maxlength="10" readonly="readonly"  /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaRegimenMonto"></span></span>):</td>
                    <td colspan="3"><input name="CmpRegimenMonto" type="text"  class="EstFormularioCaja" id="CmpRegimenMonto" value="<?php if (empty($InsBoleta->BolRegimenMonto)){ echo "";}else{ echo number_format($InsBoleta->BolRegimenMonto,2); } ?>" size="15" maxlength="10" readonly="readonly" /></td>
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
    
    
    
     <div id="tab4" class="tab_content">
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="97%" valign="top"><div class="EstFormularioArea">
            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="6"><span class="EstFormularioSubTitulo">Datos SUNAT</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Numero de Ticket:</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaTicket" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaTicket" tabindex="5" value="<?php echo $InsBoleta->BolSunatRespuestaTicket;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Fecha de Respuesta:<br />
                  (dd/mm/yyyy)</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaFecha" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Hora de Respuesta:<br />
(00:00)</td>
                <td align="left" valign="top"><input name="CmpSunatRespuestaHora" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaHora" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaHora;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Codigo de Respuesta:<br /></td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaCodigo" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaCodigo;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Descripcion de Respuesta:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaContenido" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaContenido" tabindex="6"><?php echo $InsBoleta->BolSunatRespuestaContenido;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Estado de Ticket</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaEstado" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaEstado" tabindex="5" value="<?php echo $InsBoleta->BolSunatRespuestaEstado;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">Observaciones:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaFecha" id="CmpSunatRespuestaObservacion" tabindex="6"><?php echo $InsBoleta->BolSunatRespuestaObservacion;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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


