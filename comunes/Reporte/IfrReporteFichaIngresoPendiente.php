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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_PENDIENTE_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";


require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');


$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
$InsPedidoCompra = new ClsPedidoCompra();
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();

$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionTarea = new ClsFichaAccionTarea();


//MtdObtenerReporteFichaIngresoPendientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oDiaTranscurrido=NULL) {
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPendientes(NULL,NULL,NULL,$POST_ord,$POST_sen,"",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,3,"11,2,3,4,5,6,7,71,72",1);
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE TRABAJO 
  
  X MODALIDAD DEL
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
          <th width="5%">MODALIDAD</th>
          <th width="5%">FECHA</th>
          <th width="17%">DIAS. TRANSC.</th>
          <th width="17%">CLIENTE</th>
          <th width="8%">MODELO</th>
          <th width="10%">PLACA</th>
          <th width="10%">ASESOR</th>
          <th width="10%">DIAGNOSTICO</th>
          <th width="10%">OBSERVACION</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		   <a target="_blank" href="../../principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatReporteFichaIngreso->FinId;  ?>">
			 <?php echo $DatReporteFichaIngreso->FinId;  ?>
             </a>
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          

<?php
$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatReporteFichaIngreso->FinId,NULL);
$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
 
if(!empty($ArrFichaIngresoModalidades)){						
	foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
?>
		<?php echo $DatFichaIngresoModalidad->MinNombre;?><br>
<?php
		
	}						
}
?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteFichaIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteFichaIngreso->FinDiaTranscurrido);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" > <?php echo $DatReporteFichaIngreso->CliNombre;  ?> <?php echo $DatReporteFichaIngreso->CliApellidoPaterno;  ?> <?php echo $DatReporteFichaIngreso->CliApellidoMaterno;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngreso->VmoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteFichaIngreso->EinPlaca);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteFichaIngreso->PerNombreAsesor);?> <?php echo ($DatReporteFichaIngreso->PerApellidoPaternoAsesor);?> <?php echo ($DatReporteFichaIngreso->PerApellidoMaternoAsesor);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <?php
		  
		  $diagnostico = "";
				  
				 if(!empty($ArrFichaIngresoModalidades)){			
						foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
							
							$diagnostico .= "";
							
//MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha") {
							$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','Desc',NULL,$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL,NULL,false,false,NULL,false,NULL,false,"fcc.FccFecha");								
							$ArrFichaAcciones = $ResFichaAccion['Datos'];
							
							//deb($ArrFichaAcciones);
							if(!empty($ArrFichaAcciones)){
								foreach ($ArrFichaAcciones as $DatFichaAccion){
									
									//MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {
									$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$DatFichaAccion->FccId,NULL);
									$ArrFichaAccionTareas = $ResFichaAccionTarea['Datos'];
									
									if(!empty($ArrFichaAccionTareas)){
										foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
												$diagnostico .= $DatFichaAccionTarea->FatDescripcion;
												$diagnostico .= ". ";
										}
									}
								
								}								
							}
							
						}						
					}
					
				
          
          ?>
          
          <?php echo $diagnostico;?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
<?php			
				$observacion = "";
				
				if(!empty($DatReporteFichaIngreso->FinNota)){
					   $observacion .= $DatReporteFichaIngreso->FinNota.": ";
				  }
				

//				  MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array()) {
					$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,'PcoId','Desc','0,10',NULL,NULL,3,NULL,1,NULL,NULL,NULL,$DatReporteFichaIngreso->FinId,array());
					$ArrPedidoCompras = $ResPedidoCompra['Datos'];	
					
					if(!empty($ArrPedidoCompras)){
						
						$observacion .= "Tiene (".count($ArrPedidoCompras).") pedido(s) ";
						
						$pedido_aux = "";
						
						foreach($ArrPedidoCompras as $DatPedidoCompra){
							
							$pedido = "";
							
															
							$ArrOrden = explode("-",$DatPedidoCompra->OcoId);	
							
							if($ArrOrden[1]=="STK"){
								$pedido .= "STOCK";
							}else if($ArrOrden[1]=="ZGAR"){
								$pedido .= "GARANTIA";
							}else if($ArrOrden[1]=="ZVOR"){
								$pedido .= "IMPORTACION";
							}else{
								$pedido .= "";
							}
							
							if($pedido<>$pedido_aux){
								$observacion .= $pedido;
							}
							
							
							$observacion .= "<br>";
							
							$pedido_aux = $pedido;
						}
						
						
						$pendientes = 0;
						foreach($ArrPedidoCompras as $DatPedidoCompra){
							
							$ResPedidoCompraDetalle =  $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,NULL,NULL,NULL,$DatPedidoCompra->PcoId);
							$ArrPedidoCompraDetalles = 	$ResPedidoCompraDetalle['Datos'];	
							
							if(!empty($ArrPedidoCompraDetalles)){
								
								foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle ){
									//$DatPedidoCompraDetalle->PcdCantidadPendiente
									if($DatPedidoCompraDetalle->PcdCantidadPendiente>1){
										$pendientes++;
									}
									
								}
							}
							
							if($pendientes>0){
								$observacion .= " con (".$pendientes.") repuestos pendientes ";								
							}
							
							$observacion .= "<br>";
						}
						
					}
					
					
					
?>
		  <?php echo ($observacion);?></td>
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>