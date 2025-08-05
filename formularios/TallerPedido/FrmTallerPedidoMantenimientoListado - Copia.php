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
$POST_MecanicoAccion = $_POST['MecanicoAccion'];
$POST_Editar = $_POST['Editar'];

session_start();
if (!isset($_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId
//	Parametro27	= AmdCantidadRealAnterior
//	Parametro28 = AmdEstado
//	Parametro29 = AmdReingreso
//	Parametro30 = AlmId
//	Parametro31 = AmdFecha
			//	Parametro33 = AmdFacturado
				//	Parametro34 = AmdCierre

$RepSesionObjetos = $_SESSION['InsTallerPedidoMantenimiento'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
//deb($ArrSesionObjetos);

//VARIABLES
$POST_VehiculoVersion = $_POST['VehiculoVersion'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];
$POST_VehiculoKilometraje = $_POST['VehiculoKilometraje'];
$POST_VehiculoMantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
$POST_PrimerRegistro = $_POST['PrimerRegistro'];
//MENSAJES
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
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

//INSTANCIAS
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
$InsAlmacen = new ClsAlmacen();

//MtdObtenerPlanMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL)
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModelo) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

//deb($ArrPlanMantenimientos);
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$_SESSION['SesionSucursal']);
$ArrAlmacenes = $RepAlmacen['Datos'];


$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

$Kilometraje = $POST_VehiculoMantenimientoKilometraje;

?>

<?php
if(!empty($InsPlanMantenimiento->PmaId)){
?>

	<?php
	switch($InsPlanMantenimiento->VmaId){
		//case "VMA-10017"://CHEVROLET
		default://CHEVROLET
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
            <td width="75" align="left" valign="top"><!--Version:      -->        </td>
            <td width="277" align="left"><?php //echo $InsPlanMantenimiento->VveNombre;?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            

            
	<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
			

			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
				<?php if($Kilometraje==$DatKilometro['km']){?>

          <td align="center" ><?php echo $DatKilometroEtiqueta;?> km</td>
                <td align="center" >&nbsp;</td>
                <td align="center" >Cod. Original</td>
                <td align="center" >&nbsp;</td>
                <td align="center" >Nombre</td>
                <td align="center" >U.M.</td>
                <td align="center" >Cantidad</td>
                <td align="center" >Importe</td>
                <td align="left" >Fecha</td>
          <td align="center" >Almacen</td>
          <td align="center" >Estado</td>
                <td align="center" >&nbsp;</td>

				<?php }?>
            <?php	
            }
            ?>
        </tr>
                
<?php
$MantenimientoTotal = 0;

	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

		$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
		$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
			
?>

		<?php
        if(!empty($ArrPlanMantenimientoTareas)){
        ?>

<tr>
	<td colspan="29" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
</tr>                
			
		<?php
		
		
		foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
		?>

<?php                               

						$AlmacenMovimientoSalidaDetalleId = '';
                        $FichaAccionMantenimientoId = '';

                        $FichaAccionMantenimientoAccion = '';

                        $FichaAccionMantenimientoVerificar1 = '';
                        $FichaAccionMantenimientoVerificar2 = '';
                        $FichaAccionProductoId = '';

                        $ProductoId = '';
						$ProductoPrecio = 0;
                        $ProductoCantidad = 0;
						$ProductoImporte = 0;
						
                        $ProductoUnidadMedida = '';
                        $ProductoNombre = '';
                        $ProductoTipoId = '';
						
						$OpcAccion1 = '';
$OpcAccion2 = '';
$OpcAccion3 = '';
$OpcAccion4 = '';
$OpcAccion5 = '';


						$TallerPedidoDetalleReingreso = '2';
						$TallerPedidoDetalleEstado = '3';
						
						
						$TallerPedidoDetalleAlmacenId = '';
						$TallerPedidoDetalleFecha = '';
						
						$FichaIngresoMantenimientoProductoNombre = '';
						
						$TallerPedidoDetalleFacturado = '2';
						$TallerPedidoDetalleCierre = '2';
						
						
?>

			<?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            
                if($Kilometraje == $DatKilometro['km']){
            
                    $InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
                    $FichaAccionMantenimientoAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
            		
                }

            }
            ?>
                
			<?php
            if(!empty( $FichaAccionMantenimientoAccion) ){
            ?>

        
        <tr>
          <td valign="top" class="EstPlanMantenimientoTarea">
        
                        <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>" modalidad_sigla="<?php echo $ModalidadIngreso;?>" />
        
                        <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
                        
          </td>
            
	  <?php
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
						
						<?php
						if($Kilometraje == $DatKilometro['km']){
						?>

                        <td align="right" valign="top"   >
			<?php

//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId

//	Parametro27 = 
//	Parametro28 = 
//	Parametro29 = 
//	Parametro30 = 

//	Parametro31 = AlmId
//	Parametro32 = AmdFecha
			//	Parametro33 = AmdFacturado
				//	Parametro34 = AmdCierre

                if(!empty($ArrSesionObjetos)){	
                    foreach($ArrSesionObjetos as $DatSesionObjeto){

                        $AlmacenMovimientoSalidaDetalleId = '';
                        $FichaAccionMantenimientoId = '';

                        $FichaAccionMantenimientoAccion = '';

                        $FichaAccionMantenimientoVerificar1 = '';
                        $FichaAccionMantenimientoVerificar2 = '';
                        $FichaAccionProductoId = '';

                        $ProductoId = '';
						$ProductoPrecio = 0;
                        $ProductoCantidad = 0;
						$ProductoImporte = 0;
						
                        $ProductoUnidadMedida = '';
                        $ProductoNombre = '';
                        $ProductoTipoId = '';
						
						$OpcAccion1 = '';
						$OpcAccion2 = '';
						$OpcAccion3 = '';
						$OpcAccion4 = '';
						$OpcAccion5 = '';


						$TallerPedidoDetalleReingreso = '2';
						$TallerPedidoDetalleEstado = '3';
						
						$TallerPedidoDetalleAlmacenId = '';
						$TallerPedidoDetalleFecha = '';
						
						$FichaIngresoMantenimientoProductoNombre = '';
						$TallerPedidoDetalleFacturado = '2';
						$TallerPedidoDetalleCierre = '2';
						$TallerPedidoDetalleCompraOrigen = "";
						
                        if($DatSesionObjeto->Parametro21 == $DatPlanMantenimientoTarea->PmtId){

                            $AlmacenMovimientoSalidaDetalleId = $DatSesionObjeto->Parametro1;

                            $FichaAccionMantenimientoId = $DatSesionObjeto->Parametro20;//
                            $FichaAccionMantenimientoAccion = $DatSesionObjeto->Parametro22;//

                            $FichaAccionMantenimientoVerificar1 = $DatSesionObjeto->Parametro24;//
                            $FichaAccionMantenimientoVerificar2 = $DatSesionObjeto->Parametro25;//
							
                            $FichaAccionProductoId = $DatSesionObjeto->Parametro26;//
							
							//deb($DatSesionObjeto->Parametro26);
							
                            $ProductoId = $DatSesionObjeto->Parametro2;//
							$ProductoPrecio = $DatSesionObjeto->Parametro4;//
                            $ProductoCantidad = $DatSesionObjeto->Parametro5;//
							$ProductoImporte = $DatSesionObjeto->Parametro6;//
							
                            $ProductoUnidadMedida = $DatSesionObjeto->Parametro10;//
                            $ProductoNombre = $DatSesionObjeto->Parametro3;//
                            $ProductoCodigoOriginal = $DatSesionObjeto->Parametro13;
                            $ProductoTipoId = $DatSesionObjeto->Parametro11;//
							
							$TallerPedidoDetalleReingreso = $DatSesionObjeto->Parametro29;//
							$TallerPedidoDetalleEstado = $DatSesionObjeto->Parametro28;//
							
							$FichaIngresoMantenimientoProductoNombre = '';
							
							$TallerPedidoDetalleAlmacenId = $DatSesionObjeto->Parametro31;//
							$TallerPedidoDetalleFecha =  $DatSesionObjeto->Parametro32;//
							
							
							$TallerPedidoDetalleFacturado = (empty($DatSesionObjeto->Parametro33)?2:$DatSesionObjeto->Parametro33);//
							$TallerPedidoDetalleCierre =  (empty($DatSesionObjeto->Parametro34)?2:$DatSesionObjeto->Parametro34);//
							$TallerPedidoDetalleCompraOrigen =  (empty($DatSesionObjeto->Parametro35)?2:$DatSesionObjeto->Parametro35);//
							
//							deb($DatSesionObjeto->Parametro33);
							
							if($POST_PrimerRegistro=="1"){
								$TallerPedidoDetalleEstado = 3;
							}
							
                            break;
                        }					
                    }
                }				
            ?>
            
			<?php
            switch($FichaAccionMantenimientoAccion){
				
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
            if(empty($FichaAccionMantenimientoVerificar1)){
				$FichaAccionMantenimientoVerificar1 = 2;
            }
            ?>

            <input type="hidden" value="<?php echo $FichaAccionMantenimientoAccion;?>" name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" >

           <!-- <select class="EstFormularioCombo" <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>  name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" >-->
           
           
          
            <select class="<?php echo (( $FichaAccionMantenimientoAccion == "C" or $FichaAccionMantenimientoAccion == "U")?'EstFormularioComboResaltado':'EstFormularioCombo')?>" disabled="disabled" name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" >
            <option value="X" <?php echo $OpcAccion4;?>>X</option>
            <option value="I" <?php echo $OpcAccion1;?>>Inspeccionar</option>
            <option value="C" <?php echo $OpcAccion2;?>>Cambiar</option>
			<option value="R" <?php echo $OpcAccion3;?>>Realizar</option>
            <option value="U" <?php echo $OpcAccion5;?>>Agregar</option>
<option value="P" <?php echo $OpcAccion6;?>>Consultivo</option>
            </select>

            <input size="2" type="hidden" name="CmpFichaAccionProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionProductoId;?>" />

            <input size="2" type="hidden" name="CmpFichaAccionMantenimientoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionMantenimientoId;?>" />

            <input name="CmpAlmacenMovimientoSalidaDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" type="hidden" id="CmpAlmacenMovimientoSalidaDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $AlmacenMovimientoSalidaDetalleId;?>" size="10" />

            </td>
            <td align="right" valign="top"   >
            
            <?php			
			//deb($TallerPedidoDetalleFacturado." - ".$TallerPedidoDetalleFacturado);
            if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
            ?>
            
			<a <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoNuevo" href="javascript:FncTallerPedidoDetalleNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>    
            
            <?php
            }
            ?>
            
            </td>
            <td align="left" valign="top"   >
            
            <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" size="10" maxlength="20"  value="<?php echo $ProductoCodigoOriginal;?>"    />
            
          </td>
            <td align="right" valign="top"   >
            
            <?php
            if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
            ?>
                <a <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar" href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatPlanMantenimientoTarea->PmtId?>','<?php echo $ModalidadIngreso;?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            
            <?php
            }
            ?>
            
            </td>
            <td align="right" valign="top"   >
                <?php
			//deb($TallerPedidoDetalleFacturado." - ".$TallerPedidoDetalleFacturado);
				?>
                <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text"   class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="30" value="<?php echo $ProductoNombre;?>"   />
                
      </td>
            <td align="right" valign="top"   >  
            
            <?php
            $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
            $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
            ?>
            
            <select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>   >
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
            <td align="right" valign="top"   >
            <?php
//			deb($ProductoCantidad);
			?>
            
            <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio" value="<?php echo $ProductoPrecio;?>"   />
            
            <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="6" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"   />
            
            <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />
            
            <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />
            
            <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />
            
            <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />
            
            <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div>
            
            </td>
            <td align="right" valign="top"   >
            
            <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoImporte" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte" size="6" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"   />
            
          
        </td>
            <td align="left" valign="top"   >
            
            <input name="CmpTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="CmpTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="8" maxlength="10" value="<?php echo ($TallerPedidoDetalleFecha);?>"   />
            
            <?php			
            if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
            ?>
                       
                       <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" name="BtnTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                       
                    
            <?php
			}
			?>
            
            
          </td>
            <td align="right" valign="top"   >
              
  <select class="EstFormularioCombo" name="CmpAlmacenId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpAlmacenId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?> >
  <option value="">-</option>
  <?php
foreach($ArrAlmacenes as $DatAlmacen){
?>
  <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($TallerPedidoDetalleAlmacenId == $DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmSigla?></option>
  <?php
}
?>
  </select>
              
              
            </td>
            <td align="right" valign="top"   >
              
              <!--       <input type="checkbox" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" value="3" <?php echo (($TallerPedidoDetalleEstado=="3")?'checked="checked"':'');?>  /> Considerar-->
              
              
              <select class="EstFormularioCombo"   name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>>
  <option value="">-</option>
  <option  <?php echo (($TallerPedidoDetalleEstado=="1")?'selected="selected"':'');?> value="1">Anulado</option>
  <option  <?php echo (($TallerPedidoDetalleEstado=="3")?'selected="selected"':'');?> value="3">Considerar</option>
  </select>
              
              
              
</td>
            <td align="left" valign="top"   >
            
            <?php
			if($POST_Editar==1){
			?>
            <input type="button" name="BtnTareaProductoPredeterminar_<?php echo $DatPlanMantenimientoTarea->PmtId?>"  id="BtnTareaProductoPredeterminar_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="Predeterminar" />
            
            <?php	
			}
			?>
            
            
            <input  style="visibility:hidden;"  <?php /*if($_POST['Editar']==3){?> disabled="disabled"  <?php }*/?> type="checkbox" <?php echo ($FichaAccionMantenimientoVerificar2==1)?'checked="checked"':'';;?>   name="CmpFichaAccionMantenimientoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpFichaAccionMantenimientoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="1"/>
              
              <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleReingreso"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleReingreso" value="2" />
              
              
<!--               <input name="CmpAlmacenId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" type="text" class="EstFormularioCaja" id="CmpAlmacenId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro30;?>" size="10" maxlength="10" />
            <input name="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" type="text" class="EstFormularioCaja" id="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro31;?>" size="10" maxlength="10" />
            -->
            
              
            <?php
			if($_SESSION['MysqlDeb']){
			?>
            <span style="color:#F8F8F8;" >(<?php echo $DatPlanMantenimientoTarea->PmtId?>) / (<?php echo $AlmacenMovimientoSalidaDetalleId;?>) / (<?php echo $FichaAccionMantenimientoId;?>) / (<?php echo  $FichaAccionProductoId;?>) / (<?php echo $ProductoId;?>)</span>
            
            <?php	
			}
			?>
            
            
            
            </td>
                        <?php
                        }
                        ?>
                        
                    <?php	
                    }
                    ?>
                
                </tr>
			
<?php
$MantenimientoTotal += $ProductoImporte;
?>
                
            <?php
            }
            ?>
            
		<?php			
		}
		?>

		<?php	
        }
        ?>

               
