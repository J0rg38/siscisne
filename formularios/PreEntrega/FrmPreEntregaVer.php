<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaPDSDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntregaClienteFunciones.js" ></script>
<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPreEntrega.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPreEntrega.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');
include($InsProyecto->MtdFormulariosMsj('Vehiculo').'MsjVehiculo.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPreEntregaTarea = new ClsPreEntregaTarea();
$InsPreEntregaSeccion = new ClsPreEntregaSeccion();

$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();


$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"2,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

	if (!isset($_SESSION['InsPreEntregaDetalle'.$Identificador])){	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPreEntregaDetalle'.$Identificador]);
	}

	if (!isset($_SESSION['InsPreEntregaCliente'.$Identificador])){	
		$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsPreEntregaCliente'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPreEntregaCliente'.$Identificador]);
	}
	
foreach($ArrModalidadIngresos as $DatModalidadIngreso){

	if (!isset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}

	if (!isset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}
	
	if (!isset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}
	


}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPreEntregaEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];


//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrAsesores = $ResPersonal['Datos'];




$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	$('#CmpModalidad').focus();	

	FncPreEntregaPDSDetalleListar();
	
	FncPreEntregaClienteListar();
	
});


/*
Configuracion Formulario
*/

var FichaIngresoProductoEditar = 2;
var FichaIngresoProductoEliminar = 2;

var FichaIngresoTareaEditar = 2;
var FichaIngresoTareaEliminar = 2;

var FichaIngresoSuministroEditar = 2;
var FichaIngresoSuministroEliminar = 2;

var PreEntregaDetalleEditar = 2;
var PreEntregaDetalleEliminar = 2;

</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
          	<?php
			if($PrivilegioEditar and $InsFichaIngreso->FinEstado == 1){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFichaIngreso->FinId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER PRE-ENTREGA (PDS)</span></td>
      </tr>
      <tr>
        <td colspan="2">

<div class="EstFormularioArea">
         
	<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td>Creado el:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>  
                
                 <br />
                 
<ul class="tabs">
	<li><a href="#tab1">Pre-Entrega (PDS)</a></li>
	<li><a href="#tab2">Inventario</a></li>
<?php
	$c = 5;
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
			
?>		
		<li><a id="TabModalidad<?php echo $DatModalidadIngreso->MinSigla;;?>" href="#tab<?php echo $c;?>"><?php echo $DatModalidadIngreso->MinNombre;?></a></li>
<?php

	$c++;
	}
?>    


