<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<?php $PrivilegioInformeTecnicoATS3Registrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccion.js" ></script>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');

//	if($_POST){
//		$_SESSION[$GET_mod."P"] = $POST_p;
//	}else{
//		$POST_p =  $_SESSION[$GET_mod."P"];	
//	}
	
$POST_num = ($_POST['Num']);

	if($_POST){
		$_SESSION[$GET_mod."Num"] = $POST_num;
	}else{
		$POST_num =  $_SESSION[$GET_mod."Num"];	
	}
	
$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

/*
* Otras variables
*/

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_ConCampana = $_POST['ConCampana'];
$POST_Tipo = $_POST['Tipo'];
$POST_Sucursal = $_POST['CmpSucursal'];


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
	

}


   

if(empty($POST_ord)){
//	$POST_ord = 'FinTiempoCreacion';
	$POST_ord = 'FinFecha';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}




/*
* Otras variables
*/

if(empty($POST_finicio)){
	$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaAccion.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

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

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsModalidadIngreso = new ClsModalidadIngreso();
$InsFichaIngreso = new ClsFichaIngreso();
$InsSucursal = new ClsSucursal();

$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaAccion.php');

//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL) {
//	deb($_SESSION['SesionPersonal']);

$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"AccesoTotal"))?true:false;

//deb($PrivilegioAccesoTotal );
//deb($PrivilegioAccesoTotal);
//deb($_SESSION['SesionPersonal']);
if($PrivilegioAccesoTotal){
////MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL) {
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,FinConductor,VmaNombre,VmoNombre,VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"11,2,3,4,5,6,7,71,72,73,74,75,8,9,10",$POST_Prioridad,$POST_Modalidad,NULL,NULL,NULL,0,NULL,NULL,$POST_Tipo,0,$POST_ConCampana,NULL,0,NULL,NULL,NULL,NULL,$POST_Sucursal);
//echo "aaa";
}else{
//echo "bbb";
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,FinConductor,VmaNombre,VmoNombre,VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"11,2,3,4,5,6,7,71,72,73,74,75,8,9,10",$POST_Prioridad,$POST_Modalidad,NULL,NULL,$_SESSION['SesionPersonal'],0,NULL,NULL,$POST_Tipo,0,$POST_ConCampana,NULL,0,NULL,NULL,NULL,NULL,$POST_Sucursal);

	
}


