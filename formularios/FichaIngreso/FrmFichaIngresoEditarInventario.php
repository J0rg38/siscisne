<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>
<!-- CONTROL DE PRIVILEGIOS -->

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoFuncionesv2.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaIngreso.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();


$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);	
$InsFichaIngreso->PerIdAnterior = $InsFichaIngreso->PerId;

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoEditarInventario.php');

?>

<?php
if($InsFichaIngreso->FinEstado==11 or $InsFichaIngreso->FinEstado==2){
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpExteriorDelantero1').focus();	

});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">

           
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	



<?php
if($Edito){
?>    

      

<?php
}
?>         
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        INVENTARIO DE LA ORDEN DE TRABAJO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
<br />
               
<ul class="tabs">
	<li><a href="#tab1">Inventario</a></li>
</ul>
<div class="tab_container">

    <div id="tab1" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td valign="top">
              

              
<div class="EstFormularioArea">
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">Ord. Trabajo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCaja" id="CmpFichaIngresoId" value="<?php echo $InsFichaIngreso->FinId;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Fecha:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsFichaIngreso->FinFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td align="left" valign="top">Cliente:</td>
      <td colspan="5" align="left" valign="top"><input name="CmpFichaIngresoCliente" type="text" class="EstFormularioCaja" id="CmpFichaIngresoCliente" value="<?php echo $InsFichaIngreso->CliNombre;?>" size="45" readonly="readonly" /></td>
      <td align="left" valign="top"><input type="hidden" name="Guardar" id="Guardar"   />
        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
        <input name="CmpFichaIngresoVehiculoVersion" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoVehiculoVersion" value="<?php echo $InsFichaIngreso->VveId;?>"  /><!-- REVISAR -->
        <input name="CmpFichaIngresoMantenimientoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoMantenimientoKilometraje" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>"  />
        <input name="CmpFichaIngresoEstado" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>"  />
        <input name="CmpVehiculoIngresoMarcaId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>"  />
        <input name="CmpVehiculoIngresoModeloId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>"  />
        <input name="CmpVehiculoIngresoVersionId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>"  />
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  /></td>
    </tr>

    <tr>
      <td align="left" valign="top"> Placa </td>
      <td align="left" valign="top"><input name="CmpFichaIngresoPlaca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">VIN:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVIN" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVIN" value="<?php echo $InsFichaIngreso->EinVIN;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Marca:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoMarca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoMarca" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Modelo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoModelo" type="text" class="EstFormularioCaja" id="CmpFichaIngresoModelo" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Version:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVersion" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
        </table>
