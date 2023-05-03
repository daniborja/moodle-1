# Desarrollo de Plugin y Filtro para Moodle


## Intro a la Arquitectura de Moodle
- --- Init
  - Moodle: Modular Object-Oriented Dynamic Learning Environment 
    - Es Modular y Orientado a Objetos
  - Tiene 1 parte central q es el    Core    de Moodle
    - Y al rededor de este    Core   tendremos los diferentes modulos (pugins locales)
      - Plugins Locales, son aquellos q se instalan junto con la instalacion de Moodle
        - Bloques, Themes, Examenes, Etc.
    - Podemos instalar plugins de 3ros
    - 1 Bloque es 1 Plugin
    - 1 Plugin es 1 Carpeta en nuestra Instalacion de Moodle


	-- Moodle ahora implementa MVC
		- Los    Renders    son lo q permitio separar las Views del Controller
		- A las   Views    las vamos a tener como Plantillas
  		- Las Views se construyen con   Mustache
		- Los     Models    son las Entities/DB/Tablas

	-- El mam instala Moodle con Bitnami
		- Yo descargue directo el Zip de la page
		- Cada carpeta es 1 plugin

	-- En la carpeta de    moodle    tenemos los    /blocks    y dentro:
		- /classes: Aqui estan los   `renders`
		- /db:	tb para actualizaciones
		- /lang:	para los idiomas
		- libs: guarda todas las rutinas

	-- /mod: cada carpeta va a tener una estructura similar a la de   /blocks
		- classes, db, lang, pix, tests, tool
		- Archivos como:
  		- version: modificamos la version del Plugin
		- Asi, casi todo va a ser 1 Plugin, y el plugin es un /dir q esta ordenado con cierta estructura
  		- /amd: rutinas Async en JS

	-- /themes: temas q vienen x defecto (boost, classic)
		- contienen  amd, classes, cli, lang, layout, pix (imgs), scss, style, templates, tests, settings para los parametros
		- Desarrollar 1 theme es complicado, x eso toman de base el    boost








## Notación Frankenstyle
- --- Nombres de componentes Frankenstyle se Refiere a la Convencion de nomenclatura q se utiliza para identificar de forma unica a 1 complemento de moodle segun el tipo de complemento y su nombre
  - Se utiliza en todo el codigo de Moodle con 1 notable excepcion q son las classes de CSS de los themes
		- theme_mitologia
		- core_auth:			usa recursos del core, la parte de Auth
		- mdl_local_cooreport:	Lo mismo para el desarrollo de DB
  		- mdl es la abreviacion de  moodle
  		- local: es local
  		- coolreport: 1 reporte muy util
  - snake_case
    - Va a ser usado x todo en moodle
      - Nombres de fn  |  Nombres de Classes  |  Constantes  |  Nombres de  Tablas (db)
      - Archivos de cadenas de idiomas    |    Renderers
  







## El estándar de documentación PHPDoc
- --- PHPDocs es 1 adpatacion de   JavaDocs    para documentar la programacion en PHP
  - Es 1 method estandar para definir y comentar los apectos dle codigo








## Modo de diseño de temas, modo de desarrollo y purgar los cachés
- --- Modo de Disenio de Temas
  - Si se activa este     Modo de Disenio de Temas   las paginas NO se guardaran en la Cache y el sistema cargara las paginas lentamente
  - Puede depurar los caches cada vez q le parezca conveniente
    - Utilizadas cuando se manejan Cadeas de Idiomas
  - Podemos activar el modo Depuracion
    - Para depurar la cache







## La clase html_write
- --- Es una Clase Auxiliar q nos va a permitir escribir    Tags HTML   
  - Se recomienda usar     html_writer    y NO HTML directo ya  q con este   writer    se hacen ciertas validaciones y se maneja cierto estandar para mantener el codigo del    Render   similar y facil de leer

	--  html__writer::start_tag     ::  es la resolucion de instancias y establece q inicia un tag html
		- Producir Tag de Apertura con 2 Args: Tag a abrir

