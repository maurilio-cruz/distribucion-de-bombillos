<?php

/* 
 *  author: Maurilio Cruz
 *          maurilio.cruz@outlook.com
 *  date:   2022-02-15
 */


/*
 * Constantes utilitas
 */

define( 'CERO',                    0 );
define( 'UNO',                     1 );
define( 'ROW',                     0 );
define( 'COLUMN',                  1 );
define( 'ESPACIO_NO_ILUMINADO',    0 );
define( 'PARED',                   1 );
define( 'BOMBILLA',                2 );
define( 'ESPACIO_ILUMINADO',       3 );

/*
 * getRoomData - Función utilitaria que recupera la estructura de una habitacion. ya sean desde archivo o directamente desde código.
 * 
 * @param boolean $loadFromFile Sí loadFromFile es true se carga la información desde el archivo 'input.txt'
 * 
 * @return array Devueleve una matriz de datos que contiene valores 0 y 1.
 */

function getRoomData( $loadFromFile = true ){

    if( $loadFromFile === false ){

        return [
            [0,1,0,0,0],
            [0,0,0,1,0],
            [0,0,0,0,0],
            [0,0,0,0,1]
        ];

    }

    $inputData  = explode("\n", file_get_contents('input.txt'));
    $roomData   = array();

    foreach( $inputData AS $singleLine ){
        if( str_split( $singleLine )[CERO] !== '' ){
            $roomData[] = str_split( $singleLine );
        }
    }

    return $roomData;

}

/**
 * Funcion utilitaria que evalua que toda la habitación se encuentre completamente iluminada.
 * 
 * Esta función itera sobre cada casilla disponible, y en caso de haber algun sitio sin ilumnar
 * devolverá valor false; en caso contrario (que toda la habitacién este iluminada ) devolverá true.
 * 
 * @param array $roomData Matriz con descripción de la habitación.
 * 
 * @param int $numbersOfRows Número de filas en la matriz $roomData.
 * 
 * @param int $numberOfColumns Número de columnas en la matriz $roomData.
 * 
 * @return boolean
 */

function evaluateIsFullRoomIlluminated( $roomData, $numbersOfRows, $numberOfColumns ){

    foreach( $roomData AS $rowData ){
        foreach( $rowData AS $cellData ){
            if( $cellData == ESPACIO_NO_ILUMINADO ){
                return false;
            }
        }
    }

    return true;

}

/**
 * Funcion utilitaria propaga la luz que emite una bombilla en la habitación
 * 
 *
 * 
 * @param array $roomData Matriz con descripción de la habitación.
 * 
 * @param array $positionBombilla
 * 
 * @param int $numbersOfRows Número de filas en la matriz $roomData.
 * 
 * @param int $numberOfColumns Número de columnas en la matriz $roomData.
 * 
 * @return array
 */

function propagateLightingRoom( $roomData, $positionBombilla, $numbersOfRows, $numberOfColumns ){

    // Propagacion hacia arriba/norte
    for( $indexRow = $positionBombilla[ROW]; $indexRow >= CERO; $indexRow--){
        if( $roomData[$indexRow][$positionBombilla[COLUMN]] == PARED ){
            break;
        }
        if( $roomData[$indexRow][$positionBombilla[COLUMN]] == ESPACIO_NO_ILUMINADO ){ 
            $roomData[$indexRow][$positionBombilla[COLUMN]] = ESPACIO_ILUMINADO;
        }
    }

    // Propagacion hacia abajo/sur
    for( $indexRow = $positionBombilla[ROW]; $indexRow < $numbersOfRows; $indexRow ++ ){
        if( $roomData[$indexRow][$positionBombilla[COLUMN]] == PARED ){
            break;
        }
        if( $roomData[$indexRow][$positionBombilla[COLUMN]] == ESPACIO_NO_ILUMINADO ){ 
            $roomData[$indexRow][$positionBombilla[COLUMN]] = ESPACIO_ILUMINADO;
        }
    }

    //Propagacion hacia izquierda/oeste
    for( $indexColumn = $positionBombilla[COLUMN]; $indexColumn >= CERO; $indexColumn-- ){
        if( $roomData[$positionBombilla[ROW]][$indexColumn] == PARED){
            break;
        }
        if( $roomData[$positionBombilla[ROW]][$indexColumn] == ESPACIO_NO_ILUMINADO ){
            $roomData[$positionBombilla[ROW]][$indexColumn] = ESPACIO_ILUMINADO;
        }
    }

    //Propagacion hacia izquierda/oeste
    for( $indexColumn = $positionBombilla[COLUMN]; $indexColumn < $numberOfColumns; $indexColumn++ ){
        if( $roomData[$positionBombilla[ROW]][$indexColumn] == PARED){
            break;
        }
        if( $roomData[$positionBombilla[ROW]][$indexColumn] == ESPACIO_NO_ILUMINADO ){
            $roomData[$positionBombilla[ROW]][$indexColumn] = ESPACIO_ILUMINADO;
        }
    }

    return $roomData;
}

