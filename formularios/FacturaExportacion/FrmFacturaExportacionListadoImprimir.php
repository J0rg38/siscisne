<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaExportacionDetalle.php');

$InsFacturaExportacion = new ClsFacturaExportacion();

$ResFacturaExportacion = $InsFacturaExportacion->MtdObtenerFacturaExportaciones($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SisSucId'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal,NULL,NULL,$POST_npago,$POST_Moneda);

$ArrFacturaExportaciones = $ResFacturaExportacion['Datos'];
$FacturaExportacionesTotal = $ResFacturaExportacion['Total'];
$FacturaExportacionesTotalSeleccionado = $ResFacturaExportacion['TotalSeleccionado'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="css/CssFacturaExportacion<?php echo $EmpresaAlias;?>.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

</head>
<body>

<script type="text/javascript">
$().ready(function() {
window.print();
setTimeout("window.close();",1500);
});
</script>



<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
    
    
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">LISTADO DE FACTURAS DE EXPORTACION
    <?php
if($POST_finicio == $POST_ffin){
?>
    <?php echo $POST_finicio; ?>
    <?php
}else{
?>
    <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
    <?php  
}
?>
  </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFacturaExportacionImprimirTabla" >

            <thead class="EstFacturaExportacionImprimirTablaHead">

              <tr>
                <th width="5%" >#</th>
                <th width="5%" >SERIE</th>

                <th width="7%" >CODIGO</th>
                <th width="11%" >NUM.   DOCUMENTO</th>
                <th width="22%" >CLIENTE</th>
                <th width="8%" >FECHA</th>
                <th width="25%" >COND. PAGO</th>
                <th width="25%" >MONEDA</th>
                <th width="25%" ><span title="Tipo de Cambio">T.C.</span></th>
                <th width="25%" >ESTADO</th>
                <th width="6%" >VENTA</th>
                <th width="6%" >N.  ENTREGA</th>
                <th width="6%" >CANC.</th>
                <th width="6%" >SUB TOTAL <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="9%" >IMPUESTO <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="7%" >TOTAL <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span></th>
                <th width="7%" >REGIMEN</th>
                <th width="7%" >REG. MONTO</th>
              </tr>
            </thead>

            <tfoot class="EstFacturaExportacionImprimirTablaFoot">
            </tfoot>

            <tbody class="EstFacturaExportacionImprimirTablaBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
					$c = 1;
								foreach($ArrFacturaExportaciones as $dat){

								?>





              <tr  >
                <td align="right" valign="middle" width="5%"   ><?php echo $c;?></td>
                <td align="right" valign="middle" width="5%"   ><?php echo $dat->FetNumero; ?></td>

                <td align="right" valign="middle" width="7%"   ><?php echo $dat->FexId;  ?></td>
                <td  width="11%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="22%" align="right" ><?php echo ($dat->CliNombre);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->FexFechaEmision);?></td>
                <td  width="25%" align="right" ><?php echo ($dat->NpaNombre);?></td>
                <td align="right" class="EstTablaListado" ><?php echo ($dat->MonNombre);?> (<?php echo ($dat->MonSimbolo);?>)</td>
                <td align="right" class="EstTablaListado" ><?php echo ($dat->FexTipoCambio);?></td>
                <td  width="25%" align="right" >
				<?php 


				switch($dat->FexEstado){
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
					
					case 7:
				?>
                Reservado
                <?php	
					break;
				}
				?>                </td>
                <td  width="6%" align="right" >
				
				
                  <?php echo ($dat->FexVenta); ?>                </td>
                <td  width="6%" align="right" >
				
				
                  <?php echo ($dat->FexNotaEntrega); ?>                </td>
                <td  width="6%" align="right" ><?php echo ($dat->FexCancelado); ?></td>
                <td  width="6%" align="right" ><?php echo number_format($dat->FexSubTotal,2)  ; ?>                </td>
                <td  width="9%" align="right" ><?php echo number_format($dat->FexImpuesto,2)  ; ?>				</td>
                <td  width="7%" align="right" ><?php echo number_format($dat->FexTotal,2)  ; ?></td>
                <td  width="7%" align="right" ><?php echo ($dat->RegNombre); ?></td>
                <td  width="7%" align="right" ><?php echo number_format($dat->FexRegimenMonto,2); ?></td>
              </tr>

              <?php		$f++;
			  			$c++;
						
					$SubTotal += $dat->FexSubTotal;
					$Impuesto += $dat->FexImpuesto;					
					$Total += $dat->FexTotal;
					

									}

									?>
                                    
              <tr  >
                <td colspan="13" align="right" valign="middle"   >TOTALES:</td>
                <td align="right" ><?php echo number_format($SubTotal,2);?></td>
                <td align="right" ><?php echo number_format($Impuesto,2);?></td>
                <td align="right" ><?php echo number_format($Total,2);?></td>
                <td align="right" >&nbsp;</td>
                <td align="right" >&nbsp;</td>
              </tr>
            </tbody>
      </table>
</body>