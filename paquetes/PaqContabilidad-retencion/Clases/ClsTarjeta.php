<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTarjeta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTarjeta {

    public $TarId;
	public $CueId;
	
    public $TarNombre;
	public $TarDescripcion;
	public $TarUso;
	
    public $TarTiempoCreacion;
    public $TarTiempoModificacion;
    public $TarEliminado;
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
	
	
	
	
	public function MtdGenerarTarjetaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TarId,5),unsigned)) AS "MAXIMO"
			FROM tbltartarjeta';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TarId = "TAR-10000";

			}else{
				$fila['MAXIMO']++;
				$this->TarId = "TAR-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerTarjeta(){

        $sql = 'SELECT 
        tar.TarId,
		tar.CueId,
		
        tar.TarNombre,
		tar.TarDescripcion,
		tar.TarUso
		
        FROM tbltartarjeta
        WHERE TarId = "'.$this->TarId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TarId = $fila['TarId'];
			$this->CueId = $fila['CueId'];
			
			$this->TarNombre = $fila['TarNombre'];
			$this->TarDescripcion = $fila['TarDescripcion'];
			$this->TarUso = $fila['TarUso'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTarjetas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TarId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL,$oMoneda=NULL) {

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
			$uso = ' AND tar.TarUso = '.($oUso).'';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cue.MonId = "'.($oMoneda).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tar.TarId,
				tar.CueId,
				
				tar.TarNombre,
				tar.TarDescripcion,
				tar.TarUso,
				
				mon.MonNombre
				
				FROM tbltartarjeta tar
					LEFT JOIN tblcuecuenta cue
					ON tar.CueId = cue.CueId
						LEFT JOIN tblmonmoneda mon
						ON cue.MonId = mon.MonId
					
				WHERE 1 = 1 '.$filtrar.$uso.$moneda.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTarjeta = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Tarjeta = new $InsTarjeta();
                    $Tarjeta->TarId = $fila['TarId'];
					$Tarjeta->CueId = $fila['CueId'];
					
					$Tarjeta->TarNombre= $fila['TarNombre'];
					$Tarjeta->TarDescripcion= $fila['TarDescripcion'];
					$Tarjeta->TarUso= $fila['TarUso'];
					
					$Tarjeta->MonNombre = $fila['MonNombre'];
                                   
                    $Tarjeta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Tarjeta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarTarjeta($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (TarId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TarId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tbltartarjeta WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarTarjeta() {
	
			$this->MtdGenerarTarjetaId();
		
			$sql = 'INSERT INTO tbltartarjeta (
			TarId,
			CueId,
			
			TarNombre, 
			TarDescripcion,
			TarUso
			) 
			VALUES (
			"'.($this->TarId).'", 
			"'.($this->CueId).'", 
			
			"'.($this->TarNombre).'", 
			"'.($this->TarDescripcion).'", 
			'.($this->TarUso).');';					

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
	
	public function MtdEditarTarjeta() {
		
			$sql = 'UPDATE tbltartarjeta SET 
			CueId = "'.($this->CueId).'",
			TarNombre = "'.($this->TarNombre).'",
			TarDescripcion = "'.($this->TarDescripcion).'",
			TarUso = '.($this->TarUso).'
			WHERE TarId = "'.($this->TarId).'";';
			
		
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