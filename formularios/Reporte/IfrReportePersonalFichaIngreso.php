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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_TECNICO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 



<script type="text/javascript" src="js/JsReporteOrdenCompraLlegada.js"></script>
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

$POST_FechaInicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:date("d/m/Y");
$POST_FechaFin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"PerNombre";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"ASC";

$POST_Sucursal = isset($_GET['CmpSucursal'])?$_GET['CmpSucursal']:$_SESSION['SesionSucursal'];

$POST_Detalle = ($_GET['CmpDetalle']);

//deb($_GET);


require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteTallerPedido.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');

$InsPersonal = new ClsPersonal();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
$InsTallerPedido = new ClsTallerPedido();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$InsReporteTallerPedido = new ClsReporteTallerPedido();

$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1);
//$ArrTecnicos = $ResPersonal['Datos'];
 
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL);
$ArrTecnicos = $ResPersonal['Datos'];

////MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL)
//$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL,"PerNombre","ASC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"MIN-10001,MIN-10003,MIN-10019,MIN-10020,MIN-10021,MIN-10016,MIN-10026",NULL,NULL,NULL,false,NULL,false,$POST_Sucursal);
//$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE RESUMEN DE ORDEN DE TRABAJO X TECNICO (MECANICO) DEL
      <?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
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
        
        <table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="17">#</th>
          <th width="72">TECNICO</th>

			<?php
            foreach($ArrModalidadIngresos as $DatModalidadIngreso){
//				if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI"){
					if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3"  or $DatModalidadIngreso->MinSigla == "AD"){
				?>
					
                    <th width="80"><span title="<?php echo strtoupper($DatModalidadIngreso->MinSigla)?>"><?php echo strtoupper($DatModalidadIngreso->MinSigla)?></span></th>       
					<th width="80">MONTO OT</th>
                   
		  <?php	
					}
            }
			?>
            	<th width="80">OTROS</th>       
				<th width="80">MONTO OT OTROS</th>
                    
			<th width="104">TOTAL OTs</th>
			<th width="73">TOTAL MONTO OT</th>
			<th width="73">ABONOS REPUESTOS</th>
		  <th width="53">SUMA TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$ModalidadPersonalFichaIngreso = array();
		$ModalidadFacturado = array();
				
	
		//$ModalidadPersonalFichaIngresoOtros = 0;
//		$ModalidadFacturadoOtros = 0;
$ModalidadPersonalFichaIngresoOtros = 0;
$ModalidadFacturadoOtros = 0;	

