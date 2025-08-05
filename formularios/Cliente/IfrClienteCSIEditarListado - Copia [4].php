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
	header("Content-Disposition:  filename=\"ACTUALIZAR_CSI_POST_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"FinFecha";
$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";
$POST_Sucursal = ($_POST['Sucursal']);

$POST_VehiculoMarca = ($_POST['VehiculoMarca']);
$POST_Modalidad = ($_POST['Modalidad']);


require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');


$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();

//MtdObtenerReporteFichaIngresoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oSucursal=NULL)
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Modalidad,NULL,$POST_Sucursal,$POST_VehiculoMarca);
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR CLIENTES / CSI POST VENTA DEL
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
          <th width="8%">SUCURSAL</th>
          <th width="8%">FECHA DE ATENCION</th>
          <th width="8%">O.T.</th>
          <th width="8%">CHASIS-VIN</th>
          <th width="8%">PLACA</th>
          <th width="10%">MARCA</th>
          <th width="10%">DESCRIPCION DEL MODELO</th>
          <th width="10%">TIPO CLI.</th>
          <th width="10%">NOMBRE/APELLIDO DEL CLIENTE</th>
          <th width="14%">NRO. TELEFONO CELULAR</th>
          <th width="14%">CORREO ELECTRONICO</th>
          <th width="14%">CIUDAD</th>
          <th width="14%">PROVINCIA</th>
          <th width="14%">NOMBRE DE ASESOR DE SERVICIO</th>
          <th width="14%">TRABAJO REALIZADO</th>
          <th width="14%"> INCLUIR CSI</th>
          <th width="14%">FECHA EXCLUSION</th>
          <th width="14%">USUARIO EXCLUYO</th>
          <th width="14%">MOTIVO</th>
          <th width="14%">NOTAS</th>
          <th width="14%">&nbsp;</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->SucNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		  <span title="<?php echo ($DatReporteFichaIngreso->FinId);?>"><?php echo ($DatReporteFichaIngreso->FinFecha);?></span>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->FinId);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->EinVIN);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->EinPlaca);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteFichaIngreso->VmaNombre);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteFichaIngreso->VmoNombre);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteFichaIngreso->LtiAbreviatura);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          <?php echo $DatReporteFichaIngreso->CliNombre;  ?>
          <?php echo $DatReporteFichaIngreso->CliNombreApellidoPaterno;  ?>
          <?php echo $DatReporteFichaIngreso->CliNombreApellidoMaterno;  ?>
          
         

          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          
		  <?php 
		  
		  echo (empty($DatReporteFichaIngreso->FinTelefono))?$DatReporteFichaIngreso->CliTelefono.'/'.$DatReporteFichaIngreso->CliCelular:$DatReporteFichaIngreso->FinTelefono;
		
		  ?>
		
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteFichaIngreso->CliEmail;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteFichaIngreso->CliDepartamento;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteFichaIngreso->CliProvincia;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
          <?php echo $DatReporteFichaIngreso->PerNombreAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoMaternoAsesor;?>
          
          
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
         
                <?php echo strtoupper($DatReporteFichaIngreso->MinNombre);?> 
                
                
                
                <?php echo (!empty($DatReporteFichaIngreso->FinMantenimientoKilometraje ) and $DatReporteFichaIngreso->MinSigla == "MA")?number_format($DatReporteFichaIngreso->FinMantenimientoKilometraje).' KMS':''; ?>
                
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
          <input  <?php echo (($DatReporteFichaIngreso->CliCSIIncluir==1)?'checked="checked"':'')?>  type="checkbox" name="CmpClienteCSIincluir_<?php echo $c; ?>" id="CmpClienteCSIincluir_<?php echo $c; ?>" value="<?php echo $c; ?>" ficha_ingreso="<?php echo $DatReporteFichaIngreso->FinId; ?>" cliente="<?php echo $DatReporteFichaIngreso->CliId; ?>" etiqueta="cliente" >   
          
         <!-- <input name="CmpClienteCSIExcluirMotivo_<?php echo $c;?>" type="text" class="EstFormularioCaja" id="CmpClienteCSIExcluirMotivo_<?php echo $c;?>" value="<?php echo $DatReporteFichaIngreso->CliCSIExcluirMotivo;?>" size="25" maxlength="255" />
          -->
                   </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
            <div id="CapCliCSIExcluirFecha_<?php echo $c;?>">
            <?php echo $DatReporteFichaIngreso->CliCSIExcluirFecha;?>
            </div>
          
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		<div id="CapCliCSIExcluirUsuario_<?php echo $c;?>">
		<?php echo $DatReporteFichaIngreso->CliCSIExcluirUsuario;?>
        </div>
          
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
        <div id="CapCliCSIExcluirMotivo_<?php echo $c;?>">
			<?php echo $DatReporteFichaIngreso->CliCSIExcluirMotivo;?>
        </div>
        
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
           <input name="CmpFichaIngresoObservacionCallcenter_<?php echo $c;?>" type="text" class="EstFormularioCaja" id="CmpFichaIngresoObservacionCallcenter_<?php echo $c;?>" value="<?php echo $DatReporteFichaIngreso->FinObservacionCallcenter;?>" size="25" maxlength="255" ficha_ingreso="<?php echo  $DatReporteFichaIngreso->FinId?>" />
           
           
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >

         <div id="CapClienteCSIEditarAccion_<?php echo $c; ?>"></div>
          
          </td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>