$ArrFichaIngresos = $ResFichaIngreso['Datos'];
$FichaIngresosTotal = $ResFichaIngreso['Total'];
$FichaIngresosTotalSeleccionado = $ResFichaIngreso['TotalSeleccionado'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">


<?php
if($PrivilegioEditar){
?>

<!--<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoRecepcionSeleccionados();"><img src="imagenes/iconos/enviar_recepcion.png" alt="[Rechazar OT de Recepcion]" title="Rechazar OT de Recepcion" /> Rechazar </a></div>
-->
<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoRecepcionSeleccionados2();"><img src="imagenes/submenu/enviar_recepcion_anular.png" alt="[Anular Recepcion de OT]" title="Anular Recepcion de OT" /> Anular </a></div>


	<div class="EstSubMenuSeparacion"></div>
 
<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoAlmacenSeleccionados();"><img src="imagenes/submenu/enviar_almacen2.png" alt="[Enviar OT a Almacen]" title="Enviar OT a Almacen" /> Almacen</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoTallerSeleccionados();"><img src="imagenes/submenu/enviar_almacen_cancelar2.png" alt="[Cancelar envio de OT a Almacen]" title="Cancelar envio de OT a Almacen" /> Cancelar </a></div>

<!--	<div class="EstSubMenuSeparacion"></div>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoTallerExternoSeleccionados();"><img src="imagenes/iconos/enviar_taller_externo2.png" alt="[Enviar OT a Taller Externo]" title="Enviar OT a Taller Externo" /> Taller Externo</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoTallerExternoCancelarSeleccionados();"><img src="imagenes/iconos/enviar_taller_externo_cancelar2.png" alt="[Cancelar envio de OT a Taller Externo]" title="Cancelar envio de OT a Taller Externo" /> Cancelar </a></div>


<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoTallerExternoRetornoSeleccionados();"><img src="imagenes/iconos/enviar_taller_externo_retorno.png" alt="[Envio de OT de Retorno de Taller Externo]" title="Envio de OT de Retorno de Taller Externo" /> Retorno </a></div>
-->

<!--	
<div class="EstSubMenuSeparacion"></div>
-->

<div class="EstSubMenuSeparacion"></div>

<div class="EstSubMenuBoton"><a href="javascript:FncMarcarTrabajoTerminadoSeleccionados();"><img src="imagenes/submenu/marcar_terminado.png" alt="[Marcar como Trabajo Terminado]" title="Marcar como Trabajo Terminado" /> Terminado</a></div> 
<div class="EstSubMenuBoton"><a href="javascript:FncDesmarcarTrabajoTerminadoSeleccionados();"><img src="imagenes/submenu/marcar_terminado_cancelar.png" alt="[Desmarcar como Trabajo Terminado]" title="Desmarcar como Trabajo Terminado" />  Desmarcar</a></div> 


<!--
<div class="EstSubMenuBoton"><a href="javascript:FncMarcarTrabajoConcluidoSeleccionados();"><img src="imagenes/iconos/marcar_terminado.png" alt="[Marcar como Trabajo Concluido]" title="Marcar como Trabajo Concluido" /> Terminado</a></div> 
<div class="EstSubMenuBoton"><a href="javascript:FncDesmarcarTrabajoConcluidoSeleccionados();"><img src="imagenes/iconos/marcar_terminado_cancelar.png" alt="[Desmarcar como Trabajo Concluido]" title="Desmarcar como Trabajo Concluido" />  Desmarcar</a></div> 
-->

<!--<div class="EstSubMenuSeparacion"></div>

<div class="EstSubMenuBoton"><a href="javascript:FncMarcarTrabajoConcluidoSeleccionados();"><img src="imagenes/iconos/marcar_concluido.png" alt="[Marcar como Trabajo Concluido]" title="Marcar como Trabajo Concluido" />  Concluido</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncDesmarcarTrabajoConcluidoSeleccionados();"><img src="imagenes/iconos/desmarcar_concluido.png" alt="[Desmarcar como Trabajo Concluido]" title="Desmarcar como Trabajo Concluido" />  Desmarcar</a></div> 
  
-->
<?php
}
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25">
    
    
  <span class="EstFormularioTitulo">LISTADO DE ORDENES DE TRABAJO [TALLER]</span>  </td>
  <td height="25" align="right"><img src='imagenes/iconos/taller.png' alt='TALLER' border='0' width='50' height='50' title='Taller' align="absmiddle" ></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $FichaIngresosTotalSeleccionado;?></b> de <b><?php echo $FichaIngresosTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
  </td>
</tr>
<tr>
  <td colspan="2" align="right">
    
    <input type="hidden" name="Acc" id="Acc" value="" />
    <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
    <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
    <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
    <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
    
    <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
    
    
      <span class="EstFormularioEtiqueta">Buscar:</span>

 <span class="EstFormularioContenido">  
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    </span>
    
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
    <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="fin.FinId" <?php if($POST_cam=="fin.FinId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="EinVIN" <?php if($POST_cam=="EinVIN"){ echo 'selected="selected"';}?>>VIN de Vehiculo</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Nombre del Cliente</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. del Cliente</option>
      <option value="FinConductor" <?php if($POST_cam=="FinConductor"){ echo 'selected="selected"';}?>>Nombre del Conductor</option>
s      </select>-->

Campa&ntilde;a
    <select  class="EstFormularioCombo" name="ConCampana" id="ConCampana">
    <option value="" >Todos</option>
    <option  <?php if($POST_ConCampana==1){ echo 'selected="selected"';}?> value="1">Con Campaña</option>
    <option  <?php if($POST_ConCampana==2){ echo 'selected="selected"';}?> value="2">Sin Campaña</option>
    </select>
 
      Prioridad
      
		<select  class="EstFormularioCombo" name="Prioridad" id="Prioridad">
      <option value="" >Todos</option>
		<option  <?php if($POST_estado==1){ echo 'selected="selected"';}?> value="1">Urgente</option>
		<option  <?php if($POST_estado==2){ echo 'selected="selected"';}?> value="2">Normal</option>
		</select>
        
         
    Modalidad Ingreso <select  class="EstFormularioCombo" name="Modalidad" id="Modalidad">

    <option value="" >Todos</option>
    <?php
    foreach($ArrModalidadIngresos as $DatModalidadIngreso){
    ?>
    	<option <?php echo ($DatModalidadIngreso->MinId==$POST_Modalidad)?'selected="selected"':'';?> value="<?php echo $DatModalidadIngreso->MinId?>"><?php echo $DatModalidadIngreso->MinSigla;?> - <?php echo $DatModalidadIngreso->MinNombre;?></option>
    <?php	
    }
    ?>
</select>
         Visualizar
      
		<select  class="EstFormularioCombo" name="Tipo" id="Tipo">
      <option value="" >Todos</option>
		<option  <?php if($POST_Tipo==1){ echo 'selected="selected"';}?> value="1">Ord. Trabajo</option>
		<option  <?php if($POST_Tipo==2){ echo 'selected="selected"';}?> value="2">PDS</option>
		</select>
                        
                        
                        
                        
                        
Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />	  <span class="EstFormularioEtiqueta">   Sucursal:
       </span>
       <span class="EstFormularioContenido">  
       <select  <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            </span>
            
            
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" >
                  
                  <?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "FinReferencia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinReferencia','ASC');"> Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinReferencia','DESC');"> Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinReferencia','ASC');"> Ref. </a>
                  <?php
				}
				?></th>
                <th width="8%" >Modalidades</th>
                <th width="4%" >
                
                                <?php
				if($POST_ord == "FinFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha y Hora <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinFecha','DESC');"> Fecha y Hora <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha y Hora </a>
                  <?php
				}
				?>                </th>
                <th width="5%" ><?php
				if($POST_ord == "FinFechaEntrega"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinFechaEntrega','ASC');"> Fec. Entrega Estimada <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinFechaEntrega','DESC');">  Fec. Entrega Estimada <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinFechaEntrega','ASC');">  Fec. Entrega Estimada </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FinFechaGarantia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinFechaGarantia','ASC');"> Fec. Garantia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinFechaGarantia','DESC');"> Fec. Garantia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinFechaGarantia','ASC');"> Fec. Garantia </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente  </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> VIN <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> VIN <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> VIN </a>
                <?php
				}
				?></th>
                <th width="5%" >Vehiculo</th>
                <th width="4%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Color </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "EinPlaca"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinPlaca','ASC');"> Placa <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinPlaca','DESC');"> Placa <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinPlaca','ASC');"> Placa </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FinVehiculoKilometraje"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','DESC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> </a>
                <?php
				}
				?></th>
                
                
                
                <th width="10%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span></a>
                  <?php
				}
				?></th>
                
                
                
                <th width="3%" ><?php
				if($POST_ord == "FinEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinEstado','ASC');"> Est. </a>
                <?php
				}
				?></th>
                <th width="2%" >Ref.</th>
                <th >Cam. / Prom.</th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="19" align="center">

				Mostrar de
				<select class="EstFormularioCombo" onChange="javascript:FncListar(this.value);" name="Num" id="Num">
				  <option <?php if($POST_num=="5"){ echo 'selected="selected"';}?> value="5">5</option>
				  <option <?php if($POST_num=="10"){ echo 'selected="selected"';}?> value="10">10</option>
				  <option <?php if($POST_num=="15"){ echo 'selected="selected"';}?> value="15">15</option>
				  <option <?php if($POST_num=="20"){ echo 'selected="selected"';}?> value="20">20</option>
				  <option <?php if($POST_num=="25"){ echo 'selected="selected"';}?> value="25">25</option>
				  <option <?php if($POST_num=="30"){ echo 'selected="selected"';}?> value="30">30</option>
				  <option <?php if($POST_num=="50"){ echo 'selected="selected"';}?> value="50">50</option>
				  <option <?php if($POST_num=="100"){ echo 'selected="selected"';}?> value="100">100</option>
