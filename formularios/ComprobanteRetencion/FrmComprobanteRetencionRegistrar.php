<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssComprobanteRetencion.css');
</style>

<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_ori = $_GET['Ori'];
$GET_FccId = $_GET['FccId'];
$GET_AmoId = $_GET['AmoId'];
$GET_VcoId = $_GET['VcoId'];

$GET_OvvId = $_GET['OvvId'];
$POST_Seleccionados = $_POST['cmp_seleccionados'];



//$POST_id = $_POST['CmpId'];
//$POST_ta = $_POST['CmpTalonario'];
//$POST_do = isset($_POST['CmpDocumento'])?$_POST['CmpDocumento']:$_POST['CmpDocumento2'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjComprobanteRetencion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


//$err = $client->getError();

$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();

$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

if (!isset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador])){	
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsComprobanteRetencionDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteRetencionRegistrar.php');

$ResComprobanteRetencionTalonario = $InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonarios(NULL,NULL,"CrtNumero","DESC",NULL);
$ArrComprobanteRetencionTalonarios = $ResComprobanteRetencionTalonario['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
//var ArticuloValidarStock = "1,2";
var ArticuloTipo = "1,2"; 

var Formulario = "FrmRegistrar";

var ComprobanteRetencionDetalleEditar = 1;
var ComprobanteRetencionDetalleEliminar = 1;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/			
	$('#CmpClienteNombre').focus();
	
	FncComprobanteRetencionEstablecerMoneda();

	FncComprobanteRetencionDetalleListar();
	
	<?php
	if(!empty($_SESSION['SisCrtId']) and empty($POST_id) or !empty($POST_do) ){
	?>
		FncGenerarComprobanteRetencionId('<?php echo $_SESSION['SisCrtId'];?>');
	<?php
	}
	?>


	<?php
	if(!empty($POST_do)){
	?>
		if(confirm("Desea guardar el registro ahora?")){
			$('#Guardar').val("1");
			$('#'+Formulario).submit();
		}
	<?php	 
	}
	?>
	
	<?php
	if($Edito or $Registro){
	?>
		if(confirm("Desea imprimir ahora?")){
			
			FncImprmir("<?php echo $InsComprobanteRetencion->CrnId;?>","<?php echo $InsComprobanteRetencion->CrtId;?>");
			
		}
	
	<?php	
	}else{
	?>
		FncClienteNotaVerificar();
		
	<?php	
	}
	?>
});
</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsComprobanteRetencion->CrnCierre;?>" />
	
    
<div class="EstCapMenu">
<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsComprobanteRetencion->CrnId;?>','<?php echo $InsComprobanteRetencion->CrtId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsComprobanteRetencion->CrnId;?>','<?php echo $InsComprobanteRetencion->CrtId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
	<?php
    /*if($PrivilegioRegistrarClientePago){
    ?>
    <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>ComprobanteRetencion/FrmComprobanteRetencionPagar.php?Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>           
    <?php
    }*/
    ?>

	<?php
    /*if($PrivilegioListadoClientePago){
    ?>
    <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>ComprobanteRetencion/FrmComprobanteRetencionPagoListado.php?Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
    <?php
    }*/
    ?>
    
	<?php
    /*if($PrivilegioGenerarGuiaRemision){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemision();"><img src="imagenes/iconos/guiaremision.png" alt="[Generar Guia Remision]" title="Generar Guia Remision"  />G. Rem.</a></div>   
    <?php
    }*/
    ?>  

<?php
}
?>    
            
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

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
        <td><span class="EstFormularioTitulo">REGISTRAR
        COMPROBANTE DE RETENCION</span></td>
      </tr>
      <tr>
        <td width="961">		
        
        
                                                 
          
