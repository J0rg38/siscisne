<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsBoletaAlmacenMovimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsBoletaAlmacenMovimiento
{

	public $BamId;
	public $BolId;
	public $BtaId;

	public $AmoId;
	public $VmvId;

	public $BamEliminado;

	public $BtaNumero;

	public $AmoFecha;
	public $AmoTotal;

	public $BolTotal;
	public $BolTotalReal;
	public $BolAmortizado;
	public $BolSaldo;


	public $InsMysql;

	public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}

	public function __destruct() {}

	private function MtdGenerarBoletaAlmacenMovimientoId()
	{

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(BamId,5),unsigned)) AS "MAXIMO"
			FROM tblbamboletaalmacenmovimiento';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->BamId = "BAM-10000";
		} else {
			$fila['MAXIMO']++;
			$this->BamId = "BAM-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerBoletaAlmacenMovimiento()
	{

		$sql = 'SELECT 
        BamId,
		BolId,
		BtaId,
		AmoId,
		VmvId
		
        FROM tblbamboletaalmacenmovimiento
        WHERE BamId = "' . $this->BamId . '";';


		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->BamId = $fila['BamId'];
				$this->BolId = $fila['BolId'];
				$this->BtaId = $fila['BtaId'];
				$this->AmoId = $fila['AmoId'];
				$this->VmvId = $fila['VmvId'];
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerBoletaAlmacenMovimientos($oCampo = NULL, $oFiltro = NULL, $oOrden = 'BamId', $oSentido = 'Desc', $oPaginacion = '0,10', $oBoleta = NULL, $oBoletaTalonario = NULL, $oAlmacenMovimiento = NULL, $oAnulado = true, $oTipo = NULL, $oVehiculoMovimiento = NULL)
	{

		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$boleta = '';
		$amovimiento = '';
		$tipo = '';
		$anulado = '';
		$vmovimiento = '';

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace(" ", "%", $oFiltro);
			$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oBoleta) and !empty($oBoletaTalonario)) {
			$boleta = ' AND  bam.BolId = "' . $oBoleta . '" AND bam.BtaId = "' . $oBoletaTalonario . '" ';
		}

		if (!empty($oAlmacenMovimiento)) {
			$amovimiento = ' AND bam.AmoId = "' . $oAlmacenMovimiento . '" ';
		}

		if (!empty($oTipo)) {
			switch ($oTipo) {
				case 1:
					$tipo = ' AND bam.AmoId IS NOT NULL';

					if ($oAnulado) {
						$anulado = ' AND amo.AmoEstado <> 1';
					}
					break;

				case 3:
					$tipo = ' AND bam.BolId IS NOT NULL AND bam.BtaId IS NOT NULL';

					if ($oAnulado) {
						$anulado = ' AND bol.BolEstado <> 6';
					}

					break;
			}
		}


		if (!empty($oVehiculoMovimiento)) {
			$vmovimiento = ' AND bam.VmvId = "' . $oVehiculoMovimiento . '" ';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bam.BamId,
				
				bam.BolId,
				bam.BtaId,
				bta.BtaNumero,
				bol.BolTotal,

IF(reg.RegAplicacion=2,bol.BolTotal+IFNULL(bol.BolRegimenMonto,0),bol.BolTotal-IFNULL(bol.BolRegimenMonto,0)) AS "BolTotalReal",
				
				bam.AmoId,
				bam.VmvId,
				
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				amo.FccId,
				fim.FinId,
				
				DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
				vmv.VmvTipo,
				vmv.VmvSubTipo
				
				FROM tblbamboletaalmacenmovimiento bam	
				
					LEFT JOIN tblbolboleta bol					
					ON (bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId)
					
						LEFT JOIN tblbtaboletatalonario bta						
						ON bam.BtaId = bta.BtaId

							LEFT JOIN tblregregimen reg
							ON bol.RegId = reg.RegId
							
								LEFT JOIN tblamoalmacenmovimiento amo
								ON (bam.AmoId = amo.AmoId)
									
									LEFT JOIN tblvmvvehiculomovimiento vmv
									ON bam.VmvId = vmv.VmvId
									
										LEFT JOIN tblfccfichaaccion fcc
										ON amo.FccId = fcc.FccId
											
											LEFT JOIN tblfimfichaingresomodalidad fim
											ON fcc.FimId = fim.FimId

				WHERE 1 = 1 ' . $filtrar . $boleta . $amovimiento . $anulado . $tipo . $orden . $paginacion;


		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsBoletaAlmacenMovimiento = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$BoletaAlmacenMovimiento = new $InsBoletaAlmacenMovimiento();


			$BoletaAlmacenMovimiento->BamId = $fila['BamId'];
			$BoletaAlmacenMovimiento->BolId = $fila['BolId'];
			$BoletaAlmacenMovimiento->BtaId = $fila['BtaId'];
			$BoletaAlmacenMovimiento->BtaNumero = $fila['BtaNumero'];
			$BoletaAlmacenMovimiento->BolTotal = $fila['BolTotal'];
			$BoletaAlmacenMovimiento->BolTotalReal = $fila['BolTotalReal'];
			$BoletaAlmacenMovimiento->AmoId = $fila['AmoId'];
			$BoletaAlmacenMovimiento->VmvId = $fila['VmvId'];


			$BoletaAlmacenMovimiento->AmoFecha = $fila['NAmoFecha'];
			$BoletaAlmacenMovimiento->AmoTipo = $fila['AmoTipo'];
			$BoletaAlmacenMovimiento->AmoSubTipo = $fila['AmoSubTipo'];

			$BoletaAlmacenMovimiento->FccId = $fila['FccId'];
			$BoletaAlmacenMovimiento->FinId = $fila['FinId'];

			$BoletaAlmacenMovimiento->VmvFecha = $fila['NVmvFecha'];
			$BoletaAlmacenMovimiento->VmvTipo = $fila['VmvTipo'];
			$BoletaAlmacenMovimiento->VmvSubTipo = $fila['VmvSubTipo'];

			$BoletaAlmacenMovimiento->InsMysql = NULL;
			$Respuesta['Datos'][] = $BoletaAlmacenMovimiento;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}




	//Accion eliminar	 

	public function MtdEliminarBoletaAlmacenMovimiento($oElementos)
	{

		$elementos = explode("#", $oElementos);
		$eliminar = ''; // Initialize variable to avoid undefined variable warning

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (BamId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (BamId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}


		$sql = 'DELETE FROM  tblbamboletaalmacenmovimiento WHERE ' . $eliminar;

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}


	public function MtdRegistrarBoletaAlmacenMovimiento()
	{

		$this->MtdGenerarBoletaAlmacenMovimientoId();

		$sql = 'INSERT INTO tblbamboletaalmacenmovimiento (
			BamId,	
					
			AmoId,
			VmvId,
			
			BolId,
			BtaId
			) 
			VALUES (
			"' . ($this->BamId) . '", 
			' . (empty($this->AmoId) ? 'NULL, ' : '"' . $this->AmoId . '",') . '
			' . (empty($this->VmvId) ? 'NULL, ' : '"' . $this->VmvId . '",') . '
			
			"' . ($this->BolId) . '", 
			"' . ($this->BtaId) . '");';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}
}
