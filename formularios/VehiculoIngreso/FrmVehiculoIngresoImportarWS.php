<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">IMPORTAR WHOLE SALE</span></td>
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
            <td>El archivo excel debe cumplir con lo siguiente distribucion de columnas <a href="descargas/ImportarVehiculoIngresoWS.xlsx" target="_blank">(Descargar Formato)</a>, y comenzar desde la fila 2, considerando la fila 1 como los titulos de las columnas<!-- <br />
              Columna B: Codigo SAP<br />
              Columna C: Modelo<br />
              Columna D: Transmision<br />
              Columna E: Color<br />
              Columna F: Color Aduana<br />
              Columna G: VIN<br />
              Columna H: Motor<br />
              Columna I: Año de Fabricacion<br />
              Columna J: Año MY<br />
              Columna K: Fecha de Llegada de Embarque (YYYY-mm-dd)<br />
              Columna L: Precio Dealer<br />
              Columna M: Precio con IGV<br />
              Columna N: Dealer<br />
              Columna O: Pedido--></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>

			<iframe src="<?php echo $InsProyecto->MtdFormulariosAcc("VehiculoIngreso")?>AccVehiculoIngresoImportarWS.php" id="IfrVehiculoIngresoImportarWS" name="IfrVehiculoIngresoImportarWS" scrolling="Auto"  frameborder="0" width="800" height="500"></iframe>            
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
