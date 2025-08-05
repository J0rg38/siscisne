<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Especial"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php $PrivilegioOrdenCompraVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCompra","Ver"))?true:false;?>
<?php $PrivilegioCotizacionProductoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>
<?php $PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioFichaIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Ver"))?true:false;?>

<?php $PrivilegioOrdenCompraGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCompra","GenerarExcel"))?true:false;?>
<?php $PrivilegioPagoListado = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompra.js" ></script>
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
$POST_Moneda = $_POST['Moneda'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(!$_POST){
	$POST_Moneda = "MON-10001";
}

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PcoTiempoCreacion';
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

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPedidoCompra.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsPedidoCompra = new ClsPedidoCompra();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPedidoCompra.php');

				//MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array(),$oSucursal=NULL) {
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras("pco.PcoId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,pco.VdiId,CprId,pco.OcoId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,0,NULL,NULL,NULL,NULL,array("PCO","VDI","STK","LLA","FIN"),$POST_Sucursal);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];
$PedidoComprasTotal = $ResPedidoCompra['Total'];
$PedidoComprasTotalSeleccionado = $ResPedidoCompra['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];




$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


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
    if($PrivilegioEliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
    <?php
    }
    ?>
    
    <?php
/*    if($PrivilegioEditar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarOrdenCompraSeleccionados();"><img src="imagenes/acciones/generar_orden_compra.png" alt="[Generar Ord. Compra]" title="Generar Ord. Compra" /> Ord. Compra</a></div> 
    <?php
    }*/
    ?>
    
       <?php
    if($PrivilegioEditar){
    ?>
	<div class="EstSubMenuBoton"><a href="javascript:FncActualizarDesaprobadoSeleccionados();"><img src="imagenes/acciones/desaprobado.png" alt="[Desaprobado]" title="Desaprobado" /> Desaprobado</a></div> 
	
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarAprobadoSeleccionados();"><img src="imagenes/acciones/aprobado.png" alt="[Aprobado]" title="Aprobado" /> Aprobado</a></div> 
    <?php
    }
    ?> 
    
    <!--<div class="EstSubMenuBoton"><a href="principal.php?Mod=OrdenCompra&Form=Listado"><img src="imagenes/acciones/orden_compra_gm.png" alt="[ Ord. Compra]" title=" Ord. Compra" /> Ord. Compra</a></div>--> 
   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE PEDIDO DE COMPRA</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $PedidoComprasTotalSeleccionado;?></b> de <b><?php echo $PedidoComprasTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
   
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="65%" align="right">
        
     <!--   
        Total <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span>
        -->
        </td>
        <td width="35%" align="right">
        
 <!--       <div id="CapListadoTotal" ></div>
        -->
        </td>
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
      <option value="PcoId" <?php if($POST_cam=="PcoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Cliente</option>
      
      </select>-->
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
				if($POST_ord == "PcoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PcoId','ASC');"> Id.  </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PcoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PcoFecha','ASC');"> Fecha  </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "PcoTipoPedido"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoTipoPedido','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoTipoPedido','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PcoTipoPedido','ASC');"> Tipo </a>
                  <?php
				}
				?></th>
                <th width="17%" ><?php
				if($POST_ord == "CliNombreCompleto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombreCompleto','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombreCompleto','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNombreCompleto','ASC');"> Cliente </a>
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
				if($POST_ord == "OcoTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoTipoCambio','ASC');"> T.C. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
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
                <th width="3%" ><?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Ord. Trab. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');">  Ord. Trab. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');">  Ord. Trab. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OcoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');"> Ord. Com.  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoId','DESC');"> Ord. Com.  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');"> Ord. Com.  </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "PcoTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PcoTotal','ASC');"> Total </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "VdiPago"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiPago','ASC');"> Abonos <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiPago','DESC');"> Abonos <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiPago','ASC');"> Abonos </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PcoAprobado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoAprobado','ASC');"> Aprob. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoAprobado','DESC');"> Aprob. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PcoAprobado','ASC');"> Aprob. </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "PcoEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PcoEstado','ASC');"> Est.  </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "PcoTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PcoTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PcoTotalItems','ASC');"> <span title="Items">It.</span></a>
                <?php
				}
				?></th>
                <th width="9%" >
                  <?php
				if($POST_ord == "PcoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('PcoTiempoCreacion','ASC');">
                 Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PcoTiempoCreacion','DESC');">
                    
                 Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('PcoTiempoCreacion','ASC');">
                 Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="15%" >Acciones</th>
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

				  <option <?php if($POST_num==$PedidoComprasTotal){ echo 'selected="selected"';}?> value="<?php echo $PedidoComprasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $PedidoComprasTotal;
					//}else{
					//	$tregistros = ($PedidoComprasTotalSeleccionado);
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
								foreach($ArrPedidoCompras as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center" bgcolor="<?php echo ($dat->OcoProcesadoProveedor==1?'#009933':'');?>"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >



<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PcoId; ?>" cotizacion="<?php echo $dat->CprId;?>" estado="<?php echo $dat->PcoEstado;?>" moneda="<?php echo $dat->MonId;?>" orden_compra="<?php echo $dat->OcoId;?>" />				



</td>

                <td align="right" valign="middle" width="2%"   >
				
				 <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PcoId;?>">
				 <?php echo $dat->PcoId;  ?>
                 </a>
                 </td>
                <td  width="4%" align="right" ><?php echo ($dat->PcoFecha);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->PcoTipoPedido);?></td>
                <td  width="17%" align="right" >
                  
                  
                  <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
                  
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->PcoTipoCambio;  ?></td>
                <td  width="5%" align="right" >
                  <?php
if($PrivilegioCotizacionProductoVer){
?>
                  <!--<a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>-->
                  <a href="javascript:FncCotizacionProductoVistaPreliminar('<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>
                  
                  <?php	
}else{
?>
                  <?php echo $dat->CprId;  ?>
                  <?php	
}
?></td>
                <td  width="4%" align="right" >
                  
     <?php
if($PrivilegioVentaDirectaVer){
?>
                               
                  
<!--<a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>-->

<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>
                  
                  <?php	
}else{
?>
                  <?php echo $dat->VdiId;  ?>
                  <?php	
}
?>
                  
                  
                </td>
                <td  width="3%" align="right" >


                  
  <?php
if($PrivilegioFichaIngresoVer){
?>
	<a href="javascript:FncFichaIngresoVistaPreliminar('<?php echo $dat->FinId?>');"  ><?php echo ($dat->FinId);?></a>

<?php	
}else{
?>
  <?php echo $dat->FinId;  ?>
  <?php	
}
?>
     
     
     
                </td>
                <td  width="5%" align="right" >
                  
                  
  <?php
if($PrivilegioOrdenCompraVer){
?>


<!--<a href="javascript:FncOrdenCompraCargarFormulario('Ver','<?php echo $dat->OcoId?>');"  ><?php echo ($dat->OcoId);?></a>-->
<a href="javascript:FncOrdenCompraVistaPreliminar('<?php echo $dat->OcoId?>');"  ><?php echo ($dat->OcoId);?></a>
           
           
                  
  <?php	
}else{
?>
  <?php echo $dat->OcoId;  ?>
  <?php	
}
?>
                  
                  
                  
                  
                  
                </td>
                <td  width="6%" align="right" >
				
				<?php $dat->PcoTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PcoTotal:($dat->PcoTotal/$dat->PcoTipoCambio));?>
                
				<?php echo number_format($dat->PcoTotal,2);?></td>
                <td  width="6%" align="right" ><?php