$SumaTotalPersonalFichaIngreso = 0;
$SumaTotaMecanicolFacturacion = 0;
$SumaTotalPago = 0;
$SumaTotalIngresos = 0;





        foreach($ArrTecnicos as $DatTecnico){
			
			
			$TotalIngresos = 0;
			$Facturado = 0;
			$TotalPago = 0;
			$TotaMecanicolFacturacion = 0;
									
			$TallerPedidoTotalOtros = 0;
			$FichaAccionManoObraTotalOtros = 0;

        ?>
        
                
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"     ><?php echo $c;?></td>
                <td  align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  >
                  
                  <?php echo ($DatTecnico->PerNombre);?>
  <?php echo ($DatTecnico->PerApellidoPaterno);?>
                  <?php echo ($DatTecnico->PerApellidoMaterno);?>	
                  
                </td>
<?php
			   
$TotalPersonalFichaIngreso = 0;
$TotaMecanicolFacturacion = 0;


$FacturadoOtros = 0;

		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
			if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3" or $DatModalidadIngreso->MinSigla == "AD"){
				
				
?>
					
					
					<?php
                    $InsFichaIngreso = new ClsFichaIngreso();
                    //MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL) {
                    $TotalPersonalModalidadFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,NULL,NULL,NULL,NULL,'fin.FinId','Desc',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,$DatTecnico->PerId,0,NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,false,false,$POST_Sucursal);
                    
                    $TotalPersonalFichaIngreso += $TotalPersonalModalidadFichaIngreso;
					
					$ModalidadPersonalFichaIngreso[$DatModalidadIngreso->MinId] += $TotalPersonalModalidadFichaIngreso;
                    ?>
                                
          
             <td width="80"  align="center" valign="top" bgcolor="#FFCC66"   >
               
			   <?php //echo number_format($TotalPersonalModalidadFichaIngreso,2);?>
               <?php echo round($TotalPersonalModalidadFichaIngreso,2);?>
               
               </td>
               
               <td width="80" align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">

                
                <?php
                $Facturado = 0;
                $BoletaTotal = 0;
                $FacturaTotal = 0;
               
			   
				$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,false,$POST_Sucursal,"FinFecha",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$DatTecnico->PerId);
      			$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];
        
                //MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)
               // $BoletaTotal = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotal",NULL,NULL,NULL,NULL,NULL,'BolId','Desc',NULL,$POST_Sucursal,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);
               //MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)  
              //  $FacturaTotal = $InsFactura->MtdObtenerFacturasValor("SUM","FacTotal",NULL,NULL,NULL,NULL,NULL,'FacId','Desc',1,NULL,$POST_Sucursal,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);
                
				//MtdObtenerTallerPedidosValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oPersonal=NULL,$oSucursal=NULL) {
				//$TallerPedidoTotal = $InsTallerPedido->MtdObtenerTallerPedidosValor("SUM","amo.AmoTotal",NULL,NULL,NULL,NULL,NULL,NULL,'amo.AmoId','Desc','1',FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,NULL,0,0,NULL,NULL,false,$DatModalidadIngreso->MinId,$DatTecnico->PerId,$POST_Sucursal);
				
				//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oModalidadIngreso=NULL,$oPersonal=NULL,$oSucursal=NULL) {
				//$TallerPedidoTotal = $InsReporteTallerPedido->MtdObtenerTallerPedidoDetallesValor("SUM","amd.AmdImporte",NULL,NULL,NULL,NULL,'amd.AmdId','Desc','1',NULL,3,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,$DatTecnico->PerId,$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin));
				
				//MtdObtenerFichaAccionesValor($oFuncion,$oParametro,$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL,$oPersonal=NULL) {
				//$FichaAccionManoObraTotal = $InsFichaAccion->MtdObtenerFichaAccionesValor("SUM","fcc.FccManoObra",NULL,NULL,NULL,NULL,NULL,'fcc.FccId','Desc','1',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,false,false,$DatModalidadIngreso->MinId,NULL,$POST_Sucursal,NULL,$DatTecnico->PerId);
				
				 //$Facturado = $BoletaTotal + $FacturaTotal;
				//$Facturado = $TallerPedidoTotal + $FichaAccionManoObraTotal;
				
				$Facturado = 0;
				
				if(!empty($ArrReporteFichaIngresos)){
					foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
						
						if($DatModalidadIngreso->MinId == $DatReporteFichaIngreso->MinId){
							
							//$Facturado += $DatReporteFichaIngreso->FacTotal + $DatReporteFichaIngreso->BolTotal;
							
							 switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
					
								case "F":
									$Facturado += $DatReporteFichaIngreso->FacTotal;
								break;
								
								case "B":
									 $Facturado += $DatReporteFichaIngreso->BolTotal;
								break;
								
								default:
									
								break;
								
							}


							
						}
						
					}
				}
				
				$ModalidadFacturado[$DatModalidadIngreso->MinId] += $Facturado;
                
                ?>
                
                <?php //echo number_format($Facturado,2);?>
                
                <span title="<?php echo $TallerPedidoTotal;?> / <?php echo $FichaAccionManoObraTotal;?>">
				<?php echo round($Facturado,2);?>
            	</span>
               </td>
