# Online services

Una aplicación en la que usuarios pueden crear servicios para su venta y en cada uno de ellos conversar mediante chats con los diferentes usuarios. Solo el propietario del servicio verá mas de un chat.

# Preparación

-   Clonar o descargar el repositorio
-   Crear una base de datos
-   Copiar .env.example, renombrar a .env y rellenar los datos de conexión de la BBDD
-   En terminal acceder al directorio y ejecutar:
    -   npm install
    -   composer install
    -   php artisan install:broadcasting
    -   php artisan key:generate
    -   php artisan migrate
    -   php artisan db:seed

Importante: Asegurar que estén los datos de la API Reverb en el archivo .env

# Puesta en marcha

    Necesitaremos 4 terminales

-   npm run dev
-   php artisan queue:listen
-   php artisan reverb:start
-   php artisan serve

# Acceso

    Existen 4 usuarios precargados:

-   admin@admin.com / 12345678
-   test1@test.com / 12345678
-   test2@test.com / 12345678
-   test3@test.com / 12345678