<ul class="tabs">
	<li><a href="#tab1">Comprobante de Retencion</a></li>
	
    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
           
           <div class="EstFormularioArea" >
             
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de el comprobante de retencion
                   <input type="hidden" name="Guardar" id="Guardar"  value="" />
                   <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                   </span></td>
                 <td align="left" valign="top">&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td colspan="2" align="center" valign="top">
                   
                   <table>
                     <tr>
                       <td><select  onchange="FncGenerarComprobanteRetencionId(this.value);"  class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                         <option value="">-</option>
                         <?php
			  foreach($ArrComprobanteRetencionTalonarios as $DatComprobanteRetencionTalonario){
			  ?>
                         <option <?php if(!empty($InsComprobanteRetencion->CrtId)){ if($InsComprobanteRetencion->CrtId==$DatComprobanteRetencionTalonario->CrtId){ echo 'selected="selected"';}}elseif($_SESSION['SisCrtId']==$DatComprobanteRetencionTalonario->CrtId){ 	echo 'selected="selected"';}?> 			  value="<?php echo $DatComprobanteRetencionTalonario->CrtId;?>" ><?php echo $DatComprobanteRetencionTalonario->CrtNumero;?> (<?php echo $DatComprobanteRetencionTalonario->CrtDescripcion;?>)</option>
                         <?php
			  }
			  ?>
                       </select></td>
                       <td>
                         
                         N&deg;.
                         <input tabindex="1" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsComprobanteRetencion->CrnId;?>" size="20" maxlength="20"  /></td>
                       <td>
                         <a href="javascript:FncGenerarComprobanteRetencionId(document.getElementById('CmpTalonario').value);"><img border="0" src="imagenes/recargar.jpg" alt="[Recargar]" title="Recargar" width="18" height="18" align="absmiddle"  /></a>
                         </td>
                       <td>
                         <div id="CapComprobanteRetencion"></div>
                         </td>
                       </tr>
                     </table>
                   </td>
                 <td align="left" valign="top"></td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Cliente:</td>
                 <td colspan="4" align="left" valign="top"><table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsComprobanteRetencion->CliId;?>" size="3" />
                       <input size="3" type="hidden" name="CmpClienteTipoDocumentoId" id="CmpClienteTipoDocumentoId" value="<?php echo $InsComprobanteRetencion->TdoId?>" /></td>
                     <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsComprobanteRetencion->CliNumeroDocumento;?>"  <?php echo !empty($InsComprobanteRetencion->CliId)?'readonly="readonly"':'';?>  /></td>
                     <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                     <td><input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsComprobanteRetencion->CliNombre;?> <?php echo $InsComprobanteRetencion->CliApellidoPaterno;?> <?php echo $InsComprobanteRetencion->CliApellidoMaterno;?>"  <?php echo !empty($InsComprobanteRetencion->CliId)?'readonly="readonly"':'';?> /></td>
                     <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                     </tr>
                   </table></td>
                 <td align="left" valign="top">&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Direccion:</td>
                 <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsComprobanteRetencion->CrnDireccion;?>"  /></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                 <td align="left" valign="top"><span id="sprytextfield1">
                   <label>
                     <input tabindex="6" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsComprobanteRetencion->CrnFechaEmision)){ echo date("d/m/Y");}else{ echo $InsComprobanteRetencion->CrnFechaEmision; }?>" size="10" maxlength="10" />
                     </label>
                 </span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                 <td align="left" valign="top">&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                 <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsComprobanteRetencion->CrnObservacion);?></textarea></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                 <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsComprobanteRetencion->CrnObservacionImpresa);?></textarea></td>
                 <td align="left" valign="top">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Moneda:</td>
                 <td align="left" valign="top">
                   
                   
                   
                   
                   
                   
                   <table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                         <option value="">Escoja una opcion</option>
                         <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                         <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsComprobanteRetencion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                         <?php
			  }
			  ?>
                       </select></td>
                       <td><div id="CapMonedaBuscar"></div>
                         
                         
                         
                         </td>            
                       </tr>
                     </table>
                   
                   </td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
                 <td align="left" valign="top"><table>
                   <tr>
                     <td><input  class="EstFormularioCaja" name="CmpTipoCambio" type="text" id="CmpTipoCambio" value="<?php if (empty($InsComprobanteRetencion->CrnTipoCambio)){ echo "";}else{ echo $InsComprobanteRetencion->CrnTipoCambio; } ?>" size="10" maxlength="10" onchange="FncComprobanteRetencionDetalleListar();" /></td>
                     <td>
                       <a href="javascript:FncComprobanteRetencionEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                       </td>
                     </tr>
                   </table></td>
                 <td align="left" valign="top">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Cancelado:</td>
                 <td align="left" valign="top"><?php
			switch($InsComprobanteRetencion->CrnCancelado){
				case 1:
					$OpcCancelado1 = 'selected="selected"';
				break;
			
				case 2:
					$OpcCancelado2 = 'selected="selected"';
				break;

			
			}
