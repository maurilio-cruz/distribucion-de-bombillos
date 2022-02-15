# distribucion-de-bombillos
Un electricista muy cuidadoso está tratando de iluminaral más bajo costo posible las habitaciones de sus clientes. Las habitacionesque él ilumina, siempre sonhabitaciones en forma de matriz (Ver figura 1). Comolos bombillos son muycostosos, él trata de iluminar toda la habitaciónutilizando la menor cantidad de los mismos....


## prueba logica

## Distribución de bombillas

# Descripción
El presente documento describe la manera de como ejecutar la solución al desafio propuesto en el documento  'Prueba loìgica Distribucioìn de bombillos.pdf'.
Requisitos
La solución propuesta esta desarrollada utilizando las siguientes tecnológias:

Sistema Operativo: Linux- Ubuntu 20.04.3 LTS
Lenguaje de programación: PHP V 7.4.3 (cli)

Permisos de escritura: Debido a que el requerimiento solicita poder acceder a archivos para carga de input. se requiere al menos tener permisos de lectura al archivo  input.txt.

# Ejecutar programa

1. clonar el proyecto https://github.com/maurilio-cruz/distribucion-de-bombillos.git

2. En caso de ser necesario habilitar permisos de lectura al archivo input.txt
 
3. Dentro del directorio distribucion-de-bombillos ejecutar el comando
	  # php bombilla.php
   Para mostrar una escenario previamente cardado.
   
4. Para modificar el input editar el archivo input.txt colocando la matriz que represente la habitación que el electricista va a iluminar.
	Cada caracter representa un espacio en la habitación. Los caracteres se deben capturar sin agregar ningun espacio entre ellos. los caracteres validos son 0 para representar espacios vacios, 1 para indicar muro y Enter para representar que se genera nueva fila de espacios.
  
Ejemplo de datos cargados:

01000
00010
00000
00001 
  
  
5. una vez modificado el archivo input.txt, para ejecutar el programa cargando estos datos del archivo ejecutar desde	consola el comando:
	# php bombilla.php true
  
6. En caso de quere ejecutar el programa cargando los datos de prueba se puede igualmente ejegutar el comando:
	# php bombilla.php false

Respuesta esperada
Al termino de ejecución del programa se una respuesta similar a la siguiente:

>$ php bombilla.php false

Mapa original.

0 1 0 0 0
0 0 0 1 0
0 0 0 0 0
0 0 0 0 1 

Número de Bombillas mínimas necesarias es de 4 Bombillas.

Mapa sin mostrar como la luz se propaga. Cada caracter 2 representa una bombilla:

2 1 2 0 0
0 0 0 1 0
0 0 0 0 2
0 2 0 0 1 

Mapa mostrando como la luz se propaga. Cada caracter 2 representa una bombilla. Cada número 3 representa un expacio iluminado. 

2 1 2 3 3
3 3 3 1 3
3 3 3 3 2
3 2 3 3 1 

Donde:
* La primer matriz representa la habitación original cargada desde el input. 
* Despues se muestra el número de bombillas mínimas necesarias para iluminar la habitacion.
* A continuación se muestra la forma en se sugiere colocar las bombillas en la habitacion.
* Finalmente se muestra una simulació que indica la manera en que la habitación esta completamente iluminada.
