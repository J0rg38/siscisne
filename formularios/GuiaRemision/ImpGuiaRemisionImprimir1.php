<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Guia de Remision No. <?php echo $InsGuiaRemision->GrtNumero;?> - <?php echo $InsGuiaRemision->GreId;?></title>
<link href="css/CssGuiaRemisionImprimir.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/JsGuiaRemisionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript">

$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsGuiaRemision->GreId) and !empty($InsGuiaRemision->GrtId)){?> 
FncGuiaRemisionImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>
</head>

<body>

<?php if($_GET['P']<>1){ ?>


<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<input name="TiempoImpresion" id="TiempoImpresion" type="checkbox" value="1" <?php echo ($GET_TiempoImpresion==1)?'checked="checked"':'';?>  /> Ignorar Fecha de Impresion</td>
<td>&nbsp;</td>
<td>
<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>


<?php }?>

<table width="1305" border="0" cellpadding="0" cellspacing="0" class="EstGuiaRemisionImprimirTabla">

<tr>
  <td height="176" colspan="2" align="right" valign="top"> 
  
  <span class="EstGuiaRemisionImprimirContenido">
  <?php echo $InsGuiaRemision->GrtNumero;?> - <?php echo $InsGuiaRemision->GreId;?>  </span>
  <br />
  <span class="EstGuiaRemisionImprimirContenido">
  <?php echo $InsGuiaRemision->UsuUsuario;?>  </span>
  
  
  <?php
	if($GET_TiempoImpresion!=1){
	?><br />
            <span class="EstGuiaRemisionImprimirContenido"> <?php echo date("d/m/Y");?> - <?php echo date("H:i:s");?></span>
    <?php
	}
	?>
    
    
  
    </td>
  </tr>

  
  <tr>
    <td colspan="2"><table class="EstGuiaRemisionImprimirTabla" width="62%" border="0" cellpadding="3" cellspacing="2">
      <tr>
        <td width="505" align="right" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Tacna, </span>
          <?php }?>
          
          <?php
			list($Dia,$Mes,$Ano) = explode("/",$InsGuiaRemision->GreFechaInicioTraslado);
			?>			</td>
        <td width="17" align="right" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $Dia;?></span></td>
        <td width="28" align="right" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">/ </span>
          <?php }?></td>
        <td width="17" align="right" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $Mes;?></span></td>
        <td width="17" align="right" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">/ </span>
          <?php }?></td>
        <td width="17" colspan="4" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $Ano;?></span></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td width="660" height="15"><?php if($_GET['P']!=1){ ?>
      <span class="EstGuiaRemisionImprimirEtiqueta">DESTINATARIO</span>
    <?php }?></td>
    <td width="645" height="15"><?php if($_GET['P']!=1){ ?>
      <span class="EstGuiaRemisionImprimirEtiqueta">Datos de Comprador - distinto al destinatario</span>
    <?php }?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="645" border="0" cellpadding="0" cellspacing="2" class="EstGuiaRemisionImprimirTabla">
      
      <tr>
        <td width="181" height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Se&ntilde;or (es) :</span>
          <?php }?></td>
        <td height="20" colspan="3" align="left" valign="bottom"><span class="EstGuiaRemisionImprimirContenido">
		
		<?php echo $InsGuiaRemision->GreDestinatarioNombre;?></span></td>
      </tr>
      <tr>
        <td height="15" align="left" valign="top">&nbsp;</td>
        <td height="15" align="left" valign="top">&nbsp;</td>
       
        <td height="15" align="left" valign="top">&nbsp;</td>
        <td width="204" height="15" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Ruc Nro.:</span>
          <?php }?></td>
        <td width="130" height="15" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreDestinatarioNumeroDocumento1;?></span></td>
        <td width="120" height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">DNI Nro. :</span>
          <?php }?></td>
        <td width="204" height="15" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreDestinatarioNumeroDocumento2;?></span></td>
      </tr>
    </table></td>
    <td height="65" align="left" valign="top"><table width="645" border="0" cellpadding="0" cellspacing="2" class="EstGuiaRemisionImprimirTabla">
      
      <tr>
        <td width="139" height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Se&ntilde;or (es) :</span>
          <?php }?></td>
        <td height="15" colspan="3" align="left" valign="bottom"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->CliNombre;?>
        <?php echo $InsGuiaRemision->CliApellidoPaterno;?>
        <?php echo $InsGuiaRemision->CliApellidoMaterno;?>
        
        </span></td>
      </tr>
      <tr>
        <td height="15" align="left" valign="top">&nbsp;</td>
        <td width="121" height="15" align="left" valign="top">&nbsp;</td>
        <td width="71" height="15" align="left" valign="top">&nbsp;</td>
        <td width="304" height="15" align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Ruc /:</span>
          <?php }?></td>
        <td height="15" align="left" valign="top">
		
		<span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->TdoNombre;?></span></td>
        <td height="15" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Nro. :</span>
          <?php }?></td>
        <td height="15" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->CliNumeroDocumento;?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" colspan="2"><?php if($_GET['P']!=1){ ?>
      <span class="EstGuiaRemisionImprimirEtiqueta">unidad de transporte y condutor(es)</span>
    <?php }?></td>
  </tr>
  <tr>
    <td height="90" colspan="2"><table class="EstGuiaRemisionImprimirTabla" width="100%" border="0" cellpadding="2" cellspacing="1">
      <tr>
        <td width="271" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta"> Raz&oacute;n Social:</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->PrvNombre;?></span></td>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta"> Chofer :</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreChofer;?></span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta"> RUC N&deg;: </span>
          <?php }?></td>
        <td width="468" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->PrvNumeroDocumento;?></span></td>
        <td width="160" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta"> Licencia de Conducir Nro. :</span><?php }?></td>
        <td width="385" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreNumeroLicenciaConducir;?></span></td>
        </tr>
      <tr>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Numero de Registro :</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreNumeroRegistro;?></span></td>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta"> Marca Unid. Transp. :</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreMarca;?></span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Constancia de Inscripci&oacute;n Nro .:</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreNumeroConstanciaInscripcion;?></span></td>
        <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
          <span class="EstGuiaRemisionImprimirEtiqueta">Nro. de Placa :</span>
          <?php }?></td>
        <td align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GrePlaca;?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="58" colspan="2">
  
  
   <table class="EstGuiaRemisionImprimirTabla" width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td height="18" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">Fecha de inicio de traslado:</span>
            <?php }?></td>
          <td width="607" height="18" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreFechaInicioTraslado;?></span></td>
          <td width="362" rowspan="2" align="left" valign="middle">
          
          <span class="EstGuiaRemisionImprimirContenido">
		  
		  <?php echo $InsGuiaRemision->GreVehiculo;?>

          
          </span>
          
          
          </td>
        </tr>
        <tr>
          <td width="316" height="18" align="left" valign="top"><?php if($_GET['P']!=1){ ?>  <span class="EstGuiaRemisionImprimirEtiqueta">Punto de Partida :</span><?php }?></td>
      <td height="18" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GrePuntoPartida;?></span></td>
      </tr>
        <tr>
          <td height="18" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">Punto de Llegada :</span>
            <?php }?></td>
          <td height="18" colspan="2" align="left" valign="top"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GrePuntoLlegada;?></span></td>
        </tr>
    </table>	</td>
  </tr>
  

  <tr>
    <td height="30" colspan="2" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstGuiaRemisionImprimirEtiqueta"> En la fecha estamos remitiendo a Ud. lo siguiente </span>
      <?php }?></td>
  </tr>
  
  <tr>
  <td height="410" colspan="2" valign="top">
    
    
  <table  width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstGuiaRemisionImprimirTabla2">
  <thead class="EstGuiaRemisionImprimirTablaHead2">
  <?php
