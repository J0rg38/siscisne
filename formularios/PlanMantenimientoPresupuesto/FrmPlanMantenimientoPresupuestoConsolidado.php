<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPlanMantenimientoPresupuestoConsolidadoFunciones.js"></script>

<script type="text/javascript">

var VehiculoModeloHabilitado = 1;
	
</script>
<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsClienteTipo = new ClsClienteTipo();

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];
?>

<div class="EstCapMenu">

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>


<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">RESUMEN DE PLANES DE MANTENIMIENTO</span>  </td>
  <td width="2%"><a href="formularios/PlanMantenimiento/inf/InfPlanMantenimientoPresupuesto.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>PlanMantenimientoPresupuesto/IfrPlanMantenimientoPresupuestoConsolidado.php" target="IfrPlanMantenimientoPresupuestoConsolidado" method="post" name="IfrPlanMantenimientoPresupuestoConsolidado" id="FrmPlanMantenimientoPresupuestoConsolidado">
      
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td>Marca:</td>
                <td><span id="spryselect1">
                  <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                    <option <?php echo $DatVehiculoMarca->VmaId;?>  value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                    <?php
			}
			?>
                    </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>Modelo:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                </select></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Tipo Cliente:</td>
                <td><span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                    <option <?php echo $DatClienteTipo->LtiId;?> value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                    <?php
			}
			?>
                  </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncPlanMantenimientoPresupuestoConsolidadoImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncPlanMantenimientoPresupuestoConsolidadoGenerarExcel('');" />           
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
  
  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>PlanMantenimientoPresupuesto/IfrPlanMantenimientoPresupuestoConsolidado.php" target="IfrPlanMantenimientoPresupuestoConsolidado" id="IfrPlanMantenimientoPresupuestoConsolidado" name="IfrPlanMantenimientoPresupuestoConsolidado" scrolling="auto"  frameborder="0"  height="100%" width="100%"></iframe>

  </td>
</tr>
</table>
</div>


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