<?php	
				$TotaMecanicolFacturacion += $Facturado;
			

			}else if($DatModalidadIngreso->MinSigla <> "GA" and $DatModalidadIngreso->MinSigla <> "OB" ){
			
			
				 $InsFichaIngreso = new ClsFichaIngreso();
                 //MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL) {
                 $TotalPersonalModalidadFichaIngresoOtro = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,NULL,NULL,NULL,NULL,'fin.FinId','Desc',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,$DatTecnico->PerId,0,NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,false,false,$POST_Sucursal);
                    
				 $TotalPersonalModalidadFichaIngresoOtros += $TotalPersonalModalidadFichaIngresoOtro;
				
                 
				 
				 
				
				 
				 
				$FacturadoOtro = 0;
                $BoletaTotalOtro = 0;
                $FacturaTotalOtro = 0;
                
                //MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)
               // $BoletaTotalOtro = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotal",NULL,NULL,NULL,NULL,NULL,'BolId','Desc',NULL,$POST_Sucursal,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);
               //MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL)  
               // $FacturaTotalOtro = $InsFactura->MtdObtenerFacturasValor("SUM","FacTotal",NULL,NULL,NULL,NULL,NULL,'FacId','Desc',1,NULL,$POST_Sucursal,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);
                
				//$TallerPedidoTotalOtro = $InsTallerPedido->MtdObtenerTallerPedidosValor("SUM","AmoTotal",NULL,NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,NULL,0,0,NULL,NULL,false,$DatModalidadIngreso->MinId,$DatTecnico->PerId);
				
				//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oModalidadIngreso=NULL,$oPersonal=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
				//$TallerPedidoTotalOtro = $InsReporteTallerPedido->MtdObtenerTallerPedidoDetallesValor("SUM","amd.AmdImporte",NULL,NULL,NULL,NULL,'amd.AmdId','Desc','1',NULL,3,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,$DatTecnico->PerId,$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin));
					
				
				//MtdObtenerFichaAccionesValor($oFuncion,$oParametro,$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL,$oPersonal=NULL) {
				//$FichaAccionManoObraTotalOtro = $InsFichaAccion->MtdObtenerFichaAccionesValor("SUM","fcc.FccManoObra",NULL,NULL,NULL,NULL,NULL,'fcc.FccId','Desc','1',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,false,false,$DatModalidadIngreso->MinId,NULL,$POST_Sucursal,NULL,$DatTecnico->PerId);
				
				
				
                //$FacturadoOtro = $BoletaTotalOtro + $FacturaTotalOtro;
				//$FacturadoOtro = $TallerPedidoTotalOtro + $FichaAccionManoObraTotalOtro;
				
				   
				$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,false,$POST_Sucursal,"FinFecha",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$DatTecnico->PerId);
      			$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];
				
				$FacturadoOtro = 0;
				
				if(!empty($ArrReporteFichaIngresos)){
					foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
						
						if($DatModalidadIngreso->MinId == $DatReporteFichaIngreso->MinId){
							
							
							 switch($DatReporteFichaIngreso->FinComprobanteVentaTipo){
					
								case "F":
									$FacturadoOtro += $DatReporteFichaIngreso->FacTotal;
								break;
								
								case "B":
									 $FacturadoOtro += $DatReporteFichaIngreso->BolTotal;
								break;
								
								default:
									
								break;
								
							}
							
							
						}
						
					}
				}
				
				
				$FacturadoOtros += $FacturadoOtro;
				
				$TotaMecanicolFacturacion += $FacturadoOtro;
				
				
				$TallerPedidoTotalOtros += $TallerPedidoTotalOtro;
				$FichaAccionManoObraTotalOtros += $FichaAccionManoObraTotalOtro;
				
				
			}
			
				 
				
			
		}
		
	$TotalPersonalFichaIngreso += $TotalPersonalModalidadFichaIngresoOtros;
	//////////////		
	$ModalidadPersonalFichaIngresoOtros += $TotalPersonalModalidadFichaIngresoOtros;
	$ModalidadFacturadoOtros += $FacturadoOtros;
	

	
	
?> <td width="80"  align="center" valign="top" bgcolor="#66CC33"   >
 <?php //echo number_format($TotalPersonalModalidadFichaIngresoOtros,2);?>
  <?php echo round($TotalPersonalModalidadFichaIngresoOtros,2);?>

              </td>
                <td width="80" align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php //echo number_format($FacturadoOtros,2);?>      
          
          <span title="<?php echo ($TallerPedidoTotalOtros);?> / <?php echo $FichaAccionManoObraTotalOtros;?> ">
            <?php echo round($FacturadoOtros,2);?>      
				</span>
                
                </td>

             <td  align="right" valign="top" bgcolor="#FF9900"   >
			 
			 <?php //echo number_format($TotalPersonalFichaIngreso,2);?>
			 <?php echo round($TotalPersonalFichaIngreso,2);?>
             
             <?php 	$SumaTotalPersonalFichaIngreso += $TotalPersonalFichaIngreso;?>
             
             </td>
             <td  align="right" valign="top"   >
			 
			 <?php
//echo number_format($TotaMecanicolFacturacion,2);
?>

			 <?php
