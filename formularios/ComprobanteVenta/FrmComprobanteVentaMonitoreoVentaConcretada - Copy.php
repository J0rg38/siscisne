<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Listado") or $InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Listado")){
?>

<?php $PrivilegioGenerarFactura = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Registrar"))?true:false;?>
<?php $PrivilegioGenerarBoleta = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Registrar"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>
<?php $PrivilegioGenerarFacturaExportacion = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FacturaExportacion","Registrar"))?true:false;?>


<?php $PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioVentaConcretadaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioCotizacionProductoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>

<?php $PrivilegioPagoListado = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>


<?php //$PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarExcel = true;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteVentaMonitoreoVentaConcretada.js" ></script>

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
$POST_Facturable = ($_POST['Facturable']);
$POST_Estado = ($_POST['Estado']);
$POST_Moneda = $_POST['Moneda'];	
$POST_Sucursal = $_POST['CmpSucursal'];


if($_POST){
	$_SESSION[$GET_mod."Facturable"] = $POST_Facturable;
}else{
	$POST_Facturable =  $_SESSION[$GET_mod."Facturable"];	
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'AmoTiempoCreacion';
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
	$POST_finicio = "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}


if(empty($POST_Estado)){
	$POST_Estado = 3;
}
if(empty($POST_Moneda)){
	$POST_Moneda = $EmpresaMonedaId;
}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteVentaMonitoreoVentaConcretada.php');


//MtdObtenerVentaConcretadaxFacturar($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL,$oSucursal=NULL)

$ResComprobanteVenta = $InsComprobanteVenta->MtdObtenerVentaConcretadaxFacturar("AmoId,vdi.CprId,amo.VdiId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,VdiOrdenCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Estado,0,0,0,NULL,$POST_Moneda,false,true,$POST_Facturable,$POST_Sucursal);

$ArrComprobanteVentas = $ResComprobanteVenta['Datos'];
$ComprobanteVentaTotal = $ResComprobanteVenta['Total'];
$ComprobanteVentaTotalSeleccionado = $ResComprobanteVenta['TotalSeleccionado'];




$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">


<div class="EstSubMenuBoton">
<a href="javascript:FncVentaConcretadaActualizarNoFacturableSeleccionados();"><img src="imagenes/acciones/nofacturable.png" alt="[Marcar como NO FACTURABLES]" title="Marcar como NO FACTURABLES seleccionados" />No Facturable</a>
</div> 

<div class="EstSubMenuBoton">
<a href="javascript:FncVentaConcretadaActualizarNoFacturableSeleccionados();"><img src="imagenes/acciones/facturable.png" alt="[Marcar como  FACTURABLES]" title="Marcar como  FACTURABLES seleccionados" /> Facturable</a>
</div> 





<div class="EstSubMenuBoton"><a href="javascript:FncVentaConcretadaGenerarFacturaSeleccionados();"><img src="imagenes/iconos/factura.png" alt="[Generar Factura]"  title="Generar Factura con elementos seleccionados" />Factura</a></div>


<div class="EstSubMenuBoton"><a href="javascript:FncVentaConcretadaGenerarBoletaSeleccionados();"><img src="imagenes/iconos/boleta.png" alt="[Generar Boleta]"  title="Generar Boleta con elementos seleccionados" />Boleta</a></div>

<?php
  if($PrivilegioGenerarExcel){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncComprobanteVentaMonitoreoFichaIngresoGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 

<?php	  
  }
  ?>
  


</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE ORDENES DE VENTA DE REPUESTO CONCRETADAS</span>  
    <input type="hidden" name="CmpComprobanteVentaTipo" id="CmpComprobanteVentaTipo" value="MonitoreoVentaConcretada" />
    
  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $ComprobanteVentaTotalSeleccionado;?></b> de <b><?php echo $ComprobanteVentaTotal;?></b> registros.</td>
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
    
    
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>


Filtrar Facturable:
      
      <select class="EstFormularioCombo" name="Facturable" id="Facturable">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_Facturable=="1"){ echo 'selected="selected"';}?>>Facturables</option>
      <option value="2" <?php if($POST_Facturable=="2"){ echo 'selected="selected"';}?>>No Facturables</option>  
      </select>
      
      Moneda:
	<select class="EstFormularioCombo" name="Moneda" id="Moneda">
              <option value="">Todos</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonAbreviacion?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select>
      
      
      
      <!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="AmoId" <?php if($POST_cam=="AmoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CprId" <?php if($POST_cam=="CprId"){ echo 'selected="selected"';}?>>Cot. de Repuesto</option>
      </select>-->
    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>No Realizado</option>
      <option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio;?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php  echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />Sucursal:
       
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
                <th width="2%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="4%" >
                  
                  <?php
				if($POST_ord == "AmoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Ficha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoId','DESC');"> Ficha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Ficha </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "AmoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fecha  </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CprId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Cot. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprId','DESC');"> Cot. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Cot. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Ven. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Ord. Ven. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Ven. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiFecha','ASC');"> Ord. Ven. Fec. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiFecha','DESC');"> Ord. Ven. Fec. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiFecha','ASC');"> Ord. Ven. Fec. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiOrdenCompraNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> O.C. Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','DESC');"> O.C. Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> O.C. Ref. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VdiOrdenCompraFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraFecha','ASC');"> O.C. Ref. Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraFecha','DESC');"> O.C. Ref. Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraFecha','ASC');"> O.C. Ref. Fecha </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "LtiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('LtiNombre','ASC');"> Tipo Cliente<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('LtiNombre','DESC');"> Tipo Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('LtiNombre','ASC');"> Tipo Cliente </a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Documento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Documento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Documento </a>
                  <?php
				}
				?></th>
                <th width="14%" ><?php
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
                <th width="7%" ><?php
				if($POST_ord == "AmoTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoTotal','ASC');"> Total  </a>
                <?php
				}
				?></th>
                <th width="10%" >Abonos</th>
                <th width="2%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Cotizador <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Cotizador <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Cotizador </a>
                  <?php
				}
				?></th>
                <th width="2%" ><?php
				if($POST_ord == "AmoTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoTotalItems','ASC');"> <span title="Items">It.</span></a>
                <?php
				}
				?></th>
                <th width="8%" >
                  <?php
				if($POST_ord == "AmoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                  Fecha  Registro
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','DESC');">
                    
                 Fecha  Registro
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                  Fecha  Registro
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="8%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="18" align="center">

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

				  <option <?php if($POST_num==$ComprobanteVentaTotal){ echo 'selected="selected"';}?> value="<?php echo $ComprobanteVentaTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ComprobanteVentaTotal;
					//}else{
					//	$tregistros = ($ComprobanteVentaTotalSeleccionado);
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

				foreach($ArrComprobanteVentas as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VcoId; ?>" cliente="<?php echo $dat->CliId; ?>" />				</td>

                <td align="right" valign="middle" width="4%"   >
				

<?php
if($PrivilegioVentaConcretadaVer){
?>
<!--<a href="javascript:FncVentaConcretadaCargarFormulario('Ver','<?php echo $dat->VcoId;  ?>');"  ><?php echo $dat->VcoId;  ?></a>-->


<a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $dat->VcoId;  ?>');"  ><?php echo $dat->VcoId;  ?></a>



<?php	
}else{
?>
<?php echo $dat->VcoId;  ?>
<?php	
}
?>
</td>
                <td  width="5%" align="right" ><?php echo ($dat->VcoFecha);?></td>
                <td  width="3%" align="right" >
				
<?php
if($PrivilegioCotizacionProductoVer){
?>
<a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo ($dat->CprId);?>');"  ><?php echo ($dat->CprId);?></a>
<?php	
}else{
?>
<?php echo ($dat->CprId);?>
<?php	
}
?>



</td>
                <td  width="4%" align="right" >

<?php
/*if($PrivilegioVentaDirectaVer){
?>
<a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>
<?php	
}else{
?>
<?php echo ($dat->VdiId);?>
<?php	
}*/
?>
<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>





</td>
                <td  width="4%" align="right" >
                
                
                
                <?php echo ($dat->VdiFecha);?>
                </td>
                <td  width="4%" align="right" >


<?php            
if(!empty($dat->VdiArchivo)){
	
	$extension = strtolower(pathinfo($dat->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->VdiArchivo, '.'.$extension);  
?>
                 
                  
<a href="subidos/venta_directa/<?php echo $dat->VdiArchivo;?>" target="_blank" title="">
				<?php echo ($dat->VdiOrdenCompraNumero);?>
</a>
              
                  
<?php	
}else{
?>
	<?php echo ($dat->VdiOrdenCompraNumero);?>
<?php	
}
?>



                
                </td>
                <td  width="5%" align="right" >
                <?php echo ($dat->VdiOrdenCompraFecha);?>
                
                
                </td>
                <td  width="5%" align="right" ><?php echo ($dat->LtiNombre);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="14%" align="right" >
                  
                  <?php echo ($dat->CliNombre);?>
                  <?php echo ($dat->CliApellidoPaterno);?>
                  <?php echo ($dat->CliApellidoMaterno);?>
                  
                </td>
                <td  width="7%" align="right" >
                  
                  
                  <?php echo number_format($dat->VcoTotal,2);?>
                  
                </td>
                <td  width="10%" align="right" ><?php
if($PrivilegioPagoListado){
?>
                  <a href="javascript:FncPagoVentaDirectaCargarFormulario('Listado','<?php echo $dat->VdiId;?>');" >Ord. Cobro / Abonos</a>


<?php
}
?></td>
                <td  width="2%" align="right" ><?php echo $dat->PerNombre;  ?>
                  <?php //echo $dat->PerApellidoPaterno;  ?>
                  <?php //echo $dat->PerApellidoMaterno;  ?></td>
                <td  width="2%" align="right" ><?php echo ($dat->VcoTotalItems);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->VcoTiempoModificacion);?></td>
        <td  width="8%" align="center" >
		
	<?php
    if($PrivilegioGenerarFactura){
    ?>
    
<a href="principal.php?Mod=Factura&Form=Registrar&Ori=VentaConcretada&VcoId=<?php echo $dat->VcoId;?>"><img src="imagenes/generar_factura.png" width="19" height="19" border="0" title="Generar Factura" alt="[Generar Factura]"   /></a>
       
<!--        <a href="javascript:FncVentaConcretadaGenerarFactura('<?php echo $dat->VcoId;?>')"><img src="imagenes/generar_factura.png" width="19" height="19" border="0" title="Generar Factura" alt="[Generar Factura]"   /></a>-->
        
<!--        <a href="javascript:FncVentaConcretadaGenerarFacturaSeleccionado('<?php echo $dat->VcoId;?>')"><img src="imagenes/generar_factura.png" width="19" height="19" border="0" title="Generar Factura" alt="[Generar Factura]"   /></a>-->
        
        
        
    <?php
    }
    ?>
    
    <?php
    if($PrivilegioGenerarBoleta){
    ?>
        <a href="principal.php?Mod=Boleta&Form=Registrar&Ori=VentaConcretada&VcoId=<?php echo $dat->VcoId;?>"><img src="imagenes/generar_boleta.png" width="19" height="19" border="0" title="Generar Boleta" alt="[Generar Boleta]"   /></a>
    <?php
    }
    ?>
    
        <?php
    if($PrivilegioGenerarFacturaExportacion){
    ?>
        <a href="principal.php?Mod=FacturaExportacion&Form=Registrar&Ori=VentaConcretada&VcoId=<?php echo $dat->VcoId;?>"><img src="imagenes/acciones/factura_exportacion.png" width="19" height="19" border="0" title="Generar Factura de Exportacion" alt="[Generar Factura de Exportacion]"   /></a>
    <?php
    }
    ?>
    
    
     <?php
    if($PrivilegioGenerarGuiaRemision and $dat->VcoGuiaRemision=="No"){
    ?>
        <a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=VentaConcretada&VcoId=<?php echo $dat->VcoId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]"   /></a>
    <?php
    }
    ?>
    
    
    
    
    <?php //echo $dat->VcoGenerarComprobante;?>
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

