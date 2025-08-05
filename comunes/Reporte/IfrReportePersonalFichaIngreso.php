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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"PerNombre";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"ASC";

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');


$InsPersonal = new ClsPersonal();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();


$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1);
$ArrTecnicos = $ResPersonal['Datos'];

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE RESUMEN DE ORDEN DE TRABAJO X TECNICO (MECANICO)DEL
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
        
        <table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>#</th>
          <th>TECNICO</th>

			<?php
            foreach($ArrModalidadIngresos as $DatModalidadIngreso){
//				if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI"){
					if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3"){
				?>
					<th><?php echo strtoupper($DatModalidadIngreso->MinNombre)?></th>       
					<th>FACTURADO</th>     
                   
		  <?php	
				}
            }
			?>
			
          <th>TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrTecnicos as $DatTecnico){
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
			foreach($ArrModalidadIngresos as $DatModalidadIngreso){
				
					if($DatModalidadIngreso->MinSigla == "MA" or $DatModalidadIngreso->MinSigla == "RE" or $DatModalidadIngreso->MinSigla == "RI" or $DatModalidadIngreso->MinSigla == "R1" or $DatModalidadIngreso->MinSigla == "R2" or $DatModalidadIngreso->MinSigla == "R3"){

?>

<?php
$InsFichaIngreso = new ClsFichaIngreso();
$TotalPersonalModalidadFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,NULL,NULL,NULL,NULL,'fin.FinId','Desc',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,$DatTecnico->PerId,0,NULL,NULL,NULL,0,NULL,NULL,0);

$TotalPersonalFichaIngreso += $TotalPersonalModalidadFichaIngreso;
?>
            
          
             <td  align="center" valign="top" bgcolor="#FFCC66"   >
               <?php echo number_format($TotalPersonalModalidadFichaIngreso,2);?></td>
               
               <td align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">




<?php
$Facturado = 0;
$BoletaTotal = 0;
$FacturaTotal = 0;

//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL) 
$BoletaTotal = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotal",NULL,NULL,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,"5",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);


// MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL) 
$FacturaTotal = $InsFactura->MtdObtenerFacturasValor("SUM","FacTotal",NULL,NULL,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,"5",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatModalidadIngreso->MinId,NULL,NULL,NULL,$DatTecnico->PerId);

$Facturado = $BoletaTotal + $FacturaTotal;
?>

<?php
//if($Facturado>0){
?>
<?php
echo number_format($Facturado,2);
?>

<?php	
/*}else{
?>
-
<?php	
	
}*/
?>

               </td>
            
              <?php	
}
			}
			?>
            
                <td  align="center" valign="top"   >
				
                <?php echo number_format($TotalPersonalFichaIngreso,2);?>
                  
                  </td>
               
                </tr>
      

        <?php	
		 $c++;
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
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