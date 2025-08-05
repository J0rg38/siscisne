<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionTalonario.js"></script>
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

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CrtTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjComprobanteRetencionTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');

$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteRetencionTalonario.php');

$ResComprobanteRetencionTalonario = $InsComprobanteRetencionTalonario->MtdObtenerComprobanteRetencionTalonarios($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$_SESSION['SisSucId']);
$ArrComprobanteRetencionTalonarios = $ResComprobanteRetencionTalonario['Datos'];
$ComprobanteRetencionTalonariosTotal = $ResComprobanteRetencionTalonario['Total'];
$ComprobanteRetencionTalonariosTotalSeleccionado = $ResComprobanteRetencionTalonario['TotalSeleccionado'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmComprobanteRetencionTalonarioListado {
    //put your code here  
}
*/

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    


<div class="EstCapMenu">

<?php
if($PrivilegioEliminar){
?>
<div class="EstSubMenuBoton">
<a href="javascript:FncEliminarSeleccionados();"><img src="imagenes/submenu/eliminar.png" alt="[Eliminar]" title="Eliminar elementos seleccionados" />Eliminar</a>
</div> <?php
}
?>
</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE TALONARIOS DE COMPROBANTE DE RETENCIONS</span></td>
</tr>

<tr>
  <td>
    Mostrando <b><?php echo $ComprobanteRetencionTalonariosTotalSeleccionado;?></b> de <b><?php echo $ComprobanteRetencionTalonariosTotal;?></b> registros.</td>
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


       <select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="CrtId" <?php if($POST_cam=="CrtId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="CrtNumero" <?php if($POST_cam=="CrtNumero"){ echo 'selected="selected"';}?>>Numero</option>
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

                <th width="9%" ><?php
				if($POST_ord == "CrtId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrtId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CrtId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="14%" ><?php
				if($POST_ord == "CrtNumero"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrtNumero','ASC');"> N&uacute;mero <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtNumero','DESC');"> N&uacute;mero <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrtNumero','ASC');"> N&uacute;mero  </a>
                  <?php
				}
				?></th>
                <th width="14%" ><?php
				if($POST_ord == "CrtInicio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrtInicio','ASC');"> Inicio <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtInicio','DESC');"> Inicio <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrtInicio','ASC');"> Inicio </a>
                <?php
				}
				?></th>
                <th width="30%" ><?php
				if($POST_ord == "CrtDescripcion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CrtDescripcion','ASC');"> Descripcion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtDescripcion','DESC');"> Descripcion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CrtDescripcion','ASC');"> Descripcion </a>
                  <?php
				}
				?></th>
                <th width="17%" >
                  <?php
				if($POST_ord == "CrtTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('CrtTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CrtTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('CrtTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> </a>
                  
                <?php
				}
				?>			    </th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="8" align="center">

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

				  <option <?php if($POST_num==$ComprobanteRetencionTalonariosTotal){ echo 'selected="selected"';}?> value="<?php echo $ComprobanteRetencionTalonariosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ComprobanteRetencionTalonariosTotal;
					//}else{
					//	$tregistros = ($ComprobanteRetencionTalonariosTotalSeleccionado);
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

								foreach($ArrComprobanteRetencionTalonarios as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->CrtId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->CrtId; ?>" />				</td>

                <td align="right" valign="middle" width="9%"   ><?php echo $dat->CrtId;  ?></td>
                <td align="right" valign="middle" width="14%"   ><?php echo $dat->CrtNumero; ?></td>
                <td  width="14%" align="right" ><?php echo $dat->CrtInicio; ?></td>
                <td  width="30%" align="right" ><?php echo $dat->CrtDescripcion; ?></td>
                <td  width="17%" align="right" ><?php echo ($dat->CrtTiempoCreacion);?></td>
        <td  width="12%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->CrtId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->CrtId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>


<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CrtId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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

