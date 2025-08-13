<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEditarId = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarId"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>

<?php $PrivilegioClienteEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Editar"))?true:false;?>
<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencion.js"></script>



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
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_tal = $_POST['Talonario'];
$POST_Moneda = $_POST['Moneda'];
$POST_npago = $_POST['CondicionPago'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CrnTiempoCreacion';
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

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjComprobanteRetencion.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();
$InsMoneda = new ClsMoneda();

$InsComprobanteRetencion->SucId = $_SESSION['SisSucId'];
$InsComprobanteRetencion->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteRetencion.php');


//MtdObtenerComprobanteRetenciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CrnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oCliente=NULL) {
$ResComprobanteRetencion = $InsComprobanteRetencion->MtdObtenerComprobanteRetenciones("crt.Crtnumero,crn.CrnId,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,$POST_Moneda,NULL);
$ArrComprobanteRetenciones = $ResComprobanteRetencion['Datos'];
$ComprobanteRetencionesTotal = $ResComprobanteRetencion['Total'];
$ComprobanteRetencionesTotalSeleccionado = $ResComprobanteRetencion['TotalSeleccionado'];

$ResComprobanteRetencionTalonario = $InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonarios(NULL,NULL,"CrtNumero","DESC",NULL,$_SESSION['SisSucId']);
$ArrComprobanteRetencionTalonarios = $ResComprobanteRetencionTalonario['Datos'];

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
if($PrivilegioImprimir){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
    <img src="imagenes/submenu/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div> 
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoEntregadoSeleccionados();">
    
    <img src="imagenes/submenu/entregado.png" alt="[Act. Entregado]" title="Actualizar a estado ENTREGADO seleccionados" />Entregado</a></div>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoReservadoSeleccionados();">
    <img src="imagenes/iconos/reservado.png" alt="[Act. Reservado]" title="Actualizar a estado RESERVADO seleccionados" />Reservado</a></div>
<?php
}
?>

<?php
if($PrivilegioEliminar){
?>
	<div class="EstSubMenuBoton">
<a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/submenu/eliminar.png" alt="[Eliminar]" title="Eliminar elementos seleccionados" />Eliminar</a>
</div> <?php
}
?>



<?php
/*if($PrivilegioEditar){
?>       
<div class="EstSubMenuBoton"><a href="javascript:FncGenerarResumenBajaXmlSeleccionados();"><img src="imagenes/submenu/sunat_baja.png" alt="[Resumen Baja]" title="Resumen Baja"  />Baja</a></div>
<?php
	}*/
	?>
        

</div>

<div class="EstCapContenido">



<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE COMPROBANTE DE RETENCIONES</span>  </td>
</tr>
<tr>
  <td width="46%">
    Mostrando <b><?php echo $ComprobanteRetencionesTotalSeleccionado;?></b> de <b><?php echo $ComprobanteRetencionesTotal;?></b> registros.</td>
  <td width="54%" align="right">
  
  
    <!--<table border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td align="right">SubTotal <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></td>
        <td align="right"><div id="CapListadoSubTotal" ></div></td>
        <td align="right">| Impuesto <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></td>
        <td align="right"><div id="CapListadoImpuesto" ></div></td>
        <td align="right">| Total <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> </td>
        <td align="right"><div id="CapListadoTotal" > </div></td>
      </tr>
      </table>-->
      
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="21%" align="right" class="EstTablaTotalesEtiqueta">SUB TOTAL: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="17%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoSubTotal" ></div></td>
        <td width="20%" align="right" class="EstTablaTotalesEtiqueta">IMPUESTO: <span class="EstMonedaSimbolo">
		<?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="15%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoImpuesto" ></div></td>
        <td width="14%" align="right" class="EstTablaTotalesEtiqueta">TOTAL: <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span></td>
        <td width="13%" align="right" class="EstTablaTotalesContenido"><div id="CapListadoTotal" ></div></td>
      </tr>
      </table>
      
      </td>
  </tr>
<tr>
<td colspan="2" align="left">

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


	<!--<select class="EstFormularioCombo" name="Cam" id="Cam">
	<option value="CrnId" <?php if($POST_cam=="CrnId"){ echo 'selected="selected"';}?>>Id</option>
	<option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
	<option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>><span title="Numero de Documento">Num. Doc.</span> de Cliente</option>
    <option value="CrnOrdenNumero" <?php if($POST_cam=="CrnOrdenNumero"){ echo 'selected="selected"';}?>>Num. Orden</option>
    <option value="CrnSIAFNumero" <?php if($POST_cam=="CrnSIAFNumero"){ echo 'selected="selected"';}?>>Num. SIAF</option>
    <option value="CrnTotal" <?php if($POST_cam=="CrnTotal"){ echo 'selected="selected"';}?>>Total</option>
     </select>-->
     
     
     Fecha Inicio:
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin:
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />



<!--<br />-->
     Talonario:
     <select  class="EstFormularioCombo" name="Talonario" id="Talonario">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrComprobanteRetencionTalonarios as $DatComprobanteRetencionTalonario){
			  ?>
                  <option <?php if($POST_tal==$DatComprobanteRetencionTalonario->CrtId){ echo 'selected="selected"';}?> 			  value="<?php echo $DatComprobanteRetencionTalonario->CrtId;?>" ><?php echo $DatComprobanteRetencionTalonario->CrtNumero;?></option>
                  <?php
			  }
			  ?>
          </select>
		Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
		<option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      	<option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
		<option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
		<option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>
		<option value="7" <?php if($POST_estado==7){ echo 'selected="selected"';}?>>Reservado</option>       
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
        <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">





<!--<div id="CapListado" >-->

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="1%" ><?php
				if($POST_ord == "CrtNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrtNumero','ASC');"> Serie <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtNumero','DESC');"> Serie <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CrtNumero','ASC');"> Serie </a>
                <?php
				}
				?></th>

                <th width="2%" ><?php
				if($POST_ord == "CrnId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CrnId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> </a>
                <?php
				}
				?></th>
                <th width="11%" ><?php
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
                <th width="4%" ><?php
				if($POST_ord == "CrnFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnFechaEmision','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnFechaEmision','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrnFechaEmision','ASC');"> Fecha   </a>
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
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "CrnTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrnTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span></a>
                  <?php
				}
				?></th>
                <th width="2%" ><?php
				if($POST_ord == "CrnEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrnEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th width="3%" >Canc.</th>
                <th width="3%" ><?php
				if($POST_ord == "CrnTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrnTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th colspan="2" >SUNAT</th>
                <th width="1%" ><?php
				if($POST_ord == "CrnTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrnTotalItems','ASC');"> <span title="Items">It.</span> </a>
                <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "CrnTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrnTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrnTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CrnTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> </a>
                <?php
				}
				?></th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="17" align="center">

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

				  <option <?php if($POST_num==$ComprobanteRetencionesTotal){ echo 'selected="selected"';}?> value="<?php echo $ComprobanteRetencionesTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ComprobanteRetencionesTotal;
					//}else{
					//	$tregistros = ($ComprobanteRetencionesTotalSeleccionado);
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


							$SumaSubTotal = 0;;
							$SumaImpuesto = 0;
							$SumaTotal = 0;


								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrComprobanteRetenciones as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->CrnId."%".$dat->CrtId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CrnId."%".$dat->CrtId; ?>" cliente = "<?php echo $dat->CliId;?>" estado="<?php echo $dat->CrnEstado; ?>" nota_credito="<?php echo $dat->CrnNotaCredito;?>" />				</td>
                <td align="right" valign="middle"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>">
				<?php echo $dat->CrtNumero;;  ?>
                </a>
                
                </td>

                <td align="right" valign="middle"   >
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>">
				<?php echo $dat->CrnId;  ?>
                </a>
                </td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" >
				
                      
                     
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
                   
                
        
        
                
                </td>
                <td align="right" ><?php echo ($dat->CrnFechaEmision);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->CrnTipoCambio);?></td>
                <td align="right" >
                  
                  <?php echo $dat->CrnEstadoIcono; ?>
                  <?php echo $dat->CrnEstadoDescripcion; ?>
                  
                  <?php 


				/*switch($dat->CrnEstado){
					case 1:
				?>
                  <img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />
                  <?php	
				
				break;
										
					case 5:
				?>
                  
                  <img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
					case 6:
				?>
                  
                  <img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					
					case 7:
				?>
                  
                  <img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />                
                <?php	
					break;
					
					
				}*/
				?>                </td>
                <td align="right" > 
                  
                  
                  
                  
                  <?php
				if($dat->CrnCancelado==1){
				?>
                  Si
                  <!--<a href="javascript:FncClientePagoCargarFormulario('Listado','<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>');" ><img src="imagenes/acciones/enlace.gif" align="Enlace" title="Enlace" border="0" width="18" height="18" />Si  </a>              
                -->  <?php
				}elseif($dat->CrnCancelado==2){
				?>
                  No
                <?php	
				}
				?>                </td>
                <td align="right" > 
                  <?php //echo ($dat->MonSimbolo);?>
                  <?php $dat->CrnTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CrnTotal:($dat->CrnTotal/$dat->CrnTipoCambio));?>
                  
                <?php echo number_format($dat->CrnTotal,2); ?></td>
                <td width="2%" align="right" >
                  <a href="javascript:FncComprobanteRetencionSunatHistorialCargar('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>');" >          
                    
                    
                  <?php
