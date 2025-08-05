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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_COMPROBANTE_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Modalidad = $_POST['CmpModalidad'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();

//MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL)
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Modalidad);
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
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE LISTADO DE ORDENES DE TRABAJO X MODALIDAD 
  
  DEL
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
          <th width="8%">ORD. TRABAJO</th>
          <th width="5%">FECHA</th>
          <th width="17%">CLIENTE</th>
          <th width="8%">MARCA</th>
          <th width="8%">MODELO</th>
          <th width="10%">KM. MANT.</th>
          <th width="10%">KM. REAL</th>
          <th width="10%">MODALIDAD</th>
          <th width="14%">TECNICO</th>
          <th width="10%">TIEMPO ESTIMADO</th>
          <th width="10%">COMP</th>
          <th width="10%">FEC. COMPROB.</th>
          <th width="10%">NUM. COMPROB.</th>
          <th width="10%">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
			$FichaIngresoModalidadTotal = 0;		
			$FichaIngresoModalidadFacturadoTotal = 0;		
			$FichaIngresoModalidadNoFacturadoTotal = 0;					
			
		$c=1;
        foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
          <?php echo $DatReporteFichaIngreso->FinId;  ?>
          <a target="_blank" href="../../principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatReporteFichaIngreso->FinId;  ?>">
			 
             </a>
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteFichaIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngreso->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngreso->VmaNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngreso->VmoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
           <?php
		  if(!empty($DatReporteFichaIngreso->FinMantenimientoKilometraje) and $DatReporteFichaIngreso->MinId == "MIN-10001"){
			?>
          <?php echo number_format($DatReporteFichaIngreso->FinMantenimientoKilometraje);  ?>
            <?php  
		  }
		  ?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
            <?php echo number_format($DatReporteFichaIngreso->FinVehiculoKilometraje);  ?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          <?php echo $DatReporteFichaIngreso->MinNombre;  ?>
          
         

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo ($DatReporteFichaIngreso->PerNombre);?>
          <?php echo ($DatReporteFichaIngreso->PerApellidoPaterno);?>
          <?php echo ($DatReporteFichaIngreso->PerApellidoMaterno);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo round($DatReporteFichaIngreso->FinTiempoTranscurrido2,2);?>
            <?php //echo round($DatReporteFichaIngreso->FinTiempoTranscurrido,2);?>
            hrs </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
		  <?php echo $DatReporteFichaIngreso->FinComprobanteVentaTipo; ?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
        //  deb($DatReporteFichaIngreso->FccFacturable);
		  if($DatReporteFichaIngreso->FccFacturable=="2"){
			 ?>
             No Facturable
             <?php 
		  }
          ?>
		  <?php
			switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
				
				case "F":
			?>
            <?php echo $DatReporteFichaIngreso->FacFechaEmision;?>
            <?php	
				break;
				
				case "B":
			?>
            <?php echo $DatReporteFichaIngreso->BolFechaEmision;?>
          <?php	
				break;
				
			}
			?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
			<?php
            if($DatReporteFichaIngreso->FccFacturable=="2"){
            ?>
				No Facturable
            <?php 
            }
            ?>
            
			<?php
            
			switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
            
            	case "F":
            ?>
            	<?php echo $DatReporteFichaIngreso->FtaNumero;?> - <?php echo $DatReporteFichaIngreso->FacId;?>
            <?php	
				break;
            
				case "B":
            ?>
            	<?php echo $DatReporteFichaIngreso->BtaNumero;?> - <?php echo $DatReporteFichaIngreso->BolId;?>
            <?php	
            	break;
            
            }
			
            ?>
            
            
            </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
			<?php
			switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
				
				case "F":
				
				$FichaIngresoModalidadFacturadoTotal++;
				
			?>
            
				<?php echo number_format($DatReporteFichaIngreso->FacTotal,2);?>
            
			<?php	
				break;
				
				case "B":
				
				$FichaIngresoModalidadNoFacturadoTotal++;
			?>
            
				<?php echo number_format($DatReporteFichaIngreso->BolTotal,2);?> 
            
			<?php	
				break;
				
			}
			?>
            
            </td>
          </tr>
        <?php	
		$FichaIngresoModalidadTotal++;
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>


<table width="100%">
<tr>
  <td align="right">Total Fichas: </td>
<td align="right">&nbsp;</td>
</tr>
<tr>
  <td align="right">Total Facturados: </td>
<td align="right">&nbsp;</td>
</tr>
</table>


<p class="EstTablaReporteNota">
Del
<?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> al <?php echo $POST_ffin; ?>
      <?php  
  }
?>
</p>


</body>
</html>