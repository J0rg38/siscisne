<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantia.js" ></script>

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
		$POST_fil =  $_SESSION[$GET_mod."Filtro"];	
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
$POST_Prioridad = $_POST['Prioridad'];
$POST_Modalidad = $_POST['Modalidad'];


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FinTiempoCreacion';
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


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGarantia.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGarantia.php');

$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"73",$POST_Prioridad,$POST_Modalidad);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];
$FichaIngresosTotal = $ResFichaIngreso['Total'];
$FichaIngresosTotalSeleccionado = $ResFichaIngreso['TotalSeleccionado'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="POST" action="#" >    

<div class="EstCapMenu">





</div>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25" colspan="2">
    
    
  <span class="EstFormularioTitulo">MONITOREO DE ORDENES DE TRABAJO TERMINADAS POR REVISAR</span></td>
</tr>
<tr>
  <td width="47%">
    Mostrando <b><?php echo $FichaIngresosTotalSeleccionado;?></b> de <b><?php echo $FichaIngresosTotal;?></b> registros</td>
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
    
    
    <input class="EstFormularioCaja" name="Fil" type="text" id="Fil" value="<?php echo $POST_fil;?>" size="18" />
    
    <select class="EstFormularioCombo" name="Con" id="Con">
          <option <?php if($POST_con=="esigual"){ echo 'selected="selected"';}?> value="esigual">Es igual a</option>
          <option <?php if($POST_con=="noesigual"){ echo 'selected="selected"';}?> value="noesigual">No es igual a</option>
          <option <?php if($POST_con=="comienza"){ echo 'selected="selected"';}?> value="comienza">Comienza por</option>
          <option <?php if($POST_con=="termina"){ echo 'selected="selected"';}?> value="termina">Termina con</option>
          <option <?php if($POST_con=="contiene"){ echo 'selected="selected"';}?> value="contiene">Contiene</option>
          <option <?php if($POST_con=="nocontiene"){ echo 'selected="selected"';}?> value="nocontiene">No Contiene</option>
        </select>
    <select class="EstFormularioCombo" name="Cam" id="Cam">
      <option value="fin.FinId" <?php if($POST_cam=="fin.FinId"){ echo 'selected="selected"';}?>>Id</option>
      <option value="EinVIN" <?php if($POST_cam=="EinVIN"){ echo 'selected="selected"';}?>>VIN de Vehiculo</option>
      <option value="CliNombre" <?php if($POST_cam=="CliNombre"){ echo 'selected="selected"';}?>>Nombre del Cliente</option>
      <option value="CliNumeroDocumento" <?php if($POST_cam=="CliNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Doc. del Cliente</option>
      <option value="FinConductor" <?php if($POST_cam=="FinConductor"){ echo 'selected="selected"';}?>>Nombre del Conductor</option>
s      </select>


 
      Prioridad
      
		<select  class="EstFormularioCombo" name="Prioridad" id="Prioridad">
      <option value="" >Todos</option>
		<option  <?php if($POST_estado==1){ echo 'selected="selected"';}?> value="1">Urgente</option>
		<option  <?php if($POST_estado==2){ echo 'selected="selected"';}?> value="2">Normal</option>
		</select>
                        
                        
Fecha Inicio
    <input class="EstFormularioCajaFecha" name="FechaInicio" type="text"  id="FechaInicio" value="<?php if(empty($POST_finicio)){ echo "01/".date("m/Y");}else{ echo $POST_finicio; }?>" size="9" maxlength="10"/>
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    Fecha Fin
    
    <input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php if(empty($POST_ffin)){ echo date("d/m/Y");}else{ echo $POST_ffin; }?>" size="9" maxlength="10"/>
    
  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />
    
    <input class="EstFormularioBoton" name="btn_buscar" type="submit" onClick="javascript:FncBuscar();" id="btn_buscar" value="Filtrar" /></td>
</tr>
<tr>
<td colspan="2">





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="1%" >

				<input onClick="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="6%" >
                  
                  <?php
				if($POST_ord == "FinId"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Id. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinId','DESC');"> Id. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinId','ASC');"> Id.  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "FinPrioridad"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','ASC');"> Prioridad <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','DESC');"> Prioridad <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinPrioridad','ASC');"> Prioridad </a>
                <?php
				}
				?></th>
                <th width="3%" >
                
                                <?php
				if($POST_ord == "FinFecha"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinFecha','DESC');"> Fecha <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinFecha','ASC');"> Fecha </a>
                  <?php
				}
				?>                </th>
                <th width="3%" ><?php
				if($POST_ord == "FinHora"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinHora','ASC');"> Hora <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinHora','DESC');"> Hora <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinHora','ASC');"> Hora </a>
                <?php
				}
				?></th>
                <th width="4%" ><?php
				if($POST_ord == "PrvNumeroDocumento"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNumeroDocumento','ASC');"> Num. Doc. </a>
                <?php
				}
				?></th>
                <th width="12%" ><?php
				if($POST_ord == "PrvNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PrvNombre','DESC');"> Cliente <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('PrvNombre','ASC');"> Cliente  </a>
                  <?php
				}
				?></th>
                <th width="5%" ><?php
				if($POST_ord == "EinVIN"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> VIN <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('EinVIN','DESC');"> VIN <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('EinVIN','ASC');"> VIN </a>
                <?php
				}
				?></th>
                <th width="16%" ><?php
				if($POST_ord == "FinConductor"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinConductor','ASC');"> Conductor <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinConductor','DESC');"> Conductor <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinConductor','ASC');"> Conductor </a>
                <?php
				}
				?></th>
                <th width="7%" ><?php
				if($POST_ord == "FinVehiculoKilometraje"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','DESC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('FinVehiculoKilometraje','ASC');"> <span title="Kilometraje del Vehiculo">Km. Veh.</span> </a>
                <?php
				}
				?></th>
                <th width="23%" ><?php
				if($POST_ord == "PerNombre"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span> <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('PerNombre','DESC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span> <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('PerNombre','ASC');"> <span title="Kilometraje del Vehiculo"> Tecnico</span></a>
                  <?php
				}
				?></th>
                <th width="9%" ><?php
				if($POST_ord == "FinTiempoCreacion"){
					if($POST_sen == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','ASC');"> Fecha de Registro <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','DESC');"> Fecha de Registro <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{

				?>
                  <a href="javascript:FncOrdenar('FinTiempoCreacion','ASC');"> Fecha de Registro </a>
                <?php
				}
				?></th>
                <th width="5%" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="14" align="center">

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

				  <option <?php if($POST_num==$FichaIngresosTotal){ echo 'selected="selected"';}?> value="<?php echo $FichaIngresosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $FichaIngresosTotal;
					//}else{
					//	$tregistros = ($FichaIngresosTotalSeleccionado);
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

								foreach($ArrFichaIngresos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center"  ><?php echo $f;?></td>
                <td width="1%" align="center"  >

					<input   onclick="javascript:FncAgregarSeleccionado(this.value);" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->FinId; ?>" estado="<?php echo $dat->FinEstado;?>" />				    

					</td>
                    <td align="right" valign="middle" width="6%"   ><?php echo $dat->FinId;  ?></td>
                    <td  width="5%" align="right" >

						<?php
                        switch($dat->FinPrioridad){
                            case 1:
                        ?>
                          Urgente
                          <?php	
                            break;
                            
                            case 2:
                        ?>
                          Normal
                          <?php	
                            break;
                        }
                        ?>
                      
                    </td>
                    <td  width="3%" align="right" ><?php echo $dat->FinFecha;  ?></td>
                    <td  width="3%" align="right" ><?php echo $dat->FinHora;  ?></td>
                    <td  width="4%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                    <td  width="12%" align="right" ><?php echo ($dat->CliNombre);?></td>
                    <td  width="5%" align="right" ><?php echo ($dat->EinVIN);?></td>
                    <td  width="16%" align="right" ><?php echo ($dat->FinConductor);?></td>
                    <td  width="7%" align="right" ><?php echo ($dat->FinVehiculoKilometraje);?></td>
                    <td  width="23%" align="right" ><?php echo ($dat->PerNombre);?> <?php echo ($dat->PerApellidoPaterno);?> <?php echo ($dat->PerApellidoMaterno);?></td>
                    <td  width="9%" align="center" ><?php echo ($dat->FinTiempoCreacion);?></td>
                    <td  width="5%" align="center" >
                      
<?php
if($PrivilegioEditar){
?>		                
    <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Registrar&Id=<?php echo $dat->FinId;?>"><img src="imagenes/ver.gif" width="19" height="19" border="0" title="Revisar Ord. Trabaj. Terminado" alt="[Revisar Ord. Trabaj. Terminado]"   /></a>                

<?php
}
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