</ul>     

  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     


        
       
        
   
       
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
 
        <tr>
          <td valign="top">
          
          
          <div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Vehiculo</span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input name="CmpPreEntregaId" type="hidden" id="CmpPreEntregaId" value="<?php echo $InsFichaIngreso->EinId;?>" size="3" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsFichaIngreso->EinId;?>" size="3" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsFichaIngreso->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td>&nbsp;</td>
                   <td><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="30" maxlength="50" readonly="readonly"  /></td>
                   <td>&nbsp;</td>
                 </tr>
               </table></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td>Version:
                 <input name="CmpVehiculoIngresoVersionId" type="hidden" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>" size="3" /></td>
               <td><input  name="CmpVehiculoIngresoVersion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A&ntilde;o de Fabricacion:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>" size="30" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">Color:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoColor" value="<?php echo $InsFichaIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td><input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="3" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Kilometraje:</td>
               <td align="left"><input  name="CmpVehiculoKilometraje" type="text" class="EstFormularioCaja" id="CmpVehiculoKilometraje" value="<?php if(empty($InsFichaIngreso->FinVehiculoKilometraje)){ echo "0.00"; }else{echo $InsFichaIngreso->FinVehiculoKilometraje;}?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">Kilometraje/Plan Mant.:</td>
               <td align="left"><select class="EstFormularioCombo" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje" disabled="disabled" >
               </select>
                 <input type="hidden" name="CmpMantenimientoKilometrajeAux" id="CmpMantenimientoKilometrajeAux" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Campa&ntilde;a:</td>
               <td colspan="5" align="left"><input name="CmpCampanaId" type="hidden" id="CmpCampanaId"  value="<?php echo $InsFichaIngreso->CamId;?>" size="20" maxlength="50" />
                 <input name="CmpCampanaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaCodigo"  value="<?php echo $InsFichaIngreso->CamCodigo;?>" size="20" maxlength="20" />
                 <input name="CmpCampanaNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaNombre"  value="<?php echo $InsFichaIngreso->CamNombre;?>" size="60" maxlength="500" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="3" align="left">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div>
         
         
          
          </td>
        </tr>
        <tr>
          <td valign="top">
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la Pre-Entrega (PDS)
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Modalidad de Ingreso:</td>
                  <td align="left" valign="top">Codigo:</td>
                  <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsFichaIngreso->FinId;?>" size="15" maxlength="20" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td rowspan="6" align="left" valign="top"><?php
	
		
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		?>
                    <?php
            if(is_array($InsFichaIngreso->FichaIngresoModalidad)){	
                foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){
                    $aux = '';
                    if($DatFichaIngresoModalidad->MinId==$DatModalidadIngreso->MinId){
                        $aux = 'checked="checked"';						
                        break;
                    }					
                }
            }				
            ?>
                    <input disabled="disabled" etiqueta="modalidad" <?php echo $aux;?> type="checkbox" value="<?php echo $DatModalidadIngreso->MinId?>" name="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" id="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" sigla="<?php echo $DatModalidadIngreso->MinSigla;?>" />
                    <?php echo $DatModalidadIngreso->MinNombre?><br />
                    <?php	
		}
		?></td>
                  <td align="left" valign="top">Sucursal:</td>
                  <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                    <option value="">Escoja una opcion</option>
                    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                    <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsFichaIngreso->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                    <?php
    }
    ?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Asesor:</td>
                  <td colspan="3" align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpAsesor" id="CmpAsesor" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
                    <option <?php echo ($DatAsesor->PerId==$InsFichaIngreso->PerIdAsesor)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsFichaIngreso->FinFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">Hora:</td>
                  <td align="left" valign="top"><input  name="CmpHora" type="text" class="EstFormularioCaja" id="CmpHora" value="<?php if(empty($InsFichaIngreso->FinHora)){ echo date("H:i"); }else{echo $InsFichaIngreso->FinHora;}?>" size="10" maxlength="8" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Prioridad:</td>
                  <td align="left" valign="top"><?php
					switch($InsFichaIngreso->FinPrioridad){
						case 1:
							$OpcPrioridad1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcPrioridad2 = 'selected = "selected"';						
						break;

					}
					?>
                    <select  disabled="disabled" class="EstFormularioCombo" name="CmpPrioridad" id="CmpPrioridad">
                      <option <?php echo $OpcPrioridad1;?> value="1">Urgente</option>
                      <option <?php echo $OpcPrioridad2;?> value="2">Normal</option>
                      </select></td>
                  <td align="left" valign="top">Estado: </td>
                  <td align="left" valign="top"><?php
					switch($InsFichaIngreso->FinEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
					}
					?>
                    <select  class="EstFormularioCombo" name="CmpEstadoAux" id="CmpEstadoAux" disabled="disabled">
                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                      <option <?php echo $OpcEstado2;?> value="2">Revisado</option>
                      <option <?php echo $OpcEstado3;?> value="3">Pedido [Preparando]</option>
                      <option <?php echo $OpcEstado4;?> value="4">Pedido [Enviado]</option>
                      </select>
                    <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tecnico:</td>
                  <td colspan="3" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" disabled="disabled" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
                    <option <?php echo ($DatTecnico->PerId==$InsFichaIngreso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
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
       
       <tr>
         <td valign="top">
           
           <div class="EstFormularioArea">
             
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td><span class="EstFormularioSubTitulo">Propietarios</span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="center"><div class="EstFormularioArea" >
    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="48%"><div class="EstFormularioAccion" id="CapClienteAccion">Listo
          para registrar elementos</div></td>
        <td width="49%" align="right">
          
          <a href="javascript:FncPreEntregaClienteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> 
          
          </td>
        <td width="1%"><div id="CapPreEntregaClientesResultado"> </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><div id="CapPreEntregaClientes" class="EstCapPreEntregaClientes" > </div></td>
        <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="center">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               </table>
             
             
             </div>
           
           </td>
       </tr>        
        </table>
         
		

		 
    </div>    
    

 
    <div id="tab2" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  
                  
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Formato PDS</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        


<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="8"><span class="EstFormularioSubTitulo">Inventario de Ingreso</span></td>
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
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>EXTERIORES</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>INTERIORES</td>
                      <td>&nbsp;</td>
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
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><p>Lado Delantero</p></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lado Derecho</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Llave de Contacto:</td>
                      <td><input  name="CmpInterior1" type="text" class="EstFormularioCaja" id="CmpInterior1" value="<?php if(empty($InsFichaIngreso->FinInterior1)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Cenicero:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior15" type="text" id="CmpInterior15" value="<?php if(empty($InsFichaIngreso->FinInterior15)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior15;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parachoque:</td>
                      <td><input  name="CmpExteriorDelantero1" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero1" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero1)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo  Posterior:</td>
                      <td><input  name="CmpExteriorDerecho1" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho1" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho1)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Lunas Electricas:</td>
                      <td><input  name="CmpInterior2" type="text" class="EstFormularioCaja" id="CmpInterior2" value="<?php if(empty($InsFichaIngreso->FinInterior2)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Manual:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior16" type="text" id="CmpInterior16" value="<?php if(empty($InsFichaIngreso->FinInterior16)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior16;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Neblineros:</td>
                      <td><input  name="CmpExteriorDelantero2" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero2" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero2)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Tapa de Combustible:</td>
                      <td><input  name="CmpExteriorDerecho2" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho2" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho2)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Asiento (tela, cuero):</td>
                      <td><input  name="CmpInterior3" type="text" class="EstFormularioCaja" id="CmpInterior3" value="<?php if(empty($InsFichaIngreso->FinInterior3)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Antena:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior17" type="text" id="CmpInterior17" value="<?php if(empty($InsFichaIngreso->FinInterior17)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior17;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Faros:</td>
                      <td><input  name="CmpExteriorDelantero3" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero3" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero3)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Aros:</td>
                      <td><input  name="CmpExteriorDerecho3" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho3" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho3)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Asiento Piloto:</td>
                      <td><input  name="CmpInterior4" type="text" class="EstFormularioCaja" id="CmpInterior4" value="<?php if(empty($InsFichaIngreso->FinInterior4)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Copas de Aros / Vasos:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior18" type="text" id="CmpInterior18" value="<?php if(empty($InsFichaIngreso->FinInterior18)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior18;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Plumillas:</td>
                      <td><input  name="CmpExteriorDelantero4" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero4" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero4)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Posterior:</td>
                      <td><input  name="CmpExteriorDerecho4" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho4" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho4)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Controles de Tim&oacute;n:</td>
                      <td><input  name="CmpInterior5" type="text" class="EstFormularioCaja" id="CmpInterior5" value="<?php if(empty($InsFichaIngreso->FinInterior5)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Airbags:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior19" type="text" id="CmpInterior19" value="<?php if(empty($InsFichaIngreso->FinInterior19)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior19;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parabrisas:</td>
                      <td><input  name="CmpExteriorDelantero5" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero5" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero5)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Delantera:</td>
                      <td><input  name="CmpExteriorDerecho5" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho5" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho5)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Perilla de Palanca:</td>
                      <td><input  name="CmpInterior6" type="text" class="EstFormularioCaja" id="CmpInterior6" value="<?php if(empty($InsFichaIngreso->FinInterior6)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Seguro Cromado Rueda:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior20" type="text" id="CmpInterior20" value="<?php if(empty($InsFichaIngreso->FinInterior20)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior20;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Emble:</td>
                      <td><input  name="CmpExteriorDelantero6" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero6" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero6)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Espejo Lateral:</td>
                      <td><input  name="CmpExteriorDerecho6" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho6" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho6)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Radio (Cass/CD/MP/A/C):</td>
                      <td><input  name="CmpInterior7" type="text" class="EstFormularioCaja" id="CmpInterior7" value="<?php if(empty($InsFichaIngreso->FinInterior7)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gancho de remolque:</td>
                      <td><input  name="CmpInterior21" type="text" class="EstFormularioCaja" id="CmpInterior21" value="<?php if(empty($InsFichaIngreso->FinInterior21)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior21;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Bicel/Mascara:</td>
                      <td><input  name="CmpExteriorDelantero7" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero7" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero7)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDelantero7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo  Delantero:</td>
                      <td><input  name="CmpExteriorDerecho7" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho7" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho7)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>A/C:</td>
                      <td><input  name="CmpInterior8" type="text" class="EstFormularioCaja" id="CmpInterior8" value="<?php if(empty($InsFichaIngreso->FinInterior8)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior8;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Estuche de Herram.:</td>
                      <td><input  name="CmpInterior22" type="text" class="EstFormularioCaja" id="CmpInterior22" value="<?php if(empty($InsFichaIngreso->FinInterior22)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior22;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lunas:</td>
                      <td><input  name="CmpExteriorDerecho8" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho8" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho8)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorDerecho8;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Reloj:</td>
                      <td><input  name="CmpInterior9" type="text" class="EstFormularioCaja" id="CmpInterior9" value="<?php if(empty($InsFichaIngreso->FinInterior9)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior9;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gata llave de rueda Palanca:</td>
                      <td><input  name="CmpInterior23" type="text" class="EstFormularioCaja" id="CmpInterior23" value="<?php if(empty($InsFichaIngreso->FinInterior23)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior23;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Lado Posterior</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Espejo Retovisor:</td>
                      <td><input  name="CmpInterior10" type="text" class="EstFormularioCaja" id="CmpInterior10" value="<?php if(empty($InsFichaIngreso->FinInterior10)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior10;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Luz de Sal&oacute;n:</td>
                      <td><input  name="CmpInterior24" type="text" class="EstFormularioCaja" id="CmpInterior24" value="<?php if(empty($InsFichaIngreso->FinInterior24)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior24;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parachoque:</td>
                      <td><input  name="CmpExteriorPosterior1" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior1" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior1)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Lado Izquierdo</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Correas de Seguridad:</td>
                      <td><input  name="CmpInterior11" type="text" class="EstFormularioCaja" id="CmpInterior11" value="<?php if(empty($InsFichaIngreso->FinInterior11)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior11;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Triangulo:</td>
                      <td><input  name="CmpInterior25" type="text" class="EstFormularioCaja" id="CmpInterior25" value="<?php if(empty($InsFichaIngreso->FinInterior25)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior25;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Faros:</td>
                      <td><input  name="CmpExteriorPosterior2" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior2" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior2)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo Posterior:</td>
                      <td><input  name="CmpExteriorIzquierdo1" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo1" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo1)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Tapasoles:</td>
                      <td><input  name="CmpInterior12" type="text" class="EstFormularioCaja" id="CmpInterior12" value="<?php if(empty($InsFichaIngreso->FinInterior12)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior12;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Extintor:</td>
                      <td><input  name="CmpInterior26" type="text" class="EstFormularioCaja" id="CmpInterior26" value="<?php if(empty($InsFichaIngreso->FinInterior26)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior26;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Maletera:</td>
                      <td><input  name="CmpExteriorPosterior3" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior3" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior3)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Aros:</td>
                      <td><input  name="CmpExteriorIzquierdo2" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo2" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo2)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Sunroof:</td>
                      <td><input  name="CmpInterior13" type="text" class="EstFormularioCaja" id="CmpInterior13" value="<?php if(empty($InsFichaIngreso->FinInterior13)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior13;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Cobertor de Maletera:</td>
                      <td><input  name="CmpInterior27" type="text" class="EstFormularioCaja" id="CmpInterior27" value="<?php if(empty($InsFichaIngreso->FinInterior27)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior27;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Plumillas:</td>
                      <td><input  name="CmpExteriorPosterior4" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior4" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior4)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Posterior:</td>
                      <td><input  name="CmpExteriorIzquierdo3" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo3" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo3)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Encendedor:</td>
                      <td><input  name="CmpInterior14" type="text" class="EstFormularioCaja" id="CmpInterior14" value="<?php if(empty($InsFichaIngreso->FinInterior14)){ echo "0"; }else{echo $InsFichaIngreso->FinInterior14;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>5ta Llave de Aro:</td>
                      <td><input  name="CmpExteriorPosterior5" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior5" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior5)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Delantera:</td>
                      <td><input  name="CmpExteriorIzquierdo4" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo4" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo4)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td colspan="5" rowspan="4" align="right"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>1</td>
                          <td>&nbsp;</td>
                          <td>Buen Estado</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>2</td>
                          <td>&nbsp;</td>
                          <td>Pintura Rayada</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>3</td>
                          <td>&nbsp;</td>
                          <td>Abolladura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>4</td>
                          <td>&nbsp;</td>
                          <td>Rotura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>5</td>
                          <td>&nbsp;</td>
                          <td>Faltante</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>6</td>
                          <td>&nbsp;</td>
                          <td>Oxido</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>0</td>
                          <td>&nbsp;</td>
                          <td>No preseta</td>
                          <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Emblema:</td>
                      <td><input  name="CmpExteriorPosterior6" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior6" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior6)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorPosterior6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Espejo Lateral:</td>
                      <td><input  name="CmpExteriorIzquierdo5" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo5" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo5)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Gdfgo Delantero:</td>
                      <td><input  name="CmpExteriorIzquierdo6" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo6" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo6)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lunas:</td>
                      <td><input  name="CmpExteriorIzquierdo7" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo7" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo7)){ echo "0"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
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
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td colspan="10" align="left" valign="top">
                      
<!--<textarea name="CmpObservacion" cols="60" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFichaIngreso->FinObservacion;?></textarea>-->

<div class="EstFormularioCajaObservacion"> <?php echo stripslashes($InsFichaIngreso->FinObservacion);?> </div>
</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>

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
                    </table>
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
 
 
    
    
    
        
        
<?php
	$c = 5;
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		
		
				$FichaIngresoModalidadObsequio = '';

		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){	
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){

				if($DatFichaIngresoModalidad->MinId == $DatModalidadIngreso->MinId){

					$FichaIngresoModalidadObsequio = $DatFichaIngresoModalidad->FimObsequio;
				  
					break;
				}

			}
		}	
		
		
