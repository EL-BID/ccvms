*Esta herramienta digital forma parte del catálogo de herramientas del **Banco Interamericano de Desarrollo**. Puedes conocer más sobre la iniciativa del BID en [code.iadb.org](https://code.iadb.org)*

## Sistema para la Administración de Red de Frío y Vacinación CCVMS

[![Build Status](https://travis-ci.org/EL-BID/ccvms.svg?branch=master)](https://travis-ci.org/EL-BID/ccvms)
![analytics image (flat)](https://raw.githubusercontent.com/vitr/google-analytics-beacon/master/static/badge-flat.gif)
![analytics](https://www.google-analytics.com/collect?v=1&cid=555&t=pageview&ec=repo&ea=open&dp=/ccvms/readme&dt=&tid=UA-4677001-16)

### Descripción y contexto
---
Salud Mesoamérica, ME-G1001 & ME-G1004

Para contribuir en la reducción de la muerte infantil por enfermedades prevenibles por vacunación la Secretaría de Salud del Estado de Chiapas implementa herramientas para generar y gestionar información fidedigna de censo nominal de vacunación y seguimiento del mismo; Se crea CCVMS como estrategia para registrar y monitorear la  cobertura de vacunación, y sumar estrategias que apoen a lograr la cobertura máxima en el estado, se puede tammbién saber que infantes necesitan vacunas con respecto a su esquema de vacunación.

CCVMS se encarga también de registrar incidentes en la cadena de frío, esto asegura que las unidades de salud puedan reportar fallas en la red y Departamento estatal de Red de Frío preste atención a dicha situación, esta actividad es primordial pues el ojetivo de la red es mantener el biólogico condiciones aptas para ser aplicado. 


La arquitectura REST es muy útil para construir un cliente/servidor para aplicaciones en red. REST significa Representational State Transfer (Transferencia de Estado Representacional) de sus siglas en inglés. Una API REST es una API, o librería de funciones, a la cual accedemos mediante protocolo HTTP, ósea desde direcciones webs o URL mediante las cuales el servidor procesa una consulta a una base de datos y devuelve los datos del resultado en formato XML, JSON, texto plano, etc. (Para el proyecto CIUM nos enfocaremos en JSON) Mediante REST utilizas los llamados Verbos HTTP, que son GET (Mostrar), POST (Insertar), PUT (Agregar/Actualizar) y DELETE (Borrar).

### Guía de usuario
---


### Guía de instalación
---
#### Requisitos
##### Software
Para poder instalar y utilizar esta API, deberá asegurarse de que su servidor cumpla con los siguientes requisitos:
* MySQL®
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* [Composer](https://getcomposer.org/) es una librería de PHP para el manejo de dependencias.
* Opcional [Postman](https://www.getpostman.com/) que permite el envío de peticiones HTTP REST sin necesidad de desarrollar un cliente.

#### Instalación
Guia de Instalación Oficial de Laravel 5.1 [Aquí](https://laravel.com/docs/5.1#installation)
##### Proyecto (API/Cliente)
El resto del proceso es sencillo.
1. Clonar el repositorio con: `git clone https://github.com/arbey-morales/ccvms.git`
2. Instalar dependencias: `composer install`
3. Editar archivo `.env`  ubicado en la raiz del directorio de instalación.
       
        APP_DEBUG=false
        APP_KEY=8uBfPdRcY9lqo6yaXuTCHhQrb73RdxgT

        DB_CONNECTION=mysql
        DB_HOST="servidor"
        DB_DATABASE="base_datos"
        DB_USERNAME="usuario_mysql"
        DB_PASSWORD="password

        PUSHER_APP_ID="ID_APP"
        PUSHER_APP_KEY="KEY_APP"
        PUSHER_APP_SECRET="secret"
        # PUSHER_APP_CHANNEL=reporteC1
        PUSHER_APP_CLUSTER="cluster"

       
    * ***Opcional*** Si va a usar pusher debe crear una cuenta [Aquí](https://pusher.com/)
    
* **APP_KEY**: Clave de encriptación para laravel.
* **APP_DEBUG**: `true` o `false` dependiento si desea o no tener opciones de debug en el código.

* **DB_HOST**: Dominio de la conexión a la base de datos.
* **DB_DATABASE**: Nombre de la base de datos.
* **DB_USERNAME**: Usuario con permisos de lectura y escritura para la base de datos.
* **DB_PASSWORD**: Contraseña del usuario.

* **PUSHER_APP_ID**: ID de la APP que te da el pusher al crear un proyecto.
* **PUSHER_APP_KEY**: Llave para el proyecto de pusher.
* **PUSHER_APP_SECRET**: Contraseña para el proyecto de pusher.
* **PUSHER_APP_CHANNEL**: Canal que desea usar para las notificaciones con pusher.
* **PUSHER_APP_CLUSTER**: Cluster seleccionado para el canal del pusher.

##### Base de Datos del proyecto
1. Abrir su Sistema Gestor de Base de Datos y crear la base de datos `ccvms`.
2. Abrir una terminal con la ruta raiz donde fue clonado el proyecto y correr cualquiera de los siguientes comandos:
    * `php artisan migrate --seed` Crea las tablas y e inserta datos precargados de muestra.
    * `php artisan migrate` Solo crea las tablas sin datos.
3. Una vez configurado el proyecto se inicia con `php artisan serve` y nos levanta un servidor: 
    * `http://127.0.0.1:8000` o su equivalente `http://localhost:8000`

### Cómo contribuir
---
Si deseas contribuir con este proyecto, por favor lee las siguientes guías que establece el [BID](https://www.iadb.org/es "BID"):

* [Guía para Publicar Herramientas Digitales](https://el-bid.github.io/guia-de-publicacion/ "Guía para Publicar") 
* [Guía para la Contribución de Código](https://github.com/EL-BID/Plantilla-de-repositorio/blob/master/CONTRIBUTING.md "Guía de Contribución de Código")

### Código de conducta 
---


### Autor/es
---
* **[Caralampio Arbey Morales Trujillo](https://github.com/arbey-morales  "Github")** - [Bitbucket](https://bitbucket.org/Arbey "Bitbucket")
* **[Ramiro Gabriel Alférez Chavez](mailto:ramiro.alferez@gmail.com "Correo electrónico")**
* **[Eliecer Ramirez Esquinca](https://github.com/checherman "Github")**

### Licencia 
---
La Documentación de Soporte y Uso del software se encuentra licenciada bajo Creative Commons IGO 3.0 Atribución-NoComercial-SinObraDerivada (CC-IGO 3.0 BY-NC-ND).

El código de este repo usa la [ Licencia AM-331-A3](LICENSE.md).

## Limitación de responsabilidades

El BID no será responsable, bajo circunstancia alguna, de daño ni indemnización, moral o patrimonial; directo o indirecto; accesorio o especial; o por vía de consecuencia, previsto o imprevisto, que pudiese surgir:

i. Bajo cualquier teoría de responsabilidad, ya sea por contrato, infracción de derechos de propiedad intelectual, negligencia o bajo cualquier otra teoría; y/o

ii. A raíz del uso de la Herramienta Digital, incluyendo, pero sin limitación de potenciales defectos en la Herramienta Digital, o la pérdida o inexactitud de los datos de cualquier tipo. Lo anterior incluye los gastos o daños asociados a fallas de comunicación y/o fallas de funcionamiento de computadoras, vinculados con la utilización de la Herramienta Digital.
