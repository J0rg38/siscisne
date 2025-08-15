<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsBanco
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsBanco {

    public $BanId;
	public $SucId;
    public $BanNombre;
    public $BanTiempoCreacion;
    public $BanTiempoModificacion;
    public $BanEliminado;
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
	
	public function MtdVerificarExisteBanco() {
		
		$Id = NULL;
		
		$sql = 'SELECT
		ban.BanId
		FROM tblbanbanco ban 
		WHERE ban.BanNombre = "'.$this->BanNombre.'" LIMIT 1';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);
		
		if(!empty($fila['BanId'])){
			$Id = $fila['BanId'];
		}
		
		
		return $Id;			
	}
	
	
	public function MtdGenerarBancoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(BanId,5),unsigned)) AS "MAXIMO"
			FROM tblbanbanco';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->BanId = "BAN-10000";

			}else{
				$fila['MAXIMO']++;
				$this->BanId = "BAN-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerBanco(){

        $sql = 'SELECT 
        BanId,
        BanNombre,
		BanDescripcion,
		DATE_FORMAT(BanTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBanTiempoCreacion",
        DATE_FORMAT(BanTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBanTiempoModificacion"
        FROM tblbanbanco
        WHERE BanId = "'.$this->BanId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->BanId = $fila['BanId'];
			$this->BanNombre = $fila['BanNombre'];
			$this->BanDescripcion = $fila['BanDescripcion'];
			$this->BanTiempoCreacion = $fila['NBanTiempoCreacion'];
			$this->BanTiempoModificacion = $fila['NBanTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerBancos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BanId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10') {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$sucursal = '';
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
		
		if(!empty($oSucursal)){
			$sucursal = ' AND SucId = "'.($oSucursal).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ban.BanId,
				ban.BanNombre,
				ban.BanDescripcion,
				DATE_FORMAT(ban.BanTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBanTiempoCreacion",
                DATE_FORMAT(ban.BanTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBanTiempoModificacion"				
				FROM tblbanbanco ban
				WHERE ban.BanEliminado = 1 '.$filtrar.$sucursal.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBanco = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Banco = new $InsBanco();
                    $Banco->BanId = $fila['BanId'];
					$Banco->BanNombre= $fila['BanNombre'];
					$Banco->BanDescripcion= $fila['BanDescripcion'];
                    $Banco->BanTiempoCreacion = $fila['NBanTiempoCreacion'];
                    $Banco->BanTiempoModificacion = $fila['NBanTiempoModificacion'];                    
                    $Banco->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Banco;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarBanco($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (BanId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (BanId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblbanbanco WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarBanco() {
	
			$this->MtdGenerarBancoId();
		
			$sql = 'INSERT INTO tblbanbanco (
			BanId,
			BanNombre, 
			BanDescripcion,
			BanTiempoCreacion,
			BanTiempoModificacion,
			BanEliminado) 
			VALUES (
			"'.($this->BanId).'", 
			"'.($this->BanNombre).'", 
			"'.($this->BanDescripcion).'", 
			"'.($this->BanTiempoCreacion).'", 
			"'.($this->BanTiempoModificacion).'", 				
			'.($this->BanEliminado).');';					

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
	
	public function MtdEditarBanco() {
		
			$sql = 'UPDATE tblbanbanco SET 
			 BanNombre = "'.($this->BanNombre).'",
			 BanDescripcion = "'.($this->BanDescripcion).'",
			 BanTiempoModificacion = "'.($this->BanTiempoModificacion).'"
			 WHERE BanId = "'.($this->BanId).'";';
			
		
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
		
		public function MtdEditarBanco2() {
		
			$sql = 'UPDATE tblbanbanco SET 
			 BanNombre = "'.($this->BanNombre).'",
			 BanTiempoModificacion = "'.($this->BanTiempoModificacion).'"
			 WHERE BanId = "'.($this->BanId).'";';
			
		
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