<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoVehiculoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoVehiculo.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculoDetalle.php');
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
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');


$InsTrasladoVehiculo = new ClsTrasladoVehiculo();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsTrasladoVehiculoDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoVehiculoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoVehiculoEditar.php');

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"2,3,4");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){


	FncTrasladoVehiculoDetalleListar();

	FncTrasladoVehiculoFotoListar();

});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncTrasladoVehiculoDetalleListar";

var TrasladoVehiculoDetalleEditar = 2;
var TrasladoVehiculoDetalleEliminar = 2;

var TrasladoVehiculoFotoEditar = 2;
var TrasladoVehiculoFotoEliminar = 2;
</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsTrasladoVehiculo->TveId;?>&Su=<?php echo $InsTrasladoVehiculo->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER TRASLADO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Traslado de Vehiculo</a></li>
	
  

</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoVehiculo->TveTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoVehiculo->TveTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Traslado de Vehiculo
                 
                 
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
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoVehiculo->TveId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsTrasladoVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha de Traslado: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsTrasladoVehiculo->TveFecha)){ echo date("d/m/Y");}else{ echo $InsTrasladoVehiculo->TveFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Llegada: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFechaLlegada" type="text" class="EstFormularioCajaFecha" id="CmpFechaLlegada" value="<?php if(empty($InsTrasladoVehiculo->TveFechaLlegada)){ echo date("d/m/Y");}else{ echo $InsTrasladoVehiculo->TveFechaLlegada; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Operacion:</td>
               <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                 <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsTrasladoVehiculo->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Tipo de Comprobante:</td>
               <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                 <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsTrasladoVehiculo->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Referencia:</td>
               <td align="left" valign="top"><input name="CmpReferenciaSerie" type="text" class="EstFormularioCaja" id="CmpReferenciaSerie" value="<?php echo $InsTrasladoVehiculo->TveReferenciaSerie;?>" size="10" maxlength="50" readonly="readonly" />
                 -
                 <input name="CmpReferenciaNumero" type="text" class="EstFormularioCaja" id="CmpReferenciaNumero" value="<?php echo $InsTrasladoVehiculo->TveReferenciaNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                 <input type="hidden" name="CmpClienteId" id="CmpClienteId"  value="<?php echo $InsTrasladoVehiculo->CliId;?>" />
               </span><span class="EstFormularioSubTitulo">
               <input type="hidden" name="CmpProveedorId" id="CmpProveedorId"  value="<?php echo $InsTrasladoVehiculo->PrvId;?>" />
               <input type="hidden" name="CmpMonedaId" id="CmpMonedaId"  value="<?php echo $InsTrasladoVehiculo->MonId;?>" />
               <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsTrasladoVehiculo->TveIncluyeImpuesto;?>" />
               </span><span class="EstFormularioSubTitulo">
               <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsTrasladoVehiculo->TvePorcentajeImpuestoVenta;?>" />
               </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Sucursal Origen:</td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                 <option value="">Escoja una opcion</option>
                 <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                 <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoVehiculo->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                 <?php
    }
    ?>
                 </select></td>
               <td align="left" valign="top">Sucursal Destino:</td>
               <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoVehiculo->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select  disabled="disabled" class="EstFormularioCombo" name="CmpSucursalDestino" id="CmpSucursalDestino">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsTrasladoVehiculo->SucIdDestino==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                   <?php
    }
    ?>
                   </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionInterna" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionInterna"><?php echo $InsTrasladoVehiculo->TveObservacionInterna;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsTrasladoVehiculo->TveObservacionImpresa;?></textarea></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsTrasladoVehiculo->TveEstado){
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
               <td align="left" valign="top">Doc. Ref.:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncTrasladoVehiculoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoVehiculoFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapTrasladoVehiculoFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="550" colspan="2" align="left" valign="top"><div class="EstCapTrasladoVehiculoFotos" id="CapTrasladoVehiculoFotos"></div></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                       </tr>
                     </table></td>
                     <td><div id="CapTrasladoVehiculoFotosResultado"> </div></td>
                   </tr>
                 </table>
               </div></td>
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
               <td width="49%"><span class="EstFormularioSubTitulo">VEHICULOS	</span></td>
               <td width="49%">&nbsp;</td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapVehiculoAccion">Listo
                 para registrar elementos</div></td>
               <td align="right"><a href="javascript:FncTrasladoVehiculoDetalleListar();">
                 <input type="hidden" name="CmpTrasladoVehiculoDetalleAccion" id="CmpTrasladoVehiculoDetalleAccion" value="AccTrasladoVehiculoDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td><div id="CapTrasladoVehiculoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapTrasladoVehiculoDetalles" class="EstCapTrasladoVehiculoDetalles" > </div></td>
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
