<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$ModalidadIngresoId = $_POST['ModalidadIngresoId'];

session_start();
if (!isset($_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

/*$GET_tipo = $_GET['Tipo'];
$GET_ptipo = $_GET['RtiId'];
*/
$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();


				//SesionObjeto-FichaAccionProducto
				//Parametro1 = FapId
				//Parametro2 = ProId
				//Parametro3 = ProNombre
				//Parametro4 = FapVerificar1
				//Parametro5 = FapVerificar2
				//Parametro6 = UmeId
				//Parametro7 = FapTiempoCreacion
				//Parametro8 = FapTiempoModificacion
				//Parametro9 = FapCantidad
				//Parametro10 = FapCantidadReal	
				//Parametro11 = RtiId
				//Parametro12 = UmeNombre
				//Parametro13 = UmeIdOrigen
				//Parametro14 = FapEstado
				//Parametro15 = Tipo
				//Parametro16 = FapAccion
	
$RepFichaAccionProducto = $_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrFichaAccionProductos = $RepFichaAccionProducto['Datos'];


$RepFichaAccionMantenimiento = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrFichaAccionMantenimientos = $RepFichaAccionMantenimiento['Datos'];


?>

<?php
if(empty($ArrFichaAccionProductos)){
?>
<!--No se encontraron elementos-->
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="8%" align="center">-</th>
  <th width="13%" align="center">Cod. Original</th>
  <th width="18%" align="center">Cod. Alternativo</th>
  <th width="49%" align="center"> Nombre 
</th>
  <th width="4%" align="center">U.M.</th>
  <th width="4%" align="center">Cant.</th>
  <th width="2%" align="center">&nbsp;</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
	
	

		$ImprimirDetalle = true;
		
	if($ModalidadIngresoId=="MIN-10001"){
?>
	
    <?php

/*SesionObjeto-FichaAccionMantenimiento
Parametro1 = FaaId
Parametro2 = 
Parametro3 = PmtId
Parametro4 = FaaAccion
Parametro5 = FaaTiempoCreacion
Parametro6 = FaaTiempoModificacion
Parametro7 = FaaNivel
Parametro8 = FaaVerificar1
Parametro9 = FaaVerificar2
Parametro10 = FaaEstado

Parametro11 = FapId
Parametro12 = ProId
Parametro13 = ProNombre
Parametro14 = FapVerificar1
Parametro15 = FapVerificar2
Parametro16 = UmeId
Parametro17 = FapTiempoCreacion
Parametro18 = FapTiempoModificacion
Parametro19 = FapCantidad
Parametro20 = FapCantidadReal	
Parametro21 = RtiId
Parametro22 = UmeNombre
Parametro23 = UmeIdOrigen
Parametro24 = FapEstado*/	

	if(!empty($ArrFichaAccionMantenimientos)){
		foreach($ArrFichaAccionMantenimientos as $DatFichaAccionMantenimiento){
			
			if($DatFichaAccionMantenimiento->Parametro11 == $DatFichaAccionProducto->Parametro1){
				$ImprimirDetalle = false;
				break;
			}
		}
	}
	?>
    
<?php
}	



	if($DatFichaAccionProducto->Parametro14 == 2 and $ImprimirDetalle){
	
		$OpcAccion2 = "";
		$OpcAccion4 = "";

				
			
?>
<tr>
<td align="left" valign="top">
<input style="visibility:hidden;" checked="checked" etiqueta="producto" type="checkbox" name="CmpFichaAccionProductoSigla_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item?>" id="CmpFichaAccionProductoSigla_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" />
<?php echo $c;?></td>
<td align="left" valign="top">


                    <?php
                
                    switch($DatFichaAccionProducto->Parametro16){
                
                        case "C":
                            $OpcAccion2 = 'selected="selected"';
                        break;
                        
                        case "X":
                            $OpcAccion4 = 'selected="selected"';						
                        break;
                    }
                    ?>

             
        
<select  name="CmpFichaAccionProductoAccion_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" id="CmpFichaAccionProductoAccion_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" <?php echo ($POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2)?'disabled="disabled"':'';?>    >
<option value="X" <?php echo $OpcAccion4;?>>X</option>
<option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
</select>
    
    

</td>
<td align="left" valign="top"><input   name="CmpFichaAccionProductoCodigoOriginal_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" type="text" class="<?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2 )?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>" id="CmpFichaAccionProductoCodigoOriginal_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="<?php echo $DatFichaAccionProducto->Parametro17;?>" size="20" maxlength="20"  readonly="readonly"  /></td>
<td align="left" valign="top"><input class="<?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2 )?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  readonly="readonly"   name="CmpFichaAccionProductoCodigoAlternativo_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" type="text" id="CmpFichaAccionProductoCodigoAlternativo_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="<?php echo $DatFichaAccionProducto->Parametro18;?>" size="30"  /></td>
<td align="left" valign="top">

  
<input class="<?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2 )?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  readonly="readonly"   name="CmpFichaAccionProductoNombre_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" type="text" id="CmpFichaAccionProductoNombre_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="<?php echo $DatFichaAccionProducto->Parametro3;?>" size="30"  />
  
</td>
<td align="left" valign="top">

<?php

//deb($DatFichaAccionProducto->Parametro11);


$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$DatFichaAccionProducto->Parametro11);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
?>


<select <?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2)?'disabled="disabled"':'';?>  class="<?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2   )?'EstFormularioCajaDeshabilitada':(($DatFichaAccionProducto->Parametro16=="C" and (empty($DatFichaAccionProducto->Parametro6)) and !empty($DatFichaAccionProducto->Parametro2) )?'EstFormularioCajaRevisar':'EstFormularioCaja')?>" name="CmpFichaAccionProductoUnidadMedida_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" id="CmpFichaAccionProductoUnidadMedida_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>">

<option value="">-</option>
<?php
foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
?>
<option <?php echo (($DatFichaAccionProducto->Parametro6==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
<?php	
}
?>
</select>

</td>
<td align="left" valign="top">




<input class="<?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar == 2 or ($DatFichaAccionProducto->Parametro5 == 2 and !empty($DatFichaAccionProducto->Parametro5)) )?'EstFormularioCajaDeshabilitada':(($DatFichaAccionProducto->Parametro16 == "C" and (empty($DatFichaAccionProducto->Parametro9) or $DatFichaAccionProducto->Parametro9 == "0.00" ) and !empty($DatFichaAccionProducto->Parametro2) )?'EstFormularioCajaRevisar':'EstFormularioCaja')?>" <?php echo ($DatFichaAccionProducto->Parametro16<>"C" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2)?'readonly="readonly"':'';?> name="CmpFichaAccionProductoCantidad_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" type="text"  id="CmpFichaAccionProductoCantidad_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="<?php echo number_format($DatFichaAccionProducto->Parametro9,2,'.','');?>" size="5" maxlength="10" />

</td>
<td align="left" valign="top">

<input <?php echo ($DatFichaAccionProducto->Parametro4==1)?'checked="checked"':'';?> <?php echo ($DatFichaAccionProducto->Parametro16=="X" or $POST_Editar==2 or $DatFichaAccionProducto->Parametro5 == 2 )?'disabled="disabled"':'';?> type="checkbox" name="CmpFichaAccionProducto_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" id="CmpFichaAccionProducto_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="1" />

</td>
</tr>
<?php
$aux = '';
$c++;
	}
}




?>
</tbody>
</table>
<br />
<?php
}
?>




