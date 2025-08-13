<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php //$PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php //$PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php //$PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php //$PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php //$PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPlanMantenimiento.js" ></script>

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
$POST_sen = ($_POST['Sen'] ?? '');
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num'] ?? '');

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

$POST_VehiculoMarca = $_POST['VehiculoMarca'];

/*
* Otras variables
*/
//$POST_estado = $_POST['Estado'];
//$POST_finicio = $_POST['FechaInicio'];
//$POST_ffin = $_POST['FechaPma'];
//$POST_con = $_POST['Con'];
//$POST_Prioridad = $_POST['Prioridad'];
//$POST_Modalidad = $_POST['Modalidad'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PmaTiempoModificacion';
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

//if(empty($POST_finicio)){
//	$POST_finicio = "01/".date("m/Y");
//}

//if(empty($POST_ffin)){
//	$POST_ffin = date("d/m/Y");
//}

if(empty($POST_con)){
	$POST_con = "contiene";
}


//include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPlanMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');


$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsVehiculoMarca = new ClsVehiculoMarca();

//include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPlanMantenimiento.php');

//MtdObtenerPlanMantenimientos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL) 
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos("pma.PmaId,pma.PmaNombre,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,NULL,NULL,$POST_VehiculoMarca);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
$PlanMantenimientosTotal = $ResPlanMantenimiento['Total'];
$PlanMantenimientosTotalSeleccionado = $ResPlanMantenimiento['TotalSeleccionado'];


$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>




<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">
<?php
/*  if($PrivilegioGenerarExcel){
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
}*/
?>






</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO DE PLANES DE MANTENIMIENTO</span>  </td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $PlanMantenimientosTotalSeleccionado;?></b> de <b><?php echo $PlanMantenimientosTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
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
    <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="PmaId" <?php if($POST_cam=="PmaId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="PmaNombre" <?php if($POST_cam=="PmaNombre"){ echo 'selected="selected"';}?>>Nombre</option>
      </select>-->
Marca:
<select class="EstFormularioCombo" name="VehiculoMarca" id="VehiculoMarca" >
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$POST_VehiculoMarca)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                <?php
			}
			?>
              </select>
    
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

                <th width="2%" >
                  
                  <?php
				if($POST_ord == "PmaId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PmaId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PmaId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PmaId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="26%" ><?php
				if($POST_ord == "PmaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PmaNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PmaNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PmaNombre','ASC');"> Nombre </a>
                <?php
				}
				?></th>
                <th width="14%" ><?php
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
                <th width="12%" ><?php
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
                <th width="9%" ><?php
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
                <th width="11%" ><?php
				if($POST_ord == "PmaTareaProducto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PmaTareaProducto','ASC');"> Predeterminados <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PmaTareaProducto','DESC');"> Predeterminados <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PmaTareaProducto','ASC');"> Predeterminados </a>
                <?php
				}
				?></th>
                <th width="13%" ><?php
				if($POST_ord == "PmaTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PmaTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PmaTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PmaTiempoCreacion','ASC');"> Fecha Creacion </a>
                <?php
				}
				?></th>
                <th width="9%" >Acciones</th>
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

				  <option <?php if($POST_num==$PlanMantenimientosTotal){ echo 'selected="selected"';}?> value="<?php echo $PlanMantenimientosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $PlanMantenimientosTotal;
					//}else{
					//	$tregistros = ($PlanMantenimientosTotalSeleccionado);
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
						<a class="EstPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Pmaal</a>
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

								foreach($ArrPlanMantenimientos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PmaId; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   ><?php echo $dat->PmaId;  ?></td>
                <td  width="26%" align="right" ><?php echo ($dat->PmaNombre);?></td>
                <td  width="14%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="12%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="11%" align="center" ><?php echo ($dat->PmaTareaProducto);?></td>
                <td  width="13%" align="center" ><?php echo ($dat->PmaTiempoCreacion);?></td>
                <td  width="9%" align="center" >
                  
                  
                  <?php
/*if($PrivilegioAuditoriaVer){
?>
  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->PmaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  
  <?php
if($PrivilegioEliminar){
?>
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PmaId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Pmapletamente"   /></a>
  <?php
}
?>               
                  
  <?php
if($PrivilegioEditar){
?>             
                  
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->PmaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
                  
  <?php
}*/
?>				

<?php
if($PrivilegioEditar){
?>             
	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->PmaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
<?php
}
?>				
                  
<?php
if($PrivilegioVer){
?>		                
	<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PmaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>         
    
    
    <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=VerProducto&Id=<?php echo $dat->PmaId;?>"><img src="imagenes/acciones/ver_producto.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
<?php
}
?>

                  
                  
                  <?php
			/*if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncVistaPreliminar('<?php echo $dat->PmaId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            

                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>        

     <a href="javascript:FncImprmir('<?php echo $dat->PmaId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>

                  <?php
			}*/
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