<option <?php if($POST_num=="125"){ echo 'selected="selected"';}?> value="125">125</option>
<option <?php if($POST_num=="150"){ echo 'selected="selected"';}?> value="150">150</option>

				  <option <?php if($POST_num==$FichaIngresosTotal){ echo 'selected="selected"';}?> value="<?php echo $FichaIngresosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $FichaIngresosTotal;
					//}else{
					//	$tregistros = ($FichaIngresosTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>



					<?php
					if($POST_p<>"1"){
					?>

					<a class="EstPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');">
					Inicio					</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<=$cant_paginas & $POST_p<>"1"){

					$pagina = explode(",",$POST_pag);

					?>
					<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
					<?php
					}
					?>

					&nbsp;
					<?php
					$xpag =10;
					
					$inicio = 0;
					$fin = 0;
					
					if($POST_p-$xpag>0){
						$inicio = $POST_p-$xpag;
					}else{
						$inicio = $POST_p-($POST_p-$xpag*-1);
					}

					if($POST_p+$xpag<$cant_paginas){
						$fin = $POST_p+$xpag;
					}else{
						$fin = $POST_p+($POST_p-$xpag*-1);
					}
					?>
					<?php
					$num = 0;
					
					for($i=1;$i<=$cant_paginas;$i++){
					?>
						
                        <?php
						if($i>=$inicio and $i<=$fin){
						?>	
                        
                        <?php
						if($POST_p==$i){
						?>
                        <span class="EstPaginaActual"><?php echo $i;?></span>
                        <?php	
						}else{
						?>
	<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>                        
                        <?php	
						}
						?>

    					<?php
						}
						?>
					
					<?php
							$num = $num + $numxpag ;
					}
					?>

					&nbsp;
					<?php
					if($POST_p<$cant_paginas){
						$pagina = explode(",",$POST_pag);
					?>
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<>$cant_paginas){
					?>
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
					<?php
					}
					?>
					&nbsp;
						Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                    </td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
					$Color = "FFFFFF";
					
								foreach($ArrFichaIngresos as $dat){


	if($f%2==0){
											$Color = "#FFFFFF";
										}else{
											$Color = "#EEEEEE";
								
										}
										
										
								?>

           

              <tr id="Fila_<?php echo $f;?>"> 
                <td width="1%" align="center" bgcolor="<?php echo $dat->FinPrioridadColor;?>"   ><?php echo $f;?></td>
                <td width="2%" align="center" bgcolor="<?php echo $Color;?>" >
                  
                  
  <?php
//if($PrivilegioEditar and ($dat->FinEstado==2 or $dat->FinEstado==3)){
?>             
  <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->FinId; ?>" estado="<?php echo $dat->FinEstado;?>" taller_externo="<?php echo $dat->FinTallerExterno;?>" />				    
  <?php
//}
?>	
                  
</td>
                <td align="right" valign="middle" width="2%"  bgcolor="<?php echo $Color;?>" >
                
                  <!--<span class="EstTablaListadoCodigo">-->
                 <!--<h2 style="color:<?php echo (($dat->FinCierre == 1)?'#F00':'000000');?>;"> <?php echo $dat->FinId;  ?></h2>-->
                 <h2> <?php echo $dat->FinId;  ?></h2>
                 <!-- </span>-->
                                      <?php
if($dat->FinCierre == 1 ){
?>
<img src="imagenes/estado/cierre_ot.png" width="25" height="25" title="Cierre O.T." align="Cierre O.T." />

                  <?php
}
?>	 
                </td>
                <td  width="8%" align="left"  bgcolor="<?php echo $Color;?>" ><?php echo ($dat->FinReferencia);?></td>
                <td  width="8%" align="left" bgcolor="<?php echo $Color;?>" ><?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$dat->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
                  <?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
                  -<?php echo $DatFichaIngresoModalidad->MinNombre?><br />
  <?php
		}
		?></td>
                <td  width="4%" align="right" bgcolor="<?php echo $Color;?>" ><?php echo $dat->FinFecha;  ?> <?php echo $dat->FinHora;  ?></td>
                <td  width="5%" align="right" bgcolor="#AEE3AE" >
                  
                  <?php echo (empty($dat->FinFechaEntrega)?'':$dat->FinFechaEntrega);?>
                  <?php echo ((empty($dat->FinHoraEntrega) or $dat->FinHoraEntrega == "00:00:00")?'':$dat->FinHoraEntrega);?>
                  
                </td>
                <td  width="3%" align="right" bgcolor="<?php echo $Color;?>" ><?php echo ($dat->FinFechaGarantia);?>
                  <?php if(!empty($dat->FinGarantiaDiaTranscurrido)){?>
(<?php echo $dat->FinGarantiaDiaTranscurrido;?>)
<?php }?></td>
                <td  width="5%" align="right" bgcolor="<?php echo $Color;?>" >-
                  <?php
