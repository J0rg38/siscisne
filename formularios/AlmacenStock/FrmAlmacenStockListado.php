<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioListaPrecioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Ver"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsAlmacenCombo.js" ></script>
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
//$POST_est = $_POST['Estado'];
$POST_est = "";
$POST_con = $_POST['Con'];
$POST_Referencia = $_POST['Referencia'];
$POST_IncluirReemplazo = $_POST['CmpIncluirReemplazo'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Almacen = ($_POST['CmpAlmacen']);
//$POST_Ano = $_POST['CmpAno'];
$POST_Ano = 1900;

if($_POST){
	$_SESSION['SesionAlmacen'] = $POST_Almacen;
}else{
	$POST_Almacen =  $_SESSION['SesionAlmacen'];	
}

//if($_POST){
//	$_SESSION['SesionSucursal'] = $POST_Sucursal;
//}else{
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
if(empty($POST_Ano)){
	$POST_Ano = date("Y");
}

$TieneMovimiento = false;	

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProductoListaPrecioCotizado.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenStock = new ClsAlmacenStock();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenStock.php');
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false)

/*if(!empty($POST_Almacen)){
	$TieneMovimiento = true;	
}else{
	$TieneMovimiento = false;
}*/

//deb($POST_IncluirReemplazo);

if($POST_IncluirReemplazo == "1"){
			
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$POST_fil,"PreId","ASC",NULL,1);
	$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
	
	$reemplazos = "";
	
	if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
					
					if(!empty($DatProductoReemplazo->PreCodigo1)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo1;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo2)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo2;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo3)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo3;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo4)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo4;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo5)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo5;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo6)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo6;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo7)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo7;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo8)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo8;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo9)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo9;	
					}
					
					
					if(!empty($DatProductoReemplazo->PreCodigo10)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo10;	
					}
					
					
			}
		}
}


//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) {


$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks("ProId,ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId,ProUbicacion,ProReferencia,RtiNombre,ProCodigoBarra",$POST_con,$POST_fil.$reemplazos,$POST_ord,$POST_sen,$POST_est,$POST_pag,NULL,$POST_Ano."-01-01",date("Y-m-d"),NULL,NULL,$POST_Referencia,NULL,NULL,$POST_Almacen,$TieneMovimiento,$POST_Sucursal,$POST_Ano);
//$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks("ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId,ProCodigoBarra",$POST_con,$POST_fil.$reemplazos,$POST_ord,$POST_sen,$POST_est,$POST_pag,NULL,$POST_Ano."-01-01",date("Y-m-d"),NULL,NULL,$POST_Referencia,NULL,NULL,$POST_Almacen,$TieneMovimiento,$POST_Sucursal,$POST_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
$AlmacenStocksTotal = $ResAlmacenStock['Total'];
$AlmacenStocksTotalSeleccionado = $ResAlmacenStock['TotalSeleccionado'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$POST_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

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
            <div class="EstSubMenuBoton"><a href="javascript:FncListadoImprimir();"><img src="imagenes/submenu/imprimir.png" alt="[Imprimir]" title="Imprimir" />Imprimir</a></div>
  <?php
			}
			?>



</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE STOCK DE REPUESTOS EN ALMACEN</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $AlmacenStocksTotalSeleccionado;?></b> de <b><?php echo $AlmacenStocksTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">


<table border="0" cellpadding="2" cellspacing="2">
<tr>
  <td align="right" valign="top"><input type="hidden" name="Acc" id="Acc" value="" />
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
    
    <span class="EstFormularioEtiquetaCaja">Referencia:</span>     
    <input class="EstFormularioCajaBuscar" name="Referencia" type="text" id="Referencia" value="<?php echo $POST_Referencia;?>" size="18" placeholder="Marca Modelo" />
    
    
    <!--<span class="EstFormularioEtiquetaCaja"> Estado: </span>
<select class="EstFormularioCombo" name="Est" id="Est">
  <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
  <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
  <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
</select>-->
    
    <!--
