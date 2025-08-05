<?php
//if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php //$PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<!--
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPlanMantenimientoFunciones.js" ></script>-->

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPlanMantenimiento.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
//include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPlanMantenimiento.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

//$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
//ACCIONES
//include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPlanMantenimientoEditar.php');
//DATOS
//MtdObtenerPlanMantenimientoSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmsId',$oSentido = 'Desc',$oPaginacion = '0,10')
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
//ALERTAS

$InsPlanMantenimiento->PmaId = $GET_id;
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >


</script>

<div class="EstCapMenu">
        
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER PLAN DE MANTENIMIENTO</span></td>
      </tr>
      <tr>
        <td>
        
<ul class="tabs">
    <li><a href="#tab1">Plan de Mantenimiento</a></li>
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top">
             <div class="EstFormularioArea" >
             <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          <tr>
            <td width="4">&nbsp;</td>
            <td colspan="6">
              <span class="EstFormularioSubTitulo">
                Datos del Ingreso	de	Vehiculo	
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              </span></td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="75">&nbsp;</td>
            <td width="172">&nbsp;</td>
            <td width="79">&nbsp;</td>
            <td width="211">&nbsp;</td>
            <td width="75">&nbsp;</td>
            <td width="277">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Marca:              </td>
            <td align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?></td>
            <td align="left">Modelo:              </td>
            <td align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
            <td align="left" valign="top">Version:              </td>
            <td align="left"><?php echo $InsPlanMantenimiento->VveNombre;?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          
          
          <?php
			switch($InsPlanMantenimiento->VmaId){
			  
				//case "VMA-10017"://CHEVROLET
				default://CHEVROLET
?>

          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            
            
            
            
		<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
           
            <td width="30" align="center" ><?php echo $DatKilometroEtiqueta;?> </td>
           
            <?php	
            }
            ?><td align="center" >&nbsp;</td>
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

?>
	<tr>
		<td colspan="<?php echo count($InsPlanMantenimiento->PmaChevroletKilometrajes)+1;?>" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
	</tr>                
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

		$PlanMantenimientoDetalleId = '';
		$PlanMantenimientoDetalleAccion = '';
?>


	<?php
    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		
//        if($Kilometraje==$DatKilometro){
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
			//deb($InsPlanMantenimiento->PmaId." - ".$DatKilometro." - ".$DatPlanMantenimientoTarea->PmtId);
			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
//			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro,NULL,$DatPlanMantenimientoTarea->PmtId);	
//        }
    }
	
//deb($PlanMantenimientoDetalleAccion);
    ?>
                
	<?php
	if(!empty( $PlanMantenimientoDetalleAccion)){
	?>
	<tr>
		<td align="left" valign="top" class="EstPlanMantenimientoTarea">
			<?php echo $DatPlanMantenimientoTarea->PmtNombre;?> <span style="color:#CCC;">[<?php echo $DatPlanMantenimientoTarea->PmtId;?>]</span>
		
        </td>

			
			
			
			
			
			
			<?php
			
			$Kilometrajes = "";
			
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
				
				
            ?>
            
<?php
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
			
			$PlanMantenimientoDetalleId = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleId($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
			
			
			
			

?>
				<td align="left" valign="top"   >
                


<?php
$InsTareaProducto = new ClsTareaProducto();
$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoTarea->PmtId);
$ArrTareaProductos = $ResTareaProducto['Datos'];
?>


<?php
$TprId = "";

foreach($ArrTareaProductos as $DatTareaProducto){
?>	
	<span style="font-size:6px;"><?php echo $TprId =  $DatTareaProducto->TprId;?></span><br />
	<span style="font-size:8px; color:#F00;"><?php echo $DatTareaProducto->ProCodigoOriginal;?></span><br />
    <span style="font-size:8px;"><?php echo $DatTareaProducto->ProNombre;?></span><br />
    <span style="font-size:8px; color:#03F;"><?php echo $DatTareaProducto->TprCantidad;?></span><br />
    <span style="font-size:8px; color:#0C3;"><?php echo $DatTareaProducto->UmeNombre;?></span><br />
    
    
<?php
}
?>  



<?php
if($PlanMantenimientoDetalleAccion=="C"){
	//$Kilometrajes.=$DatKilometro['eq']."-";	
}
?>
<a id="<?php echo $DatPlanMantenimientoTarea->PmtId?>-<?php echo $DatKilometro['eq']?>" target="_blank" href="corregir.php?TprId=<?php echo $TprId;?>&PmaId=<?php echo $InsPlanMantenimiento->PmaId;?>&PmtId=<?php echo $DatPlanMantenimientoTarea->PmtId;?>&Kilometraje=<?php echo $DatKilometro['eq'];?>&Kilometrajes=<?php echo $Kilometrajes;?>">
<?php echo (($PlanMantenimientoDetalleAccion=="X")?'':$PlanMantenimientoDetalleAccion);?>
</a>
				</td>
			<?php	
			}
			?>
            
            
            
            

	<td align="right"   >

    
    </td>
</tr>
	<?php
	}
	?>
    
    
    
		<?php			
		}
		?>
               