if($PrivilegioClienteEditar or $PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('<?php echo (($PrivilegioClienteEditar)?'Editar':'Ver');?>','<?php echo $dat->CliId?>');"  ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></a>
                  <?php
}else{
?>
                  <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?>
                  <?php	
}
?>
                  <?php

if($dat->CliCSIIncluir == "2"){
?>
                  <img src="imagenes/avisos/retirado.gif" alt="" width="15" height="15" border="0" align="Excluido CSI" title="Excluido CSI" />
                  <?php	
}
?>
                  <?php
$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
$ResVehiculoIngresoCliente =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$dat->EinId);
				$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
				
?>
                  <?php
	if(!empty($ArrVehiculoIngresoClientes)){
	?>
                  <br />
                  <?php
    	foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
	?>
                  <?php
		if($dat->CliId<>$DatVehiculoIngresoCliente->CliId){
		?>
-
<?php
            if($PrivilegioClienteEditar or $PrivilegioClienteVer){
            ?>
<a href="javascript:FncClienteCargarFormulario('<?php echo (($PrivilegioClienteEditar)?'Editar':'Ver');?>','<?php echo $DatVehiculoIngresoCliente->CliId?>');"  ><?php echo ($DatVehiculoIngresoCliente->CliNombre);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoPaterno);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoMaterno);?></a>
<?php
            }else{
            ?>
<?php echo ($DatVehiculoIngresoCliente->CliNombre);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoPaterno);?> <?php echo ($DatVehiculoIngresoCliente->CliApellidoMaterno);?>
<?php	
            }
            ?>