<span class="EstFormularioEtiquetaCaja"> Año:</span>
<select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                    <?php
//for($ano=2014;$ano<=date("Y");$ano++){
for( $ano=2014;$ano<=date("Y");$ano++){
?>
                    <option value="<?php echo $ano;?>" <?php echo (($POST_Ano == date("Y"))?'selected="selected"':'')?>  ><?php echo $ano;?></option>
                    <?php	
}
?>
                  </select>
                  -->
    
    
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
    
    
    
    <span class="EstFormularioEtiquetaCaja">Almacen:</span>     
    <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
      <option value="">Escoja una opcion</option>
      <?php
    foreach($ArrAlmacenes as $DatAlmacen){
    ?>
      <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($POST_Almacen==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
      <?php
    }
    ?>
      </select><br />
    <input type="checkbox" name="CmpIncluirReemplazo" id="CmpIncluirReemplazo" value="1"  <?php if($POST_IncluirReemplazo=="1"){ echo 'checked="checked"';} ?>   /> 
    Buscar reemplazos
    
  </td>
  <td valign="top"><input class="EstFormularioBoton" name="btn_buscar" type="submit" onclick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
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
                <th width="2%" >#</th>
                <th width="2%" >
                  
                  <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="2%" ><?php
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
                <th width="6%" ><?php
				if($POST_ord == "ProCodigoOriginal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Orig. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProCodigoOriginal','DESC');"> Cod. Orig. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProCodigoOriginal','ASC');"> Cod. Orig. </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "ProCodigoAlternativo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alt. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','DESC');"> Cod. Alt. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProCodigoAlternativo','ASC');"> Cod. Alt. </a>
                  <?php
				}
				?></th>
                <th width="23%" ><?php
				if($POST_ord == "ProNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProNombre','ASC');"> Nombre  </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "ProMarca"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProMarca','ASC');"> Marca <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProMarca','DESC');"> Marca <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProMarca','ASC');"> Marca </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "ProReferencia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProReferencia','DESC');"> Referencia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProReferencia','ASC');"> Referencia </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "AstUbicacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','ASC');"> Ubicacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','DESC');"> Ubicacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstUbicacion','ASC');"> Ubicacion </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "AstStockReal"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stock   <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstStockReal','DESC');"> Stock  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstStockReal','ASC');"> Stock  </a>
                  <?php
				}
				?></th>
                <th width="7%"><?php
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
                <th width="7%"><?php
				if($POST_ord == "AstPedidoPorLLegar"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstPedidoPorLLegar','ASC');">  Por Llegar <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstPedidoPorLLegar','DESC');">  Por Llegar <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstPedidoPorLLegar','ASC');">  Por Llegar </a>
                  <?php
				}
				?></th>
                <th width="7%"><?php
				if($POST_ord == "AstPedidoUltimaFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstPedidoUltimaFecha','ASC');"> Ultimo Pedido <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstPedidoUltimaFecha','DESC');"> Ultimo Pedido <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstPedidoUltimaFecha','ASC');"> Ultimo Pedido </a>
                  <?php
				}
				?></th>
                <th width="7%">
                  
                  
                  
                  <?php
				if($POST_ord == "AstPedidoLlegadaEstimada"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('AstPedidoLlegadaEstimada','ASC');"> Llegada Estimada <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('AstPedidoLlegadaEstimada','DESC');">  Llegada Estimada<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('AstPedidoLlegadaEstimada','ASC');">  Llegada Estimada </a>
                  <?php
				}
				?>                </th>
                <th width="7%"><?php
				if($POST_ord == "ProPromedioMensual"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProPromedioMensual','ASC');"> Prom. Men. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProPromedioMensual','DESC');"> Prom. Men. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProPromedioMensual','ASC');"> Prom. Men. </a>
                  <?php
				}
				?></th>
                <th width="7%">Disp.  GM
                  <?PHP

	$FechaDisponibilidad = "";
	
	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades(NULL,NULL,NULL ,"PdiTiempoCreacion","DESC","1",1);
	$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
	
	if(!empty($ArrProductoDisponibilidades)){
		foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
			
			$FechaDisponibilidad = $DatProductoDisponibilidad->PdiTiempoCreacion;
		
		}
	}
