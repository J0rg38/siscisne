<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" >
</script>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">VERIFICAR VEHICULO EN CAMPAÑA</span></td>
  <td width="2%"><a href="formularios/CampanaVerificarVehiculo/inf/InfCampanaVerificarVehiculo.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Campana/IfrCampanaVerificarVehiculo.php" target="IfrCampanaVerificarVehiculo" method="post" name="FrmCampanaVerificarVehiculo" id="FrmCampanaVerificarVehiculo">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top">     <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>VIN:</td>
                <td><a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td colspan="3">
                  <span id="sprytextfield1">
               <input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" size="20" maxlength="50" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset></td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                      <option value="CamId" >Cod. Interno</option>
                      <option value="CamCodigo" >Codigo</option>
                      <option value="CamNombre">Nombre</option>
                      <option value="CamFechaInicio" selected="selected">Fecha</option>
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
						<select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
							<option value="ASC">Ascendente</option>
							<option value="DESC" selected="selected">Descendente</option>
						</select>                    
					</td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncCampanaVerificarVehiculoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncCampanaVerificarVehiculoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Campana/IfrCampanaVerificarVehiculo.php" target="IfrCampanaVerificarVehiculo" id="IfrCampanaVerificarVehiculo" name="IfrCampanaVerificarVehiculo" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

