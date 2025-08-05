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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_ORDEN_VENTA_VEHICULO_CALLCENTER_".date('d-m-Y').".xls\";");
}
?>

<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

<?php

$POST_finicio = isset($_REQUEST['FechaInicio'])?$_REQUEST['FechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_REQUEST['FechaFin'])?$_REQUEST['FechaFin']:date("d/m/Y");

$POST_ClienteNombre = $_REQUEST['ClienteNombre'];
$POST_ClienteId = $_REQUEST['ClienteId'];

$POST_FichaIngresoId = $_REQUEST['FichaIngresoId'];
$POST_SucursalId = $_REQUEST['SucursalId'];

$POST_VehiculoMarca = $_REQUEST['VehiculoMarca'];
$POST_Modalidad = $_REQUEST['Modalidad'];
$POST_IncluirCSI = $_REQUEST['IncluirCSI'];
$POST_DiasTranscurridos = $_REQUEST['DiasTranscurridos'];

$POST_Filtro = $_REQUEST['Filtro'];

		
$POST_ord = isset($_REQUEST['Orden'])?$_REQUEST['Orden']:"OvvFechaEntrega";
$POST_sen = isset($_REQUEST['Sentido'])?$_REQUEST['Sentido']:"DESC";

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');


$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

////MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0,$oFecha="IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)") 
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes("OvvId,CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_Filtro ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_VehiculoMarca,$POST_SucursalId,$POST_IncluirCSI,"Igual",$POST_DiasTranscurridos,"IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)");
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];



$Saludo = "";

$Hora = date("i");

if($Hora>18){

	$Saludo = "Buenas Noches";

}else if($Hora>12){
	
	$Saludo = "Buenas Tardes";

}else{

	$Saludo = "Buenos Dias";
		
}
?>

<?php

if($_SESSION['MysqlDeb']){
	echo json_encode($_REQUEST);
}

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO  DE  ORDENES DE VENTA DE VEHICULOS- CALLCENTER 
  
  DEL
      <?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
      <?php  
  }
