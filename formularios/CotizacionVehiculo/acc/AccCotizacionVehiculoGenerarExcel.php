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

//
//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}
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
                <th width="1%" >#</th>
                <th width="2%" >ID</th>
                <th width="4%" >INTERES</th>
                <th width="4%" >FECHA</th>
                <th width="4%" >CANT. DIAS TRANSC.</th>
                <th width="7%" >NUM. DOC.</th>
                <th width="16%" >CLIENTE</th>
                <th width="4%" >CELULAR</th>
                <th width="4%" >MARCA</th>
                <th width="5%" >MODELO</th>
                <th width="5%" >VERSION</th>
                <th width="3%" >AÑO FAB.</th>
                <th width="3%" >AÑO MOD.</th>
                <th width="3%" >COLOR</th>
                <th width="5%" >MONEDA</th>
                <th width="3%" >TOTAL</th>
                <th width="3%" >ORD. VEN.</th>
                <th width="3%" >ESTADO</th>
                <th width="5%" >ASESOR</th>
                <th width="8%" >FECHA CREACION</th>
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
                <td width="1%" align="center" bgcolor="<?php //echo $dat->CveNivelColor;?>"  ><?php echo $f;?></td>
                <td align="left" valign="middle" width="2%"   >
				
				
				<?php echo $dat->CveId;  ?>
               
                
             
                
                </td>
                <td  width="4%" align="right" >   <?php 
				switch($dat->CveNivelInteres){
					case 1:
				?>
               
                <?php	
					break;
					
					case 2:
				?>
            Nivel 1
                <?php	
					break;
					

						case 3:
				?>
                 Nivel 2
                <?php	
					break;
					
						case 4:
				?>
              Nivel 3
                <?php	
					break;
					
				}
				?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveFecha;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveDiaTranscurridos;  ?> dias</td>
                <td  width="7%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="16%" align="right" ><?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  ><?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?></a>
                  <?php	
}else{
?>
                  <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
                <?php	
}
?></td>
                <td  width="4%" align="right" ><?php echo $dat->CveCelular;  ?></td>
                <td  width="4%" align="right" ><?php echo $dat->VmaNombre;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->VmoNombre;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->VveNombre;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CveAnoFabricacion;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CveAnoModelo;  ?></td>
                <td  width="3%" align="right" ><?php echo $dat->CveColor;  ?></td>
                <td  width="5%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="3%" align="right" >
                  
                          <?php $dat->CveTotal = (($dat->CveTotal/(empty($dat->CveTipoCambio)?1:$dat->CveTipoCambio)));?>
                <?php echo number_format($dat->CveTotal,2); ?>
                
					<?php //$dat->CveTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->CveTotal:($dat->CveTotal/$dat->CveTipoCambio));?>
					<?php //echo number_format($dat->CveTotal,2);?>
                 
                </td>
                <td  width="3%" align="right" >
                  
                  
                  
                  
                  <?php
if($dat->CveOrdenVentaVehiculo == "Si"){
?>
                  
   
    Tiene Ord.  Venta
               
  <?php	
}else{
?>
                  No Tiene Ord.  Venta
                  
  <?php	
}
?>
                </td>
                <td  width="3%" align="right" >
				
				<?php
				
				/*	switch($dat->CveEstado){
					
					  case 1:
						?>
                         <img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />
                        <?php
					  break;
					
					  case 3:
						 
						 ?>
                <img width="15" height="15" alt="[Listo]" title="Listo" src="imagenes/estado/realizado.gif" />
                <?php
						 
					  break;	
					  
					  case 6:
				
				?>
					<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />
                <?php
				
				break;
					
					  default:
						  ?>
                          -
                          <?php
					  break;					
					
					}
					*/
				?>
				
				<?php
				  echo $dat->CveEstadoDescripcion;
				  ?>
                  
                  </td>
                <td  width="5%" align="right" >
				<?php echo $dat->PerNombre;?> <?php echo $dat->PerApellidoPaterno;?> <?php echo $dat->PerApellidoMaterno;?>
                
                </td>
                <td  width="8%" align="right" ><?php echo ($dat->CveTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									
								
									$SubTotal += $dat->CveSubTotal;
									$Impuesto += $dat->CveImpuesto ;
									$Total += $dat->CveTotal ;
									

									}
									$SubTotal = number_format($SubTotal,2);
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									

									?>
            </tbody>
      </table>
      
      
</body>
</html>