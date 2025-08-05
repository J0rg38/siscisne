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

require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');
require_once($InsProyecto->MtdRutLibrerias().'phplot-6.2.0/phplot.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ENCUESTA_VENTA_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_Sucursal = ($_GET['Sucursal']);

//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaRespuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaSeccion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsEncuesta = new ClsEncuesta();
$InsSucursal = new ClsSucursal();

//deb($InsEncuesta->EncTipo);
$InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
$ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3,"VENTA");
$ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];

?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ENCUESTAS DE  VENTA  DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
}
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">

    <img src="../../imagenes/logos/logo_reporte.png" width="243" height="59" />

  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ENCUESTAS DE  VENTA  DEL
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
$ArrPromotores = array(9,10);
$ArrNeutros = array(7,8);
$ArrDetractores = array(0,1,2,3,4,5,6);

$Promotores = 0;
$Neutros = 0;
$Detractores = 0;
$TotalNPS = 0;


$ArrTTInsatisfecho = array(0,1,2);
$ArrPocoSatisfecho = array(3,4);
$ArrAlgoSatisfecho = array(5,6);
$ArrMuySatisfecho = array(7,8);
$ArrTotalSatisfecho = array(9,10);

$TTInsatisfecho = 0;
$PocoSatisfecho = 0;
$AlgoSatisfecho = 0;
$MuySatisfecho = 0;
$TotalSatisfecho = 0;


?>

