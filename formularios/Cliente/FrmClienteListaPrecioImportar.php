<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>


<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteListaPrecioImportarFunciones.js" ></script>


<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$POST_MonedaId = "MON-10001";
?>
<script type="text/javascript">
$(document).ready(function (){

	FncClienteListaPrecioEstablecerMoneda();

});
</script>
<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR ARCHIVOS DE LISTA DE PRECIOS DE REPUESTOS</span></td>
      </tr>
      <tr>
        <td>
        
        
                                <br />
   
        
        
     

      
    
		
		
		 <div class="EstFormularioArea" >
         
         
         <form name="FrmClienteListaPrecio" id="FrmClienteListaPrecio" method="post" enctype="multipart/form-data" action="formularios/Cliente/acc/AccClienteListaPrecioImportar.php" target="IfrClienteListaPrecioImportar">

		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Importar</span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="EstFormulario">Cliente:
                  <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="" size="3" />
                  <input name="CmpFecha" type="hidden" id="CmpFecha" value="<?php echo date("d/m/Y");?>" size="3" /></td>
                <td class="EstFormulario"><table>
                  <tr>
                    <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td><span id="sprytextfield5">
                      <label>
                        <input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" value="" size="45" maxlength="255"  />
                        </label>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                    <td> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                    </tr>
                  </table></td>
                <td class="EstFormulario">Num. Doc.:</td>
                <td class="EstFormulario"><table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionProducto->CliNumeroDocumento;?>" size="20" maxlength="50" /></td>
                    <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td></td>
                    <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"></a>
                      <div id="CapClienteBuscar"></div></td>
                    </tr>
                  </table></td>
                <td width="10%" align="left" valign="top"> Moneda: </td>
                <td width="18%" align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_MonedaId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                  <?php
			  }
			  ?>
                  </select></td>
                <td width="12%" align="left" valign="top">Tipo de Cambio:</td>
                <td width="50%" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($POST_TipoCambio)){ echo "";}else{ echo $POST_TipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                    <td><a href="javascript:FncClienteListaPrecioEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                    </tr>
                  </table></td>
                <td width="10%" align="left" valign="top"><input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" /></td>
                </tr>
              
              
            </table></td>
          </tr>
          <tr>
            <td colspan="3">
              
              <div class="EstNotasTitulo">Descripcion:</div>
              <div class="EstNotas">
                - Este modulo sirve para poder actualizar en listado de precios de repuestos.</div>
              
              <br /></td>
          </tr>
          </table>

          </form>  
            </div>
            
            </td>
          </tr>
          <tr>
            <td><iframe src="formularios/Cliente/acc/AccClienteListaPrecioImportar.php" id="IfrClienteListaPrecioImportar" name="IfrClienteListaPrecioImportar" scrolling="Auto"  frameborder="0" width="100%" height="500"></iframe></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
		
		
   
        </div>		
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
    
</div>
<?php
}else{
echo ERR_GEN_101;
}
?>
<script type="text/javascript">
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
</script>
