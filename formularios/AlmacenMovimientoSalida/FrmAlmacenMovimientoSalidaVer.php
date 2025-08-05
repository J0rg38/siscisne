<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoSalidaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoSalidaDetalleFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("TallerPedido");?>CssTallerPedido.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoSalida.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoSalida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
$InsTipoOperacion = new ClsTipoOperacion();

$InsClienteTipo = new ClsClienteTipo();

$InsAlmacen = new ClsAlmacen();
$InsMoneda = new ClsMoneda();

if (isset($_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoSalidaEditar.php');

// MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"2,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];


//
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsAlmacenMovimientoSalida->SucId );
$ArrAlmacenes = $RepAlmacen['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];
?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	FncAlmacenMovimientoSalidaDetalleListar();
	
});

var AlmacenMovimientoSalidaDetalleEditar = 2;
var AlmacenMovimientoSalidaDetalleEliminar = 2;


</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsAlmacenMovimientoSalida->AmoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsAlmacenMovimientoSalida->AmoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsAlmacenMovimientoSalida->AmoId;?>&Su=<?php echo $InsAlmacenMovimientoSalida->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER SALIDA DE ALMACEN X ORD. TRABAJO</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoSalida->AmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoSalida->AmoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Salida de Almacen</a></li>

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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Salida de Almacen
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoSalida->AmoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Salida:<br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoSalida->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoSalida->AmoFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top">
                 
                 <select class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion" disabled="disabled">
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                   <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoSalida->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                   <?php
			}
			?>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">
               <input type="hidden" name="CmpAlmacen" id="CmpAlmacen" value="<?php echo $InsAlmacenMovimientoSalida->AlmId;?>" />
               </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda: </td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><span id="spryselect2">
                     <select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                       <option value="">Escoja una opcion</option>
                       <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                       <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoSalida->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                       <?php
			  }
			  ?>
                     </select>
                   </span></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoSalidaDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoSalida->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoSalida->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                   <td><a href="javascript:FncAlmacenMovimientoSalidaEstablecerMoneda();"></a></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descuento:</td>
               <td align="left" valign="top"><input name="CmpDescuento" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpDescuento" onchange="FncAlmacenMovimientoSalidaDetalleListar();" value="<?php echo number_format($InsAlmacenMovimientoSalida->AmoDescuento,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Tipo de Cliente:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                 <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsAlmacenMovimientoSalida->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoSalida->AmoObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoSalida->AmoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;?>" />
                 <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta;?>" />
               
                <input type="hidden" name="CmpDescuento" id="CmpDescuento"  value="<?php echo $InsAlmacenMovimientoSalida->AmoDescuento;?>" />
               </span></td>
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
               <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%"><input type="hidden" name="CmpAlmacenMovimientoSalidaDetalleAccion" id="CmpAlmacenMovimientoSalidaDetalleAccion" value="AccAlmacenMovimientoSalidaDetalleRegistrar.php" /></td>
               <td width="50%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncAlmacenMovimientoSalidaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="0%"><div id="CapAlmacenMovimientoSalidaDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapAlmacenMovimientoSalidaDetalles" class="EstCapAlmacenMovimientoSalidaDetalles" > </div></td>
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
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
