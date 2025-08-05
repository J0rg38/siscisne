<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>

<?php $PrivilegioVehiculoIngresoVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Ver"))?true:false;?>


<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcion.js" ></script>
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
$POST_fil = (empty($_POST['Fil'])?$_GET['Fil']:$_POST['Fil']);

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
$POST_Personal = $_POST['Personal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VreTiempoCreacion';
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

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoRecepcion.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsVehiculoRecepcion = new ClsVehiculoRecepcion();
$InsPersonal = new ClsPersonal();

$InsVehiculoRecepcion->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoRecepcion.php');


// MtdObtenerVehiculoRecepciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoIngreso=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oPersonal=NULL)
$ResVehiculoRecepcion = $InsVehiculoRecepcion->MtdObtenerVehiculoRecepciones("VreId,EinVIN,VmaNombre,VmoNombre,VveNombre,VreGuiaRemisionNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Personal);
$ArrVehiculoRecepciones = $ResVehiculoRecepcion['Datos'];
$VehiculoRecepcionesTotal = $ResVehiculoRecepcion['Total'];
$VehiculoRecepcionesTotalSeleccionado = $ResVehiculoRecepcion['TotalSeleccionado'];


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];



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
if($PrivilegioEditar){
?>
   
    
  <!--  <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/iconos/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anular</a></div>
    
   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoDesanuladoSeleccionados();">
    <img src="imagenes/iconos/desanulado.png" alt="[Act. Desanulado]" title="Actualizar a estado DESANULADO seleccionados" />Desanular</a></div>-->
<?php
}
?>

<?php
/*if($PrivilegioEditar){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarVehiculoRecepcionAlmacenSeleccionados();"><img src="imagenes/iconos/enviar_almacen2.png" alt="[Enviar Cotizacion a Almacen]" title="Enviar Cotizacion a Almacen" /> Almacen</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncEnviarVehiculoRecepcionVentasSeleccionados();"><img src="imagenes/iconos/enviar_almacen_cancelar.png" alt="[Cancelar Envio de Cotizacion a Almacen]" title="Cancelar Envio de Cotizacion a Almacen" /> Cancelar </a></div> 
    
<?php
}*/
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE RECEPCION DE VEHICULOS  </span>  </td>
</tr>
<tr>
  <td width="50%">
    Mostrando <b><?php echo $VehiculoRecepcionesTotalSeleccionado;?></b> de <b><?php echo $VehiculoRecepcionesTotal;?></b> registros.</td>
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
      <option value="VreId" <?php if($POST_cam=="VreId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Cliente</option>      
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Cliente</option>      

      
      
      </select>-->
<!--    Estado:
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>En Transito</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>-->
      
      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
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

                <th width="6%" >
                  
                  <?php
				if($POST_ord == "VreId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VreId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VreId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="9%" >
                
                                <?php
				if($POST_ord == "VreFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VreFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VreFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="6%" ><?php
				if($POST_ord == "VreTieneGuia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VreTieneGuia','ASC');"> ¿Tiene Guia?<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreTieneGuia','DESC');"> ¿Tiene Guia? <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VreTieneGuia','ASC');"> ¿Tiene Guia? </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VreGuiaRemisionNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VreGuiaRemisionNumero','ASC');"> Num. Guia Remision <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreGuiaRemisionNumero','DESC');">  Num. Guia Remision <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VreGuiaRemisionNumero','ASC');">  Num. Guia Remision</a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
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
				if($POST_ord == "VmaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "VmoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmoNombre','DESC');"> Modelo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VmoNombre','ASC');"> Modelo </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "EinColor"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinColor','ASC');"> Color <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinColor','DESC');"> Color <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinColor','ASC');"> Color </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Responsable <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Responsable <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Responsable </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VreEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VreEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VreEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "VreTotalItems"){
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
                <th width="8%" >
                  <?php
				if($POST_ord == "VreTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('VreTiempoCreacion','ASC');">
                 Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VreTiempoCreacion','DESC');">
                    
                 Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('VreTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="13%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="15" align="center">

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

				  <option <?php if($POST_num==$VehiculoRecepcionesTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoRecepcionesTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoRecepcionesTotal;
					//}else{
					//	$tregistros = ($VehiculoRecepcionesTotalSeleccionado);
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
								foreach($ArrVehiculoRecepciones as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VreId; ?>" estado="<?php echo $dat->VreEstado; ?>" />				</td>

                <td align="right" valign="middle" width="6%"   >
				
                <a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VreId;?>"><?php echo $dat->VreId;  ?></a>
                
                
				</td>
                <td  width="9%" align="right" ><?php echo $dat->VreFecha;  ?></td>
                <td  width="6%" align="right" >
				
				<?php echo $dat->VreTieneGuia;?>
                <?php
				/*switch($dat->VreTieneGuia){
					case "1":
				?>
                Si
                <?php	
					break;
					
					case "":
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
				*/
				
				?>
                </td>
                <td  width="5%" align="right" ><?php echo ($dat->VreGuiaRemisionNumero);?></td>
                <td  width="7%" align="right" ><?php echo $dat->EinVIN?></td>
                <td  width="7%" align="right" >
                  
                  <?php echo $dat->VmaNombre?>
                  
                  
                </td>
                <td  width="8%" align="right" ><?php echo $dat->VmoNombre?></td>
                <td  width="8%" align="right" ><?php echo $dat->EinColor?></td>
                <td  width="8%" align="right" >
                  
                  <?php echo ($dat->PerNombre);?>
                  <?php echo ($dat->PerApellidoPaterno);?>
                  <?php echo ($dat->PerApellidoMaterno);?>
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->VreEstadoDescripcion;?>
                  <?php
				/*switch($dat->VreEstado){
					
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
                <td  width="4%" align="right" ><?php echo ($dat->VreTotalItems);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->VreTiempoCreacion);?></td>
        <td  width="13%" align="center" >
		
        
<?php
if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->VreId;?>&Ta=<?php echo $dat->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>

<?php
if($PrivilegioEliminar){
?> 
	<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VreId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php

	if($PrivilegioEditar){
?>
	<a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VreId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
	<a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VreId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->VreId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}
?>
        
<?php
if($PrivilegioImprimir){
?>        
	<a href="javascript:FncImprmir('<?php echo $dat->VreId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
<?php
}
?>
 
 <?php
 
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncGenerarPDF('<?php echo $dat->VreId;?>');"><img src="imagenes/pdf.gif" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
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

