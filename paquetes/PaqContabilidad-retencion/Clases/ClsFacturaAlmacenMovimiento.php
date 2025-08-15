<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaAlmacenMovimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaAlmacenMovimiento {

    public $FamId;
	public $FacId;
	public $FtaId;

	public $AmoId;

    public $FamEliminado;
	
	public $FtaNumero;
	
	public $FpaId;

	public $AmoFecha;
	public $AmoTotal;

	public $FacTotal;
	public $FacTotalReal;
	
	public $FacAmortizado;
	public $FacSaldo;

	public $FccId;
	public $FinId;
			
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

	private function MtdGenerarFacturaAlmacenMovimientoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FamId,5),unsigned)) AS "MAXIMO"
			FROM tblfamfacturaalmacenmovimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FamId = "FAM-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FamId = "FAM-".$fila['MAXIMO'];					
			}	

	}
		
    public function MtdObtenerFacturaAlmacenMovimiento(){

        $sql = 'SELECT 
        FamId,
		FacId,
		FtaId,
		AmoId
        FROM tblfamfacturaalmacenmovimiento
        WHERE FamId = "'.$this->FamId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->FamId = $fila['FamId'];
			$this->FacId = $fila['FacId'];
			$this->FtaId = $fila['FtaId'];
			$this->AmoId = $fila['AmoId'];  
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerFacturaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oFacturaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL){

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

		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			$factura = ' AND fam.FacId = "'.$oFactura.'" AND fam.FtaId = "'.$oFacturaTalonario.'" ';
		}
				
		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND fam.AmoId = "'.$oAlmacenMovimiento.'"  ';
		}
		
		if(!empty($oTipo)){
			switch($oTipo){
				case 1://Amota
					$tipo = ' AND fam.AmoId IS NOT NULL ';
					
					if($oAnulado){
						$anulado = ' AND amo.AmoEstado <> 1';
					}
				break;

				
				case 3:
					$tipo = ' AND fam.FacId IS NOT NULL AND fam.FtaId IS NOT NULL';

					if($oAnulado){
						$anulado = ' AND fac.FacEstado <> 6';
					}
				break;
			}
		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fam.FamId,
				
				fam.FacId,
				fam.FtaId,
				fta.FtaNumero,
				fac.FacTotal,
				fac.FacTotalReal,
				fam.AmoId,	
				fam.VmvId,
							
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				amo.FccId,
				fim.FinId,
				
				DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
				vmv.VmvTipo,
				vmv.VmvSubTipo
				
				FROM tblfamfacturaalmacenmovimiento fam	
					LEFT JOIN tblfacfactura fac
					ON (fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId)
						LEFT JOIN tblftafacturatalonario fta
						ON fam.FtaId = fta.FtaId
							LEFT JOIN tblregregimen reg
							ON fac.RegId = reg.RegId
								LEFT JOIN tblamoalmacenmovimiento amo
								ON (fam.AmoId = amo.AmoId)
									
									LEFT JOIN tblvmvvehiculomovimiento vmv
									ON fam.VmvId = vmv.VmvId
									
									LEFT JOIN tblfccfichaaccion fcc
									ON amo.FccId = fcc.FccId
										LEFT JOIN tblfimfichaingresomodalidad fim
										ON fcc.FimId = fim.FimId

				WHERE 1 = 1 '.$filtrar.$factura.$amovimiento.$nentrega.$anulado.$tipo.$orden.$paginacion;
				

				
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaAlmacenMovimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$FacturaAlmacenMovimiento = new $InsFacturaAlmacenMovimiento();
				
					$FacturaAlmacenMovimiento->FamId = $fila['FamId'];
					$FacturaAlmacenMovimiento->FacId = $fila['FacId'];
					$FacturaAlmacenMovimiento->FtaId = $fila['FtaId'];
					$FacturaAlmacenMovimiento->FtaNumero = $fila['FtaNumero'];
					$FacturaAlmacenMovimiento->FacTotal = $fila['FacTotal'];
					$FacturaAlmacenMovimiento->FacTotalReal = $fila['FacTotalReal'];
					$FacturaAlmacenMovimiento->AmoId = $fila['AmoId'];
					$FacturaAlmacenMovimiento->VmvId = $fila['VmvId'];
					
					$FacturaAlmacenMovimiento->AmoFecha = $fila['NAmoFecha'];
					$FacturaAlmacenMovimiento->AmoTipo = $fila['AmoTipo'];
					$FacturaAlmacenMovimiento->AmoSubTipo = $fila['AmoSubTipo'];
		
		
					$FacturaAlmacenMovimiento->FccId = $fila['FccId'];
					$FacturaAlmacenMovimiento->FinId = $fila['FinId'];

					$FacturaAlmacenMovimiento->VmvFecha = $fila['NVmvFecha'];
					$FacturaAlmacenMovimiento->VmvTipo = $fila['VmvTipo'];
					$FacturaAlmacenMovimiento->VmvSubTipo = $fila['VmvSubTipo'];
					
                    $FacturaAlmacenMovimiento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaAlmacenMovimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	//Accion eliminar	 

	public function MtdEliminarFacturaAlmacenMovimiento($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		$i=1;
		foreach($elementos as $elemento){
			if(!empty($elemento)){
			
				if($i==count($elementos)){						
					$eliminar .= '  (FamId = "'.($elemento).'")';	
				}else{
					$eliminar .= '  (FamId = "'.($elemento).'")  OR';	
				}	
			}
		$i++;

		}


			$sql = 'DELETE FROM  tblfamfacturaalmacenmovimiento WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarFacturaAlmacenMovimiento() {
	
			$this->MtdGenerarFacturaAlmacenMovimientoId();
		
			$sql = 'INSERT INTO tblfamfacturaalmacenmovimiento (
			FamId,
			
			AmoId,
			VmvId,
			
			FtaId,
			FacId
			)
			VALUES (
			"'.($this->FamId).'", 
			'.(empty($this->AmoId)?'NULL, ':'"'.$this->AmoId.'",').'
			'.(empty($this->VmvId)?'NULL, ':'"'.$this->VmvId.'",').'
			
			"'.($this->FtaId).'", 	
			"'.($this->FacId).'");';

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
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
