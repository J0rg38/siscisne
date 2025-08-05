<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<!-- ARCHIVO DE FUNCIONES JS -->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleAutocompletar.js" ></script>-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCombo.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoInstalarFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoInstalarDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoInstalar.css');
</style>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}



//VARIABLES
$GET_id = $_GET['Id'];
$Registro = false;
$POST_Sucursal = $_POST['CmpSucursal'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoInstalar.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoInstalar.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoInstalarDetalle.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

//INSTANCIAS
$InsVehiculoInstalar = new ClsVehiculoInstalar();
$InsPersonal = new ClsPersonal();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();


$SucursalId = $POST_Sucursal;
//CONFIGURACIONES
//require_once($InsPoo->MtdPaqActividadConf().'CnfVehiculoInstalar.php');

if (isset($_SESSION['InsVehiculoInstalarDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoInstalarDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoInstalarDetalle'.$Identificador]);
}



//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoInstalarEditar.php');

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$InsVehiculoInstalar->SucId,NULL,NULL,true);
$ArrAsesores = $ResPersonal['Datos'];


$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
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
$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	
	 FncVehiculoInstalarDetalleListar();
	
});


var VehiculoInstalarDetalleEditar = 1;
var VehiculoInstalarDetalleEliminar = 1;

</script>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" >
<div class="EstCapMenu">
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
        INSTALACION DE ACCESORIOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoInstalar->VisTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoInstalar->VisTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         
          
        	<ul class="tabs">
        <li><a href="#tab1">Instalacion</a></li>
         

	</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
      
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">
           
           
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td><span class="EstFormularioSubTitulo">
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoInstalar->VisId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsVehiculoInstalar->VisFecha;?>" size="15" maxlength="10" />
                </label><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoInstalar->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
              </select></td>
            <td align="left" valign="top">Aprobado por:</td>
            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
              <option <?php echo ($DatAsesor->PerId==$InsVehiculoInstalar->PerId)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL CLIENTE Y VEHICULO</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Vehiculo:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVehiculoInstalar->EinId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">VIN:</td>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVehiculoInstalar->EinVIN;?>" size="25" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Placa:</td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVehiculoInstalar->VisVehiculoPlaca;?>" size="10" maxlength="50"  /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('Placa');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Marca:
                  <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoInstalar->VmaId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoMarca" value="<?php echo $InsVehiculoInstalar->VmaNombre;?>" size="15" maxlength="50"  /></td>
                <td align="left" valign="top" class="EstFormulario">Modelo:
                  <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoInstalar->VmoId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsVehiculoInstalar->VmoNombre;?>" size="15" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario">Version:
                  <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoInstalar->VveId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoVersion" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersion" value="<?php echo $InsVehiculoInstalar->VveNombre;?>" size="15" maxlength="50"/></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVehiculoInstalar->CliId;?>" size="3" />
                  <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsVehiculoInstalar->EinId;?>" size="3" /></td>
                <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento"  >
                  <option value="">Escoja una opcion</option>
                  <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                  <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVehiculoInstalar->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                  <?php
	}
	?>
                  </select></td>
                <td><a href="javascript:FncClienteSimpleNuevo();"></a></td>
                <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  tabindex="4" value="<?php echo $InsVehiculoInstalar->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" <?php if(!empty($InsVehiculoInstalar->CliId)){ echo 'readonly="readonly"';} ?>   /></td>
                <td><a href="javascript:FncClienteSimpleBuscar('NumeroDocumento');"></a></td>
                <td><input name="CmpClienteNombreCompleto" type="text" class="EstFormularioCaja" id="CmpClienteNombreCompleto"   tabindex="2" value="<?php echo $InsVehiculoInstalar->CliNombre;?> <?php echo $InsVehiculoInstalar->CliApellidoPaterno;?> <?php echo $InsVehiculoInstalar->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($InsVehiculoInstalar->CliId)){ echo 'readonly="readonly"';} ?>  />
                  <input type="hidden" name="CmpClienteNombre" id="CmpClienteNombre" value="<?php echo $InsVehiculoInstalar->CliNombre;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsVehiculoInstalar->CliApellidoPaterno;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsVehiculoInstalar->CliApellidoMaterno;?>" size="3" /></td>
                <td><a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
                <td></td>
                </tr>
              <tr> </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE LA INSTALACION</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td colspan="5" align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsVehiculoInstalar->VisReferencia;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observaciones:</td>
            <td colspan="5" align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpObservacionInterna" id="CmpObservacionInterna" cols="45" rows="4"><?php echo $InsVehiculoInstalar->VisObservacionInterna;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsVehiculoInstalar->VisEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
				
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
              </select></td>
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
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        
        
        
  </td>
       </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="98%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="3">&nbsp;</td>
                        <td colspan="11"><span class="EstFormularioSubTitulo">ACCESORIOS</span>
                          <input name="CmpProductoId"  type="hidden" class="EstFormularioCaja" id="CmpProductoId" size="10" maxlength="20" />
                          <input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
                          <input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />
                          <input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
                          <input name="CmpProductoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpProductoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                          <input name="CmpProductoVehiculoInstalarDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpProductoVehiculoInstalarDetalleId" size="3" maxlength="20"  /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td ><div id="CapProductoBuscar2"></div></td>
                        <td >C&oacute;digo Orig.</td>
                        <td >&nbsp;</td>
                        <td >C&oacute;digo Alt.</td>
                        <td >&nbsp;</td>
                        <td>Nombre : </td>
                        <td >&nbsp;</td>
                        <td >U.M.</td>
                        <td >Cantidad:</td>
                        <td >Estado:</td>
                        <td ><div id="CapProductoBuscar"></div></td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><?php
							//if(empty($InsVehiculoInstalar->OcoId)){
							?>
                          <a href="javascript:FncVehiculoInstalarDetalleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                          <?php
							//}
					   ?></td>
                        <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                        <td><?php
							//if(empty($InsVehiculoInstalar->OcoId)){
							?>
                          <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                          <?php
							//}
					   ?></td>
                        <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                        <td><?php
							//if(empty($InsVehiculoInstalar->OcoId)){
							?>
                          <a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                          <?php
							//}
					   ?></td>
                        <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                        <td><?php
							//if(empty($InsVehiculoInstalar->OcoId)){
							?>
                          <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /></a>
                          <?php
							//}
					   ?></td>
                        <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                        </select></td>
                        <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10" /></td>
                        <td><select  class="EstFormularioCombo" name="CmpVehiculoInstalarDetalleEstado" id="CmpVehiculoInstalarDetalleEstado">
                          <option value="0">-</option>
                          <option value="1">Pendiente</option>
                          <option selected="selected" value="3">Conforme</option>
                        </select></td>
                        <td><a href="javascript:FncVehiculoInstalarDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
              </div></td>
            </tr>
            <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVehiculoInstalarDetalleListar();">
                 <input type="hidden" name="CmpVehiculoInstalarDetalleAccion" id="CmpVehiculoInstalarDetalleAccion" value="AccVehiculoInstalarDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoInstalarDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="1%"><div id="CapVehiculoInstalarDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoInstalarDetalles" class="EstCapVehiculoInstalarDetalles" > </div></td>
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
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>
	
	
	
    

</form>


<script type="text/javascript">
<!--
//-->

Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
	
</script>

<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}

?>

