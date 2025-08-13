
<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once('../../clases/ClsSesionObjeto.php');

require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');

/*
*Clases de Conexion
*/
require_once('../../conexiones/ClsConexion.php');
require_once('../../clases/ClsMysql.php');
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
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

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

$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CueTiempoModificacion';
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

require_once('../../paquetes/PaqContabilidad/Clases/ClsCuenta.php');

$InsCuenta = new ClsCuenta();

$ResCuenta = $InsCuenta->MtdObtenerCuentas($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est);
$ArrCuentas = $ResCuenta['Datos'];
$CuentasTotal = $ResCuenta['Total'];
$CuentasTotalSeleccionado = $ResCuenta['TotalSeleccionado'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="css/CssCuenta.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

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
  <td align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td align="center">
  
<span class="EstReporteTitulo">LISTADO DE CUENTAS

</span>
  
  
  </td>
</tr>
<tr>
<td align="right">

<span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?>  <?php echo date("H:i:s");?> <?php echo date("a");?></span> 
<br>
<span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span> 


</td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >ID</th>
                <th width="11%" >NUMERO</th>
                <th width="34%" >BANCO</th>
                <th width="12%" >MONEDA</th>
                <th width="9%" >INGRESOS</th>
                <th width="10%" >SALIDAS </th>
                <th width="7%" >SALDO</th>
                <th width="11%" >ESTADO</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrCuentas as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->CueId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->CueNumero; ?></td>
                <td align="right" ><?php echo $dat->CueBanco; ?></td>
                <td align="right" ><?php
			switch($dat->CueMoneda){
				case "S":
			?>
Nuevos Soles
  <?php
				break;
				
				case "D":
			?>
Dolares
<?php
				break;

			}
			?></td>
                <td align="right" ><?php echo $dat->CueIngresos; ?></td>
                <td align="right" ><?php echo $dat->CueSalidas; ?></td>
                <td align="right" ><?php echo $dat->CueSaldo; ?></td>
                <td align="right" >
                  
                  
                  <?php
			switch($dat->CueEstado){
				case 1:
			?>
                  ACTIVO
                  <?php
				break;
				
				case 2:
			?>
INACTIVO
                  <?php
				break;

			}
			?>                </td>
                </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
</body>
</html>