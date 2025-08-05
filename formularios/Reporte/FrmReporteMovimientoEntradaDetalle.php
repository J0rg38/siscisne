<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteMovimientoEntradaDetalle.js"></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsMoneda = new ClsMoneda();
$InsProveedor = new ClsProveedor();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
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
    
    <span class="EstFormularioTitulo">REPORTE DE MOVIMIENTOS DE ENTRADA DETALLE</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteMovimientoEntradaDetalle.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteMovimientoEntradaDetalle.php" target="IfrReporteMovimientoEntradaDetalle" method="post" name="FrmReporteMovimientoEntradaDetalle" id="FrmReporteMovimientoEntradaDetalle">
      
      
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
          <option <?php echo (($DatMoneda->MonId == $POST_Moneda)?'selected="selected"':'') ?>  value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
          <?php
			  }
			  ?>
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      </table>
    </fieldset>   
            
            
          </td>
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">  
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="01/01/<?php  echo date("Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
                </tr>
             
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
                </tr> <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
          


<fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
              <tr>
                <td><span title="Numero de Documento">Num. Doc.</span>:</td>
                <td colspan="3"><table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" value="<?php echo $ProveedorNumeroDocumento?>" /></td>
                    <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>Proveedor:
                  <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $ProveedorId?>" /></td>
                <td colspan="3"><input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255" value="<?php echo $ProveedorNombre;?> <?php echo $ProveedorApellidoPaterno;?> <?php echo $ProveedorApellidoMaterno;?>"  /></td>
              </tr>  
              <tr>
                <td>Con O.C.:</td>
                <td><select name="CmpConOrdenCompra" id="CmpConOrdenCompra" class="EstFormularioCombo">
                  <option value=""  selected="selected"  >Todos</option>
                  <option value="1" >Si</option>
                  <option value="2">No</option>
                </select></td>
                <td>Cancelado:</td>
                <td><select name="CmpCancelado" id="CmpCancelado" class="EstFormularioCombo">
                  <option value=""  >Todos</option>
                  <option value="1" >Si</option>
                  <option value="2" selected="selected" >No</option>
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
                      <option value="AmoId">Mov. Alm</option>
                      <option value="OcoId" >Ord. Compra</option>
                      <option value="AmoComprobanteFecha" >Fecha Comprobante</option>
                      <option value="AmoComprobanteNumero" selected="selected" > Num. Comprobante</option>
                       <option value="ProCodigoOriginal" >Cod. Original</option>
                       <option value="CliNombre" >Cliente</option>
                     
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td></td>
                  <td><select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                    <option value="ASC"  selected="selected">Ascendente</option>
                    <option value="DESC">Descendente</option>
                  </select></td>
                </tr>
                <tr>
                  <td>                    </td>
                  <td>&nbsp;</td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteMovimientoEntradaDetalleImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteMovimientoEntradaDetalleGenerarExcel('');" />           
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
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteMovimientoEntradaDetalle.php" target="IfrReporteMovimientoEntradaDetalle" id="IfrReporteMovimientoEntradaDetalle" name="IfrReporteMovimientoEntradaDetalle" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
  
  <iframe class="autoHeight"  src="" target="IfrReporteMovimientoEntradaDetalle" id="IfrReporteMovimientoEntradaDetalle" name="IfrReporteMovimientoEntradaDetalle" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  
  
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
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

