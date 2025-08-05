<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PagoVehiculoIngreso",$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PagoVehiculoIngreso","Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoVehiculoIngresoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoVehiculoIngresoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPagoVehiculoIngreso.css');
</style>

<?php
$GET_id = $_GET['Id'];



include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPagoVehiculoIngreso.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPagoVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPagoVehiculoIngresoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

$InsPagoVehiculoIngreso = new ClsPagoVehiculoIngreso();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();
$InsTipoDocumento = new ClsTipoDocumento();
$InsBanco = new ClsBanco();


if (isset($_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador])){	
	$_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPagoVehiculoIngresoEditar.php');


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,$POST_pag);
$ArrBancos = $ResBanco['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){


	FncPagoVehiculoIngresoEstablecerMoneda

	FncPagoVehiculoIngresoDetalleListar();

	
	FncPagoVehiculoIngresoFotoListar();
	
});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncPagoVehiculoIngresoDetalleListar";

var PagoVehiculoIngresoDetalleEditar = 2;
var PagoVehiculoIngresoDetalleEliminar = 2;

var PagoVehiculoIngresoFotoEditar = 2;
var PagoVehiculoIngresoFotoEliminar = 2;

</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPagoVehiculoIngreso->PviId;?>&Su=<?php echo $InsPagoVehiculoIngreso->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER PAGO DE VEHICULOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Pago de Vehiculos</a></li>
	
  

</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPagoVehiculoIngreso->PviTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPagoVehiculoIngreso->PviTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Pago de Vehiculos
                 
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPagoVehiculoIngreso->PviId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Fecha de Registro: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsPagoVehiculoIngreso->PviFecha)){ echo date("d/m/Y");}else{ echo $InsPagoVehiculoIngreso->PviFecha; }?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:</td>
               <td colspan="3" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPagoVehiculoIngreso->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                     </select>
                     :</td>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsPagoVehiculoIngreso->PrvNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                   <td><input name="CmpProveedorNombreCompleto" type="text" class="EstFormularioCaja" id="CmpProveedorNombreCompleto" value="<?php echo $InsPagoVehiculoIngreso->PrvNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
                   </tr>
                 </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Banco:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpBanco" id="CmpBanco">
                 <option value="">Escoja una opcion</option>
                 <?php
				foreach($ArrBancos as $DatBanco){
				?>
                 <option <?php echo ($InsPagoVehiculoIngreso->BanId == $DatBanco->BanId)?'selected="selected"':''; ?> value="<?php echo $DatBanco->BanId?>"><?php echo $DatBanco->BanNombre; ?></option>
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
               <td align="left" valign="top">Numero Operacion:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsPagoVehiculoIngreso->PviComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" />
                 -
                 <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsPagoVehiculoIngreso->PviComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Operacion<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php echo $InsPagoVehiculoIngreso->PviComprobanteFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:
                 <input name="CmpTipoCambio" type="hidden"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncPagoVehiculoIngresoDetalleListar();" value="<?php if (empty($InsPagoVehiculoIngreso->PviTipoCambio)){ echo "";}else{ echo $InsPagoVehiculoIngreso->PviTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPagoVehiculoIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                   </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
               </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio2" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio2" onchange="FncPagoVehiculoIngresoDetalleListar();" value="<?php if (empty($InsPagoVehiculoIngreso->PviTipoCambio)){ echo "";}else{ echo $InsPagoVehiculoIngreso->PviTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
                 <input name="CmpTipoCambioComercial" type="hidden"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambioComercial" value="<?php if (empty($InsPagoVehiculoIngreso->PviTipoCambioComercial)){ echo "";}else{ echo $InsPagoVehiculoIngreso->PviTipoCambioComercial; } ?>" size="10" maxlength="10" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Docuemnto Escaneado:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncPagoVehiculoIngresoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPagoVehiculoIngresoFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapPagoVehiculoIngresoFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadPagoVehiculoIngresoFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/PagoVehiculoIngreso/acc/AccPagoVehiculoIngresoFotoSubir.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tama&ntilde;o no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncPagoVehiculoIngresoFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                       </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top"><div class="EstCapPagoVehiculoIngresoFotos" id="CapPagoVehiculoIngresoFotos"></div></td>
                         <td align="left" valign="top">&nbsp;</td>
                       </tr>
                     </table></td>
                     <td><div id="CapPagoVehiculoIngresoFotosResultado"> </div></td>
                   </tr>
                 </table>
               </div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero de Bloque:</td>
               <td align="left" valign="top"><input name="CmpNumeroBloque" type="text" class="EstFormularioCaja" id="CmpNumeroBloque" value="<?php echo $InsPagoVehiculoIngreso->PviNumeroBloque;?>" size="10" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsPagoVehiculoIngreso->PviObservacion;?></textarea></td>
               <td align="left" valign="top">Sucursal Destino:</td>
               <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsPagoVehiculoIngreso->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                 <select  disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                   <option value="">Escoja una opcion</option>
                   <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                   <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsPagoVehiculoIngreso->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                   <?php
    }
    ?>
                 </select></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Total:</td>
               <td align="left" valign="top"><input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo round($InsPagoVehiculoIngreso->PviTotal,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsPagoVehiculoIngreso->PviEstado){
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
               <td width="49%"><span class="EstFormularioSubTitulo">VEHICULOS	</span></td>
               <td width="49%">&nbsp;</td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapVehiculoAccion">Listo
                 para registrar elementos</div></td>
               <td align="right"><a href="javascript:FncPagoVehiculoIngresoDetalleListar();">
                 <input type="hidden" name="CmpPagoVehiculoIngresoDetalleAccion" id="CmpPagoVehiculoIngresoDetalleAccion" value="AccPagoVehiculoIngresoDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td><div id="CapPagoVehiculoIngresoDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapPagoVehiculoIngresoDetalles" class="EstCapPagoVehiculoIngresoDetalles" > </div></td>
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