echo round($TotaMecanicolFacturacion,2);
?>


<?php
$SumaTotaMecanicolFacturacion+=$TotaMecanicolFacturacion;
?>

</td>
             <td  align="right" valign="top"   >

<?php
///MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0)
$InsPago = new ClsPago();
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",NULL,NULL,$POST_Sucursal,NULL,$DatTecnico->PerId,NULL,1);
$ArrPagos =  $ResPago['Datos'];
?>
               
               <?php
$TotalPago = 0;
if(!empty($ArrPagos)){
	foreach($ArrPagos as $DatPago){
?>
               <?php
		$TotalPago += $DatPago->PagMonto;
?>
               <?php	
	}
}
?>
               
               <?php
//echo number_format($TotalPago,2);
echo round($TotalPago,2);
?>

<?php $SumaTotalPago+=$TotalPago;?>

</td>
             <td  align="right" valign="top"   >
               
<?php
$TotalIngresos = $TotalPago + $TotaMecanicolFacturacion;
?>
               
<?php
echo round($TotalIngresos,2);
?>
               
<?php
$SumaTotalIngresos += $TotalIngresos;
?>             </td>
               
                </tr>
      

        <?php	
		 $c++;
        }
        ?>
        
        
          <tr>
            <td  align="right" valign="middle"   class="EstTablaReporteColumnaEspecial4"    >&nbsp;</td>
            <td  align="right" valign="top"  class="EstTablaReporteColumnaEspecial4"  >TOTALES:</td>
                   
                   <?php
				   
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
			if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3" or $DatModalidadIngreso->MinSigla == "AD"){

				   ?>
            <td width="80"  align="center" valign="top"  class="EstTablaReporteColumnaEspecial4"	  >
                  
                     <?php echo round($ModalidadPersonalFichaIngreso[$DatModalidadIngreso->MinId],2);?>
                  
            </td>
            <td width="80" align="center" valign="top"  class="EstTablaReporteColumnaEspecial4"	>
                   
                     <?php echo round($ModalidadFacturado[$DatModalidadIngreso->MinId],2);?>
                     
            </td>
                    <?php
			}
		}
					?>
                    <td width="80"  align="center" valign="top"  class="EstTablaReporteColumnaEspecial4"  >
                    
                    <?php echo round($ModalidadPersonalFichaIngresoOtros,2);?>
                    
                    </td>
            <td width="80" align="center" valign="top" class="EstTablaReporteColumnaEspecial4">
            <?php echo round($ModalidadFacturadoOtros,2);?>
            
            </td>
            <td  align="right" valign="top" class="EstTablaReporteColumnaEspecial4"   >
            
            <?php echo round($SumaTotalPersonalFichaIngreso,2);?>
            </td>
            <td  align="right" valign="top"  class="EstTablaReporteColumnaEspecial4"   >
			
			<?php echo round($SumaTotaMecanicolFacturacion,2);?>
            
            </td>
            <td  align="right" valign="top"  class="EstTablaReporteColumnaEspecial4"  >
           
            <?php echo round($SumaTotalPago,2);?>
            </td>
            <td  align="right" valign="top"   class="EstTablaReporteColumnaEspecial4" >
            
             <?php echo round($SumaTotalIngresos,2);?>
             
            </td>
          </tr>
                  
                  
                  
                  
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
<table>
<tr>
	<?php
            foreach($ArrModalidadIngresos as $DatModalidadIngreso){
//				if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI"){
					if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3"  or $DatModalidadIngreso->MinSigla == "AD"){
				?>
					
    <td><b><?php echo ($DatModalidadIngreso->MinSigla)?>:</b> <?php echo ($DatModalidadIngreso->MinNombre)?> </td>
                   
		  <?php	
					}
            }
			?>
            </tr>
       </table>     
    
