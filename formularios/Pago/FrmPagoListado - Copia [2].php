<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") ){
?>


<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php $PrivilegioRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPago.js" ></script>

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

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Estado = $_POST['Estado'];

$POST_Area = $_POST['Area'];
$POST_Moneda = $_POST['Moneda'];
$POST_Origen = $_POST['Origen'];
$POST_Sucursal = $_SESSION['SesionSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PagTiempoCreacion';
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
	$POST_finicio = "01/".date("m/Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

if($_POST){
	$_SESSION[$GET_mod."Area"] = $POST_Area;
}else{
	$POST_Area = (empty($_GET['Area'])?$_SESSION[$GET_mod."Area"]:$_GET['Area']);
}

if($_POST){
   $_SESSION[$GET_mod."Origen"] = $POST_Origen;
}else{
	$POST_Origen = (empty($_GET['Origen'])?$_SESSION[$GET_mod."Origen"]:$_GET['Origen']);
}  


if($_POST){
   $_SESSION[$GET_mod."Moneda"] = $POST_Moneda;
}else{
	$POST_Moneda = (empty($_GET['Moneda'])?$_SESSION[$GET_mod."Moneda"]:$_GET['Moneda']);
}  

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsPago = new ClsPago();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsArea = new ClsArea();
$InsSucursal = new ClsSucursal();

$InsPago->UsuId = $_SESSION['SesionId'];

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPago.php');

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL)
$ResPago = $InsPago->MtdObtenerPagos("PagId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,"3,6",$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,$POST_Area,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"PagFecha",$POST_Origen,NULL,$POST_Sucursal);

$ArrPagos = $ResPago['Datos'];
$PagosTotal = $ResPago['Total'];
$PagosTotalSeleccionado = $ResPago['TotalSeleccionado'];

$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","ASC",NULL,NULL);
$ArrAreas = $ResArea['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">

<?php
  if($PrivilegioGenerarExcel){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/submenu/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 

<?php	  
  }
  ?>
  
  
<?php
if($PrivilegioEditar){
?>
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarUtilizadoSeleccionados();">
    <img src="imagenes/acciones/utilizado.png" alt="[Act. Utilizado]" title="Actualizar estado UTILIZADO los seleccionados" />Utilizado</a></div> 
    
    
    <div class="EstSubMenuBoton"><a href="javascript:FncPagoActualizarEmitidoSeleccionados();"><img src="imagenes/submenu/realizar.png" alt="[Actualizar a Listo]" title="Actualizar a Listo" /> Listo</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncPagoActualizarAnuladoSeleccionados();"><img src="imagenes/submenu/anular.png" alt="[Actualizar a Anulado]" title="Actualizar a Anulado" /> Anulado</a></div> 



<?php
}
?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO  DE ABONOS</span></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $PagosTotalSeleccionado;?></b> de <b><?php echo $PagosTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
   
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="65%" align="right">&nbsp;</td>
        <td width="35%" align="right">&nbsp;</td>
      </tr>
      </table>
    
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
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="AmoId" <?php if($POST_cam=="AmoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CprId" <?php if($POST_cam=="CprId"){ echo 'selected="selected"';}?>>Cot. de Repuesto</option>
      </select>-->
      
      
      Area:
	<select class="EstFormularioCombo" name="Area" id="Area">
    <option value="">Todos</option>
   
    <?php
			  foreach($ArrAreas as $DatArea){
			  ?>
    <option value="<?php echo $DatArea->AreId?>" <?php if($POST_Area==$DatArea->AreId){ echo 'selected="selected"';}?> ><?php echo $DatArea->AreNombre?></option>
    <?php
			  }
			  ?>
  </select>
  
  Origen
    <select class="EstFormularioCombo" name="Origen" id="Origen">
      <option value="" >Todos</option>
      <option value="REPUESTOS" <?php if($POST_Origen=="REPUESTOS"){ echo 'selected="selected"';}?>>Repuestos</option>
      <option value="VEHICULOS" <?php if($POST_Origen=="VEHICULOS"){ echo 'selected="selected"';}?>>Vehiculos</option> 

      </select>
      
      
  <!--  Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>Orden de Cobro</option>
      <option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Abono</option> 
      <option value="6" <?php if($POST_Estado==6){ echo 'selected="selected"';}?>>Anulado</option>  
      </select>-->
      
      
         Moneda:   
              <select class="EstFormularioCombo" name="Moneda" id="Moneda" >
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                  </select> 
                  
                  
                  
                  
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php echo $POST_finicio;?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    Sucursal:
       
       <select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
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
                <th width="1%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" ><?php
				if($POST_ord == "PagId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagId','ASC');"> Id. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PagFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagFecha','ASC');"> Fecha P <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagFecha','ASC');"> Fecha</a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Ord. Venta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "OvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvId','DESC');"> Ord. Venta Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "FacId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FacId','ASC');"> Factura <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FacId','DESC');"> Factura <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FacId','ASC');"> Factura </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "BolId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('BolId','DESC');"> Boleta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('BolId','ASC');"> Boleta </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> O.T. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');">  O.T.  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> O.T. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PagComprobante"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagComprobante','ASC');"> Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagComprobante','DESC');"> Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagComprobante','ASC');"> Ref. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "FpaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');"> F. Pago <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FpaNombre','DESC');"> F. Pago <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FpaNombre','ASC');"> F. Pago</a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PagNumeroRecibo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','ASC');"> Num. Recibo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','DESC');"> Num. Recibo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagNumeroRecibo','ASC');"> Num. Recibo </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "PagNumeroTranssaccion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','ASC');"> Num. Transac. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','DESC');"> Num. Transac <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagNumeroTranssaccion','ASC');"> Num. Transac </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
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
                <th width="10%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "MonNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonNombre','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda </a>
                  <?php
				}
				?>

                </th>
                <th width="3%" >
				
				
				<?php
				if($POST_ord == "PagTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagTipoCambio','ASC');"> T.C. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PagMonto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagMonto','ASC');"> Monto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagMonto','DESC');"> Monto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PagMonto','ASC');"> Monto </a>
                  <?php
				}
				?></th>
                <th width="2%" >Apl.</th>
                <th width="3%" >Tipo</th>
                <th width="3%" >Doc. Scan.</th>
                <th width="6%" ><?php
				if($POST_ord == "PagEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagEstado','ASC');"> Estado </a>
                <?php
				}
				?></th>
                <th width="8%" > <?php
				if($POST_ord == "PagTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PagTiempoCreacion','ASC');"> Fecha Registro <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PagTiempoCreacion','DESC');"> Fecha Registro <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PagTiempoCreacion','ASC');"> Fecha Registro </a>
                  <?php
				}
				?></th>
                <th width="10%" >Acciones</th>
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

				  <option <?php if($POST_num==$PagosTotal){ echo 'selected="selected"';}?> value="<?php echo $PagosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $PagosTotal;
					//}else{
					//	$tregistros = ($PagosTotalSeleccionado);
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

				foreach($ArrPagos as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PagId; ?>" />				</td>
                <td width="2%" align="right" valign="middle"   >
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PagId;?>">
                  <?php echo $dat->PagId;  ?>
                  </a>
                </td>
                <td width="4%" align="right" valign="middle"   ><?php echo $dat->PagFecha;  ?></td>
                <td width="4%" align="right" valign="middle"   >


<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');" >
<?php echo $dat->VdiId;  ?>
</a>

</td>
                <td  width="4%" align="right" >
	<a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $dat->OvvId?>');" >
<?php echo $dat->OvvId;  ?>
</a>			
				
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->FtaNumero;?> - <?php echo $dat->FacId;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->BtaNumero;?> - <?php echo $dat->BolId;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->FinId;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->PagComprobante;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->FpaNombre;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->PagNumeroRecibo;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->PagNumeroTransaccion;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="10%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->PagTipoCambio);?></td>
                <td  width="4%" align="right" >
				
				
				
				 <?php $dat->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PagMonto:($dat->PagMonto/$dat->PagTipoCambio));?>
                  
            
				<?php
				if($dat->PagEstado==6){
				?>-
                
                <?php	
				}else{
			?>
            <?php echo number_format($dat->PagMonto,2); ?>
            <?php		
				}
				?>
				
                
                
                </td>
                <td width="2%" align="right" valign="middle"   >
				
                <?php
                switch($dat->PagUtilizado){
					case "1":
				?>
                	<img src="imagenes/estado/utilizadosi.png"  title="Aplicado" alt="Aplicado" width="20"  height="20" />
                <?php	
					break;
					
					case "2":
				?>
                	<img src="imagenes/estado/utilizadono.png"  title="No Aplicados" alt="No Aplicados" width="20"  height="20" />
                <?php
					break;	
					
					default:
				?>
                -
                <?php	
					break;
				}
                ?>
				
                
                </td>
                <td width="3%" align="right" valign="middle"   ><?php
	switch($dat->PagTipo){
		case "VDI":
	?>
                  <img src="imagenes/acciones/repuestos.png" width="19" height="19" border="0" title="Repuestos" alt="[Repuestos]"   />
                  <?php	
		break;
		
		case "OVV":
	?>
                  <img src="imagenes/acciones/autos.png" width="19" height="19" border="0" title="Autos" alt="[Autos]"   />
                  <?php	
		break;
	}
