<?php
include_once "BaseDatos.php";
class Empresa{
    /**CREATE TABLE empresa(
    idempresa int AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1; */

    private $idempresa;
	private $enombre;
	private $edireccion;
    private $mensajeoperacion;


	public function __construct(){
	    $this->idempresa=0;
		$this->enombre = "";
		$this->edireccion = "";
		$this->mensajeoperacion = "";
	}

	public function cargar($idempresa,$enombre,$edireccion){	
	    $this->setIdEmpresa($idempresa);
		$this->setENombre($enombre);
		$this->setEdireccion($edireccion);
    }
	
    public function setIdEmpresa($newIdEmpresa){
        $this->idempresa=$newIdEmpresa;
    }
    public function setENombre($newENombre){
		$this->enombre=$newENombre;
	}
    public function setEdireccion($newEdireccion){
        $this->edireccion=$newEdireccion;
    }
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function getIdEmpresa(){
        return $this->idempresa;
    }
    public function getENombre(){
        return $this->enombre;
    }
    public function getEdireccion(){
        return $this->edireccion;
    }
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	
	
	/**
	 * Recupera los datos de una empresa por id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idempresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idempresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){
				    $this->setIdEmpresa($idempresa);
                    $this->setENombre($row2['enombre']);
                    $this->setEdireccion($row2['edireccion']);
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
		$consultasEmpresas="Select * from empresa ";
		if ($condicion!=""){
		    $consultasEmpresas=$consultasEmpresas.' where '.$condicion;
		}
		$consultasEmpresas.=" order by enombre ";
		//echo $consultasEmpresas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultasEmpresas)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
                    $id=$row2['idempresa'];
                    $enombre=$row2['enombre'];
                    $edireccion=$row2['edireccion'];
					$empresa=new Empresa();
					$empresa->cargar($id,$enombre,$edireccion);
					array_push($arregloEmpresa,$empresa);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloEmpresa;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
                   VALUES ('".$this->getEnombre()."','".$this->getEdireccion()."')";

		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
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
		// validar existencia de empresa
		$consultaModifica = "UPDATE empresa SET enombre='".$this->getENombre()."', edireccion='".$this->getEdireccion()."' WHERE idempresa=".$this->getIdEmpresa();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
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
			// validacion de empresa
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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
	    return "\nID Empresa: ".$this->getIdEmpresa()."\n". "Nombre: ".$this->getENombre()."\n". "Dirección: ".$this->getEdireccion()."\n";
			
	}
}