?>



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">SUCURSAL</th>
          <th width="8%">ORD. VENTA</th>
          <th width="6%">FECHA</th>
          <th width="8%">ENTREGA</th>
          <th width="8%">DIAS TRANSC.</th>
          <th width="25%">CLIENTE.</th>
          <th width="25%">DOC.</th>
          <th width="10%">TELEFONO</th>
          <th width="9%">CELULAR</th>
          <th width="6%">EMAIL</th>
          <th width="6%">VIN</th>
          <th width="6%">PLACA</th>
          <th width="8%">MARCA.</th>
          <th width="9%">MODELO</th>
          <th width="9%" align="center">VERSION</th>
          <th width="9%" align="center">COLOR</th>
          <th width="9%" align="center">ASESOR</th>
          <th width="9%" align="center"># LLA.</th>
          <th width="9%" align="center"># ENC.</th>
          <th width="9%" align="center">ACCIONES</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
		$TotalLlamadas = 0;
		$TotalEncuestas= 0;
		
        foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculo){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?>
          
<?php
$Motivo = " Excluido el Fecha: ".$DatReporteOrdenVentaVehiculo->CliCSIExcluirFecha." por Usuario: ".$DatReporteOrdenVentaVehiculo->CliCSIExcluirUsuario." Motivo: ". $DatReporteOrdenVentaVehiculo->CliCSIExcluirMotivo;
?>

  
        
                  
<input  type="checkbox" name="CmpReporteOrdenVentaVehiculo_<?php echo $c; ?>" id="CmpReporteOrdenVentaVehiculo_<?php echo $c; ?>" value="<?php echo $c; ?>" ficha_ingreso="<?php echo $DatReporteOrdenVentaVehiculo->OvvId; ?>" cliente="<?php echo $DatReporteOrdenVentaVehiculo->CliId; ?>" etiqueta="fila" style="visibility:hidden;" fecha_inicio="<?php echo FncCambiaFechaAMysql($POST_finicio);?>" fecha_fin="<?php echo FncCambiaFechaAMysql($POST_ffin);?>" motivo="<?php echo $Motivo;?>" >  


          </td>
          <td align="right" valign="middle"   >
          
          
          
		  <?php echo $DatReporteOrdenVentaVehiculo->SucNombre;  ?>
          
          
          </td>
          <td align="right" valign="middle"   >
		  
                      <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $DatReporteOrdenVentaVehiculo->OvvId;?>');"><?php echo $DatReporteOrdenVentaVehiculo->OvvId;  ?></a>
                      
<!--                      
          <a href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatReporteOrdenVentaVehiculo->OvvId;?>" target="_blank">
			 <?php echo $DatReporteOrdenVentaVehiculo->OvvId;  ?></a>  -->        
             
			</td>
          <td align="right" ><?php echo ($DatReporteOrdenVentaVehiculo->OvvFecha);?></td>
          <td align="right" >
          
		  
		  <h2><?php echo ($DatReporteOrdenVentaVehiculo->OvvFechaEntrega);?>
          
          </h2>
          
          
          </td>
          <td align="right" >
		  
		  <?php
		  if($DatReporteOrdenVentaVehiculo->OvvDiaTranscurridoEntrega>0){
		?>
          <?php echo ($DatReporteOrdenVentaVehiculo->OvvDiaTranscurridoEntrega);?> dia(s)
          
        <?php 
		  }
		  ?>
		
          
          
          </td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->CliNombre;  ?> <?php echo $DatReporteOrdenVentaVehiculo->CliApellidoPaterno;  ?> <?php echo $DatReporteOrdenVentaVehiculo->CliApellidoMaterno;  ?>
          
          
                    <?php

if($DatReporteOrdenVentaVehiculo->CliCSIIncluir == "2"){
?>
    <a href="javascript:void(0);" id="BtnCSIDatos_<?php echo $c;  ?>">
    <img src="imagenes/avisos/retirado.gif" width="15" height="15" border="0" align="Excluido CSI" title="Excluido CSI" />
    
    </a>
    <?php	
}
?>  
          
          
          
          </td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->CliNumeroDocumento;  ?></td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->CliTelefono;  ?></td>
          <td align="right" >
<?php


$Titulo = $SistemaCorreoRemitente;

$Mensaje = $Saludo." Señ@r ".$DatReporteOrdenVentaVehiculo->CliNombre;

//$Mensaje = str_replace(" ","%",$Mensaje);

?>


<?php echo $DatReporteOrdenVentaVehiculo->CliCelular;?>


<?php
if(!empty($DatReporteOrdenVentaVehiculo->CliCelular)){
?>
<a  href="javascript:FncOrdenVentaVehiculoSeguimientoEnviarWhatsapp('<?php echo trim($DatReporteOrdenVentaVehiculo->CliWhatsapp);?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/whatsapp.png" width="20" height="20" title="Enviar mensaje de whatsapp" />
</a>

<?php
}
?>


<?php
/*if(!empty($DatReporteOrdenVentaVehiculo->CliCelular)){
?>
<a  href="javascript:FncOrdenVentaVehiculoSeguimientoEnviarSms('<?php echo trim($DatReporteOrdenVentaVehiculo->CliWhatsapp);?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/enviar_sms.png" width="20" height="20" title="Enviar mensaje de texto" />
</a>

<?php
}*/
?>


    
          
          
          
          
          
          </td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->CliEmail;  ?>
 
<?php
if(!empty($DatReporteOrdenVentaVehiculo->CliEmail)){
?>         


  <a  href="javascript:FncOrdenVentaVehiculoSeguimientoEnviarEmail('<?php echo trim($DatReporteOrdenVentaVehiculo->CliEmail);?>','<?php echo $Titulo;?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/enviar_correo.png" width="20" height="20" title="Enviar mensaje por Email" />
</a>
      <?php
}
	  ?>  
          
          
          
      
          
          </td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->EinVIN;  ?></td>
          <td align="right" >
		  
		  <h2>
		  <?php echo $DatReporteOrdenVentaVehiculo->EinPlaca;  ?>
          
          </h2>
          </td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->VmaNombre;  ?></td>
          <td align="right" ><?php echo $DatReporteOrdenVentaVehiculo->VmoNombre;  ?></td>
          <td align="center" ><?php echo $DatReporteOrdenVentaVehiculo->VveNombre;  ?></td>
          <td align="center" ><?php echo $DatReporteOrdenVentaVehiculo->EinColor;  ?></td>
          <td align="center" ><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"> <?php echo $DatReporteOrdenVentaVehiculo->PerNombre;?> <?php echo $DatReporteOrdenVentaVehiculo->PerApellidoPaterno;?> <?php echo $DatReporteOrdenVentaVehiculo->PerApellidoMaterno;?></span></td>
          <td align="center" >
            
  <?php

$InsOrdenVentaVehiculoLlamada = new ClsOrdenVentaVehiculoLlamada();
//MtdObtenerOrdenVentaVehiculoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvlId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResOrdenVentaVehiculoLlamada =  $InsOrdenVentaVehiculoLlamada->MtdObtenerOrdenVentaVehiculoLlamadas(NULL,NULL,"OvlId","ASC",NULL,$DatReporteOrdenVentaVehiculo->OvvId,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL);
$ArrOrdenVentaVehiculoLlamadas = 	$ResOrdenVentaVehiculoLlamada['Datos'];

?>
            
            <h2>
              
              <span id="CapTotalOrdenVentaVehiculoLlamadas_<?php echo $c;?>">
              <?php
		  echo count($ArrOrdenVentaVehiculoLlamadas);
		  ?>
              </span>
              
            </h2>
            
            <?php
			$TotalLlamadas += count($ArrOrdenVentaVehiculoLlamadas);
			?>
          </td>
          <td align="center" >
          
          
          <?php
		  
$InsEncuesta = new ClsEncuesta();
//MtdObtenerEncuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL,$oSucursal=NULL,$oFichaIngreso=NULL,$oOrdenVentaVehiculo=NULL) {
$ResEncuesta = $InsEncuesta->MtdObtenerEncuestas(NULL,NULL,NULL,"EncFecha","DESC","1",NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"VENTA",NULL,NULL,$DatReporteOrdenVentaVehiculo->OvvId);
$ArrEncuestas = $ResEncuesta['Datos'];

		  ?>
          <h2>
          <span id="CapTotalEncuestas_<?php echo $c;?>">
          <?php
		  echo count($ArrEncuestas);
		  ?>
          </span>
          </h2>
          
           <?php
			$TotalEncuestas += count($ArrEncuestas);
			?>
          </td>
          <td align="center" >
          
            
<!--            <a href="javascript:FncOrdenVentaVehiculoVistaPreliminar('<?php echo $DatReporteOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>-->
                  
            <a href="javascript:FncOrdenVentaVehiculoSeguimientoClienteCargarFormulario('<?php echo $DatReporteOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/acciones/llamar.png" alt="[Registrar Llamada]" title="Registrar Llamada" width="19" height="19" border="0" /></a>
            
             <a href="javascript:FncOrdenVentaVehiculoEncuestaCargarFormulario('<?php echo $DatReporteOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/acciones/encuesta.gif" alt="[Registrar Encuesta]" title="Registrar Encuesta" width="19" height="19" border="0" /></a>
                                          
          </td>
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
            <td align="right"><h2>TOTALES:</h2></td>
            <td align="right"><h2><?php echo $TotalLlamadas;?></h2></td>
            <td align="right"><h2><?php echo $TotalEncuestas;?></h2></td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>