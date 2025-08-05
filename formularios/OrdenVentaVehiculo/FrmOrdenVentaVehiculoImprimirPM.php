<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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

$GET_id = $_GET['Id'];
$GET_NumeroMantenimiento = $_GET['NumeroMantenimiento'];
$GET_Completo = $_GET['Completo'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta de Vehiculo No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssOrdenVentaVehiculoImprimirPM.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenVentaVehiculo->OvvId)){?> 
FncOrdenVentaVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>




    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><!--<img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  />-->
      
      <?php
	  
	  //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsOrdenVentaVehiculo->VmaId){
		  case "VMA-10017":
	?>
     <img src="../../imagenes/membretes/cabecera_chevrolet.png" width="100%"  />
    <?php  
		  break;
		  
		  case "VMA-10018":
	?>
     <img src="../../imagenes/membretes/cabecera_isuzu.png" width="100%"  />
    <?php	  
		  break;
		  
		  default:
		 ?>
          <img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  />
         <?php 
		  break;
	  }
	  ?>
      
      
      
      </td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="34%" align="left" valign="top">&nbsp;</td>
      <td width="28%" align="center" valign="top">&nbsp;</td>
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>










<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td colspan="3" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">PLANES DE MANTENIMIENTO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsOrdenVentaVehiculo->OvvId;?></span>
        
      </td>
      </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td width="9%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">CLIENTE(S): </span></td>
      <td width="57%" align="left" valign="top" >
        
        
        <span class="EstOrdenVentaVehiculoImprimirContenido"> 
          
          <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
          <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno?> /
          <?php		
	}
}
?>
          <br />
          
          <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
          
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?></span>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> / 
          
          <?php		
	}
}
?>
          
          
          </span>
        
        </td>
      <td width="32%" align="right" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
	  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  ?>
        Tacna, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
        <?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
      </span></td>
      </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">VEHICULO: </span>
        
        
      </td>
      <td colspan="2" align="left" valign="top" >
        
        
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          VIN:
          </span>
        <span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersion">
          <?php echo $InsOrdenVentaVehiculo->EinVIN;?> 
          </span>
        
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          MARCA:
          </span>
        <span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersion">
          <?php echo $InsOrdenVentaVehiculo->VmaNombre;?>
          </span>
        
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          MODELO:
          </span>
        <span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersion">
          <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> 
          </span>
        
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          VERSION: 
          </span>
        <span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersion">
          <?php echo $InsOrdenVentaVehiculo->VveNombre;?></span>
      </td>
      </tr>
    <tr>
      <td colspan="3" align="left" valign="top" >
        
        <?php
		if($InsOrdenVentaVehiculo->VmaId == "VMA-10017"){
		?>
        
        <table class="EstOrdenVentaVehiculoImprimirTablaPlanMantenimiento" width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody class="EstOrdenVentaVehiculoImprimirTablaPlanMantenimientoBody">
            <tr>
              <td width="33" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==1)?'bgcolor="B0D8FF"':'');?> ><strong>SERVICIO  1,500 KMS.</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  
				<?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor,  líquido de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpia parabrisas, electrolito de batería</li>
                  
                <?php
				}
				?>
                
                  
                  </ul></td>
              <td width="33%" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==2)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  DE 5,000 KMS.</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                  
                  
                  <?php
				if($GET_Completo<> "No"){
				?>
                <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor,  líquido de frenos, líquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería</li>
                    <?php
				}
				?>
                
                
                
                  </ul></td>
              <td width="33%" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==3)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 10,000  KMS.</strong>
                <ul>
                <li>Cambio de bujias</li>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                  
                  <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor, líquido  de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería, caja, transferencia y coronas</li>
                  <?php
				}
				  ?>
                  
                  
                  </ul></td>
              </tr>
            <tr>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==4)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  15,000 KMS.</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                  <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor,  líquido de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería</li>
                  <?php
				}
								?>
                
                  </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==5)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  20,000 KMS</strong>
                <ul>
                <li>Cambio de bujias</li>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                  <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar correa de accesorios</li>
                  <li>Inspeccionar filtro de aire</li>
                   <?php
				}
				?>
                  <li>Cambio de filtro de combustible</li>
                  
                 <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar filtro de a/c y operación</li>
                  <li>Inspeccionar guardapolvos palier</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor, líquido  de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería, caja, transferencia y coronas</li>
                  <?php
				}
				  ?>
                  </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==6)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 25,000  KMS</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                   <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor,  líquido de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería.</li>
                   <?php
				}
				?>
                
                  </ul></td>
              </tr>
            <tr>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==7)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 30,000  KMS.</strong>
                <ul>
                <li>Cambio de bujias</li>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                   <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor, fluido  de dirección hidráulica, agua limpiaparabrisas, electrolito de batería, caja,  transferencia y coronas</li>
                  <?php
				}
				  ?>
                  </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==8)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 35,000  KMS.</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
					<?php
					if($GET_Completo<> "No"){
					?>
                  <li>Inspeccionar correa de accesorios</li>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar mangueras del sist. Enfriamiento</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor, líquido  de frenos, liquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería</li>
					<?php
					}
					?>
                  </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==9)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO 40,000 KMS.</strong>
                <ul>
                	<li>Cambio de bujia</li>
                    <li>Cambio de filtro de combustible</li>
                    <li>Cambio de filtro de aire</li>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                  
					<?php
					if($GET_Completo<> "No"){
					?>
                  <li>Inspeccionar correa de accesorios</li>
                  <li>Inspección presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de líquido de frenos,  electrolito de batería, liquido de embrague, fluido de dirección hidráulica,  agua limpia parabrisas</li>
					<?php
					}
					?>
                    <li>Cambio de refrigerante</li>
                  <li>Cambio  de aceite de caja, transferencia y coronas</li>
                  </ul></td>
              </tr>
            <tr>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==10)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO 45,000  KMS.</strong>
                <ul>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
                <?php
				if($GET_Completo<> "No"){
				?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor,  líquido de frenos, liquido de embrague, fluido de dirección hidráulica, agua limpia  parabrisas, electrolítico de batería</li>
                <?php
				}
				?>
                  
                  </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==11)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 50,000  KMS.</strong>
                <ul>
                  <li>Cambio de bujías</li>
                  <li>Cambio de aceite de motor</li>
                  <li>Cambio de filtro de aceite</li>
					<?php
					if($GET_Completo<> "No"){
					?>
                  <li>Inspeccionar filtro de aire</li>
                  <li>Inspeccionar freno de mano</li>
                  <li>Inspeccionar presión de los neumáticos</li>
                  <li>Ajustar tuercas de ruedas</li>
                  <li>Revisar niveles de refrigerante de motor, líquido  de frenos, líquido de embrague, fluido de dirección hidráulica, agua  limpiaparabrisas, electrolito de batería, caja, transferencia y coronas</li>
                  <?php
					}
				  ?>
                  </ul></td>
              <td align="left" valign="bottom"><p>
              Importante:<br />
              En caso el cliente ​no se acerque al taller a realizar el mantenimiento respectivo estipulado en el manual de mantenimiento, perderá los beneficios de dicho mantenimiento.</p></td>
              </tr>
            </tbody>
          </table>
        
        <?php
		}else if($InsOrdenVentaVehiculo->VmaId == "VMA-10018"){
		?>
        <table class="EstOrdenVentaVehiculoImprimirTablaPlanMantenimiento" width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody class="EstOrdenVentaVehiculoImprimirTablaPlanMantenimientoBody">
            <tr>
              <td width="33" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==1)?'bgcolor="B0D8FF"':'');?> ><strong>SERVICIO  1000 KMS.</strong>
                <ul>
                 
