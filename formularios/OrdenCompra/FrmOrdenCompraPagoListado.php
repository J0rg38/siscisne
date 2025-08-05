<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraPagoListadoFunciones.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraPagoListado.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Proveedor");?>JsProveedorAutocompletar.js" ></script>


<?php

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsProveedor = new ClsProveedor();
$InsMoneda = new ClsMoneda();

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

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$POST_Moneda = "MON-10001";
?>

<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">ACTUALIZAR PAGO DE ORDENES DE COMPRA</span></td>
  <td width="2%"><a href="formularios/Proveedor/inf/InfOrdenCompraPagoListado.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <!--<form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Proveedor/IfrOrdenCompraPagoListado.php" target="IfrOrdenCompraPagoListado" method="post" name="FrmOrdenCompraPago" id="FrmOrdenCompraPago">
      -->
<form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>OrdenCompra/IfrOrdenCompraPagoListado.php" method="POST" name="FrmOrdenCompraPago" id="FrmOrdenCompraPago"  onsubmit="return false">
            
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">
          

<fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Moneda</legend>
            <table border="0" cellpadding="2" cellspacing="2"><tr>
                <td>Moneda:</td>
                <td><select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                  <option value="">Todos</option>
                  <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                  <option <?php echo (($DatMoneda->MonId==$POST_Moneda)?'selected="selected"':'')?>  value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              
              </table>
          </fieldset> 
          
          
          
          </td>
          <td align="left" valign="top">
          


<fieldset class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            
            
  <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
  <tr>
    <td><span title="Numero de Documento">Num. Doc.</span>:</td>
    <td>
      
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          <td>
            <input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento" size="20" maxlength="50" value="<?php echo $ProveedorNumeroDocumento?>" />
            </td>
          
          <td>
            <a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            </td>
          </tr>
        </table>
      
    </td>
    </tr>
  <tr>
    <td>Proveedor:
      <input type="hidden" name="CmpProveedorId" id="CmpProveedorId" value="<?php echo $ProveedorId?>" /></td>
    <td><input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" size="45" maxlength="255" value="<?php echo $ProveedorNombre;?> <?php echo $ProveedorApellidoPaterno;?> <?php echo $ProveedorApellidoMaterno;?>"  /></td>
  </tr>
  <tr>
    <td>Cancelado:</td>
    <td>
		
        
		<select name="CmpCancelado" id="CmpCancelado" class="EstFormularioCombo">
		<option value="" >Todos</option>
		<option value="1" >Si</option>
		<option value="2" selected="selected" >No</option>
		</select>
        </td>
    </tr>
  </table>
            </fieldset>   
            
            
          
                            </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td>
                
				<input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="01/01/<?php  echo date("Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  



                  </td>
              </tr>
             
              <tr>
                <td>Fecha Fin:</td>
                <td>
 
<input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> 
                  
                  
                  </td>
                </tr> 
              <tr>
                <td>&nbsp;</td>
                <td><input type="hidden" name="CmpSeleccionados" id="CmpSeleccionados" value="" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>Ordenar por:</td>
                </tr>
                <tr>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                    <option value="AmoComprobanteNumero" selected="selected">Num. Comprob.</option>
                      <option value="AmoComprobanteFecha">Fecha Comprob.</option>
                    </select>                    </td>
                  </tr>
                <tr>
                  <td><select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                    <option value="ASC" selected="selected">Ascendente</option>
                    <option value="DESC" >Descendente</option>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                </table>
            </fieldset></td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td><input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncOrdenCompraPagoCargarListado();" width="25" height="25"  /></td>
                </tr>
              <tr>
                <td>
                  
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncOrdenCompraPagoImprimir('');" width="25" height="25"  />           
                  <?php	  
            }
            ?>  
                  
                </td>
                </tr>
              <tr>
                <td><?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncOrdenCompraPagoGenerarExcel('');" width="25" height="25" />           
                  <?php	  
            }
            ?> 
                </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
      </form>    </td>
</tr>
<tr>
  <td colspan="2" align="center">

<!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Proveedor/IfrOrdenCompraPagoListado.php" target="IfrOrdenCompraPagoListado" id="IfrOrdenCompraPagoListado" name="IfrOrdenCompraPagoListado" scrolling="auto"  frameborder="0"  height="420" width="100%" onload='javascript:resizeIframe(this);'></iframe>
  
  -->
  
  
  <div class="EstFormularioCapaListado" id="CapOrdenCompraPago"></div>
  <iframe id="IfrOrdenCompraPagoListado" name="IfrOrdenCompraPagoListado" frameborder="0" height="1" ></iframe>
  
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

