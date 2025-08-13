<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioListaPrecioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Ver"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsAlmacenCombo.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoStock.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoStock.css');
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
$POST_sen = ($_POST['Sen'] ?? '');
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
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];
$POST_Referencia = $_POST['Referencia'];
$POST_IncluirReemplazo = $_POST['CmpIncluirReemplazo'];
$POST_Sucursal = $_POST['CmpSucursal'] ?? '';
$POST_Almacen = ($_POST['CmpAlmacen']);
$POST_Ano = $_POST['CmpAno'];

if($_POST){
	$_SESSION['SesionAlmacen'] = $POST_Almacen;
}else{
	$POST_Almacen =  $_SESSION['SesionAlmacen'];	
}

//if($_POST){
//	$_SESSION['SesionSucursal'] = $POST_Sucursal;
///}else{
//	$POST_Sucursal = $_SESSION['SesionSucursal'];	
//}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


if($_POST){
	
}else{
	$POST_est=1;
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VehNombre';
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
if(empty($POST_Ano)){
	$POST_Ano = date("Y");
}

$TieneMovimiento = true;	

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoStock = new ClsVehiculoStock();
$InsVehiculo = new ClsVehiculo();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoStock.php');


//MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL,$oVehiculo=NULL,$oAno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) 
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoStocks("veh.VehCodigoIdentificador,veh.VehNombre,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_VehiculoVersion,$POST_AnoFabricacion,$POST_AnoModelo,$POST_Color,$POST_Sucursal,NULL,$POST_Ano,NULL,NULL);
$ArrVehiculoStocks = $ResVehiculoStock['Datos'];
$VehiculoStocksTotal = $ResVehiculoStock['Total'];
$VehiculoStocksTotalSeleccionado = $ResVehiculoStock['TotalSeleccionado'];


$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos("veh.VehCodigoIdentificador,veh.VehNombre,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,NULL,NULL,$POST_VehiculoTipo,$POST_est);
$ArrVehiculos = $ResVehiculo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

/*
 * interface FrmVehiculoStockListado {
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



</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE STOCK DE VEHICULOS EN ALMACEN</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $VehiculoStocksTotalSeleccionado;?></b> de <b><?php echo $VehiculoStocksTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">


<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>&nbsp;</td>
  <td align="right"><input type="hidden" name="Acc" id="Acc" value="" />
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
    <span class="EstFormularioEtiquetaCaja"> Estado: </span>
  <select class="EstFormularioCombo" name="Est" id="Est">
    <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
    <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
    <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
  </select>
  <span class="EstFormularioEtiquetaCaja">Sucursal:</span>                
    
  <select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
    <option value="">Todos</option>
    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
    <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
    <?php
    }
    ?>
  </select>
  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onclick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" />
    
  </td>
  <td>&nbsp;</td>
</tr>
</table>
		
      
      
      </td>
</tr>
<tr>
<td>


<div id="CapListado">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="3%" >#</th>
                <th width="2%" >
                  
                  <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="8%" ><?php
				if($POST_ord == "ProId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('ProId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "VehCodigoIdentificador"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehCodigoIdentificador','ASC');"> Cod. Unico <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehCodigoIdentificador','DESC');"> Cod. Unico <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehCodigoIdentificador','ASC');"> Cod. Unico </a>
                  <?php
				}
				?></th>
                <th width="26%" ><?php
				if($POST_ord == "VehNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VehNombre','ASC');"> Nombre Comercial <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VehNombre','DESC');"> Nombre Comercial <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VehNombre','ASC');"> Nombre Comercial  </a>
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
                <th width="6%" ><?php
				if($POST_ord == "UmeNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('UmeNombre','DESC');"> U.M. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('UmeNombre','ASC');"> U.M. </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "VstStockReal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VstStockReal','ASC');"> Stock   <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VstStockReal','DESC');"> Stock  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VstStockReal','ASC');"> Stock  </a>
                  <?php
				}
				?></th>
                <th width="12%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
              <tr>
                <td colspan="11" align="center">

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

				  <option <?php if($POST_num==$VehiculoStocksTotal){ echo 'selected="selected"';}?> value="<?php echo $VehiculoStocksTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $VehiculoStocksTotal;
					//}else{
					//	$tregistros = ($VehiculoStocksTotalSeleccionado);
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

								foreach($ArrVehiculoStocks as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >
                  
                  <input onclick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->VstId; ?>" />				</td>
                <td align="center" valign="middle"   >
                  
                  <a href="principal.php?Mod=Vehiculo&Form=Ver&Id=<?php echo $dat->VehId;  ?>">
                    <?php echo $dat->VehId;  ?>
                    </a>
                
                  
                </td>
                <td align="right" valign="middle"   ><?php echo $dat->VehCodigoIdentificador;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->VehNombre; ?></td>
                <td  width="9%" align="right" ><?php echo $dat->VmaNombre; ?></td>
                <td  width="9%" align="right" ><?php echo $dat->VmoNombre; ?></td>
                <td align="right" ><?php echo $dat->VveNombre; ?></td>
                <td align="right" ><?php echo $dat->UmeNombre; ?></td>
                <td align="right" bgcolor="#CC33CC" >
                  
                  
                  <?php echo number_format($dat->VstStockReal,2); ?>
                  
                  <?php
				  
				  ?>
                  
                </td>
                <td align="center" ><?php
if($PrivilegioEliminar){
?>
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->VehId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
                  <?php
}
?>
                  
                  
                  
                  <?php
if($PrivilegioVer){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VehId;?>&Almacen=<?php echo $POST_Almacen;?>&Sucursal=<?php echo $POST_Sucursal;?>&Ano=<?php echo $POST_Ano;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  <?php
}
?>
                  <?php
			if($PrivilegioVer){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->VehId;?>','<?php echo $POST_Almacen;?>','<?php echo $POST_Sucursal;?>','<?php echo $POST_Ano;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioVer){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->VehId;?>','<?php echo $POST_Almacen;?>','<?php echo $POST_Sucursal;?>','<?php echo $POST_Ano;?>');"><img src="imagenes/acciones/imprimir.gif" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?>            
                  
                  <?php
    /*if($ProductoPrivilegioVer){
    ?>
      <a href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $dat->VehId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
      <?php
    }*/
    ?>
                  
                  <!-- <a href="migrar/TarStockCorregirStockAlmacen2.php?AlmacenId=<?php echo $POST_Almacen;?>&c=1&ProductoId=<?php echo $dat->VehId;?>" >[CA]</a>
    <a href="migrar/TarStockCorregirStockAlmacen.php?&c=1&ProductoId=<?php echo $dat->VehId;?>" >[C]</a>-->
                  
                  <?php
/*if(!empty($POST_Almacen)){
?>

    <a href="migrar/TarStockCorregirStockAlmacen2.php?c=1&AlmacenId=<?php echo $POST_Almacen;?>&ProductoId=<?php echo $dat->VehId;?>&Sucursal=<?php echo $POST_Sucursal;?>" >
    <img src="imagenes/acciones/ajustar1.png" width="19" height="19" alt="[Ajustar Stock x Almacen]" title="Ajustar Stock x Almacen" />
    </a>

  
    <a href="migrar/TarStockCorregirStockAlmacen.php?c=1&AlmacenId=<?php echo $POST_Almacen;?>&ProductoId=<?php echo $dat->VehId;?>&Sucursal=<?php echo $POST_Sucursal;?>" >
    <img src="imagenes/acciones/ajustar2.png"  width="19" height="19" alt="[Ajustar Stock General]" title="AjustarStock General"/>
    </a>
    
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