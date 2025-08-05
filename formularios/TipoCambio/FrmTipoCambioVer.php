<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php

$GET_id = $_GET['Id'];
include('formularios/TipoCambio/msj/MsjTipoCambio.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once('paquetes/PaqContabilidad/Clases/ClsTipoCambio.php');

$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

include('formularios/TipoCambio/acc/AccTipoCambioEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>





<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsTipoCambio->TcaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        TIPO DE CAMBIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTipoCambio->TcaTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTipoCambio->TcaTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo:</td>
            <td>
            
            <input  readonly="readonly" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsTipoCambio->TcaId;?>" size="15" maxlength="20" />
            
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Moneda:</td>
            <td>
              <select disabled="disabled" class="EstFormularioCombo" id="CmpMoneda" name="CmpMoneda">
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrMonedas as $DatMoneda){				
				
			?>
                <option <?php if($InsTipoCambio->MonId == $DatMoneda->MonId){ echo 'selected="selected"';}?> value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?> <?php echo $DatMoneda->MonSimbolo;?></option>
                <?php
			}
			?>
              </select>
             </td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td>
              
                <input readonly="readonly" class="EstFormularioCajaFecha"  name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsTipoCambio->TcaFecha)){ echo date("d/m/Y");}else{ echo $InsTipoCambio->TcaFecha; }?>" size="15" maxlength="10" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Compra:</td>
            <td>
            
                <input readonly="readonly" class="EstFormularioCaja" name="CmpMontoCompra" type="text" id="CmpMontoCompra" value="<?php echo $InsTipoCambio->TcaMontoCompra;?>" size="10" maxlength="10" />
             </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Venta:</td>
            <td>
                <input readonly="readonly"  class="EstFormularioCaja" name="CmpMontoVenta" type="text" id="CmpMontoVenta" value="<?php echo $InsTipoCambio->TcaMontoVenta;?>" size="10" maxlength="10" />
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
    
    
</div>

	

	
    



<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
