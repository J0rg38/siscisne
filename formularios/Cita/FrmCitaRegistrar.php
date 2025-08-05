<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCombo.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCitaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCitaPresupuestoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCita.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCitaPresupuesto.css');
</style>

<?php
$Registro = false;
$POST_Sucursal = $_POST['CmpSucursal'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCita.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$SucursalId = $POST_Sucursal;
//CONFIGURACIONES
require_once($InsPoo->MtdPaqActividadConf().'CnfCita.php');

//CLASES
$InsCita = new ClsCita();
$InsPersonal = new ClsPersonal();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();

$SucursalSiglas = "";

if(!empty($POST_Sucursal)){

	$InsSucursal->SucId = $POST_Sucursal;
	$InsSucursal->MtdObtenerSucursal(false);
	$SucursalSiglas = $InsSucursal->SucSiglas;	
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCitaRegistrar.php');

//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
//$ArrAsesores = $ResPersonal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1,NULL,NULL,$InsCita->SucId,NULL,NULL,true);
$ArrAsesores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$InsCita->SucId,NULL,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];



//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
//$ArrTecnicos = $ResPersonal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1,NULL,NULL,NULL,$InsCita->SucId,NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


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
	FncCitaMantenimientoKilometrajeEstablecer();
	
	FncCitaHistorialListar();

});