<li>	I	-	ARRANQUE DEL MOTOR Y RUIDO NORMAL	</li>
<li>	R	-	ACEITE DE MOTOR  15W40	</li>
<li>	I	-	TUBERÍAS DEL TURBOCARGADOR	</li>
<li>	A	-	HOLGURA DE VALVULA	</li>
<li>	T	-	MULTIPLES DE ADMISION Y ESCAPE	</li>
<li>	T	-	TUERCAS DE TORNILLO U DEL MUELLE DE HOJAS	</li>
<li>	T	-	TUERCAS DE RUEDA Y PERNOS DE RUEDA	</li>


                  </ul></td>
              <td width="33%" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==2)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  DE 5,000 KMS.</strong>
                <ul>

<li>	R	-	ACEITE DE MOTOR  15W40	</li>
<li>	R	-	FILTRO DE ACEITE DE MOTOR	</li>
<li>	R	-	ARANDELA DE CARTER	</li>
<li>	R	-	FILTRO ELEMENTO PCV DEL TURBOCARGADOR	</li>
<li>	I	-	TUBERÍAS DEL TURBOCARGADOR	</li>
<li>	I	-	JUEGO LIBRE DEL VOLANTE DE DIRECCION	</li>
<li>	I	-	FUNCIONALIDAD DEL MECANISMO DE DIRECCION	</li>
<li>	I	-	PRESION DE AIRE Y DAÑOS EN LAS LLANTAS	</li>

                  </ul></td>
              <td width="33%" align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==3)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO DE 10,000  KMS.</strong>
                <ul>
               
