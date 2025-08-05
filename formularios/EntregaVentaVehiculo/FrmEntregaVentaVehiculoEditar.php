<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
         
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsEntregaVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsEntregaVentaVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsEntregaVentaVehiculoPropietarioFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssEntregaVentaVehiculo.css');
</style>



<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjEntregaVentaVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsPersonal = new ClsPersonal();



if (isset($_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador])){	
	$_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccEntregaVentaVehiculoEditar.php');


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonaleVendedores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];


?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

function FncDesactivarEnter(){
	
}


	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	
	$('#CmpFecha').focus();	

	//FncEntregaVentaVehiculoDetalleListar();
	
	FncEntregaVentaVehiculoEstablecerMoneda();
	
	FncVehiculoModelosCargar();
	
	FncEntregaVentaVehiculoPropietarioListar();
		
		
	FncEntregaVentaVehiculoEstablecerMantenimiento();
	//FncVehiculoIngresoListar();
	
});

/*
Configuracion Formulario
*/

var EntregaVentaVehiculoDetalleEditar = 1;
var EntregaVentaVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;
var VehiculoColorHabilitado = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

var EntregaVentaVehiculoPropietarioEditar = 1;
var EntregaVentaVehiculoPropietarioEliminar = 1;

</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">

           <?php
if($Edito){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsEntregaVentaVehiculo->EvvId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsEntregaVentaVehiculo->EvvId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            

<?php
}
?>    

