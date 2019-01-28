# bioleft

> Plataforma para el intercambio de semillas con licencias libres.

## Requerimientos

* PHP 7.0 o posterior
* [composer][0]
* MariaDB 5.5.20 / MySQL 5.5.3 / Percona Server 5.5.8 o posterior
* [drush][1] (opcional pero recomendado)
* cualquier servidor web (no es necesario usando drush)

Para más información ver [requerimientos][2] en la página oficial de drupal.

## Instalación rápida

Recomendamos usar `drush` para simplificar la instalación y el uso del sitio

### 1. Construir el sitio

```
$ composer install
$ composer drupal:scaffold
```

### 2. Instalar el sitio

```
$ drush site-install --db-url=mysql://USER:PASS@HOST/DB --site-name=Bioleft --locale=es bioleft
```

Reemplazando `USER`, `PASS` y `HOST` con los datos del servidor de base de datos
a usar y `DB` por el nombre de la base de datos.

Esto creará la base de datos e instalará drupal. Si el usuario no tiene
suficientes permisos para crear la base de datos crearla antes de ejecutar este
comando.

### 3. Acceder a la plataforma

Finalmente para acceder a la plataforma recién instalada ejecutar

```
$ drush rs
```

y luego acceder a http://127.0.0.1:8888

En caso de usar un servidor web sólo es necesario el paso 1 y luego acceder a la
plataforma y completar la instalación desde un navegador web seleccionando el
perfil de instalación **`bioleft`** en la pantalla *Elegir perfil*.

## Desarrollo

### Features

Usamos [features][3] para empaquetar y exportar las funcionalidades del sitio,
se encuentran en el directorio `modules/custom`.

### Tema

El tema del sitio se encuentra en el directorio `themes/custom/semilla`.

Usamos [bootstrap 3][4], [sass][5] y [grunt][6], por lo que es necesario instalar 
[node][7] y [grunt][6].

Luego para instalar las dependencias ejecutar

```
$ npm install
```

Para compilar los archivos ejecutar

```
$ grunt
```

También se puede ejecutar

```
$ grunt watch
```

para compilar automáticamente los archivos cada vez que se modifique una de las fuentes.

### Configuraciones

#### Geolocalización

Obtener una [API Key de google maps][8] y configurarla en:

* *Configuración > Sistema > Geocoder*
* *Configuración > Servicios > Geolocalización*

#### Envío de correos

Para que el sitio pueda enviar correos es necesario configurar el módulo
[Swift Mailer][9] en *Configuración > Sistema > Swift Mailer*.

### Documentación

En [documentacion.md](doc/documentacion.md) hay más información sobre el uso
de la plataforma, la importación de los contenidos iniciales, etc.

[0]: https://getcomposer.org
[1]: https://www.drush.org
[2]: https://www.drupal.org/docs/8/system-requirements
[3]: https://www.drupal.org/projects/features
[4]: https://getbootstrap.com/docs/3.3
[5]: https://sass-lang.com
[6]: https://gruntjs.com
[7]: https://nodejs.org
[8]: https://developers.google.com/maps/documentation/javascript/get-api-key
[9]: https://www.drupal.org/project/swift_mailer