//if($_GET['P']!=1){ 
?>
  <tr>
    <td height="10" align="center" widtd="135" >&nbsp;</td>
    <td height="10" align="center" widtd="135" ><span class="EstGuiaRemisionDetalleImprimirEtiqueta">
      <?php if($_GET['P']!=1){ ?>
      Cantidad
      <?php } ?>
      </span></td>
    <td align="center" widtd="50" >&nbsp;</td>
    <td align="center" widtd="99" ><span class="EstGuiaRemisionDetalleImprimirEtiqueta">
      <?php if($_GET['P']!=1){ ?>
      Unidad Medida
      <?php } ?>
      </span></td>
    <td height="10" align="center" widtd="50" >&nbsp;</td>
    <td height="10" align="center" widtd="729" ><span class="EstGuiaRemisionDetalleImprimirEtiqueta">
      <?php if($_GET['P']!=1){ ?>
      Descripcion
      <?php } ?>
      </span></td>
    <td width="8" height="10" align="center" widtd="16" >&nbsp;</td>
    <td align="center" widtd="99" ><span class="EstGuiaRemisionDetalleImprimirEtiqueta">
      <?php if($_GET['P']!=1){ ?>
      Peso Neto
      <?php } ?>
      </span></td>
    <td height="10" align="center" widtd="54" >&nbsp;</td>
    <td height="10" align="center" widtd="99" ><span class="EstGuiaRemisionDetalleImprimirEtiqueta">
      <?php if($_GET['P']!=1){ ?>
      Peso Bruto 
      <?php } ?>
      </span></td>
    </tr>
  <?php 
