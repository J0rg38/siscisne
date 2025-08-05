<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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
$POST_RecibirEditar = $_POST['RecibirEditar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsMantenimientoTarea.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsMantenimientoTarea = new ClsMantenimientoTarea();
			
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

Parametro25 = FiaId
*/



//deb($ArrSesionObjetos);

//VARIABLES
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_VehiculoAnoFabricacion = $_POST['VehiculoAnoFabricacion'];

$POST_VehiculoKilometraje = $_POST['VehiculoKilometraje'];
$POST_VehiculoMantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
$POST_MantenimientoLlenadoAutomatico = $_POST['MantenimientoLlenadoAutomatico'];

//MENSAJES

//deb($ArrSesionObjetos);
//deb($_SESSION['FichaAccionAux']);
				
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
	
	Parametro25 = FiaId
	*/

//$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
//$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//$SesionObjetosTotal = $RepSesionObjetos['Total'];
//$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
	
//deb($ArrSesionObjetos);

//$ResMantenimientoTarea = $InsMantenimientoTarea->MtdObtenerMantenimientoTareas(NULL,NULL,NULL,NULL,NULL,$POST_VehiculoModelo,$POST_VehiculoMantenimientoKilometraje);
//$ArrMantenimientoTareas = $ResMantenimientoTarea['Datos'];
//
//$ArrProductosPredeterminados = array(
//
//array("FOCO DE FARO","PMT-10065","UME-10007"),
//array("FOCO LAGRIMA","PMT-10066","UME-10007"),
//array("FOCO 1 CONTACTO","PMT-10067","UME-10007"),
//array("FOCO 2 CONTACTO","PMT-10068","UME-10007"),
//
//
//	array("ACEITE MOBIL SUPER 2000","PMT-10000","UME-10007"),//Aceite de motor
//	
//
//	array("FILTRO DE ACEITE","PMT-10001","UME-10007"),//Filtro de aceite
//	array("FILTRO DE AIRE","PMT-10002","UME-10007"),//Filtro de aire del motor
//	array("BUJIA","PMT-10003","UME-10007"),//Bujias
//
//	array("FAJA DE DISTRIBUCION","PMT-10005","UME-10007"),//	Fajas y correas accesorias
//	array("FILTRO DE COMBUSTIBLE","PMT-10039","UME-10007"),//	Filtro de combustible integrado a la bomba
//	array("CADENA DE DISTRIBUCION","PMT-10040","UME-10007"),//	Cadena de distribución
//	array("EMPAQUE CARTER","PMT-10057","UME-10007"),//	Empaque de tapón de cárter
////	array("ACEITE MOBIL SUPER 1000","PMT-10009","UME-10002"),//	Aceite de caja de transmisión mecánica
//	array("MOBIL ATF 220","PMT-10009","UME-10002"),//	Aceite de caja de transmisión mecánica
//
//	array("DISCO DE FRENO","PMT-10058","UME-10007"),//	Estado de frenos de disco
//	array("TAMBOR DE FRENO","PMT-10059","UME-10007"),// Estado de frenos de tambor
//
//	array("AMORTIGUADOR DELANTERO LH","PMT-10060","UME-10007"),// Suspensión delantera / amortiguador RH
//	array("AMORTIGUADOR DELANTERO RH","PMT-10061","UME-10007"),// Suspensión delantera / amortiguador LH
//	array("AMORTIGUADOR POSTERIOR","PMT-10062","UME-10007"),// Suspensión posterior / amortiguador RH y LH
//	array("ROTULA DE SUSPENSIÓN RH","PMT-10063","UME-10007"),// Suspensión delantera / rotula RH
//	array("ROTULA DE SUSPENSIÓN LH","PMT-10064","UME-10007"),//  Suspensión delantera / rotula LH
//
//	array("FILTRO DE AIRE (AIRE ACONDICIONADO)","PMT-10011","UME-10007"),//  Filtro de cabina (si aplica)
//	array("REFRIGERANTE VERDE PRESTONE","PMT-10014","UME-10002"),//  Refrigerante de motor
////	array("LIQUIDO DE FRENO DOT 4","PMT-10017","UME-10002"),//  Refrigerante de frenos
//	array("LIQUIDO DE FRENO DOT 4","PMT-10017","UME-10007"),//  Refrigerante de frenos
//	
//	array("ACEITE MOBIL DELVAC MX","PMT-11066","UME-10007"),//ACEITE DE MOTOR 15W40
//	array("FILTRO DE ACEITE","PMT-11067","UME-10007"),//FILTRO DE ACEITE DE MOTOR
//	array("ARANDELA DE CARTER","PMT-11068","UME-10007"),//ARANDELA DE CARTER
//	array("FILTRO SEDIMENTADOR COMBUSTIBLE","PMT-11071","UME-10007"),//FILTRO DE AIRE
//	
//	array("FILTRO DE COMBUSTIBLE","PMT-11075","UME-10007"),//FILTRO DE COMBUSTIBLE
// 
//	array("LIQUIDO REFRIGERANTE RADIADOR","PMT-11084","UME-10007"),//LIQUIDO REFRIGERANTE RADIADOR
//	array("LIQUIDO DE FRENO","PMT-11097","UME-10007"),//LIQUIDO DE FRENO
//	array("LIQUIDO DIRECCION HIDRAULICA MOBIL","PMT-11103","UME-10007"),//LIQUIDO DE FRENO
//	array("FILTRO DE COMBUSTIBLE","PMT-10004","UME-10007")
//
//
//
//
//
////LIQUIDO DIRECCION HIDRAULICA MOBIL 	
//
//); 
	
//deb($POST_MantenimientoLlenadoAutomatico);	

//$POST_MantenimientoLlenadoAutomatico = 2;



//$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
//$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//$SesionObjetosTotal = $RepSesionObjetos['Total'];
//$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//deb($ArrSesionObjetos);

?>

<?php
//echo $SesionObjetosTotal;
?>
<?php
if(!empty($POST_VehiculoModelo) and !empty($POST_VehiculoMantenimientoKilometraje)){
?>



<?php
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

//MtdObtenerPlanMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL)
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

//deb($ArrPlanMantenimientos);
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$Kilometraje = $POST_VehiculoMantenimientoKilometraje;
?>

<?php
if(!empty($InsPlanMantenimiento->PmaId)){
	
		
?>

<input type="hidden" value="<?php echo $InsPlanMantenimiento->PmaId;?>" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId" />

<a href="javascript:FncPlanMantenimientoVer();">
[Ver Plan de Mantenimiento]
</a>

	<?php
	
	switch($InsPlanMantenimiento->VmaId){

		default:
		//case "VMA-10017"://CHEVROLET
	?>
 

<?php
			
////				
////	/*
////	SesionObjeto-FichaAccionMantenimiento
////	Parametro1 = FaaId
////	Parametro2 = 
////	Parametro3 = PmtId
////	Parametro4 = FaaAccion
////	Parametro5 = FaaTiempoCreacion
////	Parametro6 = FaaTiempoModificacion
////	Parametro7 = FaaNivel
////	Parametro8 = FaaVerificar1
////	Parametro9 = FaaVerificar2
////	Parametro10 = FaaEstado
////	
////	Parametro11 = FapId
////	Parametro12 = ProId
////	Parametro13 = ProNombre
////	Parametro14 = FapVerificar1
////	Parametro15 = FapVerificar2
////	Parametro16 = UmeId
////	Parametro17 = FapTiempoCreacion
////	Parametro18 = FapTiempoModificacion
////	Parametro19 = FapCantidad
////	Parametro20 = FapCantidadReal	
////	Parametro21 = RtiId
////	Parametro22 = UmeNombre
////	Parametro23 = UmeIdOrigen
////	Parametro24 = FapEstado
////	
////	Parametro25 = FiaId
////	*/				
////			if(!empty($ProductoId)){
////				//deb($InsFichaAccionMantenimiento->Parametro12);
////				if(empty($InsFichaAccionMantenimiento->Parametro12)){
////					
////					$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($InsFichaAccionMantenimiento->Item,1,
////					$InsFichaAccionMantenimiento->Parametro1,
////					NULL,
////					$InsFichaAccionMantenimiento->Parametro3,
////					$InsFichaAccionMantenimiento->Parametro4,
////					$InsFichaAccionMantenimiento->Parametro5,
////					date("d/m/Y H:i:s"),
////					$InsFichaAccionMantenimiento->Parametro7,
////					$InsFichaAccionMantenimiento->Parametro8,
////					$InsFichaAccionMantenimiento->Parametro9,
////					$InsFichaAccionMantenimiento->Parametro10,
////					
////					NULL,
////					$ProductoId,
////					$ProductoNombre,
////					2,
////					1,
////					$ProductoUnidadMedida,
////					date("d/m/Y H:i:s"),
////					date("d/m/Y H:i:s"),
////					$ProductoCantidad,
////					0,
////					$ProductoTipo,
////					$ProductoUnidadMedidaNombre,
////					$ProductoUnidadMedidaOrigen,
////					2,
////					$InsFichaAccionMantenimiento->Parametro25);
////					
////					
////				}
////				
////			}	
////
////		}
////
////	}
//
//}
?>

<?php

$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>





	<table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          <tr>
            <td width="4">&nbsp;</td>
            <td colspan="6"><input type="hidden" name="CmpPlanMantenimiento" id="CmpPlanMantenimiento" value="<?php echo $InsPlanMantenimiento->PmaId;?>" /></td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="75" align="left" valign="top">Marca:              </td>
            <td width="172" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?></td>
            <td width="79" align="left">Modelo:              </td>
            <td width="211" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
            <td width="75" align="left" valign="top"><!--Version--></td>
            <td width="277" align="left">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
           
<?php
//deb($InsPlanMantenimiento->PmaChevroletKilometrajes);	
//foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $i => $Kilometro){
//	echo $Kilometro;
//	echo "-";
//	echo $i;
//	echo "<br>";	
//}
?>
            
	<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
		  <td align="center" >Plan Mant.</td>
			

			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
            <?php if($Kilometraje==$DatKilometro['km']){?>
                <td align="center" ><?php echo $DatKilometroEtiqueta;?> km</td>
                <td align="center" >&nbsp;</td>
                <td align="center" >Cod. Original</td>
                <td align="center" >Nombre</td>
                <td align="center" >U.M.</td>
                <td align="center" >Cantidad</td>
                <td align="center" >Realizado</td>
                <td align="center" >&nbsp;</td>
            <?php	}?>
            <?php	
            }
            ?>
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
					
	//	$OpcAccion1 = '';
//		$OpcAccion2 = '';
//		$OpcAccion3 = '';
//		$OpcAccion4 = '';
							
		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
					
?>


<tr>
	<td colspan="26" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
</tr>                
    				
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
?>

<?php
$PlanMantenimientoDetalleId = '';
$PlanMantenimientoDetalleAccion = '';
$PlanMantenimientoDetalleNivel = '';
$PlanMantenimientoDetalleVerificar1 = '';

$FichaAccionProductoId = '';
$FichaAccionProductoVerificar2 = '';

$ProductoId = '';
$ProductoCantidad = 0;
$ProductoUnidadMedida = '';
$ProductoCodigoOriginal = '';
$ProductoNombre = '';
$ProductoTipoId = '';

$OpcAccion1 = '';
$OpcAccion2 = '';
$OpcAccion3 = '';
$OpcAccion4 = '';
?>

	<?php
    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
        
        if($Kilometraje == $DatKilometro['km']){

            $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
            $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	

        }
        
    }
    ?>
                
	<?php
	if(!empty($PlanMantenimientoDetalleAccion)){
	?>
	<tr>
	  <td class="EstPlanMantenimientoTarea">
	    
	    <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
        
   <?php echo $DatPlanMantenimientoTarea->PmtNombre;?></td>
	  <td align="center"   >

<?php
	  
switch($PlanMantenimientoDetalleAccion){
	
	case "I":
	?>
    Inspeccionar
    <?php
	break;
	
	case "C":
		?>
    Cambiar
    <?php
	break;
	
	case "R":
		?>
    Realizar
    <?php				
	break;
	
	case "X":
		?>
    X
    <?php						
	break;
	
	case "U":
		?>
    Agregar
    <?php						
	break;
	
	case "P":
		?>
    Consultivo
    <?php					
	break;
	
}

?>
      
      
      </td>
		

			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                <?php
                if($Kilometraje == $DatKilometro['km']){
					
					  
                ?>
                
                <td align="center"   >
                
                
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
                    if(!empty($ArrSesionObjetos)){	
					
                        foreach($ArrSesionObjetos as $DatSesionObjeto){

						
$PlanMantenimientoDetalleId = '';
$PlanMantenimientoDetalleAccion = '';
$PlanMantenimientoDetalleNivel = '';
$PlanMantenimientoDetalleVerificar1 = '';

$FichaAccionProductoId = '';
$FichaAccionProductoVerificar2 = '';

$ProductoId = '';
$ProductoCantidad = 0;
$ProductoUnidadMedida = '';
$ProductoCodigoOriginal = '';
$ProductoNombre = '';
$ProductoTipoId = '';

$OpcAccion1 = '';
$OpcAccion2 = '';
$OpcAccion3 = '';
$OpcAccion4 = '';
$OpcAccion5 = '';
						//deb("xxx");
                            if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){

								$PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
								$PlanMantenimientoDetalleNivel = $DatSesionObjeto->Parametro7;
								$PlanMantenimientoDetalleVerificar1 = $DatSesionObjeto->Parametro8;
								
								$FichaAccionProductoId = $DatSesionObjeto->Parametro11;
								$FichaAccionProductoVerificar2 = $DatSesionObjeto->Parametro15;
								//$DatSesionObjeto->Parametro9;
								$ProductoId = $DatSesionObjeto->Parametro12;
								$ProductoCantidad = $DatSesionObjeto->Parametro19;
								$ProductoUnidadMedida = $DatSesionObjeto->Parametro16;
								$ProductoCodigoOriginal = $DatSesionObjeto->Parametro26;
								$ProductoNombre = $DatSesionObjeto->Parametro13;
								$ProductoTipoId = $DatSesionObjeto->Parametro21;
								//deb($DatSesionObjeto->Parametro13);
                                break;
                            }					
                        }
                    }
					
                    ?>

                    <?php
                
                    switch($PlanMantenimientoDetalleAccion){
                
                        case "I":
                            $OpcAccion1 = 'selected="selected"';
                        break;
                        
                        case "C":
                            $OpcAccion2 = 'selected="selected"';
                        break;
                        
                        case "R":
                            $OpcAccion3 = 'selected="selected"';					
                        break;
                        
                        case "X":
                            $OpcAccion4 = 'selected="selected"';						
                        break;
						
						case "U":
					$OpcAccion5 = 'selected="selected"';						
				break;

case "P":
					$OpcAccion6 = 'selected="selected"';						
				break;
				
				
            }
                    ?>

<?php
	if(empty($PlanMantenimientoDetalleNivel)){
		$PlanMantenimientoDetalleNivel = (!empty($OpcAccion4))?'2':'1';
	}
	
	if(empty($PlanMantenimientoDetalleVerificar1)){
		$PlanMantenimientoDetalleVerificar1 = 2;
	}
?>



<select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ( ($POST_Editar == 2 ) )?'disabled="disabled"':'';?>  >
<option value="X" <?php echo $OpcAccion4;?>>X</option>
<option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
<option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
<option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
<option value="U" <?php echo $OpcAccion5;?>>Agregar</option>
<option value="P" <?php echo $OpcAccion6;?>>Consultivo</option>
            </select>
  <!--  disabled="disabled"-->

<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />

<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />


<input size="2" type="hidden" name="CmpFichaAccionProductoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionProductoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionProductoVerificar2;?>" />


                </td>
                <td align="right"   >

<?php

if($POST_Editar==1 ){
?>
	<a <?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 )?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>FichaAccionProductoNuevo" href="javascript:FncFichaAccionProductoNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
<?php
}
?>
				</td>
                <td align="right"   >
                
                <!--<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" type="text" class="<?php echo (($FichaAccionMantenimientoAccion<>"C" and $FichaAccionMantenimientoAccion<>"U") or $POST_Editar==2 )?'EstFormularioCajaDeshabilitado':'EstFormularioCaja'?>"   <?php echo (($FichaAccionMantenimientoAccion<>"C" and $FichaAccionMantenimientoAccion<>"U") or $POST_Editar==2 )?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" size="10" maxlength="20"  value="<?php echo $ProductoCodigoOriginal;?>"    />-->
                
                
                <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" type="text" class="<?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2))  )?'EstFormularioCajaDeshabilitado':'EstFormularioCaja'?>"   <?php echo (($FichaAccionMantenimientoAccion<>"C" and $FichaAccionMantenimientoAccion<>"U") or $POST_Editar==2 )?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" size="10" maxlength="20"  value="<?php echo $ProductoCodigoOriginal;?>"    />
                
                
                </td>
                <td align="right"   >
                
