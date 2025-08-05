<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsKardexFunciones.js" ></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
var ProductoValidarStock = "1";
var ProductoLector = 2;
//var ProductoEnfoque = "FechaInicio";
</script>


<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        KARDEX</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
                                                <br />
        
 
        
        
         <div class="EstFormularioArea">
         
         <table width="100%" class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td width="76" colspan="3">
              
              <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Kardex/IfrKardex.php" target="IfrKardex" id="FrmKardex" name="FrmKardex" method="post">
                
                <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="2">
                      <tr>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">C&oacute;digo Orig.:</td>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">Nombre:
                          <input name="CmpProductoId" class="EstFormularioCaja" type="hidden" id="CmpProductoId" size="10" maxlength="20"  /></td>
                        <td align="center" class="EstFormulario">Unidad:</td>
                        <td align="center" class="EstFormulario">Moneda:</td>
                        <td align="center">Fecha Inicio:</td>
                        <td align="center">Fecha Fin: </td>
                        <td align="center">Almacen:</td>
                        <td align="center">&nbsp;</td>
                        </tr>
                      
                      
                      <tr>
                        <td class="EstFormulario"><a href="javascript:FncKardexNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                        <td class="EstFormulario"><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input  class="EstFormularioCaja" name="CmpProductoNombre" type="text" id="CmpProductoNombre" size="45" maxlength="255" /></td>
                        <td class="EstFormulario"><span id="spryselect1">
                          <select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaKardex" id="CmpProductoUnidadMedidaKardex">
                            </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                        <td class="EstFormulario"><select class="EstFormularioCombo" name="Moneda" id="Moneda">
                          <option value="">Todos</option>
                          <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                          <option value="<?php echo $DatMoneda->MonId?>"  ><?php echo $DatMoneda->MonAbreviacion?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                          <?php
			  }
			  ?>
                          </select></td>
                        <td align="center"><input name="FechaInicio" type="text" class="EstFormularioCajaFecha"  id="FechaInicio" value="01/01/<?php echo date("Y")?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td align="center"><input class="EstFormularioCajaFecha" name="FechaFin" type="text"  id="FechaFin" value="<?php echo date("d/m/Y");?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td><select class="EstFormularioCombo" name="CmpAlmacenId" id="CmpAlmacenId">
                          <option value="">Escoja una opcion</option>
                          <?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
                          <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($GET_Almacen==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre;?></option>
                          <?php
}
?>
                          </select></td>
                        <td>&nbsp;</td>
                      </tr>
                        <tr>
                          <td class="EstFormulario">&nbsp;</td>
                          <td class="EstFormulario">&nbsp;</td>
                          <td class="EstFormulario">&nbsp;</td>
                          <td class="EstFormulario">&nbsp;</td>
                          <td class="EstFormulario">&nbsp;</td>
                          <td class="EstFormulario">&nbsp;</td>
                          <td align="center">&nbsp;</td>
                          <td align="center">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top">
                      <table border="0" cellpadding="0" cellspacing="2">
                        <tr>
                          <td>
                            <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                          <td>
                            <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncKardexImprimir('');" />           </td>
                          <td>
                            <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncKardexGenerarExcel('');" />           </td>
                          </tr>
                        </table>
                      
                      
                      
                      </td>
                  </tr> 
                </table>
                
                
                
                
                </form>
              </td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              
              
              
              <iframe class="autoHeight" id="IfrKardex" name="IfrKardex" scrolling="auto" frameborder="0" height="350" width="100%"></iframe>
              
              
              </td>
            <td>&nbsp;</td>
          </tr>
          </table>
        
        
        </div>
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
  </table>
    
    
</div>



	<script type="text/javascript">
Calendar.setup({ 
	inputField : "FechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del botón que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "FechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del botón que  
	});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
    </script>
    





<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

