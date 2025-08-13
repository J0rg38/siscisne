<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"FACTURA_".date('d-m-Y').".xls\";");
 
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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$GET_F = ($_GET['F']);


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
	$POST_ord = 'FacTiempoCreacion';
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



require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');
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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

$InsFactura = new ClsFactura();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsNotaCredito = new ClsNotaCredito();




$ResFactura = $InsFactura->MtdObtenerFacturas("fta.Ftanumero,fac.FacId,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento,fac.AmoId,fim.FinId,amo.VdiId,vdi.VdiOrdenCompraNumero,fac.OvvId,fac.FacDatoAdicional8",$POST_con,$POST_fil,$POST_ord,$POST_sen,(($GET_F=="1")?"":$POST_pag),$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado);
$ArrFacturas = $ResFactura['Datos'];




$FacturasTotal = $ResFactura['Total'];
$FacturasTotalSeleccionado = $ResFactura['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFacturaImprimirTabla" >

            <thead class="EstFacturaImprimirTablaHead">

              <tr>
                <th width="3%" >#</th>
                <th width="4%" >SERIE</th>

                <th width="5%" >NUMERO</th>
                <th width="4%" >FECHA</th>
                <th width="13%" >NUM. DOC. </th>
                <th width="28%" >CLIENTE</th>
                <th width="3%" class="EstTablaListado" >REF</th>
                <th width="3%" class="EstTablaListado" >MODELO</th>
                <th width="5%" >COND. PAGO</th>
                <th width="6%" >MONEDA</th>
                <th width="3%" ><span title="Tipo de Cambio">T.C.</span></th>
                <th width="4%" class="EstTablaListado" >ORD. TRAB.</th>
                <th width="4%" class="EstTablaListado" >MOV. ALM.</th>
                <th width="4%" >NOTA CREDITO</th>
                <th width="4%" >NOTA DEBITO</th>
                <th width="4%" >ITEMS</th>
                <th width="4%" >ESTADO</th>
                <th width="4%" >SUB TOTAL</th>
                <th width="7%" >IMPUESTO</th>
                <th width="7%" >TOTAL</th>
              </tr>
            </thead>

            <tfoot class="EstFacturaImprimirTablaFoot">
            </tfoot>

            <tbody class="EstFacturaImprimirTablaBody">
            <?php




$pagina = explode(",",$POST_pag);
$f=$pagina[0]+1;

$SubTotal = 0;
$Impuesto = 0;
$Total = 0;
$c = 1;
					
								foreach($ArrFacturas as $dat){


								//function MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL,$oNoProcesdado=false)
								$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrFechaEmision","DESC",1,NULL,NULL,"1,5",NULL,NULL,NULL,NULL,$dat->FacId,$dat->FtaId);
								$ArrNotaCreditos = $ResNotaCredito['Datos'];	
$NotaCreditoSerie = "";
$NotaCreditoId = "";
$NotaCreditoMotivo = "";

if(!empty($ArrNotaCreditos)){
	foreach($ArrNotaCreditos as $DatNotaCredito){
		
		$NotaCreditoSerie = $DatNotaCredito->NctNumero;
		$NotaCreditoId = $DatNotaCredito->NcrId;
		$NotaCreditoMotivo = $DatNotaCredito->NcrMotivo;
		
	}
}


?>


  <?php $dat->FacTotal = (($dat->FacTotal/(empty($dat->FacTipoCambio)?1:$dat->FacTipoCambio)));?>
              <?php $dat->FacSubTotal = (($dat->FacSubTotal/(empty($dat->FacTipoCambio)?1:$dat->FacTipoCambio)));?>
               <?php $dat->FacImpuesto = (($dat->FacImpuesto/(empty($dat->FacTipoCambio)?1:$dat->FacTipoCambio)));?>



              <tr  >
                <td align="right" valign="middle" width="3%"   ><?php echo $c;?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->FtaNumero;;  ?></td>

                <td align="right" valign="middle" width="5%"   ><?php echo $dat->FacId;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->FacFechaEmision);?></td>
                <td  width="13%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="28%" align="right" ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></td>
                <td align="right" class="EstTablaListado" ><?php echo ($dat->EinVIN);?> <?php echo ($dat->FacDatoAdicional13);?></td>
                <td align="right" class="EstTablaListado" ><?php echo ($dat->FacDatoAdicional3); ?></td>
                <td  width="5%" align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td  width="6%" align="right" > (<?php echo ($dat->MonSimbolo);?>)</td>
                <td  width="3%" align="right" ><?php echo ($dat->FacTipoCambio);?></td>
                <td align="right" class="EstTablaListado" >
                  <?php echo $dat->FinId;?> 
                 </td>
                <td align="right" class="EstTablaListado" > <?php echo $dat->AmoId;?> 
                 </td>
                <td align="right" class="EstTablaListado" >
				
				
                  <?php echo ($dat->FacNotaCredito); ?>
                 
                 </td>
                <td align="right" class="EstTablaListado" >
				
				
                  <?php echo ($dat->FacNotaDebito); ?>
                 </td>
                <td  width="4%" align="right" ><?php echo ($dat->FacTotalItems)  ; ?></td>
                <td  width="4%" align="right" ><span class="EstTablaListado"><?php echo $dat->FacEstadoDescripcion;?></span></td>
                <td  width="4%" align="right" ><?php $dat->FacSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->FacSubTotal:($dat->FacSubTotal/$dat->FacTipoCambio));?>
                <?php echo number_format($dat->FacSubTotal,2);?>
                </td>
                <td  width="7%" align="right" ><?php $dat->FacImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->FacImpuesto:($dat->FacImpuesto/$dat->FacTipoCambio));?>
                <?php echo number_format($dat->FacImpuesto,2);?>
                </td>
                <td  width="7%" align="right" ><?php $dat->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->FacTotal:($dat->FacTotal/$dat->FacTipoCambio));?>
                <?php echo number_format($dat->FacTotal,2);?></td>
              </tr>

              <?php		$f++;
			  			$c++;
			  		
					$SubTotal += $dat->FacSubTotal;
					$Impuesto += $dat->FacImpuesto;					
					$Total += $dat->FacTotal;
					

									}

									?>
                                    
              <tr  >
                <td colspan="17" align="right" valign="middle"   >TOTALES:</td>
                <td align="right" ><?php echo number_format($SubTotal,2);?></td>
                <td align="right" ><?php echo number_format($Impuesto,2);?></td>
                <td align="right" ><?php echo number_format($Total,2);?></td>
              </tr>
            </tbody>
      </table>