<li>	I	-	ARRANQUE DEL MOTOR Y RUIDO NORMAL	</li>
<li>	R	-	ACEITE DE MOTOR  15W40	</li>
<li>	R	-	FILTRO DE ACEITE DE MOTOR	</li>
<li>	R	-	ARANDELA DE CARTER	</li>
<li>	I	-	CONTAMINACION DEL ACEITE	</li>
<li>	I	-	FILTRO  DE AIRE	</li>
<li>	I	-	CONEXIÓN Y JUNTA DEL TURBOCARGADOR AL DUCTO DE AIRE 	</li>
<li>	I	-	AFLOJAMIENTO O MONTAJE INCORRECTO DEL TUBO DE ESCAPE	</li>
<li>	R	-	FILTRO DE COMBUSTIBLE	</li>
<li>	I	-	COLADOR DE TANQUE DE COMBUSTIBLE	</li>
<li>	I	-	TUBERÍAS DEL TURBOCARGADOR	</li>
<li>	I	-	TANQUE DE COMBUSTIBLE INTERIOR	</li>
<li>	I	-	VELOCIDAD DE RALENTI Y ACELERACION	</li>
<li>	I	-	CIRCUITO DE ENFRIAMIENTO Y RADIADOR	</li>
<li>	I	-	FUNCIONAMIENTO DEL TAPON DEL RADIADOR O TAPON DEL TANQUE AUXILIAR DEL RADIADOR	</li>
<li>	I	-	DAÑOS EN LA BANDA DEL VENTILADOR	</li>
<li>	I	-	LIQUIDO DE EMBRAGUE 	</li>
<li>	I	-	FUNCIONAMIENTO DEL SISTEMA DE EMBRAGUE	</li>
<li>	I	-	CARRERA Y JUEGO LIBRE DEL PEDAL DE EMBRAGUE	</li>
<li>	I	-	CUBIERTA DE ESCAPE DEL REFORZADOR DE EMBRAGUE	</li>
<li>	I	-	ACEITE  DEL ENGRANAJE DIFERENCIAL HD 80W90	</li>
<li>	I	-	ACEITE DE ENGRANAJES DEL INTERDIFERENCIAL MODELO FVZ	</li>
<li>	I	-	FUGAS DE ACEITE DEL SISTEMA DE FRENOS	</li>
<li>	I	-	LIQUIDO  DIRECCION HIDRAULICA ATF (DEXRON III)	</li>
<li>	I	-	JUEGO LIBRE DEL VOLANTE DE DIRECCION	</li>
<li>	I	-	FUNCIONALIDAD DEL MECANISMO DE DIRECCION	</li>
<li>	I	-	AFLOJAMIENTO DEL MECANISMO DE CONTROL DE ENGRANAJES	</li>
<li>	I	-	DAÑOS EN LOS MUELLES	</li>
<li>	T	-	TUERCAS DE RUEDA Y PERNOS DE RUEDA	</li>
<li>	I	-	PRESION DE AIRE Y DAÑOS EN LAS LLANTAS	</li>
<li>	I	-	OBJETOS EXTRAÑOS EN LAS RUEDAS	</li>
<li>	I	-	AFLOJAMIENTO EN LOS COJINETES DE LA MAZA DE RUEDA DELANTERA	</li>
<li>	I	-	 GREASE PUNTOS DE  ENGRASE (7 puntos)	</li>



                </ul></td>
              </tr>
            <tr>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==4)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  15,000 KMS.</strong>
                <ul>
                 
