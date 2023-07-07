curl -s https://laravel.build/devstagram | bash 	//Instalacion de proyecto Laravel con Docker + WSL

Entras dentro del PowerShell y escribes wsl -> luego vas hacia el proyecto "devstagram".
Escribes  ./vendor/bin/sail up -> Con ello puedes arrancar el proyecto (ACTUALMENTE CON sail up es suficiente)
PARA FINALIZAR QUE ESTE CORRIENDO EL PROYECTO ./vendor/bin/sail up (ACTUALMENTE CON sail down es suficiente)

//VAMOS A UTILIZAR POR EL MOMENTO LARAGON PERO SERÍA ASÍ LA INSTALACIÓN DE DOCKER


//npm run watch -> TIRAR DENTRO DE LA CARPETA DEL PROYECTO PARA QUE CORRA TAILWIND

//TAILWIND CSS -> Para que nos corra y nos recoja los campios debemos de tirar dentro del proyecto devstagram: 'npm run dev' o 'npm run watch'.
Su configuración se hizo en el documento tailwind.config.js
//HEROICONS -> Lo utilizamos para emojis, solo copiar y pegar desde la web el svg. https://heroicons.com/
//DROPZONE -> Para subir imagenes, lo hemos configurado en el app.js y nos vale para las subidas de posts. Consultar tambien PostController, Post (Model) y PostFactory (abajo explicado lo hecho) https://docs.dropzone.dev/getting-started/installation/npm-or-yarn.
//INTERVENTION IMAGE -> Para establecer guardados de imagenes, se instala como en la web se indica con composer y se añaden dos líneas en el config/app.php . Seguir instrucciones de la web https://image.intervention.io/v2/introduction/installation


//Models + Migrations + Factory
Ya conocías Models y Migrations. Factory es como un tester hacia lo que vas a hacer. 
Por ejemplo, se ha creado PostFactory.php, dentro de la carpeta 'factories', y en el archivo hemos establecido unas pruebas de insercción de posts.
Para tirar el facotry, dentro del proyecto de devstagram, tenemos que escribir 'php artisan tinker' y luego dentro 'App\Models\Post::factory()->times(20)->create();'.
Con esto último tirado queremos que nos cree 20 veces lo establecido en 'PostFactory.php'

En cuanto a Models hemos creado 2 funciones en User y Post, una hasMany y otra belongsTo, con ello podemos llamar a esas funciones directamente dentro de la variable y sacar los datos.
Por ejemplo en el de user que hemos hecho un hasMany de los posts:
$user = User::find(6)
$user->posts //Directamente te saca los posts del usuario, mirar en el modelo como se ha establecido para que esto sea así