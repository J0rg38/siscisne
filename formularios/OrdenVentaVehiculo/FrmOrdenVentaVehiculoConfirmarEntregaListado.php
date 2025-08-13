<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado")){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

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
<?php  $PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"AccesoTotal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoConfirmarEntregaListado.js" ></script>
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
$POST_sen = ($_POST['Sen'] ?? '');
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num'] ?? '');

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
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_ActaEntrega = $_POST['CmpActaEntrega'];
$POST_Moneda = $_POST['Moneda'];	




if(!$_POST){
	$POST_Moneda = "MON-10001";
}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'OvvTiempoCreacion';
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

if(empty($POST_estado)){
	$POST_estado = 0;
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if(empty($POST_Moneda)){
	$POST_Moneda = $EmpresaMonedaId;
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');




require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
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

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');



$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculo.php');



//$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"General","AccesoTotal"))?true:false;

if($PrivilegioAccesoTotal){
	
		
//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0)
	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,$POST_Moneda,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,1,NULL,NULL,2);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];

}else{

	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,$POST_Moneda,$_SESSION['SesionPersonal'],NULL,0,NULL,NULL,NULL,$POST_Sucursal,1,NULL,NULL,2);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];

}


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];



$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

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
  
  




</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE  VEHICULOS POR ENTREGAR</span></td>
</tr>
<tr>
  <td width="50%">
    Mostrando <b><?php echo $OrdenVentaVehiculosTotalSeleccionado;?></b> de <b><?php echo $OrdenVentaVehiculosTotal;?></b> registros.</td>
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
    <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="OvvId" <?php if($POST_cam=="OvvId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Cliente</option>      

      
      
      </select>-->
    
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="8" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="8" maxlength="10"/>
    
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
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="4%" >
                  
                  <?php
				if($POST_ord == "OvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" >
                
                                <?php
				if($POST_ord == "OvvFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="9%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Doc.  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc.  </a>
                <?php
				}
				?></th>
                <th width="25%" ><?php
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
                <th width="5%" ><?php
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
                <th width="7%" ><?php
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
                <th width="7%" ><?php
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
                <th width="7%" ><?php
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
                <th width="6%" ><?php
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
                <th width="6%" ><?php
				if($POST_ord == "CveId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Prof. Ven. Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CveId','DESC');"> Prof. Ven. Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CveId','ASC');"> Prof. Ven. Veh. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OvvComprobanteVenta"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvComprobanteVenta','ASC');"> Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvComprobanteVenta','DESC');"> Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvComprobanteVenta','ASC');"> Comprob. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OvvInmediata"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvInmediata','ASC');"> Inmediata <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvInmediata','DESC');"> Inmediata. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OvvInmediata','ASC');"> Inmediata. </a>
                  <?php
				}
				?></th>
                <th width="5%" >Aprob. 1</th>
                <th width="5%" ><?php
				if($POST_ord == "OvvEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="5%" >
                  
                  Num. Comprob.
                  
                </th>
                <th width="4%" ><?php
				if($POST_ord == "PerNombre"){
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
                <th width="4%" >
                  <?php
				if($POST_ord == "OvvTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('OvvTiempoCreacion','ASC');">
                 Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvTiempoCreacion','DESC');">
                    
               Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('OvvTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="20" align="center">

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

				  <option <?php if($POST_num==$OrdenVentaVehiculosTotal){ echo 'selected="selected"';}?> value="<?php echo $OrdenVentaVehiculosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $OrdenVentaVehiculosTotal;
					//}else{
					//	$tregistros = ($OrdenVentaVehiculosTotalSeleccionado);
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
								foreach($ArrOrdenVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->OvvId; ?>" estado = "<?php echo $dat->OvvEstado; ?>" factura_estado="<?php echo $dat->OvvFacturaEstado; ?>" boleta_estado="<?php echo $dat->OvvBoletaEstado; ?>" aprobacion1="<?php echo $dat->OvvAprobacion1; ?>" aprobacion2="<?php echo $dat->OvvAprobacion2; ?>" aprobacion3="<?php echo $dat->OvvAprobacion3; ?>"  />				</td>

                <td align="right" valign="middle" width="4%"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->OvvId;?>">
				<?php echo $dat->OvvId;  ?>
                </a>
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->OvvFecha;  ?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="25%" align="left" >
                
<?php
if($PrivilegioClienteVer){
?>
    <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  >
    - <?php echo ($dat->CliNombre);?>
    <?php echo ($dat->CliApellidoPaterno);?>
    <?php echo ($dat->CliApellidoMaterno);?>
    </a>
<?php	
}else{
?>
    - <?php echo ($dat->CliNombre);?>
    <?php echo ($dat->CliApellidoPaterno);?>
    <?php echo ($dat->CliApellidoMaterno);?>
<?php	
}
?>
                
                   
                  
                  
                 <?php
				 $InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
				 
				 $ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->OvvId);
				 $ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

//deb( $ArrOrdenVentaVehiculoPropietarios);
				 ?>
                 
                 <?php
				 if(!empty($ArrOrdenVentaVehiculoPropietarios)){
					 foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
				?>
                	<?php
					if($DatOrdenVentaVehiculoPropietario->CliId <> $dat->CliId){
					?><br />
                    



              
<?php
if($PrivilegioClienteVer){
?>
<a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  >
		- <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?>
		<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?>
		<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>
	</a>
<?php	
}else{
?>
		- <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?>
                    	<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>
<?php                        
}
?>
                    
                        
                    <?php
					}
					?>
                	
                    
                <?php		 
					 }
				 }
				 ?>
               
                  
                  
                </td>
                <td  width="5%" align="right" >
				
				
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


<?php //echo ($dat->EinVIN);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvColor);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->CveId);?></td>
                <td  width="5%" align="right" >
                  <?php
				switch($dat->OvvComprobanteVenta){
					case "F":
				?>
                  FACTURA
                  <?php	
					break;
					
					case "B":
				?>
                  BOLETA
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                  
                  
                </td>
                <td  width="5%" align="right" ><?php
				switch($dat->OvvInmadiata){
					case 1:
				?>
                  Si
                  <?php	
					break;
					
					case 2:
				?>
                  No
  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
				?></td>
                <td  width="5%" align="center" ><?php
				switch($dat->OvvAprobacion1){
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
                <td  width="5%" align="right" ><?php
                switch($dat->OvvEstado){
				
				case 1:
				?>
                  <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />
                  <?php
					
				break;
				
				case 3:
				
				?>
                  <img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/realizado.gif" />
                  <?php
				
				break;	
				
				case 4:
				
				?>
                  <img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/por_facturar.png" />
                  <?php
				
				break;	
				
				case 5:
				
				?>
                  <img width="15" height="15" alt="[Facturado]" title="Facturado" src="imagenes/estado/facturado.png" />
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
				  //echo $dat->OvvEstadoIcono;
				  ?>
  <?php
				  echo $dat->OvvEstadoDescripcion;
				  ?>
  <?php
				  /*
				switch($dat->OvvEstado){
					
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
                <td  width="5%" align="right" >
                  
                  
                  <?php
				switch($dat->OvvComprobanteVenta){
					case "F":
				?>
 <a href="javascript:FncFacturaVistaPreliminar('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><?php echo $dat->OvvFacturaNumero?></a>
 
				  <?php	
					break;
					
					case "B":
				?>
                 <a href="javascript:FncBoletaVistaPreliminar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');"> <?php echo $dat->OvvBoletaNumero?></a>
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                  
                </td>
                <td  width="4%" align="right" ><?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OvvTiempoCreacion);?></td>
        <td  width="10%" align="center" >
<?php
/*if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->OvvId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}*/
?>



<?php
/*if($PrivilegioEliminar and $dat->OvvAprobacion1 == 3 and $dat->OvvAprobacion2 == 3){
?>
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->OvvId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Ovvpletamente"   /></a>
<?php
}*/
?>               
				
<?php
/*
if($PrivilegioEditar and $dat->OvvAprobacion1 == 3 and $dat->OvvAprobacion2 == 3){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->OvvId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}*/
?>				
	
<?php
/*if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->OvvId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}*/
?>



<?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncVistaPreliminar('<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncImprmir('<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
  

				
<?php
/*if($PrivilegioEditar){
?>      
	<a href="javascript:FncOrdenVentaVehiculoCargarFormulario('<?php echo (($PrivilegioEditar)?'Editar':'Ver');?>Nota','<?php echo $dat->OvvId?>');"  ><img src="imagenes/acciones/notas.png" alt="[Notas]" title="Notas" width="19" height="19" border="0" /></a>
<?php
}*/
?>	
<?php
/*if($PrivilegioPagoRegistrar){
?>
<a href="javascript:FncGenerarPago('<?php echo $dat->OvvId;?>');" ><img src="imagenes/acciones/orden_cobro.png" alt="[Orden Cobro]" title="Registrar Orden de Cobro"  width="19" height="19" border="0" /></a>
<?php
}*/
?>

  <?php
/*if($PrivilegioEditar){
?>	
  <a href="javascript:FncOrdenVentaVehiculoCargarFormulario('SeguimientoCliente','<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/llamadas.png" alt="[Llamadas]" title="Llamadas" width="19" height="19" border="0" /></a>
  <?php
}*/
?> 


  <?php
/*if($PrivilegioEditar  and $dat->OvvAprobacion1 == 1 and $dat->OvvAprobacion2 == 1){
?>	
  <a href="javascript:FncEntregaVentaVehiculoCargarFormulario('EntregaVentaVehiculo','Registrar','<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/entrega.png" alt="[Entrega]" title="Entrega" width="19" height="19" border="0" /></a>
  <?php
}*/
?> 

  <?php
if($PrivilegioEditar  and $dat->OvvAprobacion1 == 1 and $dat->OvvAprobacion2 == 1){
?>	
  <a href="javascript:FncEntregaVentaVehiculoCargarFormulario('OrdenVentaVehiculo','ConfirmarEntrega','<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/confirmar_entrega.png" alt="[Confirmar Entrega]" title="Confirmar Entrega" width="19" height="19" border="0" /></a>
  <?php
}
?> 


<?php
/*if(empty($dat->EncId)){
?>
    
    <?php
    if($PrivilegioEncuestaRegistrar and $dat->OvvAprobacion1 == 1 and $dat->OvvAprobacion2 == 1){
    ?>	
    
        <a href="javascript:FncEncuestaCargarFormulario('Registrar','','<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/encuesta2.jpg" alt="[Encuesta]" title="Encuesta" width="19" height="19" border="0" /></a>
    <?php
    }
    ?> 

<?php	
}else{
?>
	<?php
	if( ($PrivilegioEncuestaEditar or $PrivilegioEncuestaVer) and $dat->OvvAprobacion1 == 1 and $dat->OvvAprobacion2 == 1){
	?>	
   
    
		<a href="javascript:FncEncuestaCargarFormulario('<?php echo (($PrivilegioEncuestaEditar)?'Editar':'Ver');?>','<?php echo $dat->EncId;?>','<?php echo $dat->OvvId;?>');"><img src="imagenes/acciones/encuesta2.jpg" alt="[Encuesta]" title="Encuesta" width="19" height="19" border="0" /></a>
	<?php
	}
	?>   


<?php	
}*/
?>


<?php
/*if($PrivilegioEditar and ($dat->OvvEstado == 3) ){
?>           

<a href="javascript:FncOrdenVentaVehiculoSolicitarVIN('<?php echo $dat->OvvId;?>','<?php echo $dat->EinVIN;?>')"><img src="imagenes/acciones/enviar_correo3.png" width="19" height="19" border="0" title="Enviar Solicitud de VIN" alt="[Enviar Solicitud de VIN]"   /></a>   
    
    
<?php
}*/
?>


			</td>
              </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->OvvSubTotal;
									$Impuesto += $dat->OvvImpuesto ;
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