//if($PrivilegioPagoListado and $dat->VdiPago == "Si"){

if($dat->VdiPago == "Si"){
?>
	
	<?php
	if($PrivilegioPagoListado){
	?>
		<a href="javascript:FncPagoVentaDirectaCargarFormulario('Listado','<?php echo $dat->VdiId;?>');" > Tiene Abono</a>    
    <?php	
	}else{
	?>
   		Tiene Abono
    <?php	
	}
	?>

<?php
}else{
?>
No Tiene Abono
<?php	
}
?></td>
                <td  width="4%" align="right" >
                
                <?php
				switch($dat->PcoAprobado){
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
				?>
                </td>
                <td  width="3%" align="right" >
                  
                  <?php
				  echo $dat->PcoEstadoDescripcion;
				  ?>
                  
                  <?php
				
					switch($dat->PcoEstado){
					
						case 1:
					?>
                    <img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.png" />
                    <?php
							
						break;
					
						case 3:
						
						?>
                  <img width="15" height="15" alt="[Listo]" title="Listo" src="imagenes/estado/realizado.png" />
                    <?php
											
						break;	
						
						case 31:
						?>
                   <img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />
                    <?php
											
						break;
		
						case 6:
						?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />
                    <?php
									
						break;	
		
						default:
							?>
                   -
                    <?php
						break;
					
					}
					
				?></td>
                <td  width="3%" align="right" ><?php echo ($dat->PcoTotalItems);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->PcoTiempoCreacion);?></td>
        <td  width="15%" align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->PcoId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