<br />
<?php
		}
		?>
<?php	
		}
	}
    ?></td>
                <td  width="3%" align="right" bgcolor="<?php echo $Color;?>" >
                  
                  
                  
                  
                  <?php echo ($dat->EinVIN);?>             <?php
	  
	if(!empty($dat->VreId)){
?>
                  <a href="javascript:FncVehiculoRecepcionVistaPreliminar('<?php echo $dat->VreId?>');"  > <img src="imagenes/avisos/alerta.gif" border="0" alt="Reclamo" title="Reclamo" width="15" height="15" /></a>
                  <?php
	}
?>
                  
                  
                  <?php
	if($dat->FinTieneNota == "Si"){
?>
                  <a href="javascript:FncAvisoCargarFormulario('<?php echo $dat->EinId?>');"  > <img src="imagenes/estado/notas.png" border="0" alt="Notas" title="Notas" width="25" height="25" /></a>
                  <?php
	}
?>		
                  
                </td>
                <td  width="5%" align="left" bgcolor="<?php echo $Color;?>" ><b>Marca:</b> <?php echo ($dat->VmaNombre);?><br />
                  <b>Modelo:</b> <?php echo ($dat->VmoNombre);?><br />
                  <b>Version:</b> <?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" bgcolor="<?php echo $Color;?>" ><?php echo ($dat->EinColor);?></td>
                <td  width="4%" align="right" bgcolor="<?php echo $Color;?>" >
				<h2>
				<?php echo ($dat->EinPlaca);?>
                </h2>
                </td>
                <td  width="3%" align="right" bgcolor="<?php echo $Color;?>" >
				   <?php
				if(!empty($dat->FinVehiculoKilometraje)){
				?>
					<?php echo ($dat->FinVehiculoKilometraje);?> km
                <?php	
				}
				?>
                
                </td>
                <td  width="10%" align="right" bgcolor="<?php echo $Color;?>" ><?php echo ($dat->PerNombre);?> <?php echo ($dat->PerApellidoPaterno);?> <?php echo ($dat->PerApellidoMaterno);?></td>
                <td  width="3%" align="center" bgcolor="<?php echo $Color;?>" >
                  
                  
                  <?php echo $dat->FinEstadoDescripcion;?>
                  <?php echo $dat->FinEstado;?>
                  
            
                  
                </td>
                <td  width="2%" align="left" bgcolor="<?php echo $Color;?>" >
                 
                 
                 
					<a href="javascript:FncTallerPedidoVerFichas('<?php echo $dat->FinId?>');"><img src="imagenes/acciones/enlace.gif" align="Enlace" title="Enlace" border="0" width="18" height="18" /> Fichas</a>
                  
                  
                   
                  
                  <?php
