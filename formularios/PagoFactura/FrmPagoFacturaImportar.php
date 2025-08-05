<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar")){
?>

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FormaPago');?>JsCuentaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPagoFacturaImportarFunciones.js" ></script>

<?php
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsArea = new ClsArea();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();
$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,1);
$ArrAreas = $ResArea['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResFormaPago = $InsFormaPago->MtdObtenerFormaPagos(NULL,NULL,"FpaId","ASC",NULL,1);
$ArrFormaPagos = $ResFormaPago['Datos'];

$ResCuenta = $InsCuenta->MtdObtenerCuentas(NULL,NULL,NULL,"CueId","ASC",NULL,NULL,$InsFactura->MonId);
$ArrCuentas = $ResCuenta['Datos'];

?>






<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR PAGO DE FACTURAS</span></td>
      </tr>
      <tr>
        <td>
        
        
                                <br />
   
        
        
     

      
    
		
		
		 <div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Importar</span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
            
            
             <div class="EstFormularioArea" >
            
                    
         <form name="FrmPagoFactura" id="FrmPagoFactura" method="post" enctype="multipart/form-data" action="formularios/PagoFactura/acc/AccPagoFacturaImportar.php" target="IfrPagoFacturaImportar">
            
            
            
            
  <table class="EstFormulario" width="100%" border="0" cellpadding="0" cellspacing="2">
 
    <tr>
      <td width="15%" align="left" valign="top" class="EstFormularioEtiqueta">Cliente:
        <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="" size="3" />
        <input name="CmpFecha" type="hidden" id="CmpFecha" value="<?php echo date("d/m/Y");?>" size="3" /></td>
      <td width="42%" align="left" valign="top" class="EstFormularioContenido">
      
      <table>
        <tr>
          <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
          <td><span id="sprytextfield5">
            <label>
              <input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" value="" size="45" maxlength="255"  />
              </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          <td> <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
          </tr>
        </table>
        
        
        </td>
      <td width="11%" align="left" valign="top" class="EstFormularioEtiqueta">Num. Doc.:</td>
      <td width="22%" align="left" valign="top" class="EstFormularioContenido"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
          <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionProducto->CliNumeroDocumento;?>" size="20" maxlength="50" /></td>
          <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
          <td></td>
          <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"></a>
            <div id="CapClienteBuscar"></div></td>
          </tr>
      </table></td>
      <td width="10%" align="left" valign="middle"><!--  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/establecer.jpg" alt="[Ver]" title="Ver" />-->
      
      </td>
      </tr>
    
      <tr>
        <td align="left" valign="top" class="EstFormularioEtiqueta" >Moneda:</td>
        <td align="left" valign="top" class="EstFormularioContenido" >
          
          <span id="spryselect3">
          <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
            <option value="">Todos</option>
            <?php
    foreach($ArrMonedas as $DatMoneda){
    ?>
            <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_MonedaId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
            <?php
    }
    ?>
            </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>         </td>
        <td align="left" valign="top" class="EstFormularioEtiqueta" >Cuenta:</td>
        <td align="left" valign="top" class="EstFormularioContenido" ><span id="spryselect4">
          <select class="EstFormularioCombo" name="CmpCuenta" id="CmpCuenta">
            <option value="">Escoja una opcion</option>
            <?php
      foreach($ArrCuentas as $DatCuenta){
      ?>
            <option <?php echo ($InsPago->CueId == $DatCuenta->CueId)?'selected="selected"':''; ?> value="<?php echo $DatCuenta->CueId?>"><?php echo $DatCuenta->BanNombre; ?> - <?php echo $DatCuenta->CueNumero ?> - <?php echo $DatCuenta->MonNombre; ?></option>
            <?php
      }
      ?>
            </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        <td width="10%" align="left" valign="middle">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstFormularioEtiqueta">Forma  Pago:</td>
        <td align="left" valign="top" class="EstFormularioContenido" ><span id="spryselect1">
          <select class="EstFormularioCombo" name="CmpFormaPago" id="CmpFormaPago">
            <option value="">Escoja una opcion</option>
            <?php
    foreach($ArrFormaPagos as $DatFormaPago){
      ?>
            <option <?php echo ($InsPago->FpaId == $DatFormaPago->FpaId)?'selected="selected"':''; ?>  value="<?php echo $DatFormaPago->FpaId?>"><?php echo $DatFormaPago->FpaNombre ?></option>
            <?php
    }
    
    ?>
          </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        <td align="left" valign="top" class="EstFormularioEtiqueta" >Area Destino:</td>
        <td align="left" valign="top" class="EstFormularioContenido" ><span id="spryselect2">
          <select class="EstFormularioCombo" name="CmpAreaId" id="CmpAreaId">
            <option value="">Escoja una opcion</option>
            <?php
    foreach($ArrAreas as $DatArea){
      ?>
            <option <?php echo ($InsPago->AreId == $DatArea->AreId)?'selected="selected"':''; ?>  value="<?php echo $DatArea->AreId?>"><?php echo $DatArea->AreNombre ?></option>
            <?php
    }
    
    ?>
          </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        <td width="10%" align="left" valign="middle">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstFormularioEtiqueta">Archivo:</td>
        <td colspan="3" align="left" valign="top" class="EstFormularioContenido" >
          
          
          <input type="file" id="CmpArchivo" name="CmpArchivo" />
          
          
          <input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />
          
          
          
        </td>
        <td width="10%" align="left" valign="middle">&nbsp;</td>
        </tr>
        
  </table>
            
            
            </form>
            
            </div>
            
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              
              <div class="EstNotasTitulo">Descripcion:</div>
              <div class="EstNotas">
                - Este modulo sirve para actualizar los abonos de los clientes usando un archivo de excel.<br />
                
  </div>
              
              <br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              
              <iframe src="formularios/PagoFactura/acc/AccPagoFacturaImportar.php" id="IfrPagoFacturaImportar" name="IfrPagoFacturaImportar" scrolling="Auto"  frameborder="0" width="800" height="500"></iframe>
              
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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


<script type="text/javascript">
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>


<?php
}else{
echo ERR_GEN_101;
}
?>
