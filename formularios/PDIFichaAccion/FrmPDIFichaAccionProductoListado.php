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
$ModalidadIngresoId = $_POST['ModalidadIngresoId'];

session_start();
if (!isset($_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

	
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
//Parmaetro17 = ProCodigoOriginal,
//Parmaetro18 = ProCodigoAlternativo
	
$RepFichaAccionProducto = $_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrFichaAccionProductos = $RepFichaAccionProducto['Datos'];

$RepFichaAccionMantenimiento = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrFichaAccionMantenimientos = $RepFichaAccionMantenimiento['Datos'];


?>

  
    <?php
    if(empty($ArrFichaAccionProductos)){
    ?>
    No se encontraron elementos
    <?php
    }else{
    ?>
  
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="11%" align="center">Cod. Original</th>
      <th width="11%" align="center">Cod. Alternativo</th>
      <th width="61%" align="center"> Nombre </th>
      <th width="4%" align="center">U.M.</th>
      <th width="4%" align="center">Cant.</th>
      <th width="2%" align="center">&nbsp;</th>
      <th colspan="2" align="center"> Acc.</th>
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
    
		/*
		SesionObjeto-FichaAccionMantenimiento
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
		Parametro24 = FapEstado
		*/	
		
			if(!empty($ArrFichaAccionMantenimientos)){
				foreach($ArrFichaAccionMantenimientos as $DatFichaAccionMantenimiento){
		
					if(!empty($DatFichaAccionMantenimiento->Parametro11) ){
						
						//deb($DatFichaAccionMantenimiento->Parametro11." - ".$DatFichaAccionProducto->Parametro1);
						if($DatFichaAccionMantenimiento->Parametro11 == $DatFichaAccionProducto->Parametro1){
							$ImprimirDetalle = false;
							break;
						}
						
					}
					
				}
			}

        ?>
    
<?php
		}	
		//deb($ImprimirDetalle);
		
		
        //if($DatFichaAccionProducto->Parametro14==1 and $ImprimirDetalle){
		if($ImprimirDetalle){
            
    ?>
    
    
    <tr>
    <td align="left" valign="top"><?php echo $c;?></td>
    <td align="left" valign="top"><?php echo $DatFichaAccionProducto->Parametro17;?></td>
    <td align="left" valign="top"><?php echo $DatFichaAccionProducto->Parametro18;?></td>
    <td align="left" valign="top">
      <?php echo $DatFichaAccionProducto->Parametro3;?></td>
    <td align="left" valign="top"><?php echo $DatFichaAccionProducto->Parametro12;?></td>
    <td align="left" valign="top"><?php echo number_format($DatFichaAccionProducto->Parametro9,2,'.','');?></td>
    <td align="left" valign="top">
    
    
    <input type="checkbox" <?php //echo $aux;?> checked="checked"  disabled="disabled" name="CmpFichaAccionProducto_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" id="CmpFichaAccionProducto_<?php echo $ModalidadIngreso.$DatFichaAccionProducto->Item;?>" value="1" />
    
    </td>
    <td width="2%" align="left" valign="top">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      
      <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionProductoEscoger('<?php echo $DatFichaAccionProducto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      
      <?php
    }
    ?>
    
      
      
      
    
    </td>
    <td width="3%" align="left" valign="top">
        <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaAccionProductoEliminar('<?php echo $DatFichaAccionProducto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
    
    </td>
    </tr>
    <?php
            
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