/*				if($dat->FinCotizacionProducto=="Si"){
				?>
                  
                  
                  
                  <a href="javascript:FncCotizacionProductoListadoCargar('<?php echo $dat->FinId?>');" title=""><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" /> Cot.</a>
                  
                  <br />
                  <?php
				}
*/				?>
                  <?php
/*//if($dat->FinAlmacenMovimientoSalida == "Si"){
?>
                  
                  <a href="javascript:FncPedidoCompraListadoCargar('<?php echo $dat->FinId?>');" title=""><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" /> Ord. Compra</a>
  <br /> 
                  
                  
                  <?php	
//}*/
?>
                  
  <?php
/*if($dat->FinGarantia == "Si"){
?>
                  <!-- <a href="formularios/TrabajoTerminado/DiaGarantiaListado.php?height=440&amp;width=850&amp;FinId=<?php echo $dat->FinId?>" class="thickbox" title=""><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" title="Enlace" align="Enlace" border="0" /> Hoja Garantia</a>-->
                  <a href="javascript:FncHojaGarantiaListadoCargar('<?php echo $dat->FinId?>');" title=""><img src="imagenes/acciones/enlace.gif" alt="" width="18" height="18" border="0" align="Enlace" title="Enlace" /> Hoja Garantia</a>
                  
                  <br />
                  
                  <?php	
}*/
?>
                  
                  
                </td>
                <td align="center" bgcolor="<?php echo $Color;?>" ><?php
			/*	if(!empty($dat->CamId)){
				?>
                
<!--<a href="javascript:FncCampanaCargarFormulario('Ver','<?php echo $dat->CamId?>');"  >

                <img src="imagenes/menu/campanas.png" alt="[Campañas]" title="Campañas" border="0" align="absmiddle" width="20" height="20" /> </a>-->
                


                <?php					
				}*/
				?>
                  <?php
if(!empty($dat->CamId)){
?>
                  <?php
				if(!empty($dat->CamBoletin)){
				?>
                  <a  href="subidos/campana/<?php echo $dat->CamBoletin; ?>" target="_blank"  > <img src="imagenes/menu/campanas.png" alt="[Campañas]" title="<?php echo $dat->CamCodigo; ?> - <?php echo $dat->CamNombre; ?>" border="0" align="absmiddle" width="20" height="20" /></a>
                  <?php					
				}else{
?>
                  <a  href="javascript:alert('!No se encontro boletin de campaña¡');"> <img  src="imagenes/menu/campanas.png" alt="[Campañas]" title="<?php echo $dat->CamCodigo; ?> - <?php echo $dat->CamNombre; ?>" border="0" align="absmiddle" width="20" height="20" /></a>
                  <?php	
				}
				?>
                <?php   
}
?>
				
				<?php 
				
				/* if(!empty($dat->OvvId)){
				?>
                  <a href="javascript:FncOrdenVentaVehiculoVerPlan('<?php echo $dat->OvvId;?>','<?php echo $dat->FinCantidadMantenimientos;?>');"><img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                  <?php	 
				 }*/
				 
				 ?>
                <?php 				
				 if(!empty($dat->ObsId)){
				?>
                
					<?php
                    if(!empty($dat->ObsFoto)){
                    ?>
                    	
<a target="<?php echo (!empty($dat->ObsArchivo)?'_blank'.$dat->ObsArchivo:'');?>" href="<?php echo (!empty($dat->ObsArchivo)?'subidos/obsequio_archivos/'.$dat->ObsArchivo:'#');?>">


                        <img src="imagenes/avisos/<?php echo $dat->ObsFoto;?>" alt="<?php echo $dat->ObsNombre?>" title="<?php echo $dat->ObsNombre?>" border="0" width="25" height="25"/>
</a>
                        
                    <?php	
                    }else{
                    ?>
                    <a target="<?php echo (!empty($dat->ObsArchivo)?'_blank'.$dat->ObsArchivo:'');?>" href="<?php echo (!empty($dat->ObsArchivo)?'subidos/obsequio_archivos/'.$dat->ObsArchivo:'#');?>">

                    <img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                    <?php	
                    }
                    ?>
                 
				  <?php	 
				 }
				 ?>        
                 
                     <?php
                if(!empty($dat->OvmId)){
                ?>
                  
                  <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId;?>');">
                    <img src="imagenes/avisos/gratuito.png" alt="Mantenimiento Gratuito" title="Mantenimiento Gratuito" border="0" width="25" height="25"/></a>
                  
                  
                  <?php  
                }
                ?>   
                
                        </td>
                <td  width="12%" align="center"  >
                  
  <!--<div id="myDiv">Right click to view the context menu</div>