<?php
}
?>  

              
            </table></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="right"><b>I</b>: Inspección/ajuste 
              <b>C</b>: Cambio o reemplazo 
              <b>R</b>: Realizar </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left">
            
            <p>
            <b>Nota a.</b> El plan de mantenimiento presentado corresponde a condiciones normales. En condiciones severas
			(trocha, taxi, arrastre de remolque, frenado continuo, etc) la pauta difiere y tiene más puntos de inspección 
            </p>
            <p>
			<b>Nota b.</b> Las pautas pueden estar sujetas a cambios por innovaciones o variaciones técnicas 
            </p>
            </td>
            <td>&nbsp;</td>
          </tr>


<?php
				break;
			  
				case "VMA-10018"://ISUZU
?>

          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            
            
            
            
		<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
           
            <td width="30" align="center" ><?php echo $DatKilometroEtiqueta;?> </td>
           
            <?php	
            }
            ?><td align="center" >&nbsp;</td>
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

?>
	<tr>
		<td colspan="<?php echo count($InsPlanMantenimiento->PmaChevroletKilometrajes)+1;?>" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
	</tr>                
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

		$PlanMantenimientoDetalleId = '';
		$PlanMantenimientoDetalleAccion = '';
?>


	<?php
    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		
//        if($Kilometraje==$DatKilometro){
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
			//deb($InsPlanMantenimiento->PmaId." - ".$DatKilometro." - ".$DatPlanMantenimientoTarea->PmtId);
			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,NULL,$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
//			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro,NULL,$DatPlanMantenimientoTarea->PmtId);	
//        }
    }
	
//deb($PlanMantenimientoDetalleAccion);
    ?>
                
	<?php
	if(!empty( $PlanMantenimientoDetalleAccion)){
	?>
	<tr>
		<td class="EstPlanMantenimientoTarea">
			<?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
		</td>

			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
            
<?php
			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	

?>
				<td align="right"   >
                
				<?php echo (($PlanMantenimientoDetalleAccion=="X")?'':$PlanMantenimientoDetalleAccion);?>
				</td>
			<?php	
			}
			?>

	<td align="right"   >

    
    </td>
</tr>
	<?php
	}
	?>
		<?php			
		}
		?>
               
<?php
}
?>  

              
            </table></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="right"><b>R:</b> Reemplazar <b>I:</b> Inspeccionar , limpiar o reparar según sea necesario <b>A:</b> Ajustar <b>T:</b> Apretar al par de apriete especificado <b>L:</b> Lubricar </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left">

<p>
CONDICIONES TECNICAS
</p>

<p>
*ESTE PLAN DE MANTENIMIENTO ESTA DESARROLLADO EN CONDICIONES DE MANEJO NORMAL, Y CALIDAD DE COMBUSTIBLE - DIESEL NACIONAL.  
SI EL VEHICULO ES SOMETIDO A  CONDICIONES SEVERAS DE MANEJO, SIRVASE REALIZAR UN MANTENIMIENTO MAS FRECUENTE.   
CONDICIONES CONSIDERADAS ESPECIALES.
</p>
<p>
** PUNTOS DE ENGRASE :  04 JUEGO DE PINES Y BOCINAS, 02 CRUCETAS DE CARDAN Y 01 YUGO DESLIZANTE DE CARDAN.
</p>

<p>
1.-   Conducción en areas con mucho polvo<br />
2.-  Conducción repetida en distancias cortas<br />
3.-   Arrastre de un semirremolque<br />
4.-  Marcha mínima (ralentí) del motor excesiva<br />
5.-   Conducción en zonas muy húmedas o montañosas.<br />

6.-  Conducción en zonas donde se utilizan sal u otras sustancias corrosivas. <br />
7.-   Conducción frecuente en el agua. <br />
8.-   Conducción en carreteras irregulares y/o con barro o en el desierto <br />
9.-     Conducción con uso frecuente del freno o en zonas montañosas <br />
"10.-  Conducción en condiciones climáticas sumamente adversas o en zonas con temperaturas extremas
ambientales o extremadamente bajas o altas. "<br />
</p>


<p>
NOTAS TECNICAS:<br />
1.- El aceite de motor se reemplazara cada 5,000Km<br />
2.- El filtro de combustible y filtro sedimentador, se reemplazara cada 10,000Km<br />
3.- El filtro de aire se reemplazara cada 20,000Km (antes: previa inspeccion tecnica) <br />
4.- El refrigerante del motor se reemplazara cada 40,000Km ó 1 año.<br />
</p>


            </td>
            <td>&nbsp;</td>
          </tr>


<?php		  
				break;
				
				case "":
?>
No se encontro la MARCA DEL VEHICULO
          
<?php
				break;
		  }
		  ?>
          
          
        </table>
        
        </div>
        </td>
           </tr>
		   
		   
		   </table>
		   

        
        
        
   	

           </div>
	   
		

</div>      
               
             
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
    
    
</div>


	

	
    


<?php
//}else{
//echo ERR_GEN_101;
//}
?>
