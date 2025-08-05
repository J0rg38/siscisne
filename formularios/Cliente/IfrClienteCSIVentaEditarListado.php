<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ACTUALIZAR_CSI_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"OvvFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";
$POST_Sucursal = ($_POST['CmpSucursal']);

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');


$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

//MtdObtenerReporteOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCSIVentaIncluir=NULL) {
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR CLIENTES - CSI  VENTA DEL
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

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="6%">SUCURSAL</th>
          <th width="6%">FECHA VENTA</th>
          <th width="3%">FECHA ENTREGA</th>
          <th width="3%">ORDEN</th>
          <th width="3%">CHASIS-VIN</th>
          <th width="8%">PLACA</th>
          <th width="10%">MARCA</th>
          <th width="10%">DESCRIPCION DEL MODELO</th>
          <th width="10%">TIPO CLI.</th>
          <th width="7%">NOMBRE/APELLIDO DEL CLIENTE</th>
          <th width="5%">NRO. TELEFONO CELULAR</th>
          <th width="10%">CORREO ELECTRONICO</th>
          <th width="6%">CIUDAD</th>
          <th width="9%">PROVINCIA</th>
          <th width="16%">ASESOR DE VENTAS</th>
          <th> INCLUIR CSI</th>
          <th>FECHA EXCLUSION</th>
          <th>USUARIO EXCLUYO</th>
          <th>MOTIVO</th>
          <th>NOTAS</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculo){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo ($DatReporteOrdenVentaVehiculo->SucNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   >
		  
		  <span title="<?php echo ($DatReporteOrdenVentaVehiculo->OvvId);?>"><?php echo ($DatReporteOrdenVentaVehiculo->OvvFecha);?></span>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo $DatReporteOrdenVentaVehiculo->OvvFechaEntrega;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo ($DatReporteOrdenVentaVehiculo->OvvId);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" valign="top"   ><?php echo ($DatReporteOrdenVentaVehiculo->EinVIN);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteOrdenVentaVehiculo->EinPlaca);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteOrdenVentaVehiculo->VmaNombre);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->VmoNombre;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteOrdenVentaVehiculo->LtiAbreviatura);?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->CliNombre;  ?> <?php echo $DatReporteOrdenVentaVehiculo->CliApellidoPaterno;  ?> <?php echo $DatReporteOrdenVentaVehiculo->CliApellidoMaterno;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->CliTelefono;  ?><?php echo $DatReporteOrdenVentaVehiculo->CliCelularl;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->CliEmail;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->CliDepartamento;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->CliProvincia;  ?></td>
          <td align="left" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteOrdenVentaVehiculo->PerNombre;  ?> <?php echo $DatReporteOrdenVentaVehiculo->PerApellidoPaterno;  ?> <?php echo $DatReporteOrdenVentaVehiculo->PerApellidoMaterno;  ?></td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
            
            <input  <?php echo (($DatReporteOrdenVentaVehiculo->CliCSIVentaIncluir==1)?'checked="checked"':'')?>  type="checkbox" name="CmpClienteCSIVentaIncluir_<?php echo $DatReporteOrdenVentaVehiculo->CliId; ?>" id="CmpClienteCSIVentaIncluir_<?php echo $DatReporteOrdenVentaVehiculo->CliId; ?>" value="<?php echo $DatReporteOrdenVentaVehiculo->CliId; ?>" onChange="FncClienteCSIVentaEditarAccion('<?php echo $DatReporteOrdenVentaVehiculo->CliId; ?>');" etiqueta="cliente" >
            
            
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><div id="CapCliCSIVentaExcluirFecha_<?php echo $c;?>"> <?php echo $DatReporteOrdenVentaVehiculo->CliCSIVentaExcluirFecha;?> </div></td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><div id="CapCliCSIVentaExcluirUsuario_<?php echo $c;?>"> <?php echo $DatReporteOrdenVentaVehiculo->CliCSIVentaExcluirUsuario;?> </div></td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><div id="CapCliCSIVentaExcluirMotivo_<?php echo $c;?>"> <?php echo $DatReporteOrdenVentaVehiculo->CliCSIVentaExcluirMotivo;?> </div></td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><input name="CmpFichaIngresoObservacionCallcenter_<?php echo $c;?>" type="text" class="EstFormularioCaja" id="CmpFichaIngresoObservacionCallcenter_<?php echo $c;?>" value="<?php echo $DatReporteOrdenVentaVehiculo->FinObservacionCallcenter;?>" size="25" maxlength="255" ficha_ingreso="<?php echo  $DatReporteOrdenVentaVehiculo->FinId?>" /></td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>