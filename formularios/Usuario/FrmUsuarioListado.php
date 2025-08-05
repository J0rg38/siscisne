<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsUsuario.js"></script>

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

$POST_rol = $_POST['Rol'];
$POST_estado = $_POST['Estado'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'UsuTiempoModificacion';
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

if(empty($POST_rol)){
	$POST_rol = 0;
}

if(empty($POST_estado)){
	$POST_estado = 0;
}

settype($POST_rol,"string");

include('formularios/Usuario/msj/MsjUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once('paquetes/PaqAcceso/Clases/ClsRol.php');

$InsUsuario = new ClsUsuario();
$InsRol = new ClsRol();

include('formularios/Usuario/acc/AccUsuario.php');

$ResUsuario = $InsUsuario->MtdObtenerUsuarios("usu.UsuId,usu.UsuUsuario","contiene",$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$POST_estado,$POST_rol);
$ArrUsuarios = $ResUsuario['Datos'];
$UsuariosTotal = $ResUsuario['Total'];
$UsuariosTotalSeleccionado = $ResUsuario['TotalSeleccionado'];

$ResRol = $InsRol->MtdObtenerRoles(NULL,NULL,"RolId","Asc",NULL);
$ArrRoles = $ResRol['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmUsuarioListado {
    //put your code here  
}
*/

?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">
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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE USUARIOS </span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $UsuariosTotalSeleccionado;?></b> de <b><?php echo $UsuariosTotal;?></b> registros.</td>
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
      	<option value="UsuId" <?php if($POST_cam=="UsuId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="UsuUsuario" <?php if($POST_cam=="UsuUsuario"){ echo 'selected="selected"';}?>>Usuario</option>              
       </select>-->

		Rol
        <select class="EstFormularioCombo" name="Rol" id="Rol">
       <option value="0" >Todos</option> 
       <?php
	   foreach($ArrRoles as $DatRol){
	   ?>
       <option value="<?php echo $DatRol->RolId;?>" <?php if($POST_rol==$DatRol->RolId){ echo 'selected="selected"';}?>><?php echo $DatRol->RolNombre;?></option>
       <?php
	   }
	   ?>                
       </select>
       Estado
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>En actividad</option>
        <option value="2" <?php if($POST_estado==2){ echo 'selected="selected"';}?>>Sin actividad</option>        
        </select>

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td>





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="3%" ><?php
				if($POST_ord == "UsuId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UsuId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UsuId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('UsuId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="6%" >Foto</th>
                <th width="33%" ><?php
				if($POST_ord == "UsuUsuario"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','ASC');"> Usuario <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','DESC');"> Usuario <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UsuUsuario','ASC');"> Usuario  </a>
                  <?php
				}
				?></th>
                <th width="7%" >
                
                <?php
				if($POST_ord == "RolId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('RolId','ASC');"> Rol <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('RolId','DESC');"> Rol <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('RolId','ASC');"> Rol  </a>
                  <?php
				}
				?>                </th>
                <th width="7%" >
                
                <?php
				if($POST_ord == "UsuEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UsuEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UsuEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UsuEstado','ASC');"> Estado  </a>
                  <?php
				}
				?>                </th>
                <th width="19%" ><?php
				if($POST_ord == "UsuUltimaSesion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UsuUltimaSesion','ASC');"> Ultima Sesion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UsuUltimaSesion','DESC');"> Ultima Sesion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UsuUltimaSesion','ASC');"> Ultima Sesion </a>
                <?php
				}
				?></th>
                <th width="11%" >
				<?php
				if($POST_ord == "UsuTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>

				<a href="javascript:FncOrdenar('UsuTiempoModificacion','ASC');">
				U.A.
				<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
				<?php
					}else{
				?>
				<a href="javascript:FncOrdenar('UsuTiempoModificacion','DESC');">

				U.A.
				<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
				<?php
					}
				}else{

				?><a href="javascript:FncOrdenar('UsuTiempoModificacion','ASC');">
				U.A.
								</a>

				<?php
				}
				?>			    </th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="10" align="center">

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

				  <option <?php if($POST_num==$UsuariosTotal){ echo 'selected="selected"';}?> value="<?php echo $UsuariosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $UsuariosTotal;
					//}else{
					//	$tregistros = ($UsuariosTotalSeleccionado);
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

								foreach($ArrUsuarios as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->UsuId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->UsuId; ?>" />				</td>

                <td align="right" valign="middle" width="3%"   ><?php echo $dat->UsuId;  ?></td>
                <td align="right" valign="middle" width="6%"   >
                
            <?php            
if(!empty($dat->UsuFoto)){
	
	$extension = strtolower(pathinfo($dat->UsuFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->UsuFoto, '.'.$extension);  
?>

	<a href="subidos/usuario_fotos/<?php echo $dat->UsuFoto;?>" class="thickbox" title=""><img  src="subidos/usuario_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>" alt="<?php echo $nombre_base."_thumb2.".$extension;?>" width="25" height="25" class="tooltip" title="<?php echo $nombre_base."_thumb2.".$extension;?>" border="0"  /></a>



  
  
  
<?php	
}else{
?>
No hay FOTO
<?php	
}
?>
                
                </td>
                <td align="right" valign="middle" width="33%"   ><?php echo $dat->UsuUsuario; ?></td>
                <td  width="7%" align="right" >
			<?php echo $dat->RolNombre;?>					</td>
                <td  width="7%" align="right" >
				
			<?php
			switch($dat->UsuEstado){
				case 1:
			?>
                  <img src="imagenes/habilitado.gif" alt="[Habilitado]" title="Habilitado" width="20" height="20" />
                  <?php
				break;
				
				case 2:
			?>
                  <img src="imagenes/deshabilitado.gif" alt="[Deshabilitado]" title="Deshabilitado" width="20" height="20" />
                  <?php
				break;

			}
			?>   
			
			
			              </td>
                <td  width="19%" align="right" ><?php echo ($dat->UsuUltimaSesion);?></td>
                <td  width="11%" align="right" ><?php echo ($dat->UsuTiempoModificacion);?></td>
        <td  width="10%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->UsuId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>


<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->UsuId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->UsuId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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

