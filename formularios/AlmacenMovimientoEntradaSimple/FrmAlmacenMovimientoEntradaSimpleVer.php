<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada",$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaSimpleDetalleFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoEntradaSimple.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoEntradaSimple.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');



require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoEntradaSimpleEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"1,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsAlmacenMovimientoEntrada->SucId );
$ArrAlmacenes = $RepAlmacen['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	FncAlmacenMovimientoEntradaSimpleEstablecerMoneda

	FncAlmacenMovimientoEntradaSimpleDetalleListar();


});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncAlmacenMovimientoEntradaSimpleDetalleListar";

var AlmacenMovimientoEntradaSimpleDetalleEditar = 2;
var AlmacenMovimientoEntradaSimpleDetalleEliminar = 2;

</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>&Su=<?php echo $InsAlmacenMovimientoEntrada->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER INGRESO A ALMACEN X OTRO CONCEPTO </span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Entrada a Almacen</a></li>


</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsAlmacenMovimientoEntrada->AmoTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoEntrada->AmoFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">Almacen Destino:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:</td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsAlmacenMovimientoEntrada->PrvId;?>" size="3" /></td>
                   <td><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                   </select></td>
                   <td><a href="javascript:FncProveedorNuevo('','');"></a></td>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                   <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr> </tr>
               </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                 <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsAlmacenMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero de Comprobante:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
                 -
                 <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Comprobante: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:
                 <input name="CmpTipoCambio" type="hidden"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaSimpleDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                     </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaSimpleDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></textarea></td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoEntrada->AmoEstado){
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
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Comprobante escaneado:</td>
               <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesAmoFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesAmoFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesAmoFoto'.$Identificador], '.'.$extension);  
?>
                 Vista Previa:<br />
                 <img  src="subidos/almacen_movimiento_entrada_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
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
               <td valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
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
               <td width="49%"><span class="EstFormularioSubTitulo">PRODUCTOS	</span></td>
               <td width="49%">&nbsp;</td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td align="right"><a href="javascript:FncAlmacenMovimientoEntradaSimpleDetalleListar();">
                 <input type="hidden" name="CmpAlmacenMovimientoEntradaSimpleDetalleAccion" id="CmpAlmacenMovimientoEntradaSimpleDetalleAccion" value="AccAlmacenMovimientoEntradaSimpleDetalleRegistrar.php" />
                <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td><div id="CapAlmacenMovimientoEntradaSimpleDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapAlmacenMovimientoEntradaSimpleDetalles" class="EstCapAlmacenMovimientoEntradaSimpleDetalles" > </div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>        
        </table>
         
		

		 
    </div>    
    

  
    
    
    <div>		
 
 
      </div>  
        
        
          
       

           
  
        
        
        
        
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
