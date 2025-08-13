<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioListaPrecioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Ver"))?true:false;?>
<?php $PrivilegioListaPrecioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProducto.js" ></script>

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

//Nuevo
$POST_ProductoTipo = $_POST['CmpProductoTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}

//	$POST_num = '1500';
	
if(empty($POST_ord)){
	$POST_ord = 'ProTiempoModificacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

//$POST_pag = '822,1500';

if(empty($POST_cam)){
	$POST_cam = "ProNombre";
}

// Variables Extra

if(empty($POST_con)){
	$POST_con = "contiene";
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProducto.php');

$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId,ProUbicacion,ProReferencia,RtiNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,$POST_ProductoTipo,NULL);
$ArrProductos = $ResProducto['Datos'];
$ProductosTotal = $ResProducto['Total'];
$ProductosTotalSeleccionado = $ResProducto['TotalSeleccionado'];

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmProductoListado {
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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE PRODUCTOS</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $ProductosTotalSeleccionado;?></b> de <b><?php echo $ProductosTotal;?></b> registros.</td>
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
        



        <input class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />

        <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
       
       
       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="ProId" <?php if($POST_cam=="ProId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="ProCodigoAlternativo" <?php if($POST_cam=="ProCodigoAlternativo"){ echo 'selected="selected"';}?>>Cod. Alternativo</option>
         <option value="ProCodigoOriginal" <?php if($POST_cam=="ProCodigoOriginal"){ echo 'selected="selected"';}?>>Cod. Original</option>
         <option value="ProNombre" <?php if($POST_cam=="ProNombre"){ echo 'selected="selected"';}?>>Nombre</option>
         <option value="ProReferencia" <?php if($POST_cam=="ProReferencia"){ echo 'selected="selected"';}?>>Referencia</option>
         <option value="ProUbicacion" <?php if($POST_cam=="ProUbicacion"){ echo 'selected="selected"';}?>>Ubicacion</option>
       </select>-->
       
       Tipo:
       
       <select class="EstFormularioCombo" name="CmpProductoTipo" id="CmpProductoTipo">
             <option value="">Todos</option>
            <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
              <option <?php echo $DatProductoTipo->RtiId;?> <?php echo ($DatProductoTipo->RtiId==$POST_ProductoTipo)?'selected="selected"':"";?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>			
			<?php
			}
			?>
            </select>
       Estado:



		<select class="EstFormularioCombo" name="Est" id="Est">
                <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
                <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
                <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
                </select>
	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
  <td width="87%" valign="top">
    
    
    
    
    
  <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="1%" >#</th>
        <th width="2%" >
          
          <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
        <th width="2%" >&nbsp;</th>
        
        <th width="2%" ><?php
				if($POST_ord == "ProId"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('ProId','ASC');"> Id.  </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "RtiNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('RtiNombre','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('RtiNombre','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('RtiNombre','ASC');"> Tipo </a>
          <?php
				}
				?></th>
        <th width="7%" ><?php
				if($POST_ord == "ProCodigoAlternativo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alternativo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProCodigoAlternativo','DESC');">  Cod. Alternativo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');">  Cod. Alternativo </a>
          <?php
				}
				?></th>
        <th width="5%" ><?php
				if($POST_ord == "ProCodigoOriginal"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Original <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProCodigoOriginal','DESC');"> Cod. Original <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Original </a>
          <?php
				}
				?></th>
        <th width="10%" >
          <?php
				if($POST_ord == "ProNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre  </a>
          <?php
				}
				?>		</th>
        <th width="7%" ><?php
				if($POST_ord == "ProReferencia"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProReferencia','DESC');"> Referencia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia </a>
          <?php
				}
				?></th>
        <th width="14%" ><?php
				if($POST_ord == "ProUbicacion"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProUbicacion','ASC');"> Ubicacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProUbicacion','DESC');"> Ubicacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProUbicacion','ASC');"> Ubicacion </a>
          <?php
				}
				?></th>
        <th width="6%" >Uso</th>
        <th width="6%" ><?php
				if($POST_ord == "ProCostoIngreso"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProCostoIngreso','ASC');"> Costo (Ingreso) <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProCostoIngreso','DESC');">  Costo (Ingreso) <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProCostoIngreso','ASC');">  Costo (Ingreso) </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "ProCosto"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo (Base) <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProCosto','DESC');"> Costo (Base) <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo (Base) </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "UmeNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('UmeNombre','DESC');"> U.M.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M. </a>
          <?php
				}
				?></th>
        <th width="4%" ><?php
				if($POST_ord == "ProStockMinimo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProStockMinimo','ASC');"> Stock Min. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProStockMinimo','DESC');"> Stock Min <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProStockMinimo','ASC');"> Stock Min. </a>
          <?php
				}
				?></th>
        <th width="3%" ><?php
				if($POST_ord == "ProEstado"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProEstado','ASC');"> Est. </a>
          <?php
				}
				?></th>
        <th width="3%" ><span title="Foto de Referencia">F</span> </th>
        <th width="3%" ><span title="Archivo de Especificaciones">AE</span></th>
        <th width="4%" >Lista Precio</th>
        <th width="7%" >Stk. Verif.</th>
        <th width="7%" >
          <?php
				if($POST_ord == "ProTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('ProTiempoModificacion','ASC');">
            U.A.
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProTiempoModificacion','DESC');">
            
            U.A.
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('ProTiempoModificacion','ASC');">
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
        
        <td colspan="22" align="center">
          
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
            <option <?php if($POST_num==$ProductosTotal){ echo 'selected="selected"';}?> value="<?php echo $ProductosTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ProductosTotal;
					//}else{
					//	$tregistros = ($ProductosTotalSeleccionado);
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

								foreach($ArrProductos as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="1%" align="center"  ><?php echo $f;?></td>
      <td width="2%" align="center"  >
        
        <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->ProId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->ProId; ?>" />				</td>
      <td align="right" valign="middle" width="2%"   >
      
      <?php
	  
	  if($dat->ProRevisado == 1){
	?>
    <img src="imagenes/alerta2.gif" alt="[Revisar]" title="Revisar" width="20" height="20" />
    <?php  
	  }
	  
			?>
            
            
            </td>
      
      <td align="right" valign="middle" width="2%"   >
	  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>"><?php echo $dat->ProId;  ?></a></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->RtiNombre; ?></td>
      <td align="right" valign="middle" width="7%"   ><?php echo $dat->ProCodigoAlternativo; ?></td>
      <td align="right" valign="middle" width="5%"   ><?php echo $dat->ProCodigoOriginal; ?></td>
      <td align="right" valign="middle" width="10%"   ><?php echo $dat->ProNombre; ?></td>
      <td  width="7%" align="right" ><?php echo $dat->ProReferencia; ?></td>
      <td  width="14%" align="right" ><?php echo $dat->ProUbicacion; ?></td>
      <td  width="6%" align="left" >
      
<!--      <a href="formularios/Producto/DiaProductoUso.php?height=440&width=850&ProId=<?php echo $dat->ProId?>" class="thickbox" title=""><img src="imagenes/acciones/producto_uso.png" alt="Uso del Producto" title="Uso del Producto" border="0" width="20" height="20" /> Uso</a>-->
	  
      
      
      
        <a href="javascript:FncProductoUsoEditar('<?php echo (($PrivilegioEditar)?'EditarUso': (($PrivilegioVer)?'VerUso':''))?>','<?php echo $dat->ProId?>');" ><img src="imagenes/acciones/producto_uso.png" alt="Uso del Producto" title="Uso del Producto" border="0" width="20" height="20" /> Uso</a>    
      
	  
<?php
if($dat->ProValidarUso == 1){
?>
	
	 
	<?php
	$InsProductoVehiculoModelo = new ClsProductoVehiculoModelo();
	$ResProductoVehiculoModelo = $InsProductoVehiculoModelo->MtdObtenerProductoVehiculoModelos(NULL,NULL,"PvvId","ASC",NULL,$dat->ProId);
	$ArrProductoVehiculoModelos = $ResProductoVehiculoModelo['Datos'];
	?>           
	
	
	<?php
	if(!empty($ArrProductoVehiculoModelos)){
	?>
	<br /><br />
	<?php
		foreach($ArrProductoVehiculoModelos as $DatProductoVehiculoModelo){
	
	?>
		<?php echo $DatProductoVehiculoModelo->VmaNombre;?>-<?php echo $DatProductoVehiculoModelo->VmoNombre;?> / 
	<?php
			
		}
	}
	?>


<?php
}else{
?>
General
<?php
}
?>




      
      </td>
      <td  width="6%" align="right" ><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span><?php echo number_format($dat->ProCostoIngreso,3); ?></td>
      <td  width="4%" align="right" ><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span><?php echo number_format($dat->ProCosto,3); ?></td>
      <td  width="4%" align="right" ><?php echo $dat->UmeNombre; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->ProStockMinimo; ?></td>
      <td  width="3%" align="center" ><?php
			switch($dat->ProEstado){
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
			?></td>
      <td  width="3%" align="center" >
        
        
  <?php
if(!empty($dat->ProFoto)){
?> 
  <a target="_blank" href="subidos/producto_fotos/<?php echo $dat->ProFoto;?>" class="thickbox" ><img src="imagenes/foto.jpg" alt="Foto" width="30" height="30" border="0" title="Foto de Referencia" /></a></td>
  <?php
}
?>	
      
      
      <td  width="3%" align="center" >
        
  <?php
if(!empty($dat->ProEspecificacion)){
?> 
  <a target="_blank" href="subidos/producto_especificaciones/<?php echo $dat->ProEspecificacion;?>"><img src="imagenes/pdf.gif" alt="PDF" width="30" height="30" border="0" title="Archivo de Especificaciones" /></a>			
  <?php
}
?>				
        
        
        
        
        
        </td>
      <td  width="4%" align="center" >
      
		<?php
		if($PrivilegioListaPrecioVer){
		?>
      <a href="javascript:FncListaPrecioCargarFormulario('Ver','<?php echo $dat->ProId; ?>');">
      <img  src="imagenes/lista_precios.png" alt="[Lista de Precios]" width="19" height="19" border="0" title="Lista de Precios"   /> Lista Precio
      </a>
        
        <?php	
		}
		?>
      
      </td>
      <td  width="7%" align="right" >
      
      

<?php
if($dat->ProStockVerificado==1){
?>
<img src="imagenes/verificado.png" width="15" height="15" alt="Verificado" title="Verificado" />
<?php  
}
?>
      </td>
      <td  width="7%" align="right" ><?php echo ($dat->ProTiempoModificacion);?></td>
      <td  width="10%" align="center" >
        
        
  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->ProId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->ProId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>


  <?php
/*if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=CostoVinculado&Id=<?php echo $dat->ProId;?>"><img src="imagenes/costos_vinculados.png" width="19" height="19" border="0" title="Ver Historial de Costos Vinculados" alt="[Ver Historial de Costos Vinculados]"   /></a>
  <?php
}*/
?>

</td>
      </tr>
    
    <?php		$f++;
	
	
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
//
//$InsVehiculoVersion = new ClsVehiculoVersion();
//$InsProductoAno = new ClsProductoAno();
//
//$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,NULL);
//$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
//
//foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
//
//	$InsProductoVehiculoVersion = new ClsProductoVehiculoVersion();
//	$InsProductoVehiculoVersion->ProId = $dat->ProId;
//	$InsProductoVehiculoVersion->VveId = $DatVehiculoVersion->VveId;
//	$InsProductoVehiculoVersion->PvvTiempoCreacion = date("Y-m-d H:i:s");
//	$InsProductoVehiculoVersion->PvvTiempoModificacion = date("Y-m-d H:i:s");
//	$InsProductoVehiculoVersion->MtdRegistrarProductoVehiculoVersion();	
//
//}
//
//for($i=date("Y")-10;$i<=(date("Y"));$i++){
//	$InsProductoAno = new ClsProductoAno();
//	$InsProductoAno->ProId = $dat->ProId;
//	$InsProductoAno->PanAno = $i;
//	$InsProductoAno->PanTiempoCreacion = date("Y-m-d H:i:s");
//	$InsProductoAno->PanTiempoModificacion = date("Y-m-d H:i:s");
//	$InsProductoAno->MtdRegistrarProductoAno();
//	
//	
//	
//}

				
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

