<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ACTUALIZAR_INVENTARIO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

//$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:date("d/m/Y");
//$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

//$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"FinFecha";
//$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";
//$POST_Sucursal = isset($_POST['Sucursal'])?$_POST['Sucursal']:"";
//$POST_VehiculoMarca = isset($_POST['VehiculoMarca'])?$_POST['VehiculoMarca']:"";
//$POST_EstadoVehicular = "STOCK,VENDIDO,RESERVADO,C/INCIDENCIA,TRAMITE";

$POST_Ano = $_POST['Ano'];
$POST_Mes = $_POST['Mes'];
$POST_BuscarVIN = isset($_POST['BuscarVIN'])?$_POST['BuscarVIN']:"";

$POST_Sucursal = "";
$POST_VehiculoMarca = "";
$POST_EstadoVehicular = "VENDIDO";

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsSucursal = new ClsSucursal();
////MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL)
//$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL);
//$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL,$oOrdenAno=NULL,$oOrdenMes=NULL)
//$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,"1",NULL,NULL,$POST_EstadoVehicular,$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal,NULL,$POST_Ano,$POST_Mes);
//$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN,ALM,INICIAL");
$ArrSucursales = $RepSucursal['Datos'];

//deb($_POST);
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR ENTREGA DE VEHICULOS</span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
   
<!--
<h3>Entregas</h3>

-->
<?php

////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL,$oOrdenAno=NULL,$oOrdenMes=NULL)
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$POST_BuscarVIN,"EinTiempoModificacion","ASC",NULL,"1",NULL,NULL,"VENDIDO",$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal,NULL,$POST_Ano,$POST_Mes);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>

<table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="4%">NUM. PROF.</th>
          <th width="4%">MES PROF.</th>
          <th width="6%">MARCA</th>
          <th width="6%">MODELO</th>
          <th width="6%">VERSION</th>
          <th width="3%">VIN</th>
          <th width="7%">COLOR EXTERIOR</th>
          <th width="7%">COLOR INTERIOR</th>
          <th width="6%">AÑO FAB.</th>
          <th width="5%">AÑO MOD.</th>
          <th width="22%">UBICACION </th>
          <th width="5%">UBICACION REF.</th>
          <th width="5%">FECHA ULT. INV.</th>
          <th width="5%">NUM. DUA</th>
          <th width="6%">NOTAS</th>
          <th width="6%">OTROS</th>
          <th width="6%">ESTADO VEH.</th>
          <th width="6%">ENTREGA</th>
          <th width="6%">PEDIDO</th>
          <th width="6%">FECHA PEDIDO</th>
          <th width="6%">CLIENTE</th>
          <th width="6%">ASESOR DE VENTAS</th>
          <th width="6%">ESTADO PAGO</th>
          <th width="6%">ULT. ACT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
			
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
			//$InsOrdenVentaVehiculo->
			
			//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false)
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,"OvvFecha","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatVehiculoIngreso->EinId,$POST_Sucursal,NULL,NULL,NULL,NULL);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	
$FechaEntrega = "";
$Cliente = "";
$Asesor = "";
$OrdenId = "";
$OrdenFechaEnvio = "";

