<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDENES_VENTA_VEHICULO_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EXPORTAR A EXCEL - ORDENES DE VENTA DE VEHICULOS</title>
</head>
<body>

<?php

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();
//$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","AccesoTotal"))?true:false;

$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","AccesoTotal"))?true:false;



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
$POST_ActaEntrega = $_POST['CmpActaEntrega'];
$POST_Moneda = $_POST['Moneda'];	

//if(!$_POST){
//	$POST_Moneda = "MON-10001";
//}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '20';
}
if(empty($POST_ord)){
	$POST_ord = 'OvvTiempoCreacion';
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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');




require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');



$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

if($PrivilegioAccesoTotal){
	
//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0)
	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL,NULL,$POST_ActaEntrega);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];

}else{

	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,EinVIN,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,$_SESSION['SesionPersonal'],NULL,0,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL,NULL,$POST_ActaEntrega);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];

}


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];



$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MonId = empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

?>



<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >ID</th>
                <th width="5%" >FECHA</th>
                <th width="9%" >NUM. DOC.</th>
                <th width="25%" >CLIENTE</th>
                <th width="5%" >TELEFONO</th>
                <th width="5%" >CELULAR</th>
                <th width="5%" >0VIN</th>
                <th width="5%" >VEHICULO</th>
                <th width="7%" >NRO. MOTOR</th>
                <th width="6%" >AÑO FAB.</th>
                <th width="7%" >AÑO MOD.</th>
                <th width="6%" >COLOR</th>
                <th width="6%" >PROF. VEH.</th>
                <th width="5%" >COMPROB</th>
                <th width="5%" >E. INMEDIATA</th>
                <th width="5%" >F. ENTREGA</th>
                <th width="5%" >
                  
                  NUM. COMPROB.
                  
                </th>
                <th width="2%" >ABONOS</th>
                <th width="5%" >APROB 1 </th>
                <th width="5%" >APROB 2</th>
                <th width="6%" >MONEDA</th>
                <th width="7%" >TOTAL</th>
                <th width="5%" >CANCELADO</th>
                <th width="5%" >ESTADO</th>
                <th width="4%" >ASESOR DE VENTAS</th>
                <th width="4%" >FECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">

              <tr>

                <td colspan="27" align="center">&nbsp;</td>
              </tr>
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrOrdenVentaVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="4%"   >
				
			
				<?php echo $dat->OvvId;  ?>
             
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->OvvFecha;  ?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="25%" align="left" >
                  
                  
                  - <?php echo ($dat->CliNombre);?>
                  <?php echo ($dat->CliApellidoPaterno);?>
                  <?php echo ($dat->CliApellidoMaterno);?>
                  
                  
                  
                  
                  
                  <?php
				 $InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
				 
				 $ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','Desc',NULL,$dat->OvvId);
				 $ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

//deb( $ArrOrdenVentaVehiculoPropietarios);
				 ?>
                  
                  <?php
				 if(!empty($ArrOrdenVentaVehiculoPropietarios)){
					 foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
				?>
                  <?php
					if($DatOrdenVentaVehiculoPropietario->CliId <> $dat->CliId){
					?><br />
                  
                  
                  
                  
                  
                  
                  - <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?>
                  <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?>
                  <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>
                  
                  
                  <?php
					}
					?>
                  
                  
                  <?php		 
					 }
				 }
				 ?>
                  
                  
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->CliTelefono;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->CliCelular;  ?></td>
                <td  width="5%" align="right" >
                  
                  
                  
                  <?php echo ($dat->EinVIN);?>
                  
                  
                  
                <?php //echo ($dat->EinVIN);?></td>
                <td  width="5%" align="left" bgcolor="<?php echo $Color;?>" ><b>Marca:</b> <?php echo ($dat->VmaNombre);?>
                  <b>Modelo:</b> <?php echo ($dat->VmoNombre);?>
                  <b>Version:</b> <?php echo ($dat->VveNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->EinNumeroMotor);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->EinAnoFabricacion);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->EinAnoModelo);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvColor);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->CveId);?></td>
                <td  width="5%" align="right" >
                  <?php
				switch($dat->OvvComprobanteVenta){
					case "F":
				?>
                  FACTURA
                  <?php	
					break;
					
					case "B":
				?>
                  BOLETA
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                  
                  
                </td>

                <td  width="5%" align="right" ><?php
				switch($dat->OvvInmadiata){
					case 1:
				?>
                  Si
                  <?php	
					break;
					
					case 2:
				?>
                  No
  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
				?></td>
                <td  width="5%" align="right" ><?php echo $dat->OvvActaEntregaFecha;  ?></td>
                <td  width="5%" align="right" >
                  
                  
                  <?php
				switch($dat->OvvComprobanteVenta){
					case "F":
				?>
 <a href="javascript:FncFacturaVistaPreliminar('<?php echo $dat->FacId;?>','<?php echo $dat->FtaId;?>');"><?php echo $dat->OvvFacturaNumero?></a>
 
				  <?php	
					break;
					
					case "B":
				?>
                 <a href="javascript:FncBoletaVistaPreliminar('<?php echo $dat->BolId;?>','<?php echo $dat->BtaId;?>');"> <?php echo $dat->OvvBoletaNumero?></a>
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                  
                </td>
                <td  width="2%" align="right" >
                  
                  
                  
                  <?php
if($PrivilegioPagoListado and $dat->OvvPago == "Si"){
?>
                 Tiene Abonos
  <?php
}else{
?>
                  No tiene Abonos
  <?php	
}
?>
                  
                  
                  
  <?php
/*if($PrivilegioPagoListado){
?>
                  <a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('Listado','<?php echo $dat->OvvId;?>');" >Ord. Cobro / Abonos</a>
                  <?php
}*/
?>
                  
                  
</td>
                <td  width="5%" align="center" >
                
                
                <?php
				switch($dat->OvvAprobacion1){
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
				?>
                
                </td>
                <td  width="5%" align="center" >
                
                  <?php
				switch($dat->OvvAprobacion2){
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
				?>
                
                </td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="7%" align="right" ><?php $dat->OvvTotal = (($dat->OvvTotal/(empty($dat->OvvTipoCambio)?1:$dat->OvvTipoCambio)));?>
                  <?php echo number_format($dat->OvvTotal,2); ?>
                  <?php //$dat->OvvTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->OvvTotal:($dat->OvvTotal/$dat->OvvTipoCambio));?>
                  <?php //echo number_format($dat->OvvTotal,2);?></td>
                <td  width="5%" align="right" >
<?php echo $dat->OvvCancelado;  ?></td>
                <td  width="5%" align="right" >
                
                  <?php
				  echo $dat->OvvEstadoDescripcion;
				  ?>
                 </td>
                <td  width="4%" align="right" ><?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OvvTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->OvvSubTotal;
									$Impuesto += $dat->OvvImpuesto ;
									$Total += $dat->OvvTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table>
      
      
</body>
</html>