<?php
if(!empty($ArrEncuestaPreguntaSecciones)){
	foreach($ArrEncuestaPreguntaSecciones as $DatEncuestaPreguntaSeccion){
		
?>

	<?php	
	$InsEncuestaPregunta = new ClsEncuestaPregunta();
	//MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL,$oSeccion=NULL)
	$ResEncuestaPregunta = $InsEncuestaPregunta->MtdObtenerEncuestaPreguntas(NULL,NULL,NULL,'EprOrden','ASC',NULL,3,0,0,$DatEncuestaPreguntaSeccion->EpsId);
	$ArrEncuestaPreguntas = $ResEncuestaPregunta['Datos'];
    ?>
		<h2><?php echo $DatEncuestaPreguntaSeccion->EpsNombre;?></h2>
        
          
    		<?php
			if(!empty($ArrEncuestaPreguntas )){
				foreach($ArrEncuestaPreguntas  as $DatEncuestaPregunta){
					
					$TotalSi = 0;
					$TotalNo = 0;
					
			?>
            
       <!--   (  <?php echo $DatEncuestaPregunta->EprTipo;?>)-->
               <?php		
							$InsEncuestaPreguntaRespuesta = new ClsEncuestaPreguntaRespuesta();
							//  MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL) 
							$ResEncuestaPreguntaRespuesta = $InsEncuestaPreguntaRespuesta->MtdObtenerEncuestaPreguntaRespuestas(NULL,NULL,NULL,'EpeId','ASC',NULL,3,$DatEncuestaPregunta->EprId);
							$ArrEncuestaPreguntaRespuestas = $ResEncuestaPreguntaRespuesta['Datos'];
							
							//$Colspan = (empty(count($ArrEncuestaPreguntaRespuestas))?1:count($ArrEncuestaPreguntaRespuestas));
							
							
							//$Colspan = (empty(count($ArrEncuestaPreguntaRespuestas))?1:count($ArrEncuestaPreguntaRespuestas));
							$Colspan = count($ArrEncuestaPreguntaRespuestas);
							
							
							
			?>
            
            
            	<?php
				if($DatEncuestaPregunta->EprTipo=="1" || $DatEncuestaPregunta->EprTipo=="3"){
				?>

            		<h3><?php echo $DatEncuestaPregunta->EprNombre?></h3>
            
            	<?php
				}
				?>
          <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="281" align="center">Pregunta</th>
          
          
           <?php
			if(!empty($ArrEncuestaPreguntaRespuestas)){
				foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
			?>
          		<?php
				if($DatEncuestaPregunta->EprTipo=="1" || $DatEncuestaPregunta->EprTipo=="3"){
				?>

            		<th width="80" align="center" valign="middle"><?php echo $DatEncuestaPreguntaRespuesta->EpeNombre?></th>
            
            	<?php
				}
				?>
                
              <?php	
				}
			}
			?>
       
          
          
          <th width="97" align="center">Total</th>
          </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          
          <?php
		  $TotalFilaPregunta = 0;
		  ?>
          <tr>
            <td align="left"><?php  echo $DatEncuestaPregunta->EprNombre;?></td>
            
            <?php
			if(!empty($ArrEncuestaPreguntaRespuestas)){
				foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
			?>
				
				
				<?php
				if($DatEncuestaPregunta->EprTipo=="1" || $DatEncuestaPregunta->EprTipo=="3"){
				?>

           		 <td width="80" align="center">
                                               
                                               
                            <?php

                            
                            //MtdObtenerEncuestaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL,$oSucursal=NULL) 
                            $InsEncuestaDetalle = new ClsEncuestaDetalle();
                            //MtdObtenerEncuestaDetallesValor($oFuncion="SUM",$oParametro="EprId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL,$oEncuestaRespuesta=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL)
                            $EncuestaDetalleValor = $InsEncuestaDetalle->MtdObtenerEncuestaDetallesValor("COUNT","EprId",NULL,NULL,NULL,NULL,NULL,'EdeId','Desc','1',3,NULL,$DatEncuestaPregunta->EprId,$DatEncuestaPreguntaRespuesta->EpeValor,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Sucursal);
                            
                            
                            ?>
                  					 <?php echo $EncuestaDetalleValor;?>
                            <?php
                             $TotalFilaPregunta += (empty($EncuestaDetalleValor)?0:$EncuestaDetalleValor);
                            ?>
                            
                            <?php
							if($DatEncuestaPregunta->EprSubTipo == 1){
							?>
                            
								 <?php
                                
                                if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrPromotores)){
                                    $Promotores = $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrNeutros)){
                                    $Neutros = $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrDetractores)){
                                    $Detractores = $EncuestaDetalleValor ;
                                }
                                
                                ?>
                                
                            <?php
							}
							?>
                           
                           
                           <?php
							if($DatEncuestaPregunta->EprSubTipo == 1){
							?>
                            
								<?php
                                
                                if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrTTInsatisfecho)){
                                    $TTInsatisfecho += $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrPocoSatisfecho)){
                                    $PocoSatisfecho += $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrAlgoSatisfecho)){
                                    $AlgoSatisfecho += $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrMuySatisfecho)){
                                    $MuySatisfecho += $EncuestaDetalleValor ;
                                }else if(in_array($DatEncuestaPreguntaRespuesta->EpeValor,$ArrTotalSatisfecho)){
                                    $TotalSatisfecho += $EncuestaDetalleValor ;
                                }   
								                             
                                ?>
                                
                            <?php
							}
							?>
                            
                             <?php
							if($DatEncuestaPregunta->EprSubTipo == 2 || $DatEncuestaPregunta->EprSubTipo == 3 || $DatEncuestaPregunta->EprSubTipo == 4){
							?>
                            
								 <?php
                                if(($DatEncuestaPreguntaRespuesta->EpeValor== "Si")){
									
                                    $TotalSi += $EncuestaDetalleValor ;
									
                                }else if(($DatEncuestaPreguntaRespuesta->EpeValor == "No")){
									
                                    $TotalNo += $EncuestaDetalleValor ;
                               
                                }else{
									
                                }                            
                                ?>
                                
                            <?php
							}
							?>
                            
                          
                        


                 </td>
            
           	 <?php
				}
				?>
                
            <?php	
				}
			}
			?>
            
            <td align="center"><?php echo $TotalFilaPregunta;?></td>
          </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
          <br>
        
