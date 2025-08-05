<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUnidadMedida
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsUnidadMedida {

    public $UmeId;
    public $UmeNombre;
	public $UmeAbreviacion;
	public $UmeUso;	

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
		public function MtdGenerarUnidadMedidaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(UmeId,5),unsigned)) AS "MAXIMO"
			FROM tblumeunidadmedida';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->UmeId ="UME-10000";
			}else{
				$fila['MAXIMO']++;
				$this->UmeId = "UME-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerUnidadMedida(){

        $sql = 'SELECT 
        UmeId,
		UmeNombre,
		UmeAbreviacion,
		UmeUso
        FROM tblumeunidadmedida
        WHERE UmeId = "'.$this->UmeId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->UmeId = $fila['UmeId'];
            $this->UmeNombre = $fila['UmeNombre'];										
			$this->UmeAbreviacion = $fila['UmeAbreviacion'];
			$this->UmeUso = $fila['UmeUso'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL) {
		
		
		
		
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

		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
				
		if(!empty($oUso)){
			$uso = ' AND ume.UmeUso = '.$oUso;
		}	
		
	
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ume.UmeId,
				ume.UmeNombre,
				ume.UmeAbreviacion,
				ume.UmeUso
				FROM tblumeunidadmedida ume	
				WHERE 1 = 1 '.$filtrar.$uso.$orden.$paginacion;
			
						
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsUnidadMedida = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$UnidadMedida = new $InsUnidadMedida();				
                    $UnidadMedida->UmeId = $fila['UmeId'];
                    $UnidadMedida->UmeNombre= $fila['UmeNombre'];
                    $UnidadMedida->UmeAbreviacion= $fila['UmeAbreviacion'];
					$UnidadMedida->UmeUso = $fila['UmeUso'];					

                    $UnidadMedida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $UnidadMedida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	
	public function MtdRegistrarUnidadMedida() {

		$this->MtdGenerarUnidadMedidaId();

		$sql = 'INSERT INTO tblumeunidadmedida (
		UmeId,
		UmeNombre,
		UmeAbreviacion,
		UmeUso) 
		VALUES (
		"'.($this->UmeId).'", 
		"'.($this->UmeNombre).'", 
		"'.($this->UmeAbreviacion).'", 
		'.($this->UmeUso).');';	
		
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