```php
<?php echo html_writer::start_tag('div', array('class'=>'blah')); ?>
<div class="blah">
<?php echo html_writer::start_tag('table',
array('class'=>'generaltable', 'id'=>'mytable')); ?>
<table class="generaltable" id="mytable">
```


	-- html_writer::end_tag		Produce 1 tag de cierre
		- Cierra el tag q abrio el   ::start_tag

```php
<?php echo html_writer::end_tag('div'); ?>
</div>
<?php echo html_writer::end_tag('table'); ?>
</table>
```


	-- html_writer::tag     toma 3 args q son el start/end_tag y el contenido del mismo

```php
<?php echo html_writer::tag('div', 'Lorem ipsum', array('class'=>'blah')); ?>
<div class="blah">Lorem ipsum</div>
```



	-- html_writer::empty_tag		para tags de cierre automatico como    img/input

```php
<?php echo html_writer::empty_tag('input', array('type'=>'text', 'name'=>'afield',
'value'=>'Este es un campo')); ?>
<input type="input" name="afield" value="Este es un campo" />
```















# Desarrollo de plugins locales
## Las carpetas y archivos básicos de un plugin local
- --- 1 Plugin Local es un Plugin q no lo podemos localizar entre los 30 y picos de plugins q tenemos
  - Si No encuentras en q Tipo de Plugin se encuentra su plugin, No es 1 Bloque, No es 1 theme, No es modificacion de Archivo, entonces lo metemos en      `locale`
    - Se encuentran en el dir      `locale`     del    `Moodle CORE`
      - Creamos el nombre de del dir siguiendo los estandares de moodle (english snake_case)
        - Creamos el archivo     `version.php`
  				- Solo con este archivo se podra instalar el Plugin, se hara 1 instalacion vacia, pero no dara error.
  				- Y se va a     Crear 1 Table en DB    q se va a llamar     locale_PLUGIN-NAME

		-- Caracteristicas Estandar del Complemento:
			- version.php		version del script q debe incrementarse despues d los cambios
			- install.xml		ejecutado durante la instalacion
			- /db/install.php		ejecutado despues del  install.xml
			- /db/upgrade.php		ejecutado despues del cambio de    version.php
			- /db/access.php		definicion de capacidades (roles)
			- /db/events.php		controlador de eventos y subindices
			- /db/external.php	descripciones de servicios web y fb externas
			- /db/cron.php			W cron (cronjobs), se coloca en   lib.php
			- /lang/en/local_pluginname.php  	

		-- Las funciones mas utilizadas son:
			- local_xxx_extend_navigation()		<-  frankenstyle
			- Override: sobrescribir
			
		-- files
			- /local/xxx/settings.php: 	Opciones de configuracion q vamos a tener desde el admin
			








## Crear una nueva opción en el menú de administración del curso
- --- Crearemos 1 nuevo Plugin Local q sera 1 nueva opcion en el Menu de administracion del curso
  - No lo queremos manejar como Bloque, ni como App, ni como Theme, x tanto cae dentro de la Categoria de Plugins Locales
  - Crearemos el    dir   con el nombre del plugin q contendra
    - version.php
    - idioma
    - dir   db/
      - Para q mas adelante podamos crear 1 table


	- -- Iniciamos creando el      `version.php`    ya q sin este va a dar warnings
  	- Requiere la Licencia, luego al  Documentation   tipo PHPDoc
  	- Lo creamos en el      locale/     del root htdocs
    	- Dentro creamos     /decalogo
      	- Dentro creamos el     version.php y el local_decalogo.php es frankenstyle
  				- Estos archivos necesita la    licencia    y el      PHPDoc
  				- local_decalogo.php
    				- Tiene las variables

		-- Creamos el     local_decalogo.php     en /locale/xxx/lang/en
			- xq configura en English
			- Con esto, Module haria la instalacion











