?>
                  <?php
echo $FechaDisponibilidad;
?></th>
                <th width="7%">Reemp. GM
                  <?php

$FechaReemplazo = "";

?>
                  <?php
	// MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreTiempoCreacion","DESC","1",1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
			
			$FechaReemplazo = $DatProductoReemplazo->PreTiempoCreacion;
		
		}
    }
    ?>
                  <?php

echo $FechaReemplazo;

?>
                  </th>
                <th width="5%" >
                  
                  <?php

$FechaCosto = "";
$ListaMoneda = "";

?>
                  <?php

	$InsProductoListaPrecio = new ClsProductoListaPrecio();
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios(NULL,NULL,NULL,'PlpTiempoCreacion','DESC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
    
    if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			
			$FechaCosto = $DatProductoListaPrecio->PlpTiempoCreacion;
			$ListaMoneda = $DatProductoListaPrecio->MonSimbolo;
		
		}
    }
    ?>
                  
                  Costo GM (<?php echo $ListaMoneda;?>) 
                  
                  
                  <?php

echo $FechaCosto;

?>    <!--  Costo GM-->
                  
                  </th>
                <th width="5%" >Costo Cotizado</th>
                <th width="5%" ><?php
				if($POST_ord == "ProCosto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo (<?php echo $EmpresaMonedaSimbolo;?>) <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProCosto','DESC');"> Costo (<?php echo $EmpresaMonedaSimbolo;?>) <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProCosto','ASC');"> Costo (<?php echo $EmpresaMoneda;?>) </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "ProListaPrecioPrecio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProListaPrecioPrecio','ASC');"> Precio (<?php echo $EmpresaMonedaSimbolo;?>) <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProListaPrecioPrecio','DESC');"> Precio (<?php echo $EmpresaMonedaSimbolo;?>) <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProListaPrecioPrecio','ASC');"> Precio (<?php echo $EmpresaMoneda;?>)  </a>
                  <?php
				}
				?></th>
                <th width="4%" >Lista Precio</th>
                <th width="10%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
              <tr>
                <td colspan="23" align="center">

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
                <td align="center" valign="middle"   >
                  
                  <a href="principal.php?Mod=Producto&Form=Ver&Id=<?php echo $dat->ProId;  ?>">
                    <?php echo $dat->ProId;  ?>
                    </a>
                  <br />
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
                <td align="right" valign="middle"   ><h1><?php echo $dat->ProCodigoOriginal;  ?></h1></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProCodigoAlternativo;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProNombre; ?></td>
                <td  width="7%" align="right" ><?php echo $dat->ProMarca; ?></td>
                <td  width="7%" align="right" >
				
                <?php
				/*if(strlen($dat->ProReferencia)>15){
				?>
                
					<?php 
                    $dat->ProReferenciaCorto = substr($dat->ProReferencia,0,15);
                    ?>
                    
                    <a href="#" class="tooltipf" data-description="<?php echo $dat->ProReferencia;?>"><?php echo $dat->ProReferenciaCorto;?>...</a>
                
                
                <?php	
				}else{
				?>
                <?php echo $dat->ProReferenciaCorto;?>
                <?php	
				}*/
				?>
                
                <?php echo $dat->ProReferencia;?>
				
                
                </td>
                <td align="right" ><?php echo $dat->AstUbicacion; ?></td>
                <td align="right" bgcolor="#CC33CC" >
                  
                  
                 <h1> <?php echo number_format($dat->AstStockReal,2); ?></h1>
                  
                  <?php
				  
				  ?>
                  
                </td>
                <td align="center" ><?php echo $dat->UmeNombre; ?></td>
                <td align="center" ><?php echo number_format($dat->AstPedidoPorLLegar,2); ?></td>
                <td align="center" >
				
				
                
                       
                  <?php
		if($PrivilegioListaPrecioVer){
		?>
                  <a href="javascript:FncPedidoClienteCargarFormulario('<?php echo $dat->ProId; ?>');">
                    <!--<img  src="imagenes/estado/pedidos_clientes.png" alt="[Pedido de Clientes]" width="19" height="19" border="0" title="Pedido de Clientes"   /> 
                   -->
                   
                   <?php echo ($dat->AstPedidoUltimaFecha); ?> / <?php echo ($dat->AstPedidoTipo); ?>
                
                    </a>
                  
                  <?php	
		}
		?>
				
                
                </td>
                <td align="center">
                
                <?php echo ($dat->AstPedidoLlegadaEstimada); ?>
                
                </td>
                <td align="center"><?php echo $dat->AstPromedioMensual; ?></td>
                <td align="center" bgcolor="#FFFF99"><?php