<?php
if(        $DatEncuestaPregunta->EprSubTipo == 2 || $DatEncuestaPregunta->EprSubTipo == 3 || $DatEncuestaPregunta->EprSubTipo == 4){
?>

CUADROS RESULTADOS:
<br>

<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">Si</th>
          <th width="157" align="center" valign="middle">100</th>
            		<th width="137" align="center">No</th>
            		<th width="116" align="center">0</th>
            		<th width="116" align="center">Total</th>
            		<th width="116" align="center">Total</th>
            		<th width="116" align="center">Promedio</th>
   		  </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center"><?php echo $TotalSi;?></td>
            <td width="157" align="center">
			
			
			<?php
			$Total100 = 100 * $TotalSi;
			//$Total1 = $Total1 * 100;
			//$Total1 = round($Total1,2);
			
			?>
            <?php echo $Total100;?>
            
            </td>
           		 <td align="center"><?php echo $TotalNo;?></td>
           		 <td align="center"><?php
			$Total0 = 100 * $TotalNo;
			//$Total1 = $Total1 * 100;
			//$Total1 = round($Total1,2);
			
			?>
                 <?php echo $Total0;?></td>
           		 <td align="center">
				 
				 <?php
$TotalColumnaA = $Total100 + $Total0;
?>
                   <?php
$TotalColumnaB = $TotalSi + $TotalNo;
?>
                 <?php
				 echo $TotalColumnaA;
				 ?>
                 
                 
                 
                 </td>
           		 <td align="center"><?php
				 echo $TotalColumnaB;
				 ?></td>
           		 <td align="center"><?php
				 
				 if($TotalColumnaB>0){
					 $Promedio = $TotalColumnaA / $TotalColumnaB;
				 }else{
					 
					 $Promedio = 0;
				 }
		   
		   ?>
                 <?php
				 echo $Promedio;
				 ?></td>
	      </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
    PORCENTAJES:
<br>
   <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">Si</th>
          <th width="157" align="center" valign="middle">No</th>
   		  </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center">
			<?php
			if($TotalFilaPregunta>0){
				$SiPorcentaje = ($TotalSi * 100)/$TotalFilaPregunta;
				$SiPorcentaje = round($SiPorcentaje,2);
			}else{
				$SiPorcentaje=0;
			}
			
			
		
			?>
			
			<?php echo $SiPorcentaje;?> %
            
            
            </td>
            <td width="157" align="center">
			<?php
			
			if($TotalFilaPregunta>0){
				
			$NoPorcentaje = ($TotalNo * 100)/$TotalFilaPregunta;
			$NoPorcentaje = round($NoPorcentaje,2);
			}else{
				$NoPorcentaje=0;
			}
			
			
			
			?>
			
			
			<?php echo $NoPorcentaje;?> %</td>
            
            
   		  </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        


       <?php
	   
# PHPlot Example - Horizontal Stacked Bars
//require_once 'phplot.php';
$dir = "../../generados/reportes/";
$filename = "Encuesta3".FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).$DatEncuestaPregunta->EprId.".png";

	
if(file_exists($dir.$filename)){
	unlink($dir.$filename);
}

$Direccion = trim($DatEncuestaPregunta->EprNombre);
$Direccion = str_replace("  ","",$Direccion);

$ArrPalabras = explode(" ",$Direccion);

$titulo = "";
$afila = array();
$fila = 1;

for($i=0;$i<=count($ArrPalabras);$i++){			
						
	if(strlen($afila[$fila]." ".$ArrPalabras[$i])<50){											
		$afila[$fila].=" ".$ArrPalabras[$i];										
	}else{										
		$fila++;
		$afila[$fila].=" ".$ArrPalabras[$i];
	}
	
}

for($j=1;$j<=$fila;$j++){
			
	$titulo .= utf8_decode($afila[$j])."\n";

}	


	
$column_names = array(
                 'Si', 'No');
//                   |       |       |       |       |       |       |
$data = array(
    array('',  $SiPorcentaje+1-1,   $NoPorcentaje+1-1)
);


$colors = array();
//$colors[] = array(145, 209, 80);
//$colors[] = array(193, 0, 0);
$colors[] = array(102, 255, 51);//VERDE
$colors[] = array(255, 0, 0);//ROJO

