<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDEN_TRABAJO_FACTURAR_".date('d-m-Y').".xls\";");
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

$POST_Facturable = ($_POST['Facturable']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
	
	//$POST_Facturable = 1;
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';



/*
* Otras variables
*/
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
//$POST_Facturable = $_POST['Facturable'];
if($_POST){
	$_SESSION[$GET_mod."Facturable"] = $POST_Facturable;
}else{
	$POST_Facturable =  $_SESSION[$GET_mod."Facturable"];	
}

//deb($POST_Facturable." aaaaaaaaaaaaaaaaaaaaaaa");

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'FinTiempoCreacion';
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


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

$InsFichaAccion = new ClsFichaAccion();

$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones("amo.AmoId,fin.FinId,EinVIN,EinPlaca,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,FinConductor,VmaNombre,VmoNombre,VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,false,false,"MIN-10016,MIN-10001,MIN-10002,MIN-10003,MIN-10004,MIN-10005,MIN-10006,MIN-10007,MIN-10009,MIN-10015,MIN-10013,MIN-10017",true,$POST_Facturable,true);//73,74,75,8,9
$ArrFichaAcciones = $ResFichaAccion['Datos'];

?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >FICHA</th>
                <th width="4%" >ORD. TRAB.</th>
                <th width="4%" >FEC. ORD. TRAB.</th>
                <th width="10%" >MODALIDAD</th>
                <th width="7%" >OBSEQUIO</th>
                <th width="7%" >NUM. DOC.</th>
                <th width="7%" >TIPO CLI.</th>
                <th width="9%" >CLIENTE</th>
                <th width="3%" >VIN</th>
                <th width="5%" >MARCA</th>
                <th width="5%" >MODELO</th>
                <th width="5%" >VERSION</th>
                <th width="4%" >COLOR</th>
                <th width="4%" >PLACA</th>
                <th width="3%" >FEC. REGISTRO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">


				<?php
				$pagina = explode(",",$POST_pag);
				$f=$pagina[0]+1;

				foreach($ArrFichaAcciones as $dat){
				?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td  width="4%" align="right" >
                  
                  
                  
  <?php
if($PrivilegioAlmacenMovimientoSalidaVer){
?>
                  
                  <a href="javascript:FncAlmacenMovimientoSalidaVistaPreliminar('<?php echo $dat->AmoId;  ?>');"  ><?php echo $dat->AmoId;  ?></a>
  <?php	
}else{
?>
                  <?php echo $dat->AmoId;  ?>
  <?php	
}
?>
</td>

                <td  width="4%" align="right" >




				<?php echo ($dat->FinId);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->FinFecha);?></td>
                <td  width="10%" align="right" ><?php echo ($dat->MinNombre);?></td>
                <td  width="7%" align="right" >
				
				<?php
				
				switch($dat->FimObsequio){
					
					case 1:
				?>
					<span class="EstTablaListadoResaltar">Esto es un OBSEQUIO</span>
                <?php	
					break;
					
					case 2:
				?>
                
                <?php	
					break;
				}
				?>
			
                
                
                </td>
                <td  width="7%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="7%" align="right" ><?php echo ($dat->LtiNombre);?></td>
                <td  width="9%" align="right" >
				
				<?php echo ($dat->CliNombre);?>
                <?php echo ($dat->CliApellidoPaterno);?>
                <?php echo ($dat->CliApellidoMaterno);?>
                
                </td>
                <td  width="3%" align="right" ><?php echo ($dat->EinVIN);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VmaNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VmoNombre);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinColor);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->EinPlaca);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->FinTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
            </tbody>
      </table>

</body>
</html>
 