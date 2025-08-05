<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteProductoStock.js"></script>

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
    
    <span class="EstFormularioTitulo">REPORTE DE STOCK A LA FECHA</span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteProductoStock.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProductoStock.php" target="IfrReporteProductoStock" method="post" name="FrmReporteProductoStock" id="FrmReporteProductoStock">
      
      
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
                  <td>Marca:</td>
                  <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                    <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsOrdenVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                    <?php
			}
			?>
                    </select></td>
                  </tr>
                </table></fieldset>
            
            
          </td>
          <td align="left" valign="top">
            
            <fieldset  class="EstFormularioContenedor">
              <legend>Opciones de Fechas</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>Fecha Inicio: </td>
                  <td><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha"  id="CmpFechaInicio" value="<?php  echo "01/01/".date("Y");?>" size="10" maxlength="10" readonly="readonly"/>
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
					<option value="AstStock" >Stock</option>
		
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteProductoStockImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteProductoStockGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteProductoStock.php" target="IfrReporteProductoStock" id="IfrReporteProductoStock" name="IfrReporteProductoStock" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

