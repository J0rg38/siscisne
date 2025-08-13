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
<?php //$PrivilegioGenerarBoleta = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Boleta","Registrar"))?true:false;?>
<?php //$PrivilegioGenerarFactura = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Factura","Registrar"))?true:false;?>
<?php //$PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<?php $PrivilegioCotizacionProductoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionProducto","Ver"))?true:false;?>
<?php $PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>

<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVentaConcretada.js" ></script>

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
$POST_Moneda = $_POST['Moneda'];
$POST_Sucursal = $_POST['CmpSucursal'];


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

//
//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}



include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVentaConcretada.php');

//MtdObtenerVentaConcretadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL,$oIgnorarTotalVacio=false,$oGenerarFactura=false,$oFacturable=NULL,$oSucursal=NULL)
$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas("AmoId,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,CliNumeroDocumento,amo.CprId,amo.VdiId,vdi.VdiOrdenCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,0,0,0,NULL,$POST_Moneda,false,false,NULL,$POST_Sucursal);
$ArrVentaConcretadas = $ResVentaConcretada['Datos'];
$VentaConcretadasTotal = $ResVentaConcretada['Total'];
$VentaConcretadasTotalSeleccionado = $ResVentaConcretada['TotalSeleccionado'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


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
   
    
<!--    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/iconos/no_realizado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    
   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoDesanuladoSeleccionados();">
    <img src="imagenes/iconos/realizado.gif" alt="[Act. Desanulado]" title="Actualizar a estado DESANULADO seleccionados" />Realizado</a></div>
    -->
    
    
      <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
    <img src="imagenes/iconos/no_realizado.png" alt="[Act. No Realizado]" title="Actualizar a estado NO REALIZADO seleccionados" />No/Realizado</a></div>
    

   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoRealizadoSeleccionados();">
    <img src="imagenes/iconos/realizado.gif" alt="[Act. Realizado]" title="Actualizar a estado REALIZADO seleccionados" />Realizado</a></div>


   <div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemisionSeleccionados();">
    <img src="imagenes/iconos/guiaremision.png" alt="[Gen. Guia Remision]" title="Generar GUIA DE REMISION seleccionados" />G. Remision</a></div>
    
    
    
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
<div class="EstSubMenuBoton"><a href="javascript:FncEnviarCotizacionProductoContabilidadSeleccionados();"><img src="imagenes/iconos/enviar_contabilidad.png" alt="[Enviar Orden de Venta de Repuesto Concretada a Contabilidad]" title="Enviar Orden de Venta de Repuesto Concretada a Contabilidad" /> Contabilidad</a></div> 
<?php
}*/
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE VENTAS CONCRETADAS (VENTAS X MOSTRADOR)</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $VentaConcretadasTotalSeleccionado;?></b> de <b><?php echo $VentaConcretadasTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
     <?php
	  if(!empty($POST_Moneda)){
		  
	  ?>
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="65%" align="right">
        
        
        Total <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span>
        
        </td>
        <td width="35%" align="right">
        
        <div id="CapListadoTotal" ></div>
        
        </td>
      </tr>
      </table>
      <?php
	  }
	  ?>
    
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




    <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="VcoId" <?php if($POST_cam=="VcoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Cliente</option>
       <option value="amo.CprId" <?php if($POST_cam=="amo.CprId"){ echo 'selected="selected"';}?>>Cot. Repuesto</option>
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
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
  
  
    <span class="EstFormularioEtiqueta">   Sucursal:
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
                <th width="2%" >
                  
                  <?php
				if($POST_ord == "VcoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VcoId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VcoId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VcoId','ASC');"> Id.  </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "AmoFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fec. Salida <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoFecha','DESC');"> Fec. Salida <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoFecha','ASC');"> Fec. Salida  </a>
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
                <th width="6%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');">  Ord. Venta<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');">  Ord. Venta </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "VdiOrdenCompraNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> O.C. Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','DESC');"> O.C. Ref.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiOrdenCompraNumero','ASC');"> O.C. Ref. </a>
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
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Cot.  </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "AmoGuiaRemision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemision','ASC');"> G. Rem. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemision','DESC');"> G. Rem. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoGuiaRemision','ASC');"> G. Rem. </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "AmoFactura"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoFactura','ASC');"> Fac. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoFactura','DESC');"> Fac. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoFactura','ASC');"> Fac. </a>
                <?php
				}
				?>                  </th>
                <th width="3%" ><?php
				if($POST_ord == "AmoBoleta"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoBoleta','ASC');"> Bol. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoBoleta','DESC');"> Bol. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoBoleta','ASC');"> Bol. </a>
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
                <th width="8%" ><?php
				if($POST_ord == "AmoDescuento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoDescuento','ASC');"> Descuento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoDescuento','DESC');"> Descuento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AmoDescuento','ASC');"> Descuento </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
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
                <th width="3%" ><?php
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
                <th width="2%" ><?php
				if($POST_ord == "VcoTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VcoTotalItems','ASC');"> <span title="Items">It.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VcoTotalItems','DESC');"> <span title="Items">It.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VcoTotalItems','ASC');"> <span title="Items">It.</span></a>
                <?php
				}
				?></th>
                <th width="6%" >
                  <?php
				if($POST_ord == "AmoTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoTiempoCreacion','DESC');">
                    
                  Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('AmoTiempoCreacion','ASC');">
                   Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="2%" >Cierre</th>
                <th width="12%" >Acciones</th>
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

				  <option <?php if($POST_num==$VentaConcretadasTotal){ echo 'selected="selected"';}?> value="<?php echo $VentaConcretadasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VentaConcretadasTotal;
					//}else{
					//	$tregistros = ($VentaConcretadasTotalSeleccionado);
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
								foreach($ArrVentaConcretadas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >



<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VcoId; ?>" cotizacion="<?php echo $dat->CprId;?>" estado="<?php echo $dat->VcoEstado;?>" factura="<?php echo $dat->VcoFactura;?>" boleta="<?php echo $dat->VcoBoleta;?>" guia_remision="<?php echo $dat->VcoGuiaRemision;?>" cliente="<?php echo $dat->CliId; ?>" />				



</td>

                <td align="right" valign="middle" width="2%"   >
				
				 <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VcoId;?>">
				 <?php echo $dat->VcoId;  ?></a></td>
                <td  width="5%" align="right" ><?php echo ($dat->VcoFecha);?></td>
                <td  width="10%" align="right" >
                  
                  <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
</td>
                <td  width="6%" align="right" >
				


				
<?php
if($PrivilegioVentaDirectaVer){
?>

<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>

<!--<a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>-->
<?php	
}else{
?>
<?php echo ($dat->VdiId);?>
<?php	
}
?>
	
    
	
	
	
                <td  width="3%" align="right" ><?php echo ($dat->VdiOrdenCompraNumero);?></td>
                <td  width="3%" align="right" >
				
			
    				
<?php
if($PrivilegioCotizacionProductoVer){
?>


<!--<a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>-->

<a href="javascript:FncCotizacionProductoVistaPreliminar('<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>

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
				if($dat->VcoGuiaRemision == "Si"){
				?>

					<a href="formularios/VentaConcretada/DiaGuiaRemisionListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId;?>" class="thickbox" title="">Tiene Guia Remision</a>

				<?php	
				}else{
				?>
                  <?php //echo ($dat->AmoGuiaRemision); ?>
                <?php	
				}
				?>
                
                
                </td>
                <td  width="3%" align="right" >
				
				<?php
				if($dat->VcoFactura == "Si"){
				?>
                  <a href="formularios/VentaConcretada/DiaFacturaListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId?>" class="thickbox" title="">Tiene Factura</a>
                  <?php	
				}else{
				?>
                  <?php //echo ($dat->AmoFactura); ?>
                <?php	
				}
				?></td>
                <td  width="3%" align="right" >
                  
                  
                  <?php
				if($dat->VcoBoleta == "Si"){
				?>
                  <a href="formularios/VentaConcretada/DiaBoletaListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId?>" class="thickbox" title="">Tiene Boleta</a>
                  <?php	
				}else{
				?>
                  <?php //echo ($dat->AmoFactura); ?>
                  <?php	
				}
				?>
                  
                  
                </td>
                <td  width="7%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VcoTipoCambio;  ?></td>
                <td  width="8%" align="right" >
                  
                  <?php //$dat->VcoDescuento = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VcoDescuento:($dat->VcoDescuento/$dat->VcoTipoCambio));?>
                    <?php $dat->VcoDescuento = (($dat->VcoDescuento/(empty($dat->VcoTipoCambio)?1:$dat->VcoTipoCambio)));?>
                  
                  
                  <?php echo number_format($dat->VcoDescuento,2);?>
                <?php
				
			
				?></td>
                <td  width="4%" align="right" >
                  <?php $dat->VcoTotal = (($dat->VcoTotal/(empty($dat->VcoTipoCambio)?1:$dat->VcoTipoCambio)));?>
                  
  <?php //$dat->VcoTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VcoTotal:($dat->VcoTotal/$dat->VcoTipoCambio));?>
                  
                  <?php echo number_format($dat->VcoTotal,2);?>
                  <?php
					$Total += $dat->VcoTotal ;
			
				?>
                </td>
                <td  width="3%" align="right" >
				
                <?php //echo $dat->VcoEstadoIcono; ?>
				
                
               <?php
				switch($dat->VcoEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.png" />
                  <?php							
						break;	
						
							case 6:
				?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                  <?php							
						break;	

					}
				?> <?php echo $dat->VcoEstadoDescripcion; ?></td>
                <td  width="2%" align="right" ><?php echo ($dat->VcoTotalItems);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->VcoTiempoModificacion);?></td>
                <td  width="2%" align="center" ><?php            
if($dat->VcoCierre == "1"){
?>
                  <img  src="imagenes/estado/cerrado.png" width="18" height="18" border="0" title="Cerrado" align="Cerrado" />
                  <?php	
}
?></td>
                <td  width="12%" align="center" >
                  
                  
  <?php
if($PrivilegioAuditoriaVer){
?>
  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->VcoId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
  <?php
if($PrivilegioEliminar and $dat->VcoFactura =="No" and $dat->VcoBoleta =="No" and $dat->VcoCierre == "2"){
?>
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VcoId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
  <?php
}
?>               
                  
<?php
if($PrivilegioEditar and $dat->VcoFactura =="No" and $dat->VcoBoleta =="No" and $dat->VcoCierre == "2" ){
//if($PrivilegioEditar  ){
?>             
                  
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VcoId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  
  <?php
}
?>				
                  
  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  
                  
  <?php
}
?>
                  
                  
                  
  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $dat->VcoId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                  <!-- <a href="javascript:FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id=<?php echo $dat->VcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>-->
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncVentaConcretadaImprmir('<?php echo $dat->VcoId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?> 
                  
                  <?php
 
if($PrivilegioGenerarPDF ){
?>
                  <a href="javascript:FncVentaConcretadaGenerarPDF('<?php echo $dat->VcoId;?>');"><img src="imagenes/pdf.gif" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
  <?php
}
?>  
                  
                  
                  
                  
                  <?php
//	if($PrivilegioGenerarGuiaRemision and $dat->AmoGuiaRemision="No"){
//	if($PrivilegioGenerarGuiaRemision and $dat->VcoEstado == 3 ){
	if($PrivilegioGenerarGuiaRemision){
    ?>
                  <a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=VentaConcretada&VcoId=<?php echo $dat->VcoId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]"   /></a>
                  <?php
	}
	?>
                  
                  
  <?php
if($PrivilegioEditar and ($dat->VcoEstado == 3 )){
?>             
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=SolicitudFacturacion&Id=<?php echo $dat->VcoId;?>"><img src="imagenes/acciones/enviar_correo3.png" width="19" height="19" border="0" title="Enviar Solicitud de Facturacion" alt="[Enviar Solicitud de Facturacion]"   /></a>   
  <?php
}
?>
                  
  <?php
if($PrivilegioEditar and ($dat->VcoEstado == 3 )){
?>             
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=InformarDespacho&Id=<?php echo $dat->VcoId;?>"><img src="imagenes/acciones/enviar_correo4.png" width="19" height="19" border="0" title="Enviar Informe de Despacho" alt="[Enviar Informe de Despacho]"   /></a>   
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

