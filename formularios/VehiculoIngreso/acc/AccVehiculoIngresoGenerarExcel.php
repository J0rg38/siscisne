<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"VEHICULOS_".date('d-m-Y').".xls\";");
 
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

//Nuevo
$POST_VehiculoIngresoTipo = $_POST['CmpVehiculoIngresoTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];
$POST_EstadoVehicular = $_POST['EstadoVehicular'];
$POST_ConProforma = $_POST['ConProforma'];

$POST_VehiculoMarcaId = $_POST['VehiculoMarca'];
$POST_VehiculoModeloId = $_POST['VehiculoModelo'];
$POST_VehiculoVersionId = $_POST['VehiculoVersion'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_EstadoVehicular = $_POST['EstadoVehicular'];

if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

if(!$_POST){
	$POST_EstadoVehicular = "STOCK,VENDIDO,RESERVADO,C/INCIDENCIA,TRAMITE,STOCK";
}



if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'EinTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_cam)){
	$POST_cam = 'EinVIN';
}

// Variables Extra
if(empty($POST_con)){
	$POST_con = "contiene";
}


//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngreso.php');
//DATOS
//////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL)

  
//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL)

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("ein.EinId,ein.EinVIN,VmaNombre,VmoNombre,VveNombre,EinAnoFabricacion,EinNumeroMotor,EinPlaca,EinPoliza,EinComprobanteCompraNumero",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,NULL,NULL,$POST_EstadoVehicular,$POST_VehiculoMarcaId,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
$VehiculoIngresosTotal = $ResVehiculoIngreso['Total'];
$VehiculoIngresosTotalSeleccionado = $ResVehiculoIngreso['TotalSeleccionado'];


?>



<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
    
    <thead class="EstTablaListadoHead">
      
      <tr>
        <th width="2%" >#</th>
        <th width="2%" >ID</th>
        <th width="4%" >UBICACION</th>
        <th width="4%" >AÑO PROF</th>
        <th width="4%" >MES PROF</th>
        <th width="4%" >NUM. PROF</th>
        <th width="4%" >COD. IDENT.</th>
        <th width="4%" >TIPO</th>
        <th width="4%" >VIN</th>
        <th width="5%" >MARCA</th>
        <th width="5%" >MODELO</th>
        <th width="5%" >VERSION</th>
        <th width="3%" >AÑO FAB.</th>
        <th width="4%" >AÑO MOD.</th>
        <th width="4%" >NUM. MOTOR</th>
        <th width="4%" >COLOR</th>
        <th width="4%" >DUA</th>
        <th width="8%" >ESTADO VEH.</th>
        <th width="6%" >COMPROB.</th>
        <th width="4%" >PLACA</th>
        <th width="4%" >ESTADO</th>
        <th width="8%" >FECHA CREACION</th>
        </tr>
      </thead>
    
    <tfoot class="EstTablaListadoFoot">
      
      <tr>
        
        <td colspan="22" align="center">&nbsp;</td>
        </tr>
      </tfoot>
  <tbody class="EstTablaListadoBody">
    <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrVehiculoIngresos as $dat){

								?>
    
    
    
    <tr id="Fila_<?php echo $f;?>">
      <td width="2%" align="center"  ><?php echo $f;?></td>
      <td align="right" valign="middle" width="2%"   >
        
        
        <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->EinId;?>">
        <?php echo $dat->EinId;  ?>
        </a>
        
      </td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->SucNombre;  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VprAno;  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo FncConvertirMes($dat->VprMes);  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VprCodigo;  ?></a></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VehCodigoIdentificador;  ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->VtiNombre; ?></td>
      <td align="right" valign="middle" width="4%"   ><?php echo $dat->EinVIN; ?></td>
      <td align="right" valign="middle" width="5%"   >
	  
	  
<?php
if($PrivilegioVehiculoMarcaEditar or $PrivilegioVehiculoMarcaVer){
?>

<a href="javascript:FncVehiculoMarcaCargarFormulario('<?php echo (($PrivilegioVehiculoMarcaEditar)?'Editar':'Ver');?>','<?php echo $dat->VmaId?>');"  > <?php echo $dat->VmaNombre; ?></a>

<?php
}else{
?>
 <?php echo $dat->VmaNombre; ?>
<?php	
}
?>       

	 
      
      
      </td>
      <td align="right" valign="middle" width="5%"   >
	  
<?php
if($PrivilegioVehiculoModeloEditar or $PrivilegioVehiculoModeloVer){
?>

<a href="javascript:FncVehiculoModeloCargarFormulario('<?php echo (($PrivilegioVehiculoModeloEditar)?'Editar':'Ver');?>','<?php echo $dat->VmoId?>');"  ><?php echo $dat->VmoNombre; ?></a>

<?php
}else{
?>
<?php echo $dat->VmoNombre; ?>
<?php	
}
?>  

</td>
      <td  width="5%" align="right" >
	  
<?php
if($PrivilegioVehiculoVersionEditar or $PrivilegioVehiculoVersionVer){
?>

<a href="javascript:FncVehiculoVersionCargarFormulario('<?php echo (($PrivilegioVehiculoVersionEditar)?'Editar':'Ver');?>','<?php echo $dat->VveId?>');"  ><?php echo $dat->VveNombre; ?></a>

<?php
}else{
?>
<?php echo $dat->VveNombre; ?>
<?php	
}
?>  
</td>
      <td  width="3%" align="right" ><?php echo $dat->EinAnoFabricacion; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinAnoModelo; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinNumeroMotor; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinColor; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinDUA; ?></td>
      <td  width="8%" align="right" ><h2><?php echo $dat->EinEstadoVehicular;?></h2></td>
      <td  width="6%" align="right" ><?php echo $dat->EinComprobanteCompraNumero; ?></td>
      <td  width="4%" align="right" ><?php echo $dat->EinPlaca; ?></td>
      <td  width="4%" align="right" ><?php
			switch($dat->EinEstado){
				case 1:
			?>
        Activo
        <?php
				break;
				
				case 2:
			?>
Inactivo
        <?php
				break;

			}
			?></td>
      <td  width="8%" align="right" ><?php echo ($dat->EinTiempoCreacion);?></td>
      </tr>
    
    <?php		$f++;

									}

									?>
    </tbody>
  </table>
      
      
</body>
</html>