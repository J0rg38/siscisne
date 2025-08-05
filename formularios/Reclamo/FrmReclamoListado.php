<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReclamo.js" ></script>

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
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_Moneda = "MON-10001";


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'RecTiempoCreacion';
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


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjReclamo.php');

require_once($InsPoo->MtdPaqActividad().'ClsReclamo.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsReclamo = new ClsReclamo();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsMoneda = new ClsMoneda();

$InsReclamo->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccReclamo.php');

																												//MtdObtenerReclamos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RecId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCodigoReclamo=NULL) {
$ResReclamo = $InsReclamo->MtdObtenerReclamos("PrvNombreCompleto,PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno,PrvNumeroDocumento,RecRespuestaNumero,RecId,AmoComprobanteNumero,OcoId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,$POST_CodigoReclamo);
$ArrReclamos = $ResReclamo['Datos'];
$ReclamosTotal = $ResReclamo['Total'];
$ReclamosTotalSeleccionado = $ResReclamo['TotalSeleccionado'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


//$InsMoneda->MonId = empty($POST_Moneda)?"MON-10001":$POST_Moneda;
//$InsMoneda->MtdObtenerMoneda();

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
            <div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
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



</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" valign="top">
    
    
  <span class="EstFormularioTitulo">LISTADO DE RECLAMOS</span>  </td>
  <td height="25" align="right" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="47%" valign="top">
    Mostrando <b><?php echo $ReclamosTotalSeleccionado;?></b> de <b><?php echo $ReclamosTotal;?></b> registros</td>
  <td width="53%" align="right" valign="top">
    
    
  </td>
</tr>
<tr>
  <td colspan="2" align="right" valign="top">
    
    <input type="hidden" name="Acc" id="Acc" value="" />
    <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
    <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
    <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
    <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
    
    <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
    
    
    <input class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>

       Moneda
    
    <select disabled="disabled" class="EstFormularioCombo" name="Moneda" id="Moneda">
                        <option value="">Todos</option>
                        <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                        <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                        <?php
			  }
			  ?>
                      </select>
                      
                      Cod. Reclamo:

<select tabindex="9" class="EstFormularioCombo" id="CodigoReclamo" name="CodigoReclamo">
<option value="">Todos</option>
<option <?php if($POST_CodigoReclamo=="F"){ echo 'selected="selected"';}?> value="F">F - Numero de Parte Faltante</option>
<option <?php if($POST_CodigoReclamo=="S"){ echo 'selected="selected"';}?> value="S">S - Numero de Parte Sobrante</option>
<option <?php if($POST_CodigoReclamo=="D"){ echo 'selected="selected"';}?> value="D">D -  Numero de Parte Da&ntilde;ado</option>
<option <?php if($POST_CodigoReclamo=="E"){ echo 'selected="selected"';}?> value="E">E - Numero de Parte Equivocado</option>
</select>

                                    
                                                  
                        

      Fecha Inicio:
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin:
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    
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

                <th width="3%" >
                  
                  <?php
				if($POST_ord == "RecId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" > <?php
				if($POST_ord == "RecFechaEmision"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecFechaEmision','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecFechaEmision','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecFechaEmision','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "RecCodigoReclamo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecCodigoReclamo','ASC');"> cod. Reclamo<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecCodigoReclamo','DESC');"> Cod. Reclamo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('RecCodigoReclamo','ASC');"> Cod. Reclamo </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "PrvNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. </a>
                  <?php
				}
				?></th>
                <th width="19%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Proveedor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Proveedor </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "RecCliente"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecCliente','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecCliente','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecCliente','ASC');"> Cliente </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "AmoComprobanteNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','ASC');"> Factura <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','DESC');"> Factura <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('AmoComprobanteNumero','ASC');"> Factura </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "OcoId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');"> Ord. Compra <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcoId','DESC');">  Ord. Compra <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcoId','ASC');">  Ord. Compra </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "RecTotal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecTotal','ASC');"> Total <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecTotal','DESC');"> Total <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecTotal','ASC');"> Total </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "RecRespuestaNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecRespuestaNumero','ASC');"> Resp. Num. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecRespuestaNumero','DESC');"> Resp. Num. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecRespuestaNumero','ASC');"> Resp. Num. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "RecRespuestaFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecRespuestaFecha','ASC');"> Resp. Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecRespuestaFecha','DESC');"> Resp. Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecRespuestaFecha','ASC');"> Resp. Fecha </a>
                <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "RecEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecEstado','ASC');">Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('RecEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="10%" ><?php
				if($POST_ord == "RecTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RecTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RecTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('RecTiempoCreacion','ASC');"> Fecha Creacion </a>
                <?php
				}
				?></th>
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

				  <option <?php if($POST_num==$ReclamosTotal){ echo 'selected="selected"';}?> value="<?php echo $ReclamosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ReclamosTotal;
					//}else{
					//	$tregistros = ($ReclamosTotalSeleccionado);
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
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Recal</a>
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
								foreach($ArrReclamos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->RecId; ?>" estado="<?php echo $dat->RecEstado;?>" />				</td>

                <td align="right" valign="middle" width="3%"   >
                  
                <span class="EstTablaListadoCodigo"><?php echo $dat->RecId;  ?></span></td>
                <td  width="5%" align="right" ><?php echo $dat->RecFechaEmision;  ?></td>
                <td width="7%" align="right" valign="middle"   ><?php echo $dat->RecCodigoReclamo;  ?></td>
                <td  width="5%" align="right" ><?php echo ($dat->PrvNumeroDocumento);?></td>
                <td width="19%" align="right" valign="middle"   ><?php echo $dat->PrvNombre; ?></td>
                <td  width="8%" align="right" ><?php echo ($dat->RecCliente);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->AmoComprobanteNumero);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->OcoId);?></td>
                <td  width="4%" align="right" >
                  
  <?php $dat->RecTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->RecTotal:($dat->RecTotal/$dat->RecTipoCambio));?>                          
  <?php echo number_format($dat->RecTotal,2);?>
                </td>
                <td  width="5%" align="right" ><?php echo ($dat->RecRespuestaNumero);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->RecRespuestaFecha);?></td>
                <td  width="3%" align="right" ><?php echo $dat->RecEstadoDescripcion;?></td>
                <td  width="10%" align="right" ><?php echo ($dat->RecTiempoCreacion);?></td>
                <td  width="11%" align="center" >
                  
  <?php
if($PrivilegioAuditoriaVer){
?>
                  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->RecId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>
                  
  <?php
if($PrivilegioEliminar){
?> 
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->RecId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
                  
  <?php
if($PrivilegioEditar){
?>	
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->RecId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
  <?php
}
?> 
                  
  <?php
if($PrivilegioVer){
?>		                
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->RecId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                  
  <?php
}
?>        
                  
  <?php
if($PrivilegioVistaPreliminar){
?>
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->RecId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
  <?php
}
?>
                  
  <?php
if($PrivilegioImprimir){
?> 
                  <a href="javascript:FncImprmir('<?php echo $dat->RecId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
  <?php
}
?>              
  <?php
if($PrivilegioGenerarExcel){
?>        

	<a href="javascript:FncPopUp('formularios/Reclamo/FrmReclamoGenerarExcel.php?Id=<?php echo $dat->RecId;?>&P=2',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/excel.png" alt="[Generar Excel]" title="Generar Excel" width="19" height="19" border="0" /></a>

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

