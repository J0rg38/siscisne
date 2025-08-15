<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoPromocion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoPromocion {

    public $OvvId;
	public $EinId;
	public $EinVin;
	public $VroFechaVenta;
    public $VroDiaTranscurrido;
	public $VroVehiculoKilometraje;
	public $VroMantenimientoKilometraje;
	public $VroCantidadMantenimientos;
	
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



 public function MtdObtenerVehiculoPromocion(){

        $sql = 'SELECT 
        		vro.OvvId,
				vro.EinId,
				vro.EinVIN,
				
				DATE_FORMAT(vro.VroFechaVenta, "%d/%m/%Y") AS "NVroFechaVenta",
				
				vro.VroDiaTranscurrido,
				vro.VroVehiculoKilometraje,
				vro.VroMantenimientoKilometraje,
				vro.VroCantidadMantenimientos,
				vro.VroKilometrajeLimite,
				
					vro.ObsId,
				vro.ObsNombre
				
				
				FROM visvrovehiculopromocion vro
        WHERE vro.OvvId = "'.$this->OvvId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->OvvId = $fila['OvvId'];
			$this->EinId = $fila['EinId'];
            $this->EinVIN = $fila['EinVIN'];
            $this->VroFechaVenta = $fila['NVroFechaVenta'];
			
			$this->VroDiaTranscurrido = $fila['VroDiaTranscurrido'];
			$this->VroVehiculoKilometraje = $fila['VroVehiculoKilometraje'];
			$this->VroMantenimientoKilometraje = $fila['VroMantenimientoKilometraje'];
			$this->VroCantidadMantenimientos = $fila['VroCantidadMantenimientos'];
			$this->VroKilometrajeLimite = $fila['VroKilometrajeLimite'];
			
			$this->ObsId = $fila['ObsId'];
			$this->ObsNombre = $fila['ObsNombre'];
			
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
	
	
	
    public function MtdObtenerVehiculoPromociones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL) {

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
			
				
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND vro.EinId = "'.$oVehiculoIngreso.'" ';
		}	
		
				 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vro.OvvId,
				vro.EinId,
				vro.EinVIN,
				vro.VroFechaVenta,
				vro.VroDiaTranscurrido,
				vro.VroVehiculoKilometraje,
				vro.VroMantenimientoKilometraje,
				vro.VroCantidadMantenimientos,
				vro.VroKilometrajeLimite,
				
				vro.ObsId,
				vro.ObsNombre
				
				FROM visvrovehiculopromocion vro
					
				WHERE 1 = 1 '.$filtrar.$vingreso.$orden.$paginacion;
				
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoPromocion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoPromocion = new $InsVehiculoPromocion();				
                    $VehiculoPromocion->OvvId = $fila['OvvId'];
					$VehiculoPromocion->EinId = $fila['EinId'];
					$VehiculoPromocion->EinVIN = $fila['EinVIN'];
					$VehiculoPromocion->VroFechaVenta = $fila['VroFechaVenta'];

                    $VehiculoPromocion->VroDiaTranscurrido = $fila['VroDiaTranscurrido'];
                    $VehiculoPromocion->VroVehiculoKilometraje = $fila['VroVehiculoKilometraje'];
					$VehiculoPromocion->VroMantenimientoKilometraje = $fila['VroMantenimientoKilometraje'];
					$VehiculoPromocion->VroCantidadMantenimientos = $fila['VroCantidadMantenimientos'];
					$VehiculoPromocion->VroKilometrajeLimite = $fila['VroKilometrajeLimite'];
					
					$VehiculoPromocion->ObsId = $fila['ObsId'];
					$VehiculoPromocion->ObsNombre = $fila['ObsNombre'];

                    $VehiculoPromocion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoPromocion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
		
}
?>