$Disponibilidad = "";

if(!empty($dat->ProCodigoOriginal)){

	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$dat->ProCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
	$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
	
	//$Disponibilidad = "";
	$Disponibilidad = "NO";
	$Cantidad = 0;
	
	if(!empty($ArrProductoDisponibilidades)){
		foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
			
			$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
			$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
		
		}
	}
}
?>
                  <?php echo $Disponibilidad;?> (<?php echo number_format($Cantidad,2);?>) </td>
                <td align="center" bgcolor="#FFCC33">
				
				<?php

$Reemplazo = "";

if(!empty($dat->ProCodigoOriginal)){
?>
                  <?php
    $Reemplazo = "NO";
     $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$dat->ProCodigoOriginal ,"PreTiempoCreacion","DESC",NULL,1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
          $Reemplazo= "SI";
    }
         
    ?>
                  <?php
}
?>

<?php
if($Reemplazo == "SI"){
	?>
    <a href="javascript:FncProductoReemplazoCargar('<?php echo trim($dat->ProCodigoOriginal);?>');"><?php echo $Reemplazo;?></a>

<?php
}else{
?>
<?php echo $Reemplazo;?>
<?php	
}
?>





                 </td>
                <td  width="5%" align="center" bgcolor="#6FDB92" >
                
                
     <?php

$ProductoListaPrecioCosto = 0;
$ProductoListaPrecioMoneda = "";
?>
                  <?php

	$InsProductoListaPrecio = new ClsProductoListaPrecio();
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$dat->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
    
    if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			$ProductoListaPrecioMoneda = $DatProductoListaPrecio->MonSimbolo;
			$ProductoListaPrecioCosto = $DatProductoListaPrecio->PlpPrecioReal;
		
		}
    }
    ?>
                 <?php echo $ProductoListaPrecioMoneda;?> <?php

echo number_format($ProductoListaPrecioCosto,2);

?>     
                
                </td>
                <td  width="5%" align="right" >
                
            <?php

$ProductoListaPrecioCotizadoCosto = 0;
$ProductoListaPrecioCotizadoMoneda = "";
?>         
<?php

		$InsProductoListaPrecioCotizado = new ClsProductoListaPrecioCotizado();
		//MtdObtenerProductoListaPrecioCotizado($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL) {
		$ResProductoListaPrecioCotizado = $InsProductoListaPrecioCotizado->MtdObtenerProductoListaPrecioCotizado("pro.ProCodigoOriginal",$dat->ProCodigoOriginal,"OodTiempoCreacion","DESC",NULL,NULL);
		$ArrProductoListaPrecioCotizados = $ResProductoListaPrecioCotizado['Datos'];
		
			$ProductoListaPrecioMonedaId = "";
			$ProductoListaPrecioReal = 0;
			$ProductoListaPrecio = 0;
			
		if(!empty($ArrProductoListaPrecioCotizados)){
			foreach($ArrProductoListaPrecioCotizados as $DatProductoListaPrecioCotizado){
				
				if($DatProductoListaPrecioCotizado->MonId<>$EmpresaMonedaId){
					$PrecioConvertido = $DatProductoListaPrecioCotizado->OodPrecio / $DatProductoListaPrecioCotizado->OotTipoCambio;
				}else{
					$PrecioConvertido = $DatProductoListaPrecioCotizado->OodPrecio;
				}
				
				$ProductoListaPrecioCotizadoCosto =  $PrecioConvertido;
				$ProductoListaPrecioCotizadoMoneda =  $DatProductoListaPrecioCotizado->MonSimbolo;
			}
		}
		
