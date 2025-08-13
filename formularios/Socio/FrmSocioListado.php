<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSocio.js"></script>
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

$POST_TipoDocumento = $_POST['CmpTipoDocumento'];
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'SocTiempoModificacion';
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
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjSocio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsSocio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsSocio = new ClsSocio();
$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccSocio.php');
//DATOS
$ResSocio = $InsSocio->MtdObtenerSocios($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est);
$ArrSocios = $ResSocio['Datos'];
$SociosTotal = $ResSocio['Total'];
$SociosTotalSeleccionado = $ResSocio['TotalSeleccionado'];

$ResTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $ResTipoDocumento['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmSocioListado {
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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE SOCIOS</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $SociosTotalSeleccionado;?></b> de <b><?php echo $SociosTotal;?></b> registros.</td>
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
      	<option value="SocId" <?php if($POST_cam=="SocId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="SocNombre" <?php if($POST_cam=="SocNombre"){ echo 'selected="selected"';}?>>Nombre</option>
        <option value="SocApellidoPaterno" <?php if($POST_cam=="SocApellidoPaterno"){ echo 'selected="selected"';}?>>Apellido Paterno</option>        
        <option value="SocApellidoMaterno" <?php if($POST_cam=="SocApellidoMaterno"){ echo 'selected="selected"';}?>>Apellido Materno</option>        
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

                <th width="6%" ><?php
				if($POST_ord == "SocId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('SocId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" >Foto</th>
                <th width="17%" ><?php
				if($POST_ord == "SocNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocNombre','ASC');"> Nombre  </a>
                  <?php
				}
				?></th>
                <th width="9%" >
                  
                  <?php
				if($POST_ord == "SocApellidoPaterno"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocApellidoPaterno','ASC');"> Ape. Paterno <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocApellidoPaterno','DESC');"> Ape. Paterno <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocApellidoPaterno','ASC');"> Ape. Paterno  </a>
                  <?php
				}
				?>                </th>
                <th width="9%" ><?php
				if($POST_ord == "SocApellidoMaterno"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocApellidoMaterno','ASC');"> Ape. Materno <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocApellidoMaterno','DESC');"> Ape. Materno <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocApellidoMaterno','ASC');"> Ape. Materno </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "SocEmail"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocEmail','ASC');"> Email <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocEmail','DESC');"> Email <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocEmail','ASC');"> Email </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "SocTelefono"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocTelefono','ASC');"> Telef. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocTelefono','DESC');"> Telef. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocTelefono','ASC');"> Telef. </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "SocCelular"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocCelular','ASC');"> Cel. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocCelular','DESC');"> Cel. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocCelular','ASC');"> Cel. </a>
                <?php
				}
				?></th>
                <th width="12%" ><?php
				if($POST_ord == "SocDireccion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocDireccion','ASC');"> Direc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocDireccion','DESC');"> Direc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocDireccion','ASC');"> Direc. </a>
                <?php
				}
				?></th>
                <th width="3%" > <?php
				if($POST_ord == "SocEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('SocEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('SocEstado','ASC');"> Est. </a>
                  <?php
				}
				?></th>
                <th width="7%" >
                  <?php
				if($POST_ord == "SocTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('SocTiempoModificacion','ASC');">
                  U.A.
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('SocTiempoModificacion','DESC');">
                    
                  U.A.
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('SocTiempoModificacion','ASC');">
                  U.A.
                  				</a>
                  
                <?php
				}
				?>			    </th>
                <th width="8%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="14" align="center">

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

				  <option <?php if($POST_num==$SociosTotal){ echo 'selected="selected"';}?> value="<?php echo $SociosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $SociosTotal;
					//}else{
					//	$tregistros = ($SociosTotalSeleccionado);
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

								foreach($ArrSocios as $dat){

								?>

          
          
          
          
          
          

              <tr  >
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->SocId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->SocId; ?>" />				
                
                </td>

                <td align="right" valign="middle"   ><?php echo $dat->SocId;  ?></td>
                <td align="right" valign="middle"   ><?php            
if(!empty($dat->SocFoto)){
	
	$extension = strtolower(pathinfo($dat->SocFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->SocFoto, '.'.$extension);  
?>
  <a href="subidos/socio_fotos/<?php echo $dat->SocFoto;?>" class="thickbox" title="">
  <img border="0" class="tooltip"  src="subidos/socio_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>"  /></a>
  <?php	
}else{
?>
                  No hay FOTO
  <?php	
}
?></td>
                <td align="right" valign="middle"   ><?php echo $dat->SocNombre; ?></td>
                <td align="right" ><?php echo $dat->SocApellidoPaterno; ?></td>
                <td align="right" ><?php echo $dat->SocApellidoMaterno; ?></td>
                <td align="right" ><?php echo ($dat->SocEmail);?></td>
                <td align="right" ><?php echo ($dat->SocTelefono);?></td>
                <td align="right" ><?php echo ($dat->SocCelular);?></td>
                <td align="right" ><?php echo ($dat->SocDireccion);?></td>
                <td align="right" ><?php
			switch($dat->SocEstado){
				case 1:
			?>
                  <img src="imagenes/activo.gif" alt="[Actividad]" title="En Actividad" width="20" height="20" />
                  <?php
				break;
				
				case 2:
			?>
                  <img src="imagenes/inactivo.gif" alt="[Baja]" title="De Baja" width="20" height="20" />
                  <?php
				break;

			}
			?></td>
                <td align="right" ><?php echo ($dat->SocTiempoModificacion);?></td>
        <td align="center" >

<?php
/*if($PrivilegioBorrar){
?>
<a href="javascript:FncBorrarSeleccionado('<?php echo $dat->SocId;?>');"><img src="imagenes/borrar.gif" width="19" height="19" border="0" title="Borrar" alt="[Borrar]"   /></a>
<?php
}*/
?>

<?php
if($PrivilegioEliminar){
?>
          <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->SocId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
          <?php
}
?>
<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->SocId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->SocId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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

