<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico",$GET_form)){
?>

<?php $PrivilegioRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Registrar"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Editar"))?true:false;?>

<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoIT200.js" ></script>

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
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FinTiempoModificacion';
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

if(empty($POST_con)){
	$POST_con = "contiene";
}


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjInformeTecnico.php');

require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsInformeTecnico = new ClsInformeTecnico();
$InsFichaIngreso = new ClsFichaIngreso();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccInformeTecnico.php');

$ResInformeTecnico = $InsInformeTecnico->MtdObtenerInformeTecnicos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,"VMA-10018");
//$ResInformeTecnico = $InsFichaIngreso->MtdObtenerFichaIngresos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Prioridad,"MIN-10000");
$ArrInformeTecnicos = $ResInformeTecnico['Datos'];
$InformeTecnicosTotal = $ResInformeTecnico['Total'];
$InformeTecnicosTotalSeleccionado = $ResInformeTecnico['TotalSeleccionado'];

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
            






</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE INFORMES TECNICOS IT200</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $InformeTecnicosTotalSeleccionado;?></b> de <b><?php echo $InformeTecnicosTotal;?></b> registros</td>
  <td width="53%" align="right">
    
    
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
    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="IteId" <?php if($POST_cam=="IteId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="EinVIN" <?php if($POST_cam=="EinVIN"){ echo 'selected="selected"';}?>>VIN de Vehiculo</option>
      <option value="ItePropietario" <?php if($POST_cam=="ItePropietario"){ echo 'selected="selected"';}?>>Propietario</option>
s      </select>
<!--    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="2" <?php if($POST_estado==2){ echo 'selected="selected"';}?>>En Proceso</option>
      <option value="3" <?php if($POST_estado==3){ echo 'selected="selected"';}?>>Realizado</option>  
      </select>
      -->
      Prioridad
      
		<select  class="EstFormularioCombo" name="Prioridad" id="Prioridad">
      <option value="" >Todos</option>
		<option  <?php if($POST_estado==1){ echo 'selected="selected"';}?> value="1">Urgente</option>
		<option  <?php if($POST_estado==2){ echo 'selected="selected"';}?> value="2">Normal</option>
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
<td colspan="2"><table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
  <thead class="EstTablaListadoHead">
    <tr>
      <th width="1%" >#</th>
      <th width="1%" > <input onclick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" /></th>
      <th width="4%" > <?php
				if($POST_ord == "IteId"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteId','ASC');"> Id. </a>
        <?php
				}
				?></th>
      <th width="3%" > <?php
				if($POST_ord == "IteFecha"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteFecha','ASC');"> Fecha </a>
        <?php
				}
				?></th>
      <th width="4%" ><?php
				if($POST_ord == "IteFechaVenta"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteFechaVenta','ASC');"> Fec. Venta<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteFechaVenta','DESC');"> Fec. Venta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteFechaVenta','ASC');"> Fec. Venta </a>
        <?php
				}
				?></th>
      <th width="5%" ><?php
				if($POST_ord == "ItePropietario"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('ItePropietario','ASC');"> Propietario <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('ItePropietario','DESC');"> Propietario <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('ItePropietario','ASC');"> Propietario </a>
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
      <th width="10%" ><?php
				if($POST_ord == "IteMotor"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteMotor','ASC');"> Motor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteMotor','DESC');"> Motor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteMotor','ASC');"> Motor </a>
        <?php
				}
				?></th>
      <th width="10%" ><?php
				if($POST_ord == "IteTipoTransmision"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteTipoTransmision','ASC');"> Tip. Transm. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteTipoTransmision','DESC');"> Tip. Transm. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteTipoTransmision','ASC');"> Tip. Transm. </a>
        <?php
				}
				?></th>
      <th width="10%" ><?php
				if($POST_ord == "IteTipoCarroceria"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteTipoCarroceria','ASC');"> Tip. Carroc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteTipoCarroceria','DESC');"> Tip. Carroc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteTipoCarroceria','ASC');"> Tip. Carroc. </a>
        <?php
				}
				?></th>
      <th width="10%" ><?php
				if($POST_ord == "IteCarga"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteCarga','ASC');"> Carga/Tara <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteCarga','DESC');"> Carga/Tara <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteCarga','ASC');"> Carga/Tara </a>
        <?php
				}
				?></th>
      <th width="3%" ><?php
				if($POST_ord == "FinVehiculoKilometraje"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('FinVehiculoKilometraje','DESC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{


				?>
        <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span></a>
        <?php
				}
				?></th>
      <th width="4%" ><?php
				if($POST_ord == "IteCiudad"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteCiudad','ASC');"> Ciudad <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteCiudad','DESC');"> Ciudad <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteCiudad','ASC');"> Ciudad</a>
        <?php
				}
				?></th>
      <th width="4%" ><?php
				if($POST_ord == "IteDepartamento"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteDepartamento','ASC');"> Departamento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteDepartamento','DESC');"> Departamento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteDepartamento','ASC');"> Departamento</a>
        <?php
				}
				?></th>
      <th width="4%" ><?php
				if($POST_ord == "IteUsoVehiculo"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteUsoVehiculo','ASC');"> Uso Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteUsoVehiculo','DESC');"> Uso Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteUsoVehiculo','ASC');"> Uso Veh.</a>
        <?php
				}
				?></th>
      <th width="4%" ><?php
				if($POST_ord == "IteAltitud"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteAltitud','ASC');"> Altitud M.S.N.M <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteAltitud','DESC');"> Altitud M.S.N.M <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteAltitud','ASC');"> Altitud M.S.N.M </a>
        <?php
				}
				?></th>
      <th width="11%" ><?php
				if($POST_ord == "IteTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
        <a href="javascript:FncOrdenar('IteTiempoCreacion','ASC');"> Fecha de Registro <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
        <?php
					}else{
				?>
        <a href="javascript:FncOrdenar('IteTiempoCreacion','DESC');"> Fecha de Registro <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
        <?php
					}
				}else{

				?>
        <a href="javascript:FncOrdenar('IteTiempoCreacion','ASC');"> Fecha de Registro </a>
        <?php
				}
				?></th>
      <th width="9%" >Acciones</th>
    </tr>
  </thead>
  <tfoot class="EstTablaListadoFoot">
    <tr>
      <td colspan="18" align="center"> Mostrar de
        <select class="EstFormularioCombo" onchange="javascript:FncListar(this.value);" name="Num" id="Num">
          <option <?php if($POST_num=="5"){ echo 'selected="selected"';}?> value="5">5</option>
          <option <?php if($POST_num=="10"){ echo 'selected="selected"';}?> value="10">10</option>
          <option <?php if($POST_num=="15"){ echo 'selected="selected"';}?> value="15">15</option>
          <option <?php if($POST_num=="20"){ echo 'selected="selected"';}?> value="20">20</option>
          <option <?php if($POST_num=="25"){ echo 'selected="selected"';}?> value="25">25</option>
          <option <?php if($POST_num=="30"){ echo 'selected="selected"';}?> value="30">30</option>
          <option <?php if($POST_num=="50"){ echo 'selected="selected"';}?> value="50">50</option>
          <option <?php if($POST_num=="100"){ echo 'selected="selected"';}?> value="100">100</option>
          <option <?php if($POST_num==$InformeTecnicosTotal){ echo 'selected="selected"';}?> value="<?php echo $InformeTecnicosTotal;?>">Todos</option>
        </select>
        <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $InformeTecnicosTotal;
					//}else{
					//	$tregistros = ($InformeTecnicosTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>
        <?php
					if($POST_p<>"1"){
					?>
        <a class="EstPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');"> Inicio </a>
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
        Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?></td>
    </tr>
  </tfoot>
  <tbody class="EstTablaListadoBody">
    <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrInformeTecnicos as $dat){

								?>
    <tr id="Fila_<?php echo $f;?>">
      <td width="1%" align="center"  ><?php echo $f;?></td>
      <td width="1%" align="center"  ><input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->IteId; ?>" /></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->IteId;  ?></td>
      <td  width="3%" align="right" ><?php echo $dat->IteFecha;  ?></td>
      <td  width="4%" align="right" ><?php echo $dat->IteFechaVenta;  ?></td>
      <td  width="5%" align="right" ><?php echo ($dat->ItePropietario);?></td>
      <td  width="3%" align="right" ><?php echo ($dat->EinVIN);?></td>
      <td  width="10%" align="right" ><?php echo ($dat->IteMotor);?></td>
      <td  width="10%" align="right" ><?php echo ($dat->IteTipoTransmision);?></td>
      <td  width="10%" align="right" ><?php echo ($dat->IteTipoCarroceria);?></td>
      <td  width="10%" align="right" ><?php echo ($dat->IteCarga);?></td>
      <td  width="3%" align="right" ><?php echo ($dat->FinVehiculoKilometraje);?></td>
      <td  width="4%" align="right" ><?php echo ($dat->IteCiudad);?></td>
      <td  width="4%" align="right" ><?php echo ($dat->IteDepartamento);?></td>
      <td  width="4%" align="right" ><?php echo ($dat->IteUsoVehiculo);?></td>
      <td  width="4%" align="right" ><?php echo ($dat->IteAltitud);?></td>
      <td  width="11%" align="right" ><?php echo ($dat->IteTiempoCreacion);?></td>
      <td  width="9%" align="center" ><?php
/*if($PrivilegioAuditoriaVer){
?>
  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->IteId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}*/
?>
        <?php
if($PrivilegioEliminar){
?>
        <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->IteId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
        <?php
}
?>
        <?php
if($PrivilegioEditar){
?>
        <a href="principal.php?Mod=<?php echo $GET_mod;?>&amp;Form=Editar&amp;Id=<?php echo $dat->IteId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
        <?php
}
?>
        <?php
if($PrivilegioVer){
?>
        <a href="principal.php?Mod=<?php echo $GET_mod;?>&amp;Form=Ver&amp;Id=<?php echo $dat->IteId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
        <?php
}
?>
        <?php
if($PrivilegioVistaPreliminar){
?>
        <a href="javascript:FncVistaPreliminar('<?php echo $dat->IteId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        <?php
}
?>
        <?php
if($PrivilegioImprimir){
?>
        <a href="javascript:FncImprmir('<?php echo $dat->IteId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
        <?php
}
?></td>
    </tr>
    <?php		$f++;

									
								

                
                
									

									}
									
		

									?>
  </tbody>
</table></td>
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

