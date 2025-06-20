<h1>Desarrollador: Nemias David Vasquez Suarez - Laravel 11</h1>

<h2>Actualizaciones de la base de datos.</h2>

<ul>
    <li>Tabla: emp_ciudad_ubigeo</li>
    <p>- el atributo "ubi_id" : debe ser de tipo smallInteger unsigned ya que se encuentran registros de hasta 2 500 elementos, y smallInteger unsigned soporta hasta 65 000 registros</p>
    <p>
    - Se recomienda normaliar la tabla, separando por "ubi_departamentos", "ubi_provincias" y "ubi_distritos" manteniendo relaciones con sus id. Se recomienda utilizar tinyInteger unsigned como tipo de dato en los id.</p>
    <li>Tabla: emp_tarifario_grupos</il>
    <p>
    - Se recomienda utiliar el tipo de dato de laravel SmallInteger unsigned para el atributo ta_id</p>
    <p>
    - Se recomiendo utilizar el id_distrito nada mas para identificar el lugar, ya que estaría relacionado con el departamento y provincia al separar las tablas.</p>
    <li>Tablas: emp_tarifario_grupo_tarifa - emp_terminal </li>
    <p>- Deben tener índice de tipo "TinyInteger unsigned" ya que posee valores de 0 a 255. esto debido al amplio espacio que está ocupando actualmente en la db.</p>
    <p>- Para los atributos de "ter_nombre" asignarle un valor de varchar 80</p>
</ul>

<h2>Pasos para levantar el proyecto</h2>
En la terminal del proyecto

<p>Se deben ejecutar estos comandos antes de levantar el api</p>

php artisan config:clear     
php artisan cache:clear 
php artisan route:clear 
php artisan view:clear 
php artisan config:cache 
php artisan route:cache
php artisan l5-swagger:generate

<ul>
    <li>Ejecutar "composer install"</li>
    <li>Ejecutar "composer dump-autoload -o"</li>
    <li>Configurar el archivo .env con la base de datos entregada.</li>
    <li>Ejecutar "php artisan serve"</li>
</ul>

<h3>Notas de terminado</h3>
<p>Dificultades para interpretar las consutlas sql a eloquent.</p>
<p>La api no entrega completa la información.</p>
<p>Se integra Swagger para documentación.</p>
<p>No se completó de escribir las migraciones, solo las recomendaciones con tipos de datos</p>