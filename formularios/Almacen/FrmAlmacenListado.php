<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Especial"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacen.js" ></script>

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
//$POST_Sucursal = $_SESSION['SesionSucursal'];
$POST_Sucursal = $_POST['CmpSucursal'];

/*
* Otras variables
*/


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'AlmTiempoCreacion';
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

//MESAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacen.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
//INSTANCIAS
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacen.php');
//DATOS

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];
$AlmacenesTotal = $RepAlmacen['Total'];
$AlmacenesTotalSeleccionado = $RepAlmacen['TotalSeleccionado'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmAlmacenListado {
    //put your code here  
}
*/

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE ALMACENES</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $AlmacenesTotalSeleccionado;?></b> de <b><?php echo $AlmacenesTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="right">
		
        <input type="hidden" name="CmpCategoria" id="CmpCategoria" value="" />
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
    


       <select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="AlmId" <?php if($POST_cam=="AlmId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="AlmNombre" <?php if($POST_cam=="AlmNombre"){ echo 'selected="selected"';}?>>Nombre</option>
       </select>	  <span class="EstFormularioEtiqueta">   Sucursal:
       </span>
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
  <td width="82%" valign="top">
    
    
    
    
    
  <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="2%" >#</th>
        <th width="2%" >
          
          <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
        
        <th width="2%" ><?php
				if($POST_ord == "AlmId"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('AlmId','ASC');"> Id.  </a>
          <?php
				}
				?></th>
        <th width="12%" ><?php
				if($POST_ord == "SucNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SucNombre','DESC');"> Sucursal <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('SucNombre','ASC');"> Sucursal </a>
          <?php
				}
				?></th>
        <th width="12%" ><?php
				if($POST_ord == "AlmNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmNombre','ASC');"> Nombre  </a>
          <?php
				}
				?></th>
        <th width="13%" ><?php
				if($POST_ord == "AlmDireccion"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmDireccion','ASC');"> Direccion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmDireccion','DESC');"> Direccion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmDireccion','ASC');"> Direccion </a>
          <?php
				}
				?></th>
        <th width="6%" ><?php
				if($POST_ord == "AlmDistrito"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmDistrito','ASC');"> Distrito <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmDistrito','DESC');"> Distrito <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmDistrito','ASC');"> Distrito </a>
          <?php
				}
				?></th>
        <th width="7%" ><?php
				if($POST_ord == "AlmProvincia"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmProvincia','ASC');"> Provincia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmProvincia','DESC');"> Provincia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmProvincia','ASC');"> Provincia </a>
          <?php
				}
				?></th>
        <th width="10%" ><?php
				if($POST_ord == "AlmDepartamento"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmDepartamento','ASC');"> Departamento <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmDepartamento','DESC');"> Departamento <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmDepartamento','ASC');"> Departamento </a>
          <?php
				}
				?></th>
        <th width="7%" ><?php
				if($POST_ord == "AlmCodigoUbigeo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('AlmCodigoUbigeo','ASC');"> Cod. Ubigeo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmCodigoUbigeo','DESC');"> Cod. Ubigeo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('AlmCodigoUbigeo','ASC');"> Cod. Ubigeo </a>
          <?php
				}
				?></th>
        <th width="14%" >
          <?php
				if($POST_ord == "AlmTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('AlmTiempoCreacion','ASC');">
            Fecha Creacion
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('AlmTiempoCreacion','DESC');">
            
            Fecha Creacion
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('AlmTiempoCreacion','ASC');">
            Fecha Creacion
            </a>
          
          <?php
				}
				?>			    </th>
        <th width="13%" >Acciones</th>
        </tr>
      </thead>
    
    <tfoot class="EstTablaListadoFoot">
      
      <tr>
        
        <td colspan="12" align="center">
          
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
            <option <?php if($POST_num==$AlmacenesTotal){ echo 'selected="selected"';}?> value="<?php echo $AlmacenesTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $AlmacenesTotal;
					//}else{
					//	$tregistros = ($AlmacenesTotalSeleccionado);
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

								foreach($ArrAlmacenes as $dat){

								?>
      
      
      
      <tr id="Fila_<?php echo $f;?>">
        <td width="2%" align="center"  ><?php echo $f;?></td>
        <td width="2%" align="center"  >
          
          <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->AlmId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AlmId; ?>" />				</td>
        
        <td align="right" valign="middle" width="2%"   ><?php echo $dat->AlmId;  ?></td>
        <td width="12%" align="right" valign="middle"   ><?php echo $dat->SucNombre; ?></td>
        <td align="right" valign="middle" width="12%"   ><?php echo $dat->AlmNombre; ?></td>
        <td  width="13%" align="right" ><?php echo $dat->AlmDireccion; ?></td>
        <td  width="6%" align="right" ><?php echo $dat->AlmDistrito; ?></td>
        <td  width="7%" align="right" ><?php echo $dat->AlmProvincia; ?></td>
        <td  width="10%" align="right" ><?php echo $dat->AlmDepartamento; ?></td>
        <td  width="7%" align="right" ><?php echo $dat->AlmCodigoUbigeo; ?></td>
        <td  width="14%" align="right" ><?php echo ($dat->AlmTiempoCreacion);?></td>
        <td  width="13%" align="center" >
          
          <?php
if($PrivilegioEliminar){
?> 
          <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->AlmId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
          <?php
}
?>
          
          <?php
if($PrivilegioEditar){
?>
          <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->AlmId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
          <?php
}
?>
          
          
          <?php
if($PrivilegioVer){
?>
          <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->AlmId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
          <?php
}
?>
          
        
        <a target="_blank" href="migrar/TarStockCorregirStockAlmacen2.php?c=1&AlmacenId=<?php echo $dat->AlmId;?>&ProductoId="  >Corregir Stocks</a>
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