<?php
if($POST_Detalle=="Si"){
?>

     
<hr>

 <?php
 if(!empty($ArrTecnicos)){
	foreach($ArrTecnicos as $DatTecnico){	
		
?>
        
        
        <?php	
                
        //MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL)
        //    public function MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL,$oFecha="FinFecha",$oComprobanteFechaInicio=NULL,$oComprobanteFechaFin=NULL) {
        //$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10019,MIN-10020,MIN-10021,MIN-10016,MIN-10026",NULL,NULL,NULL,false,NULL,false,$POST_Sucursal,"FinFecha",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin));
        
        //MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL,$oFecha="FinFecha",$oComprobanteFechaInicio=NULL,$oComprobanteFechaFin=NULL,$oPersonal=NULL) 
        $ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,false,$POST_Sucursal,"FinFecha",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$DatTecnico->PerId);
        $ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];
        
        //MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL) {
        $InsPago = new ClsPago();
        $ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",NULL,NULL,$POST_Sucursal,$oFichaIngresoId=NULL,$DatTecnico->PerId);
        $ArrPagos =  $ResPago['Datos'];
        
        
        $TotalAbono = 0;
        $TotalFacturado = 0;
        
        ?>
        <?php
		if(!empty($ArrReporteFichaIngresos) || !empty($ArrPagos)){
		?>
       
        
        <b>TECNICO: <?php echo $DatTecnico->PerNombre;?> <?php echo $DatTecnico->PerApellidoPaterno;?> <?php echo $DatTecnico->PerApellidoMaterno;?></b><br>


		LISTADO DE ORDENES DE TRABAJO:<br>


		<?php
        if(!empty($ArrReporteFichaIngresos)){
        ?>
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
        
                    <?php
                    if($POST_Detalle=="Si"){
                    ?>
                    
                    
                  <th width="10%">DETALLE</th>
                    <th width="10%">OBSERVACIONES</th>
                  <?php
                    }
                    ?>
                  
                
                  <th width="10%">MODALIDAD</th>
                  <th width="14%">TECNICO</th>
                  <th width="10%">FECHA TERMINADO</th>
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
                     $TotalHorasTrabajadas = 0;
                     
                $c=1;
                foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
                ?>
                <tr   >
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
                  
                  <?php echo $DatReporteFichaIngreso->FinId;  ?>
                <!--  <a target="_blank" href="../../principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatReporteFichaIngreso->FinId;  ?>">
                     
                     </a>-->
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
                 <?php
                    if($POST_Detalle=="Si"){
                    ?>
                 
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >
                   <?php
                                    if(!empty($DatReporteFichaIngreso->FccCausa)){
                                    ?>
        Causa: <?php echo $DatReporteFichaIngreso->FccCausa;?>
        <?php	
                                    }
                                    ?>
                  
                  
                  
                  <?php
                  if(!empty($DatReporteFichaIngreso->FccId)){
                ?>
                  <?php
                                    //MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {
                                        $InsFichaAccionTarea = new ClsFichaAccionTarea();
                                        $ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$DatReporteFichaIngreso->FccId,NULL) ;
                                        $ArrFichaAccionTareas = $ResFichaAccionTarea['Datos'];
                                            
                                        //echo "abc: ".count($ArrFichaAccionTareas);
                                       // deb($ArrFichaAccionTareas);
                                    ?>
        <?php
                                    if(!empty($ArrFichaAccionTareas)){
                                    ?>
        Tareas:
        <?php
                                        foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
                                    ?>
        - <?php echo $DatFichaAccionTarea->FatDescripcion?><br>
        <?php		
                                        }
                                    }
                                    ?>
                                    
                <?php	  
                  }
                  ?>
                  
                
                                    
                  </td>
                   <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" ><?php echo $DatReporteFichaIngreso->FinTallerObservacion;?> <?php echo $DatReporteFichaIngreso->FinSalidaObservacion;?></td>
                
                  <?php
                  }
                  ?>
                  
                   <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
                  <?php echo $DatReporteFichaIngreso->MinNombre;  ?>
                  
                 
        
                  </td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
                  
                  <?php echo ($DatReporteFichaIngreso->PerNombre);?>
                  <?php echo ($DatReporteFichaIngreso->PerApellidoPaterno);?>
                  <?php echo ($DatReporteFichaIngreso->PerApellidoMaterno);?>
                  
                  </td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngreso->FinTiempoTallerConcluido;  ?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
                  
                  
                  <?php 
                  $TotalHorasTrabajadas +=round($DatReporteFichaIngreso->FinTiempoTranscurrido2,2);
                  echo round($DatReporteFichaIngreso->FinTiempoTranscurrido2,2);
                  
                  ?>
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
                        $TotalFacturado += $DatReporteFichaIngreso->FacTotal;
                    ?>
                    
                        <?php echo number_format($DatReporteFichaIngreso->FacTotal,2);?>
                    
                    <?php	
                        break;
                        
                        case "B":
                        
                        $FichaIngresoModalidadFacturadoTotal++;
                        $TotalFacturado += $DatReporteFichaIngreso->BolTotal;
                    ?>
                    
                        <?php echo number_format($DatReporteFichaIngreso->BolTotal,2);?> 
                    
                    <?php	
                        break;
                        
                        default:
                            $FichaIngresoModalidadNoFacturadoTotal++;
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
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    
                     <?php
                    if($POST_Detalle=="Si"){
                    ?>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                      <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <?php
                    }
                    ?>
                    
                  
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td colspan="3" align="right" class="EstTablaReporteColumnaEspecial4">TOTAL ORDEN DE TRABAJO:</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">
                    
                    <?php echo number_format($TotalFacturado,2);?>
                    </td>
                  </tr>
                </tbody>
                <tfoot class="EstTablaReporteFoot">
                </tfoot>
                </table>
          <?php
        }
        ?>
        
		LISTADO DE ABONOS:<br>

		<?php
        if(!empty($ArrPagos)){
        ?>
        
                <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
                <thead class="EstTablaReporteHead">
                <tr>
                  <th width="3%">#</th>
                  <th width="9%">ID</th>
                  <th width="6%">FECHA</th>
                  <th width="19%">CLIENTE</th>
                  <th width="9%">ORD. VEN.</th>
               
                   <?php
                    if($POST_Detalle=="Si"){
                    ?>
                    
                       <th width="22%">CODIGO</th>
                  <th width="22%">NOMBRE</th>
                 
                  <th width="22%">CANTIDAD</th>
                  <?php
					}
				  ?>
                  <th width="7%">MONEDA </th>
                  <th width="3%">T.C.</th>
                  <th width="11%">MONTO</th>
                  <th width="11%">MONTO EN <?php echo $EmpresaMoneda;  ?></th>
                  </tr>
                </thead>
                <tbody class="EstTablaReporteBody">
                
                
                <?php
                    
                $c=1;
                foreach($ArrPagos as $DatPago){
                ?>
                <tr   >
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
                  
                <!--  <a href="../../formularios/PagoVentaDirecta/FrmPagoVentaDirectaImprimir.php?Id=<?php echo $DatPago->PagId;  ?>" target="_blank">
                -->  <?php echo $DatPago->PagId;  ?>
             <!--  </a>-->
                  </td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->PagFecha;  ?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
                  
                  <?php echo $DatPago->CliNombre;  ?> <?php echo $DatPago->CliApellidoPaterno;  ?> <?php echo $DatPago->CliApellidoMaterno;  ?>
                  
                  </td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
				  
                  
                     <?php
        $InsPagoComprobante = new ClsPagoComprobante();
        $ResPagoComprobante =  $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,"PacId","ASC",NULL,$DatPago->PagId);
        $ArrPagoComprobantes = $ResPagoComprobante['Datos'];	
        ?>
        
        <?php
        if(!empty($ArrPagoComprobantes)){
            foreach($ArrPagoComprobantes as $DatPagoComprobante){
        ?>
                <?php echo $DatPagoComprobante->VdiId;?>
                
               
        <?php		
            }
        }
        
        ?>   
                  
                  
                  </td>
                    <?php
                    if($POST_Detalle=="Si"){
                    ?>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php
        $InsPagoComprobante = new ClsPagoComprobante();
        $ResPagoComprobante =  $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,"PacId","ASC",NULL,$DatPago->PagId);
        $ArrPagoComprobantes = $ResPagoComprobante['Datos'];	
        ?>
                    <?php
        if(!empty($ArrPagoComprobantes)){
            foreach($ArrPagoComprobantes as $DatPagoComprobante){
        ?>
                    <?php //echo $DatPagoComprobante->VdiId;?>
                    <?php
     //MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false,$oPersonal=NULL) {
	$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','Desc','',$DatPagoComprobante->VdiId,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL);		 
	$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
	 ?>
                    <?php
	 if(!empty($ArrVentaDirectaDetalles)){
		 foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
?>
                    <?php echo $DatVentaDirectaDetalle->ProCodigoOriginal;?>
                    <?php
			 
		 }
	 }
	 ?>
                  <?php		
            }
        }
        
        ?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php
        $InsPagoComprobante = new ClsPagoComprobante();
        $ResPagoComprobante =  $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,"PacId","ASC",NULL,$DatPago->PagId);
        $ArrPagoComprobantes = $ResPagoComprobante['Datos'];	
        ?>
                    <?php
        if(!empty($ArrPagoComprobantes)){
            foreach($ArrPagoComprobantes as $DatPagoComprobante){
        ?>
                    <?php //echo $DatPagoComprobante->VdiId;?>
                    <?php
     //MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false,$oPersonal=NULL) {
	$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','Desc','',$DatPagoComprobante->VdiId,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL);		 
	$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
	 ?>
                    <?php
	 if(!empty($ArrVentaDirectaDetalles)){
		 foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
?>
                    <?php echo $DatVentaDirectaDetalle->ProNombre;?>
                    <?php
			 
		 }
	 }
	 ?>
                  <?php		
            }
        }
        
        ?></td>
                 
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
        
        <?php
        $InsPagoComprobante = new ClsPagoComprobante();
        $ResPagoComprobante =  $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,"PacId","ASC",NULL,$DatPago->PagId);
        $ArrPagoComprobantes = $ResPagoComprobante['Datos'];	
        ?>
        
        <?php
        if(!empty($ArrPagoComprobantes)){
            foreach($ArrPagoComprobantes as $DatPagoComprobante){
        ?>
                <?php //echo $DatPagoComprobante->VdiId;?>
                
     <?php
     //MtdObtenerVentaDirectaDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oConDespacho=NULL,$oConPendiente=false,$oPersonal=NULL) {
	$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,'VddId','Desc','',$DatPagoComprobante->VdiId,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL);		 
	$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
	 ?>
     
     <?php
	 if(!empty($ArrVentaDirectaDetalles)){
		 foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
?>
		<?php echo $DatVentaDirectaDetalle->VddCantidad;?>
<?php
			 
		 }
	 }
	 ?>


        <?php		
            }
        }
        
        ?>   
                  
                  </td>
                  
                  <?php
		}
				  ?>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->MonSimbolo;  ?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPago->PagTipoCambio;  ?></td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
                
                  <?php $MontoOriginal = (($DatPago->PagMonto/(empty($DatPago->PagTipoCambio)?1:$DatPago->PagTipoCambio)));?>
        
                   <?php echo number_format($MontoOriginal,2);?>
                  </td>
                  <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatPago->PagMonto,2);  ?></td>
                  </tr>
                <?php	
                    $TotalAbono += $DatPago->PagMonto;
                $c++;
                }
                ?>
                  <tr>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                     <?php
                    if($POST_Detalle=="Si"){
                    ?>
                     <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                    
                   
                    <td align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                     <?php
                    }
                    ?>
                    
                    <td colspan="3" align="right" class="EstTablaReporteColumnaEspecial4">TOTAL ABONOS</td>
                    <td align="right" class="EstTablaReporteColumnaEspecial4"><?php echo number_format($TotalAbono,2);?></td>
                    <?php
                    if($POST_Detalle=="Si"){
                    ?>
                    <?php
                    }
                    ?>
                  </tr>
                </tbody>
                <tfoot class="EstTablaReporteFoot">
                </tfoot>
                </table>
        <?php
        }
        ?>
         
        <?php	
		}
		?>