switch($dat->CrnSunatUltimaAccion){
	case "ALTA":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_alta.png" alt="Solicitud de alta" title="Solicitud de alta" border="0" />
                  <?php	
	break;	
	
	case "BAJA":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_baja.png" alt="Solicitud de baja" title="Solicitud de baja" border="0" />
                  <?php
	break;
	
	default:
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin solicitud" title="Sin solicitud" border="0" />
                  <?php
	break;
}
?>
  </a>
                  
                  
</td>
                <td width="2%" align="right" ><?php
switch($dat->CrnSunatUltimaRespuesta){
	case "APROBADO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_aprobado.png" alt="Aprobado" title="Aprobado" border="0" />
                  <?php	
	break;	
	
	case "RECHAZO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_rechazado.png" alt="Rechazado" title="Rechazado" border="0" />
                  <?php
	break;
	
	case "EXCEPCION":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_excepcion.png" alt="Excepcion" title="Excepcion" border="0" />
                  <?php
	break;
	
	case "OBSERVADO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_observado.png" alt="Observado" title="Observado" border="0" />
                  <?php
	break;
	
	default:
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin respuesta" title="Sin respuesta" border="0" />
                  <?php
	break;
}
?></td>
                <td align="right" ><?php echo ($dat->CrnTotalItems);?></td>
                <td align="right" ><?php echo ($dat->CrnTiempoCreacion);?></td>
                <td align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
