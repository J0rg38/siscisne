<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioListaPrecioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Ver"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenStock.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenStock.css');
</style>

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


$POST_Estado = $_POST['Estado'] ?? '';

$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'ProStockReal';
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


if(empty($POST_est)){
	$POST_est = 0;
}


if(empty($POST_con)){
	$POST_con = "contiene";
}


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');

$InsAlmacenStock = new ClsAlmacenStock();


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenStock.php');

//$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag);
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks("ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId",$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
$AlmacenStocksTotal = $ResAlmacenStock['Total'];
$AlmacenStocksTotalSeleccionado = $ResAlmacenStock['TotalSeleccionado'];


/*
 * interface FrmAlmacenStockListado {
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



</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE STOCK EN ALMACEN</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $AlmacenStocksTotalSeleccionado;?></b> de <b><?php echo $AlmacenStocksTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">

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
      
      

<!--       <select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="ProId" <?php if($POST_cam=="ProId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="ProCodigoOriginal" <?php if($POST_cam=="ProCodigoOriginal"){ echo 'selected="selected"';}?>>Cod. Original</option>
        <option value="ProCodigoAlternativo" <?php if($POST_cam=="ProCodigoAlternativo"){ echo 'selected="selected"';}?>>Cod. Alternativo</option>
        <option value="ProNombre" <?php if($POST_cam=="ProNombre"){ echo 'selected="selected"';}?>>Nombre</option>
       </select>-->

      <!-- Estado
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if($POST_est==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_est==1){ echo 'selected="selected"';}?>>En actividad</option>
        <option value="2" <?php if($POST_est==2){ echo 'selected="selected"';}?>>Sin actividad</option>        
        </select>-->

	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td>


<div id="CapListado">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

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
                <th width="6%" ><?php
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
                <th width="8%" ><?php
				if($POST_ord == "ProCodigoAlternativo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alternativo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','DESC');"> Cod. Alternativo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alternativo </a>
                  <?php
				}
				?></th>
                <th width="28%" ><?php
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
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "UmeNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UmeNombre','DESC');">  U.M. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UmeNombre','ASC');">  U.M. </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "AstUbicacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','ASC');"> Ubicacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','DESC');"> Ubicacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','ASC');"> Ubicacion </a>
                  <?php
				}
				?></th>
                <th width="10%" >Uso</th>
                <th width="4%" ><?php
				if($POST_ord == "AstStockReal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stk. Min. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','DESC');"> Stk. Min. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stk. Min. </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "AstStockReal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stock  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','DESC');"> Stock  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stock  </a>
                  <?php
				}
				?></th>
                <th width="4%" >Stk. Verif.</th>
                <th width="4%" >Lista Precio</th>
                <th width="4%" >&nbsp;</th>
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

				  <option <?php if($POST_num==$AlmacenStocksTotal){ echo 'selected="selected"';}?> value="<?php echo $AlmacenStocksTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $AlmacenStocksTotal;
					//}else{
					//	$tregistros = ($AlmacenStocksTotalSeleccionado);
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
						Pagina <?php echo $POST_p;?> de <?php echo $cant_paginas;?>                    
                        
				</td>
              </tr>
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrAlmacenStocks as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input onclick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AstId; ?>" />				</td>

                <td align="right" valign="middle"   >
				
                <a href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $dat->ProId;  ?>">
				<?php echo $dat->ProId;  ?>
                </a>
                </td>
                <td align="right" valign="middle"   ><?php echo $dat->ProCodigoOriginal;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProCodigoAlternativo;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProNombre; ?></td>
                <td align="right" ><?php echo $dat->UmeNombre; ?></td>
                <td align="right" ><?php echo $dat->AstUbicacion; ?></td>
                <td align="right" >
    
<?php
/*
?>            
                  <a href="formularios/Producto/DiaProductoUso.php?height=440&width=850&ProId=<?php echo $dat->ProId?>" class="thickbox" title=""><img src="imagenes/acciones/producto_uso.png" alt="Uso del Producto" title="Uso del Producto" border="0" width="20" height="20" /> Uso</a> 
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
?>
<?php
}
?>

 <?php
*/
?>          


      
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
                <td align="right" ><?php echo number_format($dat->AstStockMinimo,2); ?></td>
                <td align="right" >
                  
                  
                  <?php echo number_format($dat->AstStockReal,2); ?>
                  
                  
                </td>
                <td  width="4%" align="right" ><?php
if($dat->ProStockVerificado==1){
?>
                  <img src="imagenes/verificado.png" width="15" height="15" alt="Verificado" title="Verificado" />
                  <?php  
}
?></td>
                <td align="center" >
                  
                  
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
                <td align="right" >
                
                <?php
				$clase = "";
				if($dat->AstStockPorcentaje >= 0 and $dat->AstStockPorcentaje <= 25){
					$clase = "EstAlmacenStockNivel1";
				}else if($dat->AstStockPorcentaje >= 26 and $dat->AstStockPorcentaje <= 50){
					$clase = "EstAlmacenStockNivel2";
				}else if($dat->AstStockPorcentaje >= 51 and $dat->AstStockPorcentaje <= 75){
					$clase = "EstAlmacenStockNivel3";
				}else if($dat->AstStockPorcentaje >= 76 and $dat->AstStockPorcentaje <= 100){
					$clase = "EstAlmacenStockNivel4";
				}
				?>
                <div class="<?php echo $clase ?>" >
	                <?php echo $dat->AstStockPorcentaje; ?> %                
                </div>
                

                </td>
                <td align="center" ><?php
if($PrivilegioEliminar){
?>
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->ProId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
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
/*if($ProductoPrivilegioVer){
?>
  <a href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $dat->ProId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}*/
?>



</td>
                </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>

</div>    
      
      </td>
</tr>
</table>


</div>



</form>

<?php
}else{
	echo ERR_GEN_101;
}

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>