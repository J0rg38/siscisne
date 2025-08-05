<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoSeguimientoCotizacionNoPedidoFunciones.js"></script>
<?php
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">SEGUIMIENTO DE ORD. TRABAJO C/ COTIZACION NO PEDIDO</span></td>
  <td width="2%"><a href="formularios/FichaIngreso/inf/InfFichaIngresoSeguimientoCotizacionNoPedido.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>FichaIngreso/IfrFichaIngresoSeguimientoCotizacionNoPedido.php" target="IfrFichaIngresoSeguimientoCotizacionNoPedido" method="post" name="FrmFichaIngresoSeguimientoCotizacionNoPedido" id="FrmFichaIngresoSeguimientoCotizacionNoPedido">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
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
          <td align="left" valign="top">     <fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
            <!--<table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="138"><span title="Numero de Documento">Num. Doc.</span>:</td>
                <td width="22"><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td width="125"><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" size="20" maxlength="50" /></td>
                <td width="133"><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td width="5"><div id="CapClienteBuscar"></div></td>
              </tr>
              <tr>
                <td>Cliente:
                  <input type="hidden" name="CmpClienteId" id="CmpClienteId" /></td>
                <td colspan="3"><input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255"  /></td>
                <td>&nbsp;</td>
                </tr>
              </table>-->
              
              <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="138">Filtro:                  </td>
                <td width="280" colspan="3"><input class="EstFormularioCaja" name="CmpFiltro" type="text" id="CmpFiltro" size="45" maxlength="255"  /></td>
                <td width="5">&nbsp;</td>
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
                      <option value="CprId" >Cod. Cotizacion</option>
                      <option value="CprFecha" selected="selected">Fecha</option>
                      <option value="CliNombre">Cliente</option>
                      
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
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncFichaIngresoSeguimientoCotizacionNoPedidoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncFichaIngresoSeguimientoCotizacionNoPedidoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>FichaIngreso/IfrFichaIngresoSeguimientoCotizacionNoPedido.php" target="IfrFichaIngresoSeguimientoCotizacionNoPedido" id="IfrFichaIngresoSeguimientoCotizacionNoPedido" name="IfrFichaIngresoSeguimientoCotizacionNoPedido" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe></td>
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

