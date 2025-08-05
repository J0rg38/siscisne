<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMiembroDirectorio.js"></script>
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

$POST_Cargo = $_POST['Cargo'];
$POST_est = $_POST['Estado'];
$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'MdiTiempoModificacion';
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

if(empty($POST_con)){
	$POST_con = "contiene";
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjMiembroDirectorio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsMiembroDirectorio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsMiembroDirectorio = new ClsMiembroDirectorio();
$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccMiembroDirectorio.php');
//DATOS
$ResMiembroDirectorio = $InsMiembroDirectorio->MtdObtenerMiembroDirectorios($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,$POST_Cargo);
$ArrMiembroDirectorios = $ResMiembroDirectorio['Datos'];
$MiembroDirectoriosTotal = $ResMiembroDirectorio['Total'];
$MiembroDirectoriosTotalSeleccionado = $ResMiembroDirectorio['TotalSeleccionado'];

$ResTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $ResTipoDocumento['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmMiembroDirectorioListado {
    //put your code here  
}
*/

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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE MIEMBROS DEL DIRECTORIO</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $MiembroDirectoriosTotalSeleccionado;?></b> de <b><?php echo $MiembroDirectoriosTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">

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
      	<option value="MdiId" <?php if($POST_cam=="MdiId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="MdiNombre" <?php if($POST_cam=="MdiNombre"){ echo 'selected="selected"';}?>>Nombre</option>
        <option value="MdiApellidoPaterno" <?php if($POST_cam=="MdiApellidoPaterno"){ echo 'selected="selected"';}?>>Apellido Paterno</option>        
        <option value="MdiApellidoMaterno" <?php if($POST_cam=="MdiApellidoMaterno"){ echo 'selected="selected"';}?>>Apellido Materno</option>        
       </select>

		Cargo:
		<select class="EstFormularioCombo" name="Cargo" id="Cargo">
        <option value="0" <?php if($POST_est==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_est==1){ echo 'selected="selected"';}?>>Presidente</option>
        <option value="2" <?php if($POST_est==2){ echo 'selected="selected"';}?>>Director</option>        
        </select>
        
        
		Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if($POST_est==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_est==1){ echo 'selected="selected"';}?>>En actividad</option>
        <option value="2" <?php if($POST_est==2){ echo 'selected="selected"';}?>>Sin actividad</option>        
        </select>

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td>





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="4%" ><?php
				if($POST_ord == "MdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('MdiId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "MdiCargo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiCargo','ASC');"> Cargo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiCargo','DESC');"> Cargo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiCargo','ASC');"> Cargo </a>
                <?php
				}
				?></th>
                <th width="5%" >Foto</th>
                <th width="14%" ><?php
				if($POST_ord == "MdiNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiNombre','ASC');"> Nombre  </a>
                  <?php
				}
				?></th>
                <th width="9%" >
                  
                  <?php
				if($POST_ord == "MdiApellidoPaterno"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiApellidoPaterno','ASC');"> Ape. Paterno <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiApellidoPaterno','DESC');"> Ape. Paterno <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiApellidoPaterno','ASC');"> Ape. Paterno  </a>
                  <?php
				}
				?>                </th>
                <th width="9%" ><?php
				if($POST_ord == "MdiApellidoMaterno"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiApellidoMaterno','ASC');"> Ape. Materno <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiApellidoMaterno','DESC');"> Ape. Materno <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiApellidoMaterno','ASC');"> Ape. Materno </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "MdiEmail"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiEmail','ASC');"> Email <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiEmail','DESC');"> Email <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiEmail','ASC');"> Email </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "MdiTelefono"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiTelefono','ASC');"> Telef. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiTelefono','DESC');"> Telef. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiTelefono','ASC');"> Telef. </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "MdiCelular"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiCelular','ASC');"> Cel. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiCelular','DESC');"> Cel. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiCelular','ASC');"> Cel. </a>
                <?php
				}
				?></th>
                <th width="12%" ><?php
				if($POST_ord == "MdiDireccion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiDireccion','ASC');"> Direc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiDireccion','DESC');"> Direc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiDireccion','ASC');"> Direc. </a>
                <?php
				}
				?></th>
                <th width="3%" > <?php
				if($POST_ord == "MdiEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MdiEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MdiEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="7%" >
                  <?php
				if($POST_ord == "MdiTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('MdiTiempoModificacion','ASC');">
                  U.A.
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MdiTiempoModificacion','DESC');">
                    
                  U.A.
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('MdiTiempoModificacion','ASC');">
                  U.A.
                  				</a>
                  
                <?php
				}
				?>			    </th>
                <th width="7%" >Acciones</th>
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

				  <option <?php if($POST_num==$MiembroDirectoriosTotal){ echo 'selected="selected"';}?> value="<?php echo $MiembroDirectoriosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $MiembroDirectoriosTotal;
					//}else{
					//	$tregistros = ($MiembroDirectoriosTotalSeleccionado);
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

								foreach($ArrMiembroDirectorios as $dat){

								?>

          
          
          
          
          
          

              <tr  >
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->MdiId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->MdiId; ?>" />				
                
                </td>

                <td align="right" valign="middle"   ><?php echo $dat->MdiId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->MdiCargoDescripcion;  ?></td>
                <td align="right" valign="middle"   ><?php            
if(!empty($dat->MdiFoto)){
	
	$extension = strtolower(pathinfo($dat->MdiFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->MdiFoto, '.'.$extension);  
?>
  <a href="subidos/miembro_directorio_fotos/<?php echo $dat->MdiFoto;?>" class="thickbox" title="">
  <img border="0" class="tooltip"  src="subidos/miembro_directorio_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>"  /></a>
  <?php	
}else{
?>
                  No hay FOTO
  <?php	
}
?></td>
                <td align="right" valign="middle"   ><?php echo $dat->MdiNombre; ?></td>
                <td align="right" ><?php echo $dat->MdiApellidoPaterno; ?></td>
                <td align="right" ><?php echo $dat->MdiApellidoMaterno; ?></td>
                <td align="right" ><?php echo ($dat->MdiEmail);?></td>
                <td align="right" ><?php echo ($dat->MdiTelefono);?></td>
                <td align="right" ><?php echo ($dat->MdiCelular);?></td>
                <td align="right" ><?php echo ($dat->MdiDireccion);?></td>
                <td align="right" ><?php
			switch($dat->MdiEstado){
				case 1:
			?>
                  <img src="imagenes/activo.gif" alt="[Actividad]" title="En Actividad" width="20" height="20" />
                  <?php
				break;
				
				case 2:
			?>
                  <img src="imagenes/inactivo.gif" alt="[Baja]" title="Sin Actividad" width="20" height="20" />
                  <?php
				break;

			}
			?></td>
                <td align="right" ><?php echo ($dat->MdiTiempoModificacion);?></td>
        <td align="center" >

<?php
/*if($PrivilegioBorrar){
?>
<a href="javascript:FncBorrarSeleccionado('<?php echo $dat->MdiId;?>');"><img src="imagenes/borrar.gif" width="19" height="19" border="0" title="Borrar" alt="[Borrar]"   /></a>
<?php
}*/
?>

<?php
if($PrivilegioEliminar){
?>
          <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->MdiId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
          <?php
}
?>
<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->MdiId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->MdiId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

