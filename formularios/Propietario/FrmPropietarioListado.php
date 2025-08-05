<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioEliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Eliminar"))?true:false;?>
<?php $PrivilegioImportarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"ImportarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPropietario.js" ></script>

<?php
 /**
 *
 * @Autor: Ing. Jonathan Blanco Alave
 * @Contacto: jba80@ingenieros.com
 */

$POST_Campo = ($_GET['Cam']);
$POST_Filtro = ($_POST['Fil']);
  if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_Filtro = (empty($_POST['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_POST['Fil']);
   }
$POST_Orden = ($_GET['Ord']);
$POST_Sentido = ($_GET['Sen']);
$POST_Paginacion = ($_GET['Pag']);
$POST_p = ($_GET['P']);
$POST_num = ($_GET['Num']);
$POST_seleccionados = $_GET['cmp_seleccionados'];
$POST_acc = $_GET['Acc'];


$POST_Estado = $_GET['Estado'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '15';
}
if(empty($POST_Orden)){
	$POST_Orden = 'ProTiempoCreacion';
}

if(empty($POST_Sentido)){
	$POST_Sentido = 'DESC';
}

if(empty($POST_Paginacion)){
	$POST_Paginacion = '0,'.$POST_num;
}

/*
* Otras variables
*/


if(empty($POST_Estado)){
	$POST_Estado = 0;
}

settype($POST_PropietarioCategoria,"string");

include($InsProyecto->MtdFormulariosMsj("Propietario").'MsjPropietario.php');

require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsPropietario = new ClsPropietario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPropietario.php');

$ResPropietario = $InsPropietario->MtdObtenerPropietarios($POST_Campo,"contiene",$POST_Filtro,$POST_Orden,$POST_Sentido,$POST_Paginacion,$POST_PropietarioCategoria,$POST_Estado);
$ArrPropietarios = $ResPropietario['Datos'];
$PropietariosTotal = $ResPropietario['Total'];
$PropietariosTotalSeleccionado = $ResPropietario['TotalSeleccionado'];


/*
 * interface FrmPropietarioListado {
    //put your code here  
}
*/

?>


<form id="FrmListado" name="FrmListado"  enctype="multipart/form-data" method="GET" action="principal.php" >    

<input type="hidden" name="Mod" id="Mod" value="Propietario" />
<input type="hidden" name="Form" id="Form" value="Listado" />

<div class="EstCapMenu">
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
  <td height="25" align="center"><span class="EstFormularioTitulo">LISTAR PROPIETARIOS </span>
  
     (<b><?php echo $PropietariosTotalSeleccionado;?></b> de <b><?php echo $PropietariosTotal;?></b> elementos)     </td>
</tr>

<tr>
<td align="right">

		<input type="hidden" name="Acc" id="Acc" value="" />
        <input type="hidden" name="Ord" id="Ord" value="<?php echo $POST_Orden;?>" />
        <input type="hidden" name="Sen" id="Sen" value="<?php echo $POST_Sentido;?>" />
        <input type="hidden" name="Pag" id="Pag" value="<?php echo $POST_Paginacion;?>" />
        <input type="hidden" name="P" id="P" value="<?php echo $POST_p;?>" />
        
        <input name="cmp_seleccionados" type="hidden" id="cmp_seleccionados" />
        <input placeholder="Ingrese una palabra para buscar" class="EstFormularioCaja" name="Fil" type="text" id="Fil" value="<?php echo $POST_Filtro;?>" size="20" />


       <select class="EstFormularioCombo" name="Cam" id="Cam">
      	<option value="ProId" <?php if($POST_Campo=="ProId"){ echo 'selected="selected"';}?>>Id</option>

		<option value="ProNombre" <?php if($POST_Campo=="ProNombre"){ echo 'selected="selected"';}?>>Nombre</option>
        <option value="ProApellido" <?php if($POST_Campo=="ProApellido"){ echo 'selected="selected"';}?>>Apellidos</option>
        
        
        <option value="ProNumeroDocumento" <?php if($POST_Campo=="ProNumeroDocumento"){ echo 'selected="selected"';}?>>Num. Documento</option>
        
        <option value="ProDireccion" <?php if($POST_Campo=="ProDireccion"){ echo 'selected="selected"';}?>>Direccion</option>
        <option value="ProTelefono" <?php if($POST_Campo=="ProTelefono"){ echo 'selected="selected"';}?>>Telefono</option>
        <option value="ProCelular" <?php if($POST_Campo=="ProCelular"){ echo 'selected="selected"';}?>>Celular</option>
               
       </select>

		
       Estado:
		<select class="EstFormularioCombo" name="Estado" id="Estado">
        <option value="0" <?php if($POST_Estado==0){ echo 'selected="selected"';}?>>Todos</option>
        <option value="1" <?php if($POST_Estado==1){ echo 'selected="selected"';}?>>En actividad</option>
        <option value="2" <?php if($POST_Estado==2){ echo 'selected="selected"';}?>>Sin actividad</option>        
        </select>

		<input class="EstFormularioBoton" name="btn_buscar" type="submit" onProck="javascript:FncBuscar();" id="btn_buscar" value="BUSCAR" /></td>
</tr>
<tr>
<td>





<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" align="center" >#</th>
                <th width="2%" align="center" >

				<input onProck="javascript:FncSeleccionarTodo();" type="checkbox" name="cmp_seleccionar_todo" id="cmp_seleccionar_todo" />				</th>

                <th width="2%" align="center" ><?php
				if($POST_Orden == "ProId"){
					if($POST_Sentido == "DESC"){
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
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ProNumeroDocumento"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProNumeroDocumento','ASC');"> Num. Doc. <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProNumeroDocumento','DESC');"> Num. Doc. <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProNumeroDocumento','ASC');"> Num. Doc. </a>
                <?php
				}
				?></th>
                <th width="10%" align="center" ><?php
				if($POST_Orden == "ProNombre"){
					if($POST_Sentido == "DESC"){
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
                <th width="10%" align="center" ><?php
				if($POST_Orden == "ProApellido"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProApellido','ASC');"> Apellidos <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProApellido','DESC');"> Apellidos <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProApellido','ASC');"> Apellidos </a>
                <?php
				}
				?></th>
                <th width="11%" align="center" ><?php
				if($POST_Orden == "ProDireccion"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProDireccion','ASC');"> Direccion <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProDireccion','DESC');"> Direccion <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProDireccion','ASC');"> Direccion </a>
                <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ProTelefono"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProTelefono','ASC');"> Telefono <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProTelefono','DESC');"> Telefono <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProTelefono','ASC');"> Telefono </a>
                <?php
				}
				?></th>
                <th width="5%" align="center" ><?php
				if($POST_Orden == "ProCelular"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProCelular','ASC');"> Celular <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProCelular','DESC');"> Celular <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProCelular','ASC');"> Celular </a>
                <?php
				}
				?></th>
                <th width="6%" align="center" ><?php
				if($POST_Orden == "ProGarantia"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProGarantia','ASC');"> Garantia <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProGarantia','DESC');"> Garantia <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProGarantia','ASC');"> Garantia </a>
                <?php
				}
				?></th>
                <th width="4%" align="center" ><?php
				if($POST_Orden == "ProDeudaPendiente"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProDeudaPendiente','ASC');"> Deuda <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProDeudaPendiente','DESC');"> Deuda <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProDeudaPendiente','ASC');"> Deuda </a>
                <?php
				}
				?></th>
                <th width="9%" align="center" ><?php
				if($POST_Orden == "ProFechaRecibo"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProFechaRecibo','ASC');"> Fec. Recibo<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProFechaRecibo','DESC');"> Fec. Recibo <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProFechaRecibo','ASC');"> Fec. Recibo </a>
                <?php
				}
				?></th>
                <th width="9%" align="center" ><?php
				if($POST_Orden == "ProFechaReingreso"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProFechaReingreso','ASC');"> Fec. Reingreso<img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /></a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProFechaReingreso','DESC');"> Fec. Reingreso <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /></a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProFechaReingreso','ASC');"> Fec. Reingreso </a>
                <?php
				}
				?></th>
                <th width="4%" align="center" >
                  
                  <?php
				if($POST_Orden == "ProEstado"){
					if($POST_Sentido == "DESC"){
				?>
                  <a href="javascript:FncOrdenar('ProEstado','ASC');"> Estado <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" /> </a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProEstado','DESC');"> Estado <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" /> </a>
                  <?php
					}
				}else{


				?>
                  <a href="javascript:FncOrdenar('ProEstado','ASC');"> Estado  </a>
                  <?php
				}
				?>                </th>
                <th width="7%" align="center" >
                  <?php
				if($POST_Orden == "ProTiempoCreacion"){
					if($POST_Sentido == "DESC"){
				?>
                  
                  <a href="javascript:FncOrdenar('ProTiempoCreacion','ASC');">
                  Fecha Creacion
                  <img src="imagenes/ascendente.png" border="0" title="Ascendente" alt="[Ascendente]" width="15" height="15" />				</a>
                  <?php
					}else{
				?>
                  <a href="javascript:FncOrdenar('ProTiempoCreacion','DESC');">
                    
                  Fecha Creacion
                  <img src="imagenes/descendente.png" border="0" title="Descendente" alt="[Descendente]"  width="15" height="15" />				</a>
                  <?php
					}
				}else{

				?><a href="javascript:FncOrdenar('ProTiempoCreacion','ASC');">
                  Fecha Creacion
                  </a>
                  
                <?php
				}
				?>			    </th>
                <th width="7%" align="center" >Acciones</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="16" align="center">



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

				  <option <?php if($POST_num==$PropietariosTotal){ echo 'selected="selected"';}?> value="<?php echo $PropietariosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_Filtro)){
						$tregistros = $PropietariosTotal;
					//}else{
					//	$tregistros = ($ReclamosTotalSeleccionado);
					//}
					
					$cant_paginas=ceil($tregistros/$numxpag);
					?>



					<?php
					if($POST_p<>"1"){
					?>

					<a class="EPaginacion" href="javascript:FncPaginar('0,<?php echo $numxpag;?>','1');">
					Inicio					</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<=$cant_paginas & $POST_p<>"1"){

					$pagina = explode(",",$POST_Paginacion);

					?>
					<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]-$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p-1)?>');">Anterior</a>
					<?php
					}
					?>

					&nbsp;
					<?php
					$num = 0;
					
					for($i=1;$i<=$cant_paginas;$i++){
					?>
						
                        <a class="EPaginacion"  href="javascript:FncPaginar('<?php echo $num?>,<?php echo $numxpag;?>','<?php echo $i?>');" ><?php echo $i?></a>
					<?php
							$num = $num + $numxpag ;
						}
					?>

					&nbsp;
					<?php
					if($POST_p<$cant_paginas){
						$pagina = explode(",",$POST_Paginacion);
					?>
						<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($pagina[0]+$numxpag)?>,<?php echo $numxpag;?>','<?php echo ($POST_p+1)?>');">Siguiente</a>
					<?php
					}
					?>
					&nbsp;
					<?php
					if($POST_p<>$cant_paginas){
					?>
						<a class="EPaginacion"  href="javascript:FncPaginar('<?php echo ($num-$numxpag);?>,<?php echo $numxpag;?>','<?php echo ($i-1);?>');">Final</a>
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




								$pagina = explode(",",$POST_Paginacion);
								$f=$pagina[0]+1;

								foreach($ArrPropietarios as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td width="2%" align="center"  >

				<input   onclick="javascript:FncAgregarSeleccionado(this.value,'<?php echo $dat->ProId; ?>');" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]" value="<?php echo $dat->ProId; ?>" />				</td>

                <td align="right" valign="middle" width="2%"   ><?php echo $dat->ProId;  ?></td>
                <td align="right" valign="middle" width="6%"   ><?php echo $dat->ProNumeroDocumento;?></td>
                <td align="right" valign="middle" width="10%"   ><?php echo $dat->ProNombre; ?></td>
                <td  width="10%" align="right" ><?php echo $dat->ProApellido; ?></td>
                <td  width="11%" align="right" ><?php echo $dat->ProDireccion; ?></td>
                <td  width="6%" align="right" ><?php echo $dat->ProTelefono; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->ProCelular; ?></td>
                <td  width="6%" align="right" ><?php echo $dat->ProGarantia; ?></td>
                <td  width="4%" align="right" ><?php echo $dat->ProDeudaPendiente; ?></td>
                <td  width="9%" align="right" ><?php echo $dat->ProFechaRecibo; ?></td>
                <td  width="9%" align="right" ><?php echo $dat->ProFechaReingreso; ?></td>
                <td  width="4%" align="right" >
                  
                  <?php
			switch($dat->ProEstado){
				case 1:
			?>
                  <img src="imagenes/habilitado.gif" alt="[Habilitado]" title="Habilitado" width="20" height="20" />
                  <?php
				break;
				
				case 2:
			?>
                  <img src="imagenes/deshabilitado.gif" alt="[Deshabilitado]" title="Deshabilitado" width="20" height="20" />
                  <?php
				break;

			}
			?>   
                  
                  
                </td>
                <td  width="7%" align="right" ><?php echo ($dat->ProTiempoCreacion);?></td>
        <td  width="7%" align="center" >


<?php
if($PrivilegioEliminar){
?> 
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->ProId;?>');"> <img  src="imagenes/acciones/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}
?>


<?php
if($PrivilegioEditar){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->ProId;?>"><img src="imagenes/acciones/editar.gif" width="19" height="19" border="0" title="Modificar" alt="[Modificar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->ProId;?>"><img src="imagenes/acciones/ver.gif" width="19" height="19" border="0" title="Ver" alt="[Visualizar]"   /></a>
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

<?php
$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();

?>
<?php
}else{
echo ERR_GEN_101;
}
?>