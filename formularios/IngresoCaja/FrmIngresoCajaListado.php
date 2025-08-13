<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>



<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsIngresoCaja.js" ></script>


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


/*
* Otras variables
*/

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

if($_POST){
	$_SESSION[$GET_mod."FechaInicio"] = $POST_finicio;
}else{
	$POST_finicio = (empty($_GET['FechaInicio'])?$_SESSION[$GET_mod."FechaInicio"]:$_GET['FechaInicio']);
}

if($_POST){
	$_SESSION[$GET_mod."FechaFin"] = $POST_ffin;
}else{
	$POST_ffin = (empty($_GET['FechaFin'])?$_SESSION[$GET_mod."FechaFin"]:$_GET['FechaFin']);
}  
   
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];
$POST_Cuenta = $_POST['CmpCuenta'];
$POST_Moneda = $_POST['CmpMonedaId'];
$POST_Sucursal = $_SESSION['SesionSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'IngTiempoCreacion';
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

if(empty($POST_finicio)){$POST_finicio = "01/01/".date("Y");}
if(empty($POST_ffin)){$POST_ffin = date("d/m/Y");}
$POST_Area = "ARE-10000";

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjIngresoCaja.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsIngreso = new ClsIngreso();
$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$InsIngreso->UsuId = $_SESSION['SesionId'];	

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccIngresoCaja.php');

//MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Desc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoIngtino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResIngreso = $InsIngreso->MtdObtenerIngresos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"IngFecha","CUE-10000",$POST_Moneda,$POST_TipoIngtino,$POST_Area,$POST_Sucursal);
$ArrIngresos = $ResIngreso['Datos'];
$IngresosTotal = $ResIngreso['Total'];
$IngresosTotalSeleccionado = $ResIngreso['TotalSeleccionado'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,NULL);
$ArrCuentas = $ResCuenta['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmIngresoListado {
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
  <?php
if($PrivilegioEditar){
?>
   
    <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
    <img src="imagenes/anulado.png" alt="[Act. Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>
    
   <div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoRealizadoSeleccionados();">
    <img src="imagenes/realizado.gif" alt="[Act. Realizado]" title="Actualizar a estado REALIZADO seleccionados" />Realizado</a></div>
<?php
}
?>

</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE INGRESOS A CAJA</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $IngresosTotalSeleccionado;?></b> de <b><?php echo $IngresosTotal;?></b> registros.</td>
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
    

<select class="EstFormularioCombo" name="Con" id="Con">
      <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
      <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
      <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
      <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
      <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
      <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
      </select>
      
      

       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="IngId" <?php if($POST_cam=="IngId"){ echo 'selected="selected"';}?>>Id</option>
        <option value="IngNumero" <?php if($POST_cam=="IngNumero"){ echo 'selected="selected"';}?>>Nombre</option>
      </select>-->

       Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if($POST_est==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_est==1){ echo 'selected="selected"';}?>>No Realizado</option>
        <option value="2" <?php if($POST_est==2){ echo 'selected="selected"';}?>>Realizado</option>        
        <option value="6" <?php if($POST_est==6){ echo 'selected="selected"';}?>>Anulado</option>        
        </select>
        
        Moneda:
        
        <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                      <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_Moneda==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                      <?php
			}
			?>
                      </select>
        
    
                  
                  Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin; ?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />	  <span class="EstFormularioEtiqueta">   Sucursal:
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
<td>


<div id="CapListado">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="6%" ><?php
				if($POST_ord == "IngId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('IngId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="20%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> A la Orden <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> A la Orden <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> A la Orden</a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "IngFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngFecha','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "IngReferencia"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngReferencia','ASC');">  Ref. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngReferencia','DESC');">  Ref. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngReferencia','ASC');"> Ref. </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "IngMoneda"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngMoneda','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngMoneda','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngMoneda','ASC');"> Moneda </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "IngTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngTipoCambio','DESC');">  T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngTipoCambio','ASC');">  T.C. </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "IngMonto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngMonto','ASC');"> Monto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngMonto','DESC');"> Monto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngMonto','ASC');"> Monto </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "IngTipo"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngTipo','ASC');"> Tipo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngTipo','DESC');"> Tipo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngTipo','ASC');"> Tipo </a>
                  <?php
				}
				?></th>
                <th width="3%" >
                  
                  <?php
				if($POST_ord == "IngEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('IngEstado','ASC');"> Est.  </a>
                  <?php
				}
				?>                </th>
                <th width="6%" > <?php
				if($POST_ord == "IngTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('IngTiempoCreacion','ASC');"> Fecha Creacion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('IngTiempoCreacion','DESC');"> Fecha Creacion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('IngTiempoCreacion','ASC');"> Fecha Creacion </a>
                  <?php
				}
				?></th>
                <th width="12%" >Acciones</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
              <tr>
                <td colspan="13" align="center">

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

				  <option <?php if($POST_num==$IngresosTotal){ echo 'selected="selected"';}?> value="<?php echo $IngresosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $IngresosTotal;
					//}else{
					//	$tregistros = ($IngresosTotalSeleccionado);
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

								foreach($ArrIngresos as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input onclick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->IngId; ?>" estado="<?php echo $dat->IngEstado; ?>" />				</td>

                <td align="right" valign="middle"   ><?php echo $dat->IngId;  ?></td>
                <td align="right" valign="middle"   >
                
                
                <?php echo $dat->PerNombre; ?>/
                <?php echo $dat->PerApellidoPaterno; ?>
                <?php echo $dat->PerApellidoMaterno; ?>
                
                <?php echo $dat->CliNombre; ?>
                <?php echo $dat->CliApellidoPaterno; ?>
                <?php echo $dat->CliApellidoMaterno; ?>
                
                <?php echo $dat->PrvNombre; ?>/
                <?php echo $dat->PrvApellidoPaterno; ?>
                <?php echo $dat->PrvApellidoMaterno; ?>
                
                </td>
                <td align="right" ><?php echo $dat->IngFecha; ?></td>
                <td align="right" ><?php echo $dat->IngReferencia; ?></td>
                <td align="right" ><?php echo $dat->MonNombre; ?></td>
                <td align="right" ><?php echo $dat->IngTipoCambio; ?></td>
                
                <td align="right" >
				
				<?php $dat->IngMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->IngMonto:($dat->IngMonto/$dat->IngTipoCambio));?>
				
				
				<?php echo number_format($dat->IngMonto,2); ?></td>
                <td align="right" ><?php echo $dat->IngTipoDescripcion; ?></td>
                <td align="right" >
                  
                  
                  <?php
			switch($dat->IngEstado){
				case 1:
			?>
                  <img src="imagenes/pendiente.gif" alt="[No Realizado]" title="No Realizado" width="20" height="20" />
                  <?php
				break;
				
				case 3:
			?>
                  <img src="imagenes/realizado.gif" alt="[Realizado]" title="Realizado" width="20" height="20" />
                  <?php
				break;
				
				case 6:
			?>
                  <img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" width="20" height="20" />
                  <?php
				break;

			}
			?>                </td>
                <td align="right" ><?php echo ($dat->IngTiempoCreacion);?></td>
                <td align="center" >
				
				  <?php
if($PrivilegioAuditoriaVer){
?>
  <a href="formularios/Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->IngId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>



<?php
if($PrivilegioEliminar){
?>
                  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->IngId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
                  <?php
}
?>
                  <?php
/*if($PrivilegioEliminar){
?>
<a href="javascript:FncBorrarSeleccionado('<?php echo $dat->IngId;?>');"><img src="imagenes/borrar.gif" width="19" height="19" border="0" title="Borrar" alt="[Borrar]"   /></a>
<?php
}*/
?>
                  
                  <?php
if($PrivilegioEditar){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->IngId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
                  <?php
}
?>
                  
                  <?php
if($PrivilegioVer){
?>
                  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->IngId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                  <?php
}
?>

<?php
if($PrivilegioVistaPreliminar){
?>
	<a href="javascript:FncVistaPreliminar('<?php echo $dat->IngId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
<?php
}
?>
        
<?php
if($PrivilegioImprimir){
?>        

	<a href="javascript:FncImprmir('<?php echo $dat->IngId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
<?php
}
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



<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "FechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "FechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); 
</script>

<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

