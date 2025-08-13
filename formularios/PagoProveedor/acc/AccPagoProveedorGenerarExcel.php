<?php

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"PAGO A PROVEEDOR_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');

/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
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

$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

if($_POST){
	$_SESSION[$GET_mod."FechaInicio"] = $POST_finicio;
}else{
	$POST_finicio = (empty($_GET['FechaInicio'])?$_SESSION[$GET_mod."FechaInicio"]:$_GET['FechaInicio']);
}

if($_POST){
	$_SESSION[$GET_mod."FechaFin"] = $POST_ffin;
}else{
	$POST_ffin = (empty($_GET['FechaFin'])?$_SESSION[$GET_mod."FechaFin"]:$_GET['FechaFin']);
}  
   
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];
$POST_Cuenta = $_POST['CmpCuenta'];
$POST_Moneda = $_POST['CmpMonedaId'];
//$POST_Area = $_POST['CmpMonedaId'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'DesTiempoCreacion';
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


if(empty($POST_est)){
	$POST_est = 0;
}


if(empty($POST_con)){
	$POST_con = "contiene";
}


if(empty($POST_finicio)){$POST_finicio = "01/01/".date("Y");}
if(empty($POST_ffin)){$POST_ffin = date("d/m/Y");}

$POST_Area = "ARE-10001";

require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');

$InsPagoProveedor = new ClsPagoProveedor();

//MtdObtenerPagoProveedors($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL) 
$ResPagoProveedor = $InsPagoProveedor->MtdObtenerPagoProveedors("cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,per.PerNombre,per.PerApellidoPaterno,per.PerApellidoMaterno,prv.PrvNombre,PrvApellidoPaterno,prv.PrvApellidoMaterno",$POST_con,$POST_fil,$POST_ord,$POST_sen,NULL,$POST_est,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"DesFecha",$POST_Cuenta,$POST_Moneda,$POST_TipoDestino,$POST_Area);
$ArrPagoProveedors = $ResPagoProveedor['Datos'];

$PagoProveedorsTotal = $ResPagoProveedor['Total'];
$PagoProveedorsTotalSeleccionado = $ResPagoProveedor['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="6%" >ID</th>
                <th width="20%" >A LA ORDEN</th>
                <th width="7%" >FECHA</th>
                <th width="5%" >NUM . CHEQUE</th>
                <th width="10%" >BANCO</th>
                <th width="10%" >CUENTA</th>
                <th width="7%" >MONEDA</th>
                <th width="4%" >T.C.</th>
                <th width="6%" >MONTO</th>
                <th width="3%" >ESTADO</th>
                <th width="6%" >FECHA CREACION</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrPagoProveedors as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PovId;  ?></td>
                <td align="right" valign="middle"   >
                
                
                <?php echo $dat->PerNombre; ?>/
                <?php echo $dat->PerApellidoPaterno; ?>
                <?php echo $dat->PerApellidoMaterno; ?>
                
                <?php echo $dat->CliNombre; ?>
                <?php echo $dat->CliApellidoPaterno; ?>
                <?php echo $dat->CliApellidoMaterno; ?>
                
                <?php echo $dat->PrvNombre; ?>/
                <?php echo $dat->PrvApellidoPaterno; ?>
                <?php echo $dat->PrvApellidoMaterno; ?>
                
                </td>
                <td align="right" ><?php echo $dat->PovFecha; ?></td>
                <td align="right" ><?php echo $dat->PovNumeroOperacion; ?></td>
                <td align="right" ><?php echo $dat->BanNombre; ?></td>
                <td align="right" ><?php echo $dat->CueNumero; ?></td>

                <td align="right" ><?php echo $dat->MonNombre; ?></td>
                <td align="right" ><?php echo $dat->PovTipoCambio; ?></td>
                
                <td align="right" >
				
				<?php $dat->PovMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->PovMonto:($dat->PovMonto/$dat->PovTipoCambio));?>
				
				
				<?php echo number_format($dat->PovMonto,2); ?></td>
                <td align="right" >
                  
                  
                  <?php
			switch($dat->PovEstado){
				case 1:
			?>
                  PENDIENTE
                  <?php
				break;
				
				case 3:
			?>
REALIZADO
                  <?php
				break;
				
				case 6:
			?>
         ANULADO
                  <?php
				break;

			}
			?>                </td>
                <td align="right" ><?php echo ($dat->PovTiempoCreacion);?></td>
                </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
