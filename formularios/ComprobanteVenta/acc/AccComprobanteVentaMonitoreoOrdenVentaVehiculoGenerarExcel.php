<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDEN_VENTA_VEHICULO_FACTURAR_".date('d-m-Y').".xls\";");
?>
<?php
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
<title>LISTADO EN EXCEL</title>
</head>
<body>


<?php





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
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];


if($_POST){
	$POST_Moneda = $_POST['Moneda'];	
}else{
	$POST_Moneda = "MON-10001";
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
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
$POST_finicio = "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_con)){
	$POST_con = "contiene";
}


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();

$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("OvvId,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),4,$POST_Moneda);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];






?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="3%" >ORD. VEN. VEH.</th>
                <th width="4%" >FECHA</th>
                <th width="4%" >NUM. DOC</th>
                <th width="3%" >TIPO CLI.</th>
                <th width="13%" >CLIENTE</th>
                <th width="3%" >VIN</th>
                <th width="5%" >MARCA</th>
                <th width="6%" >MODELO</th>
                <th width="6%" >VERSION</th>
                <th width="5%" >COLOR</th>
                <th width="6%" >MONEDA</th>
                <th width="3%" >T.C.</th>
                <th width="6%" >TOTAL</th>
                <th width="12%" >ASESOR COMERCIAL</th>
                <th width="6%" >FEC. REGISTRO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">


				<?php
				$pagina = explode(",",$POST_pag);
				$f=$pagina[0]+1;

				foreach($ArrOrdenVentaVehiculos as $dat){
				?>

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td  width="3%" align="right" ><?php echo ($dat->OvvId);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->OvvFecha);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->LtiNombre);?></td>
                <td  width="13%" align="right" >
				
				<?php echo ($dat->CliNombre);?>
                <?php echo ($dat->CliApellidoPaterno);?>
                <?php echo ($dat->CliApellidoMaterno);?>
                
                </td>
                <td  width="3%" align="right" >
				

				
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
                <td  width="5%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->OvvColor);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->MonNombre);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->OvvTipoCambio);?></td>
                <td  width="6%" align="right" >
				
				
				<?php $dat->OvvTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->OvvTotal:($dat->OvvTotal/$dat->OvvTipoCambio));?>
				
				<?php echo number_format($dat->OvvTotal,2);?></td>
                <td  width="12%" align="right" >
                  
                  <?php echo ($dat->PerNombre);?>
                  
                  <?php echo ($dat->PerApellidoPaterno);?>
                  <?php echo ($dat->PerApellidoMaterno);?>
                </td>
                <td  width="6%" align="right" ><?php echo ($dat->OvvTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
            </tbody>
      </table>

</body>
</html>
 