<li>	R	-	ACEITE DE MOTOR  15W40	</li>
<li>	R	-	FILTRO DE ACEITE DE MOTOR	</li>
<li>	R	-	ARANDELA DE CARTER	</li>
<li>	R	-	FILTRO ELEMENTO PCV DEL TURBOCARGADOR	</li>
<li>	I	-	TUBERÍAS DEL TURBOCARGADOR	</li>
<li>	I	-	JUEGO LIBRE AXIAL Y RADIAL DEL TURBOCARGADOR	</li>
<li>	I	-	DESGASTE DEL TAMBOR Y FORRO DE LA ZAPATA DE FRENO	</li>
<li>	I	-	CARRERA Y JUEGO LIBRE DEL PEDAL DE FRENO	</li>
<li>	I	-	CABLE DEL FRENO DE ESTACIONAMIENTO	</li>
<li>	I	-	FUNCIONALIDAD DEL FRENO DE ESTACIONAMIENTO 	</li>
<li>	I	-	JUEGO LIBRE DEL VOLANTE DE DIRECCION	</li>
<li>	I	-	FUNCIONALIDAD DEL MECANISMO DE DIRECCION	</li>
<li>	I	-	PRESION DE AIRE Y DAÑOS EN LAS LLANTAS	</li>


                </ul></td>
              <td align="left" valign="top" <?php echo (($GET_NumeroMantenimiento==5)?'bgcolor="B0D8FF"':'');?>><strong>SERVICIO  20,000 KMS</strong>
                <ul>

