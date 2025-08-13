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

<?php $PrivilegioOrdenCompraGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenCodificacion","GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCodificacion.js" ></script>
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
$POST_Moneda = $_POST['Moneda'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'OciTiempoCreacion';
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


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCodificacion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsOrdenCodificacion = new ClsOrdenCodificacion();
$InsMoneda = new ClsMoneda();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCodificacion.php');

//MtdObtenerOrdenCodificacions($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL) {
$ResOrdenCodificacion = $InsOrdenCodificacion->MtdObtenerOrdenCodificaciones("oco.OciId,PrvNombreCompleto,PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno,PrvNumeroDocumento",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,0,NULL,NULL);
$ArrOrdenCodificacions = $ResOrdenCodificacion['Datos'];
$OrdenCodificacionsTotal = $ResOrdenCodificacion['Total'];
$OrdenCodificacionsTotalSeleccionado = $ResOrdenCodificacion['TotalSeleccionado'];

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

 
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE CONSULTAS PNG</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $OrdenCodificacionsTotalSeleccionado;?></b> de <b><?php echo $OrdenCodificacionsTotal;?></b> registros.</td>
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
      <option value="OciId" <?php if($POST_cam=="OciId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="PrvNombre" <?php if($POST_cam=="PrvNombre"){ echo 'selected="selected"';}?>>Proveedor</option>
      <option value="PrvNumeroDocumento" <?php if($POST_cam=="PrvNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. Proveedor</option>
      
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
    
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onPrvck="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >
                  
                <input onPrvck="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" >
                  
                  <?php
				if($POST_ord == "OciId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciId','ASC');"> Id.  </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OciFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciFecha','ASC');"> Fecha  </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "OciFechaRespuesta"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciFechaRespuesta','ASC');"> Fecha Respuesta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciFechaRespuesta','DESC');"> Fecha Respuesta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciFechaRespuesta','ASC');"> Fecha Respuesta </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "TdoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','DESC');"> Tipo Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
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
                <th width="12%" ><?php
				if($POST_ord == "PrvNombreCompleto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombreCompleto','ASC');"> Proveedor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombreCompleto','DESC');"> Proveedor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PrvNombreCompleto','ASC');"> Proveedor </a>
                <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "OciSolicitante"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciSolicitante','ASC');"> Solicitante <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciSolicitante','DESC');"> Solicitante <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciSolicitante','ASC');"> Solicitante </a>
                  <?php
				}
				?></th>
                <th width="17%" ><?php
				if($POST_ord == "OciDescripcionPN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciDescripcionPN','ASC');"> Descripcion PN <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciDescripcionPN','DESC');"> Descripcion PN <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciDescripcionPN','ASC');"> Descripcion PN </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "OciVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciVIN','ASC');"> VIN <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciVIN','DESC');"> VIN  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciVIN','ASC');"> VIN  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "OciVehiculoModelo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OciVehiculoModelo','ASC');"> Año <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciVehiculoModelo','DESC');"> Año <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OciVehiculoModelo','ASC');"> Año </a>
                  <?php
				}
				?></th>
                <th width="3%" ><span title="Foto de Referencia">Foto</span></th>
                <th width="10%" >
                  <?php
				if($POST_ord == "OciTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('OciTiempoCreacion','ASC');">
                Fecha Registro
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OciTiempoCreacion','DESC');">
                    
                Fecha Registro
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('OciTiempoCreacion','ASC');">
                  Fecha Registro
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="15%" >Acciones</th>
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

				  <option <?php if($POST_num==$OrdenCodificacionsTotal){ echo 'selected="selected"';}?> value="<?php echo $OrdenCodificacionsTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $OrdenCodificacionsTotal;
					//}else{
					//	$tregistros = ($OrdenCodificacionsTotalSeleccionado);
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
								foreach($ArrOrdenCodificacions as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center" bgcolor="<?php echo ($dat->OciProcesadoProveedor==1?'#009933':'');?>"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >



<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->OciId; ?>" cotizacion="<?php echo $dat->CprId;?>" estado="<?php echo $dat->OciEstado;?>" moneda="<?php echo $dat->MonId;?>" orden_compra="<?php echo $dat->OciId;?>" />				



</td>

                <td align="right" valign="middle" width="2%"   >
				
				 <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->OciId;?>">
				 <?php echo $dat->OciId;  ?>
                 </a>
                 </td>
                <td  width="5%" align="right" ><?php echo ($dat->OciFecha);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->OciFechaRespuesta);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->TdoNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->PrvNumeroDocumento);?></td>
                <td  width="12%" align="right" >
                  
                  
                  <?php echo $dat->PrvNombre;?> <?php echo $dat->PrvApellidoPaterno;?> <?php echo $dat->PrvApellidoMaterno;?>
                  
                  
                </td>
                <td  width="8%" align="right" ><?php echo ($dat->PerNombre);?> <?php echo ($dat->PerApellidoPaterno);?> <?php echo ($dat->PerApellidoMaterno);?></td>
                <td  width="17%" align="right" ><?php echo ($dat->OciDescripcionPN);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OciVIN);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OciVehiculoAnoFabricacion);?></td>
                <td  width="3%" align="center" ><?php