<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="<?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2))  )?'EstFormularioCajaDeshabilitado':'EstFormularioCaja'?>"   <?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="30" value="<?php echo $ProductoNombre;?>" />


</td>
                <td align="right"   >
                
<?php
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
?>

<select  class="<?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'EstFormularioCombo':((($PlanMantenimientoDetalleAccion=="C" or $PlanMantenimientoDetalleAccion=="U") and (empty($ProductoUnidadMedida)) and !empty($ProductoId) )?'EstFormularioCajaRevisar':'EstFormularioCombo')?>" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" 
 <?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'disabled="disabled"':'';?> >

<option value="">Escoja una opcion</option>

<?php
if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
?>

	<?php
    foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
    ?>
		<option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>    
	
    <?php	
    }
    ?>
<?php
}
?>

</select>



                
                
                </td>
                <td align="right"   >

<?php //deb($PlanMantenimientoDetalleAccion." - ".$ProductoCantidad." - ".$ProductoId);?>

<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'EstFormularioCajaDeshabilitado':((($PlanMantenimientoDetalleAccion=="C" or $PlanMantenimientoDetalleAccion=="U") and (empty($ProductoCantidad) or $ProductoCantidad == "0.00" ) and !empty($ProductoId) )?'EstFormularioCajaRevisar':'EstFormularioCaja')?>" <?php echo (($PlanMantenimientoDetalleAccion<>"C" and $PlanMantenimientoDetalleAccion<>"U") or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="5" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />

