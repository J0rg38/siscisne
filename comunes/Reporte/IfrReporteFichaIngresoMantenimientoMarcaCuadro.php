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

require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_MODELO_ANUAL_".date('d-m-Y').".xls\";");
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

//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_Ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");


$POST_VehiculoMarca = isset($_POST['CmpVehiculoMarca'])?$_POST['CmpVehiculoMarca']:"";
$POST_VehiculoModelo = isset($_POST['CmpVehiculoModelo'])?$_POST['CmpVehiculoModelo']:"";

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

if(empty($POST_VehiculoMarca)){
	die("Escoja una marca");
}

//if(empty($POST_VehiculoModelo)){
//	die("Escoja un moelo");
//}

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();

$InsFichaIngreso = new ClsFichaIngreso();
$InsClienteTipo = new ClsClienteTipo();

$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();
//$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
//$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

//$InsVehiculoModelo->VmoId = $POST_VehiculoModelo;
//$InsVehiculoModelo->MtdObtenerVehiculoModelo();


//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsVehiculoModelo->VmoId) ;
//$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
//$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

//MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$POST_VehiculoMarca,1,NULL);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];



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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE CUADRO DE ORDENES DE TRABAJO X MARCA X AÑO (MANTENIMIENTOS) DEL
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


 
			
			
	

	

        
	<?php
	switch($InsVehiculoMarca->VmaId){
		//case "VMA-10017"://CHEVROLET
		default://CHEVROLET
	?>
<table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
            <thead class="EstTablaReporteHead">
        <tr>
          <th colspan="57">MARCA: <?php echo $InsVehiculoMarca->VmaNombre;?></th>
          </tr>
        <tr>
          <th width="14%">MODELOS</th>
			<?php
			foreach( $InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
			?>
<th><?php echo $DatKilometroEtiqueta?> KM </th>
<?php
}
?>			
<th> ANUAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
			<?php
			$TotalModeloAnualKilometraje = array();
			
            foreach($ArrVehiculoModelos as $DatModelo){
            ?>
            
                <tr>
                  <td align="right" valign="middle"   ><?php echo $DatModelo->VmoNombre;?></td>
                    <?php
					
					$TotalModeloAnual[$DatModelo->VmoId] = 0;
					
                    foreach( $InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                    <td align="right" >
<?php
//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL)

$TotalFichaIngresoMantenimientoMarca = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL,0,$POST_VehiculoMarca,$DatModelo->VmoId,$DatKilometro['km']);//CmpClienteTipo
?>

<?php echo ($TotalFichaIngresoMantenimientoMarca);?>
                    </td>
                    <?php

$TotalModeloAnual[$DatModelo->VmoId] += $TotalFichaIngresoMantenimientoMarca;

						//$TotalModeloAnualKilometraje[$DatKilometro] +=  $TotalFichaIngresoMantenimientoMarca;

                    }
                    ?>
                    <td align="right" class="Total">
                    
                   
                    <?php echo ( $TotalModeloAnual[$DatModelo->VmoId]);?>
                    
                  </td>          
                </tr>
                
            <?php	
            }
            ?>      
            
        
		<tr   >
			<td  align="right" valign="middle"   >&nbsp;</td>
            
			<?php
			foreach( $InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
			?>
			<td align="center" class="Total"> <?php //echo ( $TotalModeloAnualKilometraje[$DatKilometro]);?></td>
			<?php
			}
			?>
            
            
			<td align="center" class="Total">&nbsp;</td>          
		</tr>
          

    

  </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
    <?php
		break;
		
		case "VMA-10018"://ISUZU
	?>
	<table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th colspan="57">MARCA: <?php echo $InsVehiculoMarca->VmaNombre;?></th>
          </tr>
        <tr>
          <th width="14%">MODELOS</th>
			<?php
			foreach( $InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
			?>
<th><?php echo $DatKilometroEtiqueta?> KM </th>
<?php
}
?>			
<th> ANUAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
           
   
			<?php
            foreach($ArrVehiculoModelos as $DatModelo){
            ?> 
                <tr>
                	<td align="right" valign="middle"   ><?php echo $DatModelo->VmoNombre;?>
                    (<?php echo $DatModelo->VmoNombreComercial;?>)
                    </td>
                    
					<?php
					$TotalModeloAnual[$DatModelo->VmoId] = 0;
					
                    foreach( $InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                    <td align="right" >
                    
						<?php
                        $TotalFichaIngresoMantenimientoMarca = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,$POST_Ano,NULL,NULL,NULL,'fin.FinId','Desc',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL,0,$POST_VehiculoMarca,$DatModelo->VmoId,$DatKilometro['km']);//CmpClienteTipo
                        
                        ?>
                        
                        <?php //deb($DatKilometro['km']);?>
                        <?php echo ($TotalFichaIngresoMantenimientoMarca);?>

					</td>
                    <?php
					$TotalModeloAnual[$DatModelo->VmoId] += $TotalFichaIngresoMantenimientoMarca;

                    }
                    ?>
               	  <td align="right" class="Total"><?php echo ( $TotalModeloAnual[$DatModelo->VmoId]);?></td>          
                </tr>
            <?php
            }
            ?>  
        
        
      <!--  <tr   >
        <td  align="right" valign="middle" class="Total"   >TOTAL </td>
         <?php
		 
			foreach( $InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
			?>
        <td align="center" class="Total">1000</td>
			<?php
			}
			?>
        <td align="center" class="Total">&nbsp;</td>    
        </tr>-->
    

          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
    <?php	
		break;
		
		case "":
	?>
		
	<?php	
		break;
		
	}
	?>
   
 

		
 
		<?php	
		//}
		?>


</body>
</html>