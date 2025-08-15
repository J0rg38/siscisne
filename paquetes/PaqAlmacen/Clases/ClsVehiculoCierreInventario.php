<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoCierreInventario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoCierreInventario {

    public $VciId;
	public $VveId;
	public $VciFecha;
	public $VciAno;
	public $VciMes;
	public $VciCantidad;
	public $VciAnoFabricacion;
	public $VciAnoModelo;
	public $VciEstado;
    public $VciTiempoCreacion;
    public $VciTiempoModificacion;
    public $VciEliminado;
	
	
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

	public function MtdGenerarVehiculoCierreInventarioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VciId,5),unsigned)) AS "MAXIMO"
			FROM tblvcivehiculocierreinventario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VciId = "VIC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VciId = "VIC-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculoCierreInventario(){

        $sql = 'SELECT 
		vci.VciId,
		vci.VveId,
		
		DATE_FORMAT(vci.VciFecha, "%d/%m/%Y") AS "NVciFecha",
		
		vci.VciAno,
		vci.VciCantidad,
		vci.VciMes,
		vci.VciAnoFabricacion,
		
		vci.VciAnoModelo,
		vci.VciEstado,
		DATE_FORMAT(vci.VciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVciTiempoCreacion",
        DATE_FORMAT(vci.VciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVciTiempoModificacion",
	
		vve.VmoId,
		vmo.VmoNombre,

		vmo.VmaId,
		vma.VmaNombre,
		
		vmo.VtiId,
		vti.VtiNombre,
		
		vve.VveNombre
		
        FROM tblvcivehiculocierreinventario vci
		LEFT JOIN tblvvevehiculoversion vve
		ON vci.VveId = vve.VveId
			LEFT JOIN tblvmovehiculomodelo vmo
			ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvtivehiculotipo vti
				ON vmo.VtiId = vti.VtiId					
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
        WHERE vci.VciId = "'.$this->VciId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VciId = $fila['VciId'];
			$this->VveId = $fila['VveId'];
			
			$this->VciFecha = $fila['NVciFecha'];
			$this->VciAno = $fila['VciAno'];
			$this->VciMes = $fila['VciMes'];
			$this->VciCantidad = $fila['VciCantidad'];
			
			$this->VciAnoFabricacion = $fila['VciAnoFabricacion'];
			$this->VciAnoModelo = $fila['VciAnoModelo'];
			
			$this->VciEstado = $fila['VciEstado'];					
			$this->VciTiempoCreacion = $fila['NVciTiempoCreacion'];
			$this->VciTiempoModificacion = $fila['NVciTiempoModificacion']; 
			
			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre']; 
			
			$this->VmaId = $fila['VmaId']; 
			$this->VmaNombre = $fila['VmaNombre']; 
			
			$this->VtiId = $fila['VtiId']; 			
			$this->VtiNombre = $fila['VtiNombre']; 
			
			$this->VveNombre = $fila['VveNombre']; 
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
	
	
	public function MtdObtenerVehiculoCierreInventarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oVehiculoVersionId=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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

		
		if(!empty($oAno)){
			$ano = ' AND vci.VciAno = "'.($oAno).'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND vci.VciMes = "'.($oMes).'"';
		}
		
		if(!empty($oVehiculoVersionId)){
			$vversion = ' AND vci.VveId = "'.($oVehiculoVersionId).'"';
		}
			
		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND vci.VciAnoFabricacion = '.($oAnoFabricacion).'';
		}
		
		if(!empty($oAnoModelo)){
			$amodelo = ' AND vci.VciAnoModelo = '.$oAnoModelo.' ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vci.VciId,
				vci.VveId,
				
				vci.VciFecha,
				vci.VciAno,
				vci.VciMes,	
				vci.VciCantidad,
				
				vci.VciAnoFabricacion,
				vci.VciAnoModelo,
				vci.VciEstado,
				DATE_FORMAT(vci.VciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVciTiempoCreacion",
                DATE_FORMAT(vci.VciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVciTiempoModificacion",
				
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VmaId,
				vma.VmaNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre
		
				FROM tblvcivehiculocierreinventario vci		
					LEFT JOIN tblvvevehiculoversion vve
					ON vci.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
								
				WHERE  1 = 1  '.$filtrar.$vmarca.$vmodelo.$vversion.$vtipo.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoCierreInventario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoCierreInventario = new $InsVehiculoCierreInventario();
					
					$VehiculoCierreInventario->VciId = $fila['VciId'];
					$VehiculoCierreInventario->VveId = $fila['VveId'];
					
					$VehiculoCierreInventario->VciFecha = $fila['VciFecha'];
					$VehiculoCierreInventario->VciAno = $fila['VciAno'];
					$VehiculoCierreInventario->VciMes = $fila['VciMes'];
					
					$VehiculoCierreInventario->VciCantidad = $fila['VciCantidad'];				
                    $VehiculoCierreInventario->VciAnoFabricacion = $fila['VciAnoFabricacion'];
					$VehiculoCierreInventario->VciAnoModelo = $fila['VciAnoModelo'];	
					
					$VehiculoCierreInventario->VciEstado = $fila['VciEstado'];	
                    $VehiculoCierreInventario->VciTiempoCreacion = $fila['NVciTiempoCreacion'];
                    $VehiculoCierreInventario->VciTiempoModificacion = $fila['NVciTiempoModificacion'];
	
					$VehiculoCierreInventario->VmoId = $fila['VmoId'];
					$VehiculoCierreInventario->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoCierreInventario->VmaId = $fila['VmaId'];
					$VehiculoCierreInventario->VmaNombre = $fila['VmaNombre'];
					
					$VehiculoCierreInventario->VtiId = $fila['VtiId'];
					$VehiculoCierreInventario->VtiNombre = $fila['VtiNombre'];
					$VehiculoCierreInventario->VveNombre = $fila['VveNombre'];
				
                    $VehiculoCierreInventario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoCierreInventario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		 
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoCierreInventario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VciId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VciId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvcivehiculocierreinventario WHERE '.$eliminar;			
		
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
	
	
	
	public function MtdRegistrarVehiculoCierreInventario() {
			
			$this->MtdGenerarVehiculoCierreInventarioId();
			
			$sql = 'INSERT INTO tblvcivehiculocierreinventario (
			VciId,
			VveId,
			
			VciFecha,
			VciAno,
			VciMes,
			VciCantidad,

			VciAnoFabricacion,
			VciAnoModelo,
			
			VciEstado,
			VciTiempoCreacion,
			VciTiempoModificacion
			) 
			VALUES (
			"'.($this->VciId).'", 
			"'.($this->VveId).'", 
			
			"'.($this->VciFecha).'", 
			"'.($this->VciAno).'",
			"'.($this->VciMes).'",
			'.($this->VciCantidad).',
			
			"'.($this->VciAnoFabricacion).'",
			"'.($this->VciAnoModelo).'", 
			
			'.($this->VciEstado).',
			"'.($this->VciTiempoCreacion).'", 
			"'.($this->VciTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarVehiculoCierreInventario() {
		
						
			$sql = 'UPDATE tblvcivehiculocierreinventario SET 
			VveId = "'.($this->VveId).'",

			VciFecha = "'.($this->VciFecha).'",
			VciAno = "'.($this->VciAno).'",
			VciMes = "'.($this->VciMes).'",
			VciCantidad = '.($this->VciCantidad).',
			
			VciAnoFabricacion = "'.($this->VciAnoFabricacion).'",	
			VciAnoModelo = "'.($this->VciAnoModelo).'",			
			VciEstado = '.($this->VciEstado).',
			VciTiempoModificacion = "'.($this->VciTiempoModificacion).'"		
			WHERE VciId = "'.($this->VciId).'";';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
	}	
	
}
?>