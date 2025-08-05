<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGeneralMotorReporteCOS.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsSucursal = new ClsSucursal();

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE GENERAL MOTOR - COS</span></td>
  <td width="2%"><a href="formularios/GeneralMotor/inf/InfGeneralMotorReporteCOS.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
<!--    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>GeneralMotor/IfrGeneralMotorReporteCOS.php" target="IfrGeneralMotorReporteCOS" method="post" name="FrmGeneralMotorReporteCOS" id="FrmGeneralMotorReporteCOS">-->
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro:</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Marca:</td>
                <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
				
				?>
                  <option <?php echo (($DatVehiculoMarca->VmaId=="VMA-10017")?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select></td>
                <td>Sucursal:</td>
                <td><select  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                </tr>
              </table>
          </fieldset>
          
              </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Mes:</td>
                <td><?php
			switch(date("m")){
				case "01":
					$OptMes1 =  'selected="selected"';
				break;
				case "02":
					$OptMes2 =  'selected="selected"';
				break;
				case "03":
					$OptMes3 =  'selected="selected"';
				break;
				case "04":
					$OptMes4 =  'selected="selected"';
				break;
				case "05":
					$OptMes5 =  'selected="selected"';
				break;
				case "06":
					$OptMes6 =  'selected="selected"';
				break;
				case "07":
					$OptMes7 =  'selected="selected"';
				break;				
				case "08":
					$OptMes8 =  'selected="selected"';
				break;
				case "09":
					$OptMes9 =  'selected="selected"';
				break;
				case "10":
					$OptMes10 =  'selected="selected"';
				break;
				case "11":
					$OptMes11 =  'selected="selected"';
				break;	
				case "12":
					$OptMes12 =  'selected="selected"';
				break;	
				default:
					$OptMes1 =  'selected="selected"';
				break;																																					
			}
			?>
                  <select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
                    <option <?php echo $OptMes1;?> value="01">Enero</option>
                    <option <?php echo $OptMes2;?> value="02">Febrero</option>
                    <option <?php echo $OptMes3;?> value="03">Marzo</option>
                    <option <?php echo $OptMes4;?> value="04">Abril</option>
                    <option <?php echo $OptMes5;?> value="05">Mayo</option>
                    <option <?php echo $OptMes6;?> value="06">Junio</option>
                    <option <?php echo $OptMes7;?> value="07">Julio</option>
                    <option <?php echo $OptMes8;?> value="08">Agosto</option>
                    <option <?php echo $OptMes9;?> value="09">Setiembre</option>
                    <option <?php echo $OptMes10;?> value="10">Octubre</option>
                    <option <?php echo $OptMes11;?> value="11">Noviembre</option>
                    <option <?php echo $OptMes12;?> value="12">Diciembre</option>
                  </select></td>
                <td>Año:</td>
                <td>
                <select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                
                <?php

				for($i=2013;$i<=date("Y");$i++){
				?>
                <option <?php echo ($i==date("Y"))?'selected="selected"':'';?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                <?php	
				}
				?>
                </select>
                </td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver"  onclick="FncGeneralMotorReporteCOSVer();" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncGeneralMotorReporteCOSImprimir();" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncGeneralMotorReporteCOSGenerarExcel();" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
     <!-- </form> -->   </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
<!--  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>GeneralMotor/IfrGeneralMotorReporteCOS.php" target="IfrGeneralMotorReporteCOS" id="IfrGeneralMotorReporteCOS" name="IfrGeneralMotorReporteCOS" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
    <div id="CapGeneralMotorReporteCOS"></div>
  
  </td>
</tr>
</table>
</div>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

