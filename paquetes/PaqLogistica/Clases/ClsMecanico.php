<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMecanico
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsMecanico {

    public $MecId;
    public $MecNombre;
	public $UsuId;
	public $MecEstado;	
    public $MecTiempoCreacion;
    public $MecTiempoModificacion;
    public $MecEliminado;

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
		
	public function MtdGenerarMecanicoId() {

	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MecId,5),unsigned)) AS "MAXIMO"
			FROM tblmecmecanico';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MecId = "MEC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->MecId = "MEC-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerMecanico(){

        $sql = 'SELECT 
        MecId,
		UsuId,
		MecNombre,
		MecEstado,	
		DATE_FORMAT(MecTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMecTiempoCreacion",
        DATE_FORMAT(MecTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMecTiempoModificacion"
        FROM tblmecmecanico
        WHERE MecId = "'.$this->MecId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->MecId = $fila['MecId'];
			$this->UsuId = $fila['UsuId'];										
            $this->MecNombre = $fila['MecNombre'];										
			$this->MecEstado = $fila['MecEstado'];
			$this->MecTiempoCreacion = $fila['NMecTiempoCreacion'];
			$this->MecTiempoModificacion = $fila['NMecTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerMecanicos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MecId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL) {

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
			
				
		if(!empty($oEstado)){
			$estado = ' AND mec.MecEstado = '.$oEstado;
		}	
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				mec.MecId,
				mec.UsuId,
				mec.MecNombre,
				mec.MecEstado,
				DATE_FORMAT(mec.MecTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMecTiempoCreacion",
                DATE_FORMAT(mec.MecTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMecTiempoModificacion"
				FROM tblmecmecanico mec	
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsMecanico = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Mecanico = new $InsMecanico();				
					
                    $Mecanico->MecId = $fila['MecId'];
					$Mecanico->UsuId= $fila['UsuId'];
                    $Mecanico->MecNombre= $fila['MecNombre'];
					$Mecanico->MecEstado = $fila['MecEstado'];					
                    $Mecanico->MecTiempoCreacion = $fila['NMecTiempoCreacion'];
                    $Mecanico->MecTiempoModificacion = $fila['NMecTiempoModificacion'];    

					
                    $Mecanico->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Mecanico;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarMecanico($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MecId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MecId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblmecmecanico WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarMecanico() {
	
			$this->MtdGenerarMecanicoId();
		
			$sql = 'INSERT INTO tblmecmecanico (
			MecId,
			UsuId,
			MecNombre,
			MecEstado,
			MecTiempoCreacion,
			MecTiempoModificacion,
			MecEliminado) 
			VALUES (
			"'.($this->MecId).'", 
			"'.($this->UsuId).'", 
			"'.($this->MecNombre).'",
			'.($this->MecEstado).', 
			"'.($this->MecTiempoCreacion).'", 
			"'.($this->MecTiempoModificacion).'", 				
			'.($this->MecEliminado).');';					

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
	
	
	
	public function MtdEditarMecanico() {
		
			$sql = 'UPDATE tblmecmecanico SET 
			UsuId = "'.($this->UsuId).'",
			MecNombre = "'.($this->MecNombre).'",
			MecEstado = "'.($this->MecEstado).'",
			MecTiempoModificacion = "'.($this->MecTiempoModificacion).'"
			WHERE MecId = "'.($this->MecId).'";';
			
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