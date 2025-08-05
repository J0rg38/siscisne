<?php
@session_start();
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


require_once($InsProyecto->MtdRutLibrerias().'phpqrcode/qrlib.php');


$GET_id = $_GET['Id'];


require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();

$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();

///MtdObtenerVehiculoCaracteristicaSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL,1);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,"VveNombre","ASC",NULL,NULL,$InsCotizacionVehiculo->VmoId,1,1);
$ArrVehiculoVersiones = $RepVehiculoVersion['Datos'];
?>

<?php
//deb($InsCotizacionVehiculo->CveDescuento);
if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId){
	
	if(!empty($InsCotizacionVehiculo->CveTipoCambio)){
		
		$InsCotizacionVehiculo->CveTotalUnitario = round($InsCotizacionVehiculo->CveTotalUnitario / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio / $InsCotizacionVehiculo->CveTipoCambio,2);
		$InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento / $InsCotizacionVehiculo->CveTipoCambio,2);
		
	}else{
		
		$InsCotizacionVehiculo->CveTotal = 0;
		$InsCotizacionVehiculo->CveTotalUnitario = 0;
		$InsCotizacionVehiculo->CvePrecio = 0;
		$InsCotizacionVehiculo->CveDescuento = 0;
		
	}
}
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotizacion No. <?php echo $InsCotizacionVehiculo->CveId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssCotizacionVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsCotizacionVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsCotizacionVehiculo->CveId)){?> 
FncCotizacionVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<div class="EstCotizacionVehiculoCabecera">

    <table cellpadding="0" cellspacing="0" width="100%" border="0">
<!--    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>-->
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="center" valign="top"><?php
	  
	  //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsCotizacionVehiculo->VmaId){
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
        <img src="../../imagenes/membretes/cabecera_simple.png" width="953"  />
        <?php 
		  break;
	  }
	  ?>
      </td>
      <td align="right" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top">&nbsp;</td>
      <td width="46%" align="center" valign="top"><span class="EstPlantillaTitulo">COTIZACION</span> <span class="EstPlantillaTituloCodigo"> <?php echo $InsCotizacionVehiculo->CveId;?></span></td>
      <td width="31%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
      </tr>
    </table>

</div>









<hr class="EstReporteLinea">




   <table width="100%" border="0" cellpadding="0" cellspacing="1" class="EstCotizacionVehiculoImprimirTabla">
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0"  class="EstCotizacionVehiculoImprimirTabla">
        <tr>
          <td width="20%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Fecha de Cotizacion:</span></td>
          <td width="80%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->CveFecha;?></span></td>
        </tr>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstPlantillaImprimirTabla">
        <thead class="EstPlantillaImprimirTablaHead">
          <tr>
            <th colspan="2" align="left">Vehiculo</th>
          </tr>
        </thead>
        <tbody class="EstPlantillaImprimirTablaBody">
          <tr>
            <td width="19%" align="left" valign="middle"><span class="EstCotizacionVehiculoImprimirEtiqueta">Modelo/Año:</span></td>
            <td width="81%" align="left" valign="middle"><span class="EstCotizacionVehiculoImprimirMarcaModeloVersionPrincipal"><?php echo $InsCotizacionVehiculo->VmaNombre;?> <?php echo $InsCotizacionVehiculo->VmoNombre;?> <?php echo $InsCotizacionVehiculo->VveNombre;?>
                <?php //echo $InsCotizacionVehiculo->CveAdicional;?>
                <?php
		if(!empty($InsCotizacionVehiculo->CveAnoFabricacion)){
		?>
- Fabricacion <?php echo $InsCotizacionVehiculo->CveAnoFabricacion;?>
<?php	
		}
		?>
