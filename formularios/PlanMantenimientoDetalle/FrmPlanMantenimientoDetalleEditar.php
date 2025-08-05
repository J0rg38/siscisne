<?php
//if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPlanMantenimientoDetalleFunciones.js" ></script>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPlanMantenimientoDetalle.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
//INSTANCIAS
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPlanMantenimientoDetalleEditar.php');

$InsPlanMantenimientoDetalle->PmdId = $GET_id;
$InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalle();

//deb($GET_id);
//$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$InsPlanMantenimientoDetalle->RtiId);	
//$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];


$InsTareaProducto = new ClsTareaProducto();
$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimientoDetalle->PmaId,$InsPlanMantenimientoDetalle->PmdKilometraje,$InsPlanMantenimientoDetalle->PmtId);
$ArrTareaProductos = $ResTareaProducto['Datos'];


$TprId = "";

foreach($ArrTareaProductos as $DatTareaProducto){
	$TprId =  $DatTareaProducto->TprId;
}


?>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

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
        DETALLE DE PLAN DE MANTENIMIENTO</span></td>
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
            <td>Codigo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPlanMantenimientoDetalle->PmdId;?>" size="20" maxlength="20" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tarea:</td>
            <td><input name="CmpPlanMantenimientoTareaNombre" type="text" class="EstFormularioCaja" id="CmpPlanMantenimientoTareaNombre" value="<?php echo $InsPlanMantenimientoDetalle->PmtNombre;?>" size="40" maxlength="200" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Kilometraje:</td>
            <td><input name="CmpPlanMantenimientoDetalleKilometraje" type="text" class="EstFormularioCaja" id="CmpPlanMantenimientoDetalleKilometraje" value="<?php echo $InsPlanMantenimientoDetalle->PmdKilometraje;?>" size="20" maxlength="200" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Accion:</td>
            <td>
            
            
            
            <select name="CmpAccion" class="EstFormularioCaja" id="CmpAccion">
              <option value="X" >X</option>
            <?php
			switch($InsPlanMantenimientoDetalle->VmaId){
				
				default:
	
	
					switch($InsPlanMantenimientoDetalle->PmdAccion){
                
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
				
					switch($InsPlanMantenimientoDetalle->PmdAccion){
						
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
            
            </select>
            
            
            
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

