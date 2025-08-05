<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoCompraDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssNotaCreditoCompra.css');
</style>
<?php

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaCreditoCompra.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();
$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador])){	
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaCreditoCompraEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Configuracion Formulario
*/
var NotaCreditoCompraDetalleEditar = 2;
var NotaCreditoCompraDetalleEliminar = 2;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/
	FncNotaCreditoCompraDetalleListar();
	
});
</script>

<div class="EstCapMenu">
  <?php
			if($PrivilegioVistaPreliminar){
			?>
            
          
       
           
  <?php
			}
			?>
  <?php
			if($PrivilegioImprimir){
			?>
          
           
           
           
  <?php
			}
			?>
            
            
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsNotaCreditoCompra->NccId;?>&Ta=<?php echo $InsNotaCreditoCompra->FtaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   


    <?php
if($PrivilegioAuditoriaVer){
?>

 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsNotaCreditoCompra->NccId;?>&Ta=<?php echo $InsNotaCreditoCompra->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>

  <?php
}
?>
         

</div>

<div class="EstCapContenido">

	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td><span class="EstFormularioTitulo">VER
        NOTA DE CREDITO DE COMPRA</span></td>
      </tr>
      <tr>
        <td width="961">		
        
              
                    <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->NccTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->NccTiempoModificacion;?></span></td>
            <td>&nbsp;</td>
            <td>Creado por: </td>
            <td>
			
			  <span class="EstFormularioDatoRegistro"><?php echo $InsNotaCreditoCompra->UsuUsuario;?></span>			</td>
          </tr>
        </table>
        
        </div>   
		
		<br />
		
<ul class="tabs">
	<li><a href="#tab1">Nota de Credito</a></li>

	
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
      
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td width="100%" colspan="2" valign="top"><div class="EstFormularioArea" >
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Nota de Credito 
                 <input type="hidden" name="Guardar" id="Guardar"  value="" />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="right">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Codigo Interno:</td>
               <td><input readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsNotaCreditoCompra->NccId;?>" size="20" maxlength="20" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Se&ntilde;ores:                 </td>
               <td><input readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255" value="<?php echo $InsNotaCreditoCompra->PrvNombre;?> <?php echo $InsNotaCreditoCompra->PrvApellidoPaterno;?> <?php echo $InsNotaCreditoCompra->PrvApellidoMaterno;?>" />
                 <!--       <br /><br />
        <a href="javascript:void(0);" onclick="popupCssShow('default.php?page=pagina-2', 460);" title="Abrir PopUp 1">Abrir PopUp 2</a>-->               </td>
               <td>Fecha de Emisi&oacute;n:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td><input readonly="readonly" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsNotaCreditoCompra->NccFechaEmision)){ echo date("d/m/Y");}else{ echo $InsNotaCreditoCompra->NccFechaEmision; }?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>R.U.C. N&deg;:                 </td>
               <td><label>
                 <input readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpProveedorNumeroDocumento" type="text" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsNotaCreditoCompra->PrvNumeroDocumento;?>" />
                 </label></td>
               <td>Direccion:</td>
               <td><label>
                 <input readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpProveedorDireccion" type="text" id="CmpProveedorDireccion" size="45" maxlength="255" value="<?php echo $InsNotaCreditoCompra->NccDireccion;?>" />
                 </label></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero de Comprobante:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsNotaCreditoCompra->NccComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" /> 
                 - 
                   <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsNotaCreditoCompra->NccComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Comprobante: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsNotaCreditoCompra->NccComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Incluye Impuesto:</td>
               <td><?php
switch($InsNotaCreditoCompra->NccIncluyeImpuesto){

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
               <td>Impuesto:</td>
               <td><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsNotaCreditoCompra->NccPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" readonly="readonly" />
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
                 <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsNotaCreditoCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                 <?php
			  }
			  ?>
                 </select></td>
               <td>Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
               <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncNotaCreditoCompraDetalleListar();" value="<?php if (empty($InsNotaCreditoCompra->NccTipoCambio)){ echo "";}else{ echo $InsNotaCreditoCompra->NccTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Doc. Escaneado:</td>
               <td colspan="3"><?php              
              
if(!empty($_SESSION['SesNccFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesNccFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesNccFoto'.$Identificador], '.'.$extension);  
?>
                 Vista Previa:<br />
  <a href="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" > <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" alt="" width="150" title="<?php echo $nombre_base."_thumb.".$extension;?>" /> </a>
  <?php	
}else{
?>
                 No hay FOTO
  <?php	
}
?></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observac&oacute;n Interna:</td>
               <td><textarea readonly="readonly" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsNotaCreditoCompra->NccObservacion);?></textarea></td>
               <td valign="top">Observac&oacute;n Impresa:</td>
               <td><textarea readonly="readonly" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsNotaCreditoCompra->NccObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Estado:</td>
               <td><?php
			switch($InsNotaCreditoCompra->NccEstado){
				
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;

			}
			?>
                 <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                   <option value="" >Escoja una opcion</option>
                   <option <?php echo $OpcEstado3;?> value="3">Recibido</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                 </select></td>
               <td align="left" valign="top">Almacen de Salida:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsNotaCreditoCompra->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
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
               <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Almacen/Taller: Documentos relacionados </span></td>
               <td width="5">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mov. Entrada:</td>
               <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaId"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoIdOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Num. Comprob.</td>
               <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteNumero" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaComprobanteNumero"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoComprobanteNumeroOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha Comprob.</td>
               <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaComprobanteFecha"  tabindex="3" value="<?php  echo $InsNotaCreditoCompra->AmoComprobanteFechaOrigen;?>" size="10" maxlength="20" readonly="readonly" /></td>
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
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td colspan="2"><div class="EstFormularioAccion" id="CapNotaCreditoCompraDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="46%"><span class="EstFormularioSubTitulo"> Items
                 que componen la NOTA DE CREDITO DE COMPRA</span> </td>
               <td width="52%" align="right"><a href="javascript:FncNotaCreditoCompraDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 <input type="hidden" name="CmpNotaCreditoCompraDetalleAccion" id="CmpNotaCreditoCompraDetalleAccion" value="AccNotaCreditoCompraDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapNotaCreditoCompraDetalles" class="EstCapNotaCreditoCompraDetalles" > </div></td>
               <td><div id="CapNotaCreditoCompraDetallesResultado"> </div></td>
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

