<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDEN_VENTA_FACTURAR_".date('d-m-Y').".xls\";");
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
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Facturable = ($_POST['Facturable']);
$POST_Estado = ($_POST['Estado']);
$POST_Moneda = $_POST['Moneda'];	
$POST_Sucursal = $_POST['CmpSucursal'] ?? '';


if($_POST){
	$_SESSION[$GET_mod."Facturable"] = $POST_Facturable;
}else{
	$POST_Facturable =  $_SESSION[$GET_mod."Facturable"];	
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'AmoTiempoCreacion';
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


if(empty($POST_Estado)){
	$POST_Estado = 3;
}
/*if(empty($POST_Moneda)){
	$POST_Moneda = $EmpresaMonedaId;
}*/

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

$POST_pag = '';

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsVentaConcretada = new ClsVentaConcretada();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();


$ResComprobanteVenta = $InsComprobanteVenta->MtdObtenerVentaConcretadaxFacturar("AmoId,vdi.CprId,amo.VdiId,CliNombreCompleto,CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNumeroDocumento,VdiOrdenCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Estado,0,0,0,NULL,$POST_Moneda,false,true,$POST_Facturable,$POST_Sucursal);

$ArrComprobanteVentas = $ResComprobanteVenta['Datos'];
$ComprobanteVentaTotal = $ResComprobanteVenta['Total'];
$ComprobanteVentaTotalSeleccionado = $ResComprobanteVenta['TotalSeleccionado'];


?>
<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
  <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" >#</th>
      <th width="4%" >FICHA</th>
      <th width="3%" >ORD. VEN.</th>
      <th width="3%" >ORD. VEN. FECHA</th>
      <th width="3%" >O.C. REF.</th>
      <th width="4%" >O.C. REF. FECHA</th>
      <th width="5%" >TIPO CLIENTE</th>
      <th width="8%" >NUM. DOCUMENTO</th>
      <th width="10%" >CLIENTE</th>
      <th width="9%" >COTIZADOR</th>
      <th width="7%" >ABONOS</th>
      <th width="6%" >MONEDA</th>
      <th width="9%" >TOTAL</th>
      <th width="9%" >FECHA REGISTRO</th>
    </tr>
  </thead>
  <tfoot class="EstTablaListadoFoot">
  </tfoot>
  <tbody class="EstTablaListadoBody">
    <?php
				$pagina = explode(",",$POST_pag);
				$f=$pagina[0]+1;

				foreach($ArrComprobanteVentas as $dat){
				?>
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td align="right" valign="middle" width="4%"   ><?php
if($PrivilegioVentaConcretadaVer){
?>
        <!--<a href="javascript:FncVentaConcretadaCargarFormulario('Ver','<?php echo $dat->VcoId;  ?>');"  ><?php echo $dat->VcoId;  ?></a>-->
        <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $dat->VcoId;  ?>');"  ><?php echo $dat->VcoId;  ?></a>
        <?php	
}else{
?>
        <?php echo $dat->VcoId;  ?>
        <?php	
}
?></td>
      <td  width="3%" align="right" ><h2>
        <?php
if($PrivilegioVentaDirectaVer){
?>
        <a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>
        <?php	
}else{
?>
        <?php echo ($dat->VdiId);?>
        <?php	
}
?>
      </h2>
        <!--<a href="javascript:FncVentaDirectaVistaPreliminar('<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>

--></td>
      <td  width="3%" align="right" ><?php echo ($dat->VdiFecha);?></td>
      <td  width="3%" align="right" ><?php            
if(!empty($dat->VdiArchivo)){
	
	$extension = strtolower(pathinfo($dat->VdiArchivo, PATHINFO_EXTENSION));
	$nombre_base = basename($dat->VdiArchivo, '.'.$extension);  
?>
        <a href="subidos/venta_directa/<?php echo $dat->VdiArchivo;?>" target="_blank" title=""> <?php echo ($dat->VdiOrdenCompraNumero);?> </a>
        <?php	
}else{
?>
        <?php echo ($dat->VdiOrdenCompraNumero);?>
        <?php	
}
?></td>
      <td  width="4%" align="right" ><?php echo ($dat->VdiOrdenCompraFecha);?></td>
      <td  width="5%" align="right" ><?php echo ($dat->LtiNombre);?></td>
      <td  width="8%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
      <td  width="10%" align="right" ><?php echo ($dat->CliNombre);?> <?php echo ($dat->CliApellidoPaterno);?> <?php echo ($dat->CliApellidoMaterno);?></td>
      <td  width="9%" align="right" ><?php echo $dat->PerNombre;  ?>
        <?php //echo $dat->PerApellidoPaterno;  ?>
        <?php //echo $dat->PerApellidoMaterno;  ?></td>
      <td  width="7%" align="center" ><?php
if($PrivilegioPagoListado){
?>
        <a href="javascript:FncPagoVentaDirectaCargarFormulario('Listado','<?php echo $dat->VdiId;?>');" > <img src="imagenes/estado/abonos.png" width="25" height="25" border="0" title="Ver Abonos" alt="[Ver Abonos]"   /></a>
        <?php
}
?></td>
      <td  width="6%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
      <td  width="9%" align="right" ><?php $dat->VcoTotal = (($dat->VcoTotal/(empty($dat->VcoTipoCambio)?1:$dat->VcoTipoCambio)));?>
        <?php echo number_format($dat->VcoTotal,2);?></td>
      <td  width="9%" align="right" ><?php echo ($dat->VcoTiempoModificacion);?></td>
    </tr>
    <?php		$f++;

									
								

                
                
									

									}
									
									

									?>
  </tbody>
</table>
</body>
</html>
 