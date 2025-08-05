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

$POST_Ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");


$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"PerNombre";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"ASC";

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsPersonal = new ClsPersonal();
$InsFichaIngreso = new ClsFichaIngreso();

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
$ArrAsesores = $ResPersonal['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE RESUMEN DE ORDEN DE TRABAJO X ASESOR</span></td>
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
          <th>ASESOR</th>
			
            <?php
			for($mes=1;$mes<=12;$mes++){
			?>
			
					<th width="50"><?php echo FncConvertirMes($mes);?></th>       
			<?php
			}
			?>
			
          <th>TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrAsesores as $DatAsesor){
        ?>
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"     ><?php echo $c;?></td>
                <td  align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  >
                  
                  <?php echo ($DatAsesor->PerNombre);?>
  <?php echo ($DatAsesor->PerApellidoPaterno);?>
                  <?php echo ($DatAsesor->PerApellidoMaterno);?>	
                  
                </td>
       

            
          
            <?php
			$TotalAsesorAnual = 0;
			for($mes=1;$mes<=12;$mes++){
			?>
             <td width="50"  align="center" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   ><?php
$InsFichaIngreso = new ClsFichaIngreso();

//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL)
$TotalAsesorFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",$mes,$POST_Ano, NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,$DatAsesor->PerId) ;

?>
               <?php echo number_format($TotalAsesorFichaIngreso,2);?>
               
               
               </td>
               <?php
			   
			   	$TotalAsesorAnual += $TotalAsesorFichaIngreso;
			}
			   ?>
              
            
                <td  align="center" valign="top"   >
				
                <?php echo number_format($TotalAsesorAnual,2);?>
                  
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

</p>

</body>
</html>