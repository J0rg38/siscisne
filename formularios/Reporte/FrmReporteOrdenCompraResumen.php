<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteOrdenCompraResumen.js"></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsMoneda = new ClsMoneda();
$InsProveedor = new ClsProveedor();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

//$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
//$ArrProveedores = $ResProveedor['Datos'];
//
//if(!empty($ArrProveedores)){
//	foreach($ArrProveedores as $DatProveedor){
//
//		$ProveedorId = $DatProveedor->PrvId;
//		$ProveedorNombre = $DatProveedor->PrvNombre;
//		$ProveedorApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
//		$ProveedorApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
//		$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
//
//	}
//}

$POST_Moneda = "MON-10001";
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">RESUMEN DE ORDENES DE COMPRA DE REPUESTOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteOrdenCompraResumen.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteOrdenCompraResumen.php" target="IfrReporteOrdenCompraResumen" method="post" name="FrmReporteOrdenCompraResumen" id="FrmReporteOrdenCompraResumen">
      
      
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
          <option <?php echo (($DatMoneda->MonId == $POST_Moneda)?'selected="selected"':'') ?>  value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonAbreviatura?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
          <?php
			  }
			  ?>
        </select></td>
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
              </tr> 
            </table>
          </fieldset>    </td>
          <td align="left" valign="top">
          


<fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
              <tr>
                <td>Cliente
                  <input type="hidden" name="CmpClienteId" id="CmpClienteId" /></td>
                <td><input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="30" maxlength="255"  /></td>
              </tr>  
              <tr>
                <td>Tipo Pedido:</td>
                <td><select class="EstFormularioCombo" name="CmpOrdenCompraTipo" id="CmpOrdenCompraTipo">
                  <option value="">Escoja una opcion</option>
                  <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
                  <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
                  <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
                  <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
                  <option <?php echo $OcoTipo7;?> value="YPRO">YPRO</option>
                  <option <?php echo $OcoTipo5;?> value="STK">STK</option>
                  <option <?php echo $OcoTipo8;?> value="STX">STX</option>
                  <option <?php echo $OcoTipo6;?> value="ALM">ALM</option>
                  <option <?php echo $OcoTipo9;?> value="YSTK">YSTK</option>
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
                    
                      <option value="OcoId" selected="selected" >Ord. Compra</option>
                      <option value="OcoFecha"  >Fecha Ord. Compra </option>
                     <option value="CliNombre"  >Cliente</option>
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td></td>
                  <td><select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                    <option value="ASC"  selected="selected">Ascendente</option>
                    <option value="DESC">Descendente</option>
                    </select></td>
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteOrdenCompraResumenImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteOrdenCompraResumenGenerarExcel('');" />           
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
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteOrdenCompraResumen.php" target="IfrReporteOrdenCompraResumen" id="IfrReporteOrdenCompraResumen" name="IfrReporteOrdenCompraResumen" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
  
  <iframe class="autoHeight"  src="" target="IfrReporteOrdenCompraResumen" id="IfrReporteOrdenCompraResumen" name="IfrReporteOrdenCompraResumen" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>
  
  
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

