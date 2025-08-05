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




$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

$POST_ClienteNombre = $_POST['ClienteNombre'];
$POST_ClienteId = $_POST['ClienteId'];

$POST_FichaIngresoId = $_POST['FichaIngresoId'];
$POST_SucursalId = $_POST['SucursalId'];

$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_IncluirCSI = $_POST['IncluirCSI'];
$POST_DiasTranscurridos = $_POST['DiasTranscurridos'];

$POST_Filtro = $_POST['Filtro'];

		
$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"FinFecha";
$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');



require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');


$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
//$InsReporteFichaIngreso->Ruta = '../../';


//$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ClienteId,$POST_FichaIngresoId,2,$POST_SucursalId,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",false);		

//MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oFichaIngreso=NULL,$oDiasTranscurridos=0,$oSucursal=NULL,$oModalidadIngreso=NULL,$oConLlamada=false,$oVehiculoMarca=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor") {
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas("EinPlaca,EinVIN,FinId,CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_Filtro,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ClienteId,$POST_FichaIngresoId,$POST_DiasTranscurridos,$POST_SucursalId,$POST_Modalidad,false,$POST_VehiculoMarca,$POST_IncluirCSI,"Igual");		
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

?>


 <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="8%">SUCURSAL</th>
          <th width="8%">ORD. TRABAJO</th>
          <th width="6%">FECHA</th>
          <th width="8%">DIAS TRANSC.</th>
          <th width="25%">CLIENTE.</th>
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
          <th width="9%" align="center">TRABAJO REALIZADO</th>
          <th width="9%" align="center"># LLA.</th>
          <th width="9%" align="center"># ENC.</th>
          <th width="9%" align="center">ACCIONES</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
        foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?>
          
<?php
$Motivo = " Excluido el Fecha: ".$DatReporteFichaIngreso->CliCSIExcluirFecha." por Usuario: ".$DatReporteFichaIngreso->CliCSIExcluirUsuario." Motivo: ". $DatReporteFichaIngreso->CliCSIExcluirMotivo;
?>

  
        
                  
<input  type="checkbox" name="CmpReporteFichaIngreso_<?php echo $c; ?>" id="CmpReporteFichaIngreso_<?php echo $c; ?>" value="<?php echo $c; ?>" ficha_ingreso="<?php echo $DatReporteFichaIngreso->FinId; ?>" cliente="<?php echo $DatReporteFichaIngreso->CliId; ?>" etiqueta="fila" style="visibility:hidden;" fecha_inicio="<?php echo FncCambiaFechaAMysql($POST_finicio);?>" fecha_fin="<?php echo FncCambiaFechaAMysql($POST_ffin);?>" motivo="<?php echo $Motivo;?>" >  


          </td>
          <td align="right" valign="middle"   >
          
          
          
		  <?php echo $DatReporteFichaIngreso->SucNombre;  ?>
          
          
          </td>
          <td align="right" valign="middle"   >
		  
                      <a href="javascript:FncTrabajoTerminadoVistaPreliminar('<?php echo $DatReporteFichaIngreso->FinId;?>');"><?php echo $DatReporteFichaIngreso->FinId;  ?></a>
                      
<!--                      
          <a href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatReporteFichaIngreso->FinId;?>" target="_blank">
			 <?php echo $DatReporteFichaIngreso->FinId;  ?></a>  -->        
             
			</td>
          <td align="right" ><?php echo ($DatReporteFichaIngreso->FinFecha);?></td>
          <td align="right" >

 <?php
		  if($DatReporteFichaIngreso->FinDiaTranscurrido>0){
		?>
<h2>		  

<?php echo ($DatReporteFichaIngreso->FinDiaTranscurrido);?> dia(s)

</h2>

<?php
		  }
?>

</td>
          <td align="right" >
		  
		  <?php echo $DatReporteFichaIngreso->CliNombre;  ?> <?php echo $DatReporteFichaIngreso->CliApellidoPaterno;  ?> <?php echo $DatReporteFichaIngreso->CliApellidoMaterno;  ?>
          
          
                    <?php

if($DatReporteFichaIngreso->CliCSIIncluir == "2"){
?>
    <a href="javascript:void(0);" id="BtnCSIDatos_<?php echo $c;  ?>">
    <img src="imagenes/avisos/retirado.gif" width="15" height="15" border="0" align="Excluido CSI" title="Excluido CSI" />
    
    </a>
    <?php	
}
?>  
          
          
          
          </td>
          <td align="right" ><?php echo $DatReporteFichaIngreso->CliTelefono;  ?></td>
          <td align="right" >
<?php


$Titulo = $SistemaCorreoRemitente;

$Mensaje = $Saludo." Señ@r ".$DatReporteFichaIngreso->CliNombre;

//$Mensaje = str_replace(" ","%",$Mensaje);

?>


<?php echo $DatReporteFichaIngreso->CliCelular;?>


<?php
if(!empty($DatReporteFichaIngreso->CliCelular)){
?>
<a  href="javascript:FncTrabajoTerminadoSeguimientoEnviarWhatsapp('<?php echo trim($DatReporteFichaIngreso->CliWhatsapp);?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/whatsapp.png" width="20" height="20" title="Enviar mensaje de whatsapp" />
</a>

<?php
}
?>


<?php
/*if(!empty($DatReporteFichaIngreso->CliCelular)){
?>
<a  href="javascript:FncTrabajoTerminadoSeguimientoEnviarSms('<?php echo trim($DatReporteFichaIngreso->CliWhatsapp);?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/enviar_sms.png" width="20" height="20" title="Enviar mensaje de texto" />
</a>

<?php
}*/
?>


    
          
          
          
          
          
          </td>
          <td align="right" ><?php echo $DatReporteFichaIngreso->CliEmail;  ?>
 
<?php
if(!empty($DatReporteFichaIngreso->CliEmail)){
?>         


  <a  href="javascript:FncTrabajoTerminadoSeguimientoEnviarEmail('<?php echo trim($DatReporteFichaIngreso->CliEmail);?>','<?php echo $Titulo;?>','<?php echo $Mensaje;?>');">
<img border="0" src="imagenes/acciones/enviar_correo.png" width="20" height="20" title="Enviar mensaje por Email" />
</a>
      <?php
}
	  ?>  
          
          
          
      
          
          </td>
          <td align="right" ><?php echo $DatReporteFichaIngreso->EinVIN;  ?></td>
          <td align="right" >
		  
		  <h2>
		  <?php echo $DatReporteFichaIngreso->EinPlaca;  ?>
          
          </h2>
          </td>
          <td align="right" ><?php echo $DatReporteFichaIngreso->VmaNombre;  ?></td>
          <td align="right" ><?php echo $DatReporteFichaIngreso->VmoNombre;  ?></td>
          <td align="center" ><?php echo $DatReporteFichaIngreso->VveNombre;  ?></td>
          <td align="center" ><?php echo $DatReporteFichaIngreso->EinColor;  ?></td>
          <td align="center" ><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"> <?php echo $DatReporteFichaIngreso->PerNombreAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $DatReporteFichaIngreso->PerApellidoMaternoAsesor;?></span></td>
          <td align="left" >
		  <h2>
		  <?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatReporteFichaIngreso->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
            <?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
-<?php echo $DatFichaIngresoModalidad->MinNombre?> 

<?php
if( $DatFichaIngresoModalidad->MinSigla=="MA"){
?>
<?php echo ($DatReporteFichaIngreso->FinMantenimientoKilometraje);?> KM
<?php	
}
?>



<br />
<?php
		}
		?>
        </h2>
        