?>      

<?php echo $ProductoListaPrecioCotizadoMoneda;?>

<?php
echo number_format($ProductoListaPrecioCotizadoCosto,2);
?>     
          
                
                </td>
                <td  width="5%" align="right" ><?php echo number_format($dat->ProCosto,2); ?></td>
                <td  width="5%" align="right" >
                  
                  
                  <!--    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>-->
                  
                  
                  <?php echo number_format($dat->ProListaPrecioPrecio,2); ?></td>
                <td align="center" >
                  
                  
                  <?php
		if($PrivilegioListaPrecioVer){
		?>
                  <a href="javascript:FncListaPrecioCargarFormulario('Ver','<?php echo $dat->ProId; ?>');">
                    <img  src="imagenes/estado/lista_precios.png" alt="[Lista de Precios]" width="19" height="19" border="0" title="Lista de Precios"   />
                    </a>
                  
                  <?php	
		}
		?>
                  
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
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>&Almacen=<?php echo $POST_Almacen;?>&Sucursal=<?php echo $POST_Sucursal;?>&Ano=<?php echo $POST_Ano;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  <?php
}
?>
                    <?php
			if($PrivilegioVer){
			?>
                  
                  
                  <a href="javascript:FncVistaPreliminar('<?php echo $dat->ProId;?>','<?php echo $POST_Almacen;?>','<?php echo $POST_Sucursal;?>','<?php echo $POST_Ano;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioVer){
			?>        
                  
                  <a href="javascript:FncImprmir('<?php echo $dat->ProId;?>','<?php echo $POST_Almacen;?>','<?php echo $POST_Sucursal;?>','<?php echo $POST_Ano;?>');"><img src="imagenes/acciones/imprimir.gif" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  
                  
                  
                  <?php
			}
			?>            
   
   
   	<?php
    if($PrivilegioEditar and !empty($POST_Almacen)){
    ?>
      <a href="principal.php?Mod=AlmacenStock&Form=EditarStockMinimo&Id=<?php echo $dat->ProId;?>&Almacen=<?php echo $POST_Almacen;?>&Sucursal=<?php echo $POST_Sucursal;?>&Ano=<?php echo $POST_Ano;?>"><img src="imagenes/acciones/acc_editar_especial.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
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
                  
   <!-- <a href="migrar/TarStockCorregirStockAlmacen2.php?AlmacenId=<?php echo $POST_Almacen;?>&c=1&ProductoId=<?php echo $dat->ProId;?>" >[CA]</a>
    <a href="migrar/TarStockCorregirStockAlmacen.php?&c=1&ProductoId=<?php echo $dat->ProId;?>" >[C]</a>-->
         
<?php
/*if(!empty($POST_Almacen)){
?>

    <a href="migrar/TarStockCorregirStockAlmacen2.php?c=1&AlmacenId=<?php echo $POST_Almacen;?>&ProductoId=<?php echo $dat->ProId;?>&Sucursal=<?php echo $POST_Sucursal;?>" >
    <img src="imagenes/acciones/ajustar1.png" width="19" height="19" alt="[Ajustar Stock x Almacen]" title="Ajustar Stock x Almacen" />
    </a>

  
    <a href="migrar/TarStockCorregirStockAlmacen.php?c=1&AlmacenId=<?php echo $POST_Almacen;?>&ProductoId=<?php echo $dat->ProId;?>&Sucursal=<?php echo $POST_Sucursal;?>" >
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