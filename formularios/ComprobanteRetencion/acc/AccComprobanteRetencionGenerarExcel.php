<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"COMPROBANTE DE RETENCION_".date('d-m-Y').".xls\";");
 
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
$POST_tal = $_POST['Talonario'];
$POST_Moneda = $_POST['Moneda'];
$POST_npago = $_POST['CondicionPago'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CrnTiempoCreacion';
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



require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');


$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();


$ResComprobanteRetencion = $InsComprobanteRetencion->MtdObtenerComprobanteRetenciones("Crtnumero,CrnId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,CrnOrdenNumero,CrnSIAFNumero,CrnTotal,crn.AmoId,FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,crn.OvvId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$_SESSION['SisSucId'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda);
$ArrComprobanteRetenciones = $ResComprobanteRetencion['Datos'];
$ComprobanteRetencionesTotal = $ResComprobanteRetencion['Total'];
$ComprobanteRetencionesTotalSeleccionado = $ResComprobanteRetencion['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstComprobanteRetencionImprimirTabla" >

            <thead class="EstComprobanteRetencionImprimirTablaHead">

              <tr>
                <th width="8%" >#</th>
                <th width="8%" >SERIE</th>

                <th width="9%" >CODIGO</th>
                <th width="40%" >NUM. DOC. </th>
                <th width="40%" >CLIENTE</th>
                <th width="8%" >FECHA</th>
                <th width="9%" >COND. PAGO</th>
                <th width="9%" >MONEDA</th>
                <th width="9%" ><span title="Tipo de Cambio">T.C.</span></th>
                <th width="6%" class="EstTablaListado" >ORD. TRAB.</th>
                <th width="6%" class="EstTablaListado" >MOV. ALM.</th>
                <th width="9%" >SUB TOTAL</th>
                <th width="9%" >IMPUESTO</th>
                <th width="8%" >TOTAL</th>
              </tr>
            </thead>

            <tfoot class="EstComprobanteRetencionImprimirTablaFoot">
            </tfoot>

            <tbody class="EstComprobanteRetencionImprimirTablaBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
					$c = 1;
					
								foreach($ArrComprobanteRetenciones as $dat){

								?>





              <tr  >
                <td align="right" valign="middle" width="8%"   ><?php echo $c;?></td>
                <td align="right" valign="middle" width="8%"   ><?php echo $dat->CrtNumero;;  ?></td>

                <td align="right" valign="middle" width="9%"   ><?php echo $dat->CrnId;  ?></td>
                <td  width="40%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="40%" align="right" ><?php echo ($dat->CliNombre);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->CrnFechaEmision);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->MonNombre);?> (<?php echo ($dat->MonSimbolo);?>)</td>
                <td  width="9%" align="right" ><?php echo ($dat->CrnTipoCambio);?></td>
                <td align="right" class="EstTablaListado" >
                  <?php echo $dat->FinId;?> 
                 </td>
                <td align="right" class="EstTablaListado" > <?php echo $dat->AmoId;?> 
                 </td>
                <td  width="9%" align="right" ><?php $dat->CrnSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CrnSubTotal:($dat->CrnSubTotal/$dat->CrnTipoCambio));?>
                <?php echo number_format($dat->CrnSubTotal,2);?>
                </td>
                <td  width="9%" align="right" ><?php $dat->CrnImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CrnImpuesto:($dat->CrnImpuesto/$dat->CrnTipoCambio));?>
                <?php echo number_format($dat->CrnImpuesto,2);?>
                </td>
                <td  width="8%" align="right" ><?php $dat->CrnTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CrnTotal:($dat->CrnTotal/$dat->CrnTipoCambio));?>
                 <?php echo number_format($dat->CrnTotal,2);?>
                 </td>
              </tr>

              <?php		$f++;
			  			$c++;
			  		
					$SubTotal += $dat->CrnSubTotal;
					$Impuesto += $dat->CrnImpuesto;					
					$Total += $dat->CrnTotal;
					

									}

									?>
                                    
              <tr  >
                <td colspan="11" align="right" valign="middle"   >TOTALES:</td>
                <td align="right" ><?php echo number_format($SubTotal,2);?></td>
                <td align="right" ><?php echo number_format($Impuesto,2);?></td>
                <td align="right" ><?php echo number_format($Total,2);?></td>
              </tr>
            </tbody>
      </table>
