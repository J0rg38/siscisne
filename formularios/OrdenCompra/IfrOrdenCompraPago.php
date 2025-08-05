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
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();


//MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL)
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL);
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="271" height="92" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR CSI POST VENTA DEL
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
          <th width="8%">FECHA DE ATENCION</th>
          <th width="8%">CHASIS-VIN</th>
          <th width="8%">PLACA</th>
          <th width="10%">DESCRIPCION DEL MODELO</th>
          <th width="10%">NOMBRE/APELLIDO DEL CLIENTE</th>
          <th width="14%">NRO. TELEFONO CELULAR</th>
          <th width="14%">CORREO ELECTRONICO</th>
          <th width="14%">CIUDAD</th>
          <th width="14%">PROVINCIA</th>
          <th width="14%">CODIGO DEALER</th>
          <th width="14%">NOMBRE DEALER</th>
          <th width="14%">NOMBRE DE ASESOR DE SERVICIO</th>
          <th width="14%">TRABAJO REALIZADO</th>
          <th width="14%">INCLUIR EN CSI</th>
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
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		  <span title="<?php echo ($DatReporteFichaIngreso->FinId);?>"><?php echo ($DatReporteFichaIngreso->FinFecha);?></span>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->EinVIN);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatReporteFichaIngreso->EinPlaca);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatReporteFichaIngreso->VmoNombre);?></td>
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
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteFichaIngreso->OncCodigoDealer;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo $DatReporteFichaIngreso->OncNombre;  ?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
          <?php echo $DatReporteFichaIngreso->PerNombreAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoMaternoAsesor;?>
          
          
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
         
                <?php echo strtoupper($DatReporteFichaIngreso->MinNombre);?> 
                
                
                
                <?php echo (!empty($DatReporteFichaIngreso->FinMantenimientoKilometraje ) and $DatReporteFichaIngreso->MinSigla == "MA")?number_format($DatReporteFichaIngreso->FinMantenimientoKilometraje).' KMS':''; ?>
                
          </td>
          <td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
          
<input  <?php echo (($DatReporteFichaIngreso->CliCSIIncluir==1)?'checked="checked"':'')?>  type="checkbox" name="CmpClienteCSIincluir_<?php echo $DatReporteFichaIngreso->CliId; ?>" id="CmpClienteCSIincluir_<?php echo $DatReporteFichaIngreso->CliId; ?>" value="<?php echo $DatReporteFichaIngreso->CliId; ?>" onChange="FncClienteCSIEditarAccion('<?php echo $DatReporteFichaIngreso->CliId; ?>');" etiqueta="cliente" >
          
          
          </td>
<td align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >

<div id="CapClienteCSIEditarAccion_<?php echo $DatReporteFichaIngreso->CliId; ?>"></div>

<!--<div <?php echo (($DatReporteFichaIngreso->CliCSIIncluir==1)?'style="visibility:hidden"':'')?>  id="CapExcluir<?php echo $DatReporteFichaIngreso->CliId; ?>">
<a href="javascript:FncClienteCSIEditarExcluir('<?php echo $DatReporteFichaIngreso->CliId; ?>');">
<img src="imagenes/acciones/nochekeado.png" width="18" height="18" border="0">
</a>
</div>


<div <?php echo (($DatReporteFichaIngreso->CliCSIIncluir==2)?'style="visibility:hidden"':'')?> id="CapIncluir<?php echo $DatReporteFichaIngreso->CliId; ?>">
<a href="javascript:FncClienteCSIEditarIncluir('<?php echo $DatReporteFichaIngreso->CliId; ?>');">
<img src="imagenes/acciones/chekeado.png" width="18" height="18" border="0">
</a>
</div>-->


    <!--
<a href="../../principal2.php?Mod=Cliente&Form=CSIEditar&Id=<?php echo $DatReporteFichaIngreso->CliId?>&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=500&modal=true" class="thickbox" title="">[CSI]</a>
		-->
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>