<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



# APIS-USER
Apis desarrollada para la autenticación de usuario y administracion de los mismos pemitiendole asignarle Roles y permisos a los usuarios. Es un proyecto desarrrollado como parte de mi aprendizaje del popular framework de PHP de Laravel 

## Requisitos
Para instalar y usar este proyecto, necesitas tener lo siguiente:

- PHP 8.0 o superior
- Laravel 11.x o superior
- Composer
- POSTGRESQL o cualquier otro sistema de gestión de bases de datos compatible con Laravel

Puedes consultar la [documentación oficial de Laravel](^1^) para más información sobre cómo instalar y configurar Laravel.

## Instalación
Para instalar este proyecto en tu entorno local, sigue estos pasos:

- Clona este repositorio:    `git clone https://github.com/Jeanniert/apis-user.git`

- abrimos el proyecto:     `cd apis-user`

- Instala las dependencias:    `composer install`

- Crea un archivo .env y copia el contenido del archivo .env.example:    `cp .env.example .env`

- Genera la clave de la aplicación:    `php artisan key:generate`

- Configura la conexión a la base de datos en el archivo .env, indicando el nombre, el usuario, la contraseña y el puerto de tu base de datos.

- Migra la base de datos y ejecutar seeder:    `php artisan migrate:fresh --seed`

- Ejecuta el servidor:    `php artisan serve`

- Abre http://localhost:8000 o en su defecto http://127.0.0.1:8000


## Documentacion de la Apis:

### Auth

| Method   | URL                                      | Description                              |
| -------- | ---------------------------------------- | ---------------------------------------- |
| `POST`   | `/api/auth/login`                        | Sign in.                        |
| `GET`    | `/api/v1/logout`                           | Sign in (you must be logged in to use this endpoint.).                    |



### Roles

| Method   | URL                                      | Description                              |
| -------- | ---------------------------------------- | ---------------------------------------- |
| `GET`    | `/api/v1/roles`                           | Retrieve all role.                    |
| `POST`   | `/api/v1/roles`                             | Create a new role.                    |
| `PUT`    | `/api/v1/roles/{id}`                        | Update data role.                     |
| `DELETE` | `/api/v1/roles/{id}`                        | Delete role .                    |



### Permissions

| Method   | URL                                      | Description                              |
| -------- | ---------------------------------------- | ---------------------------------------- |
| `GET`    | `/api/v1/permissions`                           | Retrieve all permission.                    |
| `POST`   | `/api/v1/permissions`                             | Create a new permission.                    |
| `PUT`    | `/api/v1/permissions/{id}`                        | Update data permission.                     |
| `DELETE` | `/api/v1/permissions/{id}`                        | Delete permission .                    |


### Users

| Method   | URL                                      | Description                              |
| -------- | ---------------------------------------- | ---------------------------------------- |
| `GET`    | `/api/v1/users`                           | Retrieve all user.                    |
| `POST`   | `/api/v1/users`                             | Create a new user.                    |
| `PUT`    | `/api/v1/users/{id}`                        | Update data user.                     |
| `DELETE` | `/api/v1/users/{id}`                        | Delete user .                    |