$plot = new PHPlot(620, 250,$dir.$filename);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetTitle($titulo."\n N = ".$TotalFilaPregunta);
$plot->SetDataColors($colors);

$plot->SetLegend($column_names);
#  Move the legend to the lower right of the plot area:
$plot->SetLegendPixels(30, 10);
$plot->SetDataValues($data);
$plot->SetFileFormat('png');
$plot->SetIsInline(true);

$plot->SetDataType('text-data-yx');
$plot->SetPlotType('stackedbars');
///$plot->SetXTitle($DatEncuestaPreguntaRespuesta->EpeNombre);
#  Show data value labels:
$plot->SetXDataLabelPos('plotstack');
#  Rotate data value labels to 90 degrees:
$plot->SetXDataLabelAngle(90);
#  Format the data value labels with 1 decimal place:
$plot->SetXDataLabelType('data', 1);
#  Specify a whole number for the X tick interval:
$plot->SetXTickIncrement(20);
#  Disable the Y tick marks:
$plot->SetYTickPos('none');
//
$plot->DrawGraph();

?> 

     <img src="generados/reportes/<?php echo $filename;?>">   
   
   

        
         <br>
          <br>

<?php	
}
?>
      
        
       
          
            <?php		
				}
			}
			?>
         
      
        
        
      <!--  <hr>--><br><br>
<?php	
	}
}
?>

<hr>


CUADROS RESULTADOS GENERAL:
<hr>

      
<?php
$TotalEncuestados = $Promotores + $Neutros + $Detractores;
?>
      <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">Promotores</th>
          
          
            		<th width="157" align="center" valign="middle">Neutros</th>
            		<th width="137" align="center">Detractores</th>
            
       
       
          
          
          <th width="116" align="center">Total</th>
          </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center"><?php echo $Promotores;?></td>
            
           
			

           		 <td width="157" align="center"><?php echo $Neutros;?></td>
           		 <td align="center"><?php echo $Detractores;?></td>
            
          
            
            <td align="center">
            <?php echo $TotalEncuestados;?>
            </td>
          </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        <br>
        
        
<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">Promotores</th>
          
          
            		<th width="157" align="center" valign="middle">Neutros</th>
            		<th width="137" align="center">Detractores</th>
            
       
       
          
          
          <th width="116" align="center">Total NPS</th>
          </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center">
			
			
			<?php 
			
			
			if($TotalEncuestados>0){
				
			
				 $PromotoresPorcentaje = (($Promotores*100)/$TotalEncuestados);
				 $PromotoresPorcentaje = round($PromotoresPorcentaje,2);
				 
			}else{
				$PromotoresPorcentaje = 0;
			}
			
			
			
			
			
			 
			echo $PromotoresPorcentaje;
			?>
            
            
            
            %</td>
            
           
			

           		 <td width="157" align="center">
				 
				 
				 	
			<?php 
			
			if($TotalEncuestados>0){
				
				 $NeutrosPorcentaje = (($Neutros*100)/$TotalEncuestados);
				 $NeutrosPorcentaje = round($NeutrosPorcentaje,2);
			 
			 
			}else{
				$NeutrosPorcentaje = 0;
			}
			
			echo $NeutrosPorcentaje;
			?>
				 
				%</td>
           		 <td align="center">
				 
				 	<?php 
			
			
			if($TotalEncuestados>0){
				
				
			 $DetractoresPorcentaje = (($Detractores*100)/$TotalEncuestados);
			 $DetractoresPorcentaje = round($DetractoresPorcentaje,2);
			 
			 
			}else{
				$DetractoresPorcentaje = 0;
			}
			
			
			
		
			?>
				 
				 <?php echo $DetractoresPorcentaje;?> %</td>
            
          
            
            <td align="center">
            
            <?php
			$TotalNPS = $PromotoresPorcentaje - $DetractoresPorcentaje;
			?>
            <?php echo $TotalNPS;?> %
            </td>
          </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        <br> <br>