//if($PrivilegioEliminar  and ( ($dat->OcoEstado <> 1 or $dat->OcoEstado <> 3) or empty($dat->OcoEstado)) ){
if($PrivilegioEliminar  and  (empty($dat->OcoId) or (!empty($dat->OcoId) and $dat->OcoEstado==1) ) ){
?>


<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PcoId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
<?php
}
?>               
				
<?php
if($PrivilegioEditar ){
//if($PrivilegioEditar and ( ($dat->OcoEstado <> 1 or $dat->OcoEstado <> 3) or empty($dat->OcoEstado)) ){
//	if($PrivilegioEliminar  and  (empty($dat->OcoId) or (!empty($dat->OcoId) and $dat->OcoEstado==1) ) ){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->PcoId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}
?>

	
 <?php
if($PrivilegioVer){
?>		
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=VerEstado&Id=<?php echo $dat->PcoId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[P.C. Estado]" title="P.C. Estado" width="19" height="19" border="0" /></a>   

<?php
}
?>


<?php
//if($PrivilegioOrdenCompraGenerarExcel and $dat->OcoEstado == 3){
if($PrivilegioOrdenCompraGenerarExcel and !empty($dat->OcoId) ){
?>        

	<!--<a href="javascript:FncPopUp('formularios/OrdenCompra/FrmOrdenCompraGenerarExcel.php?Id=<?php echo $dat->OcoId;?>&P=2&Enviado=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/excel.png" alt="[Generar Excel]" title="Generar Excel" width="19" height="19" border="0" /></a>
-->
	<a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraGenerarExcel.php?Id=<?php echo $dat->PcoId;?>&P=2&Enviado=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/excel.png" alt="[Generar Excel]" title="Generar Excel" width="19" height="19" border="0" /></a>


<?php
}
?> 

<?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $dat->PcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $dat->PcoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			
			<?php
			}
			?> 
  


<?php
if($PrivilegioEditar and !empty($dat->OcoId)){
?>             
                      
<!--<a href="principal.php?Mod=OrdenCompra&Form=EnviarCorreo&Id=<?php echo $dat->OcoId;?>"><img src="imagenes/acciones/enviar_correo.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
            -->  
           <?php
		//   if($dat->PrvLineaCreditoActiva==1){
			?>
				<a href="javascript:FncPedidoCompraEnviarCorreo('<?php echo $dat->PcoId;?>','<?php echo   $dat->PcoAprobado?>','<?php echo   $dat->PrvLineaCreditoActiva?>')">

               <!-- <a href="principal.php?Mod=PedidoCompra&Form=EnviarCorreo&Id=<?php echo $dat->PcoId;?>">--><img src="imagenes/acciones/enviar_correo.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
	       
            <?php
		  /* }else{
			?>
            <a href="javascript:FncProveedorLineaCredito('<?php echo $dat->PrvId;?>');"><img src="imagenes/acciones/enviar_correo_deshabilitado.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
	       
            <?php
		   }*/
		   ?>        
				
<?php
}
?>	<!--A<a href="javascript:FncProveedorLineaCredito('<?php echo $dat->PrvId;?>');"><img src="imagenes/acciones/enviar_correo.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
	-->       
<?php
if($PrivilegioEditar and ($dat->PcoEstado == 31) and !empty($dat->OcoId)){
?>             
	
    <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=ConsultarETA&Id=<?php echo $dat->PcoId;?>"><img src="imagenes/acciones/enviar_correo2.png" width="19" height="19" border="0" title="Enviar Consulta ETA" alt="[Enviar Consulta ETA]"   /></a>   
    
<?php
}
?>

<?php
if($PrivilegioEditar and ($dat->PcoEstado == 3 or $dat->PcoEstado == 31) and ($dat->PcoAprobado == 2) ){
?>           

<a href="javascript:FncPedidoCompraSolicitarAutorizacion('<?php echo $dat->PcoId;?>','<?php echo   $dat->PcoAprobado?>','<?php echo   $dat->PrvLineaCreditoActiva?>')">

<img src="imagenes/acciones/enviar_correo3.png" width="19" height="19" border="0" title="Enviar Solicitud de Autorizacion" alt="[Enviar Solicitud de Autorizacion]"   /></a>   
    
   <a href="javascript:FncDescargarExcel('<?php echo $dat->PcoId;?>')"><img src="imagenes/acciones/excel.png" width="19" height="19" border="0" title="Descargar Excel" alt="[Descargar Excel]"   /></a>   
    
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

