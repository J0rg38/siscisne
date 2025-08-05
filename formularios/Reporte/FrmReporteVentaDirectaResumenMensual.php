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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteVentaDirectaResumenMensual.js"></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">RESUMEN  DE ORDENES DE VENTA MENSUAL</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteVentaDirectaResumenMensual.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteVentaDirectaResumenMensual.php" target="IfrReporteVentaDirectaResumenMensual" method="post" name="FrmReporteVentaDirectaResumenMensual" id="FrmReporteVentaDirectaResumenMensual" onsubmit="FncReporteVentaDirectaResumenMensualVer();">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Moneda</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Moneda:</td>
                <td><select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                </select></td>
              </tr>
              </table>
          </fieldset>    
          
          
          
          </td>
          <td align="left" valign="top"><fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td><span title="Numero de Documento">Num. Doc.</span>:</td>
    <td>
      
      <table>
        <tr>
          <td>
            <a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          <td>
            <input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" size="20" maxlength="50" />
            </td>
          
          <td>
            <a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
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
  <tr>
    <td colspan="2"><table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
      <tr>
        <td>Con O.C. Ref:</td>
        <td><select name="CmpConOrdenCompra" id="CmpConOrdenCompra" class="EstFormularioCombo">
          <option value="" selected="selected">Todos</option>
          <option value="1">Si</option>
          <option value="2">No</option>
        </select></td>
        <td>Clasificacion:</td>
        <td>
        
        <select class="EstFormularioCombo" name="CmpClasificacion" id="CmpClasificacion">
        <option value="">Todos</option>
                      <option value="1">Normal</option>
                      <option value="2">Mayorista</option>
                    </select>
                    
                    
                    </td>
        </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  </table>
            </fieldset>                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">  
              <tr>
                <td>Año:</td>
                <td>
                  
                  
                  <select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                    <?php
				for($i=2013;$i<=date("Y");$i++){
				?>
                    <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteVentaDirectaResumenMensualImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteVentaDirectaResumenMensualGenerarExcel('');" />           
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
   <!--class="autoHeight"-->
  <iframe class="autoHeight"  src="" target="IfrReporteVentaDirectaResumenMensual" id="IfrReporteVentaDirectaResumenMensual" name="IfrReporteVentaDirectaResumenMensual" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
</tr>
</table>
</div>

<script type="text/javascript"> 
//	Calendar.setup({ 
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
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