<?php
		if(!empty($InsCotizacionVehiculo->CveAnoModelo)){
		?>
- Modelo <?php echo $InsCotizacionVehiculo->CveAnoModelo;?>
<?php	
		}
		?>
        
        <?php
		if(!empty($InsCotizacionVehiculo->CveColor)){
		?>
- Color <?php echo $InsCotizacionVehiculo->CveColor;?>
<?php	
		}
		?>
        
        
        
            </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstCotizacionVehiculoImprimirEtiqueta">Adicionales:</span></td>
            <td align="left" valign="middle">
            <span class="EstCotizacionVehiculoImprimirContenido">
			
			
            <?php
			if(!empty($InsCotizacionVehiculo->CotizacionVehiculoObsequio)){
				foreach($InsCotizacionVehiculo->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio){
			?>
            	<?php echo $DatCotizacionVehiculoObsequio->ObsNombre;?>/
            <?php		
				}
			}
			?>
			
			
			<?php echo $InsCotizacionVehiculo->CveAdicional;?>
            
            <?php 
			if($InsCotizacionVehiculo->CveGLP=="Si"){
			?>
            Incluye GLP
            <?php	
			}else{
			?>
            
            <?php	
			}
			?>
            
            
            </span>
            
            </td>
          </tr>
        </tbody>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="2%" align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="46%" align="left" valign="top" >
      
      <table  class="EstCotizacionVehiculoImprimirTabla" width="100%" border="0" cellpadding="2" cellspacing="2">
      <thead class="EstPlantillaImprimirTablaHead">
        <tr>
          <th colspan="2" align="left" valign="top">Cliente</th>
        </tr>
      </thead>
        <tr>
          <td width="12%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">RUC/DNI:</span></td>
          <td width="38%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido"> <?php echo $InsCotizacionVehiculo->TdoNombre;?>: <?php echo $InsCotizacionVehiculo->CliNumeroDocumento;?> </span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Nombres:</span></td>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->CliNombre;?> <?php echo $InsCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $InsCotizacionVehiculo->CliApellidoMaterno;?> </span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Celular:</span></td>
          <td align="left" valign="top"><!--<span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->CliDireccion;?></span>--><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->CliCelular;?></span></td>
        </tr>
      </table></td>
      <td width="50%" align="left" valign="top" ><table  class="EstCotizacionVehiculoImprimirTabla" width="100%" border="0" cellpadding="2" cellspacing="2">
         <thead class="EstPlantillaImprimirTablaHead">
        <tr>
          <th colspan="3" align="left" valign="top">Asesor de Ventas</th>
          </tr>
      </thead>
        <tr>
          <td width="25%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Nombre:</span></td>
          <td width="54%" align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->PerNombre;?> <?php echo $InsCotizacionVehiculo->PerApellidoPaterno;?> <?php echo $InsCotizacionVehiculo->PerApellidoMaterno;?></span></td>
          <td width="21%" rowspan="5" align="left" valign="top"><?php

	if(!empty($InsCotizacionVehiculo->PerId)){
		
		$InsPersonal = new ClsPersonal();
		$InsPersonal->PerId = $InsCotizacionVehiculo->PerId;
		$InsPersonal->MtdObtenerPersonal();
		
		$tempDir = $InsPoo->Ruta.'generados/';
	
		// here our data
		$name         = $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno;
		$sortName     = $InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno.';'.$InsPersonal->PerNombre;
		$phone        = $InsPersonal->PerTelefono;
		$phonePrivate = '';
		$phoneCell    = $InsPersonal->PerCelular;
		$orgName      = $EmpresaNombre ;
		$email        = $InsPersonal->PerEmail;
	
		// if not used - leave blank!
		$addressLabel     = '';
		$addressPobox     = '';
		$addressExt       = '';
		$addressStreet    = '';
		$addressTown      = '';
		$addressRegion    = '';
		$addressPostCode  = '';
		$addressCountry   = '';
	
		// we building raw data
		$codeContents  = 'BEGIN:VCARD'."\n";
		$codeContents .= 'VERSION:2.1'."\n";
		$codeContents .= 'N:'.$sortName."\n";
		$codeContents .= 'FN:'.$name."\n";
		$codeContents .= 'ORG:'.$orgName."\n";
	
		$codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
		$codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n";
		$codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n";
	
		$codeContents .= 'ADR;TYPE=work;'.
			'LABEL="'.$addressLabel.'":'
			.$addressPobox.';'
			.$addressExt.';'
			.$addressStreet.';'
			.$addressTown.';'
			.$addressPostCode.';'
			.$addressCountry
		."\n";
	
		$codeContents .= 'EMAIL:'.$email."\n";
	
		$codeContents .= 'END:VCARD';

    // generating
    QRcode::png($codeContents, $tempDir.$InsPersonal->PerId.'026.png', QR_ECLEVEL_L, 3);

    // displaying
   //echo '<img src="'.$tempDir.$InsPersonal->PerId.'026.png" />'; 
   
?>
            <img src="<?php echo $tempDir.$InsPersonal->PerId;?>026.png" width="120" height="120" />
          <?php
	}

