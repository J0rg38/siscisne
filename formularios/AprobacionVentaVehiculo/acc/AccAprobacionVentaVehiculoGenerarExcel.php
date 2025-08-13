<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"APROBACIONES_ORDEN_VENTA_VEHICULO_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


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
$POST_Sucursal = $_POST['CmpSucursal'];

if($_POST){
	$POST_Moneda = $_POST['Moneda'];	
}else{
	$POST_Moneda = "MON-10001";
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'AovTiempoCreacion';
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

require_once($InsPoo->MtdPaqLogistica().'ClsAprobacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');




$InsAprobacionVentaVehiculo = new ClsAprobacionVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResAprobacionVentaVehiculo = $InsAprobacionVentaVehiculo->MtdObtenerAprobacionVentaVehiculos("AovId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,NULL);
$ArrAprobacionVentaVehiculos = $ResAprobacionVentaVehiculo['Datos'];
$AprobacionVentaVehiculosTotal = $ResAprobacionVentaVehiculo['Total'];
$AprobacionVentaVehiculosTotalSeleccionado = $ResAprobacionVentaVehiculo['TotalSeleccionado'];


?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="4%" >FECHA</th>
                <th width="3%" >ORD. VEH. VEH.</th>
                <th width="3%" >SUCURSAL</th>
                <th width="4%" >VIN</th>
                <th width="4%" >MARCA</th>
                <th width="5%" >MODELO</th>
                <th width="5%" >VERSION</th>
                <th width="4%" >COLOR</th>
                <th width="5%" >AÑO FAB.</th>
                <th width="5%" >NUM. DOC.</th>
                <th width="19%" >CLIENTE</th>
                <th width="3%" >ESTADO</th>
                <th width="8%" >ASESOR DE VENTAS</th>
                <th width="10%" >FECHA CREACION</th>
                <th width="12%" >Acciones</th>
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

				  <option <?php if($POST_num==$AprobacionVentaVehiculosTotal){ echo 'selected="selected"';}?> value="<?php echo $AprobacionVentaVehiculosTotal;?>">Todos</option>
                </select>

				<?php

					$numxpag = $POST_num;

					//if(empty($POST_fil)){
						$tregistros = $AprobacionVentaVehiculosTotal;
					//}else{
					//	$tregistros = ($AprobacionVentaVehiculosTotalSeleccionado);
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
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrAprobacionVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->AovId;?>">
				<?php echo $dat->AovId;  ?>
                </a>
                
                </td>
                <td  width="4%" align="right" ><?php echo $dat->AovFecha;  ?></td>
                <td  width="3%" align="right" ><?php echo ($dat->OvvId);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->SucNombre);?></td>
                <td  width="4%" align="right" >
                  
                  
                  <?php
if($PrivilegioVehiculoIngresoEditar or $PrivilegioVehiculoIngresoVer){
?>
                  
  <a href="javascript:FncVehiculoIngresoCargarFormulario('<?php echo (($PrivilegioVehiculoIngresoEditar)?'Editar':'Ver');?>','<?php echo $dat->EinId?>');"  ><?php echo ($dat->EinVIN);?></a>
                  
  <?php
}else{
?>
  <?php echo ($dat->EinVIN);?>
  <?php	
}
?>
                  
                  
  <?php //echo ($dat->EinVIN);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoFabricacion);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="19%" align="left" ><?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  > - <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?> </a>
                  <?php	
}else{
?>
                  - <?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?>
  <?php	
}
?>
  <?php
				/* $InsAprobacionVentaVehiculoPropietario = new ClsAprobacionVentaVehiculoPropietario();
				 
				 $ResAprobacionVentaVehiculoPropietario = $InsAprobacionVentaVehiculoPropietario->MtdObtenerAprobacionVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->AovId);
				 $ArrAprobacionVentaVehiculoPropietarios = $ResAprobacionVentaVehiculoPropietario['Datos'];

//deb( $ArrAprobacionVentaVehiculoPropietarios);
				 ?>
  <?php
				 if(!empty($ArrAprobacionVentaVehiculoPropietarios)){
					 foreach($ArrAprobacionVentaVehiculoPropietarios as $DatAprobacionVentaVehiculoPropietario){
				?>
  <?php
					if($DatAprobacionVentaVehiculoPropietario->CliId <> $dat->CliId){
					?>
  <br />
  <?php
if($PrivilegioClienteVer){
?>
  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  > - <?php echo $DatAprobacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAprobacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAprobacionVentaVehiculoPropietario->CliApellidoMaterno;?> </a>
  <?php	
}else{
?>
                  - <?php echo $DatAprobacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAprobacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAprobacionVentaVehiculoPropietario->CliApellidoMaterno;?>
  <?php                        
}
?>
  <?php
					}
					?>
  <?php		 
					 }
				 }*/
				 ?></td>
                <td  width="3%" align="right" >
                
              
                
                  <?php
				  echo $dat->AovEstadoDescripcion;
				  ?>
                  <?php
				  /*
				switch($dat->AovEstado){
					
						case 1:
				?>
                  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                  <?php							
						break;	

					}*/
				?></td>
                <td  width="8%" align="right" ><?php echo $dat->PerNombreVendedor;?> <?php echo $dat->PerApellidoPaternoVendedor;?> <?php echo $dat->PerApellidoMaternoVendedor;?></td>
                <td  width="10%" align="right" ><?php echo ($dat->AovTiempoCreacion);?></td>
        <td  width="12%" align="center" >
<?php
if($PrivilegioAuditoriaVer){
?>
	<a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $dat->AovId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]" width="19" height="19" border="0" title="Auditar" /></a>
<?php
}
?>



<?php
if($PrivilegioEliminar and $dat->AovEstado == 1){
?>
<a href="javascript:FncEliminarSeleccionado('<?php echo $dat->AovId;?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar Aovpletamente"   /></a>
<?php
}
?>               
				
<?php
if($PrivilegioEditar and $dat->AovEstado == 1){
?>             
                       
<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $dat->AovId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>                 
				
<?php
}
?>				
	
<?php
if($PrivilegioVer){
?>		                
            <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->AovId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
    

<?php
}
?>



<?php
			if($PrivilegioVistaPreliminar){
			?>
         <a href="javascript:FncVistaPreliminar('<?php echo $dat->AovId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
     
                <a href="javascript:FncImprmir('<?php echo $dat->AovId;?>');"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
			<?php
			}
			?> 
  
			

			</td>
              </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->AovSubTotal;
									$Impuesto += $dat->AovImpuesto ;
									$Total += $dat->OvvTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table>
