<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"REPORTE_FECHAS_ENTREGA_".date('d-m-Y').".xls\";");
 
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
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Moneda = $_POST['Moneda'];

//if(!$_POST){
//	$POST_Moneda = "MON-10001";	
//}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'AvvTiempoCreacion';
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

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}

$POST_pag = "";

require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');


$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();


//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false)
$ResAsignacionVentaVehiculo = $InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculos("AvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,NULL,true);
$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];
$AsignacionVentaVehiculosTotal = $ResAsignacionVentaVehiculo['Total'];
$AsignacionVentaVehiculosTotalSeleccionado = $ResAsignacionVentaVehiculo['TotalSeleccionado'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="4%" >FECHA</th>
                <th width="3%" >ORD. VEN. VEH.</th>
                <th width="3%" >APROBADO</th>
                <th width="3%" >SUCURSAL</th>
                <th width="4%" >VIN</th>
                <th width="4%" >MARCA</th>
                <th width="5%" >MODELO</th>
                <th width="5%" >VERSION</th>
                <th width="4%" >COLOR</th>
                <th width="5%" >AÑO FAB.</th>
                <th width="5%" >AÑO MOD.</th>
                <th width="5%" >NUM. DOC.</th>
                <th width="19%" >CLIENTE</th>
                <th width="2%" >FECHA ENTREGA</th>
                <th width="2%" >INICIAL</th>
                <th width="2%" >ABONOS</th>
                <th width="6%" >MONEDA</th>
                <th width="7%" >TOTAL</th>
                <th width="3%" >ESTADO</th>
                <th width="8%" >ASESOR DE VENTAS</th>
                <th width="10%" >FECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="23" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrAsignacionVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   >
				
				
				<?php echo $dat->AvvId;  ?>
              
                
                </td>
                <td  width="4%" align="right" ><?php echo $dat->AvvFecha;  ?></td>
                <td  width="3%" align="right" ><?php echo ($dat->OvvId);?></td>
                <td  width="3%" align="right" ><?php
				switch($dat->AvvAprobacion){
					case 1:
				?>
                 Aprobado
                  <?php	
					break;
					
					case 2:
				?>
                 Rechazado
                  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
				?></td>
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
                <td  width="5%" align="right" ><?php echo ($dat->EinAnoModelo);?></td>
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
				/* $InsAsignacionVentaVehiculoPropietario = new ClsAsignacionVentaVehiculoPropietario();
				 
				 $ResAsignacionVentaVehiculoPropietario = $InsAsignacionVentaVehiculoPropietario->MtdObtenerAsignacionVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->AvvId);
				 $ArrAsignacionVentaVehiculoPropietarios = $ResAsignacionVentaVehiculoPropietario['Datos'];

//deb( $ArrAsignacionVentaVehiculoPropietarios);
				 ?>
  <?php
				 if(!empty($ArrAsignacionVentaVehiculoPropietarios)){
					 foreach($ArrAsignacionVentaVehiculoPropietarios as $DatAsignacionVentaVehiculoPropietario){
				?>
  <?php
					if($DatAsignacionVentaVehiculoPropietario->CliId <> $dat->CliId){
					?>
  <br />
  <?php
if($PrivilegioClienteVer){
?>
  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  > - <?php echo $DatAsignacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno;?> </a>
  <?php	
}else{
?>
                  - <?php echo $DatAsignacionVentaVehiculoPropietario->CliNombre;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno;?>
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
                <td  width="2%" align="right" ><?php echo $dat->OvvActaEntregaFecha;  ?></td>
                <td  width="2%" align="right" ><?php echo ($dat->OvvPagoInicialMonedaSimbolo);?> <?php echo number_format($dat->OvvPagoInicial,2);?></td>
                <td  width="2%" align="right" ><?php
//if($PrivilegioPagoListado and $dat->OvvPago == "Si"){
if( $dat->OvvPago == "Si"){
?>
                 Tiene Abonos
                  <?php
}else{
?>
                  No Tiene Abonos
  <?php	
}
?>
  <?php
/*if($PrivilegioPagoListado){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" >Ord. Cobro / Abonos</a>
                  <?php
}*/
?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="7%" align="right" >
				
				<?php $dat->OvvTotal = (($dat->OvvTotal/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));?>
                  <?php echo number_format($dat->OvvTotal,2);?>
                  
                  
                  
                  </td>
                <td  width="3%" align="right" >
                  
                  
                  <?php
				
					switch($dat->AvvEstado){
					
					  case 1:
						?>
                  <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />
                  <?php
					  break;
					
					  case 3:
						 
						 ?>
                  <img width="15" height="15" alt="[Aprobado]" title="Aprobado" src="imagenes/estado/realizado.gif" />
                  <?php
						 
					  break;	
					  
					  case 6:
				
				?>
                  <img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                  <?php
				
				break;
					
					  default:
						  ?>
                  -
                  <?php
					  break;					
					
					}
					
				?>
                  
                  
                  <?php
				  echo $dat->AvvEstadoDescripcion;
				  ?>
                  <?php
				  /*
				switch($dat->AvvEstado){
					
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
                <td  width="10%" align="right" ><?php echo ($dat->AvvTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->AvvSubTotal;
									$Impuesto += $dat->AvvImpuesto ;
									$Total += $dat->OvvTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table>
