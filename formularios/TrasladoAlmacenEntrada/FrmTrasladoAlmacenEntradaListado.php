<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada",$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada","Imprimir"))?true:false;?>

<?php $PrivilegioProveedorVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Proveedor","Ver"))?true:false;?>
<?php $PrivilegioOrdenCompraVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCompra","Ver"))?true:false;?>
<?php $PrivilegioGenerarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCreditoCompra","Registrar"))?true:false;?>

<?php $PrivilegioGenerarReclamo = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Reclamo","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenEntrada.js" ></script>
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
$POST_origen = $_POST['Origen'];
$POST_TipoFecha = $_POST['TipoFecha'];
$POST_Moneda = $_POST['Moneda'];
$POST_Almacen = $_POST['CmpAlmacen'];

if(empty($POST_p)){$POST_p = '1';}
if(empty($POST_num)){$POST_num = '10';}
if(empty($POST_ord)){$POST_ord = 'AmoId';}
if(empty($POST_sen)){$POST_sen = 'DESC';}
if(empty($POST_pag)){$POST_pag = '0,'.$POST_num;}
/*
* Otras variables
*/
if(empty($POST_finicio)){
	$POST_finicio = "01/01/".date("Y");;
}

if(empty($POST_ffin)){$POST_ffin = date("d/m/Y");}
if(empty($POST_estado)){$POST_estado = 0;}
if(empty($POST_con)){$POST_con = "contiene";}
if(empty($POST_TipoFecha)){$POST_TipoFecha = "AmoFecha";}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoAlmacenEntrada.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsTrasladoAlmacenEntrada = new ClsTrasladoAlmacenEntrada();
$InsMoneda = new ClsMoneda();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoAlmacenEntrada.php');

																																																						//MtdObtenerTrasladoAlmacenEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="AmoFecha",$oProveedor=NULL,$oAlmacen=NULL,$oSubTipo=NULL)
