<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReclamoFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReclamoFoto {

    public $RfoId;
	public $RecId;

	public $RfoArchivo;
	public $RfoComentario;

	public $RfoEstado;	
	public $RfoTiempoCreacion;
	public $RfoTiempoModificacion;
    public $RfoEliminado;
	
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

	private function MtdGenerarReclamoFotoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(RfoId,5),unsigned)) AS "MAXIMO"
		FROM tblrforeclamofoto';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RfoId = "RFO-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RfoId = "RFO-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerReclamoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RfoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oReclamo=NULL,$oEstado=NULL) {

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
		
		if(!empty($oReclamo)){
			$garantia = ' AND rfo.RecId = "'.$oReclamo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND rfo.RfoEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			rfo.RfoId,			
			rfo.RecId,

			rfo.RfoArchivo,
			rfo.RfoComentario,
			
			rfo.RfoEstado,
			DATE_FORMAT(rfo.RfoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRfoTiempoCreacion",
	        DATE_FORMAT(rfo.RfoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRfoTiempoModificacion"
			
			FROM tblrforeclamofoto rfo
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReclamoFoto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReclamoFoto = new $InsReclamoFoto();
                    $ReclamoFoto->RfoId = $fila['RfoId'];
                    $ReclamoFoto->RecId = $fila['RecId'];

					$ReclamoFoto->RfoArchivo = $fila['RfoArchivo']; 
					$ReclamoFoto->RfoComentario = $fila['RfoComentario'];
					  
					$ReclamoFoto->RfoEstado = $fila['RfoEstado'];
					$ReclamoFoto->RfoTiempoCreacion = $fila['NRfoTiempoCreacion'];  
					$ReclamoFoto->RfoTiempoModificacion = $fila['NRfoTiempoModificacion']; 					

                    $ReclamoFoto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReclamoFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarReclamoFoto($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (RfoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RfoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblrforeclamofoto 
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
	
	
	public function MtdRegistrarReclamoFoto() {
	
			$this->MtdGenerarReclamoFotoId();
			
			
			$sql = 'INSERT INTO tblrforeclamofoto (
			RfoId,
			RecId,
			
			RfoArchivo,
			RfoComentario,

			RfoEstado,
			RfoTiempoCreacion,
			RfoTiempoModificacion) 
			VALUES (
			"'.($this->RfoId).'", 
			"'.($this->RecId).'", 
			
			"'.($this->RfoArchivo).'", 
			"'.($this->RfoComentario).'", 
			
			'.($this->RfoEstado).',
			"'.($this->RfoTiempoCreacion).'",
			"'.($this->RfoTiempoModificacion).'");';
		
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
	
	public function MtdEditarReclamoFoto() {

			$sql = 'UPDATE tblrforeclamofoto SET 	
			
			RfoArchivo = "'.($this->RfoArchivo).'",
			RfoComentario = "'.($this->RfoComentario).'",
			RfoEstado = '.($this->RfoEstado).',
			RfoTiempoModificacion = "'.($this->RfoTiempoModificacion).'"
			 
			WHERE RfoId = "'.($this->RfoId).'";';
					
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