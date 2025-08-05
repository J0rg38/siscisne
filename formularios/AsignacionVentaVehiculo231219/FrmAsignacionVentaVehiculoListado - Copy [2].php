<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php $PrivilegioPagoRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php $PrivilegioPagoListado = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>


<?php $PrivilegioVehiculoIngresoEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Editar"))?true:false;?>
<?php $PrivilegioVehiculoIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Ver"))?true:false;?>

<?php $PrivilegioEncuestaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Encuesta","Ver"))?true:false;?>
<?php $PrivilegioEncuestaEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Encuesta","Editar"))?true:false;?>
<?php $PrivilegioEncuestaRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Encuesta","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAsignacionVentaVehiculov2.js" ></script>
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
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Moneda = $_POST['Moneda'];

//if(!$_POST){
//	$POST_Moneda = "MON-10001";	
//}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'AvvTiempoCreacion';
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
	//$POST_finicio =  "01/01/".date("Y");
	$POST_finicio =  "01/".date("m")."/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAsignacionVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');




$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAsignacionVentaVehiculo.php');



//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL)
$ResAsignacionVentaVehiculo = $InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculos("AvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,NULL);
$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];
$AsignacionVentaVehiculosTotal = $ResAsignacionVentaVehiculo['Total'];
$AsignacionVentaVehiculosTotalSeleccionado = $ResAsignacionVentaVehiculo['TotalSeleccionado'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


?>




<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">
<?php
/*  if($PrivilegioGenerarExcel){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 

<?php	  
  }*/
  ?>
  
  
  
<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>


<?php
if($PrivilegioEditar){
?>
 


<div class="EstSubMenuSeparacion"></div>

<!--
<div class="EstSubMenuBoton"><a href="javascript:FncAsignacionVentaVehiculoActualizarPendienteSeleccionados();"><img src="imagenes/submenu/pendiente.png" alt="[Actualizar a Pendiente]" title="Actualizar a Pendiente" /> Pendiente</a></div>-->

<div class="EstSubMenuBoton"><a href="javascript:FncAsignacionVentaVehiculoActualizarEmitidoSeleccionados();"><img src="imagenes/submenu/realizar.png" alt="[Actualizar a Aprobado]" title="Actualizar a Aprobado" /> Revisado</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncAsignacionVentaVehiculoActualizarAnuladoSeleccionados();"><img src="imagenes/submenu/anular.png" alt="[Actualizar a Anulado]" title="Actualizar a Anulado" /> Anulado</a></div> 



<?php
}
?>


<?php
  if($PrivilegioGenerarExcel){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 

<?php	  
  }
  ?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE ASIGNACIONES DE VEHICULOS</span>  </td>
</tr>
<tr>
  <td width="50%">
    Mostrando <b><?php echo $AsignacionVentaVehiculosTotalSeleccionado;?></b> de <b><?php echo $AsignacionVentaVehiculosTotal;?></b> registros.</td>
  <td width="50%" align="right">
    
    
    <!--<table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td colspan="3" align="center">SubTotal</td>
        <td colspan="3" align="center">Impuesto</td>
        <td colspan="3" align="center">Total</td>
      </tr>
      <tr>
        <td width="16%" align="center"><div id="CapListadoSubTotal2" ></div></td>
        <td width="6%" align="center">/</td>
        <td width="15%" align="center"><div id="CapListadoSubTotal" ></div></td>
        <td width="15%" align="center"><div id="CapListadoImpuesto2" ></div></td>
        <td width="5%" align="center">/</td>
        <td width="14%" align="center"><div id="CapListadoImpuesto" ></div></td>
        <td width="12%" align="center"><div id="CapListadoTotal2" ></div></td>
        <td width="3%" align="center">/</td>
        <td width="14%" align="center"><div id="CapListadoTotal" ></div></td>
        </tr>
        
      </table>--></td>
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
    
            
            
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="8" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="8" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    
      
        Sucursal:
       
       <select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            
            
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="2%" >
                  
                  <?php
				if($POST_ord == "AvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AvvId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AvvId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AvvId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "SucNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SucNombre','DESC');"> Sucursal<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "OvvTiempoSolicitudEnvio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvTiempoSolicitudEnvio','ASC');"> Envio <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvTiempoSolicitudEnvio','DESC');"> Envio <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvTiempoSolicitudEnvio','ASC');"> Envio </a>
                  <?php
				}
				?></th>
                <th width="4%" >
                
                                <?php
				if($POST_ord == "AvvFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AvvFecha','ASC');"> Fecha Asignacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AvvFecha','DESC');"> Fecha Asignacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AvvFecha','ASC');"> Fecha Asignacion </a>
                  <?php
				}
				?>                </th>
                <th width="19%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
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
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Marca </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Modelo </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Version <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> Version <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> Version </a>
                  <?php
				}
				?></th>
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
                <th width="5%" ><?php
				if($POST_ord == "EinAnoFabricacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinAnoFabricacion','ASC');"> Año Fab. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinAnoFabricacion','DESC');"> Año Fab. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinAnoFabricacion','ASC');"> Año Fab. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "EinAnoModelo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinAnoModelo','ASC');"> Año Mod. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinAnoModelo','DESC');"> Año Mod. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinAnoModelo','ASC');"> Año Mod. </a>
                  <?php
				}
				?></th>
                <th width="2%" >Inicial</th>
                <th width="2%" >Abonos</th>
                <th width="6%" ><?php
				if($POST_ord == "MonId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonId','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonId','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('MonId','ASC');"> Moneda </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "OvvTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvTotal','ASC');"> Total </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OvvFacturado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvFacturado','ASC');"> Fact. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvFacturado','DESC');"> Fact. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvFacturado','ASC');"> Fact. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OvvCancelado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvCancelado','ASC');"> Canc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvCancelado','DESC');"> Canc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvCancelado','ASC');"> Canc. </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "OvvAprobacion1"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvAprobacion1','ASC');"> Aprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvAprobacion1','DESC');"> Aprob.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvAprobacion1','ASC');"> Aprob. </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "AvvEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AvvEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AvvEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AvvEstado','ASC');"> Est.  </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "PerNombreVendedor"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');">Asesor de Ventas <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Asesor de Ventas <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Asesor de Ventas </a>
                  <?php
				}
				?></th>
                <th width="10%" >
                  <?php
				if($POST_ord == "AvvTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('AvvTiempoCreacion','ASC');">
                 Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AvvTiempoCreacion','DESC');">
                    
               Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('AvvTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="25" align="center">

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

				  <option <?php if($POST_num==$AsignacionVentaVehiculosTotal){ echo 'selected="selected"';}?> value="<?php echo $AsignacionVentaVehiculosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $AsignacionVentaVehiculosTotal;
					//}else{
					//	$tregistros = ($AsignacionVentaVehiculosTotalSeleccionado);
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
								foreach($ArrAsignacionVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AvvId; ?>" estado = "<?php echo $dat->AvvEstado; ?>" factura_estado="<?php echo $dat->AvvFacturaEstado; ?>" boleta_estado="<?php echo $dat->AvvBoletaEstado; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   >
                  
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->AvvId;?>">
                  <?php echo $dat->AvvId;  ?>
                  </a>
                  
                </td>
                <td  width="3%" align="right" ><?php echo ($dat->SucNombre);?></td>
                <td  width="3%" align="right" ><?php echo $dat->OvvTiempoSolicitudEnvio;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->AvvFecha;  ?></td>
                <td  width="19%" align="left" ><?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  > - <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></a>
                  <?php	
}else{
?>
                  - <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?>
  <?php	
}
?>
  <?php
				/* $InsAsignacionVentaVehiculoPropietario = new ClsAsignacionVentaVehiculoPropietario();
				 
				 $ResAsignacionVentaVehiculoPropietario = $InsAsignacionVentaVehiculoPropietario->MtdObtenerAsignacionVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->AvvId);
				 $ArrAsignacionVentaVehiculoPropietarios = $ResAsignacionVentaVehiculoPropietario['Datos'];

//deb( $ArrAsignacionVentaVehiculoPropietarios);
				 ?>
  <?php
				 if(!empty($ArrAsignacionVentaVehiculoPropietarios)){
					 foreach($ArrAsignacionVentaVehiculoPropietarios as $DatAsignacionVentaVehiculoPropietario){
				?>
  <?php
					if($DatAsignacionVentaVehiculoPropietario->CliId <> $dat->CliId){
					?>
  <br />
  <?php
if($PrivilegioClienteVer){
?>
  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  > - <?php echo $DatAsignacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno;?> </a>
  <?php	
}else{
?>
                  - <?php echo $DatAsignacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno;?>
  <?php                        
}
?>
  <?php
					}
					?>
  <?php		 
					 }
				 }*/
				 ?></td>
                <td  width="4%" align="right" ><?php
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
                  <?php //echo ($dat->EinVIN);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoFabricacion);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoModelo);?></td>
                <td  width="2%" align="right" ><?php echo ($dat->OvvPagoInicialMonedaSimbolo);?> <?php echo number_format($dat->OvvPagoInicial,2);?></td>
                <td  width="2%" align="right" ><?php
//if($PrivilegioPagoListado and $dat->OvvPago == "Si"){
if( $dat->OvvPago == "Si"){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" > Tiene Abonos</a>
                  <?php
}else{
?>
                  No Tiene Abonos
  <?php	
}
?>
  <?php
/*if($PrivilegioPagoListado){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" >Ord. Cobro / Abonos</a>
                  <?php
}*/
?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="7%" align="right" ><?php $dat->OvvTotal = (($dat->OvvTotal/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));?>
                  <?php echo number_format($dat->OvvTotal,2);?></td>
                <td  width="5%" align="center" ><?php
				  
				switch($dat->AvvFacturado){
					
						case "Si":
				?>
                  <img width="25" height="25" alt="[Si]" title="Si" src="imagenes/estado/facturado_si.png" />
                  <?php
					
						break;
					
						case "No":
				?>
                  <img width="25" height="25" alt="[No]" title="No" src="imagenes/estado/facturado_no.png" />
                  <?php							
						break;	
						default:
					?>
                  -
  <?php	
						break;

					}
				?>
  <?php //echo $dat->OvvCancelado;  ?>
  <?php //echo $dat->AvvCancelado;  ?></td>
                <td  width="5%" align="center" ><?php
				  
				
				switch($dat->AvvCancelado){
				//switch($dat->AvvCancelado){
					
						case "Si":
				?>
                  <img width="25" height="25" alt="[Si]" title="Si" src="imagenes/estado/pagado_si.png" />
                  <?php
					
						break;
					
						case "No":
				?>
                  <img width="25" height="25" alt="[No]" title="No" src="imagenes/estado/pagado_no.png" />
                  <?php							
						break;	
						default:
					?>
                  -
  <?php	
						break;

					}
				?>
  <?php //echo $dat->OvvCancelado;  ?>
  <?php //echo $dat->AvvCancelado;  ?></td>
                <td  width="3%" align="right" ><?php
				switch($dat->AvvAprobacion){
					case 1:
				?>
                  <img src="imagenes/estado/aprobado.png" width="20" height="20" border="0" alt="Aprobado" title="Aprobado" />
                  <?php	
					break;
					
					case 2:
				?>
                  <img src="imagenes/estado/desaprobado.png" width="20" height="20" border="0" alt="Desaprobado" title="Desaprobado" />
                  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
				?></td>
                <td  width="3%" align="right" >
                  
                  
                  <?php
				
					switch($dat->AvvEstado){
					
					  case 1:
						?>
                  <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />
                  <?php
					  break;
					
					  case 3:
						 
						 ?>
                  <img width="15" height="15" alt="[Aprobado]" title="Aprobado" src="imagenes/estado/realizado.gif" />
                  <?php
						 
					  break;	
					  
					  case 6:
				
				?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                  <?php
				
				break;
					
					  default:
						  ?>
                  -
                  <?php
					  break;					
					
					}
					
				?>
                  
                  
                  <?php
				  echo $dat->AvvEstadoDescripcion;
				  ?>
                  <?php
				  /*
				switch($dat->AvvEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                  <?php							
						break;	

					}*/
				?></td>
                <td  width="8%" align="right" ><?php echo $dat->PerNombreVendedor;?> <?php echo $dat->PerApellidoPaternoVendedor;?> <?php echo $dat->PerApellidoMaternoVendedor;?></td>
                <td  width="10%" align="right" ><?php echo ($dat->AvvTiempoCreacion);?></td>
        <td  width="12%" align="center" >
<?php
if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->AvvId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>



<?php
if($PrivilegioEliminar and $dat->AvvEstado == 1){
?>
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->AvvId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Avvpletamente"   /></a>
<?php
}
?>               
				
<?php
if($PrivilegioEditar and $dat->AvvEstado == 1){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->AvvId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->AvvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}
?>



<?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncVistaPreliminar('<?php echo $dat->AvvId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncImprmir('<?php echo $dat->AvvId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
  
			

			</td>
              </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->AvvSubTotal;
									$Impuesto += $dat->AvvImpuesto ;
									$Total += $dat->OvvTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table></td>
</tr>
</table>
</div>

<input type="hidden" name="CmpListadoSubTotal" id="CmpListadoSubTotal" value="<?php echo $SubTotal;?>" />
<input type="hidden" name="CmpListadoImpuesto" id="CmpListadoImpuesto" value="<?php echo $Impuesto;?>" />
<input type="hidden" name="CmpListadoTotal" id="CmpListadoTotal" value="<?php echo $Total;?>" />



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

