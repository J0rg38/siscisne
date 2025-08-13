<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEditarId = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarId"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioGenerarPDF = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarPDF"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGuiaRemision.js"></script>
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
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_tal = $_POST['Talonario'];
$POST_can = $_POST['Can'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'GreTiempoCreacion';
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
$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}

if(empty($POST_con)){
	$POST_con = "contiene";
}

include($InsProyecto->MtdFormulariosMsj("GuiaRemision").'MsjGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsGuiaRemision = new ClsGuiaRemision();
$InsGuiaRemisionTalonario = new ClsGuiaRemisionTalonario();

$InsGuiaRemision->UsuId = $_SESSION['SesionId'];
$InsGuiaRemision->SucId = $_SESSION['SesionSucursal'];
	

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGuiaRemision.php');

//MtdObtenerGuiaRemisiones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'GreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL)

//MtdObtenerGuiaRemisiones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'GreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL)

$ResGuiaRemision = $InsGuiaRemision->MtdObtenerGuiaRemisiones("GreId,GrtNumero,CliNombre,CliNombreCompleto,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal);
$ArrGuiaRemisiones = $ResGuiaRemision['Datos'];
$GuiaRemisionesTotal = $ResGuiaRemision['Total'];
$GuiaRemisionesTotalSeleccionado = $ResGuiaRemision['TotalSeleccionado'];

$ResGuiaRemisionTalonario = $InsGuiaRemisionTalonario->MtdObtenerGuiaRemisionTalonarios(NULL,NULL,"GrtNumero","DESC",NULL,$POST_Sucursal);
$ArrGuiaRemisionTalonarios = $ResGuiaRemisionTalonario['Datos'];


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
			if($PrivilegioEditar){
			?>           
             
<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoPendienteSeleccionados();">
<img src="imagenes/submenu/pendiente.png" alt="[Act. Estado Pendiente]" title="Actualizar a estado PENDIENTE seleccionados" />Pendiente</a></div> 

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoEntregadoSeleccionados();">
<img src="imagenes/submenu/entregado.png" alt="[Act. Estado Entregado]" title="Actualizar a estado ENTREGADO seleccionados" />Entregado</a></div>

<div class="EstSubMenuBoton"><a href="javascript:FncActualizarEstadoAnuladoSeleccionados();">
<img src="imagenes/submenu/anulado.png" alt="[Act. Estado Anulado]" title="Actualizar a estado ANULADO seleccionados" />Anulado</a></div>


             <?php
			}
			?>   
            
            
            


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
  <td height="25">
    
    
  <span class="EstFormularioTitulo">LISTADO DE GUIAS DE REMISION</span>  </td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $GuiaRemisionesTotalSeleccionado;?></b> de <b><?php echo $GuiaRemisionesTotal;?></b> registros.</td>
</tr>
<tr>
<td align="right">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_ord;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_sen;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_pag;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        <input type="hidden" name="Can" id="Can" />

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
         <option value="GreId" <?php if($POST_cam=="GreId"){ echo 'selected="selected"';}?>>Id</option>
      	<option value="CliNombre,PrvNombre,SucNombre" <?php if($POST_cam=="CliNombre,PrvNombre,SucNombre"){ echo 'selected="selected"';}?>>Destinatario</option>
       
     </select>-->
     
     Talonario
     
     <select class="EstFormularioCombo" name="Talonario" id="Talonario">
            <option value="">Todos</option>
                        <?php
				foreach($ArrGuiaRemisionTalonarios as $DatGuiaRemisionTalonario){
				?>
                        <option value="<?php echo $DatGuiaRemisionTalonario->GrtId;?>" 
<?php  if($POST_tal==$DatGuiaRemisionTalonario->GrtId){ echo 'selected="selected"';}?> ><?php echo $DatGuiaRemisionTalonario->GrtNumero;?></option>
                        <?php
				}
				?>
                      </select>
		Estado
       <select class="EstFormularioCombo" name="Estado" id="Estado">
       <option value="0" <?php if($POST_estado==0){ echo 'selected="selected"';}?>>Todos</option>
      	<option value="1" <?php if($POST_estado==1){ echo 'selected="selected"';}?>>Pendiente</option>
       <option value="5" <?php if($POST_estado==5){ echo 'selected="selected"';}?>>Entregado</option>
              <option value="6" <?php if($POST_estado==6){ echo 'selected="selected"';}?>>Anulado</option>
       </select>
       		
        Fecha Inicio
			<input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/01/2014";}else{ echo $POST_finicio; }?>" size="10" maxlength="10"/>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
		Fecha Fin
        
		<input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="10" maxlength="10"/>
                                      
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td>





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
                <th width="4%" ><?php
				if($POST_ord == "GrtId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GrtId','ASC');"> Serie <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GrtId','DESC');"> Serie <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('GrtId','ASC');"> Serie </a>
                <?php
				}
				?></th>

                <th width="2%" ><?php
				if($POST_ord == "GreId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('GreId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "GreFechaInicioTraslado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreFechaInicioTraslado','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreFechaInicioTraslado','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GreFechaInicioTraslado','ASC');"> Fecha </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "CliNumeroDocumeto"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumeto','ASC');"> Num. Doc.<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumeto','DESC');"> Num. Doc.<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNumeroDocumeto','ASC');"> Num. Doc.</a>
                <?php
				}
				?></th>
                <th width="11%" ><?php
				if($POST_ord == "CliNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Destinatario<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('CliNombre','DESC');"> Destinatario<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('CliNombre','ASC');"> Destinatario</a>
                <?php
				}
				?></th>
                <th width="11%" ><?php
				if($POST_ord == "GreDestinatarioNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreDestinatarioNombre','ASC');"> Tercero <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreDestinatarioNombre','DESC');"> Tercero<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GreDestinatarioNombre','ASC');"> Tercero</a>
                <?php
				}
				?></th>
                <th width="13%" ><?php
				if($POST_ord == "GrePuntoPartida"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GrePuntoPartida','ASC');"> P.  Partida<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GrePuntoPartida','DESC');">P.  Partida<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GrePuntoPartida','ASC');"> P.  Partida </a>
                  <?php
				}
				?></th>
                <th width="14%" ><?php
				if($POST_ord == "GrePuntoLlegada"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GrePuntoLlegada','ASC');"> P. Llegada<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GrePuntoLlegada','DESC');"> P. Llegada<img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GrePuntoLlegada','ASC');"> P. Llegada </a>
                  <?php
				}
				?></th>
                <th width="6%" >Ref.:</th>
                <th width="3%" ><?php
				if($POST_ord == "GreEstado"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreEstado','ASC');"> <span title="Estado">Est.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreEstado','DESC');"> <span title="Estado">Est.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GreEstado','ASC');"> <span title="Estado">Est.</span>  </a>
                  <?php
				}
				?></th>
                <th colspan="2" >SUNAT</th>
                <th width="2%" ><?php
				if($POST_ord == "GreTotalItems"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreTotalItems','ASC');"> It. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreTotalItems','DESC');">  It. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('GreTotalItems','ASC');">  It. </a>
                <?php
				}
				?></th>
                <th width="6%" ><?php
				if($POST_ord == "GreTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('GreTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('GreTiempoCreacion','DESC');"> <span title="Ultima Actualizacion">Fecha Creacion</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('GreTiempoCreacion','ASC');"> <span title="Ultima Actualizacion">Fecha Creacion</span></a>
                  <?php
				}
				?></th>
                <th width="9%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="17" align="center">

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

				  <option <?php if($POST_num==$GuiaRemisionesTotal){ echo 'selected="selected"';}?> value="<?php echo $GuiaRemisionesTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $GuiaRemisionesTotal;
					//}else{
					//	$tregistros = ($GuiaRemisionesTotalSeleccionado);
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

								foreach($ArrGuiaRemisiones as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center"  >

				<input indice="<?php echo $f;?>"   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->GreId."%".$dat->GrtId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->GreId."%".$dat->GrtId; ?>" />				</td>
                <td align="right" valign="middle"   ><?php echo $dat->GrtNumero;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->GreId;  ?></td>
                <td align="right" ><?php echo ($dat->GreFechaInicioTraslado);?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></td>
                <td align="right" ><?php echo ($dat->GreDestinatarioNombre);?></td>
                <td align="right" ><?php echo ($dat->GrePuntoPartida);?></td>
                <td align="right" ><?php echo ($dat->GrePuntoLlegada);?></td>
                <td align="center" >
                  
                  
                  
                  <?php
				if($dat->GreAlmacenMovimiento=="Si"){
				?>
                  <a href="formularios/GuiaRemision/DiaAlmacenMovimientoListado.php?height=440&width=850&GreId=<?php echo $dat->GreId;?>&GrtId=<?php echo $dat->GrtId;?>" class="thickbox" title=""><?php echo $dat->GreAlmacenMovimiento;?></a>                
                  <?php	
				}
				?>
                
                
                    <?php
				if($dat->GreVehiculoMovimiento=="Si"){
				?>
                  <a href="formularios/GuiaRemision/DiaVehiculoMovimientoListado.php?height=440&width=850&GreId=<?php echo $dat->GreId;?>&GrtId=<?php echo $dat->GrtId;?>" class="thickbox" title=""><?php echo $dat->GreVehiculoMovimiento;?></a>                
                  <?php	
				}
				?>
                  
                  
                  
                <?php echo ($dat->TalId);?>
                
                   <?php echo ($dat->TptId);?>
                      <?php echo ($dat->TveId);?>
                
                
                </td>
                <td align="right" >
                  <?php 
				switch($dat->GreEstado){
					case 1:
				?>
                  <img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />
                  <?php	
				
				break;
										
					case 5:
				?>
                  
                  <img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />                
                  <?php	
					break;
					case 6:
				?>
                  
                  <img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />                
                <?php	
					break;
				}
				?>                </td>
                <td width="2%" align="right" ><a href="javascript:FncBoletaSunatHistorialCargar('<?php echo $dat->GreId;?>','<?php echo $dat->BtaId;?>');" >
                  <?php
switch($dat->GreSunatUltimaAccion){
	case "ALTA":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_alta.png" alt="Solicitud de alta" title="Solicitud de alta" border="0" />
                  <?php	
	break;	
	
	case "BAJA":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_baja.png" alt="Solicitud de baja" title="Solicitud de baja" border="0" />
                  <?php
	break;
	
	default:
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin solicitud" title="Sin solicitud" border="0" />
                  <?php
	break;
}
?>
                </a></td>
                <td width="4%" align="right" ><?php
switch($dat->GreSunatUltimaRespuesta){
	case "APROBADO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_aprobado.png" alt="Aprobado" title="Aprobado" border="0" />
                  <?php	
	break;	
	
	case "RECHAZO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_rechazado.png" alt="Rechazado" title="Rechazado" border="0" />
                  <?php
	break;
	
	case "EXCEPCION":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_excepcion.png" alt="Excepcion" title="Excepcion" border="0" />
                  <?php
	break;
	
	case "OBSERVADO":
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_observado.png" alt="Observado" title="Observado" border="0" />
                  <?php
	break;
	
	default:
?>
                  <img width="25" height="25" src="imagenes/estado/sunat_sin_procesar.png" alt="Sin respuesta" title="Sin respuesta" border="0" />
                <?php
	break;
}
?></td>
                <td align="right" ><?php echo ($dat->GreTotalItems);?></td>
                <td align="right" ><?php echo ($dat->GreTiempoCreacion);?></td>
                <td align="center" >
                  
                  
  <?php
if($PrivilegioAuditoriaVer){
?>
  <a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
                  <?php
}
?>
                  
                  
  <?php
if($PrivilegioEliminar & $dat->GreCierre==1){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->GreId."%".$dat->GrtId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
                  
                  
                  
  <?php
if($PrivilegioEditar & $dat->GreCierre==1){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
                  
                  
  <?php
if($PrivilegioEditarId & $dat->GreCierre==1){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=EditarId&Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>"><img src="imagenes/editarid.gif" width="19" height="19" border="0" title="Editar Codigo" alt="[ECodigo]"   /></a>
  <?php
}
?>
                  
                  
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>
                  
                  
                  
                  <?php
			if($PrivilegioVistaPreliminar){
			?>
                  
                  <a href="javascript:FncGuiaRemisionVistaPreliminar('<?php echo $dat->GreId;?>','<?php echo $dat->GrtId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
                  
                  <?php
			if($PrivilegioImprimir){
			?>      
                  
                  <a href="javascript:FncGuiaRemisionImprmir('<?php echo $dat->GreId;?>','<?php echo $dat->GrtId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                  
                  <?php
			}
			?>
                  
                  
                              
             <?php
// deb($PrivilegioGenerarPDF);
if($PrivilegioGenerarPDF ){
?>
	<a href="javascript:FncGuiaRemisionGenerarPDF('<?php echo $dat->GreId;?>','<?php echo $dat->GrtId;?>');"><img src="imagenes/acciones/pdf.png" alt="[Generar PDF]" title="Generar PDF" width="19" height="19" border="0" /></a>
<?php
}
?>  


                  <?php

if($PrivilegioVer ){
?>
                  
  <a href="javascript:FncGuiaRemisionSunatTareasv2('<?php echo $dat->GreId;?>','<?php echo $dat->GrtId;?>','<?php echo $dat->FacSunatRespuestaTicket;?>','<?php echo $dat->FacSunatRespuestaEnvioCodigo;?>','<?php echo $dat->FacSunatUltimaRespuesta;?>','<?php echo $dat->FacSunatRespuestaBajaTicket;?>');"><img src="imagenes/sunat/tareas_sunat.png" alt="[Tareas SUNAT v2]" title="Tareas SUNAT v2" width="19" height="19" border="0" /></a>
                  
  <?php
}
?>       
                  
                  <?php
			/*if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>GuiaRemision/FrmGuiaRemisionImprimir.php?Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncPopUp('<?php echo $InsProyecto->MtdRutFormularios();?>GuiaRemision/FrmGuiaRemisionImprimir.php?Id=<?php echo $dat->GreId;?>&Ta=<?php echo $dat->GrtId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
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