<?php

# PHPlot Example - Horizontal Stacked Bars
//require_once 'phplot.php';
$dir = "../../generados/reportes/";
$filename = "Encuesta".FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).".png";

	
if(file_exists($dir.$filename)){
	unlink($dir.$filename);
}


$column_names = array(
                 'Promotores', 'Detractores', 'Neutros');
//                   |       |       |       |       |       |       |
$data = array(
    array('',  $PromotoresPorcentaje+1-1,   $DetractoresPorcentaje+1-1,$NeutrosPorcentaje+1-1)
);

$colors = array();
//$colors[] = array(193, 0, 0);
//$colors[] = array(255, 193, 0);
//$colors[] = array(145, 209, 80);



$colors[] = array(102, 255, 51);//VERDE
$colors[] = array(255, 0, 0);//ROJO
$colors[] = array(244, 244, 36);//AMARILLO


$plot = new PHPlot(620, 250,$dir.$filename);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetTitle("NPS ACUMULADOS ".$TotalNPS." N = ".$TotalEncuestados);
$plot->SetDataColors($colors);

$plot->SetLegend($column_names);
#  Move the legend to the lower right of the plot area:
$plot->SetLegendPixels(30, 10);
$plot->SetDataValues($data);
$plot->SetFileFormat('png');
$plot->SetIsInline(true);

$plot->SetDataType('text-data-yx');
$plot->SetPlotType('stackedbars');
///$plot->SetXTitle($DatEncuestaPreguntaRespuesta->EpeNombre);
#  Show data value labels:
$plot->SetXDataLabelPos('plotstack');
#  Rotate data value labels to 90 degrees:
$plot->SetXDataLabelAngle(90);
#  Format the data value labels with 1 decimal place:
$plot->SetXDataLabelType('data', 1);
#  Specify a whole number for the X tick interval:
$plot->SetXTickIncrement(20);
#  Disable the Y tick marks:
$plot->SetYTickPos('none');

$plot->DrawGraph();


?>

   <img src="generados/reportes/<?php echo $filename;?>">   
   
   
   
<br><br>




<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">TT Insatisfecho</th>
          <th width="50" align="center" valign="middle">1</th>
          
          
            		<th width="157" align="center" valign="middle">Poco sastisfecho</th>
            		<th width="50" align="center">25</th>
            		<th width="137" align="center">Algo satisfecho</th>
            		<th width="50" align="center">50</th>
            		<th width="116" align="center">Muy satisfecho</th>
            		<th width="50" align="center">75</th>
            		<th width="126" align="center">TotalSatisfecho</th>
            		<th width="50" align="center">100</th>
            		<th colspan="2" align="center">Total</th>
   		  <th width="116" align="center">Promedio</th>
          </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          
          <tr>
            <td align="center">
			
			<?php echo $TTInsatisfecho;?></td>
            <td width="50" align="center">
            
            <?php
			$Total1 = 1 * $TTInsatisfecho;
			//$Total1 = $Total1 * 100;
			//$Total1 = round($Total1,2);
			
			?>
            <?php echo $Total1;?>
            </td>
            
           
		
								      

           		 <td width="157" align="center"><?php echo $PocoSatisfecho;?></td>
           		 <td width="50" align="center"><?php
			$Total25 = 1 * $PocoSatisfecho;
			//$Total25 = $Total25 * 100;
			//$Total25 = round($Total25,2);
			
			
			?>
                 <?php echo $Total25;?></td>
           		 <td align="center"><?php echo $AlgoSatisfecho;?></td>
           		 <td width="50" align="center"><?php
			$Total50 = 1 * $AlgoSatisfecho;
			//$Total50 = $Total50 * 100;
			//$Total50 = round($Total50,2);
			
			?>
                 <?php echo $Total50;?></td>
           		 <td align="center"><?php echo $MuySatisfecho;?></td>
           		 <td width="50" align="center"><?php
			$Total75 = 1 * $MuySatisfecho;
			//			$Total75 = $Total75 * 100;
			//$Total75 = round($Total75,2);
			
			?>
                 <?php echo $Total75;?></td>
           		 <td align="center"><?php echo $TotalSatisfecho;?></td>
           		 <td width="50" align="center"><?php
			$Total100 = 1 * $TotalSatisfecho;
		//	$Total100 = $Total100 * 100;
			//$Total100 = round($Total100,2);
			
			
			?>
                 <?php echo $Total100;?></td>
           		 <td width="50" align="center">
                 
