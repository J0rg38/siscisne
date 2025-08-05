<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"BOLETA_".date('d-m-Y').".xls\";");
 
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

$GET_F = ($_GET['F']);


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
Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_tal = $_POST['Talonario'];
$POST_Moneda = $_POST['Moneda'];
$POST_npago = $_POST['CondicionPago'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_ChkMostrarNoProcesados = $_POST['ChkMostrarNoProcesados'];
$POST_Cancelado = $_POST['Cancelado'];




if(empty($POST_p)){
	$POST_p = '1';
}
if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'BolTiempoCreacion';
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

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}



$MostrarNoProcesados = false;

if($POST_ChkMostrarNoProcesados=="1"){
	$MostrarNoProcesados = true;
}



require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

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

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


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

$InsBoleta = new ClsBoleta();
$InsBoletaTalonario = new ClsBoletaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

$InsBoleta->UsuId = $_SESSION['SesionId'];
$InsBoleta->SucId = $_SESSION['SesionSucursal'];



     
//$ResBoleta = $InsBoleta->MtdObtenerBoletas("bol.BolId,bta.BtaNumero,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento,bol.AmoId,fim.FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,bol.OvvId,bol.BolDatoAdicional8",$POST_con,$POST_fil,$POST_ord,$POST_sen,(($GET_F=="1")?"":$POST_pag),$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL);


$ResBoleta = $InsBoleta->MtdObtenerBoletas("bol.BolId,bta.BtaNumero,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento,bol.AmoId,fim.FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,bol.OvvId,bol.BolDatoAdicional8",$POST_con,$POST_fil,$POST_ord,$POST_sen,(($GET_F=="1")?"":$POST_pag),$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
$ArrBoletas = $ResBoleta['Datos'];


$ArrBoletas = $ResBoleta['Datos'];
$BoletasTotal = $ResBoleta['Total'];
$BoletasTotalSeleccionado = $ResBoleta['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >SERIE</th>

                <th width="3%" >NUMERO</th>
                <th width="4%" >FECHA</th>
                <th width="6%" >NUM. DOC.</th>
                <th width="17%" >CLIENTE</th>
                <th width="4%" >REF</th>
                <th width="3%" >MODELO</th>
                <th width="4%" >COND. PAGO</th>
                <th width="5%" >MONEDA</th>
                <th width="3%" >T.C.</th>
                <th width="6%" >ORD. TRAB.</th>
                <th width="6%" >MOV. ALM.</th>
                <th width="4%" class="EstFacturaImprimirTabla" >NOTA CREDITO</th>
                <th width="4%" class="EstFacturaImprimirTabla" >NOTA DEBITO</th>
                <th width="3%" >ITEMS</th>
                <th width="3%" >ESTADO.</th>
                <th width="4%" >TOTAL</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrBoletas as $dat){
									
									
								?>

             <?php $dat->BolTotal = (($dat->BolTotal/(empty($dat->BolTipoCambio)?1:$dat->BolTipoCambio)));?>
              <?php $dat->BolSubTotal = (($dat->BolSubTotal/(empty($dat->BolTipoCambio)?1:$dat->BolTipoCambio)));?>
               <?php $dat->BolImpuesto = (($dat->BolImpuesto/(empty($dat->BolTipoCambio)?1:$dat->BolTipoCambio)));?>

         
              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->BtaNumero;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->BolId;  ?></td>
                <td align="right" ><?php echo ($dat->BolFechaEmision);?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" >
		
    
	        <?php echo ($dat->CliNombre);?>  <?php echo ($dat->CliApellidoPaterno);?>   <?php echo ($dat->CliApellidoMaterno);?>                </td>
                <td align="right" ><?php echo ($dat->EinVIN);?> <?php echo ($dat->BolDatoAdicional13);?></td>
                <td align="right" ><?php echo ($dat->BolDatoAdicional3); ?></td>
                <td align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->BolTipoCambio);?></td>
                <td align="right" ><?php echo $dat->FinId;?></td>
                <td align="right" ><?php echo $dat->AmoId;?></td>
                <td align="right" ><?php echo ($dat->BolNotaCredito); ?></td>
                <td align="right" ><?php echo ($dat->BolNotaDebito); ?></td>
                <td align="right" ><?php echo ($dat->BolTotalItems)  ; ?></td>
                <td align="right" >
                
                <?php echo $dat->BolEstadoDescripcion; ?>

                
				                </td>
                <td align="right" >
                

			 <?php echo number_format($dat->BolTotal,2); ?>                </td>
              </tr>

              <?php		$f++;
							
							$Total += $dat->BolTotal;
							$SubTotal += $dat->BolSubTotal;
							$Impuesto += $dat->BolImpuesto;
							
									}


									$SubTotal = number_format($SubTotal,2);									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									
									?>
                                    
                                    
                                         <tr>
                <td colspan="17" align="right"  >TOTALES:</td>
                <td align="right" >&nbsp;</td>
              </tr>
            </tbody>
      </table>