?>		

        <div id="tab<?php echo $c;?>" class="tab_content">
        

            <div class="EstFormularioArea" id="CapModalidad<?php echo $DatModalidadIngreso->MinSigla;?>">
            
            
              <?php
			
			switch($DatModalidadIngreso->MinSigla){
				
				default:
			?>
            
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">TAREAS</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                          para registrar elementos</div></td>
                        <td width="49%" align="right"><a href="javascript:FncPreEntregaTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="1%"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapPreEntregaTareas" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                      </table>
                  </div></td>
                  <td width="47%" align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                          para registrar elementos</div></td>
                        <td width="48%" align="right"><a href="javascript:FncPreEntregaProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="2%"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>ProductosResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>Productos" class="EstCapPreEntregaProductos" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                  <td width="3%" align="left" valign="top">
                  
                  <?php
				 /* 
				  ?>
                  <div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">SUMINISTROS </span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>SuministroAccion">Listo
                          para registrar elementos</div></td>
                        <td width="48%" align="right"><a href="javascript:FncPreEntregaSuministroListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="2%"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>SuministrosResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>Suministros" class="EstCapPreEntregaSuministros" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div>
                    <?php
				  */
				  ?>
                  
                  </td>
                </tr>
              </table>

             <?php	
				break;
				

				
				case "PP":
			?>
            
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td width="31%" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">TAREAS</span></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncPreEntregaTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPreEntregaTareaEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"></a></td>
                                  <td width="1%"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapPreEntregaTareas2" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="1%">&nbsp;</td>
                                <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                                  para registrar elementos</div></td>
                                <td width="49%" align="right"><a href="javascript:FncPreEntregaProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPreEntregaProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"></a></td>
                                <td width="1%"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>ProductosResultado"> </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><div id="CapPreEntrega<?php echo $DatModalidadIngreso->MinSigla;?>Productos" class="EstCapPreEntregaProductos" > </div></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">
                            
                            
                            </td>
                        </tr>
                      </table>
            <?php	
				break;
				
			}
			
			?>
            
            
			
          
            </div>
      
      
        
        
        </div>
<?php
	$c++;
	}
?>
    
    
    
    
    
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

?>