<?php
	}
?>  
			<tr>
			  <td valign="top" class="EstPlanMantenimientoTarea">&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="left" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >TOTAL:</td>
			  <td align="right" valign="top"   ><input name="CmpMantenimientoTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMantenimientoTotal" size="8" maxlength="10" value="<?php echo number_format($MantenimientoTotal,2);?>"   /></td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="left" valign="top"   >&nbsp;</td>
	    </tr>
              
            </table></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="center"><b>I:</b> Inspección/ajuste 
              <b>C:</b> Cambio o reemplazo 
              <b>R:</b> Realizar
              <b>U:</b> Agregar <b>P:</b> Consultivo</td>
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
            <td width="75" align="left" valign="top">Version:              </td>
            <td width="277" align="left"><?php echo $InsPlanMantenimiento->VveNombre;?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" valign="top">
            

         
	<table class="EstPlanMantenimientoTabla" border="0" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="right">Kilómetros (x1000)</td>
			

			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
				<?php if($Kilometraje==$DatKilometro['km']){?>

          <td align="center" ><?php echo $DatKilometroEtiqueta;?> km</td>
                <td align="center" >&nbsp;</td>
                <td align="center" >Cod. Original</td>
                <td align="center" >&nbsp;</td>
                <td align="center" >Nombre</td>
                <td align="center" >U.M.</td>
                <td align="center" >Cantidad</td>
          <td align="center" >Importe</td>
                <td align="left" >Fecha</td>
                <td align="center" >Almacen</td>
                <td align="center" >Estado</td>
                <td align="center" >&nbsp;</td>

				<?php }?>
            <?php	
            }
            ?>
        </tr>
                
