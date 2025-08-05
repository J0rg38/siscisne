<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<?php $PrivilegioClienteEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Editar"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>

<?php $PrivilegioVehiculoIngresoEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Editar"))?true:false;?>
<?php $PrivilegioVehiculoIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Ver"))?true:false;?>

<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Especial"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPreEntrega.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPreEntrega.css');
</style>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

$POST_cam = ($_POST['Cam']);
$POST_fil = ($_POST['Fil']);

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord']);
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FinTiempoCreacion';
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


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPreEntrega.php');

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

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');


require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsSucursal = new ClsSucursal();
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPreEntrega.php');


//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL)


//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0) 

////MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL)

																																								//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL,$oSucursal=NULL,$oMigrado=true) {
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,FinConductor,VmaNombre,VmoNombre,VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Prioridad,$POST_Modalidad,NULL,NULL,NULL,0,NULL,NULL,2,0,NULL,NULL,0,NULL,NULL,NULL,NULL,$POST_Sucursal);


//$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Prioridad,$POST_Modalidad);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];
$FichaIngresosTotal = $ResFichaIngreso['Total'];
$FichaIngresosTotalSeleccionado = $ResFichaIngreso['TotalSeleccionado'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"2,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>




<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">
<?php
  if($PrivilegioGenerarExcel){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 

<?php	  
  }
  ?>
  
  			<?php
			if($PrivilegioImprimir){
			?>
            <div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
  <?php
			}
			?>
            
            
<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>

<?php
/*if($PrivilegioEditar){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarOrdenTrabajoContabilidadSeleccionados();"><img src="imagenes/iconos/enviar.png" alt="[Enviar OT a Contabilidad]" title="Enviar OT a Contabilidad" /> Facturacion</a></div> 

<?php
}*/
?>

<?php
if($PrivilegioEditar){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarOrdenTrabajoTallerSeleccionados();"><img src="imagenes/submenu/enviar_taller2.png" alt="[Enviar OT a Taller]" title="Enviar OT a Taller" /> Taller</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarOrdenTrabajoRecepcionSeleccionados();"><img src="imagenes/submenu/enviar_taller_cancelar.png" alt="[Cancelar Envio de OT a Taller]" title="Cancelar Envio de OT a Taller" /> Cancelar</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarFichaIngresoAlmacenSeleccionados();"><img src="imagenes/submenu/enviar_almacen2.png" alt="[Enviar OT a Almacen]" title="Enviar OT a Almacen" /> Almacen</a></div>

<?php
}
?>



</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" valign="top">
    
    
  <span class="EstFormularioTitulo">LISTADO DE PRE-ENTREGA (PDS) [  RECEPCION]</span>  </td>
  <td height="25" align="right" valign="top">
  
  <img src='imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='50' height='50' title='Recepcion' align="absmiddle"  >
  
  </td>
</tr>
<tr>
  <td width="47%" valign="top">
    Mostrando <b><?php echo $FichaIngresosTotalSeleccionado;?></b> de <b><?php echo $FichaIngresosTotal;?></b> registros.</td>
  <td width="53%" align="right" valign="top">
    
    
  </td>
</tr>
<tr>
  <td colspan="2" align="right" valign="top">
    
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
<!--    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="2" <?php if($POST_estado==2){ echo 'selected="selected"';}?>>En Proceso</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      -->
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
                <th width="8%" >Progreso</th>
                <th width="8%" >Modalidades</th>
                <th width="6%" ><?php
				if($POST_ord == "FinPrioridad"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','ASC');"> Prioridad <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','DESC');"> Prioridad <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','ASC');"> Prioridad </a>
                <?php
				}
				?></th>
                <th width="4%" >
                
                                <?php
				if($POST_ord == "FinFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="3%" ><?php
				if($POST_ord == "FinHora"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinHora','ASC');"> Hora <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinHora','DESC');"> Hora <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinHora','ASC');"> Hora </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "LtiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('LtiNombre','ASC');"> Tipo Cli. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('LtiNombre','DESC');"> Tipo Cli. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('LtiNombre','ASC');"> Tipo Cli. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente  </a>
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
                <th width="4%" ><?php
				if($POST_ord == "VmaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VmoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VveNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VveNombre','DESC');"> Version <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "EinColor"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinColor','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinColor','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinColor','ASC');"> Color </a>
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
                <th width="9%" ><?php
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
                <th width="6%" ><?php
				if($POST_ord == "FinTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','ASC');"> Fec. Registro <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','DESC');"> Fec. Registro <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','ASC');"> Fec. Registro </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FinEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinEstado','ASC');"> Est.  </a>
                  <?php
				}
				?></th>
                <th width="4%" >F.S.</th>
                <th width="4%" >Camp.</th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="24" align="center">

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
								foreach($ArrFichaIngresos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->FinId; ?>" estado="<?php echo $dat->FinEstado;?>" personal="<?php echo $dat->PerId?>" />				</td>
                <td align="right" valign="middle" width="2%"   >
                  <span class="EstTablaListadoCodigo">
                  <?php echo $dat->FinId;  ?>
                  </span>
                </td>
                <td  width="8%" align="left" ><?php
$porcentaje = 0;
	switch($dat->FinEstado){
		
		case 1:
			$porcentaje = 3.75;

		break;
		
		case 11:
			$porcentaje = 3.75 + 3.75;
		break;
		
		case 2:
			$porcentaje = 3.75 + 3.75 + 12;
		break;
		
		case 3:
			$porcentaje = 3.75 + 3.75 + 12 + 12;
		break;
		
		case 4:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12;
		break;
		
		case 5:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667;
		break;
		
		case 6:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 7:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 71:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 72:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 73:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12;
		break;
		
		case 74:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75;
		break;
		
		case 75:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75;
		break;
		
		case 9:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75 +5;
		break;
	}

?>
                  <?php
				$clase = "";
				if($porcentaje >= 0 and $porcentaje < 11){
					$clase = "EstPreEntregaNivel1";
				}else if($porcentaje >= 11 and $porcentaje < 21){
					$clase = "EstPreEntregaNivel2";
				}else if($porcentaje >= 21 and $porcentaje < 31){
					$clase = "EstPreEntregaNivel3";
				}else if($porcentaje >= 31 and $porcentaje < 41){
					$clase = "EstPreEntregaNivel4";
				}else if($porcentaje >= 41 and $porcentaje < 51){
					$clase = "EstPreEntregaNivel5";
				}else if($porcentaje >= 51 and $porcentaje < 61){
					$clase = "EstPreEntregaNivel6";
				}else if($porcentaje >= 61 and $porcentaje < 71){
					$clase = "EstPreEntregaNivel7";
				}else if($porcentaje >= 71 and $porcentaje < 81){
					$clase = "EstPreEntregaNivel8";
				}else if($porcentaje >= 81 and $porcentaje < 91){
					$clase = "EstPreEntregaNivel9";
				}else if($porcentaje >= 91 and $porcentaje < 101){
					$clase = "EstPreEntregaNivel10";
				}
				?>
                <div class="<?php echo $clase ?>" > <?php echo number_format($porcentaje,2); ?> %</div></td>
                <td  width="8%" align="left" >
                
                <?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$dat->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
          
		<?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
			-<?php echo $DatFichaIngresoModalidad->MinNombre?><br>
		<?php
		}
		?>
                </td>
                <td  width="6%" align="right" >
                  
                  <?php
				switch($dat->FinPrioridad){
					case 1:
				?>
                  Urgente
                  <?php	
					break;
					
					case 2:
				?>
                  Normal
                  <?php	
					break;
				}
				?>
                  
                </td>
                <td  width="4%" align="right" ><?php echo $dat->FinFecha;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->FinHora;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="3%" align="right" ><?php echo (empty($dat->LtiAbreviatura)?$dat->LtiNombre:$dat->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?></td>
                <td  width="5%" align="right" >
				
              
  -        

<?php
if($PrivilegioClienteEditar or $PrivilegioClienteVer){
?>

<a href="javascript:FncClienteCargarFormulario('<?php echo (($PrivilegioClienteEditar)?'Editar':'Ver');?>','<?php echo $dat->CliId?>');"  ><?php echo ($dat->CliNombre);?></a>

<?php
}else{
?>
<?php echo ($dat->CliNombre);?>
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
    ?>
    
	
                
                </td>
                <td  width="3%" align="right" >


<?php
if($PrivilegioVehiculoIngresoEditar or $PrivilegioVehiculoIngresoVer){
?>

<a href="javascript:FncVehiculoIngresoCargarFormulario('<?php echo (($PrivilegioVehiculoIngresoEditar)?'Editar':'Ver');?>','<?php echo $dat->EinId?>');"  ><?php echo ($dat->EinVIN);?></a>

<?php
}else{
?>
<?php echo ($dat->EinVIN);?>
<?php	
}
?>   

      <?php
	  
	if(!empty($dat->VreId)){
?>
      <a href="javascript:FncVehiculoRecepcionVistaPreliminar('<?php echo $dat->VreId?>');"  > <img src="imagenes/avisos/alerta.gif" border="0" alt="Reclamo" title="Reclamo" width="15" height="15" /></a>
      <?php
	}
?>

</td>
                <td  width="4%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinPlaca);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->FinVehiculoKilometraje);?></td>
                <td  width="9%" align="right" >
				
				<?php echo ($dat->PerNombre);?>
                <?php echo ($dat->PerApellidoPaterno);?>
                <?php echo ($dat->PerApellidoMaterno);?>
                
                </td>
                <td  width="6%" align="right" ><?php echo ($dat->FinTiempoCreacion);?></td>
                <td  width="3%" align="right" >
                  
                  
                  <?php echo $dat->FinEstadoDescripcion;?>
                  
                  </td>
                <td  width="4%" align="center" ><a href="formularios/TallerPedido/DiaAlmacenMovimientoListado.php?height=440&amp;width=850&amp;FinId=<?php echo $dat->FinId?>" class="thickbox" title="">Fichas Salida</a></td>
                <td  width="4%" align="center" ><?php
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
?></td>
                <td  width="12%" align="center" >
                  
                  
<?php
if($PrivilegioAuditoriaVer){
?>
  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->FinId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  

<?php
if($dat->FinEstado == 1){
		 
?>                 
	<?php
    if($PrivilegioEliminar){
    ?>
      <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->FinId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Finpletamente"   /></a>
      <?php
    }
    ?>               
                      
      <?php
    if($PrivilegioEditar){
    ?>             
                      
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                      
      <?php
    }
    ?>	

<?php
}
?>	

   <?php
    //if($dat->FinEstado==11 or $dat->FinEstado==2){
if($dat->FinEstado<>1){		
    ?>             
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Trabajar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/trabajar.gif" width="19" height="19" border="0" title="Corregir" alt="[Corregir]"   /></a>
      <?php
    }
    ?>
    
    
    
      <?php
    /*if($dat->FinEstado==11 or $dat->FinEstado==2){
    ?>             
                      
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarTecnico&Id=<?php echo $dat->FinId;?>"><img src="imagenes/editar_mecanico.png" width="19" height="19" border="0" title="Editar Tecnico" alt="[Editar Tecnico]"   /></a>                 
                      
      <?php
    }
    ?>	
    
      <?php
    if($dat->FinEstado==11 or $dat->FinEstado==2){
    ?>             
                      
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarInventario&Id=<?php echo $dat->FinId;?>"><img src="imagenes/editar_inventario.png" width="19" height="19" border="0" title="Editar Inventario" alt="[Editar Inventario]" /></a>                 
                      
      <?php
    }*/
    ?>			
                  
  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->FinId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  
                  
  <?php
}
?>
                  
                  
                  
  <?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncVistaPreliminar('<?php echo $dat->FinId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            

                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        

     <a href="javascript:FncImprmir('<?php echo $dat->FinId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>

                  <?php
			}
			?> 
                  
<?php
/*//deb($dat->FinEstado);
if($PrivilegioEditar and ($dat->FinEstado==2 or $dat->FinEstado==3 or $dat->FinEstado==4)){
//if($PrivilegioEditar and ($dat->FinEstado<>1 and $dat->FinEstado<>11  )){
?>             
  <a href="javascript:FncFichaAccionModalidadIngresoEditar('<?php echo $dat->FinId;?>');"><img src="imagenes/iconos/mingreso.png" width="19" height="19" border="0" title="Modalidad Ingreso" alt="[Modalidad Ingreso]"   /></a>                 
<?php
}*/
?>	   


<?php
if($PrivilegioEditar and ($dat->FinEstado  == 1 or $dat->FinEstado == 11  )){
?>             
    <a href="javascript:FncFichaIngresoModalidadIngresoEditar('<?php echo $dat->FinId;?>');"><img src="imagenes/iconos/mingreso.png" width="19" height="19" border="0" title="Modalidad Ingreso" alt="[Modalidad Ingreso]"   /></a>
    
<?php
}else if($PrivilegioEditar and ($dat->FinEstado  == 2 or $dat->FinEstado == 3 or $dat->FinEstado == 4)){
?>

<a href="javascript:FncFichaAccionModalidadIngresoEditar('<?php echo $dat->FinId;?>');"><img src="imagenes/iconos/mingreso.png" width="19" height="19" border="0" title="Modalidad Ingreso" alt="[Modalidad Ingreso]"   /></a>   

<?php	
}else if($PrivilegioEditar and ($dat->FinEstado  == 5 or $dat->FinEstado == 6 or $dat->FinEstado == 7 or $dat->FinEstado == 71 or $dat->FinEstado == 73 or $dat->FinEstado == 74 or $dat->FinEstado == 75 or $dat->FinEstado == 9)){
?>

	<a href="javascript:FncTallerPedidoModalidadIngresoEditar('<?php echo $dat->FinId;?>');"><img src="imagenes/iconos/mingreso.png" width="19" height="19" border="0" title="Modalidad Ingreso" alt="[Modalidad Ingreso]"   /></a>        
    
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
<td align="left" valign="middle">
<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' align="absmiddle" > Contabilidad
</td>
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

