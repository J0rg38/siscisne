<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteCotizacionVehiculoTrafico.js"></script>

<?php
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsPersonal = new ClsPersonal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE TRAFICO/COTIZACION VEHICULOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteCotizacionVehiculoTrafico.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteCotizacionVehiculoTrafico.php" target="IfrReporteCotizacionVehiculoTrafico" method="post" name="FrmReporteCotizacionVehiculoTrafico" id="FrmReporteCotizacionVehiculoTrafico">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td>Vendedor:
    </td>
    <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                      <option value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                      <?php
					}
					?>
                    </select></td>
  </tr>
  </table></fieldset>
            
          
                            </td>
          
          <td align="left" valign="top">
            
            <fieldset  class="EstFormularioContenedor">
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
                  <td>
                  


<select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
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
                            </select>
                            
                            
                  </td>
                  </tr>
                </table>
              </fieldset>   
            
            
          </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteCotizacionVehiculoTraficoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteCotizacionVehiculoTraficoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteCotizacionVehiculoTrafico.php" target="IfrReporteCotizacionVehiculoTrafico" id="IfrReporteCotizacionVehiculoTrafico" name="IfrReporteCotizacionVehiculoTrafico" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

