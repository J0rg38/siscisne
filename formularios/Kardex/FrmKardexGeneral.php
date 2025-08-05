<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsAlmacenCombo.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsKardexGeneralFunciones.js" ></script>

<?php

$POST_Sucursal = $_SESSION['SesionSucursal'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsProductoTipo = new ClsProductoTipo();
$InsMoneda = new ClsMoneda();
$InsProductoCategoria = new ClsProductoCategoria();
$InsSucursal = new ClsSucursal();
$InsAlmacen = new ClsAlmacen();

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepProductoCategoria = $InsProductoCategoria->MtdObtenerProductoCategorias(NULL,NULL,"PcaNombre","ASC",NULL,NULL);
$ArrProductoCategorias = $RepProductoCategoria['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$POST_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];

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
        KARDEX GENERAL</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
                                                <br />
        
 
        
        
         <div class="EstFormularioArea">
         
         <table width="100%" class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td width="76" colspan="3" align="center">
              
           <!--   <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Kardex/IfrKardexGeneral.php" target="IfrKardexGeneral" method="post" name="FrmKardexGeneral" id="FrmKardexGeneral">
            -->    
                <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">
                  <tr>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="2">
                      <tr>
                        <td align="center" class="EstFormulario">Sucursal:</td>
                        <td align="center">Almacen:</td>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">C&oacute;digo Orig.:</td>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">Nombre:
                          <input name="CmpProductoId" class="EstFormularioCaja" type="hidden" id="CmpProductoId" size="10" maxlength="20"  /></td>
                        <td align="center" class="EstFormulario">Unidad:</td>
                        <td align="center">Fecha Inicio:</td>
                        <td align="center">Fecha Fin: </td>
                        </tr>
                      <tr>
                        <td class="EstFormulario"><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                          <option value="">Todos</option>
                          <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                          <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                          <?php
    }
    ?>
                        </select></td>
                        <td><select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                          <option value="">Escoja una opcion</option>
                          <?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
                          <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($GET_Almacen==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre;?></option>
                          <?php
}
?>
                        </select></td>
                        <td class="EstFormulario"><a href="javascript:FncKardexNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                        <td class="EstFormulario"><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input  class="EstFormularioCaja" name="CmpProductoNombre" type="text" id="CmpProductoNombre" size="25" maxlength="255" /></td>
                        <td class="EstFormulario"><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaKardex" id="CmpProductoUnidadMedidaKardex">
                        </select></td>
                        <td><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha"  id="CmpFechaInicio" value="01/01/<?php echo date("Y")?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php echo date("d/m/Y");?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        </tr>
                    </table></td>
                    <td><table border="0" cellpadding="0" cellspacing="2">
                      <tr>
                        <td><input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" /></td>
                        <td><input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  /></td>
                        <td><input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel"  /></td>
                        </tr>
                      </table></td>
                  </tr>
                  </table>
                
                
              <!--  
                
                </form>-->
              </td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
              
            <!--  class="autoHeight" -->
              <!--<iframe id="IfrKardexGeneral" name="IfrKardexGeneral" scrolling="auto" frameborder="0" height="350" width="100%"></iframe>-->
                 <div id="CapKardexGeneral"></div>
  
              
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
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del botón que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del botón que  
	});
    </script>
    





<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