<?php
$TotalColumnaA = $Total1 + $Total25 + $Total50 + $Total75 + $Total100;
?>

<?php
$TotalColumnaB = $TTInsatisfecho + $PocoSatisfecho + $AlgoSatisfecho + $MuySatisfecho + $TotalSatisfecho;
?> 

<?php
				 echo $TotalColumnaA;
				 ?>
                 
                 
                 </td>
           		 <td width="50" align="center">
                 
                <?php
				 echo $TotalColumnaB;
				 ?>
                 
                 </td>
            
          
            
            <td align="center"> 
           <?php
		   if($TotalColumnaB>0){
			     $Promedio = $TotalColumnaA / $TotalColumnaB;
		   }else{
			     $Promedio = 0;
		   }
		 
		   ?>
           
              <?php
				 echo $Promedio;
				 ?>
                 
           
            </td>
          </tr>
          <tr>
            <td align="center">
			<?php
			if($TotalColumnaB>0){
				$TTInsatisfechoPorcentaje = $TTInsatisfecho / $TotalColumnaB;
				$TTInsatisfechoPorcentaje = $TTInsatisfechoPorcentaje*100;
				$TTInsatisfechoPorcentaje = round($TTInsatisfechoPorcentaje,2);
			}else{
				$TTInsatisfechoPorcentaje = 0;
			}
			
			?>
			
			<?php echo $TTInsatisfechoPorcentaje;?>
            
            
            %</td>
            <td width="50" align="center">&nbsp;</td>
            <td align="center"><?php
			
			if($TotalColumnaB>0){
				$PocoSatisfechoPorcentaje = $PocoSatisfecho / $TotalColumnaB;
				$PocoSatisfechoPorcentaje = $PocoSatisfechoPorcentaje*100;
				$PocoSatisfechoPorcentaje = round($PocoSatisfechoPorcentaje,2);
			}else{
				
				$PocoSatisfechoPorcentaje =0;
			}
			?>
            <?php echo $PocoSatisfechoPorcentaje;?> %</td>
            <td width="50" align="center">&nbsp;</td>
            <td align="center"><?php
			
			if($TotalColumnaB>0){
				
				$AlgoSatisfechoPorcentaje = $AlgoSatisfecho / $TotalColumnaB;
				$AlgoSatisfechoPorcentaje = $AlgoSatisfechoPorcentaje*100;
				$AlgoSatisfechoPorcentaje = round($AlgoSatisfechoPorcentaje,2);
					
			}else{
				$AlgoSatisfechoPorcentaje = 0;
			}
			
			?>
            <?php echo $AlgoSatisfechoPorcentaje;?> %</td>
            <td width="50" align="center">&nbsp;</td>
            <td align="center"><?php
			
			
			if($TotalColumnaB>0){
				
			
				$MuySatisfechoPorcentaje = $MuySatisfecho / $TotalColumnaB;
				$MuySatisfechoPorcentaje = $MuySatisfechoPorcentaje*100;
				$MuySatisfechoPorcentaje = round($MuySatisfechoPorcentaje,2);
						
			}else{
				$MuySatisfechoPorcentaje = 0;
			}
			
			
			?>
            <?php echo $MuySatisfechoPorcentaje;?> %</td>
            <td width="50" align="center">&nbsp;</td>
            <td align="center"><?php
			
			
			if($TotalColumnaB>0){
				
			$TotalSatisfechoPorcentaje = $TotalSatisfecho / $TotalColumnaB;
			$TotalSatisfechoPorcentaje = $TotalSatisfechoPorcentaje*100;
			$TotalSatisfechoPorcentaje = round($TotalSatisfechoPorcentaje,2);
			}else{
				$TotalSatisfechoPorcentaje = 0;
			}
			
			
			?>
            <?php echo $TotalSatisfechoPorcentaje;?> %</td>
            <td width="50" align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>