if(!empty($ArrOrdenVentaVehiculos)){
	foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
		
		$OrdenId = $DatOrdenVentaVehiculo->OvvId;
		$FechaEntrega = $DatOrdenVentaVehiculo->OvvActaEntregaFecha;
		$Cliente = $DatOrdenVentaVehiculo->CliNombre." ".$DatOrdenVentaVehiculo->CliApellidoPaterno." ".$DatOrdenVentaVehiculo->CliApellidoMaterno;
		$Asesor = $DatOrdenVentaVehiculo->PerNombre." ".$DatOrdenVentaVehiculo->PerApellidoPaterno." ".$DatOrdenVentaVehiculo->PerApellidoMaterno;	
		$OrdenFechaEnvio = $DatOrdenVentaVehiculo->OvvTiempoSolicitudEnvio;	
		
		
		
	}
}
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="middle"   ><?php echo $c;?>
          <input style="visibility:hidden;"  type="checkbox" name="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" id="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" value="<?php echo $DatVehiculoIngreso->EinId; ?>"  etiqueta="vehiculo_ingreso_entrega" ></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   >
		  
		<?php echo ($DatVehiculoIngreso->EinNumeroProforma);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmaNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmoNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VveNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><a id="Fila_<?php echo ($DatVehiculoIngreso->EinId);?>3" href="javascript:void(0);"> <?php echo ($DatVehiculoIngreso->EinVIN);?> </a></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->EinColor);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($DatVehiculoIngreso->EinColorInterior);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($DatVehiculoIngreso->EinAnoFabricacion);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($DatVehiculoIngreso->EinAnoModelo);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" >
		  
		  <!--<?php echo ($DatVehiculoIngreso->SucNombre);?> / 
		  <?php echo ($DatVehiculoIngreso->EinUbicacionReferencia);?>-->
          
          <select class="EstFormularioCombo" name="CmpSucursal_<?php echo $DatVehiculoIngreso->EinId?>" id="CmpSucursal_<?php echo $DatVehiculoIngreso->EinId?>">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($DatVehiculoIngreso->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select>
                
                </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" >
          
          <input name="CmpUbicacionReferencia_<?php echo $DatVehiculoIngreso->EinId?>"  type="text" class="EstFormularioCaja"  id="CmpUbicacionReferencia_<?php echo $DatVehiculoIngreso->EinId?>" value="<?php echo $DatVehiculoIngreso->EinUbicacionReferencia?>" size="15" maxlength="255">
          
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><input name="CmpFechaUltimoInventario_<?php echo ($DatVehiculoIngreso->EinId);?>" type="text" class="EstFormularioCajaFecha" id="CmpFechaUltimoInventario_<?php echo ($DatVehiculoIngreso->EinId);?>" tabindex="6" value="<?php  echo $DatVehiculoIngreso->EinFechaUltimoInventario ?>" size="10" maxlength="10" />                                                                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaUltimoInventario_<?php echo ($DatVehiculoIngreso->EinId);?>" name="BtnFechaUltimoInventario_<?php echo ($DatVehiculoIngreso->EinId);?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($DatVehiculoIngreso->EinDUA);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" >
          
          <input name="CmpNota_<?php echo $DatVehiculoIngreso->EinId?>"  type="text" class="EstFormularioCaja"  id="CmpNota_<?php echo $DatVehiculoIngreso->EinId?>" value="<?php echo $DatVehiculoIngreso->EinNota?>" size="25" maxlength="255">
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><input name="CmpDatoAdicional_<?php echo $DatVehiculoIngreso->EinId?>"  type="text" class="EstFormularioCaja"  id="CmpDatoAdicional_<?php echo $DatVehiculoIngreso->EinId?>" value="<?php echo $DatVehiculoIngreso->EinDatoAdicional?>" size="15" maxlength="45"></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php //echo ($DatVehiculoIngreso->EinEstadoVehicular);?>
          
          <?php
			switch($DatVehiculoIngreso->EinEstadoVehicular){

				case "STOCK":
					$OpcEstadoVehicular1 = 'selected="selected"';
				break;
				
				case "VENDIDO":
					$OpcEstadoVehicular2 = 'selected="selected"';
				break;				
				
				case "RESERVADO":
					$OpcEstadoVehicular3 = 'selected="selected"';
				break;
				
				case "C/INCIDENCIA":
					$OpcEstadoVehicular4 = 'selected="selected"';
				break;
				
				case "TRAMITE":
					$OpcEstadoVehicular5 = 'selected="selected"';
				break;
				
			
				
				
				default:
				
				break;

			}
			?>
        <select class="EstFormularioCombo" name="CmpEstadoVehicular_<?php echo ($DatVehiculoIngreso->EinId);?>" id="CmpEstadoVehicular_<?php echo ($DatVehiculoIngreso->EinId);?>">
          <option value="">Escoja una opcion</option>
          <option <?php echo $OpcEstadoVehicular1;?> value="STOCK">STOCK</option>
          <option <?php echo $OpcEstadoVehicular2;?> value="VENDIDO">VENDIDO</option>
          <option <?php echo $OpcEstadoVehicular3;?> value="RESERVADO">RESERVADO</option>
          <option <?php echo $OpcEstadoVehicular4;?> value="C/INCIDENCIA">C/INCIDENCIA</option>
             
          </select></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" >
		  
		  
          
          <input name="CmpFechaEntrega_<?php echo ($DatVehiculoIngreso->EinId);?>" type="text" class="EstFormularioCajaFecha" id="CmpFechaEntrega_<?php echo ($DatVehiculoIngreso->EinId);?>" tabindex="6" value="<?php  echo $FechaEntrega ?>" size="10" maxlength="10" readonly />                                                                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEntrega_<?php echo ($DatVehiculoIngreso->EinId);?>" name="BtnFechaEntrega_<?php echo ($DatVehiculoIngreso->EinId);?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
          
          
          
          </td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($OrdenId);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo $OrdenFechaEnvio;?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($Cliente);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($Asesor);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" >&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivoX":"EstTablaReporteInactivoX";?>" ><?php echo ($DatVehiculoIngreso->EinTiempoModificacion);?></td>
          </tr>
        <?php	
		$c++;
        }
        ?>
        </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
</table>



</body>
</html>