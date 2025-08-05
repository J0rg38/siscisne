<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteOrdenCompraPendiente.js"></script>


<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsMoneda = new ClsMoneda();
$InsProveedor = new ClsProveedor();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

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

$POST_Moneda = "MON-10001";
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE ORDEN DE COMPRA NO ATENDIDOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteOrdenCompraPendiente.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteOrdenCompraPendiente.php" target="IfrReporteOrdenCompraPendiente" method="post" name="FrmReporteOrdenCompraPendiente" id="FrmReporteOrdenCompraPendiente">
      
      
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
            <a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          <td>
            <input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" value="<?php echo $ProveedorNumeroDocumento;?>" />
            </td>
          
          <td>
            <a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          </tr>
        </table>
      
    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Proveedor:
      <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $ProveedorId?>" /></td>
    <td><input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255"   value="<?php echo $ProveedorNombre;?> <?php echo $ProveedorApellidoPaterno;?> <?php echo $ProveedorApellidoMaterno;?>"/></td>
    <td>&nbsp;</td>
  </tr>
  </table>
            </fieldset>                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">  
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo "01/".date("m/Y");?>" size="10" maxlength="10"/>
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
               
          
<fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">  
              <tr>
                <td><!--Con O.C.:-->Moneda:</td>
                <td><!--<select name="CmpConOrdenCompra" id="CmpConOrdenCompra" class="EstFormularioCombo">
                  <option value="1" selected="selected">Si</option>
                  <option value="2">No</option>
                </select>-->
                  <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
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
                <td>Ord. Compra:</td>
                <td><table>
    <tr>
    <td><a href="javascript:FncOrdenCompraNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    <td>
      <input name="CmpOrdenCompraId" id="CmpOrdenCompraId" type="hidden"    value="<?php  echo $InsPedidoCompra->OcoId;?>" size="20" maxlength="20" />
      <input name="CmpOrdenCompra" type="text" class="EstFormularioCaja" id="CmpOrdenCompra" size="20" maxlength="50" />
    </td>
    <td><a href="javascript:FncOrdenCompraBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    </tr>
    </table></td>
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
                     
                     <option value="OcoId" >Ord. Compra</option>
                      <option value="OcoFecha" selected="selected">Fecha</option>
                     
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteOrdenCompraPendienteImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteOrdenCompraPendienteGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="" target="IfrReporteOrdenCompraPendiente" id="IfrReporteOrdenCompraPendiente" name="IfrReporteOrdenCompraPendiente" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

