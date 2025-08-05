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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteVentaDirectaResumen.js"></script>

<?php

$POST_Sucursal = $_SESSION['SesionSucursal'];

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];


?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">RESUMEN  DE ORDENES DE VENTA</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteVentaDirectaResumen.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteVentaDirectaResumen.php" target="IfrReporteVentaDirectaResumen" method="post" name="FrmReporteVentaDirectaResumen" id="FrmReporteVentaDirectaResumen" onsubmit="FncReporteVentaDirectaResumenVer();">
      
      
      <table class="EstFormulario" cellpadding="0" cellspacing="0" border="0">

        <tr>
          <td align="left" valign="top"><fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
            <table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
              <tr>
                <td>Sucursal:</td>
                <td colspan="3"><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="70"><span title="Numero de Documento">Num. Doc.</span>:</td>
                <td colspan="3">
                  
                  <table>
                    <tr>
                      <td>
                        <a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                        </td>
                      <td>
                        <input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" size="20" maxlength="50" />
                        </td>
                      
                      <td>
                        <a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                        </td>
                      </tr>
                    </table>
                  
                  </td>
                <td width="1">Cliente:
                  <input type="hidden" name="CmpClienteId" id="CmpClienteId" /></td>
                <td width="1"><input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255"  /></td>
                </tr>
              <tr>
                <td>Tipo Pedido</td>
                <td><select name="CmpOrdenCompraPedido" id="CmpOrdenCompraPedido" class="EstFormularioCombo">
                  <option value="" selected="selected">Todos</option>
                  <option value="YRUSH">YRUSH</option>
                  <option value="ZVOR">ZVOR</option>
                  <option value="STK">STK</option>
                  <option value="ZGAR">ZGAR</option>
                </select></td>
                <td>Estado:</td>
                <td><select name="CmpEstado" id="CmpEstado" class="EstFormularioCombo">
                  <option value="" selected="selected">Todos</option>
                  <option value="1">PENDIENTE</option>
                  <option value="2">INCOMPLETO</option>
                  <option value="3">COMPLETADO</option>
                </select></td>
                <td>Clasificacion:</td>
                <td><select class="EstFormularioCombo" name="CmpClasificacion" id="CmpClasificacion">
                  <option value="">Todos</option>
                  <option  value="1">Normal</option>
                  <option value="2">Mayorista</option>
                </select></td>
                </tr>
              <tr>
                <td>O.C. Ref.:</td>
                <td><input name="CmpOrdenCompraNumero" type="text" class="EstFormularioCaja" id="CmpOrdenCompraNumero" size="10" maxlength="50" /></td>
                <td>Codigo Orig.:</td>
                <td><input name="CmpProductoCodigoOriginal" type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="50" /></td>
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
          </fieldset>                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">  
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="01/<?php  echo date("m/Y");?>" size="10" maxlength="10"/>
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
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                      <option value="VdiId" selected="selected">Ord. Ven.</option>
                      <option value="VdiFecha" >Fecha / Ord. Ven.</option>
                      
                      <option value="VdiOrdenCompraNumero">O.C. Ref.</option>
                      <option value="VdiOrdenCompraFecha">Fecha / O.C. Ref.</option>
                      
                      <option value="cli.CliNombre" >Cliente</option>
                      
                      
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncReporteVentaDirectaResumenImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncReporteVentaDirectaResumenGenerarExcel('');" />           
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
  <iframe class="autoHeight"  src="" target="IfrReporteVentaDirectaResumen" id="IfrReporteVentaDirectaResumen" name="IfrReporteVentaDirectaResumen" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

