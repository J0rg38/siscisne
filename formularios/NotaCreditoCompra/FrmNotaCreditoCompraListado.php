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


<?php $PrivilegioAlmacenMovimientoEntradaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"AlmacenMovimientoEntrada","Ver"))?true:false;?>

<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsNotaCreditoCompra.js"></script>
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
	$POST_ord = 'NccTiempoModificacion';
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

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaCreditoCompra.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();
$InsMoneda = new ClsMoneda();

$InsNotaCreditoCompra->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaCreditoCompra.php');


//MtdObtenerNotaCreditoCompras($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oProveedor=NULL)
$ResNotaCreditoCompra = $InsNotaCreditoCompra->MtdObtenerNotaCreditoCompras("NccId,PrvNombreCompleto,PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno,PrvNumeroDocumento,NccComprobanteNumero,AmoId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Moneda,NULL,NULL);
$ArrNotaCreditoCompras = $ResNotaCreditoCompra['Datos'];
$NotaCreditoComprasTotal = $ResNotaCreditoCompra['Total'];
$NotaCreditoComprasTotalSeleccionado = $ResNotaCreditoCompra['TotalSeleccionado'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

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
if($PrivilegioEditar){
?>
    
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
/*if($PrivilegioGenerarGuiaRemision){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemisionSeleccionados();"><img src="imagenes/iconos/guiaremision.png" alt="[Generar Guia de Remision]"  title="Generar guia de remision con elementos seleccionados" />G. Rem.</a></div>
<?php
}
?>
<?php
if($PrivilegioRegistrarNotaCredito){
?>	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarNotaCreditoSeleccionados();"><img src="imagenes/submenu/ncredito.png" alt="[Generar N. Credito]" title="Generar Nota de Credito con elementos"  />N. Credito</a></div>
    
<?php	
}*/
?>

</div>

<div class="EstCapContenido">



<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE NOTAS DE CREDITO DE COMPRAS</span>  </td>
</tr>
<tr>
  <td width="46%">
    Mostrando <b><?php echo $NotaCreditoComprasTotalSeleccionado;?></b> de <b><?php echo $NotaCreditoComprasTotal;?></b> registros.</td>
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



		Estado
		<select class="EstFormularioCombo" name="Estado" id="Estado">
		<option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
		<option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
		<option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>
   
		</select>
                  Moneda
                  
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
		Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
       

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>

<tr>
<td colspan="2">





<!--<div id="CapListado" >-->

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >
                  
                <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" ><?php
				if($POST_ord == "NccId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('NccId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "PrviNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccNumeroComprobante','ASC');"> <span title="Numero de Documento">Num. N. Cred.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccNumeroComprobante','DESC');"> <span title="Numero de Documento">Num. N. Cred.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccNumeroComprobante','ASC');"> <span title="Numero de Documento">Num. N. Cred.</span></a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "NccFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccFechaEmision','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccFechaEmision','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccFechaEmision','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PrviNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrviNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrviNumeroDocumento','DESC');"> <span title="Numero de Documento">Num. Doc.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PrviNumeroDocumento','ASC');"> <span title="Numero de Documento">Num. Doc.</span> </a>
                <?php
				}
				?></th>
                <th width="16%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Proveedor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
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
				if($POST_ord == "NccTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccTipoCambio','DESC');"> <span title="Tipo de Cambio">T.C.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccTipoCambio','ASC');"> <span title="Tipo de Cambio">T.C.</span> </a>
                <?php
				}
				?></th>
                <th width="4%" > <?php
				if($POST_ord == "AmoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Mov. Alm. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoId','DESC');"> Mov. Alm. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Mov. Alm. </a>
                  <?php
				}
				?>
                </th>
                <th width="9%" ><?php
				if($POST_ord == "AmoComprobanteNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','ASC');"> Num. Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','DESC');"> Num. Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','ASC');"> Num. Comprob. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "NccSubTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccSubTotal','ASC');">Sub Total<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccSubTotal','ASC');">Sub Total</a><a href="javascript:FncOrdenar('NccTotal','DESC');"><img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccSubTotal','ASC');">Sub Total </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "NccImpuesto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccImpuesto','ASC');">Impuesto<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccImpuesto','ASC');">Impuesto</a><a href="javascript:FncOrdenar('NccTotal','DESC');"><img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccImpuesto','ASC');">Impuesto </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "NccTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "NccEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccEstado','ASC');"> <span title="Estado">Est.</span></a>
                  <?php
				}
				?></th>
                <th width="4%" >Doc. Scan.</th>
                <th width="2%" ><?php
				if($POST_ord == "NccTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NccTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NccTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NccTotalItems','ASC');"> <span title="Items">It.</span></a>
                  <?php
				}
				?></th>
                <th width="12%" >Acciones</th>
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

				  <option <?php if($POST_num==$NotaCreditoComprasTotal){ echo 'selected="selected"';}?> value="<?php echo $NotaCreditoComprasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $NotaCreditoComprasTotal;
					//}else{
					//	$tregistros = ($NotaCreditoComprasTotalSeleccionado);
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

								foreach($ArrNotaCreditoCompras as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->NccId."%".$dat->FtaId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->NccId."%".$dat->FtaId; ?>" cliente = "<?php echo $dat->PrvId;?>" estado="<?php echo $dat->NccEstado; ?>" nota_credito="<?php echo $dat->NccNotaCredito;?>" />				</td>
                <td align="right" valign="middle"   ><?php echo $dat->NccId;  ?></td>
                <td align="right" ><?php echo ($dat->NccComprobanteNumero);?></td>
                <td align="right" ><?php echo ($dat->NccFechaEmision);?></td>
                <td align="right" ><?php echo ($dat->PrvNumeroDocumento);?></td>
                <td align="right" >
                  
                  <?php echo $dat->PrvNombre;?> <?php echo $dat->PrvApellidoPaterno;?> <?php echo $dat->PrvApellidoMaterno;?>
                  
                </td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->NccTipoCambio);?></td>
                <td align="right" >
				
				<?php
				  if(!empty($dat->AmoIdOrigen)){
					  ?>
                  <?php
				 if($PrivilegioAlmacenMovimientoEntradaVer){
				?>
                
					<a href="javascript:FncAlmacenMovimientoEntradaVistaPreliminar('<?php echo $dat->AmoIdOrigen;?> ');"><?php echo $dat->AmoIdOrigen;?></a>

				<!--<a href="javascript:FncAlmacenMovimientoEntradaCargarFormulario('Ver','<?php echo $dat->AmoId;?> ');"> <?php echo $dat->AmoId;?></a>-->

                  <?php
				 }else{
				?>
                  <?php echo $dat->AmoIdOrigen;?>
                  <?php 
				 }
				 ?>
                  <?php
				  }else{
					?>
                  -
  <?php  
				  }
				  ?></td>
                <td align="right" >
				
				
				<?php echo ($dat->AmoComprobanteNumeroOrigen);?></td>
                <td align="right" ><?php $dat->NccSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->NccSubTotal:($dat->NccSubTotal/$dat->NccTipoCambio));?>
                <?php echo number_format($dat->NccImpuesto,2); ?></td>
                <td align="right" >  
                  
                  <?php $dat->NccImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->NccImpuesto:($dat->NccImpuesto/$dat->NccTipoCambio));?>
                  
                <?php echo number_format($dat->NccImpuesto,2); ?></td>
                <td align="right" > 
                  
                  <?php $dat->NccTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->NccTotal:($dat->NccTotal/$dat->NccTipoCambio));?>
                  
                <?php echo number_format($dat->NccTotal,2); ?></td>
                <td align="right" ><?php echo $dat->NccEstadoIcono; ?> <?php echo $dat->NccEstadoDescripcion; ?>
                  <?php 


				/*switch($dat->NccEstado){
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
				?></td>
                <td  width="4%" align="center" ><?php            
if(!empty($dat->NccFoto)){
	
	$extension = strtolower(pathinfo($dat->NccFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->NccFoto, '.'.$extension);  
?>
                 
                  <a target="_blank" href="subidos/nota_credito_compra_fotos/<?php echo $dat->NccFoto;?>"  title=""><img  src="imagenes/documento.gif" alt="" border="0"  /></a>
                  <?php	
}
?></td>
                <td align="right" ><?php echo ($dat->NccTotalItems);?></td>
                <td align="center" >
                  
                  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->NccId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  <?php
//if($PrivilegioEliminar & $dat->NccCierre==1 ){
	if($PrivilegioEliminar){
?> 
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->NccId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
                  <?php
}
?>
                  <?php
//if($PrivilegioEditar & $dat->NccCierre==1 ){
if($PrivilegioEditar ){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->NccId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
                  <?php
}
?>
                  <?php
//if($PrivilegioEditarId & $dat->NccCierre==1 ){
	if($PrivilegioEditarId){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->NccId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
                  <?php
}
?>
                  <?php
if($PrivilegioVer){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->NccId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  <?php
}
?>
                  
                  
                  
                  <?php
if($PrivilegioVistaPreliminar){
?>
                  <a href="javascript:FncNotaCreditoCompraVistaPreliminar('<?php echo $dat->NccId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  <?php
}
?>
                  
                  <?php
if($PrivilegioImprimir){
?>   
                  <a href="javascript:FncNotaCreditoCompraImprmir('<?php echo $dat->NccId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  <?php
}
?>
                  
                  
                  <?php
/*if($PrivilegioGenerarGuiaRemision and ($dat->NccEstado <> 6)){
?>
	<a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=OrdenVentaVehiculo&OvvId=<?php echo $dat->OvvId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]" /></a>
<?php
}*/
?>
                  
                </td>
              </tr>

              <?php		$f++;

							$SumaSubTotal += $dat->NccSubTotal;
							$SumaImpuesto += $dat->NccImpuesto;
							$SumaTotal += $dat->NccTotal;
							
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