<input type="hidden" name="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $FichaAccionProductoId;?>"  />


                <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div></td>
                <td align="left"   >
                
                 <input   title="<?php echo $FichaAccionProductoId;?>" type="checkbox" <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"   <?php //echo ($PlanMantenimientoDetalleAccion=="X" )?'disabled="disabled"':'';?> <?php echo ($POST_RecibirEditar=="2" )?'disabled="disabled"':'';?>   />
            
            </td>
                <td align="left"   >
           
<!--  <input  style="visibility:hidden;" title="<?php echo $FichaAccionProductoId;?>" type="checkbox" <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"   <?php //echo ($PlanMantenimientoDetalleAccion=="X" )?'disabled="disabled"':'';?> <?php echo ($POST_RecibirEditar=="2" )?'disabled="disabled"':'';?>   />
     -->             
                  
                  <?php
				if($_SESSION['MysqlDeb'] == 1){
				?>
                  <span style="color:#F8F8F8;" >(<?php echo $DatPlanMantenimientoTarea->PmtId?>) / (<?php echo $PlanMantenimientoDetalleId;?>) / (<?php echo $FichaAccionProductoId;?>)</span>
                  <?php	
				}
				?>          </td>
                <?php
                }
                ?>
                
			<?php	
			}
			?>
</tr>
	<?php
	}
	?>
		<?php			
		}
		?>
               