?></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Contacto:</span></td>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido">
            <?php
		if(!empty($InsCotizacionVehiculo->PerTelefono)){
		?>
            Tel.: <?php echo $InsCotizacionVehiculo->PerTelefono;?>
  <?php
		}
		?>
  <?php
		if(!empty($InsCotizacionVehiculo->PerCelular)){
		?>
            / Cel.:<?php echo $InsCotizacionVehiculo->PerCelular;?>
  <?php
		}
		?>
          </span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirEtiqueta">Email:</span></td>
          <td align="left" valign="top"><span class="EstCotizacionVehiculoImprimirContenido">
            <?php
		if(!empty($InsCotizacionVehiculo->PerEmail)){
		?>
            Email: <?php echo $InsCotizacionVehiculo->PerEmail;?>
  <?php
		}
		?>
          </span></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
      
		

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstPlantillaImprimirTabla">
       <thead class="EstPlantillaImprimirTablaHead">
       <tr>
         <th colspan="2" align="left">Precio</th>
         </tr>
        </thead>
         <tbody class="EstPlantillaImprimirTablaBody">
         
<?php
if(!empty($InsCotizacionVehiculo->CvePrecio)){
?>

       <tr>
         <td align="left"><span class="EstCotizacionVehiculoImprimirEtiqueta">Precio Base:</span></td>
         <td align="left"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->MonSimbolo;?></span> <span class="EstCotizacionVehiculoImprimirContenido"><?php echo number_format($InsCotizacionVehiculo->CvePrecio,2);?></span></td>
       </tr>
<?php	
}
?>


       <tr>
         <td align="left"><span class="EstCotizacionVehiculoImprimirEtiqueta">Precio Unitario:</span></td>
         <td align="left"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo $InsCotizacionVehiculo->MonSimbolo;?></span> <span class="EstCotizacionVehiculoImprimirContenido"><?php echo number_format($InsCotizacionVehiculo->CveTotalUnitario,2);?></span></td>
       </tr>
       <tr>
         <td align="left"><span class="EstCotizacionVehiculoImprimirEtiqueta">Cantidad:</span></td>
         <td align="left"><span class="EstCotizacionVehiculoImprimirContenido"><?php echo number_format($InsCotizacionVehiculo->CveCantidad,2);?></span></td>
       </tr>
       <tr>
         <td width="25%" align="left"><span class="EstCotizacionVehiculoImprimirEtiqueta">PRECIO TOTAL:</span></td>
         <td width="25%" align="left"><span class="EstCotizacionVehiculoImprimirPrecio"><?php echo $InsCotizacionVehiculo->MonSimbolo;?></span> <span class="EstCotizacionVehiculoImprimirPrecio"><?php echo number_format($InsCotizacionVehiculo->CveTotal,2);?></span></td>
         </tr>
        </tbody>
        </table>
        
        
        
       
        
        
        
        
	  </td>
      <td align="left" valign="top" ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <thead class="EstPlantillaImprimirTablaHead">
       <tr>
         <th colspan="2">Fotos</th>
         </tr>
        </thead>
        <tr>
          <td colspan="2" align="center"><?php
		

		if(!empty($InsCotizacionVehiculo->CveFoto)){
		?>
            <img src="../../subidos/cotizacion_vehiculo_fotos/<?php echo $InsCotizacionVehiculo->CveFoto;?>" alt="" height="150"  /> <br />
            <span class="EstCotizacionVehiculoImprimirSubContenido">* Foto Referencial</span>
            <?php
		}else if(!empty($InsCotizacionVehiculo->VveFoto)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsCotizacionVehiculo->VveFoto;?>" alt="" height="150"  /> <br />
            <span class="EstCotizacionVehiculoImprimirReferencias">* Foto Referencial</span>
          <?php
		}
		?></td>
        </tr>
        <tr>
          <td align="center"><?php
		if(!empty($InsCotizacionVehiculo->VveFotoLateral)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsCotizacionVehiculo->VveFotoLateral;?>" alt="" height="60"  /> <br />
            <span class="EstCotizacionVehiculoImprimirReferencias">Foto Lateral</span>
            <?php
		}
		?></td>
          <td align="center"><?php
		if(!empty($InsCotizacionVehiculo->VveFotoPosterior)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsCotizacionVehiculo->VveFotoPosterior;?>" alt="" height="60"  /> <br />
            <span class="EstCotizacionVehiculoImprimirReferencias">Foto Posterior</span>
            <?php
		}
		?></td>
        </tr>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <!--    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" >
      
      
      
      <?php //echo $InsCotizacionVehiculo->VehInformacion;?>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>-->
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><?php
		if(!empty($InsCotizacionVehiculo->VveFotoCaracteristica)){
			
		?>
        <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsCotizacionVehiculo->VveFotoCaracteristica;?>" alt="" width="100%" /> <br />
       <!-- <span class="EstCotizacionVehiculoImprimirReferencias">Foto Posterior</span>-->
      <?php
		}
		?></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><?php