//}
?>
  </thead>
  <tbody class="EstGuiaRemisionImprimirTablaBody2">
  <?php
	
	if(is_array($InsGuiaRemision->GuiaRemisionDetalle)){
		foreach($InsGuiaRemision->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){
?>
    
    <tr>
      <td width="55" height="21" align="center">&nbsp;</td>
      <td width="108" align="center"><span class="EstGuiaRemisionDetalleImprimirContenido"><?php echo $DatGuiaRemisionDetalle->GrdCantidad;?></span></td>
      <td width="8">&nbsp;</td>
      <td width="139" align="center"><span class="EstGuiaRemisionDetalleImprimirContenido"><?php echo $DatGuiaRemisionDetalle->GrdUnidadMedida;?></span></td>
      <td width="26">&nbsp;</td>
      <td width="657"><span class="EstGuiaRemisionDetalleImprimirContenido">
	  <?php echo $DatGuiaRemisionDetalle->GrdCodigo;?> - 
      
	  <?php echo $DatGuiaRemisionDetalle->GrdDescripcion;?></span>
      
      
      
      
      
      
        <?php
			if(!empty($InsGuiaRemision->OvvId)){
			?>
      
       <table width="371" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="105"><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">Marca:</span></td>
                  <td width="99"><span class="EstGuiaRemisionImprimirContenidoCaracteristica">
                    <?php echo $InsGuiaRemision->OrdenVentaVehiculoVmaNombre;?>			</span>		</td>
                  <td width="86"><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">TRACCI&Oacute;N:</span></td>
                  <td width="76"><span class="EstGuiaRemisionImprimirContenidoCaracteristica"> <?php echo $InsGuiaRemision->VveCaracteristica7;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">Modelo:</span></td>
                  <td>
                    
                    
                    <?php
		
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/SEDAN/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/HATCHBACK/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/GT/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		
		
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/MAX/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/MOVE/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/CARGO/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		
		$InsGuiaRemision->OrdenVentaVehiculoVmoNombre = preg_replace("/WORK/", "", $InsGuiaRemision->OrdenVentaVehiculoVmoNombre);
		
		
		?>    
        
        			<span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoVmoNombre;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">CARROCERIA:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica8;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">A&ntilde;o Fabricac.:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoEinAnoFabricacion;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">NO. puertas:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica9;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Motor:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoEinNumeroMotor;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">combustible:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica10;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Clindros:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica1;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">peso bruto:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica11;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Ejes:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica2;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">carga util:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica12;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Chasis:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoEinVIN;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">peso seco:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica13;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">Color:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoEinColor;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">alto:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica14;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">Cilindrada:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica3;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">largo:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica15;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Asientos:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica4;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">ancho:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica16;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">Cap. Pasajeros:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica5;?></span></td>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">dist. ejes:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->VveCaracteristica17;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstGuiaRemisionImprimirEtiquetaCaracteristica">No. Poliza:</span></td>
                  <td><span class="EstGuiaRemisionImprimirContenidoCaracteristica"><?php echo $InsGuiaRemision->OrdenVentaVehiculoEinDUA;?></span></td>
                  <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                </table>
                
                            <?php
			}
			?>
         <span class="EstGuiaRemisionDetalleImprimirContenido">
                     <?php
			if(!empty($InsGuiaRemision->OvvId)){
			?>
            	<br />O.V.V.: <?php echo $InsGuiaRemision->OvvId;?>
            <?php
			}
			?>
            
        <?php
			if(!empty($InsGuiaRemision->VdiId)){
			?>
      
      		<?php echo $InsGuiaRemision->VdiId;?>

                
                            <?php
			}
			?>
      
      </td>
      <td align="center">&nbsp;</td>
      <td width="134" align="center"><span class="EstGuiaRemisionDetalleImprimirContenido"><?php echo $DatGuiaRemisionDetalle->GrdPesoNeto;?></span></td>
      <td width="8" align="center">&nbsp;</td>
      <td width="143" align="center"><span class="EstGuiaRemisionDetalleImprimirContenido"><?php echo $DatGuiaRemisionDetalle->GrdPesoTotal;?></span></td>
      </tr>
  <?php	
		}
	} 
