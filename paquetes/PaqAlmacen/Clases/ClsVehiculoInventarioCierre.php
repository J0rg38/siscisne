<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoInventarioCierre
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoInventarioCierre {

    public $VicId;
	public $VveId;
	public $VciFecha;
	public $VciAno;
	public $VciMes;
	public $VciCantidad;
	public $VciAnoFabricacion;
	public $VciAnoModelo;
	public $VicEstado;
    public $VicTiempoCreacion;
    public $VicTiempoModificacion;
    public $VicEliminado;
	
	
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

	public function MtdGenerarVehiculoInventarioCierreId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VicId,5),unsigned)) AS "MAXIMO"
			FROM tblvcivehiculocierreinventario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VicId = "VIC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VicId = "VIC-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculoInventarioCierre(){

        $sql = 'SELECT 
		vci.VicId,
		vci.VveId,
		
		DATE_FORMAT(vci.VciFecha, "%d/%m/%Y") AS "NVciFecha",
		
		vci.VciAno,
		vci.VciCantidad,
		vci.VciMes,
		vci.VciAnoFabricacion,
		
		vci.VciAnoModelo,
		vci.VicEstado,
		DATE_FORMAT(vci.VicTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoCreacion",
        DATE_FORMAT(vci.VicTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoModificacion",
	
		vve.VmoId,
		vmo.VmoNombre,

		vmo.VmaId,
		vma.VmaNombre,
		
		vmo.VtiId,
		vti.VtiNombre,
		
		vve.VveNombre
		
        FROM tblvcivehiculocierreinventario vci
		LEFT JOIN tblvvevciiculoversion vve
		ON vci.VveId = vve.VveId
			LEFT JOIN tblvmovciiculomodelo vmo
			ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvtivciiculotipo vti
				ON vmo.VtiId = vti.VtiId					
					LEFT JOIN tblvmavciiculomarca vma
					ON vmo.VmaId = vma.VmaId
        WHERE vci.VicId = "'.$this->VicId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VicId = $fila['VicId'];
			$this->VveId = $fila['VveId'];
			
			$this->VciFecha = $fila['NVciFecha'];
			$this->VciAno = $fila['VciAno'];
			$this->VciMes = $fila['VciMes'];
			$this->VciCantidad = $fila['VciCantidad'];
			
			$this->VciAnoFabricacion = $fila['VciAnoFabricacion'];
			$this->VciAnoModelo = $fila['VciAnoModelo'];
			
			$this->VicEstado = $fila['VicEstado'];					
			$this->VicTiempoCreacion = $fila['NVicTiempoCreacion'];
			$this->VicTiempoModificacion = $fila['NVicTiempoModificacion']; 
			
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
	
	
	
	
	public function MtdObtenerVehiculoInventarioCierres($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oVehiculoVersionId=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL) {

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
				vci.VicId,
				vci.VveId,
				
				vci.VciFecha,
				vci.VciAno,
				vci.VciMes,	
				vci.VciCantidad,
				
				vci.VciAnoFabricacion,
				vci.VciAnoModelo,
				vci.VicEstado,
				DATE_FORMAT(vci.VicTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoCreacion",
                DATE_FORMAT(vci.VicTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVicTiempoModificacion",
				
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VmaId,
				vma.VmaNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre
		
				FROM tblvcivehiculocierreinventario vci		
					LEFT JOIN tblvvevciiculoversion vve
					ON vci.VveId = vve.VveId
						LEFT JOIN tblvmovciiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivciiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavciiculomarca vma
								ON vmo.VmaId = vma.VmaId
								
				WHERE  1 = 1  '.$filtrar.$vmarca.$vmodelo.$vversion.$vtipo.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoInventarioCierre = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoInventarioCierre = new $InsVehiculoInventarioCierre();
					
					$VehiculoInventarioCierre->VicId = $fila['VicId'];
					$VehiculoInventarioCierre->VveId = $fila['VveId'];
					
					$VehiculoInventarioCierre->VciFecha = $fila['VciFecha'];
					$VehiculoInventarioCierre->VciAno = $fila['VciAno'];
					$VehiculoInventarioCierre->VciMes = $fila['VciMes'];
					
					$VehiculoInventarioCierre->VciCantidad = $fila['VciCantidad'];				
                    $VehiculoInventarioCierre->VciAnoFabricacion = $fila['VciAnoFabricacion'];
					$VehiculoInventarioCierre->VciAnoModelo = $fila['VciAnoModelo'];	
					
					$VehiculoInventarioCierre->VicEstado = $fila['VicEstado'];	
                    $VehiculoInventarioCierre->VicTiempoCreacion = $fila['NVicTiempoCreacion'];
                    $VehiculoInventarioCierre->VicTiempoModificacion = $fila['NVicTiempoModificacion'];
	
					$VehiculoInventarioCierre->VmoId = $fila['VmoId'];
					$VehiculoInventarioCierre->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoInventarioCierre->VmaId = $fila['VmaId'];
					$VehiculoInventarioCierre->VmaNombre = $fila['VmaNombre'];
					
					$VehiculoInventarioCierre->VtiId = $fila['VtiId'];
					$VehiculoInventarioCierre->VtiNombre = $fila['VtiNombre'];
					$VehiculoInventarioCierre->VveNombre = $fila['VveNombre'];
				
                    $VehiculoInventarioCierre->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoInventarioCierre;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		 
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoInventarioCierre($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VicId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VicId = "'.($elemento).'")  OR';	
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
	
	
	
	public function MtdRegistrarVehiculoInventarioCierre() {
			
			$this->MtdGenerarVehiculoInventarioCierreId();
			
			$sql = 'INSERT INTO tblvcivehiculocierreinventario (
			VicId,
			VveId,
			
			VciFecha,
			VciAno,
			VciMes,
			VciCantidad,

			VciAnoFabricacion,
			VciAnoModelo,
			
			VicEstado,
			VicTiempoCreacion,
			VicTiempoModificacion
			) 
			VALUES (
			"'.($this->VicId).'", 
			"'.($this->VveId).'", 
			
			"'.($this->VciFecha).'", 
			"'.($this->VciAno).'",
			"'.($this->VciMes).'",
			'.($this->VciCantidad).',
			
			"'.($this->VciAnoFabricacion).'",
			"'.($this->VciAnoModelo).'", 
			
			'.($this->VicEstado).',
			"'.($this->VicTiempoCreacion).'", 
			"'.($this->VicTiempoModificacion).'");';

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
	
	public function MtdEditarVehiculoInventarioCierre() {
		
						
			$sql = 'UPDATE tblvcivehiculocierreinventario SET 
			VveId = "'.($this->VveId).'",

			VciFecha = "'.($this->VciFecha).'",
			VciAno = "'.($this->VciAno).'",
			VciMes = "'.($this->VciMes).'",
			VciCantidad = '.($this->VciCantidad).',
			
			VciAnoFabricacion = "'.($this->VciAnoFabricacion).'",	
			VciAnoModelo = "'.($this->VciAnoModelo).'",			
			VicEstado = '.($this->VicEstado).',
			VicTiempoModificacion = "'.($this->VicTiempoModificacion).'"		
			WHERE VicId = "'.($this->VicId).'";';

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