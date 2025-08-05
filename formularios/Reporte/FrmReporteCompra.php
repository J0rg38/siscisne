<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteCompra.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",1,NULL);
$ArrSucursales = $ResSucursal['Datos'];
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE COMPRAS </span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteCompra.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteCompra.php" target="IfrReporteCompra" method="post" name="FrmReporteCompra" id="FrmReporteCompra">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">  <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Visualizacion</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td align="left">
                    Expresado en:                    </td>
                  <td align="left">
                    <select class="EstFormularioCombo" id="CmpMoneda" name="CmpMoneda">
					<option value="">Todos</option>
                      <?php
			foreach($ArrMonedas as $DatMoneda){				
				
			?>
                      <option <?php if($EmpresaMonedaId == $DatMoneda->MonId){ echo 'selected="selected"';}?> value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?> <?php echo $DatMoneda->MonSimbolo;?></option>
                      <?php
			}
			?>
                      </select>                    </td>
                </tr>
                </table>
              </fieldset>  </td>
          <td rowspan="2" align="left" valign="top">     <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td><span title="Numero de Documento">Num. Doc.</span>:</td>
    <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
    <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" /></td>
    <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
    <td><div id="CapProveedorBuscar"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Proveedor:
      <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" /></td>
    <td colspan="6"><input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255"  /></td>
    </tr>
  <tr>
    <td>Impuesto: </td>
    <td colspan="4"><select class="EstFormularioCombo" name="CmpImpuesto" id="CmpImpuesto">
      <option selected="selected" value="">Todos</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select></td>
    <td>Declarado:</td>
    <td><select class="EstFormularioCombo" name="CmpDeclarado" id="CmpDeclarado">
      <option selected="selected" value="">Todos</option>
      <option value="1">Si</option>
      <option value="2">No</option>
       <option value="3">Por Declarar</option>
       <option value="4">No Declarable</option>
      </select></td>
    </tr>
  </table>
            </fieldset></td>
          <td rowspan="2" align="left" valign="top">        <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Lugar</legend>
            Sucursal:
            <select name="CmpSucursal" id="CmpSucursal" class="EstFormularioCombo">
              <!--<option value="-1">Todos</option>-->
              <?php
		foreach($ArrSucursales as $DatSucursal){
		?>
              <option <?php if($DatSucursal->SucId==$_SESSION['SisSucId']){ echo 'selected="selected"';}?>value="<?php echo $DatSucursal->SucId?>"><?php echo $DatSucursal->SucNombre?></option>
              <?php	
		}
		?>
              </select>
            </fieldset></td>
          <td rowspan="2" align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                      <option value="ComId" selected="selected">Cod. de Compra</option>
                      <option value="ComFechaEmision" selected="selected">Fecha de Ingreso</option>
                      <option value="CtiNombre">Comprobante</option>
                      <option value="ComComprobanteNumero">Num. de Comprobante</option>
                      <option value="ComComprobanteFecha">Fecha de Comprobante</option>
                      <option value="ComGuiaRemisionNumero">Num. de G. Remision</option>
                      <option value="ComGuiaRemisionFecha">Fecha de G. Remision</option>
                      <option value="PrvNumeroDocumento"><span title="Numero de Documento">Num. Doc.</span> de Proveedor</option>
                      <option value="PrvNombre">Proveedor</option>
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
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td><select class="EstFormularioCombo" name="CmpFechaFiltro" id="CmpFechaFiltro">
                  <option value="ComFechaEmision" selected="selected">Fecha Ingreso</option>
                  <option value="ComComprobanteFecha">Fecha de  Comprobante</option>
                  <option value="ComDeclaradoFecha">Fecha de  Declaracion</option>
					<option value="ComDeclaradoFecha">Fecha Por Declarar</option>
                  </select></td>
                </tr>
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo "01/".date("m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" />                  </td>
                </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /> </td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteCompraImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteCompraGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteCompra.php" target="IfrReporteCompra" id="IfrReporteCompra" name="IfrReporteCompra" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