?></td>
                <td  width="3%" align="right" ><?php            

//deb($dat->PagFoto1);

if(!empty($dat->PagFoto1)){
	
	$extension = strtolower(pathinfo($dat->PagFoto1, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->PagFoto1, '.'.$extension);  
?>
                
                  <a target="_blank" href="subidos/pago_fotos/<?php echo $dat->PagFoto1;?>"  title=""><img  src="imagenes/documento.gif" alt="" border="0"  /></a>
                  <?php	
}
?></td>
                <td  width="6%" align="right" >
                
                
        <?php 


				switch($dat->PagEstado){
					case 1:
				?>
                  <img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />
                  <?php	
				
				break;
										
					case 3:
				?>
                  
                  <img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
					case 6:
				?>
                  
                  <img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
				
					
				}
				?>             
                
                
                </td>
                <td  width="8%" align="right" ><?php echo ($dat->PagTiempoCreacion);?></td>

                <td  width="10%" align="center" >
         
         
         <?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->PagId;?>&Ta=&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>



         
                  
                  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PagId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
                  
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->PagId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
                  
                  
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PagId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>



<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncPagoVistaPreliminar('<?php echo $dat->PagId;?>','<?php echo (empty($dat->VdiId)?2:1);?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
     <a href="javascript:FncPagoImprmir('<?php echo $dat->PagId;?>','<?php echo (empty($dat->VdiId)?2:1);?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
     
			<?php
			}
			?>
            
            
                  
  <?php
if($PrivilegioVer){
?>
  <a href="javascript:FncPagoVentaDirectaCargarFormulario('VerHistorial','<?php echo $dat->PagId;?>','<?php echo $dat->VdiId;?>');"><img src="imagenes/acciones/historial.png" width="19" height="19" border="0" title="Ver Historial" alt="[Ver Historial]"   /></a>
  <?php
}
?>

                  
  <?php
if($PrivilegioRegistrar){
?>



<?php
	switch($dat->PagTipo){
		case "VDI":
	?>
  <a href="principal.php?Mod=PagoVentaDirecta&Form=AbonoRegistrar&VdiId=<?php echo $dat->VdiId;?>&Area=<?php echo $POST_Area;?>"><img src="imagenes/acciones/orden_cobro.png" width="19" height="19" border="0" title="Registrar" alt="[Registrar]"   /></a>
    <?php	
		break;
		
		case "OVV":
	?>
    <a href="principal.php?Mod=PagoVentaDirecta&Form=AbonoRegistrar&OvvId=<?php echo $dat->OvvId;?>&Area=<?php echo $POST_Area;?>"><img src="imagenes/acciones/orden_cobro.png" width="19" height="19" border="0" title="Registrar" alt="[Registrar]"   /></a>
    <?php	
		break;
	}
?>
  
  <?php
}
?>
           
            
                </td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
            </tbody>
      </table>

</td>
</tr>
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