<ul id="myMenu" class="contextMenu" style="display: none; top: 146px; left: 114px;">
<li class="edit">
<a href="#edit">Edit</a>
</li>
<li class="cut separator">
<a href="#cut">Cut</a>
</li>
<li class="copy">
<a href="#copy">Copy</a>
</li>
<li class="paste">
<a href="#paste">Paste</a>
</li>
<li class="delete">
<a href="#delete">Delete</a>
</li>
<li class="quit separator">
<a href="#quit">Quit</a>
</li>
</ul>-->
                  
                  
                  <?php
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
?>
                  
                  <?php
/*    if($PrivilegioEditar){
    ?>
      <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->FinId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Finpletamente"   /></a>
      <?php
    }
    ?>    
    
    
    	<?php
    if($PrivilegioEliminar){
    ?>
      <a href="PrivilegioEditar:FncEliminarSeleccionado('<?php echo $dat->FinId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Finpletamente"   /></a>
      <?php
    }*/
    ?>    
                  
                  
                  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->FinId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  
                  <?php
if($PrivilegioRegistrar and $dat->FinEstado==11){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Registrar&FinId=<?php echo $dat->FinId;?>"><img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Generar Sub Ordenes de Trabajo" alt="[Generar Sub Ordenes de Trabajo]"   /></a>                
                  <?php
}
?>  
                  
                  
                  <?php

//if($InsFichaIngreso->FinEstado==4  || $InsFichaIngreso->FinEstado==5 || $InsFichaIngreso->FinEstado==6 || $InsFichaIngreso->FinEstado == 72 || $InsFichaIngreso->FinEstado == 7 || $InsFichaIngreso->FinEstado == 71 || $InsFichaIngreso->FinEstado == 73 ){
//if($PrivilegioEditar and ($dat->FinEstado==4 || $dat->FinEstado==5 || $dat->FinEstado==6 || $dat->FinEstado == 72 || $dat->FinEstado==71 or $dat->FinEstado==7 || $InsFichaIngreso->FinEstado == 73 )){
//if($PrivilegioEditar and ($dat->FinEstado==4 || $dat->FinEstado==5 || $dat->FinEstado==6 || $dat->FinEstado == 72 || $dat->FinEstado==71 or $dat->FinEstado==7 || $InsFichaIngreso->FinEstado == 73 )){
//if($PrivilegioEditar and ($dat->FinEstado==4 or $dat->FinEstado==5 or $dat->FinEstado==6 or $dat->FinEstado == 72 or $dat->FinEstado==71 or $dat->FinEstado==7 or $dat->FinEstado == 73 or $dat->FinEstado == 74 or $dat->FinEstado == 75  or $dat->FinEstado == 9   or $dat->FinEstado == 10)){
//if($PrivilegioEditar and ($dat->FinEstado==4 or $dat->FinEstado==5 or $dat->FinEstado==6 or $dat->FinEstado == 72 or $dat->FinEstado==71 or $dat->FinEstado==7 or $dat->FinEstado == 73 or $dat->FinEstado == 74 or $dat->FinEstado == 75  or $dat->FinEstado == 9   or $dat->FinEstado == 10)){

	if($PrivilegioEditar 
	
	and (
	$dat->FinEstado==4 or $dat->FinEstado==5 or $dat->FinEstado==6 or $dat->FinEstado == 72 or $dat->FinEstado==71 or $dat->FinEstado==7 or $dat->FinEstado == 73 or $dat->FinEstado == 73 or $dat->FinEstado == 74 or $dat->FinEstado == 75 or $dat->FinEstado == 9 or $dat->FinEstado == 10
	
	) 
	
	and
	
	$dat->FinCierre == 2){
?>             
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Trabajar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/trabajar.gif" width="19" height="19" border="0" title="Adicionar" alt="[Adicionar]"   /></a>                 
                  <?php
}
?>	
                  
                  
                  <?php