<?php
}
?>  

              
            </table></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="center"><b>I:</b> Inspección/ajuste 
              <b>C:</b> Cambio o reemplazo 
              <b>R:</b> Realizar 
              <b>U:</b> Agregar
               
              <b>P:</b> Consultivo </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top">
            
            <?php echo $InsPlanMantenimiento->PmaNota;?>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>

	<?php
		break;
		
		case "VMA-10018"://ISUZU
	?>
    
    






<?php
//if($POST_MantenimientoLlenadoAutomatico==1){
//	
//	//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) 
//	
//	$InsTareaProducto = new ClsTareaProducto();
//	//$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$POST_VehiculoMantenimientoKilometraje);
//	$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajes[$POST_VehiculoMantenimientoKilometraje]['eq']);
//	
//	$ArrTareaProductos = $ResTareaProducto['Datos'];
//
//	//deb($ArrTareaProductos);
//
//	//foreach($ArrProductosPredeterminados as $DatProductoPredeterminado){
//	foreach($ArrTareaProductos as $DatTareaProducto){
//		
//		$ProductoId = "";
//		$ProductoCodigoOriginal = "";
//		$ProductoNombre = "";
//		$ProductoUnidadMedida = "";
//		$ProductoUnidadMedidaNombre = "";
//		$ProductoUnidadMedidaOrigen = "";
//		$ProductoTipo = "";
//		$ProductoCantidad = 0;
//
//		$RepFichaAccionMantenimiento = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdVerificarExisteSesionObjeto2($DatTareaProducto->PmtId);
//		$ExisteFichaAccionMantenimiento = $RepFichaAccionMantenimiento['Existe'];
//		$InsFichaAccionMantenimiento = $RepFichaAccionMantenimiento['Datos'];
//		
//
//		if($ExisteFichaAccionMantenimiento){
//
//			
//				$InsProducto->ProId = $DatTareaProducto->ProId;
//				$InsProducto->MtdObtenerProducto(false);
//
//				$ProductoId = $DatTareaProducto->ProId;
//				$ProductoCodigoOriginal = $DatTareaProducto->ProCodigoOriginal;
//				$ProductoNombre = $DatTareaProducto->ProNombre;
//				$ProductoUnidadMedida = $DatTareaProducto->UmeId;
//				$ProductoUnidadMedidaNombre = $DatTareaProducto->UmeNombre;
//				$ProductoUnidadMedidaOrigen = $InsProducto->UmeId;
//				$ProductoTipo = $InsProducto->RtiId;
//				$ProductoCantidad = $DatTareaProducto->TprCantidad;		
//				
//				
//				
//				
//	/*
//	SesionObjeto-FichaAccionMantenimiento
//	Parametro1 = FaaId
//	Parametro2 = 
//	Parametro3 = PmtId
//	Parametro4 = FaaAccion
//	Parametro5 = FaaTiempoCreacion
//	Parametro6 = FaaTiempoModificacion
//	Parametro7 = FaaNivel
//	Parametro8 = FaaVerificar1
//	Parametro9 = FaaVerificar2
//	Parametro10 = FaaEstado
//	
//	Parametro11 = FapId
//	Parametro12 = ProId
//	Parametro13 = ProNombre
//	Parametro14 = FapVerificar1
//	Parametro15 = FapVerificar2
//	Parametro16 = UmeId
//	Parametro17 = FapTiempoCreacion
//	Parametro18 = FapTiempoModificacion
//	Parametro19 = FapCantidad
//	Parametro20 = FapCantidadReal	
//	Parametro21 = RtiId
//	Parametro22 = UmeNombre
//	Parametro23 = UmeIdOrigen
//	Parametro24 = FapEstado
//	
//	Parametro25 = FiaId
//	*/				
//			if(!empty($ProductoId)){
//				//deb($InsFichaAccionMantenimiento->Parametro12);
//				if(empty($InsFichaAccionMantenimiento->Parametro12)){
//					
//					$_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($InsFichaAccionMantenimiento->Item,1,
//					$InsFichaAccionMantenimiento->Parametro1,
//					NULL,
//					$InsFichaAccionMantenimiento->Parametro3,
//					$InsFichaAccionMantenimiento->Parametro4,
//					$InsFichaAccionMantenimiento->Parametro5,
//					date("d/m/Y H:i:s"),
//					$InsFichaAccionMantenimiento->Parametro7,
//					$InsFichaAccionMantenimiento->Parametro8,
//					$InsFichaAccionMantenimiento->Parametro9,
//					$InsFichaAccionMantenimiento->Parametro10,
//					
//					NULL,
//					$ProductoId,
//					$ProductoNombre,
//					2,
//					1,
//					$ProductoUnidadMedida,
//					date("d/m/Y H:i:s"),
//					date("d/m/Y H:i:s"),
//					$ProductoCantidad,
//					0,
//					$ProductoTipo,
//					$ProductoUnidadMedidaNombre,
//					$ProductoUnidadMedidaOrigen,
//					2,
//					$InsFichaAccionMantenimiento->Parametro25,
//					$ProductoCodigoOriginal);
//					
//					
//				}
//				
//			}	
//
//		}
//
//	}
//
//}
?>

