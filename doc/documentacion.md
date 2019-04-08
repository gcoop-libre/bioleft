# bioleft.org

## Configuraciones

Algunas configuraciones iniciales necesrias para utilizar la plataforma.

### 1. Importación de semillas, plagas y agroquimicos

Para probar el sitio con contenidos se puede hacer una importación inicial de
semillas, plagas y agroquímicos. En este repositorio se incluyen los archivos
a importar en el directorio `data`.

* [data/plagas.csv](data/plagas.csv) ([fuente][0])
* [data/quimicos.csv](data/quimicos.csv) ([fuente][1])
* [data/semillas.csv](data/semillas.csv) son las semillas publicadas en INASE
  (Instituto Nacional de Semillas) de Argentina ([fuente][2])

Desde el menú *Contenido > Canales de noticias* presionar al botón *Agregar* y en
la pantalla siguiente seleccionar *Semillas registradas*, *Plagas* o *Químicos*
según corresponda. Luego ingresar un título, cargar el archivo correspondiente y
guardar.

### 2. Usuarixs

#### Usuarix Editor

Para crear los contenidos, es necesario ser editor o administrador del sitio.
Crear los contenidos de ayuda del sitio, la importación de las semillas,
taxonomías de ocupación y trabajo, etc.

#### Usuarix Biolefter

Cualquier persona podrá registrarse en la plataforma, sin necesidad de que otrx
lo apruebe.

Los campos obligatorios son:

* *Nombre de usuario*
* *Email*
* *Dirección* Podrá cargar la dirección completando este campo, y si no posee
  dirección numerada, puede hacerlo localizando el lugar a través del campo Mapa
  Usuario. Esto servirá para que cuando el usuarix cargue una semilla en *Mis
  semillas* esta pueda ser visualizada en el mapa para todxs lxs usuarixs biolefter.

Los campos opcionales son:
* *Lugar de trabajo*
* *Ocupación*

### 3. Menú principal (navegación principal)

Desde *Estructura > Menús* se pueden agregar links a la Navegación Principal del sitio.

Las páginas que denerán añadirse en el menú son:

* *Catalogo de Semillas* (`/catalogo-semillas`)
* *Mis Semillas* (`/mis-semillas`)
* *Cuaderno de campo* (`/lote`)
* *Mis Transacciones* (`/mis-transacciones`)
* *Foro* (`/forum`)

## Página básica y Ayuda

Estos tipos de contenido permiten publicar páginas de información general y temas
de la ayuda que serán visibles para el público general de la plataforma (sin
necesidad de estar autenticadx).

## Licencias

Aquí se dan de alta los diferentes tipos de licencias que incluirán las semillas
que registren lxs usuarixs de bioleft. Al incluirlas, deberá agregar un ícono y
una descripción que estará disponible al momento de cargar una nueva semilla.

## Catálogo de semillas

En esta vista se listarán todas las semillas que lxs usuarixs registren y tengan
aplicadas una licencia. Son las que cargarán lxs usuarixs en *Mis Semillas*.

## Mis semillas

Es un formulario donde lxs usuarixs *Biolefter* podrán cargar semillas existentes
en la plataforma, nuevas semillas o semillas mejoradas y aplicar una licencia
para poder intercambiar con otrxs usuarixs.

### Semillas existentes

Esta semilla hace referencia a una semilla del listado de semillas registradas.
Buscará una semilla y luego agregará la cantidad que disponible y una licencia
para la misma.

### Semilla sin registrar

Este semilla no se encuentra incluida entre el listado de semillas registradas.
Se deberán completar todos los datos solicitados para dar de alta esta nueva
semilla.

### Semillas mejoradas

Esta semilla hace referencia a una semilla del listado de semillas registradas.
Se debe incorporar los detalles de dicha mejora y luego incorporar los detalles
de semilla como cantidad y la licencia para la misma.

## Mis transacciones

Una vez que un usuarix solicita una transacción desde el catálogo de semillas el
sitio enviará una notificación vía email al usuarix que publicó la misma. Este
recibirá un mensaje que le permitirá aceptar o rechazar la transacción.

## Foro

El foro provee un canal en el cual lxs biolefters podrán compartir mensajes en
diferentes categorías referentes a la temática de la herramienta online.

## Cuaderno de campo / Lote

Esta sección permite a lxs usuarixs crear un registro de sus diferentes campos /
lotes indicando un nombre y una ubicación geográfica.

## Mis cultivos

En esta sección lxs usuarixs podrán registrar sus cultivos asignando los mismos
a un campo / lote determinado.

## Labor

Lxs usuarixs biolefter registrarán las labores de sus cultivos registrados. Cada
labor incluye variedad de datos técnicos que permiten agregar valor y
funcionalidad al sistema.


[0]: https://www.sinavimo.gov.ar/plagas/simple
[1]: https://gestion.inase.gov.ar/consultaGestion/gestiones
[2]: http://www.senasa.gob.ar/informacion/prod-vet-fito-y-fertilizantes/prod-fitosanitarios-y-fertili/registro-nacional-de-terapeutica-vegetal
