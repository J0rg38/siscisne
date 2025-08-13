<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
	$PrivilegioVer = true;
}else{
	$PrivilegioVer = false;
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
	$PrivilegioEditar = true;
}else{
	$PrivilegioEditar = false;
}
?>


<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar")){
	$PrivilegioEliminar = true;
}else{
	$PrivilegioEliminar = false;
}
?>

<script type="text/javascript" src="formularios/VehiculoCategoria/js/JsVehiculoCategoria.js"></script>

<script type="text/javascript">
$(document).ready(function (){
	
	function toncheck(id, state) {	
		document.getElementById('CmpCategoria').value = tree.getAllChecked();
	};
	 
	tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);
	 
	tree.setSkin('dhx_skyblue');
	tree.setImagePath("librerias/dhtmlxTree/dhtmlxTree/codebase/imgs/csh_bluebooks/");
	tree.enableCheckBoxes(1);
	tree.enableThreeStateCheckboxes(true);
	
	tree.setOnCheckHandler(toncheck);	
	
tree.loadXML("comunes/VehiculoCategoria/XmlVehiculoCategoria.php", function() {
    tree.loadOpenStates("CooVehiculoCategoria")
    });
	
});
</script>


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

$POST_cat = $_POST['CmpCategoria'];
$POST_car = $_POST['Car'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VcaTiempoModificacion';
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

if(empty($POST_cat)){
	$POST_cat = 0;
}
if(empty($POST_car)){
	$POST_car = true;
}else{
	$POST_car = false;
}

include($InsProyecto->MtdFormulariosMsj('VehiculoCategoria').'MsjVehiculoCategoria.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCategoria.php');

$InsVehiculoCategoria = new ClsVehiculoCategoria();

include('formularios/VehiculoCategoria/acc/AccVehiculoCategoria.php');

$RepVehiculoCategoria = $InsVehiculoCategoria->MtdObtenerVehiculoCategorias($POST_cam,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$POST_cat,false,$POST_car);
$ArrVehiculoCategorias = $RepVehiculoCategoria['Datos'];
$VehiculoCategoriasTotal = $RepVehiculoCategoria['Total'];
$VehiculoCategoriasTotalSeleccionado = $RepVehiculoCategoria['TotalSeleccionado'];

$RepProductoSubCategoria = $InsVehiculoCategoria->MtdObtenerVehiculoCategorias(NULL,NULL,"VcaNombre","ASC",1,NULL,NULL,true);
$ArrProductoSubCategorias = $RepProductoSubCategoria['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmVehiculoCategoriaListado {
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
  <td height="25" colspan="2"><span class="EstFormularioTitulo">LISTADO DE CATEGORIAS DE CATEGORIAS DE VEHICULO</span></td>
</tr>
<tr>
  <td colspan="2">
    Mostrando <b><?php echo $VehiculoCategoriasTotalSeleccionado;?></b> de <b><?php echo $VehiculoCategoriasTotal;?></b> registros.</td>
</tr>
<tr>
  <td colspan="2" align="right">
		
        <input type="hidden" name="CmpCategoria" id="CmpCategoria" value="" />
		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        <input class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />


       <select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="VcaId" <?php if($POST_cam=="VcaId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="VcaNombre" <?php if($POST_cam=="VcaNombre"){ echo 'selected="selected"';}?>>Nombre</option>
       </select>

<!--Categoria:
		<select class="EstFormularioCombo" id="CmpCategoria" name="CmpCategoria">
		  <option value="0" <?php if(empty($POST_cat)){ echo 'selected="selected"';}?>>Todos</option>
		  <?php 
		echo FncArbol($ArrProductoSubCategorias,0,false,$POST_cat,"VcaNombre","VcaId","ProductoSubCategoria");
		?>
	    </select>-->
         <select name="Car" id="Car" class="EstFormularioCombo">
           <option value=""  <?php if($POST_car==true){ echo 'selected="selected"';}?> >Listado Avanzado</option>
           <option value="false"  <?php if($POST_car==false){ echo 'selected="selected"';}?>>Listado Simple </option>
        </select>


	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
  <td width="18%" valign="top"><div id="treeboxbox_tree" style="width:200px; height:400px;background-color:#f5f5f5;border :1px solid Silver;  "/></td>
<td width="82%" valign="top">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="3%" >#</th>
                <th width="3%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="4%" ><?php
				if($POST_ord == "VcaId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VcaId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VcaId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('VcaId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="61%" ><?php
				if($POST_ord == "VcaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VcaNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VcaNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VcaNombre','ASC');"> Nombre  </a>
                  <?php
				}
				?></th>
                <th width="18%" >
				<?php
				if($POST_ord == "VcaTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>

				<a href="javascript:FncOrdenar('VcaTiempoModificacion','ASC');">
				U.A.
				<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
				<?php
					}else{
				?>
				<a href="javascript:FncOrdenar('VcaTiempoModificacion','DESC');">

				U.A.
				<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
				<?php
					}
				}else{

				?><a href="javascript:FncOrdenar('VcaTiempoModificacion','ASC');">
				U.A.
								</a>

				<?php
				}
				?>			    </th>
                <th width="11%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="6" align="center">

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

				  <option <?php if($POST_num==$VehiculoCategoriasTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoCategoriasTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoCategoriasTotal;
					//}else{
					//	$tregistros = ($VehiculoCategoriasTotalSeleccionado);
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

								foreach($ArrVehiculoCategorias as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="3%" align="center"  ><?php echo $f;?></td>
                <td width="3%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->VcaId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VcaId; ?>" />				</td>

                <td align="right" valign="middle" width="4%"   ><?php echo $dat->VcaId;  ?></td>
                <td align="right" valign="middle" width="61%"   ><?php echo $dat->VcaNombre; ?></td>
                <td  width="18%" align="right" ><?php echo ($dat->VcaTiempoModificacion);?></td>
        <td  width="11%" align="center" >

<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VcaId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>

<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->VcaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>


<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VcaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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