/**
 * Funcion utilitaria devuelve una lista con todas las pocisiones disponibles para colocar una bombilla.
 * 
 *
 * 
 * @param array $roomData Matriz con descripción de la habitación.
 *  
 * @param int $numbersOfRows Número de filas en la matriz $roomData.
 * 
 * @param int $numberOfColumns Número de columnas en la matriz $roomData.
 * 
 * @return array
 */

function obtenerEspaciosDisponibles( $roomData, $numbersOfRows, $numberOfColumns ){

    $listaEspaciosDisponibles       = array();
    $numeroDeEspaciosDisponibles    = 0;

    for( $indexRow = 0; $indexRow < $numbersOfRows; $indexRow++ ){
        for( $indexColumn = 0; $indexColumn < $numberOfColumns; $indexColumn++ ){
            if( $roomData[$indexRow][$indexColumn] == ESPACIO_NO_ILUMINADO ){
                $listaEspaciosDisponibles[] = array( $indexRow, $indexColumn );
                $numeroDeEspaciosDisponibles ++;
            }
        }

    }

    return array( $listaEspaciosDisponibles, $numeroDeEspaciosDisponibles );

}

    
/*
 * drawRoom Función que dibuja en console un habitación en el estado actual. Imprime las casilas correspondientes a
 *          ESPACIO_NO_ILUMINADO    con valor de 0
 *          PARED                   con valor de 1
 *          BOMBILLA                con valor de 2
 *          ESPACIO_ILUMINADO       con valor de 3
 *          
 * @param array $roomData Matriz que contiene la estructura de una habitacion
 * 
 * @return void
 */

