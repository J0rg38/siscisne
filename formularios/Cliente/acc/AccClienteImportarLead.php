<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Clases de Conexion
*/
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>


<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); ?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON2.php'); ?>

<link rel="stylesheet" type="text/css" href="../css/CssClienteImportar.css"/>

<?php
$POST_Personal = $_POST['CmpPersonal'];

if(!$_POST){
	$POST_Personal = $_SESSION['SesionPersonal'];
}

//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClientePersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoReferido.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$InsPersonal = new ClsPersonal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>
	<form method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">Asesor de Ventas:</td>
  <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
    <option value="">Escoja una opcion</option>
    <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
    <option <?php echo ($DatPersonal->PerId==$POST_Personal)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
    <?php
					}
					?>
  </select></td>
  </tr>
<tr>
  <td align="left" valign="top">Archivo:</td>
  <td align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
	<input name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />

  
  </td>
</tr>
<tr>
  <td colspan="2" align="left" valign="top"><?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/vehiculos/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
?>
Nombre de Archivo: <?php echo $file_name;?><br />
<?php
	if (move_uploaded_file($tempFile,$targetFile)){
		
		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
			
			switch($ext){
				
				case "xls":
					
					echo "<span class='EstMensajeError'>";
					echo "Formato de archivo excel no soportado<br>";						
					echo "</span>";
				break;
				
				case "xlsx":
				
					$xlsx = new SimpleXLSX($targetFile); 
	
					list($num_cols, $num_rows) = $xlsx->dimension(); 
	
					$fila = 1;
					$inicio_fila = 0;
					$inicio_columna = 0;
					
					$Registrados = 0;
					$NoRegistrados = 0;
					$Actualizados = 0;
					$NoActualizados = 0;
					$NoIdentificados = 0;
					
					foreach( $xlsx->rows() as $r ) { 
	
						echo "[Fila_".$fila."]>";	
						echo "<br>";
						
						/*
						A Asignado
						B Modelo
						C Teléfono móvil
						D Venta Etapa Fase
						E ID del Contacto
						F Correo electrónico
						G Nombre del contacto
						H Apellidos del contacto
						I Observaciones
						*/
					
						$Asignado  = ( (!empty($r[0])) ? $r[0] : '' );
						$Modelo  = ( (!empty($r[1])) ? $r[1] : '' );
						$TelefonoMovil  = ( (!empty($r[2])) ? $r[2] : '' );
						$VentaEtapaFase  = ( (!empty($r[3])) ? $r[3] : '' );
						$IdContacto  = ( (!empty($r[4])) ? $r[4] : '' );
						$CorreoElectronico  = ( (!empty($r[5])) ? $r[5] : '' );
						$NombreContacto  = ( (!empty($r[6])) ? $r[6] : '' );
						$ApellidosContacto  = ( (!empty($r[7])) ? $r[7] : '' );
						$Observaciones  = ( (!empty($r[8])) ? $r[8] : '' );
						
						
						$Asignado  = gmdate("d/m/Y H:i:s", (ExcelToPHP($Asignado)));
						
							echo "<b>Asignado:</b> ".$Asignado;
							echo "<br>";

							echo "<b>Modelo:</b> ".$Modelo;
							echo "<br>";
							
							echo "<b>Teléfono móvil:</b> ".$TelefonoMovil;
							echo "<br>";
							
							echo "<b>Venta Etapa Fase:</b> ".$VentaEtapaFase;
							echo "<br>";
							
							echo "<b>ID del Contacto:</b> ".$IdContacto;
							echo "<br>";
							
							echo "<b>Correo electrónico:</b> ".$CorreoElectronico;
							echo "<br>";
							
							echo "<b>Nombre del contacto:</b> ".$NombreContacto;
							echo "<br>";
							
							echo "<b>Apellidos del contacto:</b> ".$ApellidosContacto;
							echo "<br>";
							
							echo "<b>Observaciones:</b> ".$Observaciones;
							echo "<br>";
											
							$ClienteId  = "";
							
							if(!empty($IdContacto)){
							
								$InsCliente = new ClsCliente();
								//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oClienteTipo=NULL,$oClasificacion=NULL,$oTipoReferido=NULL) 
								$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","esigual",$IdContacto,"CliTiempoCreacion","DESC",1,"1",NULL,NULL,NULL,NULL,NULL);
								$ArrClientes = $ResCliente['Datos'];
								
								if(!empty($ArrClientes)){
									foreach($ArrClientes as $DatCliente){
										$ClienteId = $DatCliente->CliId;
									}
								}
							
							}else{
								$NoIdentificados++;
								echo "<span class='EstMensajeError'>";
								echo "No se encontro Id del Contacto";
								echo "</span>";
								echo "<br>";	
							}

							if(!empty($ClienteId)){
								
								$InsCliente1 = new ClsCliente();
								$InsCliente1->CliId = $ClienteId;
								$InsCliente1->LtiId = "LTI-10123";
								$InsCliente1->TdoId = "TDO-10001";
								$InsCliente1->PerId = $POST_Personal;
								
								$InsCliente1->CliNombre = $NombreContacto;
								$InsCliente1->CliApellidoPaterno = $ApellidosContacto;
								$InsCliente1->CliApellidoMaterno = "";
								$InsCliente1->CliCelular = $TelefonoMovil;
								$InsCliente1->CliEmail = $CorreoElectronico;
								$InsCliente1->CliNumeroDocumento = $IdContacto;
								
								$InsCliente1->CliLeadFechaAsignado = FncCambiaFechaAMysql($Asignado,false);
								$InsCliente1->CliLeadModelo = $Modelo;
								$InsCliente1->CliLeadObservacion = $Observaciones;
								$InsCliente1->CliLeadEtapaFase = $VentaEtapaFase;
								$InsCliente1->CliLeadTiempoModificacion = date("Y-m-d H:i:s");
								$InsCliente1->CliLead = 1;
							
								$InsCliente1->EinTiempoCreacion = date("Y-m-d H:i:s");
								$InsCliente1->EinTiempoModificacion = date("Y-m-d H:i:s");
								$InsCliente1->EinEliminado = 1;		
								
								if($InsCliente1->MtdEditarClienteLead()){
									$Actualizados++;
									
									echo "Cliente editado correctamente";
									echo "<br>";
								}else{
									$NoActualizados++;
									echo "<span class='EstMensajeError'>";
									echo "El Cliente no se pudo editar";
									echo "</span>";
									echo "<br>";
								}		
								
							}else{
									
								$InsCliente1 = new ClsCliente();
								$InsCliente1->LtiId = "LTI-10123";
								$InsCliente1->TdoId = "TDO-10001";
								$InsCliente1->PerId = $POST_Personal;
								
								$InsCliente1->CliNombre = $NombreContacto;
								$InsCliente1->CliApellidoPaterno = $ApellidosContacto;
								$InsCliente1->CliApellidoMaterno = "";
								$InsCliente1->CliCelular = $TelefonoMovil;
								$InsCliente1->CliEmail = $CorreoElectronico;
								$InsCliente1->CliNumeroDocumento = $IdContacto;
								
								$InsCliente1->CliLeadFechaAsignado = FncCambiaFechaAMysql($Asignado,false);
								$InsCliente1->CliLeadModelo = $Modelo;
								$InsCliente1->CliLeadObservacion = $Observaciones;
								$InsCliente1->CliLeadEtapaFase = $VentaEtapaFase;
								$InsCliente1->CliLeadTiempoModificacion = date("Y-m-d H:i:s");
								$InsCliente1->CliLead = 1;
							
								$InsCliente1->EinTiempoCreacion = date("Y-m-d H:i:s");
								$InsCliente1->EinTiempoModificacion = date("Y-m-d H:i:s");
								$InsCliente1->EinEliminado = 1;		
								
								if($InsCliente1->MtdRegistrarClienteLead()){
									$Registrados++;	
									echo "Cliente registrado correctamente";
									echo "<br>";
								}else{
									$NoRegistrados++;
									echo "<span class='EstMensajeError'>";
									echo "El Cliente no se pudo registrar";
									echo "</span>";
									echo "<br>";
								}

							}
							
							echo "<br>";
							echo "<br>";
						$fila++;
					}
					
					
				
				break;
				
			}
				

		} else {
			echo "<span class='EstMensajeError'>";
			echo "Hubo un error al subir el archivo";
			echo "</span>";
			echo "<br>";
		
		}

	
}
?></td>
</tr>
<tr>
  <td colspan="2" align="left" valign="top">
<?php
echo "<b>Resultados</b>";
echo "<br>";
echo "<br>";
echo "<b>Clientes registrados:</b> ".$Registrados;
echo "<br>";
echo "<b>Clientes que no se pudeieron registrar:</b> ".$NoRegistrados;
echo "<br>";
echo "<b>Clientes editados:</b> ".$Actualizados;
echo "<br>";
echo "<b>Clientes que no se pudieron editar:</b> ".$NoActualizados;
echo "<br>";
echo "<b>Clientes no idenficados:</b> ".$NoIdentificados;
echo "<br>";
?>
  </td>
  </tr>
</table>

	</form>

