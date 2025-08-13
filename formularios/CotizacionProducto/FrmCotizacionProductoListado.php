<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>


<?php $PrivilegioClienteVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente","Ver"))?true:false;?>
<?php $PrivilegioVehiculoIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Ver"))?true:false;?>
<?php $PrivilegioFichaIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Ver"))?true:false;?>
<?php //$PrivilegioVentaDirectaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Ver"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>
<?php $PrivilegioGenerarVentaDirecta = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaDirecta","Registrar"))?true:false;?>

<?php $PrivilegioRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Registrar"))?true:false;?>
<?php $PrivilegioGenerarFichaIngreso = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Registrar"))?true:false;?>

	
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProducto.js" ></script>
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
$POST_fil = (empty($_POST['Fil'])?$_GET['Fil']:$_POST['Fil']);

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
$POST_Personal = $_POST['Personal'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CprTiempoCreacion';
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

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}


//
//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionProducto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsCotizacionProducto = new ClsCotizacionProducto();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();

$InsCotizacionProducto->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionProducto.php');


//MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL,$oPersonal=NULL,$oCliente=NULL,$oTieneFichaIngreso=NULL,$oSucursal=NULL)
$ResCotizacionProducto = $InsCotizacionProducto->MtdObtenerCotizacionProductos("cpr.CprId,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,seg.CliNombre,seg.CliApellidoPaterno,seg.CliApellidoMaterno,cli.CliNumeroDocumento,EinVIN,EinPlaca,FinId,VmaNombre,VmoNombre,VveNombre,CprMarca,CprModelo,CprPlaca,cli.CliDepartamento,cli.CliDistrito,cli.CliProvincia",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,NULL,NULL,$POST_Personal,NULL,NULL,$POST_Sucursal);
$ArrCotizacionProductos = $ResCotizacionProducto['Datos'];
$CotizacionProductosTotal = $ResCotizacionProducto['Total'];
$CotizacionProductosTotalSeleccionado = $ResCotizacionProducto['TotalSeleccionado'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

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
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/submenu/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>


<?php
if($PrivilegioEditar){
?>
   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarNivelInteresSeleccionados();"><img src="imagenes/submenu/icon_nivel_interes.png" alt="[Actualizar Nivel de Interes seleccionados]" title="Actualizar Nivel de Interes seleccionados" />Niv. Interes</a></div>
   
   
   
      <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
    <img src="imagenes/submenu/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div>
    
      <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoRealizadoSeleccionados();">
    <img src="imagenes/submenu/realizado.png" alt="[Act. Listo]" title="Actualizar a estado LISTO seleccionados" />Listo</a></div>
    
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anular</a></div>
    
   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoDesanuladoSeleccionados();">
    <img src="imagenes/submenu/desanulado.png" alt="[Act. Desanulado]" title="Actualizar a estado DESANULADO seleccionados" />Desanular</a></div>
<?php
}
?>

<?php
/*if($PrivilegioEditar){
?>
 <div class="EstSubMenuBoton"><a href="javascript:FncEditarVentaPerdidaSeleccionados();"><img src="imagenes/submenu/estado_observado.png" alt="[Actualizar Estado Venta Perdida]" title="Actualizar Estado Venta Perdida" />Ven. Perdida</a></div>
<?php
}*/
?>


<?php
/*if($PrivilegioEditar){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarCotizacionProductoAlmacenSeleccionados();"><img src="imagenes/iconos/enviar_almacen2.png" alt="[Enviar Cotizacion a Almacen]" title="Enviar Cotizacion a Almacen" /> Almacen</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarCotizacionProductoVentasSeleccionados();"><img src="imagenes/iconos/enviar_almacen_cancelar.png" alt="[Cancelar Envio de Cotizacion a Almacen]" title="Cancelar Envio de Cotizacion a Almacen" /> Cancelar </a></div> 
    
<?php
}*/
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE COTIZACIONES DE REPUESTOS Y SERVICIOS</span>  </td>
</tr>
<tr>
  <td width="50%">
    Mostrando <b><?php echo $CotizacionProductosTotalSeleccionado;?></b> de <b><?php echo $CotizacionProductosTotal;?></b> registros.</td>
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
        
      </table>-->
      
      <?php
	  if(!empty($POST_Moneda)){
		  
	  ?>
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
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="CprId" <?php if($POST_cam=="CprId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Cliente</option>      
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>      

      
      
      </select>-->
<!--    Estado:
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>En Transito</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>-->
      
      Cotizador:
      <select  class="EstFormularioCombo" name="Personal" id="Personal" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                      <option <?php echo ($DatPersonal->PerId==$POST_Personal)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                      <?php
					}
					?>
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
      
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
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
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="2%" >
                  
                  <?php
				if($POST_ord == "CprId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CprId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" >
                
                                <?php
				if($POST_ord == "CprFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CprFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="4%" ><?php
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
                <th width="4%" ><?php
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
                <th width="5%" ><?php
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
                <th width="5%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombreSeguro','ASC');"> Seguro <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombreSeguro','DESC');"> Seguro <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombreSeguro','ASC');"> Seguro </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
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
                <th width="5%" >Vehiculo</th>
                <th width="4%" ><?php
				if($POST_ord == "CprPlaca"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprPlaca','ASC');"> Placa <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprPlaca','DESC');"> Placa <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CprPlaca','ASC');"> Placa </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> O.T. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');"> O.T. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> O.T. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "CprVentaDirecta"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprVentaDirecta','ASC');"> O.V. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprVentaDirecta','DESC');"> O.V.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CprVentaDirecta','ASC');"> O.V. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
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
                <th width="3%" ><?php
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
                <th width="4%" ><?php
				if($POST_ord == "CprTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CprTotal','ASC');"> Total  </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
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
                <th width="3%" ><?php
				if($POST_ord == "CprEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CprEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CprEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="2%" ><?php
				if($POST_ord == "CprTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CotTotalItems','ASC');"> It. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CotTotalItems','DESC');"> It. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CotTotalItems','ASC');"> It. </a>
                <?php
				}
				?></th>
                <th width="3%" >
                  <?php
				if($POST_ord == "CprTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('CprTiempoCreacion','ASC');">
                 Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CprTiempoCreacion','DESC');">
                    
                 Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CprTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="11%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="21" align="center">

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

				  <option <?php if($POST_num==$CotizacionProductosTotal){ echo 'selected="selected"';}?> value="<?php echo $CotizacionProductosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $CotizacionProductosTotal;
					//}else{
					//	$tregistros = ($CotizacionProductosTotalSeleccionado);
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
								foreach($ArrCotizacionProductos as $dat){




$Color = "#FFFFFF";
if($dat->CprVentaPerdida==1){
	$Color = "#FF0000";
}
		
		
		
								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center" bgcolor="<?php echo $Color; ?>"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CprId; ?>" estado="<?php echo $dat->CprEstado; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   >
				
                <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CprId;?>"><?php echo $dat->CprId;  ?></a>
                 <?php 
				switch($dat->CprNivelInteres){
					case 1:
				?>
               
                <?php	
					break;
					
					case 2:
				?>
               <img src="imagenes/estado/icon_nivel3.png" width="25" height="25" align="Nivel 1" title="Nivel 1" />
                <?php	
					break;
					
						case 3:
				?>
               <img src="imagenes/estado/icon_nivel2.png" width="25" height="25" align="Nivel 2" title="Nivel 2" />
                <?php	
					break;
					
						case 4:
				?>
               <img src="imagenes/estado/icon_nivel1.png" width="25" height="25" align="Nivel 3" title="Nivel 3" />
                <?php	
					break;
					
				}
				?>
                
				</td>
                <td  width="4%" align="right" ><?php echo $dat->CprFecha;  ?></td>
                <td  width="4%" align="right" >
                  
                  
                  <?php echo (empty($dat->LtiAbreviatura)?$dat->LtiNombre:$dat->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?>
                  
                </td>
                <td  width="4%" align="right" ><?php echo ($dat->TdoNombre);?>/<?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="5%" align="right" >
				

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
                <td  width="5%" align="right" >
                

<?php echo $dat->CliNombreSeguro;?> <?php echo $dat->CliApellidoPaternoSeguro;?> <?php echo $dat->CliApellidoMaternoSeguro;?>          
                </td>
                <td  width="3%" align="right" >
                  
  <?php
if($PrivilegioVehiculoIngresoVer and !empty($dat->EinId)){
?>
                  <a href="javascript:FncVehiculoIngresoSimpleCargarFormulario('Ver','<?php echo $dat->EinId?>');"  ><?php echo ($dat->CprVIN);?></a>
  <?php	
}else{
?>
  <?php echo $dat->CprVIN;  ?>
  <?php	
}
?>
                  
                  
</td>
                <td  width="5%" align="left" ><b>Marca:</b> <?php echo ($dat->VmaNombre);?><br />
                  <b>Modelo:</b> <?php echo ($dat->VmoNombre);?><br />
                  <b>Version:</b> <?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" >
				
				<h2><?php echo ($dat->CprPlaca);?></h2></td>
                <td  width="3%" align="right" >
                
<?php
if(!empty($dat->FinId)){
?>

	<?php
    if($PrivilegioFichaIngresoVer){
    ?>
        <a href="javascript:FncFichaIngresoCargarFormulario('Ver','<?php echo $dat->FinId?>');"  ><?php echo ($dat->FinId);?></a>
    
    <?php	
    }else{
    ?>
    <?php echo $dat->FinId;  ?>
    <?php	
    }
    ?>

<?php	
}else{
?>
No tiene O.T.
<?php	
}
?>


                </td>
                <td  width="4%" align="right" >
				
<?php
if($dat->CprVentaDirecta == "Si"){
?>

<a href="formularios/CotizacionProducto/DiaVentaDirectaListado.php?height=440&width=850&CprId=<?php echo $dat->CprId?>" class="thickbox" title="Tiene Orden de Venta">
<?php //echo ($dat->CprVentaDirecta); ?>
Tiene O.V.
</a> 

<?php	
}else{
?>
No Tiene O.V.
<?php // echo $dat->CprVentaDirecta;  ?>
<?php	
}
?>

				
                
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CprTipoCambio;  ?></td>
                <td  width="4%" align="right" >

   <?php $dat->CprTotal = (($dat->CprTotal/(empty($dat->CprTipoCambio)?1:$dat->CprTipoCambio)));?>
               
                         
  <?php //$dat->CprTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CprTotal:($dat->CprTotal/$dat->CprTipoCambio));?>
  <?php echo number_format($dat->CprTotal,2);?>
                  
                  <?php
					$Total += $dat->CprTotal ;
			
				?>
                </td>
                <td  width="6%" align="right" >
				
				<?php echo ($dat->PerNombre);?>
                <?php echo ($dat->PerApellidoPaterno);?>
                <?php echo ($dat->PerApellidoMaterno);?>
                
                </td>
                <td  width="3%" align="right" >
				
				
				<span title="<?php echo $dat->CprEstado;?>"><?php echo $dat->CprEstadoDescripcion;?></span>
                  <?php
				switch($dat->CprEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/estado/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/estado/realizado.gif" />
                  <?php							
						break;	
						
						case 6:
				?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                  <?php							
						break;

					}
				?></td>
                <td  width="2%" align="right" ><?php echo ($dat->CprTotalItems);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->CprTiempoCreacion);?></td>
        <td  width="11%" align="center" >
		
        
<?php
if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->CprId;?>&Ta=<?php echo $dat->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>

<?php
if($PrivilegioEliminar and $dat->CprEstado==1 and $dat->CprVentaDirecta=="No" ){
?> 
	<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CprId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
//if($PrivilegioEditar and $dat->CprEstado==1 and $dat->CprVentaDirecta=="No"){
//	if($PrivilegioEditar and $dat->CprEstado==1){
if($PrivilegioEditar ){
?>
    <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CprId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CprId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->CprId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}
?>
        
<?php
if($PrivilegioImprimir and $dat->CprEstado <> 6){
?>        
	<a href="javascript:FncImprmir('<?php echo $dat->CprId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
<?php
}
?>
 
 <?php
 
if($PrivilegioGenerarPDF and $dat->CprEstado <> 6){
?>
	<a href="javascript:FncGenerarPDF('<?php echo $dat->CprId;?>');"><img src="imagenes/pdf.gif" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>         

  <?php
if($PrivilegioGenerarVentaDirecta and $dat->CprEstado <> 6){
?>		  


	<?php
   // if($dat->VdiGenerarVentaDirecta == "Si"){
    //if($dat->CprVentaDirecta=="No"){
    ?>
    <a href="principal.php?Mod=VentaDirecta&Form=Registrar&Origen=CotizacionProducto&CprId=<?php echo $dat->CprId;?>"><img src="imagenes/iconos/orden_venta.png" width="19" height="19" border="0" title="Generar Orden de Venta" alt="[Generar Orden de Venta]"   /></a>                
    <?php	
   // }
    ?>

                  
                  
  <?php
}
?>      
        
         <?php
if($PrivilegioRegistrar and $dat->CprEstado <> 6){
?>		  
 
        <a href="principal.php?Mod=CotizacionProducto&Form=Registrar&Origen=CotizacionProducto&CprId=<?php echo $dat->CprId;?>"><img src="imagenes/iconos/cotizacion.png" width="19" height="19" border="0" title="Generar Cotizacion" alt="[Generar Cotizacion]"   /></a>  
                          
  <?php
}
?>      
           
         <?php
if($PrivilegioGenerarFichaIngreso and $dat->CprEstado <> 6){
?>	 
<a href="principal.php?Mod=FichaIngreso&Form=Registrar&Origen=CotizacionProducto&CprId=<?php echo $dat->CprId;?>"><img src="imagenes/nicono/orden_trabajo.png" width="19" height="19" border="0" title="Generar Cotizacion" alt="[Generar Cotizacion]"   /></a>  
        
                         
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
<td align="left" valign="middle">Ultima Actualizacion</td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">I.T.: </span></td>
<td align="left" valign="middle"><p>Numero de Items</p></td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">T.C.: </span></td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoContenido">Tipo de Cambio</span></td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">O.T.: </span></td>
<td align="left" valign="middle">Orden de Trabajo</td>
<td align="left" valign="middle"><span class="EstPanelTablaListadoEtiqueta">O.V.: </span></td>
<td align="left" valign="middle">Orden de Venta</td>
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

