<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteFichaIngresoModalidadAnual.js"></script>

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsModalidadIngreso = new ClsModalidadIngreso();

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];


?>





<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE CUADRO DE ORDENES DE TRABAJO X MODALIDAD X AÑO</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteFichaIngresoModalidadAnual.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoModalidadAnual.php" target="IfrReporteFichaIngresoModalidadAnual" method="post" name="FrmReporteFichaIngresoModalidadAnual" id="FrmReporteFichaIngresoModalidadAnual">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Marca:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
				
				?>
                  <option value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select></td>
                <td>Modalidad</td>
                <td><select class="EstFormularioCombo" name="CmpModalidadIngreso" id="CmpModalidadIngreso">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrModalidadIngresos as $DatModalidad){
				
				?>
                  <option value="<?php echo $DatModalidad->MinId;?>"><?php echo $DatModalidad->MinNombre;?></option>
                  <?php	
				}
				?>
                </select></td>
                </tr>
              <tr>
                <td colspan="4"><input name="ChkIgnorarPrimerMantenimiento" type="checkbox" id="ChkIgnorarPrimerMantenimiento" value="1" checked="checked" />
                  Ignorar 1er Mantenimiento
                    <input name="ChkIgnorarReparacionesSinCosto" type="checkbox" id="ChkIgnorarReparacionesSinCosto" value="1" checked="checked" />
                    <label for="ChkIgnorarPrimerMantenimiento">Ignorar Fichas sin Comprobante</label></td>
                </tr>
              </table>
          </fieldset>
          
              </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
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
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteFichaIngresoModalidadAnualImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteFichaIngresoModalidadAnualGenerarExcel('');" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
      </form>    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoModalidadAnual.php" target="IfrReporteFichaIngresoModalidadAnual" id="IfrReporteFichaIngresoModalidadAnual" name="IfrReporteFichaIngresoModalidadAnual" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

