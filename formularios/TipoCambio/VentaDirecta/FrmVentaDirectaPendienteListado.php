<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"PendienteListado")){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioCotizacionProductoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarVentaConcretada = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Registrar"))?true:false;?>
<?php $PrivilegioGenerarPedidoCompra = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Registrar"))?true:false;?>

<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>


<?php //$PrivilegioGenerarBoleta = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Registrar"))?true:false;?>
<?php //$PrivilegioGenerarFactura = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Registrar"))?true:false;?>
<?php //$PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaDirecta.js" ></script>
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
$POST_fil = $_POST['Fil'];

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

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
$POST_Moneda = $_POST['Moneda'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VdiTiempoModificacion';
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



include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaDirecta.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsMoneda = new ClsMoneda();

$InsCotizacionProducto->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaDirecta.php');

//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL)
$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas("VdiId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,LtiNombre,vdi.CprId,VdiOrdenCompraNumero,VdiMarca,VdiModelo,VdiPlaca,VdiAnoModelo",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,0,NULL,NULL,$POST_Moneda);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];
$VentaDirectasTotal = $ResVentaDirecta['Total'];
$VentaDirectasTotalSeleccionado = $ResVentaDirecta['TotalSeleccionado'];

	
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

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
  
  
<?php
if($PrivilegioEditar){
?>
    
	<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/pendiente.gif" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" /> Anulado</a></div>
    
	<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoDesanuladoSeleccionados();">
    <img src="imagenes/realizado.gif" alt="[Act. Desanulado]" title="Actualizar a estado DESANULADO seleccionados" /> Realizado</a></div>

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
<div class="EstSubMenuBoton"><a href="javascript:FncEnviarCotizacionProductoContabilidadSeleccionados();"><img src="imagenes/iconos/enviar_contabilidad.png" alt="[Enviar Orden de Venta de Repuesto a Contabilidad]" title="Enviar Orden de Venta de Repuesto a Contabilidad" /> Contabilidad</a></div> 
<?php
}*/
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE ORDENES DE VENTA S/ PEDIDO</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $VentaDirectasTotalSeleccionado;?></b> de <b><?php echo $VentaDirectasTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
   
       <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="21%" align="right" class="EstTablaTotalesEtiqueta">SUB TOTAL: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="17%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoSubTotal" ></div></td>
        <td width="19%" align="right" class="EstTablaTotalesEtiqueta">IMPUESTO: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="16%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoImpuesto" ></div></td>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
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
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="VdiId" <?php if($POST_cam=="VdiId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Cliente</option>
       <option value="amo.CprId" <?php if($POST_cam=="amo.CprId"){ echo 'selected="selected"';}?>>Cot. Repuesto</option>
      </select>-->
      
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
  
  
  
    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="1%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="5%" >
                  
                  <?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Id.  </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiFecha','ASC');"> Fec. Emision <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiFecha','DESC');"> Fec. Emision <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VdiFecha','ASC');"> Fec. Emision  </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "LtiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('LtiNombre','ASC');"> Tipo Cli.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
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
                <th width="2%" ><?php
				if($POST_ord == "TdoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','DESC');"> Tipo Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. </a>
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
                <th width="19%" ><?php
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
                <th width="4%" ><?php
				if($POST_ord == "VdiMarca"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiMarca','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiMarca','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiMarca','ASC');"> Marca </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiModelo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiModelo','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiModelo','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiModelo','ASC');"> Modelo </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiPlaca"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiPlaca','ASC');"> Placa <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiPlaca','DESC');"> Placa <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiPlaca','ASC');"> Placa </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VdiAnoModelo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiAnoModelo','ASC');"> A&ntilde;o <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiAnoModelo','DESC');"> A&ntilde;o <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiAnoModelo','ASC');"> A&ntilde;o </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
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
                <th width="5%" ><?php
				if($POST_ord == "VdiPedidoCompra"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiPedidoCompra','ASC');"> Ped. Comp.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiPedidoCompra','DESC');"> Ped. Comp. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiPedidoCompra','ASC');"> Ped. Comp. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VdiOrdenCompraNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','DESC');"> Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> Ref. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VdiVentaConcretada"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiVentaConcretada','ASC');"> V. Concre. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiVentaConcretada','DESC');"> V. Concre. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiVentaConcretada','ASC');"> V. Concre. </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
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
                <th width="4%" ><?php
				if($POST_ord == "AmoTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoTipoCambio','ASC');"> T.C. </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VdiDescuento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiDescuento','ASC');"> Descuento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiDescuento','DESC');"> Descuento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiDescuento','ASC');"> Descuento </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VdiSubTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiSubTotal','ASC');"> SubTotal <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiSubTotal','DESC');"> SubTotal <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiSubTotal','ASC');"> SubTotal </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VdiImpuesto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiImpuesto','ASC');"> Impuesto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiImpuesto','DESC');"> Impuesto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiImpuesto','ASC');"> Impuesto </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "VdiTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiTotal','ASC');"> Total  </a>
                <?php
				}
				?></th>
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
				if($POST_ord == "VdiEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="2%" >&nbsp;</th>
                <th width="2%" ><?php
				if($POST_ord == "VdiTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiTotalItems','ASC');"> <span title="Items">It.</span></a>
                <?php
				}
				?></th>
                <th width="8%" >
                  <?php
				if($POST_ord == "VdiTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('VdiTiempoModificacion','ASC');">
                  U.A.
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiTiempoModificacion','DESC');">
                    
                  U.A.
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('VdiTiempoModificacion','ASC');">
                  U.A.
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="8%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="28" align="center">

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

				  <option <?php if($POST_num==$VentaDirectasTotal){ echo 'selected="selected"';}?> value="<?php echo $VentaDirectasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VentaDirectasTotal;
					//}else{
					//	$tregistros = ($VentaDirectasTotalSeleccionado);
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
								foreach($ArrVentaDirectas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="1%" align="center"  >



<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VdiId; ?>" cotizacion="<?php echo $dat->CprId;?>" estado="<?php echo $dat->VdiEstado;?>" factura="<?php echo $dat->VdiFactura;?><?php echo $dat->VdiBoleta;?>" />				



</td>

                <td align="right" valign="middle" width="5%"   >
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VdiId;?>">
				<?php echo $dat->VdiId;  ?></a></td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiFecha);?></td>
                <td  width="3%" align="right" ><?php echo (empty($dat->LtiAbreviatura)?$dat->LtiNombre:$dat->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?></td>
                <td  width="2%" align="right" ><?php echo ($dat->TdoNombre);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="19%" align="right" >


<?php
if($PrivilegioClienteVer){
?>
	<a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  ><?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?></a>
<?php	
}else{
?>
	<?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
<?php	
}
?>



				 
			    </td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiMarca);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiModelo);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiPlaca);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiAnoModelo);?></td>
                <td  width="4%" align="right" >
                  
                  <?php
