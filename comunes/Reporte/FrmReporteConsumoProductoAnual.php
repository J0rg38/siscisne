<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteConsumoProductoAnual.js"></script>

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');

$InsProductoTipo = new ClsProductoTipo();

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];
?>




<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE CONSUMO DE PRODUCTO ANUAL</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteConsumoProductoAnual.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteConsumoProductoAnual.php" target="IfrReporteConsumoProductoAnual" method="post" name="FrmReporteConsumoProductoAnual" id="FrmReporteConsumoProductoAnual">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td>Tipo Producto:</td>
    <td><span id="spryselect1">
      <select class="EstFormularioCombo" name="CmpProductoTipo" id="CmpProductoTipo">
        <option value="">Todos</option>
        <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
        <option <?php echo $DatProductoTipo->RtiId;?>  value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
        <?php
			}
			?>
      </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    <td></td>
  </tr>
  </table></fieldset>
            
          
                            </td>
          
          <td align="left" valign="top">
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr class="EstFormulario">
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
              </tr>
              </table>
          </fieldset>   
          
          
           </td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
					
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                    <option value="ProCodigoOriginal" selected="selected" >Cod. Original</option>
					<option value="ProNombre" >Nombre</option>
					
		
					</select>                    
                    
                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC">Ascendente</option>
                      <option value="DESC"  selected="selected" >Descendente</option>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteConsumoProductoAnualImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteConsumoProductoAnualGenerarExcel('');" />           
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
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteConsumoProductoAnual.php" target="IfrReporteConsumoProductoAnual" id="IfrReporteConsumoProductoAnual" name="IfrReporteConsumoProductoAnual" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
  <iframe class="autoHeight"  target="IfrReporteConsumoProductoAnual" id="IfrReporteConsumoProductoAnual" name="IfrReporteConsumoProductoAnual" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  
  </td>
</tr>
</table>
</div>

<script type="text/javascript">
/*Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	});*/
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