?>
                   <select  class="EstFormularioCombo" id="CmpCancelado" name="CmpCancelado" disabled="disabled">
                     <option <?php echo $OpcCancelado1;?> value="1">Si</option>
                     <option <?php echo $OpcCancelado2;?> value="2">No</option>
                     </select></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">Estado:</td>
                 <td align="left" valign="top"><?php
			switch($InsComprobanteRetencion->CrnEstado){
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
                   <select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                     <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                     <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                     <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                     <option <?php echo $OpcEstado7;?> value="7">Reservado</option>
                     </select></td>
                 <td align="left" valign="top">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2" align="left" valign="top">


<input <?php echo (($InsComprobanteRetencion->CrnNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
Notificar via email <br />

<input <?php echo (($InsComprobanteRetencion->CrnProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" />
Procesar comprobante  <br />

<input <?php echo (($InsComprobanteRetencion->CrnEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" />
Enviar a SUNAT <br />   
                        
                        
                        &nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
               </tr>
               </table>
             
             </div>
           
           </td>
       </tr>
     
       <tr>
         <td width="75%" valign="top">
           <div id="CapComprobanteRetencionDetalle" class="EstFormularioArea">
             
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="9"><span class="EstFormularioSubTitulo">Items
                   </span>
                   <input type="hidden" name="CmpComprobanteRetencionDetalleItem" id="CmpComprobanteRetencionDetalleItem" />
                   <input type="hidden" name="CmpComprobanteRetencionDetalleId" id="CmpComprobanteRetencionDetalleId" />
                   <!--           <input readonly="readonly" name="CmpComprobanteRetencionDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleProductoId" size="20" maxlength="10" />
                 -->
                   <input readonly="readonly" name="CmpComprobanteRetencionDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleTiempoCreacion" size="20" maxlength="10" />
                   <input readonly="readonly" name="CmpComprobanteRetencionDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleVentaDetalleId" size="20" maxlength="10" />
                   <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="left">Tipo Doc:</td>
                 <td align="left">Serie:</td>
                 <td align="left">Número:</td>
                 <td align="left">Fecha:</td>
                 <td align="left">Total:</td>
                 <td align="left">Porcen. Reten.:</td>
                 <td align="left">Retenido</td>
                 <td align="left">Pagado</td>
                 <td>&nbsp;</td>
                 </tr>
               
               <tr>
                 <td>&nbsp;</td>
                 <td>
                   <a href="javascript:FncComprobanteRetencionDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                 <td><select  class="EstFormularioCombo" name="CmpComprobanteRetencionDetalleTipoDocumento" id="CmpComprobanteRetencionDetalleTipoDocumento">
                   
                   <option value="">-</option>
                   <option value="01">Factura</option>
                 <!--  <option value="03">Boleta</option>
                   <option value="00">Recibo Honorarios</option>-->
                   </select></td>
                 <td><input tabindex="11" class="EstFormularioCaja" name="CmpComprobanteRetencionDetalleSerie" type="text" id="CmpComprobanteRetencionDetalleSerie" size="10" maxlength="10"   /></td>
                 <td><input tabindex="11" class="EstFormularioCaja" name="CmpComprobanteRetencionDetalleNumero" type="text" id="CmpComprobanteRetencionDetalleNumero" size="10" maxlength="10"   /></td>
                 <td><input tabindex="11" class="EstFormularioCajaFecha" name="CmpComprobanteRetencionDetalleFechaEmision" type="text" id="CmpComprobanteRetencionDetalleFechaEmision" size="10" maxlength="10"   />
                 
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteRetencionDetalleFechaEmision" name="BtnComprobanteRetencionDetalleFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                 
                 </td>
                 <td><input tabindex="10" class="EstFormularioCaja" name="CmpComprobanteRetencionDetalleTotal" type="text" id="CmpComprobanteRetencionDetalleTotal" size="5" maxlength="10"  /></td>
                 <td><input tabindex="10" class="EstFormularioCaja" name="CmpComprobanteRetencionDetallePorcentajeRetencion" type="text" id="CmpComprobanteRetencionDetallePorcentajeRetencion" size="5" maxlength="10"  /></td>
                 <td><input tabindex="10" class="EstFormularioCaja" name="CmpComprobanteRetencionDetalleRetenido" type="text" id="CmpComprobanteRetencionDetalleRetenido" size="5" maxlength="10"  /></td>
                 <td><input tabindex="10" class="EstFormularioCaja" name="CmpComprobanteRetencionDetallePagado" type="text" id="CmpComprobanteRetencionDetallePagado" size="5" maxlength="10"  /></td>
                 <td><a href="javascript:FncComprobanteRetencionDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td colspan="8" align="right">&nbsp;</td>
                 <td>&nbsp;</td>
                 </tr>
               </table>
           </div>                                 </td>
         </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapComprobanteRetencionDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncComprobanteRetencionDetalleListar();">
                 <input type="hidden" name="CmpComprobanteRetencionDetalleAccion" id="CmpComprobanteRetencionDetalleAccion" value="AccComprobanteRetencionDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncComprobanteRetencionDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
               <td width="1%"><div id="CapComprobanteRetencionDetallesResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapComprobanteRetencionDetalles" class="EstCapComprobanteRetencionDetalles" > </div></td>
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
    
  

</form>
<script type="text/javascript"> 


	
	
	Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del bot&oacute;n que  
	}); 
		Calendar.setup({ 
	inputField : "CmpComprobanteRetencionDetalleFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteRetencionDetalleFechaEmision"// el id del bot&oacute;n que  
	}); 
	




</script>
<?php

}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