</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" >	

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        CITA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
          <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
	<br />
        
	<ul class="tabs">
    
        <li><a href="#tab1">Cita</a></li>
        <li><a href="#tab3">Historial</a></li>
		<li><a href="#tab2">Presupuesto</a></li>
        
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
            <td width="4">&nbsp;</td>
            <td width="118">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Código Interno:

         </td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCita->CitId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top">
              
              
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsCita->CitFecha;?>" size="15" maxlength="10" />
              </label><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsCita->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select></td>
            <td align="left" valign="top">Registrado por:</td>
            <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonalRegistro" id="CmpPersonalRegistro" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
              <option <?php echo ($DatPersonal->PerId==$InsCita->PerIdRegistro)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Asesor:</td>
            <td colspan="5" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
              <option <?php echo ($DatAsesor->PerId==$InsCita->PerId)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE LA CITA</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tecnico:</td>
            <td colspan="5" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonalMecanico" id="CmpPersonalMecanico" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
              <option <?php echo ($DatTecnico->PerId==$InsCita->PerIdMecanico)?'selected="selected"':'';?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
              </select>
              
              


              <div id="CapPersonalHorario"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha Programada:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td width="309" align="left" valign="top">
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFechaProgramada" type="text" id="CmpFechaProgramada" value="<?php  echo $InsCita->CitFechaProgramada;?>" size="15" maxlength="10" />
                </label><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaProgramada" name="BtnFechaProgramada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td width="161" align="left" valign="top">Hora Programada:<br />
              <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
            <td width="314" align="left" valign="top"><input class="EstFormularioCajaHora" name="CmpHoraProgramada" type="text" id="CmpHoraProgramada" value="<?php  echo $InsCita->CitHoraProgramada;?>" size="15" maxlength="10" />
             
    
              
              
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
            -->
            
            
              
              
              </td>
            <td width="314" align="left" valign="top">Duracion Estimada:</td>
            <td width="314" align="left" valign="top"><?php
			switch($InsCita->CitDuracion){
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
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="5" align="left" valign="top">
            
            <a id="BtnCitaCalendario" href="javascript:void(0)"><img src="imagenes/acciones/icon_calendario_full120.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" />Ver Calendario</a> 
            <a id="BtnValidarCita" href="javascript:void(0);"><img src="imagenes/acciones/icon_validar120.png" width="25" height="25" border="0" alt="Validar" title="Validar" align="absmiddle" />Validar Cita</a>
            <a id="BtnCitaVerRestricciones" href="javascript:void(0)"><img src="imagenes/acciones/icon_restricciones120.png" width="25" height="25" border="0" alt="Restricciones" title="Restricciones" align="absmiddle" />Ver Restricciones</a> 

            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL CLIENTE Y VEHICULO</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsCita->CliId;?>" size="3" />
                  <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsCita->EinId;?>" size="3" /></td>
                <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento"  >
                  <option value="">Escoja una opcion</option>
                  <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                  <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCita->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                  <?php
	}
	?>
                  </select></td>
                <td><a href="javascript:FncClienteSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td><input <?php if(!empty($InsCita->CliId)){ echo 'readonly="readonly"';} ?>  tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsCita->CliNumeroDocumento;?>"   /></td>
                <td><a href="javascript:FncClienteSimpleBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td><input <?php if(!empty($InsCita->CliId)){ echo 'readonly="readonly"';} ?>   tabindex="2" class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsCita->CliNombre;?> <?php echo $InsCita->CliApellidoPaterno;?> <?php echo $InsCita->CliApellidoMaterno;?>"  />
                  <input type="hidden" name="CmpClienteNombre" id="CmpClienteNombre" value="<?php echo $InsCita->CliNombre;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsCita->CliApellidoPaterno;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsCita->CliApellidoMaterno;?>" size="3" /></td>
                <td><a id="BtnClienteRegistrar" onclick="FncClienteSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                <td></td>
                </tr>
              <tr> </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Vehiculo:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsCita->EinId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">VIN:</td>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsCita->EinVIN;?>" size="25" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Placa:</td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsCita->CitVehiculoPlaca;?>" size="10" maxlength="50"  /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('Placa');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Marca:
                  <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsCita->VmaId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoMarca" value="<?php echo $InsCita->CitVehiculoMarca;?>" size="15" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario">Modelo:
                  
                  <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsCita->VmoId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsCita->CitVehiculoModelo;?>" size="15" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario">Version:
                  <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsCita->VveId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoVersion" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersion" value="<?php echo $InsCita->CitVehiculoVersion;?>" size="15" maxlength="50" /></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td colspan="5" align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsCita->CitReferencia;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Mantenimiento:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpCitaPresupuestoMantenimientoKilometraje" id="CmpCitaPresupuestoMantenimientoKilometraje"  >
              </select>
              <input name="CmpKilometrajeMantenimiento" type="hidden" id="CmpKilometrajeMantenimiento" value="<?php echo $InsCita->CitKilometrajeMantenimiento;?>" size="3" />
              
              <a href="javascript:FncVehiculoMantenimientoResumenListado();">Ver Mantenimientos</a>
              
              </td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observaciones:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo $InsCita->CitDescripcion;?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsCita->CitEstado){
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
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        
           </td>
       </tr>
           
        </table>
         
		

    </div>    
             <div id="tab3" class="tab_content">
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top" align="center">
              
              
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">

        <tr>
          <td width="1%" align="left" valign="top"></td>
          <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Historial OTs</span></td>
          <td width="1%" align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top"></td>
          <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
              <tr>
                <td width="1%">&nbsp;</td>
                <td width="49%"><div class="EstFormularioAccion" id="CapCitaHistorialAccion">Listo
                  para registrar elementos</div></td>
                <td width="49%" align="right"><a href="javascript:FncCitaHistorialListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                <td width="1%"><div id="CapCitaHistorialesResultado"> </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2"><div id="CapCitaHistoriales" class="EstCapCitaHistoriales" > </div></td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </div></td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top"></td>
          <td colspan="2" align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        </table>
          
          
                
                </td>
            </tr>
            </table>
     
     
     
    
    </div>



         <div id="tab2" class="tab_content">
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top" align="center">
              
              
              <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"></td>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td>Tipo Cliente:</td>
                <td><span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpCitaPresupuestoClienteTipo" id="CmpCitaPresupuestoClienteTipo">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                    <option <?php echo (($DatClienteTipo->LtiId==$GET_ClienteTipoId)?'selected="selected"':'');?>  value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                    <?php
			}
			?>
                    </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>&nbsp;</td>
              </tr>
              </table>
          </fieldset> </td>
          <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td><input name="BtnCitaPresupuestoVer"   id="BtnCitaPresupuestoVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="return false;" /></td>
            </tr>
          </table></td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top">                  </td>
          
          <td colspan="2" align="left" valign="top">
          
          
          <div id="CapCitaPresupuesto"></div>
          
          
          </td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
          </table>
          
          
                
                </td>
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
	
	
	
Calendar.setup({ 
	inputField : "CmpFechaProgramada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaProgramada"// el id del botón que  
	});
</script>


    <script type="text/javascript">
        $(document).ready(function(){
            // find the input fields and apply the time select to them.
//            $('#CmpHoraProgramada').ptTimeSelect();

 //$('#CmpHoraProgramada').timepicker();
  $('#CmpHoraProgramada').timepicker(
  { 
	'timeFormat': 'H:i' ,
	'minTime': '07:30',
	'maxTime': '18:00'
  
  }
  );
  
	$('#CmpHoraProgramada').on('changeTime', function() {
		FncValidarPersonalHoraCita();
	});


		//	
//			$('#CmpHoraProgramada')
//			.ptTimeSelect({
//			//	containerClass: undefined,
//			//	containerWidth: undefined,
//				hoursLabel:     'Horas',
//				minutesLabel:   'Minutos',
//				setButtonLabel: 'Establecer Hora',
//			//	popupImage:     undefined,
//				onFocusDisplay: true,
//				zIndex:         10
//			//	onBeforeShow:   undefined,
//			//	onClose:        undefined
//			});
//			
	
	
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
