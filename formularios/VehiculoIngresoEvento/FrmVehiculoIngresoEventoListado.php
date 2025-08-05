<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Especial"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioFichaIngresoRegistrar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Registrar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoEvento.js"></script>
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
$POST_Personal = $_POST['Personal'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

$POST_PersonalMecanico = $_POST['PersonalMecanico'];
$POST_TipoFecha = $_POST['TipoFecha'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VieTiempoModificacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_finicio)){
	$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_TipoFecha)){
	$POST_TipoFecha = "VieFecha";
}
if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngresoEvento.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoEvento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

//INSTANCAS
$InsVehiculoIngresoEvento = new ClsVehiculoIngresoEvento();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoEvento.php');
//DATOS



//MtdObtenerVehiculoIngresoEventos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VieId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oSucursal=NULL)
$ResVehiculoIngresoEvento = $InsVehiculoIngresoEvento->MtdObtenerVehiculoIngresoEventos("vib.VieId,vib.VieReferencia,ein.EinVIN,ein.EinPlaca,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre,vib.VmaNombre,vib.VmoNombre,vib.VveNombre,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliTelefono,cli.CliCelular","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,$POST_Personal,FncCambiaFechaAMysql($POST_finicio),(FncCambiaFechaAMysql($POST_ffin)),NULL,$POST_Sucursal);
$ArrVehiculoIngresoEventos = $ResVehiculoIngresoEvento['Datos'];
$VehiculoIngresoEventosTotal = $ResVehiculoIngresoEvento['Total'];
$VehiculoIngresoEventosTotalSeleccionado = $ResVehiculoIngresoEvento['TotalSeleccionado'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
$ArrAsesores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
$ArrTecnicos = $ResPersonal['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
    <img src="imagenes/submenu/pendiente.png" alt="[Act. Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div> 
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoRealizadoSeleccionados();">
    <img src="imagenes/submenu/realizado.png" alt="[Act. Realizado]" title="Actualizar a estado REALIZADO seleccionados" />Realizado</a></div>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/submenu/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    
    
    
    
<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/iconos/eliminar.png" alt="[Eliminar seleccionados]" title="Eliminar seleccionados" />Eliminar</a></div> 
<?php
}
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE INCIDENTE DE VEHICULOS</span></td>
</tr>

<tr>
  <td>
    Mostrando <b><?php echo $VehiculoIngresoEventosTotalSeleccionado;?></b> de <b><?php echo $VehiculoIngresoEventosTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">

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
    


       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="VieId" <?php if($POST_cam=="VieId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="VieNombre" <?php if($POST_cam=="VieNombre"){ echo 'selected="selected"';}?>>Numero</option>
       </select>-->
       
       Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /><span class="EstFormularioEtiqueta">Sucursal: </span>
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
<td>





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="3%" >#</th>
                <th width="3%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="3%" ><?php
				if($POST_ord == "VieId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VieId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VieId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VieId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VieFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VieFecha','ASC');"> Fecha  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VieFecha','DESC');"> Fecha  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VieFecha','ASC');"> Fecha  </a>
                <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "VieReferencia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VieReferencia','ASC');"> Referencia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VieReferencia','DESC');"> Referencia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VieReferencia','ASC');"> Referencia </a>
                  <?php
				}
				?></th>
                <th width="10%" ><?php
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
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VmaNombre','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VmaNombre','ASC');"> Marca  </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
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
                <th width="7%" ><?php
				if($POST_ord == "VveNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VveNombre','DESC');"> Version <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VveNombre','ASC');"> Version </a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Reportado por<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> Reportado por <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> Reportado por </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "VieEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VieEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VieEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VieEstado','ASC');"> Estado </a>
                <?php
				}
				?></th>
                <th width="18%" >
                  <?php
				if($POST_ord == "VieTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('VieTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VieTiempoCreacion','DESC');">
                    
                  Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('VieTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="13" align="center">

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

				  <option <?php if($POST_num==$VehiculoIngresoEventosTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoIngresoEventosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoIngresoEventosTotal;
					//}else{
					//	$tregistros = ($VehiculoIngresoEventosTotalSeleccionado);
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

								foreach($ArrVehiculoIngresoEventos as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="3%" align="center"  ><?php echo $f;?></td>
                <td width="3%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->VieId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VieId; ?>" />				</td>

                <td align="right" valign="middle" width="3%"   ><?php echo $dat->VieId;  ?></td>
                <td align="right" valign="middle" width="5%"   ><?php echo $dat->VieFecha;  ?></td>
                <td width="10%" align="right" valign="middle"   ><?php echo $dat->VieReferencia; ?></td>
                <td align="right" valign="middle" width="10%"   ><?php echo $dat->EinVIN; ?></td>
                <td align="right" valign="middle" width="7%"   ><?php echo $dat->VmaNombre; ?></td>
                <td width="7%" align="right" valign="middle"   ><?php echo $dat->VmoNombre; ?></td>
                <td width="7%" align="right" valign="middle"   ><?php echo $dat->VveNombre; ?></td>
                <td width="9%" align="right" valign="middle"   ><?php echo $dat->PerNombre; ?> <?php echo $dat->PerApellidoMaterno; ?> <?php echo $dat->PerApellidoPaterno; ?></td>
                <td  width="8%" align="right" >
                  
                  <?php echo $dat->VieEstadoIcono; ?>
                  <?php echo $dat->VieEstadoDescripcion; ?>
                  
                </td>
                <td  width="18%" align="right" ><?php echo ($dat->VieTiempoCreacion);?></td>
        <td  width="10%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VieId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VieId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>


<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VieId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>


   <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->VieId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->VieId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?> 
 
</td>
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



