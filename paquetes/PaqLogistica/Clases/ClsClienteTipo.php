<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsClienteTipo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClienteTipo {

    public $LtiId;
    public $LtiNombre;
	public $LtiAbreviatura;
	public $LtiUtilidad;
	public $LtiPorcentajeMargenUtilidad;
	public $VmaId;
	public $VmaObservacion;
	public $LtiUso;
	public $LtiEstado;
	public $LtiTiempoCreacion;
	public $LtiTiempoModificacio;

	public $VmaNombre;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarClienteTipoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(LtiId,5),unsigned)) AS "MAXIMO"
		FROM tbllticlientetipo';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->LtiId = "LTI-10000";
		}else{
			$fila['MAXIMO']++;
			$this->LtiId = "LTI-".$fila['MAXIMO'];					
		}

	}
		
		
    public function MtdObtenerClienteTipo(){

        $sql = 'SELECT 
        LtiId,
		VmaId,
		
		LtiNombre,
		LtiAbreviatura,
		
		LtiPorcentajeMargenUtilidad,
		LtiPorcentajeOtroCosto,
		LtiPorcentajeDescuento,
		LtiPorcentajeManoObra,
		LtiManoObra,
		
		LtiUtilidad,
		LtiUso,
		LtiObservacion,
		LtiEstado,
		DATE_FORMAT(LtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NLtiTiempoCreacion",
        DATE_FORMAT(LtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NLtiTiempoModificacion"
		FROM tbllticlientetipo
        WHERE LtiId = "'.$this->LtiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->LtiId = $fila['LtiId'];
			$this->VmaId = $fila['VmaId'];	
			
			$this->LtiNombre = $fila['LtiNombre'];	
			$this->LtiAbreviatura = $fila['LtiAbreviatura'];
			
			$this->LtiPorcentajeMargenUtilidad = $fila['LtiPorcentajeMargenUtilidad'];
			$this->LtiPorcentajeOtroCosto = $fila['LtiPorcentajeOtroCosto'];
			$this->LtiPorcentajeDescuento = $fila['LtiPorcentajeDescuento'];
			$this->LtiPorcentajeManoObra = $fila['LtiPorcentajeManoObra'];
			$this->LtiManoObra= $fila['LtiManoObra'];
			 
			$this->LtiUtilidad = $fila['LtiUtilidad'];	
			$this->LtiUso = $fila['LtiUso'];
			$this->LtiObservacion = $fila['LtiObservacion'];		
			$this->LtiEstado = $fila['LtiEstado'];	
			
			$this->LtiTiempoCreacion = $fila['NLtiTiempoCreacion'];	
			$this->LtiTiempoModificacion = $fila['NLtiTiempoModificacion'];	
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$vmarca = '';
		$estado = '';
		$orden = '';
		$paginacion = '';

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
	
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND lti.VmaId = "'.($oVehiculoMarca).'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND lti.LtiEstado = '.($oEstado).'';
		}
			
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				 LtiId,
				lti.VmaId,
				
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				lti.LtiPorcentajeMargenUtilidad,
				lti.LtiPorcentajeOtroCosto,
				lti.LtiPorcentajeDescuento,
				lti.LtiPorcentajeManoObra,
				lti.LtiManoObra,
				
				lti.LtiUtilidad,
				lti.LtiUso,
				lti.LtiObservacion,
				lti.LtiEstado,
				DATE_FORMAT(lti.LtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NLtiTiempoCreacion",
				DATE_FORMAT(lti.LtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NLtiTiempoModificacion",
				vma.VmaNombre
				
				FROM tbllticlientetipo lti	
					LEFT JOIN tblvmavehiculomarca vma
					ON lti.VmaId = vma.VmaId
				WHERE 1 = 1 '.$filtrar.$vmarca.$estado.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsClienteTipo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

/*
TAXI 30
CAMION 40
PARTICULARES 50
CAMIONETAS 60
*/
					$ClienteTipo = new $InsClienteTipo();				
					
                    $ClienteTipo->LtiId = $fila['LtiId'];
					$ClienteTipo->VmaId= $fila['VmaId'];
					
					$ClienteTipo->LtiNombre= $fila['LtiNombre'];
					$ClienteTipo->LtiAbreviatura= $fila['LtiAbreviatura'];
					
					$ClienteTipo->LtiPorcentajeMargenUtilidad= $fila['LtiPorcentajeMargenUtilidad'];
					$ClienteTipo->LtiPorcentajeOtroCosto= $fila['LtiPorcentajeOtroCosto'];
					$ClienteTipo->LtiPorcentajeDescuento= $fila['LtiPorcentajeDescuento'];
					$ClienteTipo->LtiPorcentajeManoObra= $fila['LtiPorcentajeManoObra'];
					$ClienteTipo->LtiManoObra= $fila['LtiManoObra'];
					
					$ClienteTipo->LtiUtilidad= $fila['LtiUtilidad'];
					$ClienteTipo->LtiUso = $fila['LtiUso'];
					$ClienteTipo->LtiObservacion= $fila['LtiObservacion'];
					$ClienteTipo->LtiEstado= $fila['LtiEstado'];
					$ClienteTipo->LtiTiempoCreacion= $fila['NLtiTiempoCreacion'];
					$ClienteTipo->LtiTiempoModificacion= $fila['NLtiTiempoModificacion'];
					
					$ClienteTipo->VmaNombre= $fila['VmaNombre'];
					
                    $ClienteTipo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ClienteTipo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	
	
	
	//Accion eliminar	 
	
	public function MtdEliminarClienteTipo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (LtiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (LtiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tbllticlientetipo WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarClienteTipo() {
	
		$this->MtdGenerarClienteTipoId();
		
		$sql = 'INSERT INTO tbllticlientetipo (
		LtiId,
		VmaId,
		
		LtiNombre, 
		LtiAbreviatura,
		
		LtiPorcentajeMargenUtilidad,
		LtiPorcentajeOtroCosto,
		LtiPorcentajeDescuento,
		LtiPorcentajeManoObra,
		
		LtiObservacion,
		LtiEstado,
		LtiTiempoCreacion,
		LtiTiempoModificacion
		) 
		VALUES (
		"'.($this->LtiId).'",
		NULL,
			
		"'.($this->LtiNombre).'",
		"'.($this->LtiAbreviatura).'",
		
		'.($this->LtiPorcentajeMargenUtilidad).',
		'.($this->LtiPorcentajeOtroCosto).',
		'.($this->LtiPorcentajeDescuento).',
		'.($this->LtiPorcentajeManoObra).',
		
		"'.($this->LtiObservacion).'",
		'.($this->LtiEstado).',
		"'.($this->LtiTiempoCreacion).'",
		"'.($this->LtiTiempoModificacion).'");';

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
	
	public function MtdEditarClienteTipo() {
		
		$sql = 'UPDATE tbllticlientetipo SET 
		LtiNombre = "'.($this->LtiNombre).'",
		LtiAbreviatura = "'.($this->LtiAbreviatura).'",
		
		LtiPorcentajeMargenUtilidad = '.($this->LtiPorcentajeMargenUtilidad).',
		LtiPorcentajeOtroCosto = '.($this->LtiPorcentajeOtroCosto).',
		LtiPorcentajeDescuento = '.($this->LtiPorcentajeDescuento).',
		LtiPorcentajeManoObra = '.($this->LtiPorcentajeManoObra).',
		
		LtiObservacion = "'.($this->LtiObservacion).'",
		LtiEstado = '.($this->LtiEstado).',
		LtiTiempoModificacion = "'.($this->LtiTiempoModificacion).'"
		WHERE LtiId = "'.($this->LtiId).'";';
		
		
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