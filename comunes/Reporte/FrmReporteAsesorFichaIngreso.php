<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteAsesorFichaIngreso.js"></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>

<p>&nbsp;</p>
<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE RESUMEN DE ORDEN DE TRABAJO X ASESOR</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteAsesorFichaIngreso.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteAsesorFichaIngreso.php" target="IfrReporteAsesorFichaIngreso" method="post" name="FrmReporteAsesorFichaIngreso" id="FrmReporteAsesorFichaIngreso">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
              <tr>
                <td class="EstFormulario">Año:</td>
                <td class="EstFormulario"><select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                  <?php
				for($i=2013;$i<=date("Y");$i++){
				?>
                  <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php	
				}
				?>
                  </select></td>
              </tr>  
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                      <option value="PerNombre" selected="selected">Asesor</option>
                     
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC" selected="selected">Ascendente</option>
                      <option value="DESC" >Descendente</option>
                      </select>                    </td>
                  </tr>
                </table>
            </fieldset></td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteAsesorFichaIngresoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteAsesorFichaIngresoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteAsesorFichaIngreso.php" target="IfrReporteAsesorFichaIngreso" id="IfrReporteAsesorFichaIngreso" name="IfrReporteAsesorFichaIngreso" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