<?php

$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
//deb($ArrSesionObjetos);
?>





    <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          <tr>
            <td width="4">&nbsp;</td>
            <td colspan="6"><input type="hidden" name="CmpPlanMantenimiento" id="CmpPlanMantenimiento" value="<?php echo $InsPlanMantenimiento->PmaId;?>" /></td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="75" align="left" valign="top">Marca:              </td>
            <td width="172" align="left"><?php echo $InsPlanMantenimiento->VmaNombre;?></td>
            <td width="79" align="left">Modelo:              </td>
            <td width="211" align="left"><?php echo $InsPlanMantenimiento->VmoNombre;?></td>
            <td width="75" align="left" valign="top">&nbsp;</td>
            <td width="277" align="left">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            

            
	<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
		  <td align="center" >Plan Mant.</td>
			

			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
				<?php if($Kilometraje==$DatKilometro['km']){?>
                
                    <td align="center" ><?php echo $DatKilometroEtiqueta;?> km</td>
                    <td align="center" >&nbsp;</td>
                    <td align="center" >Cod. Original</td>
                    <td align="center" >Nombre</td>
                    <td align="center" >U.M.</td>
                    <td align="center" >Cantidad</td>
                    <td align="center" >Realizado</td>
                    <td align="center" >&nbsp;</td>
                <?php	}?>
            <?php	
            }
            ?>
        </tr>
                
