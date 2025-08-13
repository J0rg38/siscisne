<?php

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"NOTA DE CREDITO_".date('d-m-Y').".xls\";");
 
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

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'NcrTiempoModificacion';
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

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoVenta.php');

$InsNotaCreditoVenta = new ClsNotaCreditoVenta();


$InsNotaCredito = new ClsNotaCredito();


$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal);
$ArrNotaCreditos = $ResNotaCredito['Datos'];
$NotaCreditosTotal = $ResNotaCredito['Total'];
$NotaCreditosTotalSeleccionado = $ResNotaCredito['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >SERIE</th>

                <th width="2%" >CODIGO</th>
                <th width="19%" >NUM. DOCUMENTO</th>
                <th width="19%" >CLIENTE</th>
                <th width="6%" >FECHA</th>
                <th width="4%" >ESTADO</th>
                <th width="2%" >VENTA</th>
                <th width="8%" >N. ENTREGA</th>
                <th width="8%" >CANC.</th>
                <th width="8%" >SUB TOTAL <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="9%" >IMPUESTO <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="9%" >TOTAL <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="2%" >REGIMEN</th>
                <th width="2%" >REG. MONTO</th>
                <th width="2%" >TIPO ORDEN</th>
                <th width="2%" >NUM. ORDEN</th>
                <th width="2%" >FEC. ORDEN</th>
                <th width="2%" >NUM. SIAF</th>
                <th width="2%" ># items</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>

            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
								$c = 1;
								foreach($ArrNotaCreditos as $dat){

								?>

            <tbody class="EstTablaListadoBody">


              <tr  >
                <td align="right" valign="top" width="2%"   ><?php echo $c;?></td>
                <td align="right" valign="top" width="2%"   ><?php echo $dat->NctNumero;;  ?></td>

                <td align="right" valign="top" width="2%"   ><?php echo $dat->NcrId;  ?></td>
                <td  width="19%" align="right" valign="top" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="19%" align="right" valign="top" ><?php echo ($dat->CliNombre);?></td>
                <td  width="6%" align="right" valign="top" ><?php echo ($dat->NcrFechaEmision);?></td>
                <td  width="4%" align="right" valign="top" >
				<?php 


				switch($dat->NcrEstado){
					case 1:
				?>
              Pendiente
                <?php	
				
				break;
										
					case 5:
				?>
                
              Entregado          
				<?php	
					break;
					
					case 6:
				?>
              Anulado           
				<?php	
					break;
				}
				?>                </td>
                <td  width="2%" align="right" valign="top" >
                
                
                <?php
				if($dat->NcrVenta=="Si"){
				?>
<?php
$ResNotaCreditoVenta = $InsNotaCreditoVenta->MtdObtenerNotaCreditoVentas(NULL,NULL,'FveId','Desc',NULL,$dat->NcrId,$dat->NctId,NULL,NULL,NULL,NULL,true,1);
$ArrNotaCreditoVentas = $ResNotaCreditoVenta['Datos'];
?>
<?php
	foreach($ArrNotaCreditoVentas as $DatNotaCreditoVenta){
?>
<?php echo $DatNotaCreditoVenta->VtaNumero;?> - <?php echo $DatNotaCreditoVenta->VenId;?>, 

<?php
	}
?>

                <?php	
				}else{
				?>
                <?php echo ($dat->NcrVenta); ?>
                <?php	
				}
				?>                </td>
                <td  width="8%" align="right" valign="top" >
                
                  <?php
				if($dat->NcrNotaEntrega=="Si"){
				?>
                
                
<?php
$ResNotaCreditoVenta = $InsNotaCreditoVenta->MtdObtenerNotaCreditoVentas(NULL,NULL,'FveId','Desc',NULL,$dat->NcrId,$dat->NctId,NULL,NULL,NULL,NULL,true,2);
$ArrNotaCreditoNotaEntregas = $ResNotaCreditoVenta['Datos'];
?>

<?php
	foreach($ArrNotaCreditoNotaEntregas as $DatNotaCreditoNotaEntrega){
?>
	<?php echo $DatNotaCreditoNotaEntrega->NetNumero;?> - <?php echo $DatNotaCreditoNotaEntrega->NenId;?>, 

<?php
	}
?>


                  <?php	
				}else{
				?>
                  <?php echo ($dat->NcrNotaEntrega); ?>
                  <?php	
				}
				?>                </td>
                <td  width="8%" align="right" valign="top" >&nbsp;</td>
                <td  width="8%" align="right" valign="top" ><?php echo number_format($dat->NcrSubTotal,2,'.','')  ; ?>                </td>
                <td  width="9%" align="right" valign="top" ><?php echo number_format($dat->NcrImpuesto,2,'.','')  ; ?>				</td>
                <td  width="9%" align="right" valign="top" ><?php echo number_format($dat->NcrTotal,2,'.','')  ; ?>				</td>
                <td  width="2%" align="right" valign="top" ><?php echo ($dat->RegNombre);?></td>
                <td  width="2%" align="right" valign="top" ><?php echo number_format($dat->NcrRegimenMonto,2,'.','');?></td>
                <td  width="2%" align="right" valign="top" ><?php
				switch($dat->NcrOrdenTipo){
					case 1:
				?>
Orden de Servicio
  <?php	
					break;
					
					case 2:
				?>
Orden de Compra
<?php
					
					break;	
				}
				?></td>
                <td  width="2%" align="right" valign="top" ><?php echo ($dat->NcrOrdenNumero);?></td>
                <td  width="2%" align="right" valign="top" ><?php echo ($dat->NcrOrdenFecha);?></td>
                <td  width="2%" align="right" valign="top" ><?php echo ($dat->NcrSIAFNumero);?></td>
                <td  width="2%" align="right" valign="top" >
				<?php echo ($dat->NcrTotalItems)  ; ?>				</td>
              </tr>

              <?php		$f++;
			  			$c++;

									}

									?>

              <tr  >
                <td align="right" valign="middle"   >&nbsp;</td>
                <td align="right" valign="middle"   >&nbsp;</td>
                <td align="right" valign="middle"   >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >=SUMA(K2:K<?php echo $f;?>)</td>
                <td align="right" >=SUMA(L2:L<?php echo $f;?>)</td>
                <td align="right" >=SUMA(M2:M<?php echo $f;?>)</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
              </tr>
            </tbody>
      </table>