</div>  


              </td>
            </tr>
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="10"><span class="EstFormularioSubTitulo">Inventario de Ingreso</span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">EXTERIORES</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">INTERIORES</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top"><p>Lado Delantero</p></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lado Derecho</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Llave de Contacto:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior1" type="text" id="CmpInterior1" value="<?php if(empty($InsFichaIngreso->FinInterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Cenicero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior15" type="text" id="CmpInterior15" value="<?php if(empty($InsFichaIngreso->FinInterior15)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior15;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parachoque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero1" type="text" id="CmpExteriorDelantero1" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo  Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho1" type="text" id="CmpExteriorDerecho1" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas Electricas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior2" type="text" id="CmpInterior2" value="<?php if(empty($InsFichaIngreso->FinInterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Manual:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior16" type="text" id="CmpInterior16" value="<?php if(empty($InsFichaIngreso->FinInterior16)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior16;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Neblineros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero2" type="text" id="CmpExteriorDelantero2" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Tapa de Combustible:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho2" type="text" id="CmpExteriorDerecho2" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Asiento (tela, cuero):</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior3" type="text" id="CmpInterior3" value="<?php if(empty($InsFichaIngreso->FinInterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Antena:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior17" type="text" id="CmpInterior17" value="<?php if(empty($InsFichaIngreso->FinInterior17)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior17;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Faros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero3" type="text" id="CmpExteriorDelantero3" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Aros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho3" type="text" id="CmpExteriorDerecho3" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Asiento Piloto:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior4" type="text" id="CmpInterior4" value="<?php if(empty($InsFichaIngreso->FinInterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Copas de Aros / Vasos:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior18" type="text" id="CmpInterior18" value="<?php if(empty($InsFichaIngreso->FinInterior18)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior18;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Plumillas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero4" type="text" id="CmpExteriorDelantero4" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho4" type="text" id="CmpExteriorDerecho4" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Controles de Tim&oacute;n:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior5" type="text" id="CmpInterior5" value="<?php if(empty($InsFichaIngreso->FinInterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Airbags:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior19" type="text" id="CmpInterior19" value="<?php if(empty($InsFichaIngreso->FinInterior19)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior19;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parabrisas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero5" type="text" id="CmpExteriorDelantero5" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Delantera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho5" type="text" id="CmpExteriorDerecho5" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Perilla de Palanca:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior6" type="text" id="CmpInterior6" value="<?php if(empty($InsFichaIngreso->FinInterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Seguro Cromado Rueda:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior20" type="text" id="CmpInterior20" value="<?php if(empty($InsFichaIngreso->FinInterior20)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior20;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Emble:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero6" type="text" id="CmpExteriorDelantero6" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Lateral:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho6" type="text" id="CmpExteriorDerecho6" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Radio (Cass/CD/MP/A/C):</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior7" type="text" id="CmpInterior7" value="<?php if(empty($InsFichaIngreso->FinInterior7)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Gancho de remolque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior21" type="text" id="CmpInterior21" value="<?php if(empty($InsFichaIngreso->FinInterior21)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior21;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Bicel/Mascara:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero7" type="text" id="CmpExteriorDelantero7" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo  Delantero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho7" type="text" id="CmpExteriorDerecho7" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">A/C:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior8" type="text" id="CmpInterior8" value="<?php if(empty($InsFichaIngreso->FinInterior8)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior8;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Estuche de Herram.:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior22" type="text" id="CmpInterior22" value="<?php if(empty($InsFichaIngreso->FinInterior22)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior22;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho8" type="text" id="CmpExteriorDerecho8" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho8)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho8;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Reloj:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior9" type="text" id="CmpInterior9" value="<?php if(empty($InsFichaIngreso->FinInterior9)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior9;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Gata llave de rueda Palanca:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior23" type="text" id="CmpInterior23" value="<?php if(empty($InsFichaIngreso->FinInterior23)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior23;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Lado Posterior</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Retovisor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior10" type="text" id="CmpInterior10" value="<?php if(empty($InsFichaIngreso->FinInterior10)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior10;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Luz de Sal&oacute;n:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior24" type="text" id="CmpInterior24" value="<?php if(empty($InsFichaIngreso->FinInterior24)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior24;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parachoque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior1" type="text" id="CmpExteriorPosterior1" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lado Izquierdo</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Correas de Seguridad:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior11" type="text" id="CmpInterior11" value="<?php if(empty($InsFichaIngreso->FinInterior11)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior11;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Triangulo:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior25" type="text" id="CmpInterior25" value="<?php if(empty($InsFichaIngreso->FinInterior25)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior25;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Faros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior2" type="text" id="CmpExteriorPosterior2" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo1" type="text" id="CmpExteriorIzquierdo1" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Tapasoles:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior12" type="text" id="CmpInterior12" value="<?php if(empty($InsFichaIngreso->FinInterior12)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior12;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Extintor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior26" type="text" id="CmpInterior26" value="<?php if(empty($InsFichaIngreso->FinInterior26)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior26;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Maletera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior3" type="text" id="CmpExteriorPosterior3" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Aros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo2" type="text" id="CmpExteriorIzquierdo2" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Sunroof:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior13" type="text" id="CmpInterior13" value="<?php if(empty($InsFichaIngreso->FinInterior13)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior13;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Cobertor de Maletera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior27" type="text" id="CmpInterior27" value="<?php if(empty($InsFichaIngreso->FinInterior27)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior27;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Plumillas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior4" type="text" id="CmpExteriorPosterior4" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo3" type="text" id="CmpExteriorIzquierdo3" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Encendedor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior14" type="text" id="CmpInterior14" value="<?php if(empty($InsFichaIngreso->FinInterior14)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior14;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">5ta Llave de Aro:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior5" type="text" id="CmpExteriorPosterior5" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Delantera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo4" type="text" id="CmpExteriorIzquierdo4" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td colspan="4" rowspan="4" align="right" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>1</td>
                          <td>&nbsp;</td>
                          <td>Buen Estado</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>2</td>
                          <td>&nbsp;</td>
                          <td>Pintura Rayada</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>3</td>
                          <td>&nbsp;</td>
                          <td>Abolladura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>4</td>
                          <td>&nbsp;</td>
                          <td>Rotura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>5</td>
                          <td>&nbsp;</td>
                          <td>Faltante</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>6</td>
                          <td>&nbsp;</td>
                          <td>Oxido</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>0</td>
                          <td>&nbsp;</td>
                          <td>No preseta</td>
                          <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Emblema:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior6" type="text" id="CmpExteriorPosterior6" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Lateral:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo5" type="text" id="CmpExteriorIzquierdo5" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo Delantero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo6" type="text" id="CmpExteriorIzquierdo6" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo7" type="text" id="CmpExteriorIzquierdo7" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
                  
                  
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
 

    
    
    
    

        



    
</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

	
	
	
    
       


     
</form>

<?php
}else{
	echo ERR_FIN_702;
}
?>


<?php

}else{
	echo ERR_GEN_101;
}

if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}


?>