<li>	I	-	ARRANQUE DEL MOTOR Y RUIDO NORMAL	</li>
<li>	R	-	ACEITE DE MOTOR  15W40	</li>
<li>	R	-	FILTRO DE ACEITE DE MOTOR	</li>
<li>	R	-	ARANDELA DE CARTER	</li>
<li>	I	-	CONTAMINACION DEL ACEITE	</li>
<li>	R	-	FILTRO  DE AIRE	</li>
<li>	I	-	CONEXIÓN Y JUNTA DEL TURBOCARGADOR AL DUCTO DE AIRE 	</li>
<li>	I	-	AFLOJAMIENTO O MONTAJE INCORRECTO DEL TUBO DE ESCAPE	</li>
<li>	R	-	FILTRO DE COMBUSTIBLE	</li>
<li>	I	-	COLADOR DE TANQUE DE COMBUSTIBLE	</li>
<li>	I	-	TUBERÍAS DEL TURBOCARGADOR	</li>
<li>	I	-	TANQUE DE COMBUSTIBLE INTERIOR	</li>
<li>	I	-	VELOCIDAD DE RALENTI Y ACELERACION	</li>
<li>	I	-	LIQUIDO REFRIGERANTE RADIADOR 	</li>
<li>	I	-	CIRCUITO DE ENFRIAMIENTO Y RADIADOR	</li>
<li>	I	-	FUNCIONAMIENTO DEL TAPON DEL RADIADOR O TAPON DEL TANQUE AUXILIAR DEL RADIADOR	</li>
<li>	I	-	DAÑOS EN LA BANDA DEL VENTILADOR	</li>
<li>	I	-	LIQUIDO DE EMBRAGUE 	</li>
<li>	I	-	FUNCIONAMIENTO DEL SISTEMA DE EMBRAGUE	</li>
<li>	I	-	CARRERA Y JUEGO LIBRE DEL PEDAL DE EMBRAGUE	</li>
<li>	I	-	CUBIERTA DE ESCAPE DEL REFORZADOR DE EMBRAGUE	</li>
<li>	R	-	ACEITE DE TRANSMISION MANUAL  	</li>
<li>	I	-	ACEITE  DEL ENGRANAJE DIFERENCIAL HD 80W90	</li>
<li>	I	-	ACEITE DE ENGRANAJES DEL INTERDIFERENCIAL MODELO FVZ	</li>
<li>	I	-	LIQUIDO DE FRENO 	</li>
<li>	I	-	FUGAS DE ACEITE DEL SISTEMA DE FRENOS	</li>
<li>	I	-	LIQUIDO  DIRECCION HIDRAULICA ATF (DEXRON III)	</li>
<li>	I	-	JUEGO LIBRE DEL VOLANTE DE DIRECCION	</li>
<li>	I	-	FUNCIONALIDAD DEL MECANISMO DE DIRECCION	</li>
<li>	I	-	AFLOJAMIENTO DEL MECANISMO DE CONTROL DE ENGRANAJES	</li>
<li>	T	-	TUERCAS DE RUEDA Y PERNOS DE RUEDA	</li>
<li>	I	-	PRESION DE AIRE Y DAÑOS EN LAS LLANTAS	</li>
<li>	I	-	OBJETOS EXTRAÑOS EN LAS RUEDAS	</li>
<li>	I	-	AFLOJAMIENTO EN LOS COJINETES DE LA MAZA DE RUEDA DELANTERA	</li>
<li>	I	-	 GREASE PUNTOS DE  ENGRASE (7 puntos)	</li>


                </ul></td>
              <td align="left" valign="bottom" <?php echo (($GET_NumeroMantenimiento==6)?'bgcolor="B0D8FF"':'');?>>
              
R   -   Remmplazar.<br />
I   -   Inspeccionar , limpiar o reparar según sea necesario<br />
A   -   Ajustar<br />
T   -   Apretar al par de apriete especificado<br />
L   -   Lubricar<br /><br />

              
              
              Importante:<br />
                En caso el cliente ​no se acerque al taller a realizar el mantenimiento respectivo estipulado en el manual de mantenimiento, perderá los beneficios de dicho mantenimiento.</td>
            </tr>
            </tbody>
          </table>
        <?php	
		}
		?>
        
        
      </td>
      </tr>
    <tr>
      <td colspan="3" align="center" valign="bottom" >
        
        <table width="100%">
          <tr>
            <td width="50%" align="center">
              
              
              <br /><br /><br />
              
              <span class="EstOrdenVentaVehiculoImprimirNota3"> 
                
                ______________________________ <br />
                
                
                
                <?php
$i = 1;
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
                
                
                <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?>
                
                <?php
		if($i == 1){
		break;
		}
		?> 
                <?php	
		$i++;	
	}
}
?>
                <br />  
                Cliente
                
                
                
                
                
                
                </span>
              
              
              
              
              </td>
            <td width="50%" align="center">
              
              
              <br /><br /><br />
              
              ______________________________
              <br />
              <span class="EstOrdenVentaVehiculoImprimirNota3"> <?php echo $InsOrdenVentaVehiculo->PerNombre;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoMaterno;?> <br />
                Asesor de Ventas<br />
                <?php echo $EmpresaNombre;?><br />
                
                
                </span>
              </td>
            </tr>
          </table>
        
        </td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>


<!--<p align="center">
        <span class="EstOrdenVentaVehiculoImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
        Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>
</p>
-->
 
 
</body>
</html>
