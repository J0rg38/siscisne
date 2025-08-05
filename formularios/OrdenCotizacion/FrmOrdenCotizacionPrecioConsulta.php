<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCotizacionPrecioConsultaFunciones.js"></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
?>


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


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">CONSULTA DE PRECIOS COTIZADOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfOrdenCotizacionPrecioConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>OrdenCotizacion/IfrOrdenCotizacionPrecioConsulta.php" target="IfrOrdenCotizacionPrecioConsulta" method="post" name="FrmOrdenCotizacionPrecioConsulta" id="FrmOrdenCotizacionPrecioConsulta">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"></td>
          <td align="left" valign="top">
          
          
             <fieldset class="EstFormularioContenedor"><legend>Opciones de FIltro</legend>
             
             <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Moneda:</td>
                <td><select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
          <option value="">Todos</option>
          <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
          <option <?php echo (($DatMoneda->MonId == "MON-10001")?'selected="selected"':'') ?>  value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
          <?php
			  }
			  ?>
        </select></td>
                </tr>
              <tr>
                <td>Codigo Original: </td>
                <td><table border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td><a href="javascript:FncProductoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td><input  name="CmpProductoId" type="hidden"  id="CmpProductoId" value="" size="10" maxlength="10"/>
                      <input class="EstFormularioCaja" name="CmpProductoCodigoOriginal" type="text"  id="CmpProductoCodigoOriginal" value="<?php echo $GET_ProCodigoOriginal;?>" size="20" maxlength="20"/></td>
                    </tr>
                </table></td>
                </tr>
            </table>
            
            
            
            </fieldset>
            
            
            </td>
          
          <td align="left" valign="top">
          
             <fieldset class="EstFormularioContenedor">
          
          <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo "01/01/".date("Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                </tr>
            </table>
            </fieldset>
            
            </td>
          <td align="left" valign="top">
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncOrdenCotizacionPrecioConsultaImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncOrdenCotizacionPrecioConsultaGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>OrdenCotizacion/IfrOrdenCotizacionPrecioConsulta.php" target="IfrOrdenCotizacionPrecioConsulta" id="IfrOrdenCotizacionPrecioConsulta" name="IfrOrdenCotizacionPrecioConsulta" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
</tr>
</table>
</div>


<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del botón que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del botón que  
	});
</script>
<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

