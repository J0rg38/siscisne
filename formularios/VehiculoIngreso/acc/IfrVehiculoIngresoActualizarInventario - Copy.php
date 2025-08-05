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
	header("Content-Disposition:  filename=\"ACTUALIZAR_CSI_POST_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

</head>
<body>

<?php

//$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

//$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"FinFecha";
//$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";
$POST_Sucursal = isset($_POST['Sucursal'])?$_POST['Sucursal']:"";
$POST_VehiculoMarca = isset($_POST['VehiculoMarca'])?$_POST['VehiculoMarca']:"";
$POST_EstadoVehicular = "STOCK,VENDIDO,RESERVADO,C/INCIDENCIA,TRAMITE";



require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

////MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL)
//$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL);
//$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];


$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,"1",NULL,NULL,$POST_EstadoVehicular,$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">ACTUALIZAR INVENTARIO DE VEHICULOS</span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
<?php


$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,"1",NULL,NULL,"STOCK",$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>
<h2>Unidades Libres</h2>
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">NUM. PROF.</th>
          <th width="8%">MES PROF.</th>
          <th width="8%">MARCA</th>
          <th width="8%">MODELO</th>
          <th width="8%">VERSION</th>
          <th width="8%">VIN</th>
          <th width="8%">COLOR EXTERIOR</th>
          <th width="14%">COLOR INTERIOR</th>
          <th width="14%">AÑO FAB.</th>
          <th width="14%">AÑO MOD.</th>
          <th width="14%">UBICACION </th>
          <th width="14%">FECHA ULT. INV.</th>
          <th width="14%">NUM. DUA</th>
          <th width="14%">OTROS</th>
          <th width="14%">ESTADO PAGO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
		  <?php echo $c;?>
          
            <input style="visibility:hidden;"  type="checkbox" name="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" id="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" value="<?php echo $DatVehiculoIngreso->EinId; ?>"  etiqueta="vehiculo_ingreso" >
            
            
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		<?php echo ($DatVehiculoIngreso->EinNumeroProforma);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmaNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmoNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VveNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><a id="Fila_<?php echo ($DatVehiculoIngreso->EinId);?>2" href="javascript:void(0);"> <?php echo ($DatVehiculoIngreso->EinVIN);?> </a></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->EinColor);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinColorInterior);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoFabricacion);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoModelo);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php echo ($DatVehiculoIngreso->SucNombre);?> / 
		  <?php echo ($DatVehiculoIngreso->EinUbicacionReferencia);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >-</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinDUA);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>


<hr>

<h2>Unidades c/ Incidencia</h2>


<?php


$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,"1",NULL,NULL,"C/INCIDENCIA",$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>

<table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">NUM. PROF.</th>
          <th width="8%">MES PROF.</th>
          <th width="8%">MARCA</th>
          <th width="8%">MODELO</th>
          <th width="8%">VERSION</th>
          <th width="8%">VIN</th>
          <th width="8%">COLOR EXTERIOR</th>
          <th width="14%">COLOR INTERIOR</th>
          <th width="14%">AÑO FAB.</th>
          <th width="14%">AÑO MOD.</th>
          <th width="14%">UBICACION </th>
          <th width="14%">FECHA ULT. INV.</th>
          <th width="14%">NUM. DUA</th>
          <th width="14%">OTROS</th>
          <th width="14%">ESTADO PAGO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?>
          <input style="visibility:hidden;"  type="checkbox" name="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" id="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" value="<?php echo $DatVehiculoIngreso->EinId; ?>"  etiqueta="vehiculo_ingreso" ></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		<?php echo ($DatVehiculoIngreso->EinNumeroProforma);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmaNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmoNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VveNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		  <a id="Fila_<?php echo ($DatVehiculoIngreso->EinId);?>" href="javascript:void(0);">
		  <?php echo ($DatVehiculoIngreso->EinVIN);?>
          </a>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->EinColor);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinColorInterior);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoFabricacion);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoModelo);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php echo ($DatVehiculoIngreso->SucNombre);?> / 
		  <?php echo ($DatVehiculoIngreso->EinUbicacionReferencia);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >-</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinDUA);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
</table>


<hr>

<h2>Unidades Separadas</h2>


<?php


$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinVIN","ASC",NULL,"1",NULL,NULL,"RESERVADO",$POST_VehiculoMarca,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,$POST_ConProforma,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

?>

<table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">NUM. PROF.</th>
          <th width="8%">MES PROF.</th>
          <th width="8%">MARCA</th>
          <th width="8%">MODELO</th>
          <th width="8%">VERSION</th>
          <th width="8%">VIN</th>
          <th width="8%">COLOR EXTERIOR</th>
          <th width="14%">COLOR INTERIOR</th>
          <th width="14%">AÑO FAB.</th>
          <th width="14%">AÑO MOD.</th>
          <th width="14%">UBICACION </th>
          <th width="14%">FECHA ULT. INV.</th>
          <th width="14%">NUM. DUA</th>
          <th width="14%">OTROS</th>
          <th width="14%">ESTADO PAGO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?>
          <input style="visibility:hidden;"  type="checkbox" name="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" id="CmpVehiculoIngreso_<?php echo $DatVehiculoIngreso->EinId; ?>" value="<?php echo $DatVehiculoIngreso->EinId; ?>"  etiqueta="vehiculo_ingreso" ></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   >
		  
		<?php echo ($DatVehiculoIngreso->EinNumeroProforma);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->FinFecha);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmaNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VmoNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->VveNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><a id="Fila_<?php echo ($DatVehiculoIngreso->EinId);?>3" href="javascript:void(0);"> <?php echo ($DatVehiculoIngreso->EinVIN);?> </a></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"   ><?php echo ($DatVehiculoIngreso->EinColor);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinColorInterior);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoFabricacion);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinAnoModelo);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
		  
		  <?php echo ($DatVehiculoIngreso->SucNombre);?> / 
		  <?php echo ($DatVehiculoIngreso->EinUbicacionReferencia);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >-</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php echo ($DatVehiculoIngreso->EinDUA);?></td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          <td align="right" valign="top" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >&nbsp;</td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
</table>



</body>
</html>