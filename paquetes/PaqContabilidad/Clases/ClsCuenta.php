<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCuenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCuenta {

    public $CueId;
    public $CueNumero;
	public $CueCCI;
    public $BanId;
    public $MonId;
	public $CueSaldo;
	
	public $CueDescripcion;
	public $CueEstado;	
    public $CueTiempoCreacion;
    public $CueTiempoModificacion;
    public $CueEliminado;

	public $BanNombre;
	
	public $InsMysql;


	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarCuentaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CueId,5),unsigned)) AS "MAXIMO"
			FROM tblcuecuenta';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CueId = "CUE-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CueId = "CUE-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerCuenta(){

        $sql = 'SELECT 
        CueId,
		CueNumero,
		CueCCI,
		BanId,
		MonId,
		0 AS CueIngresos,
		0 AS CueSalidas,
		CueSaldo,
		CueDescripcion,
		CueEstado,	
		DATE_FORMAT(CueTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCueTiempoCreacion",
        DATE_FORMAT(CueTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCueTiempoModificacion"
        FROM tblcuecuenta
        WHERE CueId = "'.$this->CueId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CueId = $fila['CueId'];
            $this->CueNumero = $fila['CueNumero'];
			$this->CueCCI = $fila['CueCCI'];
			
			
			$this->BanId = $fila['BanId'];
			$this->MonId = $fila['MonId'];
			$this->CueIngresos = $fila['CueIngresos'];
			$this->CueSalidas = $fila['CueSalidas'];
			$this->CueSaldo = $fila['CueSaldo'];
										
										
			$this->CueDescripcion = $fila['CueDescripcion'];										
			$this->CueEstado = $fila['CueEstado'];
			$this->CueTiempoCreacion = $fila['NCueTiempoCreacion'];
			$this->CueTiempoModificacion = $fila['NCueTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCuentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CueId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oMoneda=NULL,$oBanco = NULL,$oTarjeta=NULL) {

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
			$estado = ' AND cue.CueEstado = '.$oEstado;
		}	
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND cue.MonId = "'.$oMoneda.'"';
		}	
		
		if(!empty($oBanco)){
			$banco = ' AND cue.BanId = "'.$oBanco.'"';
		}
		
		if(!empty($oTarjeta)){
			$tarjeta = ' AND tar.TarId = "'.$oTarjeta.'"';
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cue.CueId,
				cue.CueNumero,
				cue.CueCCI,
				cue.BanId,
				cue.MonId,
				cue.Cuesaldo,
				0 AS CueIngresos,
				0 AS CueSalidas,
				
				cue.CueDescripcion,
				cue.CueEstado,
				DATE_FORMAT(cue.CueTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCueTiempoCreacion",
                DATE_FORMAT(cue.CueTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCueTiempoModificacion",
				ban.BanNombre,
				
				mon.MonNombre,
				mon.MonSimbolo
				
				FROM tblcuecuenta cue
					LEFT JOIN tblbanbanco ban
					ON cue.BanId = ban.BanId	
						LEFT JOIN tblmonmoneda mon
						ON cue.MonId = mon.MonId
							LEFT JOIN tbltartarjeta tar
							ON tar.CueId = cue.CueId
							
				WHERE 1 = 1 '.$filtrar.$moneda.$tipo.$estado.$banco.$tarjeta.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCuenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Cuenta = new $InsCuenta();				
					
                    $Cuenta->CueId = $fila['CueId'];
                    $Cuenta->CueNumero= $fila['CueNumero'];
					$Cuenta->CueCCI= $fila['CueCCI'];
					
					
					
					$Cuenta->BanId= $fila['BanId'];
					$Cuenta->MonId = $fila['MonId'];
					
					$Cuenta->CueIngresos = $fila['CueIngresos'];
					$Cuenta->CueSalidas = $fila['CueSalidas'];
					$Cuenta->CueSaldo = $fila['CueSaldo'];
					
					
					$Cuenta->CueDescripcion = $fila['CueDescripcion'];
					$Cuenta->CueEstado = $fila['CueEstado'];
                    $Cuenta->CueTiempoCreacion = $fila['NCueTiempoCreacion'];
					$Cuenta->CueTiempoModificacion = $fila['NCueTiempoModificacion'];

					$Cuenta->BanNombre = $fila['BanNombre'];
					
					$Cuenta->MonNombre = $fila['MonNombre'];
					$Cuenta->MonSimbolo = $fila['MonSimbolo'];


                    $Cuenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Cuenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarCuenta($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CueId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CueId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblcuecuenta WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarCuenta() {
	
			$this->MtdGenerarCuentaId();
		
			$sql = 'INSERT INTO tblcuecuenta (
			CueId,
			CueNumero,
			CueCCI,
			BanId,
			MonId,
			CueSaldo,
			CueDescripcion,
			CueEstado,
			CueTiempoCreacion,
			CueTiempoModificacion
			) 
			VALUES (
			"'.($this->CueId).'", 
			"'.($this->CueNumero).'",
			"'.($this->CueCCI).'",
			
			
			"'.($this->BanId).'",
			"'.($this->MonId).'",
			'.($this->CueSaldo).',
			"'.($this->CueDescripcion).'", 
			'.($this->CueEstado).', 
			"'.($this->CueTiempoCreacion).'", 
			"'.($this->CueTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarCuenta() {
		

			$sql = 'UPDATE tblcuecuenta SET 
			CueNumero = "'.($this->CueNumero).'",
			CueCCI = "'.($this->CueCCI).'",
			
			
			BanId = "'.($this->BanId ).'",
			MonId = "'.($this->MonId).'",
			
			 CueDescripcion = "'.($this->CueDescripcion).'",
			 CueEstado = '.($this->CueEstado).',
			 CueTiempoModificacion = "'.($this->CueTiempoModificacion).'"
			 WHERE CueId = "'.($this->CueId).'";';
			
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