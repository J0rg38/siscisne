<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<?php $PrivilegioListaPrecioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Ver"))?true:false;?>
<?php $PrivilegioListaPrecioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ListaPrecio","Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorComunicado.js" ></script>

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
$POST_sen = $_POST['Sen'] ?? '';
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

//Nuevo
$POST_ProveedorComunicadoTipo = $_POST['CmpProveedorComunicadoTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];
$POST_Referencia = $_POST['Referencia'];
$POST_ProveedorComunicadoCategoria = $_POST['CmpProveedorComunicadoCategoria'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}

//	$POST_num = '1500';
	
if(empty($POST_ord)){
	$POST_ord = 'PomTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

//$POST_pag = '822,1500';

if(empty($POST_cam)){
	$POST_cam = "ProAsunto";
}

// Variables Extra

if(empty($POST_con)){
	$POST_con = "contiene";
}


if(empty($POST_finicio)){
$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProveedorComunicado.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedorComunicado.php');


$InsProveedorComunicado = new ClsProveedorComunicado();


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProveedorComunicado.php');


//MtdObtenerProveedorComunicados($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PomId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResProveedorComunicado = $InsProveedorComunicado->MtdObtenerProveedorComunicados("PomCodigo,PomAsunto",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
$ArrProveedorComunicados = $ResProveedorComunicado['Datos'];
$ProveedorComunicadosTotal = $ResProveedorComunicado['Total'];
$ProveedorComunicadosTotalSeleccionado = $ResProveedorComunicado['TotalSeleccionado'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

/*
 * interface FrmProveedorComunicadoListado {
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



</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">LISTADO DE COMUNICADOS</span></td>
</tr>
<tr>
  <td>
    Mostrando <b><?php echo $ProveedorComunicadosTotalSeleccionado;?></b> de <b><?php echo $ProveedorComunicadosTotal;?></b> registros.</td>
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
        



         <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCajaBuscar" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
        <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
      </select>
      
        Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php  echo $POST_finicio; ?>" size="9" maxlength="10"/>
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo $POST_ffin;?>" size="9" maxlength="10"/>
    
  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
    
    
    
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
        <th width="13%" ><?php
				if($POST_ord == "PomCodigo"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('PomCodigo','ASC');"> Codigo <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('PomCodigo','DESC');"> Codigo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('PomCodigo','ASC');"> Codigo </a>
          <?php
				}
				?></th>
        <th width="6%" ><?php
				if($POST_ord == "PomFecha"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('PomFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('PomFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('PomFecha','ASC');"> Fecha </a>
          <?php
				}
				?></th>
        <th width="19%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Nombre <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /></a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Nombre <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /></a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Nombre </a>
          <?php
				}
				?></th>
        <th width="25%" >
          <?php
				if($POST_ord == "ProAsunto"){
					if($POST_sen == "DESC"){
				?>
          <a href="javascript:FncOrdenar('ProAsunto','ASC');"> Asunto <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" /> </a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProAsunto','DESC');"> Asunto <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  /> </a>
          <?php
					}
				}else{


				?>
          <a href="javascript:FncOrdenar('ProAsunto','ASC');"> Asunto  </a>
          <?php
				}
				?>		</th>
        <th width="3%" >Doc.</th>
        <th width="10%" >
          <?php
				if($POST_ord == "ProTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
          
          <a href="javascript:FncOrdenar('ProTiempoCreacion','ASC');">
            Fecha Creacion
            <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" align="absmiddle" />				</a>
          <?php
					}else{
				?>
          <a href="javascript:FncOrdenar('ProTiempoCreacion','DESC');">
            
            Fecha Creacion
            <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15"  align="absmiddle"  />				</a>
          <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('ProTiempoCreacion','ASC');">
            Fecha Creacion
            </a>
          
          <?php
				}
				?>			    </th>
        <th width="12%" >Acciones</th>
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
            <option <?php if($POST_num==$ProveedorComunicadosTotal){ echo 'selected="selected"';}?> value="<?php echo $ProveedorComunicadosTotal;?>">Todos</option>
            </select>
          
          <?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $ProveedorComunicadosTotal;
					//}else{
					//	$tregistros = ($ProveedorComunicadosTotalSeleccionado);
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

								foreach($ArrProveedorComunicados as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td width="2%" align="center"  >
        
        <input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->PomId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->PomId; ?>" />				</td>
      <td align="right" valign="middle" width="8%"   >
        <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PomId;?>"><?php echo $dat->PomId;  ?></a></td>
      <td width="13%" align="right" valign="middle"   ><?php echo $dat->PomCodigo; ?></td>
      <td width="6%" align="right" valign="middle"   ><?php echo $dat->PomFecha; ?></td>
      <td align="right" valign="middle" width="19%"   ><?php echo $dat->PrvNombre; ?> <?php echo $dat->PrvApellidoPaterno; ?> <?php echo $dat->PrvApellidoMaterno; ?></td>
      <td align="right" valign="middle" width="25%"   ><?php echo $dat->PomAsunto; ?></td>
      <td  width="3%" align="right" ><?php            
if(!empty($dat->PomArchivo)){
	
	$extension = strtolower(pathinfo($dat->PomArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->PomArchivo, '.'.$extension);  
?>
        <a target="_blank" href="subidos/comunicado_fotos/<?php echo $dat->PomArchivo;?>"  title=""><img  src="imagenes/documento.gif" alt="" width="20" height="20" border="0"  /></a>
        <?php	
}
?></td>
      <td  width="10%" align="right" ><?php echo ($dat->PomTiempoCreacion);?></td>
      <td  width="12%" align="center" >
        
        
        
<?php
if($PrivilegioAuditoriaVer){
?>
<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->PomId;?>&TipoTabla=v2&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
  <?php
}
?>




        
  <?php
if($PrivilegioEliminar){
?> 
  <a href="javascript:FncEliminarSeleccionado('<?php echo $dat->PomId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioEditar){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->PomId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
  <?php
}
?>
        
  <?php
if($PrivilegioVer){
?>
  <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->PomId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
  <?php
}
?>





</td>
      </tr>
    
    <?php		$f++;
	
	
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProveedorComunicadoVehiculoVersion.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProveedorComunicadoAno.php');
//
//$InsVehiculoVersion = new ClsVehiculoVersion();
//$InsProveedorComunicadoAno = new ClsProveedorComunicadoAno();
//
//$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveAsunto','ASC',NULL,NULL,NULL);
//$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
//
//foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
//
//	$InsProveedorComunicadoVehiculoVersion = new ClsProveedorComunicadoVehiculoVersion();
//	$InsProveedorComunicadoVehiculoVersion->PomId = $dat->PomId;
//	$InsProveedorComunicadoVehiculoVersion->VveId = $DatVehiculoVersion->VveId;
//	$InsProveedorComunicadoVehiculoVersion->PvvTiempoCreacion = date("Y-m-d H:i:s");
//	$InsProveedorComunicadoVehiculoVersion->PvvTiempoModificacion = date("Y-m-d H:i:s");
//	$InsProveedorComunicadoVehiculoVersion->MtdRegistrarProveedorComunicadoVehiculoVersion();	
//
//}
//
//for($i=date("Y")-10;$i<=(date("Y"));$i++){
//	$InsProveedorComunicadoAno = new ClsProveedorComunicadoAno();
//	$InsProveedorComunicadoAno->PomId = $dat->PomId;
//	$InsProveedorComunicadoAno->PanAno = $i;
//	$InsProveedorComunicadoAno->PanTiempoCreacion = date("Y-m-d H:i:s");
//	$InsProveedorComunicadoAno->PanTiempoModificacion = date("Y-m-d H:i:s");
//	$InsProveedorComunicadoAno->MtdRegistrarProveedorComunicadoAno();
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

