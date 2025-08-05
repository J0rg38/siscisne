<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteVehiculoIngresoMOS.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');



$InsVehiculoMarca = new ClsVehiculoMarca();
$InsSucursal = new ClsSucursal();

// MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE MOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteVehiculoIngresoMOS.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
<!--    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteVehiculoIngresoMOS.php" target="IfrReporteVehiculoIngresoMOS" method="post" name="FrmReporteVehiculoIngresoMOS" id="FrmReporteVehiculoIngresoMOS">
     --> 
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor"><legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Marca:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
								?>
                  <option <?php echo (($DatVehiculoMarca->VmaId=="VMA-10017")?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select>
                </td>
                </tr>
            </table>
            </fieldset>
            </td>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Año:</td>
                <td><select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                  <?php
				for($i=2013;$i<=date("Y");$i++){
				?>
                  <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php	
				}
				?>
                </select></td>
                <td>Mes:</td>
                <td><select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
                  <option <?php echo ((date("m")=="01")?'selected="selected"':'');?>  value="01">Enero</option>
                  <option <?php echo ((date("m")=="02")?'selected="selected"':'');?>  value="02">Febrero</option>
                  <option <?php echo ((date("m")=="03")?'selected="selected"':'');?>  value="03">Marzo</option>
                  <option <?php echo ((date("m")=="04")?'selected="selected"':'');?>  value="04">Abril</option>
                  <option <?php echo ((date("m")=="05")?'selected="selected"':'');?>  value="05">Mayo</option>
                  <option <?php echo ((date("m")=="06")?'selected="selected"':'');?>  value="06">Junio</option>
                  <option <?php echo ((date("m")=="07")?'selected="selected"':'');?>  value="07">Julio</option>
                  <option <?php echo ((date("m")=="08")?'selected="selected"':'');?>  value="08">Agosto</option>
                  <option <?php echo ((date("m")=="09")?'selected="selected"':'');?>  value="09">Setiembre</option>
                  <option <?php echo ((date("m")=="10")?'selected="selected"':'');?>  value="10">Octubre</option>
                  <option <?php echo ((date("m")=="11")?'selected="selected"':'');?>  value="11">Noviembre</option>
                  <option <?php echo ((date("m")=="12")?'selected="selected"':'');?>  value="12">Diciembre</option>
                </select></td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncReporteVehiculoIngresoMOSVer();" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteVehiculoIngresoMOSImprimir();" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteVehiculoIngresoMOSGenerarExcel();" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
      <!--</form>-->    </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteVehiculoIngresoMOS.php" target="IfrReporteVehiculoIngresoMOS" id="IfrReporteVehiculoIngresoMOS" name="IfrReporteVehiculoIngresoMOS" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
      <div id="CapReporteVehiculoIngresoMOS"></div>
  
  
  
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