if($PrivilegioEliminar & $dat->CrnCierre==1 ){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CrnId."%".$dat->CrtId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>



<?php
if($PrivilegioEditar & $dat->CrnCierre==1 ){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>
<?php
if($PrivilegioEditarId & $dat->CrnCierre==1 ){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
<?php
}
?>
<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CrnId;?>&Ta=<?php echo $dat->CrtId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>

<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncComprobanteRetencionVistaPreliminar('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
     <a href="javascript:FncComprobanteRetencionImprmir('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
     
			<?php
			}
			?>
    

            
<?php
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncComprobanteRetencionGenerarPDF('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>');"><img src="imagenes/acciones/pdf.png" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  

<?php
/*if($PrivilegioVer ){
?>

<a href="javascript:FncComprobanteRetencionSunatTareas('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>','<?php echo $dat->CrnSunatRespuestaTicket;?>');"><img src="imagenes/acciones/sunat_tareas.png" alt="[Tareas SUNAT]" title="Tareas SUNAT" width="19" height="19" border="0" /></a>

<?php
}*/
?>  

<?php

if($PrivilegioVer ){
?>

<a href="javascript:FncComprobanteRetencionSunatTareasv2('<?php echo $dat->CrnId;?>','<?php echo $dat->CrtId;?>','<?php echo $dat->CrnSunatRespuestaTicket;?>','<?php echo $dat->CrnSunatRespuestaEnvioCodigo;?>','<?php echo $dat->CrnSunatUltimaRespuesta;?>','<?php echo $dat->CrnSunatRespuestaBajaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>

<?php
}
?>  


            </td>
              </tr>

              <?php		$f++;

							$SumaSubTotal += $dat->CrnSubTotal;
							$SumaImpuesto += $dat->CrnImpuesto;
							$SumaTotal += $dat->CrnTotal;
							
									}

									?>
            </tbody>
      </table>
      
<!--</div>--></td>
</tr>
</table>
<input type="hidden" name="CmpListadoSubTotal" id="CmpListadoSubTotal" value="<?php echo number_format($SumaSubTotal,2);?>" />
<input type="hidden" name="CmpListadoImpuesto" id="CmpListadoImpuesto" value="<?php echo number_format($SumaImpuesto,2);?>" />
<input type="hidden" name="CmpListadoTotal" id="CmpListadoTotal" value="<?php echo number_format($SumaTotal,2);?>" />
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