function drawRoom( $roomData ){

    foreach( $roomData AS $rowData ){
        foreach( $rowData AS $cellData ){
            echo $cellData .' ';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;

}

/*
 * drawRoom Función que dibuja en console un habitación en el estado actual. Omite las casillas que contiene el valor de ESPACIO_ILUMINADO (3)
 *          Imprime las casilas correspondientes a
 * 
 *          ESPACIO_NO_ILUMINADO    con valor de 0
 *          PARED                   con valor de 1
 *          BOMBILLA                con valor de 2
 *          
 * @param array $roomData Matriz que contiene la estructura de una habitacion
 * 
 * @return void
 */

function drawNotIlluminatedRoom( $roomData ){

    foreach( $roomData AS $rowData ){
        foreach( $rowData AS $cellData ){
            if($cellData == ESPACIO_ILUMINADO ){
                echo ESPACIO_NO_ILUMINADO .' ';
            }else{
                echo $cellData .' ';
            }
            
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;

}

/**
 *  iterateRoom - Función principal. Resuelve de manera recursiva la mejor configuración posible para iluminar una habitación utilizando el menor numero de bombillas.
 * 
 * 
 *
 **/

 function iterateRoom( $roomData, $avaibleSpaces, $nextIndexIteration, $valueOfAdd, $actualTotalOfBulbs, $lowerTotalOfBulbs, $roomAditionalParams ){

    if( $nextIndexIteration == $avaibleSpaces->count ){
        
        $isFullRoomIlluminated  = evaluateIsFullRoomIlluminated( $roomData, $roomAditionalParams->rows, $roomAditionalParams->columns );
        
        if( $isFullRoomIlluminated ){

            return  array( $actualTotalOfBulbs, $roomData );

        }

        return array( PHP_INT_MAX, $roomData );
    }

    // If it is a Bulb, we increase the counter of used bulbs.
    if( $valueOfAdd == BOMBILLA ){

        // We can put a bulb or empty space in the roomData.
        $rowNewBulb     = $avaibleSpaces->data[$nextIndexIteration][ROW];
        $columnNewBulb  = $avaibleSpaces->data[$nextIndexIteration][COLUMN];
        $roomData[$rowNewBulb][$columnNewBulb]  = $valueOfAdd;
        $actualTotalOfBulbs++;

        // We propagate the light and we evaluate if is full illuminated
        $roomData               = propagateLightingRoom( $roomData, array($rowNewBulb, $columnNewBulb), $roomAditionalParams->rows, $roomAditionalParams->columns );
        $isFullRoomIlluminated  = evaluateIsFullRoomIlluminated( $roomData, $roomAditionalParams->rows, $roomAditionalParams->columns);

        if( $isFullRoomIlluminated ){
            if($actualTotalOfBulbs < $lowerTotalOfBulbs ){
                //This is a lower
                return array( $actualTotalOfBulbs, $roomData );
            }
        }

    }
    
    list( $totalBulbsUnlighting, $roomUnlighthingData)          = iterateRoom( $roomData, $avaibleSpaces, $nextIndexIteration + 1, ESPACIO_NO_ILUMINADO, $actualTotalOfBulbs, $lowerTotalOfBulbs, $roomAditionalParams );
    list( $totalBulbsLightingIteration,   $roomLighthingData)   = iterateRoom( $roomData, $avaibleSpaces, $nextIndexIteration + 1, BOMBILLA,             $actualTotalOfBulbs, $lowerTotalOfBulbs, $roomAditionalParams );
    
    if( $totalBulbsUnlighting < $totalBulbsLightingIteration ){
        return array( $totalBulbsUnlighting, $roomUnlighthingData);
    }

    return array( $totalBulbsLightingIteration, $roomLighthingData );

}

/**
 * printResult - Funcion utilitaria para impresion de resultados
 * 
 *
 * 
 * @param $originalRoomData
 * 
 * @param $roomData
 * 
 * @param $lowerTotalOfBulbs
 * 
 * @return void
 */

function printResult( $originalRoomData, $roomData, $lowerTotalOfBulbs ){

    echo PHP_EOL;
    echo PHP_EOL;
    echo "Mapa original." . PHP_EOL;
    echo PHP_EOL;
    drawRoom($originalRoomData);
    echo PHP_EOL;
    echo "Número de Bombillas mínimas necesarias es de $lowerTotalOfBulbs Bombillas." . PHP_EOL;
    echo PHP_EOL;
    echo "Mapa sin mostrar como la luz se propaga. Cada caracter " . BOMBILLA  . " representa una bombilla:" . PHP_EOL;
    echo PHP_EOL;
    drawNotIlluminatedRoom($roomData);
    echo PHP_EOL;
    echo PHP_EOL;
    echo "Mapa mostrando como la luz se propaga. Cada caracter " . BOMBILLA . " representa una bombilla. Cada número " . ESPACIO_ILUMINADO . " representa un expacio iluminado. " . PHP_EOL;
    echo PHP_EOL;
    drawRoom($roomData);
    echo PHP_EOL;

}

/**
 * Funcion principal de ejecución.
 * 
 *
 * 
 * @param void
 * 
 * @return void
 */

function main( $loadFromFile = false ){

    $miniumNumberOfBombillas= PHP_INT_MAX;
    $roomData               = getRoomData( $loadFromFile );
    $roomAditionalParams    = (object) array(
        'rows'    => count( $roomData ),
        'columns' => count( $roomData[CERO] )
    );

    // Obtenemos una lista y el numero de espacios disponibles en la habitación a colocar una bombilla
    list( $listaEspaciosDisponibles, $numeroDeEspaciosDisponibles ) = obtenerEspaciosDisponibles( $roomData, $roomAditionalParams->rows, $roomAditionalParams->columns );

    $avaibleSpaces = (object) array(
        'data'  => $listaEspaciosDisponibles,
        'count' => $numeroDeEspaciosDisponibles
    );

    $lowerTotalOfBulbs = PHP_INT_MAX;
    $actualTotalOfBulbs= CERO;

    list( $unlightingIteration, $roomUnlighthingData) = iterateRoom( $roomData, $avaibleSpaces, $nextIndexIteration = CERO, ESPACIO_NO_ILUMINADO, $actualTotalOfBulbs, $lowerTotalOfBulbs, $roomAditionalParams );
    list( $lightingIteration,   $roomLighthingData)   = iterateRoom( $roomData, $avaibleSpaces, $nextIndexIteration = CERO, BOMBILLA,             $actualTotalOfBulbs, $lowerTotalOfBulbs, $roomAditionalParams );


    if( $unlightingIteration < $lightingIteration ){

        printResult( $roomData, $roomUnlighthingData, $unlightingIteration );

    }else{

        printResult( $roomData, $roomLighthingData, $lightingIteration );

    }

}

/*
 *
 */

$loadFromFile = false;

if( $argv[1] === true || $argv[1] === 'true'){
    $loadFromFile = true;
}

main( $loadFromFile );

?>