<?php
		}
	}
?>
    
    <?php	
}
?>       
        
<?php
/*if(!empty($ArrTecnicos)){
	foreach($ArrTecnicos as $DatTecnico){
		
		$InsFichaIngreso = new ClsFichaIngreso();
		$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinFecha","ASC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,NULL,$DatTecnico->PerId,0,NULL,NULL,1,0,NULL,NULL,0,NULL,NULL,NULL,NULL,$POST_Sucursal);
		$ArrFichaIngresos = $ResFichaIngreso['Datos'];
?>

	<?php
    if(!empty($ArrFichaIngresos )){
    ?>
	<?php //echo $DatTecnico->PerId;?>

    <h3><?php echo $DatTecnico->PerNombre;?> <?php echo $DatTecnico->PerApellidoPaterno;?> <?php echo $DatTecnico->PerApellidoMaterno;?></h3>
    <br>

	<?php
        
    ?>
    
    
    <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
            <thead class="EstTablaReporteHead">
            <tr>
              <th width="2%">#</th>
              <th width="3%">O.T.</th>
              <th width="5%">FECHA</th>
              <th width="9%">MODALIDAD</th>
              <th width="9%">CLIENTES</th>
              <th width="5%">MANT.</th>
              <th width="16%">OTROS</th>
              <th width="17%">OBSERVACIONES</th>
              <th width="8%">COMPROB</th>
              <th width="8%">FECHA COMPROB.</th>
              <th width="8%">MONEDA</th>
              <th width="10%">MONTO</th>
              </tr>
            </thead>
            <tbody class="EstTablaReporteBody">
            
            
            <?php
            $c=1;
             
            foreach($ArrFichaIngresos as $DatFichaIngreso){
                
                
                
            ?>
            
            
            <tr   >
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
              
              <?php echo $DatFichaIngreso->FinId;  ?>
              </td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFichaIngreso->FinFecha;  ?></td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
              
                 <?php
              $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
              
              //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
              $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
              $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
              ?>
                      
                      <?php
            foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
            ?>
                      -<?php echo $DatFichaIngresoModalidad->MinNombre?><br>
                      <?php
            }
            ?>
            
            </td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFichaIngreso->CliNombreCompleto;  ?></td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
              
              <?php
              if($DatFichaIngreso->FinMantenimientoKilometraje>0){
                ?>
                 <?php echo $DatFichaIngreso->FinMantenimientoKilometraje;?> km
                <?php  
              }
              ?>
              
              
              
              
              </td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >
              
              
              <?php
              $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
              
              //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
              $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
              $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
              ?>
                      
                      <?php
            foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
            ?>
                 
                 <?php
				//echo $DatFichaIngresoModalidad->FimId;
				 ?>   
    <?php
    //MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha") {
        $InsFichaAccion = new ClsFichaAccion();
        $ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','Desc',NULL,$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL,NULL,false,false,NULL,false,NULL,false,"fcc.FccFecha");
        $ArrFichaAcciones = $ResFichaAccion['Datos'];
    ?>
                <?php
                if(!empty($ArrFichaAcciones)){
                    foreach($ArrFichaAcciones as $DatFichaAccion){
                ?>
                            
							<?php //echo $DatFichaAccion->FccId;?>
                            
                            <?php
							if(!empty($DatFichaAccion->FccCausa)){
							?>
							
							Causa:
						<?php echo $DatFichaAccion->FccCausa;?>
							<?php	
							}
							?>	
                            
                            <?php
                            //MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {
                                $InsFichaAccionTarea = new ClsFichaAccionTarea();
                                $ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$DatFichaAccion->FccId,NULL) ;
                                $ArrFichaAccionTareas = $ResFichaAccionTarea['Datos'];
                                    
								//echo "abc: ".count($ArrFichaAccionTareas);
                               // deb($ArrFichaAccionTareas);
                            ?>
                            
                            <?php
                            if(!empty($ArrFichaAccionTareas)){
							?>
                            Tareas:
                            <?php
                                foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
                            ?>
                                - <?php echo $DatFichaAccionTarea->FatDescripcion?><br>
                                
                            <?php		
                                }
                            }
                            ?>
                            
                <?php		
                    }
                }
                ?>
    
                      <?php
            }
            ?>
            
            
            
            </td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" ><?php echo $DatFichaIngreso->FinTallerObservacion;?> <?php echo $DatFichaIngreso->FinSalidaObservacion;?></td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >&nbsp;</td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >&nbsp;</td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >&nbsp;</td>
              <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="left" >&nbsp;</td>
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
              </tr>
              </tbody>
            <tfoot class="EstTablaReporteFoot">
            </tfoot>
            </table>
            
    <?php
       
    }
    ?>

        
<?php	
	}
}*/
?>

  <?php
/*            foreach($ArrModalidadIngresos as $DatModalidadIngreso){
//				if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI"){
					if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3"  or $DatModalidadIngreso->MinSigla == "AD"){
				?>
					<?php echo strtoupper($DatModalidadIngreso->MinSigla)?>      
					
					
		  <?php	
					}
            }*/
			?>      

<p class="EstTablaReporteNota">
Del
<?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> al <?php echo $POST_FechaFin; ?>
      <?php  
  }
?>
</p>

</body>
</html>