<?php
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
					
//		$OpcAccion1 = '';
//		$OpcAccion2 = '';
//		$OpcAccion3 = '';
//		$OpcAccion4 = '';
//		$OpcAccion5 = '';
//		$OpcAccion6 = '';
							
		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
					
?>


<tr>
	<td colspan="26" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
</tr>                
    				
<?php
	foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
?>

	<?php
    $PlanMantenimientoDetalleId = '';
    $PlanMantenimientoDetalleAccion = '';
    $PlanMantenimientoDetalleNivel = '';
    $PlanMantenimientoDetalleVerificar1 = '';
   
    
    $FichaAccionProductoId = '';
	$FichaAccionProductoVerificar2 = '';
    
    $ProductoId = '';
    $ProductoCantidad = '';
    $ProductoUnidadMedida = '';
    $ProductoCodigoOriginal = '';
    $ProductoNombre = '';
    $ProductoTipoId = '';
    
    $OpcAccion1 = '';
    $OpcAccion2 = '';
    $OpcAccion3 = '';
    $OpcAccion4 = '';
    $OpcAccion5 = '';
    $OpcAccion6 = '';
	$OpcAccion7 = '';
    ?>

	<?php
    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
        
        if($Kilometraje == $DatKilometro['km']){
			
            $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
            $PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
            
			//deb($InsPlanMantenimiento->PmaId." - ".$DatKilometro['eq']." - ".$DatPlanMantenimientoSeccion->PmsId." - ".$DatPlanMantenimientoTarea->PmtId);
        }
        
    }
    ?>
                
	<?php
	if(!empty($PlanMantenimientoDetalleAccion)){
	?>

	<tr>
	  <td class="EstPlanMantenimientoTarea">
	    
	    <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" />
        
   <?php echo $DatPlanMantenimientoTarea->PmtNombre;?></td>
	  <td align="center"   >
      
    
      <?php
	  switch($PlanMantenimientoDetalleAccion){
	case "R":
						?>
                        Reemplazar
                        <?php
						break;
						
						case "I":
							?>
                        Inspeccionar
                        <?php
						break;
						
						case "A":
							?>
                        Ajustar
                        <?php				
						break;
						
						case "T":
							?>
                        Apretar
                        <?php					
						break;
						
						case "L":
							?>
                        Lubricar
                        <?php			
						break;
						
						case "U":
							?>
                        Agregar
                        <?php					
						break;
						
						case "X":
							?>
                        X
                        <?php				
						break;
	  }
?>
      
      
      
      </td>
		

			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                <?php
                if($Kilometraje == $DatKilometro['km']){
                ?>
                
                <td align="center"   >
                
                
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
                    if(!empty($ArrSesionObjetos)){	
                        foreach($ArrSesionObjetos as $DatSesionObjeto){
							
    $PlanMantenimientoDetalleId = '';
    $PlanMantenimientoDetalleAccion = '';
    $PlanMantenimientoDetalleNivel = '';
    $PlanMantenimientoDetalleVerificar1 = '';
   
    
    $FichaAccionProductoId = '';
	$FichaAccionProductoVerificar2 = '';
    
    $ProductoId = '';
    $ProductoCantidad = '';
    $ProductoUnidadMedida = '';
    $ProductoCodigoOriginal = '';
    $ProductoNombre = '';
    $ProductoTipoId = '';
    
    $OpcAccion1 = '';
    $OpcAccion2 = '';
    $OpcAccion3 = '';
    $OpcAccion4 = '';
    $OpcAccion5 = '';
    $OpcAccion6 = '';
	$OpcAccion7 = '';						
                            if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){

								$PlanMantenimientoDetalleId = $DatSesionObjeto->Parametro1;
                                $PlanMantenimientoDetalleAccion = $DatSesionObjeto->Parametro4;
								$PlanMantenimientoDetalleNivel = $DatSesionObjeto->Parametro7;
								$PlanMantenimientoDetalleVerificar1 = $DatSesionObjeto->Parametro8;
								
								
								$FichaAccionProductoId = $DatSesionObjeto->Parametro11;
								$FichaAccionProductoVerificar2 = $DatSesionObjeto->Parametro15;
								
								$ProductoId = $DatSesionObjeto->Parametro12;
								$ProductoCantidad = $DatSesionObjeto->Parametro19;
								$ProductoUnidadMedida = $DatSesionObjeto->Parametro16;
								$ProductoCodigoOriginal = $DatSesionObjeto->Parametro26;
								$ProductoNombre = $DatSesionObjeto->Parametro13;
								$ProductoTipoId = $DatSesionObjeto->Parametro21;
								
                                break;
                            }					
                        }
                    }
					
                    ?>

                    <?php
                
                    switch($PlanMantenimientoDetalleAccion){
						
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
						
						case "X":
							$OpcAccion4 = 'selected="selected"';						
						break;
                    }
                    ?>

<?php
	if(empty($PlanMantenimientoDetalleNivel)){
		$PlanMantenimientoDetalleNivel = (!empty($OpcAccion4))?'2':'1';
	}
	
	if(empty($PlanMantenimientoDetalleVerificar1)){
		$PlanMantenimientoDetalleVerificar1 = 2;
	}
?>







    
 <select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ( ($POST_Editar == 2 ) )?'disabled="disabled"':'';?>  >
  <option value="X" <?php echo $OpcAccion4;?>>X</option>

                    <option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
                    <option value="I" <?php echo $OpcAccion2;?>>Inspeccionar</option>
                    <option value="A" <?php echo $OpcAccion3;?>>Ajustar</option>
                    <option value="T" <?php echo $OpcAccion5;?>>Apretar</option>
                    <option value="L" <?php echo $OpcAccion6;?>>Lubricar</option>
                    
                    <option value="U" <?php echo $OpcAccion7;?>>Agregar</option>
    </select>
    
<!--    
    <select class="EstFormularioCombo"  name="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ( ($POST_Editar == 2 and $POST_RecibirEditar == 2) )?'disabled="disabled"':'';?> >
    <option value="X" <?php echo $OpcAccion4;?>>X</option>
    <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
    <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
    <option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
    <option value="U" <?php echo $OpcAccion5;?>>Agregar</option>
<option value="P" <?php echo $OpcAccion6;?>>Consultivo</option>
            </select>
    -->
    
    
    

<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleNivel_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleNivel;?>" />

<input size="2" type="hidden" name="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $PlanMantenimientoDetalleId;?>" />


<input size="2" type="hidden" name="CmpFichaAccionProductoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionProductoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionProductoVerificar2;?>" />

                </td>
                <td align="right"   >

<?php
if($POST_Editar==1){
?>
	<a <?php echo ($PlanMantenimientoDetalleAccion<>"R" or $POST_Editar==2 )?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>FichaAccionProductoNuevo" href="javascript:FncFichaAccionProductoNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
<?php
}
?>
				</td>
                <td align="right"   ><input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" type="text" class="<?php echo ($FichaAccionMantenimientoAccion<>"R" or $POST_Editar==2 )?'EstFormularioCajaDeshabilitado':'EstFormularioCaja'?>"   <?php echo ($FichaAccionMantenimientoAccion<>"R" or $POST_Editar==2 )?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" size="10" maxlength="20"  value="<?php echo $ProductoCodigoOriginal;?>"    /></td>
                <td align="right"   >
                
                <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion<>"R" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'EstFormularioCajaDeshabilitado':'EstFormularioCaja'?>"   <?php echo ($PlanMantenimientoDetalleAccion<>"R" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="30" value="<?php echo $ProductoNombre;?>" />
                
                </td>
                <td align="right"   >
                
<?php
$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
?>
<select  class="<?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'EstFormularioCajaDeshabilitado':(($PlanMantenimientoDetalleAccion=="C" and (empty($ProductoUnidadMedida)) and !empty($ProductoId) )?'EstFormularioCajaRevisar':'EstFormularioCombo')?>" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir"  <?php echo ($PlanMantenimientoDetalleAccion<>"R" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'disabled="disabled"':'';?> >
  <option value="">Escoja una opcion</option>
  <?php
if(!empty($ProductoTipoId) || !empty($ProductoUnidadMedida)){
?>
  <?php
    foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUidadMedida){
    ?>
  <option <?php echo (($ProductoUnidadMedida==$DatProductoTipoUidadMedida->UmeId)?'selected="selected"':'');?>   value="<?php echo $DatProductoTipoUidadMedida->UmeId;?>"><?php echo $DatProductoTipoUidadMedida->UmeNombre;?></option>
  <?php	
    }
    ?>
  <?php
}
?>
</select>


                
                
          </td>
                <td align="right"   >
                
                <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" type="text" class="<?php echo ($PlanMantenimientoDetalleAccion<>"C" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'EstFormularioCajaDeshabilitado':(($PlanMantenimientoDetalleAccion=="C" and (empty($ProductoCantidad) or $ProductoCantidad == "0.00" ) and !empty($ProductoId) )?'EstFormularioCajaRevisar':'EstFormularioCaja')?>"   <?php echo ($PlanMantenimientoDetalleAccion<>"R" or $POST_Editar==2 or ($FichaAccionProductoVerificar2==2 and !empty($FichaAccionProductoVerificar2)) )?'readonly="readonly"':'';?>  id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="10" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"  />
                
                
                  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />

<input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />

<input type="hidden" name="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $FichaAccionProductoId;?>"  />


                <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div></td>
                <td align="left"   >
                
                <input   title="<?php echo $FichaAccionProductoId;?>" type="checkbox" <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"   <?php //echo ($PlanMantenimientoDetalleAccion=="X" )?'disabled="disabled"':'';?> <?php echo ($POST_RecibirEditar=="2" )?'disabled="disabled"':'';?>   />
                
                
                </td>
                <td align="left"   >
                  
  <!--<input title="<?php echo $FichaAccionProductoId;?>" type="checkbox" <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"   <?php echo ($PlanMantenimientoDetalleAccion=="X"  or $POST_Editar==2)?'disabled="disabled"':'';?>   />-->
                  
                  
  <!--<input  style="visibility:hidden;" title="<?php echo $FichaAccionProductoId;?>" type="checkbox" <?php echo ($PlanMantenimientoDetalleVerificar1==1)?'checked="checked"':'';?>  name="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoDetalleVerificar1_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="1"   <?php //echo ($PlanMantenimientoDetalleAccion=="X" )?'disabled="disabled"':'';?>  <?php echo ($POST_RecibirEditar=="2" )?'disabled="disabled"':'';?>  />-->
                  
                  
                  <?php
				
				
				if($_SESSION['MysqlDeb'] == 1){
				?>
                  <span style="color:#F8F8F8;" >(<?php echo $DatPlanMantenimientoTarea->PmtId?>) / (<?php echo $PlanMantenimientoDetalleId;?>) / (<?php echo $FichaAccionProductoId;?>)</span>
                  <?php	
				}
				?>          </td>
                <?php
                }
                ?>
                
			<?php	
			}
			?>
</tr>
	<?php
	}
	?>
		<?php			
		}
		?>
               
<?php
}
?>  

              
            </table></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="center"><b>R:</b> Reemplazar <b>I:</b> Inspeccionar , limpiar o reparar según sea necesario <b>A:</b> Ajustar <b>T:</b> Apretar al par de apriete especificado <b>L:</b> Lubricar </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top">
            
            <?php echo $InsPlanMantenimiento->PmaNota;?>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
    <?php
		break;
		
		//default:
		
		case "":
	?>
	No se encontro la MARCA DEL VEHICULO
	<?php
		break;
		
	}
	?>
<?php
}else{
?>
	No se encontro un plan de mantenimiento
<?php	
}
?>      
        
<?php	
}if(empty($POST_VehiculoVersion)){
?>
No se ha encontrado el modelo de vehiculo
<?php	
}elseif(empty($POST_VehiculoMantenimientoKilometraje)){
?>
No se ha encontrado el kilometraje del plan de mantenimiento
<?php	
}
?>

 