if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta) or !empty($InsCotizacionVehiculo->CveCondicionVentaOtro) ){	
?>

  
<!--<p>-->
<span class="EstCotizacionVehiculoImprimirTitulo">Precio incluye: </span>
<!--</p>-->
<br />
<!--<p>-->

<span class="EstCotizacionVehiculoImprimirContenido">
	
  			
            
                <?php
			  	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){	
					foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta ){
				?>
                	-  <?php echo $DatCotizacionVehiculoCondicionVenta->CovNombre;?> 
                <?php						
					}
				}				
				?>
         

			
<?php
if(!empty($InsCotizacionVehiculo->CveCondicionVentaOtro)){
?>
- <?php echo $InsCotizacionVehiculo->CveCondicionVentaOtro;?>
<?php	
}
?>

           
</span>

 <br />        
 
<!--</p>-->

<?php
}
?>




<?php
if(!empty( $InsCotizacionVehiculo->CveObservacion)){
?>
 
	<br />
 
    <span class="EstCotizacionVehiculoImprimirTitulo">
    Observaciones:
    </span>
    
    <br />
    
   <!-- <p align="justify">-->
    <span class="EstCotizacionVehiculoImprimirObservacion">
    <?php echo $InsCotizacionVehiculo->CveObservacion;?>
    </span>
   <!-- </p>-->
    <br />
<?php	
}
?>


