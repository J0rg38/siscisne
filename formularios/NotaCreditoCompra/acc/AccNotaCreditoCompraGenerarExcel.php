<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"NOTA DE CREDITO DE COMPRA_".date('d-m-Y').".xls\";");
 
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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

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
	$POST_ord = 'NccTiempoModificacion';
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

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjNotaCreditoCompra.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();
$InsNotaCreditoCompraTalonario = new ClsNotaCreditoCompraTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

  $ResNotaCreditoCompra = $InsNotaCreditoCompra->MtdObtenerNotaCreditoCompras("Ftanumero,NccId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,NccOrdenNumero,NccSIAFNumero,NccTotal,fac.AmoId,FinId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$_SESSION['SisSucId'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda);
$ArrNotaCreditoCompras = $ResNotaCreditoCompra['Datos'];
$NotaCreditoComprasTotal = $ResNotaCreditoCompra['Total'];
$NotaCreditoComprasTotalSeleccionado = $ResNotaCreditoCompra['TotalSeleccionado'];
$ArrNotaCreditoCompras = $ResNotaCreditoCompra['Datos'];

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >-</th>

                <th width="2%" >ID</th>
                <th width="4%" >NUM. DOC</th>
                <th width="16%" > CLIENTE</th>
                <th width="5%" >FECHA</th>
                <th width="5%" >COND. PAGO</th>
                <th width="5%" >MONEDA</th>
                <th width="4%" >T.C.</th>
                <th width="2%" >ESTADO.</th>
                <th width="6%" >ORD. TRAB.</th>
                <th width="6%" >MOV. ALM.</th>
                <th width="3%" >N. CRE.</th>
                <th width="3%" >CANCELADO</th>
                <th width="5%" >SUB TOTAL</th>
                <th width="5%" >IMPUESTO</th>
                <th width="4%" >TOTAL</th>
                <th width="5%" >REGIMEN</th>
                <th width="4%" >REG. MONTO</th>
                <th width="1%" >IT.</th>
                <th width="2%" >ULTIMA MODIFICACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php


							$SumaSubTotal = 0;;
							$SumaImpuesto = 0;
							$SumaTotal = 0;


								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrNotaCreditoCompras as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->FtaNumero;;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->NccId;  ?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" ><?php echo ($dat->CliNombre);?></td>
                <td align="right" ><?php echo ($dat->NccFechaEmision);?></td>
                <td align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->NccTipoCambio);?></td>
                <td align="right" >
                  <?php echo $dat->NccEstadoDescripcion; ?>                </td>
                <td align="right" ><?php
				  if(!empty($dat->FinId)){
					  ?>
                  <a href="principal.php?Mod=FichaIngreso&amp;Form=Ver&amp;Id=<?php echo $dat->FinId;?>"> <?php echo $dat->FinId;?> </a>
                  <?php
				  }else{
					?>
                  -
  <?php  
				  }
				  ?></td>
                <td align="right" ><?php
				  if(!empty($dat->AmoId)){
					  ?>
                  <a href="principal.php?Mod=AlmacenMovimientoSalida&amp;Form=Ver&amp;Id=<?php echo $dat->AmoId;?>"> <?php echo $dat->AmoId;?> </a>
                  <?php
				  }else{
					?>
                  -
  <?php  
				  }
				  ?>
  <?php
				/*if($dat->BolAlmacenMovimiento=="Si"){
				?>
                  <a href="#" onmouseover="ajax_showTooltip(window.event,'<?php echo $InsProyecto->MtdRutComunes();?>BoletaAlmacenMovimiento/TipBoletaAlmacenMovimiento.php?BolId=<?php echo $dat->BolId;?>&BtaId=<?php echo $dat->BtaId;?>',this);return false" >
                    <?php echo ($dat->BolAlmacenMovimiento); ?></a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->BolAlmacenMovimiento); ?>
                  <?php	
				}*/
				?></td>
                <td align="right" >
                  
                  
                  
                  <?php
				if($dat->NccNotaCredito=="Si"){
				?>
                  <a href="#" onmouseover="ajax_showTooltip(window.event,'<?php echo $InsProyecto->MtdRutComunes();?>NotaCreditoCompraVenta/TipNotaCreditoCompraNotaCredito.php?DocId=<?php echo $dat->NccId;?>&DtaId=<?php echo $dat->FtaId;?>',this);return false" >
                  <?php echo ($dat->NccNotaCredito); ?>                
                  </a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->NccNotaCredito); ?>
                  <?php	
				}
				?>    
                  
                  
                  
                </td>
                <td align="right" > 
				
                <?php
				if($dat->NccCancelado==1){
				?>
				Si                
                <?php
				}elseif($dat->NccCancelado==2){
				?>
                No
                <?php	
				}
				?>                </td>
                <td align="right" > <?php echo number_format($dat->NccSubTotal,2); ?></td>
                <td align="right" >  <?php echo number_format($dat->NccImpuesto,2); ?></td>
                <td align="right" > <?php echo number_format($dat->NccTotal,2); ?></td>
                <td align="right" ><?php echo ($dat->RegNombre);?></td>
                <td align="right" ><?php echo number_format($dat->NccRegimenMonto,2);?></td>
                <td align="right" ><?php echo ($dat->NccTotalItems);?></td>
                <td align="right" ><?php echo ($dat->NccTiempoModificacion);?></td>
              </tr>

              <?php		$f++;

							$SumaSubTotal += $dat->NccSubTotal;
							$SumaImpuesto += $dat->NccImpuesto;
							$SumaTotal += $dat->NccTotal;
							
									}

									?>
            </tbody>
      </table>
