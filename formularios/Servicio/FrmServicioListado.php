<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<?php $PrivilegioVehiculoMarcaEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMarca","Editar"))?true:false;?>
<?php $PrivilegioVehiculoMarcaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoMarca","Ver"))?true:false;?>

<?php $PrivilegioVehiculoModeloEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoModelo","Editar"))?true:false;?>
<?php $PrivilegioVehiculoModeloVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoModelo","Ver"))?true:false;?>

<?php $PrivilegioVehiculoVersionEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoVersion","Editar"))?true:false;?><?php $PrivilegioVehiculoVersionVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoVersion","Ver"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicio.js" ></script>

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
$POST_ServicioTipo = $_POST['CmpServicioTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];
$POST_EstadoVehicular = $_POST['EstadoVehicular'];
$POST_ConProforma = $_POST['ConProforma'];

$POST_VehiculoMarcaId = $_POST['VehiculoMarca'];
$POST_VehiculoModeloId = $_POST['VehiculoModelo'];
$POST_VehiculoVersionId = $_POST['VehiculoVersion'];




if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'SerTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_cam)){
	$POST_cam = 'SerVIN';
}

// Variables Extra
if(empty($POST_con)){
	$POST_con = "contiene";
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjServicio.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsServicio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');


//INSTANCIAS
$InsServicio = new ClsServicio();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccServicio.php');
//DATOS
//////MtdObtenerServicios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL)

  
//MtdObtenerServicios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="SerFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL)

$ResServicio = $InsServicio->MtdObtenerServicios("ein.SerId,ein.SerVIN,VmaNombre,VmoNombre,VveNombre,SerAnoFabricacion,SerNumeroMotor,SerPlaca,SerPoliza,SerComprobanteCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,NULL,NULL,$POST_EstadoVehicular,$POST_VehiculoMarcaId,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma);
$ArrServicios = $ResServicio['Datos'];
$ServiciosTotal = $ResServicio['Total'];
$ServiciosTotalSeleccionado = $ResServicio['TotalSeleccionado'];


$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_Marca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$RepVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,"VveNombre","ASC",NULL);
$ArrVehiculoVersiones = $RepVehiculoVersion['Datos'];

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmServicioListado {
    //put your code here  
}
*/

?>
<script type="text/javascript">

var VehiculoMarcaId = "<?php echo $POST_VehiculoMarcaId;?>";
var VehiculoModeloId = "<?php echo $POST_VehiculoModeloId;?>";
var VehiculoVersionId = "<?php echo $POST_VehiculoVersionId;?>";

</script>

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
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE SERVICIOS</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $ServiciosTotalSeleccionado;?></b> de <b><?php echo $ServiciosTotal;?></b> registros.</td>
</tr>
<tr>
  <td align="right">
  
<input type="hidden" name="CmpServicioTipo" id="CmpServicioTipo" value="" />
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
       <!--<select class="EstFormularioCombo" name="Cam" id="Cam">
         <option value="SerId" <?php if($POST_cam=="SerId"){ echo 'selected="selected"';}?>>Id</option>
         <option value="SerVIN" <?php if($POST_cam=="SerVIN"){ echo 'selected="selected"';}?>>VIN</option>
         <option value="VmaNombre" <?php if($POST_cam=="VmaNombre"){ echo 'selected="selected"';}?>>Marca</option>
         <option value="VmoNombre" <?php if($POST_cam=="VmoNombre"){ echo 'selected="selected"';}?>>Modelo</option>
         <option value="SerAnoFabricacion" <?php if($POST_cam=="SerAnoFabricacion"){ echo 'selected="selected"';}?>>Modelo</option>
         <option value="SerNumeroMotor" <?php if($POST_cam=="SerNumeroMotor"){ echo 'selected="selected"';}?>>Nro. Motor</option>
         <option value="SerPlaca" <?php if($POST_cam=="SerPlaca"){ echo 'selected="selected"';}?>>Placa</option>
         <option value="SerPoliza" <?php if($POST_cam=="SerPoliza"){ echo 'selected="selected"';}?>>Poliza</option>
       </select>-->
            
            
            
                
            Estado:
 <select class="EstFormularioCombo" name="Est" id="Est">
        <option <?php if($POST_est==""){ echo 'selected="selected"';}?> value="">Todos</option>
                <option <?php if($POST_est=="1"){ echo 'selected="selected"';}?> value="1">En actividad</option>
                <option <?php if($POST_est=="2"){ echo 'selected="selected"';}?> value="2">Sin actividad</option>
                </select>

		<!--<select name="Car" id="Car" class="EstFormularioCombo">
		  <option value=""  <?php if($POST_car==true){ echo 'selected="selected"';}?> >Listado Avanzado</option>
		  <option value="false"  <?php if($POST_car==false){ echo 'selected="selected"';}?>>Listado Simple </option>
	    </select>-->
	  <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
  <td width="87%" valign="top">
    
    
    
    
    
  <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="2%" >#</th>
        <th width="2%" >
          
          <input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>
        
        <th width="9%" ><?php
				if($POST_ord == "SerId"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SerId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SerId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{

				?>
          <a href="javascript:FncOrdenar('SerId','ASC');"> Id.  </a>
          <?php
				}
				?></th>
        <th width="38%" ><?php
				if($POST_ord == "SerNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SerNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SerNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('SerNombre','ASC');"> Nombre </a>
          <?php
				}
				?></th>
        <th width="13%" ><?php
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
        <th width="6%" ><?php
				if($POST_ord == "SerImporte"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SerImporte','ASC');"> Importe <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SerImporte','DESC');"> Importe <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('SerImporte','ASC');"> Importe </a>
          <?php
				}
				?></th>
        <th width="3%" ><?php
				if($POST_ord == "SerEstado"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('SerEstado','ASC');"> Est. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SerEstado','DESC');"> Est. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('SerEstado','ASC');"> Est. </a>
          <?php
				}
				?></th>
        <th width="12%" >
          <?php
				if($POST_ord == "SerTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('SerTiempoCreacion','ASC');">
            Fecha de Creacion
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('SerTiempoCreacion','DESC');">
            
            Fecha de Creacion
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('SerTiempoCreacion','ASC');">
            Fecha de Creacion
            </a>
          
          <?php
				}
				?>			    </th>
        <th width="15%" >Acciones</th>
        </tr>
      </thead>
    
    <tfoot class="EstTablaListadoFoot">
      
      <tr>
        
        <td colspan="9" align="center">
          
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
            <option <?php if($POST_num==$ServiciosTotal){ echo 'selected="selected"';}?> value="<?php echo $ServiciosTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ServiciosTotal;
					//}else{
					//	$tregistros = ($ServiciosTotalSeleccionado);
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

								foreach($ArrServicios as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td width="2%" align="center"  >
        
        <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->SerId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->SerId; ?>" />				</td>
      
      <td align="right" valign="middle" width="9%"   >
	  
      
      <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->SerId;?>">
	  <?php echo $dat->SerId;  ?>
      </a>
      
      </td>
      <td align="right" valign="middle" width="38%"   ><?php echo $dat->SerNombre;  ?></td>
      <td align="right" valign="middle" width="13%"   ><?php echo $dat->MonSimbolo;  ?></td>
      <td align="right" valign="middle" width="6%"   ><?php echo number_format($dat->SerImporte,2);  ?></td>
      <td  width="3%" align="right" ><?php
			switch($dat->SerEstado){
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
      <td  width="12%" align="right" ><?php echo ($dat->SerTiempoCreacion);?></td>
      <td  width="15%" align="center" >
        
<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->SerId;?>&TipoTabla=v2&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>
      
  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->SerId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->SerId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->SerId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?></td>
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