$ResTrasladoAlmacenEntrada = $InsTrasladoAlmacenEntrada->MtdObtenerTrasladoAlmacenEntradas("amo.AmoId,amo.AmoGuiaRemisionNumero,amo.AmoComprobanteNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,"AmoFecha",NULL,$POST_Almacen,8);
$ArrTrasladoAlmacenEntradas = $ResTrasladoAlmacenEntrada['Datos'];
$TrasladoAlmacenEntradasTotal = $ResTrasladoAlmacenEntrada['Total'];
$TrasladoAlmacenEntradasTotalSeleccionado = $ResTrasladoAlmacenEntrada['TotalSeleccionado'];

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
<!--<div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel();"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 
-->
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
if($PrivilegioEditar){
?>

<!--<div class="EstSubMenuBoton"><a href="javascript:FncMarcarRevisadoSeleccionados();"><img src="imagenes/iconos/revisado.png" alt="[Marcar como Revisado]" title="Marcar como Revisado" />Revisado</a></div> 
-->
<?php
}
?>



</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE TRANSFERENCIAS DE ENTRADA</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $TrasladoAlmacenEntradasTotalSeleccionado;?></b> de <b><?php echo $TrasladoAlmacenEntradasTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
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
      <option value="AmoId" <?php if($POST_cam=="AmoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Proveedor</option>      
      <option value="AmoComprobanteNumero" <?php if($POST_cam=="AmoComprobanteNumero"){ echo 'selected="selected"';}?>>Num. Comprobante</option>      
      <option value="AmoGuiaRemisionNumero" <?php if($POST_cam=="AmoGuiaRemisionNumero"){ echo 'selected="selected"';}?>>Num. G. Remision</option>      
      
      
      </select>-->
    Estado:
	<select class="EstFormularioCombo" name="Estado" id="Estado">
    <option value="" >Todos</option>
    <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>No Realizado</option>
    <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
    </select>
    
    
    
    
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin; ?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="3%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="3%" >
                  
                  <?php
				if($POST_ord == "AmoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "AmoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fec. Ingreso <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','DESC');"> Fec. Ingreso <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fec. Ingreso </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "CtiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CtiNombre','ASC');"> Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CtiNombre','DESC');"> Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CtiNombre','ASC');"> Comprob. </a>
                  <?php
				}
				?></th>
                <th width="7%" > <?php
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
                <th width="7%" > <?php
				if($POST_ord == "AmoComprobanteFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteFecha','ASC');"> Fec. Comprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteFecha','DESC');"> Fec. Comprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteFecha','ASC');"> Fec. Comprob. </a>
                  <?php
				}
				?></th>
                <th width="5%" >
                  <?php
				if($POST_ord == "AmoGuiaRemisionFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemisionFecha','ASC');"> G. Rem. Fec.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemisionFecha','DESC');">G. Rem. Fec.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemisionFecha','ASC');">G. Rem. Fec. </a>
                  <?php
				}
				?>                </th>
                <th width="5%" ><?php
				if($POST_ord == "PrvNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. </a>
                  <?php
				}
				?></th>
                <th width="20%" ><?php
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
                <th width="4%" ><?php
				if($POST_ord == "AmoEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="4%" >Doc. Scan.</th>
                <th width="3%" ><?php
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
                <th width="7%" > <?php
				if($POST_ord == "AmoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');"> Fecha Creacion </a>
                  <?php
				}
				?></th>
                <th width="2%" >Cierre</th>
                <th width="11%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="16" align="center">

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

				  <option <?php if($POST_num==$TrasladoAlmacenEntradasTotal){ echo 'selected="selected"';}?> value="<?php echo $TrasladoAlmacenEntradasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $TrasladoAlmacenEntradasTotal;
					//}else{
					//	$tregistros = ($TrasladoAlmacenEntradasTotalSeleccionado);
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
								foreach($ArrTrasladoAlmacenEntradas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="3%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->TaeId; ?>" nota_credito_compra="<?php echo $dat->TaeNotaCreditoCompra;?>" />				</td>

                <td align="right" valign="middle" width="3%"   >
                  <a href="principal.php?Mod=TrasladoAlmacenEntrada&Form=Ver&Id=<?php echo $dat->TaeId;  ?>">
                  <?php echo $dat->TaeId;  ?>
                  </a>
                </td>
                <td  width="6%" align="right" ><?php echo ($dat->TaeFecha);?></td>
                <td  width="7%" align="right" ><?php echo $dat->CtiNombre;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->TaeComprobanteNumero;  ?> <br /></td>
                <td  width="7%" align="right" ><?php echo $dat->TaeComprobanteFecha;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->TaeGuiaRemisionFecha;  ?></td>
                <td  width="5%" align="right" ><?php echo ($dat->PrvNumeroDocumento);?></td>
                <td  width="20%" align="right" >
                  
                  

  <?php echo ($dat->PrvNombre);?>
    <?php echo ($dat->PrvApellidoPaterno);?>
      <?php echo ($dat->PrvApellidoMaterno);?>
          
                  
                  
</td>
                <td  width="4%" align="right" ><?php echo $dat->TaeEstadoIcono;?> <?php echo $dat->TaeEstadoDescripcion;?>
                  <?php
				/*switch($dat->TaeEstado){
					
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
                <td  width="4%" align="right" >
                  
                  
                  
  <?php            
if(!empty($dat->TaeFoto)){
	
	$extension = strtolower(pathinfo($dat->TaeFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->TaeFoto, '.'.$extension);  
?>
                  
                  <!--<a href="subidos/almacen_movimiento_entrada_fotos/<?php echo $dat->TaeFoto;?>" class="thickbox" title=""><img border="0"  src="imagenes/documento.gif"  /></a>
        -->       
                  
  <a target="_blank" href="subidos/almacen_movimiento_entrada_fotos/<?php echo $dat->TaeFoto;?>"  title=""><img border="0"  src="imagenes/documento.gif"  /></a>
                  
  <?php	
}
?>
                  
                  
                </td>
                <td  width="3%" align="right" ><?php echo ($dat->TaeTotalItems);?></td>
                <td align="right" ><?php echo ($dat->TaeTiempoCreacion);?></td>
                <td  width="2%" align="center" ><?php            
if($dat->TaeCierre == "1"){
?>
                  <img  src="imagenes/estado/cerrado.png" alt="" width="18" height="18" border="0" align="Cerrado" title="Cerrado" />
                  <?php	
}
?></td>
                <td  width="11%" align="center" >
                  
                  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->TaeId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
<?php
if($PrivilegioEliminar and $dat->TaeCierre == "2"){
?>
	<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->TaeId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
<?php
}
?>               
                  
                  <?php
if($PrivilegioEditar  and $dat->TaeCierre == "2"){
?>             
                  
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->TaeId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  
                  <?php
}
?>				
                  
                  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->TaeId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  <?php
}
?>
                  
                  
                  
                  
                  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->TaeId;?>');"><img src="imagenes/acciones/preliminar.png" alt="[Vista Preliminar]" title="Vista Preliminar" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->TaeId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?> 
                  
                  
                  
                  <?php
			/*if($PrivilegioGenerarNotaCredito  and $dat->TaeNotaCreditoCompra == "No"){
			?>        
                  <a href="principal.php?Mod=NotaCreditoCompra&Form=Registrar&Origen=TrasladoAlmacenEntrada&AmoId=<?php echo $dat->TaeId; ?>"><img src="imagenes/iconos/nota_credito_compra.png" width="19" height="19" border="0" title="Nota de Credito" alt="[Nota de Credito]"   /></a>
                  
                  <?php
			}*/
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