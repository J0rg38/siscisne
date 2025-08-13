<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") ){
?>


<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCobro.js" ></script>

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
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Estado = $POST_['Estado'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'OcbTiempoModificacion';
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

if(empty($POST_finicio)){
$POST_finicio = "01/01/".date("Y");
}

if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}



include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCobro.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsOrdenCobro.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsOrdenCobroComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsOrdenCobro = new ClsOrdenCobro();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCobro.php');
//MtdObtenerOrdenCobros($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'OcbId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL)
$ResOrdenCobro = $InsOrdenCobro->MtdObtenerOrdenCobros("OcbId,OvvId,VdiId","contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_Estado,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda);

$ArrOrdenCobros = $ResOrdenCobro['Datos'];
$OrdenCobrosTotal = $ResOrdenCobro['Total'];
$OrdenCobrosTotalSeleccionado = $ResOrdenCobro['TotalSeleccionado'];


 
$ResCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaId","ASC",NULL,1);
$ArrCondicionPagos = $ResCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">




</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">LISTADO  DE ORDENES DE COBRO</span></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $OrdenCobrosTotalSeleccionado;?></b> de <b><?php echo $OrdenCobrosTotal;?></b> registros.</td>
  <td width="53%" align="right">
    
    
   
      <table width="100%" border="0" cellpadding="2" cellspacing="4" class="EstTablaTotales">
      <tr>
        <td width="65%" align="right">&nbsp;</td>
        <td width="35%" align="right">&nbsp;</td>
      </tr>
      </table>
    
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
    
    
     <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
<!--    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="AmoId" <?php if($POST_cam=="AmoId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="CprId" <?php if($POST_cam=="CprId"){ echo 'selected="selected"';}?>>Cot. de Repuesto</option>
      </select>-->
    Estado
    <select class="EstFormularioCombo" name="Estado" id="Estado">
      <option value="" >Todos</option>
      <option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
      <option value="3" <?php if($POST_Estado==3){ echo 'selected="selected"';}?>>Realizado</option> 
      <option value="6" <?php if($POST_Estado==6){ echo 'selected="selected"';}?>>Anulado</option>  
      </select>
      
      Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/".date("m/Y");}else{ echo $POST_finicio; }?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
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
                <th width="4%" ><?php
				if($POST_ord == "OcbId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcbId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcbId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcbId','ASC');"> Id. </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "VdiId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('VdiId','DESC');"> Ord. Venta <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('VdiId','ASC');"> Ord. Venta </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "OvvId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OvvId','DESC');"> Ord. Venta Veh. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OvvId','ASC');"> Ord. Venta Veh. </a>
                  <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "TdoNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('TdoNombre','DESC');"> Tipo Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('TdoNombre','ASC');"> Tipo Doc. </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CliNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumento','ASC');"> Num. Doc. </a>
                <?php
				}
				?></th>
                <th width="18%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Cliente </a>
                <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "OcbFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcbFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcbFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcbFecha','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "NpaNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('NpaNombre','ASC');"> Cond. Pago <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('NpaNombre','DESC');"> Cond. Pago <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('NpaNombre','ASC');"> Cond. Pago </a>
                  <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "MonNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('MonNombre','DESC');"> Moneda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('MonNombre','ASC');"> Moneda </a>
                  <?php
				}
				?></th>
                <th width="3%" ><?php
				if($POST_ord == "OcbTipoCambio"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcbTipoCambio','ASC');"> T.C. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcbTipoCambio','DESC');"> T.C. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OcbTipoCambio','ASC');"> T.C. </a>
                  <?php
				}
				?></th>
                <th width="8%" ><?php
				if($POST_ord == "OcbMonto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcbMonto','ASC');"> Monto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcbMonto','DESC');"> Monto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('OcbMonto','ASC');"> Monto </a>
                  <?php
				}
				?></th>
                <th width="7%" > <?php
				if($POST_ord == "OcbTiempoModificacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('OcbTiempoModificacion','ASC');"> U.A. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('OcbTiempoModificacion','DESC');"> U.A. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('OcbTiempoModificacion','ASC');"> U.A. </a>
                  <?php
				}
				?></th>
                <th width="13%" >Acciones</th>
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

				  <option <?php if($POST_num==$OrdenCobrosTotal){ echo 'selected="selected"';}?> value="<?php echo $OrdenCobrosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $OrdenCobrosTotal;
					//}else{
					//	$tregistros = ($OrdenCobrosTotalSeleccionado);
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

				foreach($ArrOrdenCobros as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >
                  
                <input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->AmoId; ?>" />				</td>
                <td width="4%" align="right" valign="middle"   ><?php echo $dat->OcbId;  ?></td>
                <td width="5%" align="right" valign="middle"   ><?php echo $dat->VdiId;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->OvvId;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->TdoNombre;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->CliNumeroDocumento;  ?></td>
                <td  width="18%" align="right" ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->OcbFecha; ?></td>
                <td  width="9%" align="right" ><?php echo $dat->NpaNombre; ?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->OcbTipoCambio);?></td>
                <td  width="8%" align="right" ><?php echo number_format($dat->OcbMonto,2); ?></td>
                <td  width="7%" align="right" ><?php echo ($dat->OcbTiempoModificacion);?></td>

                <td  width="13%" align="center" >
                  
                  
                  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->OcbId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
                  
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->OcbId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
                  
                  
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->OcbId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>



<?php
			if($PrivilegioVistaPreliminar){
			?>
            
            <a href="javascript:FncOrdenCobroVistaPreliminar('<?php echo $dat->OcbId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
            
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
     <a href="javascript:FncOrdenCobroImprmir('<?php echo $dat->OcbId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
     
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

