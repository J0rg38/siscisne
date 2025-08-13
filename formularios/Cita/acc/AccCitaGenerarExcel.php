<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"CITAS_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';
$POST_Personal = $_POST['Personal'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];

$POST_PersonalMecanico = $_POST['PersonalMecanico'];
$POST_TipoFecha = $_POST['TipoFecha'];
$POST_Sucursal = $_POST['CmpSucursal'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'CitTiempoModificacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_finicio)){
	$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_TipoFecha)){
	$POST_TipoFecha = "CitFecha";
}
if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}

//MENSAJES

//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//INSTANCAS
$InsCita = new ClsCita();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();
//ACCIONES

//DATOS


//MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL) 
$ResCita = $InsCita->MtdObtenerCitas("cit.CitId,cit.CitVehiculoPlaca,ein.EinVIN,ein.EinPlaca,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre,cit.CitVehiculoMarca,cit.CitVehiculoModelo,cit.CitVehiculoVersion,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliTelefono,cli.CliCelular","contiene",$POST_fil,$POST_ord,$POST_sen,"",NULL,NULL,$POST_Personal,FncCambiaFechaAMysql($POST_finicio),(FncCambiaFechaAMysql($POST_ffin)),$POST_TipoFecha,false,NULL,$POST_PersonalMecanico,NULL,$POST_Sucursal);
$ArrCitas = $ResCita['Datos'];
$CitasTotal = $ResCita['Total'];
$CitasTotalSeleccionado = $ResCita['TotalSeleccionado'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
$ArrAsesores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
$ArrTecnicos = $ResPersonal['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>

<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="4%" >FECHA PROG.</th>
                <th width="4%" >HORA PROG.</th>
                <th width="10%" >CLIENTE</th>
                <th width="6%" >TELEFONO</th>
                <th width="5%" >CELULAR</th>
                <th width="5%" >ASESOR</th>
                <th width="4%" >PLACA</th>
                <th width="5%" >MARCA</th>
                <th width="5%" >MODELO</th>
                <th width="5%" >VERSION</th>
                <th width="6%" >DURACION</th>
                <th width="7%" >REGISTRADO POR</th>
                <th width="7%" >ESTADO</th>
                <th width="8%" >FECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
<tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrCitas as $dat){

								?>

            

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   ><?php echo $dat->CitId;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CitFechaProgramada;  ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CitHoraProgramada;  ?></td>
                <td align="right" valign="middle" width="10%"   ><?php echo $dat->CliNombre;  ?> <?php echo $dat->CliApellidoPaterno;  ?> <?php echo $dat->CliApellidoMaterno;  ?> / <?php echo $dat->CitReferencia;  ?></td>
                <td width="6%" align="right" valign="middle"   ><?php echo $dat->CliTelefono;  ?></td>
                <td width="5%" align="right" valign="middle"   ><?php echo $dat->CliCelular;  ?></td>
                <td width="5%" align="right" valign="middle"   ><?php echo $dat->PerNombre; ?> <?php echo $dat->PerApellidoMaterno; ?>  <?php echo $dat->PerApellidoPaterno; ?></td>
                <td align="right" valign="middle" width="4%"   ><?php echo $dat->CitVehiculoPlaca; ?></td>
                <td align="right" valign="middle" width="5%"   ><?php echo $dat->CitVehiculoMarca; ?></td>
                <td width="5%" align="right" valign="middle"   ><?php echo $dat->CitVehiculoModelo; ?></td>
                <td width="5%" align="right" valign="middle"   ><?php echo $dat->CitVehiculoVersion; ?></td>
                <td width="6%" align="right" valign="middle"   ><?php echo $dat->CitDuracion; ?> hrs</td>
                <td width="7%" align="right" valign="middle"   ><?php echo $dat->PerNombreRegistro; ?> 
				<?php echo $dat->PerApellidoMaternoRegistro; ?> <?php echo $dat->PerApellidoPaternoRegistro; ?></td>
                <td  width="7%" align="right" >
                  
                  <?php echo $dat->CitEstadoIcono; ?>
                  <?php echo $dat->CitEstadoDescripcion; ?>
                  
                </td>
                <td  width="8%" align="right" ><?php echo ($dat->CitTiempoCreacion);?></td>
        </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
