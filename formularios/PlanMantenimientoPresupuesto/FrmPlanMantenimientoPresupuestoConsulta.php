<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","Ver")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PlanMantenimiento","GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>

<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPlanMantenimientoPresupuestoConsultaFunciones.js"></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPlanMantenimientoPresupuestoConsulta.css');
</style>

<script type="text/javascript">
var VehiculoModeloHabilitado = 1;
</script>

<?php
$GET_VehiculoMarcaId = $_GET['VehiculoMarcaId'];
$GET_VehiculoModeloId = $_GET['VehiculoModeloId'];
$GET_ClienteTipoId = $_GET['ClienteTipoId'];

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
    
    <span class="EstFormularioTitulo">CONSULTA DE PRESUPUESTO DE PLAN DE MANTENIMIENTO</span>  </td>
  <td width="2%"><a href="formularios/PlanMantenimiento/inf/InfPlanMantenimientoPresupuesto.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
   <!-- <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>PlanMantenimientoPresupuesto/IfrPlanMantenimientoPresupuestoConsulta.php" target="IfrPlanMantenimientoPresupuestoConsulta" method="post" name="IfrPlanMantenimientoPresupuestoConsulta" id="FrmPlanMantenimientoPresupuestoConsulta">
      
      -->
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top"></td>
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
                  <option <?php echo (($DatVehiculoMarca->VmaId==$GET_VehiculoMarcaId)?'selected="selected"':'');?>   value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?> <?php //echo (($DatVehiculoMarca->VmaVigenciaVenta==1)?"[*]":"");?></option>
                  <?php
			}
			?>
                </select>
                <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>Kilometraje/Plan Mant.:</td>
                <td><select class="EstFormularioCombo" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje"  >
                </select></td>
                <td>&nbsp;</td>
              </tr>
             
              <tr>
                <td>&nbsp;</td>
                <td>Modelo:</td>
                <td><span id="spryselect2">
                <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                </select>
                <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>Tipo Cliente:</td>
                <td><span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                    <option <?php echo (($DatClienteTipo->LtiId==$GET_ClienteTipoId)?'selected="selected"':'');?>  value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                    <?php
			}
			?>
                    </select>
                  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                <td>&nbsp;</td>
                </tr> 
              <tr>
                <td>&nbsp;</td>
                <td>Cliente:
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <input type="hidden" name="CmpClienteId" id="CmpClienteId" />                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </td>
                <td colspan="3"><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a><input class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255"  /><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4"><input type="checkbox" name="ChkVigentes" id="ChkVigentes" value="1" />Mostrar solo modelos vigentes de venta</td>
                <td>&nbsp;</td>
              </tr>
              </table>
          </fieldset></td>
          <td align="left" valign="top"></td>
          <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
           /* if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncPlanMantenimientoPresupuestoImprimir('');" />           
                  <?php	  
            }*/
            ?>                  </td>
                <td>
                  
                  <?php
            /*if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncPlanMantenimientoPresupuestoGenerarExcel('');" />           
                  <?php	  
            }*/
            ?>                  </td>
                </tr>
              </table></td>
        </tr>
        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
               
              
              
              
              
            </td>
        </tr>
          </table>
      <!--</form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>PlanMantenimientoPresupuesto/IfrPlanMantenimientoPresupuestoConsulta.php" target="IfrPlanMantenimientoPresupuestoConsulta" id="IfrPlanMantenimientoPresupuestoConsulta" name="IfrPlanMantenimientoPresupuestoConsulta" scrolling="auto"  frameborder="0"  height="100%" width="100%"></iframe>-->
  
  <div id="CapPlanMantenimientoPresupuestoConsulta"></div>
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
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
