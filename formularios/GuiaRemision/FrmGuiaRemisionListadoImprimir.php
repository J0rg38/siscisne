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
$POST_tal = $_POST['Talonario'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'GreTiempoModificacion';
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

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');

$InsGuiaRemision = new ClsGuiaRemision();

$ResGuiaRemision = $InsGuiaRemision->MtdObtenerGuiaRemisiones($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,1,$POST_pag,$_SESSION['SesionSucursal'],$POST_estado,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_tal);
$ArrGuiaRemisiones = $ResGuiaRemision['Datos'];
$GuiaRemisionesTotal = $ResGuiaRemision['Total'];
$GuiaRemisionesTotalSeleccionado = $ResGuiaRemision['TotalSeleccionado'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="css/CssGuiaRemision<?php echo $EmpresaAlias;?>.css" rel="stylesheet" type="text/css" />
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
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
    
    
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">LISTADO DE GUIAS DE REMISION
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





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGuiaRemisionImprimirTabla" >

            <thead class="EstGuiaRemisionImprimirTablaHead">

              <tr>
                <th width="0%" >#</th>
                <th width="8%" >SERIE</th>

                <th width="7%" >CODIGO</th>
                <th width="39%" >DESTINATARIO</th>
                <th width="7%" >P. PARTIDA</th>
                <th width="8%" >P. LLEGADA</th>
                <th width="6%" >COSTO MIN.</th>
                <th width="5%" >FECHA</th>
                <th width="7%" >ESTADO</th>
                <th width="13%" >VENTA</th>
                <th width="13%" >MOV.</th>
              </tr>
            </thead>

            <tfoot class="EstGuiaRemisionImprimirTablaFoot">
            </tfoot>

            <tbody class="EstGuiaRemisionImprimirTablaBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
					$c = 1;
					
								foreach($ArrGuiaRemisiones as $dat){

								?>





              <tr  >
                <td align="right" valign="middle" width="0%"   ><?php echo $c;?></td>
                <td align="right" valign="middle" width="8%"   ><?php echo $dat->GrtNumero;;  ?></td>

                <td align="right" valign="middle" width="7%"   ><?php echo $dat->GreId;  ?></td>
                <td  width="39%" align="right" ><?php echo ($dat->CliNombre);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->GrePuntoPartida);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->GrePuntoLlegada);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->GreCostoMinimo);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->GreFechaInicioTraslado);?></td>
                <td  width="7%" align="right" ><?php 


				switch($dat->GreEstado){
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
				?></td>
                <td  width="13%" align="right" ><?php echo ($dat->GreVenta); ?></td>
                <td  width="13%" align="right" ><?php echo ($dat->GreAlmacenMovimiento); ?></td>
              </tr>

              <?php		$f++;
			  $c++;
			  		
					$SubTotal += $dat->GreSubTotal;
					$Impuesto += $dat->GreImpuesto;					
					$Total += $dat->GreTotal;
					

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
                <td align="right" >&nbsp;</td>
              </tr>
            </tbody>
      </table>
</body>