<?php
/*
?>
<br />
<span class="EstCotizacionVehiculoImprimirTitulo">
Entrega:
</span>

<br />

<!--<p align="justify">-->
<span class="EstCotizacionVehiculoImprimirSubContenido">
- La entrega esta sujeta a la disponibilidad de stock y colores al momento de su decisi&oacute;n de compra.  Confirmada la disponibilidad de stock asignado el veh&iacute;culo solicitado, el cliente deber&aacute; proporcionar a <?php echo $EmpresaNombre;?> los documentos necesarios a fin de iniciar ante Registros P&uacute;blicos el registro vehicular de su propiedad. <?php echo $EmpresaNombre;?> le brindar&aacute; el detalle oportuno de los documentos que se requiere para dicho prop&oacute;sito. El registro vehicular demora alrededor de 15 (quince) dias &uacute;tiles para la entrega de la tarjeta de propiedad y placas de rodaje, este plazo rige luego de presentar el expediente ante Registros P&uacute;blicos. Si existiera alguna observaci&oacute;n de Registros P&uacute;blicos durante el tr&aacute;mite del registro vehicular que ocasione demora en la entrega del vehiculo, este retraso no sera imputable a <?php echo $EmpresaNombre;?>.<br />


	<?php
    if(!empty($Garantia)){
    ?>
    
    <?php	echo $Garantia;?>
    
    <?php
    }else{
    ?>
    - Garantía 05 años ó 100,000 kilómetros, lo que ocurra primero
    <?php	
    }
    ?>

 <br />  
</span>	
<!--</p>
-->

<?php
*/
?>

        <?php 
		/*if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
		?>	 <span class="EstCotizacionVehiculoImprimirEtiqueta">Vigencia de la cotizaci&oacute;n hasta el</span>
        <?php  echo $InsCotizacionVehiculo->CveFechaVigencia;?>        
        <?php
		}*/
		?>
        
        <?php
		if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
		?>
        
        <br />
        
        <span class="EstCotizacionVehiculoImprimirTitulo">Vigencia:</span>
        
        <br />
		
       <!-- <p align="justify">-->
        <span class="EstCotizacionVehiculoImprimirSubContenido">
        - Cotizaci&oacute;n válida hasta el <?php echo $InsCotizacionVehiculo->CveFechaVigencia; ?>
        </span> 
      	<!--</p>-->
        <br />
        <?php	
		}
		?>
       
           <?php
		/*if(!empty($InsCotizacionVehiculo->CotizacionVehiculoFoto)){
		?>
        <br />
       
        <span class="EstCotizacionVehiculoImprimirEtiqueta">Fotos Adicionales:</span>
        
        <br />
        
        <?php
		foreach($InsCotizacionVehiculo->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
		?>
        <img height="160" src="../../subidos/cotizacion_vehiculo_fotos/<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" alt="<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" title="<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" border="0" />
        <?php	
		}
		?>
      
        <br />
        
        <?php	
		}*/
		?>     
        
       <br />
       
        <span class="EstCotizacionVehiculoImprimirTitulo">Numeros de Cuenta:</span>
        
		<br />
		
       <!-- <p align="justify">
      -->  
      
      <?php
	  
	  if(file_exists("cnf/Cuentas".$InsCotizacionVehiculo->SucSiglas.".php")){
		  include("cnf/Cuentas".$InsCotizacionVehiculo->SucSiglas.".php");
	  }
	  
	  ?>
	  
		<!--<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionVehiculoImprimirSubContenido">
        <tr>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido"><b>BANCO DE CREDITO DEL PERU</b></span></td>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido">- <b>BANCO CONTINENTAL</b></span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">- <b>BANCO SCOTIABANK </b></span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">- <b>INTERBANK</b></span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">- <b>CAJA AREQUIPA </b></span></td>
          </tr>
        <tr>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido">SOLES	215-1603833-0-49</span></td>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido">SOLES	226-01000214118</span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">DOLARES	3037125</span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">DOLARES	325-300046878-8</span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">DOLARES	00053010602110102003</span></td>
          </tr>
        <tr>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido">DOLARES	215-1611248-1-58</span></td>
          <td>  <span class="EstCotizacionVehiculoImprimirSubContenido">DOLARES	220-150100081187</span></td>
          <td>&nbsp;</td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">CODIGO RECAUDO	07621</span></td>
          <td><span class="EstCotizacionVehiculoImprimirSubContenido">SOLES	004-102-00202026695</span></td>
          </tr>
        <tr>
          <td> <span class="EstCotizacionVehiculoImprimirSubContenido">RECAUDADORA	215-1637703-1-80</span></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        </table>-->
        
    <!--    </p>-->
        
        
		  
        

 

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
 
  

<p align="right">
        <span class="EstPlantillaPie">
        
        <?php echo $EmpresaNombre;?> - R.U.C.: <?php echo $EmpresaCodigo;?><br />
       <!-- Arequipa: Av. Jacinto Ibañez 490 Parque Industrial – Telf. 054-232741 / Av. Parra 253 – Cercado – Arequipa  -Telf. 054-204620 / Av. Ejército 1059 - Cayma-->
       
       
       
        
        
       <?php echo $_SESSION['SesionSucursalDepartamento'];?>: <?php echo $_SESSION['SesionSucursalDireccion'];?> - <?php echo $_SESSION['SesionSucursalProvincia'];?> - <?php echo $_SESSION['SesionSucursalDistrito'];?><br />
       
       <?php
	   if(!empty($_SESSION['SesionSucursalTelefono'])){
	?>
    		Telefono: <?php echo $_SESSION['SesionSucursalTelefono'];?>
    <?php
	   }
	   ?>
       
         <?php
	   if(!empty($_SESSION['SesionSucursalEmail'])){
	?>
    		Email: <?php echo $_SESSION['SesionSucursalEmail'];?>
    <?php
	   }
	   ?>
       
       
        </span>
</p>

 
</body>
</html>
