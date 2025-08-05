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
	header("Content-Disposition:  filename=\"REPORTE_PDS_PLANCHADO_PINTADO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReportePDSPlanchadoPintado.js"></script>

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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsFichaAccion = new ClsFichaAccion();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();


if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}


if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}
//MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false)

$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,false,false,"MIN-10014",false);
$ArrFichaAcciones = $ResFichaAccion['Datos'];

//deb($ArrFichaAcciones);

$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE VENTA   DEL
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
          <th width="2%">&nbsp;</th>
          <th width="10%">N° ORDEN</th>
          <th width="9%">FECHA DE OT</th>
          <th width="11%" align="center">MODELO</th>
          <th width="11%" align="center">PLACA</th>
          <th width="11%" align="center">VIN</th>
          <th width="11%" align="center">AÑO</th>
          <th width="8%">KMTJE</th>
          <th width="8%">ASESOR</th>
          <th width="8%">CONCESIONARIO</th>
          <th width="8%">FALLA DESCRITA</th>
          <th width="8%">NOMBRE DEL CLIENTE</th>
          <th width="8%">CÓDIGO REPUESTOS</th>
          <th width="8%">DESCRIPCIÓN REPUESTOS</th>
          <th width="8%">COSTO REPUESTOS</th>
          <th width="8%">MANO DE OBRA EN HORAS</th>
          <th width="8%">MANO DE OBRA EN DÓLARES</th>
          <th width="8%">CODIGO DE MANO DE OBRA</th>
          <th width="8%">DESCRIPCION OTROS</th>
          <th width="8%">OTROS</th>
          <th width="8%">SUB-TOTAL</th>
          <th width="8%">IGV</th>
          <th width="8%">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$FichaAccionSumaTotal = 0;
		$c=1;
        foreach($ArrFichaAcciones as $DatFichaAccion){
			
			$Total = 0;
	
			$InsFichaAccionTarea = new ClsFichaAccionTarea();
			$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$DatFichaAccion->FccId,NULL);
			$ArrFichaAccionTareas = $ResFichaAccionTarea['Datos'];
			
			if(!empty($ArrFichaAccionTareas)){
				foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
					
					$Total = $Total + $DatFichaAccionTarea->FatCosto;
					
				}
			}
//MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) 
			
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  <?php
				  if($_GET['P']<>2){
			 ?>
             <input onClick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]"  value="<?php echo $dat->AmoId; ?>"  />
             <?php 
				  }
				  ?>
                  
                  
                </td>
                <td  align="right" valign="top"   >
				<a target="_blank" href="../../principal.php?Mod=FichaIngreso&Form=VerEstado&Id=<?php echo ($DatFichaAccion->FinId);?>">
				<?php echo ($DatFichaAccion->FinId);?>
                </a>
                </td>
                <td  align="right" valign="top"   >&nbsp; <?php echo ($DatFichaAccion->FinFecha);?></td>
                <td align="right" valign="top"  ><?php echo ($DatFichaAccion->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatFichaAccion->FinPlaca);?></td>
                <td align="right" valign="top"  ><?php echo ($DatFichaAccion->EinVIN);?></td>
                <td align="right" valign="top"  ><?php echo ($DatFichaAccion->EinAnoFabricacion);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatFichaAccion->FinVehiculoKilometraje);?></td>
                <td  align="right" valign="top"   >
                
				<?php echo ($DatFichaAccion->PerNombre);?>
                <?php echo ($DatFichaAccion->PerApellidoPaterno);?>
                <?php echo ($DatFichaAccion->PerApellidoMaterno);?>
                
                
                
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatFichaAccion->OncNombre);?></td>
                <td  align="right" valign="top"   > 
				
				
<?PHP
foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
?>
- <?php echo $DatFichaAccionTarea->FatDescripcion; ?><br>
<?php	
}
?>
				
				<?php //echo ($DatFichaAccion->FccCausa);?></td>
                <td  align="right" valign="top"   >
				
				<?php echo ($DatFichaAccion->CliNombre);?>
				
				<?php echo ($DatFichaAccion->CliApellidoPaterno);?>
				
				<?php echo ($DatFichaAccion->CliApellidoMaterno);?></td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >&nbsp;</td>
                <td  align="right" valign="top"   >&nbsp;</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >-</td>
                <td  align="right" valign="top"   >
                
                <?php
				
				echo number_format($Total,2);				
				?>
                
                </td>
          </tr>
		<?php	
			$FichaAccionSumaTotal += $DatFichaAccion->VdiTotal;
		?>
  		
      
      
              
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
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>