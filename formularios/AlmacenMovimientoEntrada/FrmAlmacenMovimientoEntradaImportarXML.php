<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Importar")){
?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR XML (FORMATO UBL)</span></td>
      </tr>
      <tr>
        <td>
        
        
                                <br />
   
        
        
     

      
    
		
		
		 <div class="EstFormularioArea" >
		<table class="EstFormulario" width="594" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="5">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td width="15">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>El archivo xml debe cumplir con el formato sunat ubl 2.0 o 2.1 para que pueda ser reconocido por el sistema.</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>

			<iframe src="<?php echo $InsProyecto->MtdFormulariosAcc("AlmacenMovimientoEntrada")?>AccAlmacenMovimientoEntradaImportarXML.php" id="IfrAlmacenMovimientoEntradaImportarXML" name="IfrAlmacenMovimientoEntradaImportarXML" scrolling="Auto"  frameborder="0" width="800" height="500"></iframe>            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="97">&nbsp;</td>
            <td width="451">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
   
        </div>		
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
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






