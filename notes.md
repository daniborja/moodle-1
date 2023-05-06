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

	-- El modo   Developer    nos va a mostrar errores en moodle q se generen x codigo q metimos







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
			
		-- Lang:
		File path: `/lang/en/plugintype_pluginname.php`


	```sh
		# URL  version.php
		https://docs.moodle.org/dev/version.php
		https://moodle.org/plugins/mod_attendance/versions

		# para el $plugin->requires
		https://moodledev.io/general/releases#moodle-41-lts

		# Plugin files
		https://moodledev.io/docs/apis/commonfiles
		https://docs.moodle.org/dev/Plugin_files
	```









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
  	- Lo creamos en el      local/     del root htdocs
    	- Dentro creamos     /decalogo
      	- Dentro creamos el        version.php y el local_decalogo.php     es frankenstyle
  				- Estos archivos necesita la    licencia    y el      PHPDoc
  				- local_decalogo.php
    				- Tiene las variables

		-- Creamos el     `local_decalogo.php`     en       '/locale/xxx/lang/en'
			- xq configura en English
			- Con esto, Module haria la instalacion









## Añadir una opción en el menú de administración del curso
- --- Para agregar 1 opt en el menu de Admin de Moodle w en el      `lib.php`
  - Damos el nombre con notacion    frankenstyle   
	 	- En el menu tomara 1 Node adicional para el link al decalogo q creamos
  

	- -- Creamos el     `lib.php`     	
  	- Al igual q con los demas archivos, vamos a tener la Licencia del GNU y el PHPDoc
  	- Con el     frankenstyle     damos nombre:   `local_decalogo_extend_settings_navigation`    a la fn
    	- Esta   fn   NO la invocamos en ningun lado, sino q se ejecuta en auto x la API de Navegacion
      	- context es importante
      	- con   `global`   podemos acceder a Variables Globales de Moodle


    - -- Los archivos de     Lan    son afectados x Cache, asi q debemos purgarla para ver cambios
			-- Asi creamos el el       node de url       para cargar otra page
    		https://moodledev.io/docs/apis/commonfiles#libphp

    	- -- Con esto  ya nos crea el  node/espacio  en   settings (engrane)   del Course
      	- Al desplegarlo ya puedo ver este nodo, pero lleva a 404 xq aun NO se implementa la page
    		- Para verlo tuve q purgar la cache





		-- URL
			https://moodledev.io/docs/apis/commonfiles#libphp
			https://docs.moodle.org/dev/Plugin_files

			https://moodledev.io/docs/apis/plugintypes/local
			https://moodledev.io/docs/apis/core/navigation








## Crear la página a desplegar
- --- En el video anterior creamos el param y la url para agregar 1 pagina custom
  - Vamos a aprender a crear Distintos Tipos de Paginas y de Objetos Globales

	- El archivo      `config.php`      trae las Variables Globales (anexo B) en el Module Core
  	- El objeto      `$PAGE`      se encarga de la configuracion de la pagina
    	- De sus diferentes elementos, pero No los va a desplegar
  	- El objeto      `$OUTPUT`      se encarga de mostrar los Elementos de la Page
		 	- Por eso lo manejamos en conjunto con    $PAGE
  	- El objeto      `$DB`      maneja la DB	


- -- Creamos el      `decalogo.php`      en el root del plugin 
  - Igual q los demas, inicia con la Licencia GNU y el PHPDoc
  - Vamos a    llamar    al archivo      `config.php`     q es propio de Moodle
    - Lo treamos con      `require_once`    y va a generar los objetos globales: db, output, page
    - Nos traemos el     courseId    con el     `required_param`
    - Creamos el   html   con el    html_writter   mencionado antes


- -- En este punto, gracias al Output ya se muestra la page


	-- URL:
			https://docs.moodle.org/dev/Page_API#.24PAGE_The_Moodle_page_global








## Crear diferentes versiones de Idiomas
- --- Lo q se hizo en el anterior video es manejar las   strings   directamente en el html, lo cual NOOO es lo recomendado hacerlo dentro de Moodle, xq se debe usar el      `API String`     de Moodle
  - Para  w  con ese contenido se una el     `get_string()`    que es parte del    "API STRING"    de Moodle
    - X medio de la fn    `getString()`, del API String, podemos    "traducir"   a != idiomas
      - Es una traduccion entre comillas, xq Moodle no lo traduce, sino q TOMO la String para el Idioma Seleccionado en Moodle
        - La tarea de realizar la Traduccion es de nosotros


	- -- Creamos el     `local_decalogo.php`   para English    en  'local/decalogo/lang/en'
  	- Q tiene las   strings    con su key y value, a los q se hara referencia desde el    `decalogo.php`
    	- Desde el    decalogo.php    se traera esas strs con el       "getString()"
			`				$string['pluginname'] = 'Decalogue of the good teacher';`

	- -- Creamos el     `local_decalogo.php`    para Spanish en  'local/decalogo/lang/es'
  	- Asi tenemos las     strings      con su key y value para traerlas en la raiz de la carpeta del plugin
  	- El nombre del   /dir   donde va este locale debe ser el MISMO nombre q tenemos instalado como idioam
    	- Si instalamos el Pack de Idioma de Espaniol de Mexico      (es_mx)     
      	- Entonces el   dir deberia ser       /es_mx,  pero como instale espanil internacional use   /es
		- Para que se apliquen los cambios      `Purgamos la Cache`
		- Cabe recalcar q es  _decalogo xq es en frankenstyle con el nombre del plugin

	- -- Modificamos el     `decalogo.php`     para q traiga las strings con      "getString()"
    	- Usamos el     `getString()`      para traer las strings en auto deacuerdo al title

	- -- En este punto, ya trae las strings de acuerdo al Language seleccionado en Moodle



		-- URL:
				https://docs.moodle.org/dev/String_API#get_string.28.29








## Quitar la página principal o “home”
- --- Este pugin local nos ayudara a Quitar el La pagina Pinrcipal / Home
  - Vamos a suponer q no se quiere tener la home para la nav de courses y demas
  - Dentro del 		 `API de Navegacion`		  tendremos 2 callbacks q se van a llamar en auto
    - 1 cb:   extender la navegacion
    - 2 cb:		extender la configuracion
      - El q usamos para generar ese nodo q nos permite ir a otra page
	- Estas      fn callback      se llaman cada vez q el usuario esta viendo 1 pagina dentro del modulo y solo deben extender la navegacion del mismo.
  	- Si no existen, se toma el original, y si existen, se hace lo q se llama la sustitucion/anulacion
    	- s

				https://moodledev.io/docs/apis/core/navigation#plugin-callbacks
		
  - Estas   fn   de callback se llaman c/vez q el User esta Viendo 1 Pagina dentro del Modulo y Solo deben Extender la navegacion del mismo
    - Function:    local_{plugin_name}_extends_navigations(global_navigation $nav)
    - Settingn navigation: q ya lo usamos

	- -- Creamos el      `version php`      en 'local/quitahome/version.php
  	

	- -- Creamos el     `lib.php`     en el root del nuevo plugin, este    lib   es el q tiene los callbacks
  	- `local_quitahome_extend_navigation()`  busca la page establecida
    	- Verificamos en el    navigation    q se encuentre el   home   
      	- CUando lo encuentra lo eliminamos con el    remove()    para q no sea accsesible



	-- URL
		- Navigation API:		https://moodledev.io/docs/apis/core/navigation
												https://moodledev.io/docs/apis/core/navigation#plugin-callbacks
		- Output Callbacks:	



