?>
  <tr>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center"><?php echo $InsGuiaRemision->GreObservacionImpresa;?></td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  <td height="21" align="center">&nbsp;</td>
  </tr>
  </tbody>
  </table>  </td>
</tr>

  <tr>
    <td colspan="2">
      
      
      
      
      
      
      
      
      
      
      <table class="EstFormulario" width="100%" border="0" cellpadding="2" cellspacing="0">
        
        
        <tr>
          <td colspan="2" align="left" valign="top"><table class="EstFormulario" width="100%" border="0" cellpadding="2" cellspacing="0">
            
            <tr>
              <td width="15%">
              
              <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[a] Venta</span>
            <?php }?>            </td>
              <td width="16%"><span class="EstGuiaRemisionImprimirContenido"><?php echo $InsGuiaRemision->GreComprobantePagoNumero;?></span></td>
              <td width="3%">&nbsp;</td>
              <td width="3%">
              
               <?php if( $InsGuiaRemision->GreMotivoTraslado==1){ ?> <span class="EstGuiaRemisionImprimirContenido">X</span> <?php }?>              </td>
              <td width="0%">&nbsp;</td>
              <td width="29%">
              
                <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[f ]Entre establecimientos <br />
                de la misma Empresa</span>
            <?php }?>            </td>
              <td width="1%">&nbsp;</td>
              <td width="4%"><?php if( $InsGuiaRemision->GreMotivoTraslado==6){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td width="1%">&nbsp;</td>
              <td width="12%">
              
                 <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[k] Importaci&oacute;n</span>
            <?php }?>            </td>
              <td width="1%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="3%"><?php if( $InsGuiaRemision->GreMotivoTraslado==11){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td width="1%">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="2">
              
               <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[b] Venta sujeto a <br />
                confirmar</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==2){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td> <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[g] Para Transformaci&oacute;n</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==7){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>
              <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[l] Exportaci&oacute;n</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==12){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td colspan="2">  <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[c] Compra</span>
            <?php }?></td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==3){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>
              
              
              <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[h] Recojo de Bienes transformados</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==8){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>
              
               <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[m] Venta con Entrega a Terceros</span>
            <?php }?>             </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==13){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td colspan="2">
              
                <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[d] Consignacion</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==4){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>  <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[i] Emisor Itinerante</span>
            <?php }?></td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==9){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>
              
                <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[n] Otros:</span>
            <?php }?>              </td>
              <td>&nbsp;</td>
              <td><?php echo $InsGuiaRemision->GreMotivoTrasladoOtro;?></td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==14){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td colspan="2">
              
              <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[e] Devoluci&oacute;n</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==5){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td> <?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">[j] Zona Primaria</span>
            <?php }?>            </td>
              <td>&nbsp;</td>
              <td><?php if( $InsGuiaRemision->GreMotivoTraslado==10){ ?>
                <span class="EstGuiaRemisionImprimirContenido">X</span>
                <?php }?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td width="13%" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
            <span class="EstGuiaRemisionImprimirEtiqueta">Comp. de Pago N&deg;</span>
          <?php }?></td>
          <td width="87%" align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top">
		  
		  
    
    </td>
        </tr>
    </table></td>
</tr>
</table>

</body>
</html>

