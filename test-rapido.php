<?php 


include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'Persona.php';

//$baseDatos = new BaseDatos();
//$conexion = $baseDatos->Iniciar();

// verificamos si la conexion funciona

/* 
if ($conexion) {
    echo "Conexión exitosa \n";
    $consulta = "SELECT * FROM persona";
    $resultado = $baseDatos->Ejecutar($consulta);
    if ($resultado) {
        echo "Consulta exitosa \n";
        $fila = $baseDatos->Registro();
        while ($fila && is_array($fila)) {
            echo "Nombre: " . $fila['pnombre'] . " Apellido: " . $fila['papellido'] . " DNI: " . $fila['nrodoc'];
            $fila = $baseDatos->Registro();
        }        
    } else {
        echo "Error en la consulta";
    }


} else {
    echo "Error en la conexión";
}
*/


// testing Empresa (insetar, modificar y elinminar)

//$empresa = new Empresa();
//$nombre1 = "Empresa 1";
//$direccion1 = "Direccion 1";

//$empresa->cargar(0, $nombre1, $direccion1); // cargamos los datos de la empresa
//$empresa->insertar(); // insertamos la empresa en la bd 
//$idRandom = 5;
/*$datos = $empresa->Buscar($idRandom); // buscamos la empresa con id 1

if ($datos){
    // Mostrar la fila recuperada
    echo "Empresa encontrada:\n";
    echo "ID: " . $empresa->getIdEmpresa() . "\n";
    echo "Nombre: " . $empresa->getENombre() . "\n";
    echo "Dirección: " . $empresa->getEdireccion() . "\n";
} else {
    echo "La empresa con ID $idRandom no fue encontrada.\n";
}
*/

// Modificar empresa
//$idEmpresaExistente = 6;
//$datosEmpresa = $empresa->Buscar($idEmpresaExistente);

/*
// Verificar si la empresa fue encontrada
if ($datosEmpresa) {
    // Mostrar los datos de la empresa antes de la modificación
    echo "Datos de la empresa antes de la modificación:\n";
    echo $empresa;

    // Modificar los datos de la empresa
    $nuevoNombre = "Nuevo Nombre";
    $nuevaDireccion = "Nueva Dirección";
    $empresa->setENombre($nuevoNombre);
    $empresa->setEdireccion($nuevaDireccion);
    $modificacionExitosa = $empresa->modificar();

    // Verificar si la modificación fue exitosa
    if ($modificacionExitosa) {
        echo "La empresa fue modificada exitosamente.\n";

        // Mostrar los datos de la empresa después de la modificación
        echo "Datos de la empresa después de la modificación:\n";
        echo $empresa;
    } else {
        echo "Error al modificar la empresa.\n";
    }
} else {
    echo "La empresa con ID $idEmpresaExistente no fue encontrada.\n";
}

*/
// eliminar empresa
/*
if ($datosEmpresa) { // verificamos que exista
    echo "Datos de la empresa a eliminar: \n";
    echo $empresa;

    // eliminar la empresa
    $eliminar = $empresa->eliminar();
    if ($eliminar) {
        echo "La empresa fue eliminada exitosamente.\n";
    } else {
        echo "Error al eliminar la empresa.\n";
    }
}
*/

// Testing rapido de VIAJE

$viaje1 = new Viaje();

// Para crear un nuevo viaje debemos contar con un ID empresa
// y un empleado creado previamente -> tambien una persona

 
// listar -> todos los viajes pero con condicion?
// Buscar -> por id
// insertar -> insertar un viaje
// modificar -> modificar un viaje
// eliminar -> eliminar un viaje

/* 
$viajes = $viaje1->listar();

if ($viajes) {
    echo "Viajes encontrados: \n";
    foreach ($viajes as $viaje) {
        echo $viaje;
    }
} else {
    echo "No se encontraron viajes.\n";
}
*/

// Buscar viaje por id
/*
$idViaje = 1;
$datosViaje = $viaje1->Buscar($idViaje);
if ($datosViaje) {
    echo "Viaje encontrado: \n";
    echo $viaje1;
} else {
    echo "No se encontró el viaje con ID $idViaje.\n";
}
*/

// Insertar un nuevo viaje
/*
$destino = "Japon";
$cantMaxPasajeros = 100;
$idEmpresa = 1; // verificar esto 
$numeroEmpleado = 144; // verificar esto
$importe = 230.000; // ingresa 230 dado que es un float / corregir
$mensajeOperacion = "Operación exitosa"; // no lo carga por parametro

$viaje1->cargar(0, $destino, $cantMaxPasajeros, $idEmpresa, $numeroEmpleado, $importe);
$viaje1->insertar();

echo $viaje1;
*/

// Modificar un viaje
/*
$destinoNuevo = "Nueva York";
$cantMaxPasajerosNuevo = 200;
$idViaje = 1;
// es necesario buscar el viaje previamente. Caso contrario no funciona 
$viajeEncontrado = $viaje1->Buscar($idViaje);

if ($viajeEncontrado) {
    echo "Viaje encontrado: \n";
    $viaje1->setVdestino($destinoNuevo);
    $viaje1->setVcantmaxpasajeros($cantMaxPasajerosNuevo);
    $modificacionExitosa = $viaje1->modificar();

if ($modificacionExitosa) {
    echo "El viaje fue modificado exitosamente.\n";
    echo $viaje1;
} else {
    echo "Error al modificar el viaje.\n";
    echo $viaje1->getMensajeOperacion();
}



} else {
    echo "No se encontró el viaje con ID $idViaje.\n";
}
*/

// Eliminar un viaje
/*
$idViaje = 1;
$viajeEncontrado = $viaje1->Buscar($idViaje);
if ($viajeEncontrado) {
    echo "Viaje encontrado: \n";
    echo $viaje1;

    $eliminacionExitosa = $viaje1->eliminar();
    if ($eliminacionExitosa) {
        echo "El viaje fue eliminado exitosamente.\n";
    } else {
        echo "Error al eliminar el viaje.\n";
        echo $viaje1->getMensajeOperacion();
    }
} else {
    echo "No se encontró el viaje con ID $idViaje.\n";
}
*/

// test rapido modificar persona

$persona = new Persona();
$dni = 2234243;

$existe = $persona->Buscar($dni);

if ($existe) {
    echo "Persona encontrada: \n";
    echo $persona;
    $nuevoDNI = 45884348;
    $persona->setNrodoc($nuevoDNI);
    $modificacionExitosa = $persona->modificar();
    if ($modificacionExitosa) {
        echo "La persona fue modificada exitosamente.\n";
        echo $persona;
    } else {
        echo "Error al modificar la persona.\n";
        echo $persona->getMensajeOperacion();
    }

} else {
    echo "No se encontró la persona con DNI $dni.\n";
} 