<?php
$MantenimientoTotal = 0;
	foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){

	$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtOrden','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
	$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
	
?>

	<?php
    if(!empty($ArrPlanMantenimientoTareas) ){
    ?>

<tr>
	<td colspan="29" align="left" class="EstPlanMantenimientoSeccion"><?php echo $DatPlanMantenimientoSeccion->PmsNombre;?></td>
</tr>                
			
		<?php
		
		
		
		
        foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
        ?>

<?php                                

		$AlmacenMovimientoSalidaDetalleId = '';
		$FichaAccionMantenimientoId = '';
		
		$FichaAccionMantenimientoAccion = '';
		
		$FichaAccionMantenimientoVerificar1 = '';
		$FichaAccionMantenimientoVerificar2 = '';
		$FichaAccionProductoId = '';
		
		$ProductoId = '';
		$ProductoPrecio = '';
		$ProductoCantidad = '';
		$ProductoImporte = '';
		
		$ProductoUnidadMedida = '';
		$ProductoNombre = '';
		$ProductoTipoId = '';
		
		$OpcAccion1 = '';
		$OpcAccion2 = '';
		$OpcAccion3 = '';
		$OpcAccion4 = '';
		$OpcAccion5 = '';
		$OpcAccion6 = '';
		$OpcAccion7 = '';
		
		$TallerPedidoDetalleReingreso = '2';
		$TallerPedidoDetalleEstado = '3';
		
		
		$TallerPedidoDetalleAlmacenId = '';
						$TallerPedidoDetalleFecha = '';
						
						
						$TallerPedidoDetalleFacturado = '2';
						$TallerPedidoDetalleCierre = '2';
?>

<?php
foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
	
	if($Kilometraje==$DatKilometro['km']){
		$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
		$FichaAccionMantenimientoAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
	}
	
}
?>
                
	<?php
	if(!empty( $FichaAccionMantenimientoAccion)){
	?>
	<tr>
	  <td valign="top" class="EstPlanMantenimientoTarea">
	    
	    <input style="visibility:hidden;" checked="checked" etiqueta="tarea" type="checkbox" name="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpPlanMantenimientoTareaId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $DatPlanMantenimientoTarea->PmtId;?>"  modalidad_sigla="<?php echo $ModalidadIngreso;?>"  />
	    <?php echo $DatPlanMantenimientoTarea->PmtNombre;?></td>
		

			<?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                <?php
                if($Kilometraje==$DatKilometro['km']){
                ?>
                
                <td align="right" valign="top"   >

<?php
					
//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId

//	Parametro27 = 
//	Parametro28 = 
//	Parametro29 = 
//	Parametro30 = 

//	Parametro31 = AlmId
//	Parametro32 = AmdFecha
			//	Parametro33 = AmdFacturado
				//	Parametro34 = AmdCierre

if(!empty($ArrSesionObjetos)){	
	foreach($ArrSesionObjetos as $DatSesionObjeto){

		$AlmacenMovimientoSalidaDetalleId = '';
		$FichaAccionMantenimientoId = '';
		
		$FichaAccionMantenimientoAccion = '';
		
		$FichaAccionMantenimientoVerificar1 = '';
		$FichaAccionMantenimientoVerificar2 = '';
		$FichaAccionProductoId = '';
		
		$ProductoId = '';
		$ProductoPrecio = '';
		$ProductoCantidad = '';
		$ProductoImporte = '';
		
		$ProductoUnidadMedida = '';
		$ProductoNombre = '';
		$ProductoTipoId = '';
		
		$OpcAccion1 = '';
		$OpcAccion2 = '';
		$OpcAccion3 = '';
		$OpcAccion4 = '';
		$OpcAccion5 = '';
		$OpcAccion6 = '';
		$OpcAccion7 = '';
		
		$TallerPedidoDetalleReingreso = '2';
		$TallerPedidoDetalleEstado = '3';
		
		$TallerPedidoDetalleAlmacenId = '';
		$TallerPedidoDetalleFecha = '';
		$TallerPedidoDetalleFacturado = '2';
		$TallerPedidoDetalleCierre = '2';
						
		if($DatSesionObjeto->Parametro21 == $DatPlanMantenimientoTarea->PmtId){

			$AlmacenMovimientoSalidaDetalleId = $DatSesionObjeto->Parametro1;
			
			$FichaAccionMantenimientoId = $DatSesionObjeto->Parametro20;//
			$FichaAccionMantenimientoAccion = $DatSesionObjeto->Parametro22;//
			$FichaAccionMantenimientoVerificar1 = $DatSesionObjeto->Parametro24;//
			$FichaAccionMantenimientoVerificar2 = $DatSesionObjeto->Parametro25;//
			$FichaAccionProductoId = $DatSesionObjeto->Parametro26;//

			$ProductoId = $DatSesionObjeto->Parametro2;//
			$ProductoPrecio = $DatSesionObjeto->Parametro4;
			$ProductoCantidad = $DatSesionObjeto->Parametro5;
			$ProductoImporte = $DatSesionObjeto->Parametro6;
		
			
			$ProductoUnidadMedida = $DatSesionObjeto->Parametro10;//
			$ProductoNombre = $DatSesionObjeto->Parametro3;//
			$ProductoCodigoOriginal = $DatSesionObjeto->Parametro13;
			$ProductoTipoId = $DatSesionObjeto->Parametro11;//
			
			$TallerPedidoDetalleReingreso  = $DatSesionObjeto->Parametro29;//
			$TallerPedidoDetalleEstado  = $DatSesionObjeto->Parametro28;//
			
			
			$TallerPedidoDetalleAlmacenId = $DatSesionObjeto->Parametro31;//
			$TallerPedidoDetalleFecha = $DatSesionObjeto->Parametro32;//
			
			
			$TallerPedidoDetalleFacturado = (empty($DatSesionObjeto->Parametro33)?'2':$DatSesionObjeto->Parametro33);//
			$TallerPedidoDetalleCierre =  (empty($DatSesionObjeto->Parametro34)?'2':$DatSesionObjeto->Parametro34);//
			$TallerPedidoDetalleCompraOrigen =  (empty($DatSesionObjeto->Parametro35)?2:$DatSesionObjeto->Parametro35);//
							
							if($POST_PrimerRegistro=="1"){
								$TallerPedidoDetalleEstado = 3;
							}
							
			break;
		}					
	}
}				
?>

<?php

					switch($FichaAccionMantenimientoAccion){

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
if(empty($FichaAccionMantenimientoVerificar1)){
	$FichaAccionMantenimientoVerificar1 = 2;
}
?>


<input type="hidden" value="<?php echo $FichaAccionMantenimientoAccion;?>" name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>Aux" >


<select  class="<?php echo (( $FichaAccionMantenimientoAccion == "R" or $FichaAccionMantenimientoAccion == "U")?'EstFormularioComboResaltado':'EstFormularioCombo')?>"  name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" disabled="disabled" >

<!--<select class="EstFormularioCombo"  name="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoAccion_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" >-->
<option value="X" <?php echo $OpcAccion4;?>>X</option>
<option value="R" <?php echo $OpcAccion1;?>>Reemplazar</option>
<option value="I" <?php echo $OpcAccion2;?>>Inspeccionar</option>
<option value="A" <?php echo $OpcAccion3;?>>Ajustar</option>
<option value="T" <?php echo $OpcAccion5;?>>Apretar</option>
<option value="L" <?php echo $OpcAccion6;?>>Lubricar</option>
<option value="U" <?php echo $OpcAccion7;?>>Agregar</option>
</select>

<input size="2" type="hidden" name="CmpFichaAccionProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionProductoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionProductoId;?>" />

<input size="2" type="hidden" name="CmpFichaAccionMantenimientoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpFichaAccionMantenimientoId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" value="<?php echo $FichaAccionMantenimientoId;?>" />

<input type="hidden" name="CmpAlmacenMovimientoSalidaDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpAlmacenMovimientoSalidaDetalleId_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="<?php echo $AlmacenMovimientoSalidaDetalleId;?>" />


</td>
<td align="right" valign="top"   >

<?php
			
           if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
            ?>
            
			<a <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoNuevo" href="javascript:FncTallerPedidoDetalleNuevo('<?php echo $DatPlanMantenimientoTarea->PmtId?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>    
            
            <?php
            }
            ?>

</td>
<td align="left" valign="top"   >
    
	<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCodigoOriginal" size="10" maxlength="20"  value="<?php echo $ProductoCodigoOriginal;?>"    />

</td>
<td align="right" valign="top"   >

<?php
if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
?>

	<a <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'style="display:none;"':''?> id="Btn<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar" href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatPlanMantenimientoTarea->PmtId?>','<?php echo $ModalidadIngreso;?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>

<?php
}
?>
            
            
    
</td>
<td align="right" valign="top"   >

	<input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" type="text"   class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"   <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoNombre" size="30" value="<?php echo $ProductoNombre;?>"   />

</td>
<td align="right" valign="top"   >  
  
  <?php
    $ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeNombre","ASC",NULL,2,$ProductoTipoId);	
    $ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
    ?>
  
  <select  class="EstFormularioCombo" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaConvertir"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>   >
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
<td align="right" valign="top"   >
  
    <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoPrecio" value="<?php echo $ProductoPrecio;?>"   />
    
  <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoCantidad" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoCantidad" size="6" maxlength="10" value="<?php echo number_format($ProductoCantidad,2);?>"   />
  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedida" value="<?php echo $ProductoUnidadMedida;?>" />
  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoUnidadMedidaEquivalente" value=""  />
  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoId" value="<?php echo $ProductoId;?>"   />
  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoItem" value="" />
  
  <div id="Cap<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoBuscar"></div>
  
</td>
<td align="right" valign="top"   >
  
  <input name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId;?>ProductoImporte" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>ProductoImporte" size="6" maxlength="10" value="<?php echo number_format($ProductoImporte,2);?>"   />
  
  <?php
$MantenimientoTotal += $ProductoImporte;
?>
</td>
<td align="left" valign="top"   >   <input name="CmpTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" type="text" class="<?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'EstFormularioCajaDeshabilitada':'EstFormularioCaja'?>"  <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'readonly="readonly"':'';?> id="CmpTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId?>" size="8" maxlength="10" value="<?php echo ($TallerPedidoDetalleFecha);?>"   />
            

<?php			
if($POST_Editar==1 and ( $TallerPedidoDetalleFacturado == "2" and $TallerPedidoDetalleFacturado == "2")){
?>
<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" name="BtnTallerPedidoDetalleFecha_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />

<?php
}
?>
                       
                    </td>
<td align="right" valign="top"   ><select class="EstFormularioCombo" name="CmpAlmacenId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" id="CmpAlmacenId_<?php echo $DatPlanMantenimientoTarea->PmtId;?>" <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>>
                              <option value="">-</option>
                              <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                              <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($TallerPedidoDetalleAlmacenId ==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmSigla?></option>
                              <?php
			}
			?>
          </select></td>
<td align="right" valign="top"   >
  
  <select  class="EstFormularioCombo"    name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" <?php echo ($POST_Editar==2 or  $TallerPedidoDetalleFacturado == "1" or $TallerPedidoDetalleCierre == "1")?'disabled="disabled"':'';?>>
    <option value="">-</option>
    <option   <?php echo (($TallerPedidoDetalleEstado=="1")?'selected="selected"':'');?> value="1">Anulado</option>
    <option   <?php echo (($TallerPedidoDetalleEstado=="3")?'selected="selected"':'');?> value="3">Considerar</option>
    </select>
  
  <!-- <input type="checkbox" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleEstado" value="3" <?php echo (($TallerPedidoDetalleEstado=="3")?'checked="checked"':'');?>  /> Considerar-->
  
</td>
<td align="left" valign="top"   >
   <?php
			if($POST_Editar==1){
			?>
<input type="button" name="BtnTareaProductoPredeterminar_<?php echo $DatPlanMantenimientoTarea->PmtId?>"  id="BtnTareaProductoPredeterminar_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="Predeterminar" />
<?php
			}
?>

  <input  style="visibility:hidden;"  <?php /*if($_POST['Editar']==3){?> disabled="disabled"  <?php }*/?> type="checkbox" <?php echo ($FichaAccionMantenimientoVerificar2==1)?'checked="checked"':'';;?>   name="CmpFichaAccionMantenimientoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId?>" id="CmpFichaAccionMantenimientoVerificar2_<?php echo $DatPlanMantenimientoTarea->PmtId?>" value="1"/>
  
  <input type="hidden" name="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleReingreso"    id="Cmp<?php echo $DatPlanMantenimientoTarea->PmtId?>TallerPedidoDetalleReingreso" value="2" />
  
   <input name="CmpAlmacenId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" type="hidden" class="EstFormularioCaja" id="CmpAlmacenId_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro30;?>" size="10" maxlength="10" />
            <input name="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" type="hidden" class="EstFormularioCaja" id="CmpTallerPedidoDetalleFecha_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro31;?>" size="10" maxlength="10" />
  
  <span style="color:#F8F8F8;" >(<?php echo $DatPlanMantenimientoTarea->PmtId?>) / (<?php echo $AlmacenMovimientoSalidaDetalleId;?>) / (<?php echo $FichaAccionMantenimientoId;?>) / (<?php echo  $FichaAccionProductoId;?>)  / (<?php echo $ProductoId;?>)</span>
  
  
  
</td>
                <?php
                }
                ?>
                
			<?php	
			}
			?>
</tr>
<?php
				
				?>
                
	<?php
	}
	?>
		<?php			
		}
		?>
        
        
        
	<?php
    }
    ?>
               
<?php
}
?>  
			<tr>
			  <td valign="top" class="EstPlanMantenimientoTarea">&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="left" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >TOTAL:</td>
			  <td align="right" valign="top"   ><input name="CmpMantenimientoTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpMantenimientoTotal" size="8" maxlength="10" value="<?php echo number_format($MantenimientoTotal,2);?>"   /></td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="right" valign="top"   >&nbsp;</td>
			  <td align="left" valign="top"   >&nbsp;</td>
	    </tr>
              
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
