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
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

$InsVehiculoVersion = new ClsVehiculoVersion();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

$InsVehiculoVersion->VveId = $GET_id;
$InsVehiculoVersion->MtdObtenerVehiculoVersion();		
	
	
	$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotizacion No. <?php echo $InsVehiculoVersion->VveId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoVersionImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoVersionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoVersion->VveId)){?> 
FncVehiculoVersionImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<div class="EstVehiculoVersionCabecera">

    <table cellpadding="0" cellspacing="0" width="100%" border="0">
<!--    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>-->
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top">
     
      
      <?php
	  
	  //deb($InsVehiculoVersion->VmaId);
	  switch($InsVehiculoVersion->VmaId){
		  case "VMA-10017":
	?>
     <img src="../../imagenes/cabecera_chevrolet.png" width="100%"  />
    <?php  
		  break;
		  
		  case "VMA-10018":
	?>
     <img src="../../imagenes/cabecera_isuzu.png" width="100%"  />
    <?php	  
		  break;
		  
		  default:
		 ?>
          <img src="../../imagenes/cabecera_cyc.png" width="100%"  />
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

</div>









<hr class="EstReporteLinea">




   <table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstVehiculoVersionImprimirTabla">
    <tr>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">


      <span class="EstPlantillaTitulo">CATALOGO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsVehiculoVersion->VmaNombre;?> <?php echo $InsVehiculoVersion->VmoNombre;?> <?php echo $InsVehiculoVersion->VveNombre;?></span>
    
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoVersionImprimirEtiquetaFondo">&nbsp;</td>
      <td width="46%" align="left" valign="top" >&nbsp;</td>
      <td width="48%" align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoVersionImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
		<?php
		
		//deb($InsVehiculoVersion->VveId);
		//deb($InsVehiculoVersion->VveFoto);
		if(!empty($InsVehiculoVersion->VveFoto)){
		?>
			<img src="../../subidos/vehiculo_version_fotos/<?php echo $InsVehiculoVersion->VveFoto;?>" width="362"  />
            <br />
            * Foto Referencial
		<?php
		}
		?>
		
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <!--    <tr>
      <td align="left" valign="top" class="EstVehiculoVersionImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" >
      
      
      
      <?php //echo $InsVehiculoVersion->VehInformacion;?>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>-->
    <tr>
      <td align="left" valign="top" class="EstVehiculoVersionImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
        
        
        
        
        <?php

//deb($InsVehiculoVersion->VehiculoVersionCaracteristica);


if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$secciones=0;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	
	
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId and $DatVehiculoVersionCaracteristica->VvcAnoModelo == $GET_Ano ){
							$secciones++;
							break;
						}
					}
				}
				
	}
}

if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$i=1;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	$MostrarSeccion = false;
	
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId and $DatVehiculoVersionCaracteristica->VvcAnoModelo == $GET_Ano ){
							$MostrarSeccion = true;
							break;
						}
					}
				}
							
	?>
	<?php
	if($MostrarSeccion){
	?>
        
        <table width="750" border="1" cellpadding="1" cellspacing="0" class="EstVehiculoVersionImprimirCaracteristica">
          <thead class="EstVehiculoVersionImprimirCaracteristicaHead">
            <tr>
            
   
    
      
              <th width="<?php echo (($InsVehiculoVersion->VmaId=="VMA-10018")?'33%':'67%')?>" align="center" ><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre?></th>
              <th width="<?php echo (($InsVehiculoVersion->VmaId=="VMA-10018")?'67%':'33%');?>" align="center" class="EstVehiculoVersionImprimirCaracteristicaSeccion">
                <?php echo $InsVehiculoVersion->VveNombre;?>
                </th>
              </tr>
  </thead>
  <tbody class="EstVehiculoVersionImprimirCaracteristicaBody">
    
    <?php
				if(!empty($InsVehiculoVersion->VehiculoVersionCaracteristica)){	
					foreach($InsVehiculoVersion->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
			?>
    
    <?php
						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId and $DatVehiculoVersionCaracteristica->VvcAnoModelo == $GET_Ano){
			?>
    
    <tr>
      <td align="left">
        
        
        <?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcDescripcion);?>
        
        
        </td>
      <td align="center">
        
        <?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcValor);?>
        
        </td>
      </tr>
    
    <?php					
				
						}	
					}
				}	
							
			?>
    
  </tbody>
          </table>
       
       <?php
	   if($secciones <> $i){
		  ?>
          <br />	      
          <?php 
	   }
	   ?>
       
      
	<?php
		$i++;
	}
	?>
        <?php
	}
}
?>
        
        
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoVersionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="center" valign="bottom" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
 
  
<br />
<!--<div class="EstVehiculoVersionPie">-->
<p align="center">
        <span class="EstVehiculoVersionImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
       <!-- Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986--> </span>
</p>
<!-- </div>-->
 
</body>
</html>
