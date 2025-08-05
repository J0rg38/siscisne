<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsKardexVehiculoGeneralFunciones.js" ></script>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();
$InsUnidadMedida = new ClsUnidadMedida();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
var VehiculoValidarStock = "1";
var VehiculoLector = 2;
//var VehiculoEnfoque = "FechaInicio";
</script>


<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        KARDEX DE VEHICULOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
                                                <br />
        
 
        
         <div class="EstFormularioArea">
         
         <table width="100%" class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td width="76" colspan="3">
           
              
              <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>KardexVehiculo/IfrKardexVehiculoGeneral.php" target="IfrKardexVehiculoGeneral" id="FrmKardexVehiculo" name="FrmKardexVehiculo" method="GET">
                
                <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="2">
                      <tr>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">C&oacute;digo Vehiculo:
                          <input name="CmpVehiculoId" class="EstFormularioCaja" type="hidden" id="CmpVehiculoId" size="10" maxlength="20"  /></td>
                        <td align="center" class="EstFormulario">&nbsp;</td>
                        <td align="center" class="EstFormulario">Marca:</td>
                        <td align="center" class="EstFormulario">Modelo:</td>
                        <td align="center" class="EstFormulario">Version:</td>
                        <td align="center" class="EstFormulario">Unidad:</td>
                        <td align="center" class="EstFormulario">Moneda:</td>
                        <td align="center">Fecha Inicio:</td>
                        <td align="center">Fecha Fin: </td>
                        <td align="center">Sucursal:</td>
                        <td align="center">&nbsp;</td>
                        </tr>
                      
                      
                      <tr>
                        <td class="EstFormulario"><a href="javascript:FncKardexVehiculoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input name="CmpVehiculoCodigoIdentificador"  type="text" class="EstFormularioCaja" id="CmpVehiculoCodigoIdentificador" size="10" maxlength="20" /></td>
                        <td class="EstFormulario"><a href="javascript:FncVehiculoBuscar('CodigoIdentificador');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td class="EstFormulario"><input name="CmpVehiculoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMarca" size="10" maxlength="255" readonly="readonly" /></td>
                        <td class="EstFormulario"><input name="CmpVehiculoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoModelo" size="10" maxlength="255" readonly="readonly" /></td>
                        <td class="EstFormulario"><input name="CmpVehiculoVersion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersion" size="10" maxlength="255" readonly="readonly" /></td>
                        <td class="EstFormulario">
                          
                          
                          <select disabled="disabled"  class="EstFormularioCombo" name="CmpVehiculoUnidadMedidaKardexVehiculo" id="CmpVehiculoUnidadMedidaKardexVehiculo">
                            <?php
						if(!empty($ArrUnidadMedidas)){
							foreach($ArrUnidadMedidas as $DatUnidadMedida){
						?>
                            <option value="<?php echo $DatUnidadMedida->UmeId;?>"><?php echo $DatUnidadMedida->UmeNombre;?></option>
                            <?php
							}
						}
						?>
                            </select>
                          
                        </td>
                        <td class="EstFormulario"><select disabled="disabled" class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                          <option value="">Todos</option>
                          <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                          <option value="<?php echo $DatMoneda->MonId?>"    ><?php echo $DatMoneda->MonAbreviacion?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                          <?php
			  }
			  ?>
                          </select></td>
                        <td align="center"><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha"  id="CmpFechaInicio" value="01/01/<?php echo date("Y")?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td align="center"><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php echo date("d/m/Y");?>" size="10" maxlength="10"/>
                          <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td><select class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                          <option value="">Escoja una opcion</option>
                          <?php
foreach($ArrSucursales as $DatSucursal){
?>
                          <option value="<?php echo $DatSucursal->SucId?>" <?php if($GET_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
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
                            <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />           </td>
                          <td>
                            <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel"/>           </td>
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
              
              
              
              <iframe class="autoHeight" id="IfrKardexVehiculoGeneral" name="IfrKardexVehiculoGeneral" scrolling="auto" frameborder="0" height="350" width="100%"></iframe>
              
              
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

