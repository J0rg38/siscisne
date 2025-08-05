<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteProductoStockMinimo.js"></script>

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');

$InsProductoTipo = new ClsProductoTipo();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsProductoCategoria = new ClsProductoCategoria();

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


$RepProductoCategoria = $InsProductoCategoria->MtdObtenerProductoCategorias(NULL,NULL,"PcaNombre","ASC",NULL,NULL);
$ArrProductoCategorias = $RepProductoCategoria['Datos'];

?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE DE STOCK MINIMOS</span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteProductoStockMinimo.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProductoStockMinimo.php" target="IfrReporteProductoStockMinimo" method="post" name="FrmReporteProductoStockMinimo" id="FrmReporteProductoStockMinimo">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
            
            
            
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Filtrado</legend>
              
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>Clasificacion: </td>
                  <td><select class="EstFormularioCombo" name="CmpProductoCategoria" id="CmpProductoCategoria">
                    <option value="">Todos</option>
                    <?php
			foreach($ArrProductoCategorias as $DatProductoCategoria){
			?>
                    <option <?php echo $DatProductoCategoria->PcaId;?> <?php //echo ($DatProductoCategoria->PcaId==$POST_ProductoCategoria)?'selected="selected"':"";?> value="<?php echo $DatProductoCategoria->PcaId?>"><?php echo $DatProductoCategoria->PcaNombre;?></option>
                    <?php
			}
			?>
                    </select></td>
                  <td>Tipo Producto:</td>
                  <td><select class="EstFormularioCombo" name="CmpProductoTipo" id="CmpProductoTipo">
                    <option value="">Todos</option>
                    <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
                    <option <?php echo $DatProductoTipo->RtiId;?>  value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
                    <?php
			}
			?>
                    </select></td>
                  </tr>
                </table></fieldset>
            
            
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
                      <option value="ProCodigoOriginal" >Cod. Original</option>
                      <option value="ProNombre" selected="selected">Nombre</option>
                      <option value="ProStockMinimo" >Stock Min.</option>
                      
                      </select>                    
                    
                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC" selected="selected">Ascendente</option>
                      <option value="DESC" >Descendente</option>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteProductoStockMinimoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteProductoStockMinimoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProductoStockMinimo.php" target="IfrReporteProductoStockMinimo" id="IfrReporteProductoStockMinimo" name="IfrReporteProductoStockMinimo" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

