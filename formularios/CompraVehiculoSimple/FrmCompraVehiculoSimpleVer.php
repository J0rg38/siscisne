<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo",$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CompraVehiculo","Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoSimpleDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCompraVehiculoSimpleAutocompletar.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCompraVehiculo.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCompraVehiculoSimple.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');











require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');



require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsCompraVehiculo = new ClsCompraVehiculo();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

if (isset($_SESSION['InsCompraVehiculoDetalle'.$Identificador])){	
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCompraVehiculoDetalle'.$Identificador]);
}

if (isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCompraVehiculoSimpleEditar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"1,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){


	FncCompraVehiculoEstablecerMoneda

	FncCompraVehiculoSimpleDetalleListar();

});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncCompraVehiculoSimpleDetalleListar";

var CompraVehiculoDetalleEditar = 2;
var CompraVehiculoDetalleEliminar = 2;

</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCompraVehiculo->CvhId;?>&Su=<?php echo $InsCompraVehiculo->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER INGRESO DE UNIDAD VEHICULAR</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Ingreso de Unidad Vehicular</a></li>
	<li><a href="#tab2">Comprobante de Pago</a></li>
  

</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCompraVehiculo->CvhTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCompraVehiculo->CvhTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Ingreso de Unidad Vehicular
                 
                 
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
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCompraVehiculo->CvhId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Ingreso: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsCompraVehiculo->CvhFecha)){ echo date("d/m/Y");}else{ echo $InsCompraVehiculo->CvhFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
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
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsCompraVehiculo->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
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
               <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
                 -
                 <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Guia de Remision: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpGuiaRemisionFecha" type="text" class="EstFormularioCajaFecha" id="CmpGuiaRemisionFecha" value="<?php echo $InsCompraVehiculo->CvhGuiaRemisionFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Guia Remision Escaneada:</td>
               <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesCveGuiaRemisionFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesCveGuiaRemisionFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCveGuiaRemisionFoto'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
                <a target="_blank" href="subidos/compra_vehiculo_fotos/<?php echo $nombre_base.".".$extension;?>" >
		        <img  src="subidos/compra_vehiculo_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
                </a>
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>
		        
		        
  </td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCompraVehiculo->CvhObservacion;?></textarea></td>
               <td align="left" valign="top">Sucursal Destino:</td>
               <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsCompraVehiculo->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select  disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsCompraVehiculo->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                   <?php
    }
    ?>
                 </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsCompraVehiculo->CvhEstado){
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
               <td><div class="EstFormularioAccion" id="CapVehiculoAccion">Listo
                 para registrar elementos</div></td>
               <td align="right"><a href="javascript:FncCompraVehiculoSimpleDetalleListar();">
                 <input type="hidden" name="CmpCompraVehiculoDetalleAccion" id="CmpCompraVehiculoDetalleAccion" value="AccCompraVehiculoSimpleDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td><div id="CapCompraVehiculoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCompraVehiculoDetalles" class="EstCapCompraVehiculoDetalles" > </div></td>
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
    
    
    <div id="tab2" class="tab_content">
      <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top"><div class="EstFormularioArea">
		  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago </span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4" align="left" valign="top">Proveedor:</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
		        <option value="">Escoja una opcion</option>
		        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
		        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCompraVehiculo->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
		        <?php
			}
			?>
		        </select>
		        :</td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td>&nbsp;</td>
		          <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsCompraVehiculo->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
		          <td>&nbsp;</td>
		          <td><div id="CapProveedorBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Proveedor:</td>
		      <td align="left" valign="top"><input name="CmpProveedorNombreCompleto" type="text" class="EstFormularioCaja" id="CmpProveedorNombreCompleto" value="<?php echo $InsCompraVehiculo->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4" align="left" valign="top">Comporbante:</td>
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
		        <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsCompraVehiculo->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
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
		      <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsCompraVehiculo->CvhComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
		        -
		        <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsCompraVehiculo->CvhComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
		      <td align="left" valign="top">Fecha de Comprobante: <br />
                <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsCompraVehiculo->CvhComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Condicion de Pago:</td>
		      <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" disabled="disabled" >
		        <option value="">Escoja una opcion</option>
		        <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
		        <option <?php if($InsCompraVehiculo->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
		        <?php  
					}
					?>
		        </select></td>
		      <td align="left" valign="top">Cantidad de Dias:</td>
		      <td align="left" valign="top"><input name="CmpCantidadDia" type="text" class="EstFormularioCaja" id="CmpCantidadDia" value="<?php echo $InsCompraVehiculo->CvhCantidadDia;?>" size="10" maxlength="3" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Moneda:
		        <input name="CmpTipoCambio" type="hidden"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncCompraVehiculoSimpleDetalleListar();" value="<?php if (empty($InsCompraVehiculo->CvhTipoCambio)){ echo "";}else{ echo $InsCompraVehiculo->CvhTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
		        <tr>
		          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
		            <option value="">Escoja una opcion</option>
		            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
		            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCompraVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
		            <?php
			  }
			  ?>
		            </select></td>
		          <td><div id="CapMonedaBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Tipo de Cambio: <br />
		        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
		      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCompraVehiculoSimpleDetalleListar();" value="<?php if (empty($InsCompraVehiculo->CvhTipoCambio)){ echo "";}else{ echo $InsCompraVehiculo->CvhTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
              
              <input name="CmpTipoCambioComercial" type="hidden"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambioComercial" value="<?php if (empty($InsCompraVehiculo->CvhTipoCambioComercial)){ echo "";}else{ echo $InsCompraVehiculo->CvhTipoCambioComercial; } ?>" size="10" maxlength="10" />
              
              
              </td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4" align="left" valign="top">Adjuntos:</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Comprobante escaneado:</td>
		      <td colspan="3" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesCveFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesCveFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCveFoto'.$Identificador], '.'.$extension);  
?>
		        Vista Previa:<br />
                
                <a target="_blank" href="subidos/compra_vehiculo_fotos/<?php echo $nombre_base.".".$extension;?>">
		        <img  src="subidos/compra_vehiculo_fotos/<?php echo $nombre_base.".".$extension;?>" width="150"  title="<?php echo $nombre_base."_thumb.".$extension;?>" />
                </a>
                
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
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    </table>
		  </div>
        
        
        </td>
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
