<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUnidadMedidaConversion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsUnidadMedidaConversion {

    public $UmcId;
    public $UmeId1;
	public $UmeId2;
	public $UmcEquivalente;	

	public $UmeNombre1;
	public $UmeAbreviacion1;
	
	public $UmeNombre2;
	public $UmeAbreviacion2;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarUnidadMedidaConversionId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(UmcId,5),unsigned)) AS "MAXIMO"
		FROM tblumcunidadmedidaconversion';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->UmcId ="UMC-10000";
		}else{
			$fila['MAXIMO']++;
			$this->UmcId = "UMC-".$fila['MAXIMO'];					
		}		
				
	}
		
	public function MtdObtenerUnidadMedidaConversion(){

        $sql = 'SELECT 
        UmcId,
		UmeId2,
		UmeId1,
		UmcEquivalente,	
        FROM tblumcunidadmedidaconversion
        WHERE UmcId = "'.$this->UmcId.'";';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->UmcId = $fila['UmcId'];
			$this->UmeId2 = $fila['UmeId2'];										
            $this->UmeId1 = $fila['UmeId1'];										
			$this->UmcEquivalente = $fila['UmcEquivalente'];
		}
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerUnidadMedidaConversiones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UmcId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUnidadMedida1=NULL,$oUnidadMedida2=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oUnidadMedida1)){
			$umedida1 = ' AND umc.UmeId1 = "'.$oUnidadMedida1.'"';
		}	

		if(!empty($oUnidadMedida2)){
			$umedida2 = ' AND umc.UmeId2 = "'.$oUnidadMedida2.'"';
		}			
	
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				umc.UmcId,
				umc.UmeId2,
				umc.UmeId1,
				umc.UmcEquivalente,
				ume1.UmeNombre AS UmeNombre1,
				ume1.UmeAbreviacion AS UmeAbreviacion1,
				ume2.UmeNombre AS UmeNombre2,
				ume2.UmeAbreviacion AS UmeAbreviacion2
				FROM tblumcunidadmedidaconversion umc
					LEFT JOIN tblumeunidadmedida ume1
					ON umc.UmeId1 = ume1.UmeId
						LEFT JOIN tblumeunidadmedida ume2
						ON umc.UmeId2 = ume2.UmeId
				WHERE 1 = 1 '.$filtrar.$umedida1.$umedida2.$orden.$paginacion;
		
//		echo "<br>";						
//		echo "<br>";						
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsUnidadMedidaConversion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$UnidadMedidaConversion = new $InsUnidadMedidaConversion();				
					
                    $UnidadMedidaConversion->UmcId = $fila['UmcId'];
					$UnidadMedidaConversion->UmeId2= $fila['UmeId2'];
                    $UnidadMedidaConversion->UmeId1= $fila['UmeId1'];
					$UnidadMedidaConversion->UmcEquivalente = $fila['UmcEquivalente'];

					$UnidadMedidaConversion->UmeNombre1 = $fila['UmeNombre1'];
					$UnidadMedidaConversion->UmeAbreviacion1 = $fila['UmeAbreviacion1'];

					$UnidadMedidaConversion->UmeNombre2 = $fila['UmeNombre2'];
					$UnidadMedidaConversion->UmeAbreviacion2 = $fila['UmeAbreviacion2'];
					
                    $UnidadMedidaConversion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $UnidadMedidaConversion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}


	public function MtdRegistrarUnidadMedidaConversion() {

		$this->MtdGenerarUnidadMedidaConversionId();

		$sql = 'INSERT INTO tblumcunidadmedidaconversion (
		UmcId,
		UmeId2,
		UmeId1,
		UmcEquivalente) 
		VALUES (
		"'.($this->UmcId).'", 
		"'.($this->UmeId2).'", 
		"'.($this->UmeId1).'", 
		'.($this->UmcEquivalente).');';	
		
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {				
			return true;
		}			
		
	}				
}

?>