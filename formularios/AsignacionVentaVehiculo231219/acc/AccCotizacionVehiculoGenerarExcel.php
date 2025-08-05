<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"PROFORMAS_VEHICULO_".date('d-m-Y').".xls\";");
 
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

if(!$_POST){
	$POST_Moneda = "MON-10001";
}

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
	$POST_ord = 'CveTiempoModificacion';
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

if(empty($POST_Moneda)){
	$POST_Moneda = $EmpresaMonedaId;
}

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();






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
                <th width="4%" >ID</th>
                <th width="5%" >FECHA</th>
                <th width="4%" >CANT. DIAS. TRANSC.</th>
                <th width="4%" >NIVEL INTERES</th>
                <th width="4%" >TIPO DOC.</th>
                <th width="9%" >NUM. DOC.</th>
                <th width="25%" >CLIENTE </th>
                <th width="6%" >CELULAR</th>
                <th width="6%" >DIRECCION</th>
                <th width="6%" >DEPARTAMENTO</th>
                <th width="6%" >PROVINCIA</th>
                <th width="6%" >DISTRITO</th>
                <th width="6%" >MONEDA</th>
                <th width="4%" >T.C.</th>
                <th width="6%" >MARCA</th>
                <th width="6%" >MODELO</th>
                <th width="6%" >VERSION</th>
                <th width="6%" >AÑO MOD.</th>
                <th width="6%" >COLOR</th>
                <th width="6%" >SUB TOTAL</th>
                <th width="7%" >IMPUESTO</th>
                <th width="7%" >TOTAL</th>
                <th width="6%" >VIGENCIA</th>
                <th width="6%" >ESTADO</th>
                <th width="4%" >COTIZADOR</th>
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
                <td align="right" valign="middle" width="4%"   >
				
				<a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->CveId;?>">
				<?php echo $dat->CveId;  ?>
                </a>
                
                </td>
                <td  width="5%" align="right" ><?php echo $dat->CveFecha;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveDiaTranscurridos;  ?> dias</td>
                <td  width="4%" align="right" ><?php echo $dat->CveNivelInteresDescripcion;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->TdoNombre);?></td>
                <td  width="9%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="25%" align="right" >
				
				<?php echo ($dat->CliNombre);?>
                <?php echo ($dat->CliApellidoPaterno);?>
                <?php echo ($dat->CliApellidoMaterno);?>
                
                </td>
                <td  width="6%" align="right" ><?php echo $dat->CveCelular;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CliDireccion;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CliDepartamento;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CliProvincia;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CliDistrito;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveTipoCambio;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->VveNombre;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveAnoModelo;  ?></td>
                <td  width="6%" align="right" ><?php echo $dat->CveColor;  ?></td>
                <td  width="6%" align="right" >
                  
                  <?php $dat->CveSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CveSubTotal:($dat->CveSubTotal/$dat->CveTipoCambio));?>
                  <?php echo number_format($dat->CveSubTotal,2);?>
                  
                </td>
                <td  width="7%" align="right" >
         
	
					<?php $dat->CveImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CveImpuesto:($dat->CveImpuesto/$dat->CveTipoCambio));?>
					<?php echo number_format($dat->CveImpuesto,2);?>
                 
                      </td>
                <td  width="7%" align="right" >
                  
                  
					<?php $dat->CveTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CveTotal:($dat->CveTotal/$dat->CveTipoCambio));?>
					<?php echo number_format($dat->CveTotal,2);?>
                 
                </td>
                <td  width="6%" align="right" >
                
                
                <?php echo ($dat->CveFechaVigencia);?>
                </td>
                <td  width="6%" align="right" ><?php
				  echo $dat->CveEstadoDescripcion;
				  ?></td>
                <td  width="4%" align="right" >
				<?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?>
                
                </td>
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