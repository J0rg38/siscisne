<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoListaPrecio.js" ></script>

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

//Nuevo
$POST_VehiculoListaPrecioTipo = $_POST['CmpVehiculoListaPrecioTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VlpTiempoModificacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_cam)){
	$POST_cam = 'VmaNombre';
}

// Variables Extra
if(empty($POST_con)){
	$POST_con = "contiene";
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj('VehiculoListaPrecio').'MsjVehiculoListaPrecio.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecio.php');

//INSTANCIAS
$InsVehiculoListaPrecio = new ClsVehiculoListaPrecio();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoListaPrecio.php');
//DATOS

//MtdObtenerVehiculoListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VlpId',$oSentido = 'Desc',$oPaginacion = '0,10') {
$ResVehiculoListaPrecio = $InsVehiculoListaPrecio->MtdObtenerVehiculoListaPrecios("VlpId,VlpCodigo",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag);
$ArrVehiculoListaPrecios = $ResVehiculoListaPrecio['Datos'];
$VehiculoListaPreciosTotal = $ResVehiculoListaPrecio['Total'];
$VehiculoListaPreciosTotalSeleccionado = $ResVehiculoListaPrecio['TotalSeleccionado'];



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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE LISTAS DE PRECIOS DE VEHICULO</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $VehiculoListaPreciosTotalSeleccionado;?></b> de <b><?php echo $VehiculoListaPreciosTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="right">
  
<input type="hidden" name="CmpVehiculoListaPrecioTipo" id="CmpVehiculoListaPrecioTipo" value="" />
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
       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="VlpId" <?php if($POST_cam=="VlpId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="VlpCodigo" <?php if($POST_cam=="VlpCodigo"){ echo 'selected="selected"';}?>>Codigo</option>
       </select>-->

            
            Estado:
 <select class="EstFormularioCombo" name="Est" id="Est">
                <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
                <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
                <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
                </select>

		<!--<select name="Car" id="Car" class="EstFormularioCombo">
		  <option value=""  <?php if($POST_car==true){ echo 'selected="selected"';}?> >Listado Avanzado</option>
		  <option value="false"  <?php if($POST_car==false){ echo 'selected="selected"';}?>>Listado Simple </option>
	    </select>-->
	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
  <td width="87%" valign="top">
    
    
    
    
    
  <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="2%" >#</th>
        <th width="2%" >
          
          <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
        
        <th width="5%" ><?php
				if($POST_ord == "VlpId"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('VlpId','ASC');"> Id.  </a>
          <?php
				}
				?></th>
        <th width="9%" ><?php
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
        <th width="9%" ><?php
				if($POST_ord == "VlpAnoFabricacion"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpAnoFabricacion','ASC');"> A&ntilde;o Fabricacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpAnoFabricacion','DESC');"> A&ntilde;o Fabricacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VlpAnoFabricacion','ASC');"> A&ntilde;o Fabricacion </a>
          <?php
				}
				?></th>
        <th width="6%" ><?php
				if($POST_ord == "VlpFecha"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VlpFecha','ASC');"> Fecha </a>
          <?php
				}
				?></th>
        <th width="12%" ><?php
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
        <th width="5%" ><?php
				if($POST_ord == "VlpTipoCambio"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VlpTipoCambio','ASC');"> T.C. </a>
          <?php
				}
				?></th>
        <th width="11%" ><?php
				if($POST_ord == "VlpCodigo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpCodigo','ASC');"> Nro. Lista Dealer <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpCodigo','DESC');"> Nro. Lista Dealer <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VlpCodigo','ASC');"> Nro. Lista Dealer </a>
          <?php
				}
				?></th>
        <th width="9%" ><?php
				if($POST_ord == "VlpFechaVigencia"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpFechaVigencia','ASC');"> Vigencia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpFechaVigencia','DESC');"> Vigencia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('VlpFechaVigencia','ASC');"> Vigencia </a>
          <?php
				}
				?></th>
        <th width="9%" ><?php
				if($POST_ord == "VlpEstado"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('VlpEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('VlpEstado','ASC');"> Est. </a>
          <?php
				}
				?></th>
        <th width="7%" >
          <?php
				if($POST_ord == "VlpTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('VlpTiempoModificacion','ASC');">
            U.A.
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('VlpTiempoModificacion','DESC');">
            
            U.A.
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('VlpTiempoModificacion','ASC');">
            U.A.
            </a>
          
          <?php
				}
				?>			    </th>
        <th width="14%" >Acciones</th>
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
            <option <?php if($POST_num==$VehiculoListaPreciosTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoListaPreciosTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoListaPreciosTotal;
					//}else{
					//	$tregistros = ($VehiculoListaPreciosTotalSeleccionado);
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

								foreach($ArrVehiculoListaPrecios as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td width="2%" align="center"  >
        
        <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->VlpId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VlpId; ?>" />				</td>
      
      <td align="right" valign="middle" width="5%"   ><?php echo $dat->VlpId;  ?></td>
      <td width="9%" align="right" valign="middle"   ><?php echo $dat->VmaNombre; ?></td>
      <td width="9%" align="right" valign="middle"   ><?php echo $dat->VlpAnoFabricacion; ?></td>
      <td align="right" valign="middle" width="6%"   ><?php echo $dat->VlpFecha;  ?></td>
      <td align="right" valign="middle" width="12%"   ><?php echo $dat->MonNombre;  ?></td>
      <td align="right" valign="middle" width="5%"   ><?php echo $dat->VlpTipoCambio;  ?></td>
      <td align="right" valign="middle" width="11%"   ><?php echo $dat->VlpCodigo;  ?></td>
      <td  width="9%" align="right" ><?php echo $dat->VlpFechaVigencia; ?></td>
      <td  width="9%" align="right" >
        
        <?php
			switch($dat->VlpEstado){
				case 1:
			?>
        <img src="imagenes/activo.gif" alt="[Activo]" title="En actividad" width="20" height="20" />
        <?php
				break;
				
				case 2:
			?>
        <img src="imagenes/inactivo.gif" alt="[Inactivo]" title="Sin actividad" width="20" height="20" />
        <?php
				break;

			}
			?>
        
        
      </td>
      <td  width="7%" align="right" ><?php echo ($dat->VlpTiempoModificacion);?></td>
      <td  width="14%" align="center" >
        
        
  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VlpId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VlpId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VlpId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>



                  
<?php
if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->VlpId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}
?>
                  
<?php
if($PrivilegioImprimir){
?>        
	<a href="javascript:FncImprmir('<?php echo $dat->VlpId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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

<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

