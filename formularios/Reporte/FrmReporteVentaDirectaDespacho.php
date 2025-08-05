<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteVentaDirectaDespacho.js"></script>

<?php
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE DESPACHO/ORDEN DE VENTA</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteVentaDirectaDespacho.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteVentaDirectaDespacho.php" target="IfrReporteVentaDirectaDespacho" method="post" name="FrmReporteVentaDirectaDespacho" id="FrmReporteVentaDirectaDespacho">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"><fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td><span title="Numero de Documento">Num. Doc.</span>:</td>
    <td>
      
      <table>
        <tr>
          <td>
            <a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          <td>
            <input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" size="20" maxlength="50" />
            </td>
          
          <td>
            <a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          </tr>
        </table>
      
    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Cliente:
      <input type="hidden" name="CmpClienteId" id="CmpClienteId" /></td>
    <td><input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255"  /></td>
    <td>&nbsp;</td>
  </tr>
  </table>
            </fieldset>                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">  
              <tr>
                <td>Fecha : </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
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
                      <option value="VdiId">Ord. Venta</option>
                      <option value="VdiFecha" >Ord. Venta Fecha</option>
                      <option value="VdiOrdenCompraNumero" selected="selected" >Ref.</option>
                      <option value="VdiOrdenCompraFecha" >Ref. Fecha</option>
                      <option value="CliNombre"  >Cliente</option>
                      
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>
                    
                    <input type="hidden" name="CmpSeleccionados" id="CmpSeleccionados"  value="">
                    
                    
                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC">Ascendente</option>
                      <option value="DESC" selected="selected">Descendente</option>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteVentaDirectaDespachoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteVentaDirectaDespachoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="" target="IfrReporteVentaDirectaDespacho" id="IfrReporteVentaDirectaDespacho" name="IfrReporteVentaDirectaDespacho" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
</tr>
</table>
</div>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
//	Calendar.setup({ 
//	inputField : "CmpFechaFin",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaFin"// el id del bot&oacute;n que  
//	}); 
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