if($PrivilegioCotizacionProductoVer){
?>
                  <a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>
                  <?php	
}else{
?>
                  <?php echo ($dat->CprId);?>
                  <?php	
}
?>
                  
                  
                  
                  
                  
                  
                </td>
                <td  width="5%" align="right" >
                  
                  
  <?php
if($dat->VdiPedidoCompra == "Si"){
?>
                  
  <!--<a href="formularios/VentaDirecta/DiaPedidoCompraListado.php?height=440&width=850&VdiId=<?php echo $dat->VdiId?>" class="thickbox" title=""><?php echo ($dat->VdiPedidoCompra); ?></a> -->
        <a href="formularios/VentaDirecta/DiaPedidoCompraListado.php?height=440&width=850&VdiId=<?php echo $dat->VdiId?>" class="thickbox" title="">Tiene Pedido</a>           
  <?php	
}else{
?>
	No Tiene Pedido
  <?php // echo $dat->VdiPedidoCompra;  ?>
  <?php	
}
?>
                  
                  
                  
                  
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->VdiOrdenCompraNumero;?></td>
                <td  width="5%" align="right" >
				

<?php
if($dat->VdiVentaConcretada == "Si"){
?>

<!--<a href="formularios/VentaDirecta/DiaVentaConcretadaListado.php?height=440&width=850&VdiId=<?php echo $dat->VdiId?>" class="thickbox" title=""><?php echo ($dat->VdiVentaConcretada); ?></a> -->

<a href="formularios/VentaDirecta/DiaVentaConcretadaListado.php?height=440&width=850&VdiId=<?php echo $dat->VdiId?>" class="thickbox" title="">Tiene  Concretada</a> 

<?php	
}else{
?>
No Tiene Concretada
<?php // echo $dat->VdiVentaConcretada;  ?>
<?php	
}
?>


                
                </td>
                <td  width="7%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VdiTipoCambio;  ?></td>
                <td  width="6%" align="right" >
				
                <?php $dat->VdiDescuento = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiDescuento:($dat->VdiDescuento/$dat->VdiTipoCambio));?>
                
				<?php echo number_format($dat->VdiDescuento,2);?>

                </td>
                <td  width="6%" align="right" >
				
                <?php $dat->VdiSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiSubTotal:($dat->VdiSubTotal/$dat->VdiTipoCambio));?>
				<?php echo number_format($dat->VdiSubTotal,2);?>
                
                <?php
					$SubTotal += $dat->VdiSubTotal ;
				?>
                
                </td>
                <td  width="6%" align="right" >
				
                <?php $dat->VdiImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiImpuesto:($dat->VdiImpuesto/$dat->VdiTipoCambio));?>
                
				<?php echo number_format($dat->VdiImpuesto,2);?>
                
                <?php
					$Impuesto += $dat->VdiImpuesto ;
			
				?></td>
                <td  width="7%" align="right" >
                  

				<?php $dat->VdiTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiTotal:($dat->VdiTotal/$dat->VdiTipoCambio));?>                  
                
                  <?php echo number_format($dat->VdiTotal,2);?>
                  <?php
					$Total += $dat->VdiTotal ;
			
				?>
                </td>
                <td  width="2%" align="right" ><?php echo $dat->PerNombre;  ?><?php echo $dat->PerApellidoPaterno;  ?><?php echo $dat->PerApellidoMaterno;  ?></td>
                <td  width="2%" align="right" >
					<?php echo $dat->VdiEstadoIcono;?>
                    <?php echo $dat->VdiEstadoDescripcion;?>
				<?php
				/*switch($dat->VdiEstado){
					
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
                <td  width="2%" align="right" >
                
              
                <?php            
if(!empty($dat->VdiArchivo)){
	
	$extension = strtolower(pathinfo($dat->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->VdiArchivo, '.'.$extension);  
?>
                 
                  
<a href="subidos/venta_directa/<?php echo $dat->VdiArchivo;?>" target="_blank" title=""><img border="0"  src="imagenes/documento.gif"  /></a>
              
                  
<?php	
}
?>


                </td>
                <td  width="2%" align="right" ><?php echo ($dat->VdiTotalItems);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->VdiTiempoModificacion);?></td>
        <td  width="8%" align="center" >


<?php
if($PrivilegioAuditoriaVer){
?>
<a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->VdiId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
//if($PrivilegioEliminar and $dat->VdiFactura =="No"){
if($PrivilegioEliminar and $dat->VdiPedidoCompra == "No" and $dat->VdiVentaConcretada == "No" and $dat->VdiEstado <> 1){
?>
	<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VdiId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
<?php
}
?>               
				
<?php
//if($PrivilegioEditar and $dat->VdiPedidoCompra == "No" and $dat->VdiVentaConcretada == "No" and $dat->VdiEstado <> 1 ){
if($PrivilegioEditar  ){
	
		
//if($PrivilegioEditar and $dat->VdiFactura =="No" ){
?>             
	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VdiId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VdiId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
<?php
}
?>


<?php
if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->VdiId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}
?>
        
<?php
if($PrivilegioImprimir){
?>        

	<a href="javascript:FncImprmir('<?php echo $dat->VdiId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
<?php
}
?>
 
 <?php
if($PrivilegioVer){
?>		
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=VerEstado&Id=<?php echo $dat->VdiId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[O.V. Estado]" title="O.V. Estado" width="19" height="19" border="0" /></a>   

<?php
}
?>

<?php
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncGenerarPDF('<?php echo $dat->VdiId;?>');"><img src="imagenes/pdf.gif" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  


<?php
//if($PrivilegioGenerarPedidoCompra and ($dat->VdiPedir == "Si" and $dat->VdiPedidoCompra == "No")){
//if($PrivilegioGenerarPedidoCompra and $dat->VdiPedir == "Si"){
	

if($PrivilegioGenerarPedidoCompra and $dat->VdiGenerarPedidoCompra == "Si" and $dat->VdiEstado <> 1){
?>		                
	<a href="principal.php?Mod=PedidoCompra&Form=Registrar&Origen=VentaDirecta&VdiId=<?php echo $dat->VdiId;?>"><img src="imagenes/generar_pedido.png" width="19" height="19" border="0" title="Generar Pedido de Compra" alt="[Generar Pedido de Compra]"   /></a>                
<?php
}
?>

<?php
//if($PrivilegioGenerarVentaConcretada and ($dat->VdiPedidoCompra == "Si" or $dat->VdiPedir == "No") and $dat->VdiVentaConcretada == "No"){
	
//if($PrivilegioGenerarVentaConcretada and $dat->VdiConcretar == "Si"){
//deb($dat->VdiGenerarVentaConcretada);

if($PrivilegioGenerarVentaConcretada and $dat->VdiGenerarVentaConcretada == "Si" and $dat->VdiEstado <> 1){
?>		                
	<a href="principal.php?Mod=VentaConcretada&Form=Registrar&Origen=VentaDirecta&VdiId=<?php echo $dat->VdiId;?>"><img src="imagenes/generar.jpg" width="19" height="19" border="0" title="Generar Venta Concretada" alt="[Generar Venta Concretada]"   /></a>                
<?php
}
?>
    
			</td>
              </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

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
<td align="left" valign="middle" class="">&nbsp;</td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">U.A.: </span></td>
<td align="left" valign="middle">Ultima Actualizacion:</td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">T.C.: </span></td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoContenido">Tipo de Cambio</span></td>
<td align="left" valign="middle">&nbsp;</td>
</tr>
</tbody>
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

