<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteKardexValorizado.js" ></script>

<?php
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
var ProductoValidarStock = "1";
var ProductoLector = 2;
//var ProductoEnfoque = "FechaInicio";
</script>






<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE KARDEX VALORIZADO</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteKardexValorizado.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteKardexValorizado.php" target="IfrReporteKardexValorizado" method="post" name="FrmReporteKardexValorizado" id="FrmReporteKardexValorizado">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          
          
          
          <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td><a href="javascript:FncReporteKardexValorizadoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" />
      <input name="CmpProductoId" class="EstFormularioCaja" type="hidden" id="CmpProductoId" size="10" maxlength="20"  /></td>
    <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    <td><input  class="EstFormularioCaja" name="CmpProductoNombre" type="text" id="CmpProductoNombre" size="50" maxlength="255" /></td>
    <td><span id="spryselect1">
      <select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaKardex" id="CmpProductoUnidadMedidaKardex">
        </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
  </table></fieldset>
            
          
                            </td>
          
          <td align="left" valign="top">
            
            <fieldset  class="EstFormularioContenedor">
              <legend>Opciones de Fechas</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>Fecha Inicio: </td>
                  <td><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha"  id="CmpFechaInicio" value="<?php  echo "01".date("/m/Y");?>" size="10" maxlength="10"/>
                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
                  </tr>
                <tr>
                  <td>Fecha Fin:</td>
                  <td><input name="CmpFechaFin" type="text" class="EstFormularioCajaFecha"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteKardexValorizadoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteKardexValorizadoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="" target="IfrReporteKardexValorizado" id="IfrReporteKardexValorizado" name="IfrReporteKardexValorizado" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
</tr>
</table>
</div>

<script type="text/javascript">
//Calendar.setup({ 
//	inputField : "CmpFechaInicio",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
//	}); 	
//	
//	Calendar.setup({ 
//	inputField : "CmpFechaFin",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaFin"// el id del bot&oacute;n que  
//	});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

