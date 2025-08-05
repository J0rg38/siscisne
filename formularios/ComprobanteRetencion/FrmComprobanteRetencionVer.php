<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssComprobanteRetencion.css');
</style>
<?php

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjComprobanteRetencion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();
$InsMoneda = new ClsMoneda();



if (isset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador])){	
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsComprobanteRetencionDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteRetencionEditar.php');

$ResComprobanteRetencionTalonario = $InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonarios(NULL,NULL,"CrtNumero","DESC",NULL);
$ArrComprobanteRetencionTalonarios = $ResComprobanteRetencionTalonario['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var ComprobanteRetencionDetalleEditar = 2;
var ComprobanteRetencionDetalleEliminar = 2;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/
	FncComprobanteRetencionEstablecerMoneda();

	FncComprobanteRetencionDetalleListar();
	
	FncClienteNotaVerificar();
	
	
});
</script>


<div class="EstCapMenu">
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
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   

<?php
/*if($PrivilegioListadoClientePago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>ComprobanteRetencion/FrmComprobanteRetencionPagoListado.php?Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}*/
?>
    <?php
if($PrivilegioAuditoriaVer){
?>

 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsComprobanteRetencion->CrnId;?>&Ta=<?php echo $InsComprobanteRetencion->CrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>

  <?php
}
?>
         

</div>

<div class="EstCapContenido">

	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td><span class="EstFormularioTitulo">VER
        COMPROBANTE DE RETENCION</span></td>
      </tr>
      <tr>
        <td width="961">		
        
              
                    <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsComprobanteRetencion->CrnTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsComprobanteRetencion->CrnTiempoModificacion;?></span></td>
            <td>&nbsp;</td>
            <td>Creado por: </td>
            <td>
			
			  <span class="EstFormularioDatoRegistro"><?php echo $InsComprobanteRetencion->UsuUsuario;?></span>			</td>
          </tr>
        </table>
        
        </div>   
		
		<br />
		
<ul class="tabs">
	<li><a href="#tab1">Comprobante de Retencion</a></li>


    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
      
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la ComprobanteRetencion 
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
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
			  foreach($ArrComprobanteRetencionTalonarios as $DatComprobanteRetencionTalonario){
			  ?>
                   <option <?php if($InsComprobanteRetencion->CrtId == $DatComprobanteRetencionTalonario->CrtId){ echo 'selected="selected"';}?> value="<?php echo $DatComprobanteRetencionTalonario->CrtId;?>" ><?php echo $DatComprobanteRetencionTalonario->CrtNumero;?>  (<?php echo $DatComprobanteRetencionTalonario->CrtDescripcion;?>)</option>
                   <?php
			  }
			  ?>
                   </select>               </td>
               <td align="left"><input readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsComprobanteRetencion->CrnId;?>" size="20" maxlength="20" />               </td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Cliente:</td>
               <td colspan="4"><table>
                 <tr>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsComprobanteRetencion->CliNumeroDocumento;?>" /></td>
                   <td><input readonly="readonly" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsComprobanteRetencion->CliNombre;?> <?php echo $InsComprobanteRetencion->CliApellidoPaterno;?> <?php echo $InsComprobanteRetencion->CliApellidoMaterno;?>" /></td>
                   <td>&nbsp;</td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Direccion:</td>
               <td><label>
                 <input readonly="readonly" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsComprobanteRetencion->CrnDireccion;?>" />
                 </label></td>
               <td>&nbsp;</td>
               <td>Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsComprobanteRetencion->CrnFechaEmision)){ echo date("d/m/Y");}else{ echo $InsComprobanteRetencion->CrnFechaEmision; }?>" size="10" maxlength="10" />
                 </td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observac&oacute;n Interna:</td>
               <td><textarea readonly="readonly" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsComprobanteRetencion->CrnObservacion);?></textarea></td>
               <td>&nbsp;</td>
               <td valign="top">Observac&oacute;n Impresa:</td>
               <td><textarea readonly="readonly" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsComprobanteRetencion->CrnObservacionImpresa;?></textarea></td>
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
                 <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsComprobanteRetencion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                       
                       <input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncComprobanteRetencionDetalleListar();" value="<?php if (empty($InsComprobanteRetencion->CrnTipoCambio)){ echo "";}else{ echo $InsComprobanteRetencion->CrnTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
                       
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
               <td>Cancelado:</td>
               <td><?php
			switch($InsComprobanteRetencion->CrnCancelado){
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
               <td>Estado:</td>
               <td><?php
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
                 <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                   <option <?php echo $OpcEstado7;?> value="7">Reservado</option>
                   </select></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2" align="left" valign="top"><input <?php echo (($InsComprobanteRetencion->CrnNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" disabled="disabled" />
                 Notificar via email <br />
  <input <?php echo (($InsComprobanteRetencion->CrnProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" disabled="disabled" />
                 Procesar comprobante <br />
  <input <?php echo (($InsComprobanteRetencion->CrnEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" disabled="disabled" />
                 Enviar a SUNAT </td>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>

       <tr>
         <td valign="top"><div id="CapComprobanteRetencionDetalle" class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="7"><span class="EstFormularioSubTitulo">Items </span>
                 <input type="hidden" name="CmpComprobanteRetencionDetalleItem" id="CmpComprobanteRetencionDetalleItem" />
                 <input type="hidden" name="CmpComprobanteRetencionDetalleId" id="CmpComprobanteRetencionDetalleId" />
                 <!--           <input readonly="readonly" name="CmpComprobanteRetencionDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleProductoId" size="20" maxlength="10" />
                 -->
                 <input readonly="readonly" name="CmpComprobanteRetencionDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleTiempoCreacion" size="20" maxlength="10" />
                 <input readonly="readonly" name="CmpComprobanteRetencionDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpComprobanteRetencionDetalleVentaDetalleId" size="20" maxlength="10" />
                 <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
               <td>&nbsp;</td>
               </tr>
             </table>
         </div></td>
         </tr>
       <tr>
         <td width="74%" valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td colspan="2"><div class="EstFormularioAccion" id="CapComprobanteRetencionDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="46%"><span class="EstFormularioSubTitulo"> Items
                 que componen el comprobante de retencion</span> </td>
               <td width="52%" align="right"><a href="javascript:FncComprobanteRetencionDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 <input type="hidden" name="CmpComprobanteRetencionDetalleAccion" id="CmpComprobanteRetencionDetalleAccion" value="AccComprobanteRetencionDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapComprobanteRetencionDetalles" class="EstCapComprobanteRetencionDetalles" > </div></td>
               <td><div id="CapComprobanteRetencionDetallesResultado"> </div></td>
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