<br>
<br>


<table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="145" align="center">TT Insatisfecho</th>
          <th width="157" align="center" valign="middle">Poco sastisfecho</th>
            		<th width="137" align="center">Algo satisfecho</th>
            		<th width="116" align="center">Muy satisfecho</th>
            		<th width="116" align="center">TotalSatisfecho</th>
   		  </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          <tr>
            <td align="center"><?php echo $TTInsatisfechoPorcentaje;?> %</td>
            <td width="157" align="center"><?php echo $PocoSatisfechoPorcentaje;?> %</td>
           		 <td align="center"><?php echo $AlgoSatisfechoPorcentaje;?> %</td>
           		 <td align="center"><?php echo $MuySatisfechoPorcentaje;?> %</td>
           		 <td align="center"><?php echo $TotalSatisfechoPorcentaje;?> %</td>
	      </tr>
          
              </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        <br><br>
        
     

<?php


# PHPlot Example - Horizontal Stacked Bars
//require_once 'phplot.php';
$dir = "../../generados/reportes/";
$filename = "Encuesta2".FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).".png";

	
if(file_exists($dir.$filename)){
	unlink($dir.$filename);
}


$column_names = array(
                 'TT Insatisfecho', 'Poco Satisfecho', 'Algo Satisfecho','Muy Satisfecho','Total Satisfecho');
//                   |       |       |       |       |       |       |
$data = array(
    array('', $TTInsatisfechoPorcentaje+1-1,   $PocoSatisfechoPorcentaje+1-1,$AlgoSatisfechoPorcentaje+1-1,$MuySatisfechoPorcentaje+1-1,$TotalSatisfechoPorcentaje+1-1)
);


//$colors[] = array(102, 255, 51);//VERDE
//$colors[] = array(255, 0, 0);//ROJO
//$colors[] = array(244, 244, 36);//AMARILLO

$colors = array();
$colors[] = array(255, 0, 0);//ROJO
$colors[] = array(237, 126, 49);//NARANJA
$colors[] = array(165, 165, 165);//PLOMO
$colors[] = array(244, 244, 36);//AMARILLO
$colors[] = array(102, 255, 51);//VERDE

//$colors[] = array(193, 0, 0);
//$colors[] = array(237, 126, 48);
//$colors[] = array(165, 165, 165);
//
//$colors[] = array(255, 193, 0);
//$colors[] = array(145, 209, 80);

$plot = new PHPlot(620, 250,$dir.$filename);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetTitle("Grado Satisfaccion N = ".$TotalColumnaB);
$plot->SetDataColors($colors);

$plot->SetLegend($column_names);
#  Move the legend to the lower right of the plot area:
$plot->SetLegendPixels(30, 10);
$plot->SetDataValues($data);
$plot->SetFileFormat('png');
$plot->SetIsInline(true);

$plot->SetDataType('text-data-yx');
$plot->SetPlotType('stackedbars');
///$plot->SetXTitle($DatEncuestaPreguntaRespuesta->EpeNombre);
#  Show data value labels:
$plot->SetXDataLabelPos('plotstack');
#  Rotate data value labels to 90 degrees:
$plot->SetXDataLabelAngle(90);
#  Format the data value labels with 1 decimal place:
$plot->SetXDataLabelType('data', 1);
#  Specify a whole number for the X tick interval:
$plot->SetXTickIncrement(20);
#  Disable the Y tick marks:
$plot->SetYTickPos('none');

$plot->DrawGraph();


?>

   <img src="generados/reportes/<?php echo $filename;?>">   
   
   
   

<br><br>

    
    
    
</body>
</html>