<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        ENTREGA DE VEHICULO PROGRAMADA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Entrega de Vehiculo</a></li>
  
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsEntregaVentaVehiculo->EvvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsEntregaVentaVehiculo->EvvTiempoModificacion;?></span></td>
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
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Entrega de Vehiculo
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsEntregaVentaVehiculo->EvvId;?>" size="20" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsEntregaVentaVehiculo->EvvFecha)){ echo date("d/m/Y");}else{ echo $InsEntregaVentaVehiculo->EvvFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Programada:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaProgramada" type="text" id="CmpFechaProgramada" value="<?php if(empty($InsEntregaVentaVehiculo->EvvFechaProgramada)){ echo date("d/m/Y");}else{ echo $InsEntregaVentaVehiculo->EvvFechaProgramada; }?>" size="15" maxlength="10" />
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaProgramada" name="BtnFechaProgramada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">Hora Programada:<br />
                 <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaHora" name="CmpHoraProgramada" type="text" id="CmpHoraProgramada" value="<?php  echo $InsEntregaVentaVehiculo->EvvHoraProgramada;?>" size="15" maxlength="10" />
                 <!--             <div id="sample1" class="ui-widget-content" style="padding: .5em;">
        <p>
            <label>Start</label><br/>
            <input name="s1Time2" value="" /> <br/>
            <label>End</label><br/>
            <input name="s1Time2" value="" />
        </p>
        <p>Some extra select boxes to show to it works under IE.<br/>
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select><br /> <br />
            <select>
                <option>Option 1 here</option>
                <option>Options 2 here</option>
            </select>
        </p>
    </div>-->
                 <!--<a id="BtnCitaCalendario" href="javascript:FncCitaCalendarioCargarFormulario('VerCalendarioFull')"><img src="imagenes/acciones/calendario_full.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" /></a>
            --></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Duracion Estimada:</td>
               <td align="left" valign="top"><?php
			switch($InsEntregaVentaVehiculo->EvvDuracion){
				case 1:
					$OpcDuracion1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcDuracion2 = 'selected="selected"';
				break;
				
				case 3:
					$OpcDuracion3 = 'selected="selected"';
				break;
				
			}
			?>
                 <select  class="EstFormularioCombo" id="CmpDuracion" name="CmpDuracion">
                   <option <?php echo $OpcDuracion1;?> value="1">1 Hora</option>
                   <option <?php echo $OpcDuracion2;?> value="2">2 Horas</option>
                   <option <?php echo $OpcDuracion3;?> value="3">3 Horas</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Orden de Venta:</td>
               <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsEntregaVentaVehiculo->OvvId;?>" size="25" maxlength="25" readonly="readonly" /></td>
               <td>Asesor de Ventas:</td>
               <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonalVendedor" id="CmpPersonalVendedor" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonaleVendedores as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsEntregaVentaVehiculo->PerIdVendedor)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
                 </select></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaciones:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsEntregaVentaVehiculo->EvvObservacion;?></textarea></td>
               <td align="left" valign="top">Entrega inmediata</td>
               <td align="left" valign="top"><?php
					switch($InsEntregaVentaVehiculo->EvvInmediata){
						case 1:
							$OpcInmediata1 = 'selected = "selected"';
						break;

						case 2:
							$OpcInmediata2 = 'selected = "selected"';						
						break;
						
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpInmediata" id="CmpInmediata">
                   <option <?php echo $OpcInmediata1;?> value="1">Si</option>
                   <option <?php echo $OpcInmediata2;?> value="2">No</option>
                 </select></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsEntregaVentaVehiculo->EvvEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 6:
						$OpcEstado6 = 'selected = "selected"';		
						break;
					}
					?>
                 <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                 </select></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones adicionales</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><input <?php echo (($InsEntregaVentaVehiculo->EvvNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                 Notificar aprobacion via email (*) </td>
               <td>&nbsp;</td>
             </tr>
             </table>
           
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">PROPIETARIOS </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapEntregaVentaVehiculoPropietarioAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncEntregaVentaVehiculoPropietarioListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncEntregaVentaVehiculoPropietarioEliminarTodo();"></a></td>
               <td width="1%"><div id="CapEntregaVentaVehiculoPropietariosResultado"> </div></td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapEntregaVentaVehiculoPropietarios" class="EstCapEntregaVentaVehiculoPropietarios" > </div></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="8"><span class="EstFormularioSubTitulo">Datos del Vehiculo 
                 
                 <input name="CmpVehiculoIngresoIdAnterior" type="hidden" id="CmpVehiculoIngresoIdAnterior" value="<?php echo $InsEntregaVentaVehiculo->EinIdAnterior;?>" size="3" />
                 
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsEntregaVentaVehiculo->EinId;?>" size="3" />
                 <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                 <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                 <input name="CmpPrecioMinimo" type="hidden" id="CmpPrecioMinimo" size="3" />
                 <input name="CmpBonoGM" type="hidden" id="CmpBonoGM" size="3" />
                 <input name="CmpBonoDealer" type="hidden" id="CmpBonoDealer" size="3" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top">Marca:</td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsEntregaVentaVehiculo->VmoId;?>" size="3" /></td>
               <td align="left" valign="top">Version:
                 <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsEntregaVentaVehiculo->VveId;?>" size="3" /></td>
               <td align="left" valign="top">Motor:</td>
               <td align="left" valign="top">Color:</td>
               <td align="left" valign="top">A&ntilde;o/Fab.</td>
               <td align="left" valign="top">A&ntilde;o/Mod.</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsEntregaVentaVehiculo->EinVIN);?>" size="20" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                 <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsEntregaVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top"><select disabled="disabled"class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
               </select></td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                 </select></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoNumeroMotor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoNumeroMotor" value="<?php echo ($InsEntregaVentaVehiculo->EinNumeroMotor);?>" size="8" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="VehiculoIngresoColor" type="text" class="EstFormularioCaja" id="VehiculoIngresoColor" value="<?php echo ($InsEntregaVentaVehiculo->EinColor);?>" size="8" maxlength="30" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo ($InsEntregaVentaVehiculo->EinAnoFabricacion);?>" size="8" maxlength="4" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoAnoModelo" type="text" class="EstFormularioCaja" id="CmpOrdenVentaVehiculoAnoModelo" value="<?php echo ($InsEntregaVentaVehiculo->EinAnoModelo);?>" size="8" maxlength="4" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
           
           </div></td>
       </tr>
       
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>        
        </table>
         
		

    </div>    
    


   
    

       
    
</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

	
	
	
    
       


     
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	

</script>


 <script type="text/javascript">
        $(document).ready(function(){
  
	  $('#CmpHora').timepicker(
	  { 
		'timeFormat': 'H:i' ,
		'minTime': '08:00',
		'maxTime': '18:00'
	  
	  }
	  );
	  
	});
    </script>
    
    
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
