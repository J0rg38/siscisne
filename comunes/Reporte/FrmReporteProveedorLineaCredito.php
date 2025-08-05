<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteProveedorLineaCredito.js"></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>


<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');


$InsMoneda = new ClsMoneda();
$InsProveedor = new ClsProveedor();

$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
$ArrProveedores = $ResProveedor['Datos'];


if(!empty($ArrProveedores)){
	foreach($ArrProveedores as $DatProveedor){

		$ProveedorId = $DatProveedor->PrvId;
		$ProveedorNombre = $DatProveedor->PrvNombre;
		$ProveedorApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
		$ProveedorApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
		$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;

	}
}


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
?>




<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE LINEA DE CREDITO DE PROVEEDOR</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteProveedorLineaCredito.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProveedorLineaCredito.php" target="IfrReporteProveedorLineaCredito" method="post" name="FrmReporteProveedorLineaCredito" id="FrmReporteProveedorLineaCredito">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          

<fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Moneda</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Moneda:</td>
                <td><span id="spryselect1">
                  <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                    <option value="">Todos</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option <?php echo (($DatMoneda->MonId=="MON-10001")?'selected="selected"':'')?>  value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonAbreviacion?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                  </td>
              </tr>
              </table>
          </fieldset> 
          
          
          </td>
          <td align="left" valign="top">      <fieldset class="EstFormularioContenedor">
        <legend>Opciones de Filtrado</legend>
             
<table border="0" cellpadding="2" cellspacing="2">
<tr>
  <td align="left"><span title="Numero de Documento">Num. Doc.</span>:</td>
  <td align="left"><table>
    <tr>
      <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
      <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" /></td>
      <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td width="49" align="left">Proveedor: </td>
  <td width="300" align="left">
    <a href="javascript:FncProveedorNuevo();"></a>
    
    <input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="50" maxlength="255" value="<?php echo $ProveedorNombre;?> <?php echo $ProveedorApellidoPaterno;?> <?php echo $ProveedorApellidoMaterno;?>">
    <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $ProveedorId?>" />	
    <a href="javascript:FncProveedorBuscar('NumeroDocumento');"></a></td>
</tr>
</table>
      </fieldset>                   </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo "01/01/".date("Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
                </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteProveedorLineaCreditoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteProveedorLineaCreditoGenerarExcel('');" />           
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
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProveedorLineaCredito.php" target="IfrReporteProveedorLineaCredito" id="IfrReporteProveedorLineaCredito" name="IfrReporteProveedorLineaCredito" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
  
  <iframe class="autoHeight"  target="IfrReporteProveedorLineaCredito" id="IfrReporteProveedorLineaCredito" name="IfrReporteProveedorLineaCredito" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  
  
  </td>
</tr>
</table>
</div>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

