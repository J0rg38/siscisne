<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoInstalar
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoInstalar {

    public $VisId;
	public $PrvId;
	public $EinId;
	
	public $VisFecha;
    public $VisFechaProgramada;
	public $VisHoraProgramada;
	public $VisMonto;
	public $VisMontoReal;
	public $VisObservacionInterna;
	public $VisObservacionImpresa;
	public $VisKilometrajeMantenimiento;
	
	public $VisEstado;	
    public $VisTiempoCreacion;
    public $VisTiempoModificacion;
    public $VisEliminado;

	public $InsMysql;

	public $Transaccion;
	
    public function __construct(){

		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
		
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarVehiculoInstalarId() {
	
			
			$sql = 'SELECT	
			suc.SucSiglas AS SIGLA,
			MAX(CONVERT(SUBSTR(vis.VisId,5),unsigned)) AS "MAXIMO"
			FROM tblvisvehiculoinstalar vis
				LEFT JOIN tblsucsucursal suc
			ON vis.SucId = suc.SucId
			
			WHERE vis.SucId = "'.$this->SucId.'"
			';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VisId = "VIS-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);

			}else{
				$fila['MAXIMO']++;
				$this->VisId = "VIS-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);				
			}	
			
				
		}
		
    public function MtdObtenerVehiculoInstalar($oCompleto=true){

        $sql = 'SELECT 
        vis.VisId,
		vis.SucId,
		
		vis.EinId,
		vis.PerId,
	
		DATE_FORMAT(vis.VisFecha, "%d/%m/%Y") AS "NVisFecha",
		
		vis.VisObservacionInterna,
		vis.VisObservacionImpresa,
		
		vis.VisReferencia,
			
		vis.VisEstado,	
		DATE_FORMAT(vis.VisTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVisTiempoCreacion",
        DATE_FORMAT(vis.VisTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVisTiempoModificacion",

		ein.EinVIN,
		ein.EinPlaca,
		ein.EinColor,
		ein.EinAnoFabricacion,
		ein.EinAnoModelo,
		
		ein.VveId,
		vve.VmoId,
		vmo.VmaId,
	
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre
		
        FROM tblvisvehiculoinstalar vis
		
				LEFT JOIN tbleinvehiculoingreso ein
				ON vis.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
									
        WHERE vis.VisId = "'.$this->VisId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->VisId = $fila['VisId'];
				$this->SucId = $fila['SucId'];
				
				
				$this->EinId = $fila['EinId'];
				$this->PerId = $fila['PerId'];
				$this->CliId = $fila['CliId'];
			
				$this->VisFecha = $fila['NVisFecha'];

				$this->VisObservacionInterna = $fila['VisObservacionInterna'];
				$this->VisObservacionImpresa = $fila['VisObservacionImpresa'];
				
				$this->VisReferencia = $fila['VisReferencia'];

				$this->VisTipoCambio = $fila['VisTipoCambio'];
				
				$this->VisEstado = $fila['VisEstado'];
				$this->VisTiempoCreacion = $fila['NVisTiempoCreacion'];
				$this->VisTiempoModificacion = $fila['NVisTiempoModificacion'];
				
			
				$this->EinVIN = $fila['EinVIN'];
				$this->EinPlaca = $fila['EinPlaca'];
				$this->EinColor = $fila['EinColor'];
				$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
				$this->EinAnoModelo = $fila['EinAnoModelo'];
				
				$this->VveId = $fila['VveId'];
				$this->VmoId = $fila['VmoId'];
				$this->VmaId = $fila['EinAnoModelo'];
			
				$this->VmaNombre = $fila['VmaNombre'];
				$this->VmoNombre = $fila['VmoNombre'];
				$this->VveNombre = $fila['VveNombre'];
				
				
				if($oCompleto){
				
					$InsVehiculoInstalarDetalle = new ClsVehiculoInstalarDetalle();
						//MtdObtenerVehiculoInstalarDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VsdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoInstalar=NULL,$oProducto=NULL)
					$ResVehiculoInstalarDetalle =  $InsVehiculoInstalarDetalle->MtdObtenerVehiculoInstalarDetalles(NULL,NULL,"VsdId","ASC",NULL,$this->VisId,NULL);
					$this->VehiculoInstalarDetalle = 	$ResVehiculoInstalarDetalle['Datos'];	
		
					
				}      
			
				switch($this->VisEstado){
					case 1:
						$this->VisEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->VisEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->VisEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($this->VisEstado){
					case 1:
						$this->VisEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->VisEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->VisEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoInstalars($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VisId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oSucursal=NULL) {



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
			
				
		if(!empty($oEstado)){
			$estado = ' AND vis.VisEstado = '.$oEstado;
		}	
				
		if(!empty($oPersonal)){
			$personal = ' AND vis.PerId = "'.$oPersonal.'"';
		}	
					
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vis.VisFecha)>="'.$oFechaInicio.'" AND DATE(vis.VisFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vis.VisFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vis.VisFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vis.EinId = "'.$oVehiculoIngresoId.'"';
		}
	
		if(!empty($oSucursal)){
			$sucursal = ' AND vis.SucId = "'.$oSucursal.'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		vis.VisId,
	
		vis.EinId,
		vis.PerId,
		vis.CliId,	

		DATE_FORMAT(vis.VisFecha, "%d/%m/%Y") AS "NVisFecha",
		
		vis.VisObservacionInterna,
		vis.VisObservacionImpresa,
		
		vis.VisReferencia,
	
		vis.VisEstado,	
		DATE_FORMAT(vis.VisTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVisTiempoCreacion",
        DATE_FORMAT(vis.VisTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVisTiempoModificacion",
		
		ein.EinVIN,
		ein.EinPlaca,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tblvisvehiculoinstalar vis
			
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vis.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vis.PerId = per.PerId
						
								
				WHERE 1 = 1 '.$filtrar.$estado.$cliente.$vingreso.$hora.$sfichaingreso .$pmecanico.$personal.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoInstalar = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoInstalar = new $InsVehiculoInstalar();				
					
                    $VehiculoInstalar->VisId = $fila['VisId'];
					$VehiculoInstalar->EinId = $fila['EinId'];
					$VehiculoInstalar->PerId = $fila['PerId'];
					$VehiculoInstalar->CliId = $fila['CliId'];
					
					$VehiculoInstalar->VisFecha = $fila['NVisFecha'];
				
					$VehiculoInstalar->VisObservacionInterna = $fila['VisObservacionInterna'];
					$VehiculoInstalar->VisObservacionImpresa = $fila['VisObservacionImpresa'];
					
					$VehiculoInstalar->VisReferencia = $fila['VisReferencia'];
				
					$VehiculoInstalar->VisEstado = $fila['VisEstado'];					
                    $VehiculoInstalar->VisTiempoCreacion = $fila['NVisTiempoCreacion'];
                    $VehiculoInstalar->VisTiempoModificacion = $fila['NVisTiempoModificacion'];    

					$VehiculoInstalar->EinVIN = $fila['EinVIN'];    
					$VehiculoInstalar->EinPlaca  = $fila['EinPlaca'];    
					
					$VehiculoInstalar->VmaNombre = $fila['VmaNombre'];    
					$VehiculoInstalar->VmoNombre = $fila['VmoNombre'];    
					$VehiculoInstalar->VveNombre = $fila['VveNombre'];  
					
					
					$VehiculoInstalar->PerApellidoPaterno = $fila['PerApellidoPaterno'];    
					$VehiculoInstalar->PerApellidoMaterno = $fila['PerApellidoMaterno'];    
					$VehiculoInstalar->PerNombre = $fila['PerNombre'];   
					
					
					 
				switch($VehiculoInstalar->VisEstado){
					case 1:
						$VehiculoInstalar->VisEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$VehiculoInstalar->VisEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$VehiculoInstalar->VisEstadoDescripcion = "Anulado";
				
					break;
					
				}
				
				
				switch($VehiculoInstalar->VisEstado){
					case 1:
						$VehiculoInstalar->VisEstadoIcono = '<img src="imagenes/estado/pendiente.png" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$VehiculoInstalar->VisEstadoIcono = '<img src="imagenes/estado/realizado.png" alt="[Realizado]" title="Realizado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$VehiculoInstalar->VisEstadoIcono = '<img src="imagenes/estado/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
					break;
					
				}
				
                    $VehiculoInstalar->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoInstalar;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	public function MtdObtenerVehiculoInstalarsValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VisId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL) {

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
			
				
		if(!empty($oEstado)){
			$estado = ' AND vis.VisEstado = '.$oEstado;
		}	

		
		if(!empty($oPersonal)){
			$personal = ' AND vis.PerId = "'.$oPersonal.'"';
		}	
		
		
			
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vis.VisFecha)>="'.$oFechaInicio.'" AND DATE(vis.VisFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vis.VisFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vis.VisFecha)<="'.$oFechaFin.'"';		
			}			
		}

	
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND vis.EinId = "'.$oVehiculoIngresoId.'"';
		}	
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vis.SucId) = "'.$oSucursal.'"';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vis.VisFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vis.VisFecha) ="'.($oAno).'"';
		}
		
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		'.$funcion.' AS "RESULTADO"
		
        FROM tblvisvehiculoinstalar vis
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON vis.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per
								ON vis.PerId = per.PerId
								
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$estado.$sucursal.$vmarca.$hora.$cliente.$vingreso.$sfichaingreso .$personal.$fecha.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoInstalar($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VisId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VisId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblvisvehiculoinstalar WHERE '.$eliminar;
			
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
	
	
	
	public function MtdActualizarEstadoVehiculoInstalar($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
				
					$sql = 'UPDATE tblvisvehiculoinstalar SET VisEstado = '.$oEstado.' WHERE   (VisId = "'.($elemento).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
//						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la VehiculoInstalar",$aux);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}

	public function MtdRegistrarVehiculoInstalar() {
	

		global $Resultado;
		$error = false;
		//
//		$this->MtdVerificarExisteVehiculoInstalar();
		
		//if(!empty($this->PrvId)){
//			$error = true;
//			$Resultado.='#ERR_VIS_201';
//		}
			
			
			$this->MtdGenerarVehiculoInstalarId();
				
			$sql = 'INSERT INTO tblvisvehiculoinstalar (
			VisId,
			SucId,
			
			EinId,
			PerId,
			CliId,
			
			VisFecha,
		
			VisObservacionInterna,
			VisObservacionImpresa,
			
			VisReferencia,
			
			VisEstado,
			VisTiempoCreacion,
			VisTiempoModificacion
			) 
			VALUES (
			"'.($this->VisId).'",
			"'.($this->SucId).'",
	
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
		
			"'.($this->VisFecha).'",
		
			"'.($this->VisObservacionInterna).'",
			"'.($this->VisObservacionImpresa).'",
			
			"'.($this->VisReferencia).'",
			
			'.($this->VisEstado).', 
			"'.($this->VisTiempoCreacion).'", 
			"'.($this->VisTiempoModificacion).'");';					

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,true);

				if(!$resultado) {						
					$error = true;
				} 	

			}
			
			
			if(!$error){			
			
				if (!empty($this->VehiculoInstalarDetalle)){		
						
					$validar = 0;				

					foreach ($this->VehiculoInstalarDetalle as $DatVehiculoInstalarDetalle){
						
						$InsVehiculoInstalarDetalle = new ClsVehiculoInstalarDetalle();
						$InsVehiculoInstalarDetalle->VisId = $this->VisId;
						
						$InsVehiculoInstalarDetalle->ProId = $DatVehiculoInstalarDetalle->ProId;
						
						$InsVehiculoInstalarDetalle->ProId = $DatVehiculoInstalarDetalle->ProId;
						$InsVehiculoInstalarDetalle->UmeId = $DatVehiculoInstalarDetalle->UmeId;							
						$InsVehiculoInstalarDetalle->VsdObservacion = $DatVehiculoInstalarDetalle->VsdObservacion;	
						$InsVehiculoInstalarDetalle->VsdCantidad = $DatVehiculoInstalarDetalle->VsdCantidad;
					
						$InsVehiculoInstalarDetalle->VsdEstado = $DatVehiculoInstalarDetalle->VsdEstado;
						$InsVehiculoInstalarDetalle->VsdTiempoCreacion = $DatVehiculoInstalarDetalle->VsdTiempoCreacion;
						$InsVehiculoInstalarDetalle->VsdTiempoModificacion = $DatVehiculoInstalarDetalle->VsdTiempoModificacion;						
						$InsVehiculoInstalarDetalle->VsdEliminado = $DatVehiculoInstalarDetalle->VsdEliminado;

						if($InsVehiculoInstalarDetalle->MtdRegistrarVehiculoInstalarDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VIS_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoInstalarDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarVehiculoInstalar() {
		
//		if($this->Transaccion){
//			$this->InsMysql->MtdTransaccionIniciar();
//		}
	
			$sql = 'UPDATE tblvisvehiculoinstalar SET 
		
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			
			VisFecha = "'.($this->VisFecha).'",
	
			VisObservacionInterna = "'.($this->VisObservacionInterna).'",
			VisObservacionImpresa = "'.($this->VisObservacionImpresa).'",
			
			VisReferencia = "'.($this->VisReferencia).'",
		
			VisEstado = '.($this->VisEstado).',
			VisTiempoModificacion = "'.($this->VisTiempoModificacion).'"
			WHERE VisId = "'.($this->VisId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 
			
			
				if(!$error){

				if (!empty($this->VehiculoInstalarDetalle)){		
						
					$validar = 0;
					foreach ($this->VehiculoInstalarDetalle as $DatVehiculoInstalarDetalle){
	
						$InsVehiculoInstalarDetalle = new ClsVehiculoInstalarDetalle();
						$InsVehiculoInstalarDetalle->VsdId = $DatVehiculoInstalarDetalle->VsdId;
						$InsVehiculoInstalarDetalle->VisId = $this->VisId;
						
						$InsVehiculoInstalarDetalle->ProId = $DatVehiculoInstalarDetalle->ProId;
						$InsVehiculoInstalarDetalle->UmeId = $DatVehiculoInstalarDetalle->UmeId;							
						$InsVehiculoInstalarDetalle->VsdObservacion = $DatVehiculoInstalarDetalle->VsdObservacion;	
						$InsVehiculoInstalarDetalle->VsdCantidad = $DatVehiculoInstalarDetalle->VsdCantidad;
					
						$InsVehiculoInstalarDetalle->VsdEstado = $DatVehiculoInstalarDetalle->VsdEstado;
						$InsVehiculoInstalarDetalle->VsdTiempoCreacion = $DatVehiculoInstalarDetalle->VsdTiempoCreacion;
						$InsVehiculoInstalarDetalle->VsdTiempoModificacion = $DatVehiculoInstalarDetalle->VsdTiempoModificacion;
						$InsVehiculoInstalarDetalle->VsdEliminado = $DatVehiculoInstalarDetalle->VsdEliminado;

						if(empty($InsVehiculoInstalarDetalle->VsdId)){
							if($InsVehiculoInstalarDetalle->VsdEliminado<>2){
								if($InsVehiculoInstalarDetalle->MtdRegistrarVehiculoInstalarDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VIS_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
			 				}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoInstalarDetalle->VsdEliminado==2){
								if($InsVehiculoInstalarDetalle->MtdEliminarVehiculoInstalarDetalle($InsVehiculoInstalarDetalle->VsdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VIS_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoInstalarDetalle->MtdEditarVehiculoInstalarDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VIS_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoInstalarDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
					
			
			if($error) {
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();
//				}
				return false;
			} else {				
//				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();
//				}
				return true;
			}					
		}	
		
				
		
				
	
}
?>