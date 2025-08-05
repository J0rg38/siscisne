<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"FORMATO_DIARIO_".date('d-m-Y').".xls\";");
 
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
<title>EXPORTAR A EXCEL - COTIZACION DE VEHICULOS</title>
</head>
<body>

<?php

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();
$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","AccesoTotal"))?true:false;



//deb($_POST);


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
$POST_NivelInteres = $_POST['NivelInteres'];
$POST_Moneda = $_POST['Moneda'];	
$POST_Sucursal =$_POST['CmpSucursal']; 
$POST_Personal =$_POST['CmpPersonal']; 


//if(!$_POST){
//	$POST_Moneda = "MON-10001";
//}

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

if(!$_POST){
	$POST_Personal = $_SESSION['SesionPersonal'];
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CveTiempoCreacion';
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

$POST_pag = "";

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();





//deb($PrivilegioAccesoTotal);

//$POST_Personal
if($PrivilegioAccesoTotal){
									
//MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL,$oDiasTranscurridos=0)
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos("CveId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,$POST_Personal,$POST_NivelInteres,$POST_Sucursal);									
									
}else{
	//MtdObtenerCotizacionVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oSucursal=NULL)
	$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculos("CveId,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliNumeroDocumento,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,$POST_Moneda,$POST_Personal,$POST_NivelInteres,$POST_Sucursal);
	
}



$ArrCotizacionVehiculos = $ResCotizacionVehiculo['Datos'];


?>



<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >HORA DE COTIZACION</th>
                <th width="4%" >DIA DE LA COTIZACION</th>
                <th width="4%" >NOMBRE DEL CLIENTE</th>
                <th width="4%" >MODELO COTIZADO</th>
                <th width="4%" >CONDICION DE COMPRA</th>
                <th width="4%" >TELEFONO</th>
                <th width="4%" >MEDIO POR EL CUAL SE ENTERO DE NUESTRAS PROMOCIONES</th>
                <th width="4%" >COTIZO EN OTRO CONCESIONARIO DE LA RED</th>
                <th width="4%" >COMENTARIOS - OBSERVACIONES</th>
                <th width="9%" >VENDEDOR</th>
                <th width="4%" >REF</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrCotizacionVehiculos as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CveHora;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CveFecha;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->VmaNombre;  ?><?php echo $dat->VmoNombre;  ?><?php echo $dat->VveNombre;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->NpaNombre;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CveCelular;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->TrfNombre;  ?></td>
                <td align="right" valign="middle" width="4%"   >
				
				
				<?php echo $dat->CveCotizoOtroLugar;  ?>
                
                
                </td>
                <td  width="4%" align="right" ><?php echo ($dat->CveObservacionReporte);?></td>
                <td  width="9%" align="right" ><?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveId;  ?></td>
        </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->CveSubTotal;
									$Impuesto += $dat->CveImpuesto ;
									$Total += $dat->CveTotal ;
									

									}
									
									

									?>
            </tbody>
      </table>
      
      
</body>
</html>