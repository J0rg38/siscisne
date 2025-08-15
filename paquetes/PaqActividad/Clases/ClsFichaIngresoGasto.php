<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoGasto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoGasto {

    public $FigId;
	public $FinId;
	public $GasId;
	
	public $FigEstado;
	public $FigTiempoCreacion;
	public $FigTiempoModificacion;
    public $FigEliminado;

    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoGastoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FigId,5),unsigned)) AS "MAXIMO"
		FROM tblfigfichaingresogasto';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FigId = "FIG-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FigId = "FIG-".$fila['MAXIMO'];					
		}

	}
	

    	public function MtdObtenerFichaIngresoGastos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FigId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {
		
		// Inicializar variables para evitar warnings
		$fingreso = '';
		$estado = '';
		$filtrar = '';
		$orden = '';
		$paginacion = '';

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explode(",",$oCampo);

			$i=1;
			$filtrar .= '  AND (';
			foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fig.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fig.FigEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fig.FigId,			
			fig.FinId,
			fig.GasId,
			
			fig.FigEstado,
			DATE_FORMAT(fig.FigTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoCreacion",
	        DATE_FORMAT(fig.FigTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoModificacion",
			
			gas.GasComprobanteNumero,
			DATE_FORMAT(gas.GasComprobanteFecha, "%d/%m/%Y") AS "NGasComprobanteFecha",
			gas.GasTotal,
			gas.GasTipoCambio,
			
			gas.GasConcepto,
			gas.MonId,
			
			mon.MonSimbolo,
			mon.MonNombre,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno
		
			FROM tblfigfichaingresogasto fig
				
				LEFT JOIN tblgasgasto gas
				ON fig.GasId = gas.GasId
					LEFT JOIN tblprvproveedor prv
					ON gas.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON gas.MonId = mon.MonId
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoGasto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoGasto = new $InsFichaIngresoGasto();
                    $FichaIngresoGasto->FigId = $fila['FigId'];
                    $FichaIngresoGasto->FinId = $fila['FinId'];					
					$FichaIngresoGasto->GasId = $fila['GasId'];
					
					$FichaIngresoGasto->FigEstado = $fila['FigEstado'];
					$FichaIngresoGasto->FigTiempoCreacion = $fila['NFigTiempoCreacion'];  
					$FichaIngresoGasto->FigTiempoModificacion = $fila['NFigTiempoModificacion']; 
					
					$FichaIngresoGasto->GasComprobanteNumero = $fila['GasComprobanteNumero']; 
					$FichaIngresoGasto->GasComprobanteFecha = $fila['NGasComprobanteFecha']; 
					$FichaIngresoGasto->GasTotal = $fila['GasTotal'];
					$FichaIngresoGasto->GasTipoCambio = $fila['GasTipoCambio'];
					
					
					$FichaIngresoGasto->GasConcepto = $fila['GasConcepto'];
					$FichaIngresoGasto->MonId = $fila['MonId'];
					
					$FichaIngresoGasto->MonSimbolo = $fila['MonSimbolo'];
					$FichaIngresoGasto->MonNombre = $fila['MonNombre'];
					
					$FichaIngresoGasto->PrvNombre = $fila['PrvNombre']; 
					$FichaIngresoGasto->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 		
					$FichaIngresoGasto->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 

                    $FichaIngresoGasto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoGasto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoGasto($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FigId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FigId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfigfichaingresogasto 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarFichaIngresoGasto() {
	
			$this->MtdGenerarFichaIngresoGastoId();
			
			$sql = 'INSERT INTO tblfigfichaingresogasto (
			FigId,
			FinId,	
			GasId,
			
			FigEstado,
			FigTiempoCreacion,
			FigTiempoModificacion) 
			VALUES (
			"'.($this->FigId).'", 
			"'.($this->FinId).'", 
			"'.($this->GasId).'",
			
			'.($this->FigEstado).',
			"'.($this->FigTiempoCreacion).'",
			"'.($this->FigTiempoModificacion).'");';
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarFichaIngresoGasto() {

		$sql = 'UPDATE tblfigfichaingresogasto SET 	
		GasId = "'.($this->GasId).'",
		FigTiempoModificacion = "'.($this->FigTiempoModificacion).'"
		WHERE FigId = "'.($this->FigId).'";';
				
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
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