/*if($PrivilegioEditar and ($dat->FinEstado==4 || $dat->FinEstado==5 || $dat->FinEstado==6 || $dat->FinEstado == 72)){
?>             
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Adicionar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/trabajar.gif" width="19" height="19" border="0" title="Adicionar" alt="[Adicionar]"   /></a>                 
<?php
}
?>		

<?php
if($PrivilegioEditar and ( $dat->FinEstado==71 or $dat->FinEstado==7)){
?>             
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Recibir&Id=<?php echo $dat->FinId;?>"><img src="imagenes/editar.gif" width="19" height="19" border="0" title="Recibir Pedido" alt="[Recibir]"   /></a>
<?php
}*/
?>	
                  
                  
                  
                  
                  <?php
//if($PrivilegioEditar and ($dat->FinEstado==2 or $dat->FinEstado==3)){
if($PrivilegioEditar and ($dat->FinEstado==2 or $dat->FinEstado==3)){
?>             
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  <?php
}
?>		
                  
                  
                  
                  
                  <?php
if($PrivilegioVer and $dat->FinEstado <> 11){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  <?php
}
?>
                  
                  <?php
//deb($dat->FinEstado);
if($PrivilegioEditar and ($dat->FinEstado==2 or $dat->FinEstado==3 or $dat->FinEstado==4)){
?>             
                  <a href="javascript:FncFichaAccionModalidadIngresoEditar('<?php echo $dat->FinId;?>');"><img src="imagenes/iconos/mingreso.png" width="19" height="19" border="0" title="Modalidad Ingreso" alt="[Modalidad Ingreso]"   /></a>                 
                  <?php
}
?>		
                  
                  
  <?php
// and $dat->FinGarantiaGenerar == "Si"
if($PrivilegioInformeTecnicoATS3Registrar){
?>             
                  <a href="principal.php?Mod=InformeTecnicoATS3&Form=Registrar&FinId=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/informe_tecnico.png" width="19" height="19" border="0" title="Generar Informe" alt="[Generar Informe]"   /></a>                 
                  <?php
}
?>		
                  
                  
                  
                  
                  
                  <?php
/*if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->FinId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}*/
?>
                  
                  <?php
/*if($PrivilegioImprimir){
?>        
	<a href="javascript:FncImprmir('<?php echo $dat->FinId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
<?php
}*/
?> 
                  
                  
                     <?php
//deb($dat->FinEstado);
if($PrivilegioEditar){
?>             
<a href="javascript:FncTallerPedidoEnviarCorreo('<?php echo $dat->FinId;?>');"><img src="imagenes/acciones/enviar_correo.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
                  <?php
}
?>		               
                  
                </td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
								

									?>
            </tbody>
      </table></td>
</tr>
</table>


<br />
<table border="0" cellpadding="2" cellspacing="2" class="EstPanelTablaListado">
<tbody class="EstPanelTablaListadoBody">
<tr>
  <td align="left" valign="middle" ><span class="EstPanelTablaListadoTitulo">LEYENDA: </span></td>
<td align="left" valign="middle">

<img src='imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' align="absmiddle"  > Recepcion
</td>
<td align="left" valign="middle">&nbsp;</td>
<td align="left" valign="middle">
<img src='imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' align="absmiddle" > Taller
</td>
<td align="left" valign="middle">&nbsp;</td>
<td align="left" valign="middle">

<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'  align="absmiddle"> Almacen
</td>
<td align="left" valign="middle">&nbsp;</td>
<td align="left" valign="middle"><img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' align="absmiddle" /> Contabilidad </td>
<td align="left" valign="middle">&nbsp;</td>
<td align="left" valign="middle">

<img src="imagenes/avisos/retirado.gif" width="20" height="20" border="0" align="absmiddle" title="Excluido CSI" alt="Excluido CSI"  />

Alerta CSI

</td>
<td align="left" valign="middle">&nbsp;</td>
<td align="left" valign="middle">&nbsp;</td>
</tr>
</tbody>
</table>


</div>



</form>


<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "FechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "FechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); 
</script>
<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