if(!empty($dat->OciFoto)){
?>
                  <!--<a target="_blank" href="subidos/orden_codificacion_fotos/<?php echo $dat->OciFoto;?>" class="thickbox" ><img src="imagenes/foto.jpg" alt="Foto" width="30" height="30" border="0" title="Foto de Referencia" /></a></td>-->
                  <a target="_blank" href="subidos/orden_codificacion_fotos/<?php echo $dat->OciFoto;?>" ><img src="imagenes/foto.jpg" alt="Foto" width="25" height="25" border="0" title="Foto de Referencia" /></a>
                  <?php
}
?></td>
                <td  width="10%" align="right" ><?php echo ($dat->OciTiempoCreacion);?></td>
        <td  width="15%" align="center" >

<?php
if($PrivilegioAuditoriaVer){
?>
<a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->OciId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>

<?php
//if($PrivilegioEliminar  and ( ($dat->OciEstado <> 1 or $dat->OciEstado <> 3) or empty($dat->OciEstado)) ){
//if($PrivilegioEliminar  and  (  $dat->OciEstado==1 ) ){
	if($PrivilegioEliminar  ){
?>


<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->OciId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Completamente"   /></a>
<?php
}
?>               
				
<?php
if($PrivilegioEditar ){
//if($PrivilegioEditar and ( ($dat->OciEstado <> 1 or $dat->OciEstado <> 3) or empty($dat->OciEstado)) ){
//	if($PrivilegioEliminar  and  (empty($dat->OciId) or (!empty($dat->OciId) and $dat->OciEstado==1) ) ){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->OciId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->OciId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}
?>

	
 <?php
/*if($PrivilegioVer){
?>		
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=VerEstado&Id=<?php echo $dat->OciId;?>"><img src="imagenes/acciones/ver_estado.png" alt="[P.C. Estado]" title="P.C. Estado" width="19" height="19" border="0" /></a>   

<?php
}*/
?>


<?php
//if($PrivilegioOrdenCompraGenerarExcel and $dat->OciEstado == 3){
if($PrivilegioOrdenCompraGenerarExcel ){
?>        

	<a href="javascript:FncPopUp('formularios/OrdenCodificacion/FrmOrdenCodificacionGenerarExcel.php?Id=<?php echo $dat->OciId;?>&P=2&Enviado=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/excel.png" alt="[Generar Excel]" title="Generar Excel" width="19" height="19" border="0" /></a>

<?php
}
?> 

<?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('formularios/OrdenCodificacion/FrmOrdenCodificacionImprimir.php?Id=<?php echo $dat->OciId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('formularios/OrdenCodificacion/FrmOrdenCodificacionImprimir.php?Id=<?php echo $dat->OciId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
  


<?php
if($PrivilegioEditar){
?>             
                      
<a href="principal.php?Mod=OrdenCodificacion&Form=EnviarCorreo&Id=<?php echo $dat->OciId;?>"><img src="imagenes/acciones/enviar_correo.png" width="19" height="19" border="0" title="Enviar Correo" alt="[Enviar Correo]"   /></a>                 
				
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

