<?php
include_once "BaseDatos.php";
class Viaje{
    /**CREATE TABLE viaje (
    idviaje int AUTO_INCREMENT, codigo de viaje
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa int,
    rnumeroempleado int,
    vimporte int,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsablev (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1; */

    private $idviaje;
	private $vdestino;
	private $vcantmaxpasajeros;
	private $idempresa;
	private $rnumeroempleado;
	private $vimporte;
    private $mensajeoperacion;
	
	// private $colObjPasajeros;
	// implementar opciones de agregar pasajeros y responsables

	public function __construct() {
	    $this->idviaje=0;
		$this->vdestino = "";
		$this->vcantmaxpasajeros = 0;
		$this->idempresa = 0;
		$this->rnumeroempleado = 0;
		$this->vimporte = 0;
		$this->mensajeoperacion = "";
	}

	public function cargar($idviaje,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte){
	$this->idviaje = $idviaje;
	$this->vdestino = $vdestino;
	$this->vcantmaxpasajeros = $vcantmaxpasajeros;
	$this->idempresa = $idempresa;
	$this->rnumeroempleado = $rnumeroempleado;
	$this->vimporte = $vimporte;
	
    }
	
	public function setIdViaje($newIdViaje){
		$this->idviaje=$newIdViaje;
	}
	public function setVdestino($newVdestino){
		$this->vdestino=$newVdestino;
	}
	public function setVcantmaxpasajeros($newVcantmaxpasajeros){
		$this->vcantmaxpasajeros=$newVcantmaxpasajeros;
	}
	public function setIdEmpresa($newIdEmpresa){
		$this->idempresa=$newIdEmpresa;
	}
	public function setRnumeroempleado($newRnumeroempleado){
		$this->rnumeroempleado=$newRnumeroempleado;
	}
	public function setVimporte($newVimporte){
		$this->vimporte=$newVimporte;
	}
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

	public function getIdViaje(){
		return $this->idviaje;
	}
	public function getVdestino(){
		return $this->vdestino;
	}
	public function getVcantmaxpasajeros(){
		return $this->vcantmaxpasajeros;
	}
	public function getIdEmpresa(){
		return $this->idempresa;
	}
	public function getRnumeroempleado(){
		return $this->rnumeroempleado;
	}
	public function getVimporte(){
		return $this->vimporte;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	

		

	/**
	 * Recupera los datos de una viaje por id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){
				    $this->setIdViaje($idviaje);
					$this->setVdestino($row2['vdestino']);
					$this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
					$this->setIdEmpresa($row2['idempresa']);
					$this->setRnumeroempleado($row2['rnumeroempleado']);
					$this->setVimporte($row2['vimporte']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultasViajes="Select * from viaje ";
		if ($condicion!=""){
		    $consultasViajes=$consultasViajes.' where '.$condicion;
		}
		$consultasViajes.=" order by idviaje ";
		//echo $consultasViajes;
		if($base->Iniciar()){
			if($base->Ejecutar($consultasViajes)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
					$id=$row2['idviaje'];
					$vdestino=$row2['vdestino'];
					$vcantmaxpasajeros=$row2['vcantmaxpasajeros'];
					$idempresa=$row2['idempresa'];
					$rnumeroempleado=$row2['rnumeroempleado'];
					$vimporte=$row2['vimporte'];
					$viaje=new Viaje();
					$viaje->cargar($id,$vdestino,$vcantmaxpasajeros,$idempresa,$rnumeroempleado,$vimporte);
					array_push($arregloViaje,$viaje);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$destino = $this->getVdestino();
		$cantMaxPasajeros = $this->getVcantmaxpasajeros();
		$idEmpresa = $this->getIdEmpresa();
		$numeroEmpleado = $this->getRnumeroempleado();
		$importe = $this->getVimporte();

		$consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
		VALUES ('$destino', $cantMaxPasajeros, $idEmpresa, $numeroEmpleado, $importe)";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdViaje($id);
			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$destino = $this->getVdestino();
		$cantMaxPasajeros = $this->getVcantmaxpasajeros();
		$idEmpresa = $this->getIdEmpresa();
		$numeroEmpleado = $this->getRnumeroempleado();
		$importe = $this->getVimporte();
		$idViaje = $this->getIdViaje();
		$consultaModifica = "UPDATE viaje SET vdestino='$destino', vcantmaxpasajeros=$cantMaxPasajeros, idempresa=$idEmpresa, rnumeroempleado=$numeroEmpleado, vimporte=$importe WHERE idviaje=$idViaje";

		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp = true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getIdViaje();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	public function __toString(){
	    return "\nID Viaje: ".$this->getIdViaje()."\nDestino: ".$this->getVdestino()."\nCant. Max. Pasajeros: ".$this->getVcantmaxpasajeros().
	    	"\nID Empresa: ".$this->getIdEmpresa()."\nID Empleado: ".$this->getRnumeroempleado()."\nImporte: ".$this->getVimporte()."\n";
			
	}
}