</td>
          <td align="center" >
          
<?php

$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada();
//MtdObtenerFichaIngresoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FllId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAsesor=NULL)
$ResFichaIngresoLlamada =  $InsFichaIngresoLlamada->MtdObtenerFichaIngresoLlamadas(NULL,NULL,"FllId","ASC",NULL,$DatReporteFichaIngreso->FinId,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL);
$ArrFichaIngresoLlamadas = 	$ResFichaIngresoLlamada['Datos'];

?>
          
          <h2>
       
             <span id="CapTotalFichaIngresoLlamadas_<?php echo $c;?>">
			 <?php
		  echo count($ArrFichaIngresoLlamadas);
		  ?>
          </span>
       
          </h2>
          </td>
          <td align="center" >
          
          
          <?php
		  
$InsEncuesta = new ClsEncuesta();
////MtdObtenerEncuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL,$oSucursal=NULL,$oFichaIngreso=NULL)
$ResEncuesta = $InsEncuesta->MtdObtenerEncuestas(NULL,NULL,NULL,"EncFecha","DESC","1",NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"POSTVENTA",NULL,$DatReporteFichaIngreso->FinId);
$ArrEncuestas = $ResEncuesta['Datos'];

		  ?>
          <h2>
          <span id="CapTotalEncuestas_<?php echo $c;?>">
          <?php
		  echo count($ArrEncuestas);
		  ?>
          </span>
          </h2>
          </td>
          <td align="center" >
          
            
<!--            <a href="javascript:FncTrabajoTerminadoVistaPreliminar('<?php echo $DatReporteFichaIngreso->FinId;?>');"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>-->
                  
            <a href="javascript:FncTrabajoTerminadoSeguimientoClienteCargarFormulario('<?php echo $DatReporteFichaIngreso->FinId;?>');"><img src="imagenes/acciones/llamar.png" alt="[Registrar Llamada]" title="Registrar Llamada" width="19" height="19" border="0" /></a>
            
             <a href="javascript:FncTrabajoTerminadoEncuestaCargarFormulario('<?php echo $DatReporteFichaIngreso->FinId;?>');"><img src="imagenes/acciones/encuesta.gif" alt="[Registrar Encuesta]" title="Registrar Encuesta" width="19" height="19" border="0" /></a>
                                          
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
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>


