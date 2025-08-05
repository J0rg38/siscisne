<?php


 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"FACTURA DE EXPORTACION_".date('d-m-Y').".xls\";");
 
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
Otras variables
*/
$POST_est = $_POST['Estado'];
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
	$POST_ord = 'FexTiempoModificacion';
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


include($InsProyecto->MtdFormulariosMsj("FacturaExportacion").'MsjFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

$InsFacturaExportacion = new ClsFacturaExportacion();
$InsFacturaExportacionTalonario = new ClsFacturaExportacionTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();

$InsFacturaExportacion->UsuId = $_SESSION['SesionId'];
$InsFacturaExportacion->SucId = $_SESSION['SisSucId'];



     
$ResFacturaExportacion = $InsFacturaExportacion->MtdObtenerFacturaExportaciones("FexId,FetNumero,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,bol.AmoId,FinId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,$POST_Moneda);

$ArrFacturaExportaciones = $ResFacturaExportacion['Datos'];
$FacturaExportacionesTotal = $ResFacturaExportacion['Total'];
$FacturaExportacionesTotalSeleccionado = $ResFacturaExportacion['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="2%" >SERIE</th>

                <th width="3%" >ID</th>
                <th width="6%" >NUM. DOC.</th>
                <th width="17%" >CLIENTE</th>
                <th width="4%" >FECHA</th>
                <th width="4%" >COND. PAGO</th>
                <th width="5%" >MONEDA</th>
                <th width="3%" >T.C.</th>
                <th width="3%" >ESTADO.</th>
                <th width="6%" >ORD. TRAB.</th>
                <th width="6%" >MOV. ALM.</th>
                <th width="2%" >CANCELADO</th>
                <th width="4%" >TOTAL</th>
                <th width="4%" >REGIMEN</th>
                <th width="5%" >REG. MONTO</th>
                <th width="2%" >IT.</th>
                <th width="3%" >ULTIMA MODIFICACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrFacturaExportaciones as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->FetNumero;  ?></td>

                <td align="right" valign="middle"   ><?php echo $dat->FexId;  ?></td>
                <td align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td align="right" >
		
    
	        <?php echo ($dat->CliNombre);?>                </td>
                <td align="right" ><?php echo ($dat->FexFechaEmision);?></td>
                <td align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td align="right" >(<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" ><?php echo ($dat->FexTipoCambio);?></td>
                <td align="right" >
                
                <?php echo $dat->FexEstadoDescripcion; ?>

                
				                </td>
                <td align="right" >
                
                <?php
				  if(!empty($dat->FinId)){
					  ?>
				  <a href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $dat->FinId;?>">
				  <?php echo $dat->FinId;?>
                  </a>
                      
                      <?php
				  }else{
					?>
-                    
                    <?php  
				  }
				  ?>
                  
                </td>
                <td align="right" >
                  <?php
				  if(!empty($dat->AmoId)){
					  ?>
				  <a href="principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $dat->AmoId;?>">
				  <?php echo $dat->AmoId;?>
                  </a>
                      
                      <?php
				  }else{
					?>
-                    
                    <?php  
				  }
				  ?>
                  
                  <?php
				/*if($dat->FexAlmacenMovimiento=="Si"){
				?>
                  <a href="#" onmouseover="ajax_showTooltip(window.event,'<?php echo $InsProyecto->MtdRutComunes();?>FacturaExportacionAlmacenMovimiento/TipFacturaExportacionAlmacenMovimiento.php?FexId=<?php echo $dat->FexId;?>&FetId=<?php echo $dat->FetId;?>',this);return false" >
                    <?php echo ($dat->FexAlmacenMovimiento); ?></a>
                  <?php	
				}else{
				?>
                  <?php echo ($dat->FexAlmacenMovimiento); ?>
                  <?php	
				}*/
				?>                </td>
                <td align="right" >
                  
                  <?php
				if($dat->FexCancelado==1){
				?>
                  Si                
                  <?php
				}elseif($dat->FexCancelado==2){
				?>
                  No
                  <?php	
				}
				?>                </td>
                <td align="right" >
                

			 <?php echo number_format($dat->FexTotal,2); ?>                </td>
                <td align="right" ><?php echo ($dat->RegNombre); ?></td>
                <td align="right" ><?php echo number_format($dat->FexRegimenMonto,2); ?></td>
                <td align="right" ><?php echo ($dat->FexTotalItems);?></td>
                <td align="right" ><?php echo ($dat->FexTiempoModificacion);?></td>
              </tr>

              <?php		$f++;
							
							$Total += $dat->FexTotal;
							$SubTotal += $dat->FexSubTotal;
							$Impuesto += $dat->FexImpuesto;
							
									}


									$SubTotal = number_format($SubTotal,2);									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									
									?>
            </tbody>
      </table>
