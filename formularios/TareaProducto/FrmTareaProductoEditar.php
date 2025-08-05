<?php
//if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTareaProductoFunciones.js" ></script>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_PlanMantenimientoId = $_GET['PlanMantenimientoId'];
$GET_PlanMantenimientoTareaId = $_GET['PlanMantenimientoTareaId'];
$GET_PlanMantenimientoDetalleKilometraje = $_GET['PlanMantenimientoDetalleKilometraje'];
$GET_PlanMantenimientoDetalleId = $_GET['PlanMantenimientoDetalleId'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTareaProducto.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

//INSTANCIAS
$InsTareaProducto = new ClsTareaProducto();
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTareaProductoEditar.php');

$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$InsTareaProducto->RtiId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
?>

<script type="text/javascript">

var UnidadMedidaTipo = 2;

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">
<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        PRODUCTO PREDETERMINADO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea"></div>   
         <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTareaProducto->TprId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tarea:</td>
            <td><input name="CmpPlanMantenimientoTareaNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPlanMantenimientoTareaNombre" value="<?php echo $InsTareaProducto->PmtNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Accion:</td>
            <td><select disabled="disabled" name="CmpPlanMantenimientoDetalleAccion" class="EstFormularioCaja" id="CmpPlanMantenimientoDetalleAccion">
              <option value="X" >X</option>
              <?php
			switch($InsTareaProducto->VmaId){
				
				default:
	
	
					switch($InsTareaProducto->PmdAccion){
                
                        case "I":
                            $OpcAccion1 = 'selected="selected"';
                        break;
                        
                        case "C":
                            $OpcAccion2 = 'selected="selected"';
                        break;
                        
                        case "R":
                            $OpcAccion3 = 'selected="selected"';					
                        break;
						
						 case "U":
                            $OpcAccion4 = 'selected="selected"';					
                        break;
                      
                    }			
				
			?>
              <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
              <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
              <option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
              <option value="U" <?php echo $OpcAccion4;?>>Agregar</option>
              <?php	
				break;
				
				case "VMA-10018"://ISUZU
				
					switch($InsTareaProducto->PmdAccion){
						
		 				case "R":
							$OpcAccion1 = 'selected="selected"';
						break;
						
						case "I":
							$OpcAccion2 = 'selected="selected"';
						break;
						
						case "A":
							$OpcAccion3 = 'selected="selected"';					
						break;
						
						case "T":
							$OpcAccion5 = 'selected="selected"';						
						break;
						
						case "L":
							$OpcAccion6 = 'selected="selected"';						
						break;
						
						case "U":
							$OpcAccion7 = 'selected="selected"';						
						break;
						
                    }
			?>
              <option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
              <option value="I" <?php echo $OpcAccion2;?>>Inspeccionar</option>
              <option value="A" <?php echo $OpcAccion3;?>>Ajustar</option>
              <option value="T" <?php echo $OpcAccion5;?>>Apretar</option>
              <option value="L" <?php echo $OpcAccion6;?>>Lubricar</option>
              <option value="U" <?php echo $OpcAccion7;?>>Agregar</option>
              <?php	
				break;
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Kilometraje:</td>
            <td><input name="CmpTareaProductoKilometraje" type="text" class="EstFormularioCajaDeshabilitada" id="CmpTareaProductoKilometraje" value="<?php echo $InsTareaProducto->TprKilometraje;?>" size="20" maxlength="200" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Original:
              <input name="CmpId" type="hidden" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsTareaProducto->TprId;?>" size="15" maxlength="20"  readonly="readonly"/>
              <input name="CmpPlanMantenimientoDetalleId" type="hidden" class="EstFormularioCaja" id="CmpPlanMantenimientoDetalleId" value="<?php echo $InsTareaProducto->PmdId;?>" size="15" maxlength="20"  readonly="readonly"/>
              <input name="CmpPlanMantenimientoId" type="hidden" class="EstFormularioCaja" id="CmpPlanMantenimientoId" value="<?php echo $InsTareaProducto->PmaId;?>" size="15" maxlength="20"  readonly="readonly"/>
              <input name="CmpTareaProductoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpTareaProductoKilometraje" value="<?php echo $InsTareaProducto->TprKilometraje;?>" size="15" maxlength="20"  readonly="readonly"/>
              <input name="CmpPlanMantenimientoTareaId" type="hidden" class="EstFormularioCaja" id="CmpPlanMantenimientoTareaId" value="<?php echo $InsTareaProducto->PmtId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td><table>
              <tr>
                <td><a href="javascript:FncTareaProductoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" value="<?php echo $InsTareaProducto->ProCodigoOriginal;?>" size="10" maxlength="20" /></td>
                <td><a href="javascript:FncProductoBuscar('CodigoOriginal');">
                
                <!--<img src="imagenes/buscar2.gif" width="20" height="20" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" />-->
                <img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" />
                
                
                </a></td>
                <td><input type="hidden"  name="CmpProductoId" id="CmpProductoId" value="<?php echo $InsTareaProducto->ProId;?>"/></td>
                <td><div id="CapProductoBuscar"></div></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Producto:</td>
            <td><span id="sprytextfield1">
              <label>
                <input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" value="<?php echo $InsTareaProducto->ProNombre;?>" size="40" maxlength="250" readonly="readonly" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Unidad de Medida:</td>
            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
             <?php
			if(!empty($ArrProductoTipoUnidadMedidas)){
				foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUnidadMedida){
			?>
            	<option  <?php echo (($DatProductoTipoUnidadMedida->UmeId==$InsTareaProducto->UmeId)?'selected="selected"':'');?> value="<?php echo $DatProductoTipoUnidadMedida->UmeId;?>"><?php echo $DatProductoTipoUnidadMedida->UmeNombre;?></option>
            <?php	
				}
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cantidad:</td>
            <td><input name="CmpTareaProductoCantidad" type="text" class="EstFormularioCaja" id="CmpTareaProductoCantidad" size="10" maxlength="10" value="<?php echo $InsTareaProducto->TprCantidad;?>"   /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">

  <input type="checkbox" name="CmpCopiar" id="CmpCopiar" value="1" checked="checked" /> Copiar a todos los kilometrajes
     
            </td>
            <td>&nbsp;</td>
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
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>
	
	
	
    

</form>
<?php
//}else{
//	echo ERR_GEN_101;
//}



?>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
</script>
