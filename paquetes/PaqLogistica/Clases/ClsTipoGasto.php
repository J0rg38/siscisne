<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTipoGasto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoGasto {

    public $TgaId;
    public $TgaNombre;
	public $TgaSigla;
	public $TgaDescripcion;	
	public $TgaUso;
	public $ProId;
	
	public $TgaArchivo;
	public $TgaFoto;
	public $TgaEstado;
    public $TgaTiempoCreacion;
    public $TgaTiempoModificacion;
    public $TgaEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarTipoGastoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TgaId,5),unsigned)) AS "MAXIMO"
			FROM tbltgatipogasto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TgaId = "TGA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TgaId = "TGA-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerTipoGasto(){

        $sql = 'SELECT 
        tga.TgaId,
        tga.TgaNombre,
		tga.TgaDescripcion,
		
		tga.TgaEstado,
		DATE_FORMAT(tga.TgaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTgaTiempoCreacion",
        DATE_FORMAT(tga.TgaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTgaTiempoModificacion"	
        FROM tbltgatipogasto tga
		WHERE tga.TgaId = "'.$this->TgaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TgaId = $fila['TgaId'];
            $this->TgaNombre = $fila['TgaNombre'];
			$this->TgaDescripcion = $fila['TgaDescripcion'];
			
			$this->TgaEstado = $fila['TgaEstado'];
			$this->TgaTiempoCreacion = $fila['NTgaTiempoCreacion'];
			$this->TgaTiempoModificacion = $fila['NTgaTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTipoGastos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TgaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$uso = '';
		$estado = '';
		$orden = '';
		$paginacion = '';

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oUso)){

			$elementos = explode(",",$oUso);

			$i=1;
			$uso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$uso .= '  (TgaUso = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$uso .= ' OR ';	
				}
			$i++;		
			}

			$uso .= ' ) 
			)
			';

		}
		
		if(!empty($oEstado)){
			$estado = ' AND tga.TgaEstado = '.($oEstado);
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tga.TgaId,
				tga.TgaNombre,
				tga.TgaDescripcion,
				tga.TgaUso,
				
				tga.TgaEstado,						
				DATE_FORMAT(tga.TgaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTgaTiempoCreacion",
                DATE_FORMAT(tga.TgaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTgaTiempoModificacion"				
				FROM tbltgatipogasto tga
				WHERE 1  = 1 '.$filtrar.$uso.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoGasto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$TipoGasto = new $InsTipoGasto();
                    $TipoGasto->TgaId = $fila['TgaId'];
                    $TipoGasto->TgaNombre= $fila['TgaNombre'];
					$TipoGasto->TgaDescripcion= $fila['TgaDescripcion'];
					$TipoGasto->TgaUso= $fila['TgaUso'];
					
					$TipoGasto->TgaEstado= $fila['TgaEstado'];
                    $TipoGasto->TgaTiempoCreacion = $fila['NTgaTiempoCreacion'];
                    $TipoGasto->TgaTiempoModificacion = $fila['NTgaTiempoModificacion'];    
					
					$TipoGasto->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$TipoGasto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarTipoGasto($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (TgaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TgaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tbltgatipogasto WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarTipoGasto() {
	
			$this->MtdGenerarTipoGastoId();
			
			$sql = 'INSERT INTO tbltgatipogasto (
			TgaId,
			TgaNombre, 
			TgaDescripcion,
			TgaUso,
			
			TgaEstado,
			TgaTiempoCreacion,
			TgaTiempoModificacion) 
			VALUES (
			"'.($this->TgaId).'", 
			"'.($this->TgaNombre).'", 
			"'.($this->TgaDescripcion).'", 
			'.($this->TgaUso).', 
			
			'.($this->TgaEstado).', 
			"'.($this->TgaTiempoCreacion).'", 
			"'.($this->TgaTiempoModificacion).'");';

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
	
	public function MtdEditarTipoGasto() {
		
			$sql = 'UPDATE tbltgatipogasto SET 
			 TgaNombre = "'.($this->TgaNombre).'",
			 TgaDescripcion = "'.($this->TgaDescripcion).'",
			 TgaUso = '.($this->TgaUso).',		
		
			 TgaEstado = '.($this->TgaEstado).',
			 TgaTiempoModificacion = "'.($this->TgaTiempoModificacion).'"
			 WHERE TgaId = "'.($this->TgaId).'";';
		
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