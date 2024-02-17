# API Prueba

API en Laravel utilizando autenticación Sanctum
- 1 CRUD Tareas (Tasks)

Instalación:

1) Crear una base de datos mysql

2) Clonar o descargar el proyecto en el directorio de tu servidor web

3) Acceder mediante terminal a la carpeta del proyecto

4) Ejecutar:  <b>Composer install</b>

5) Crear el archivo .env con los comandos: <b> cp .env.example .env</b>

7) En el archivo .env colocar el nombre de la base de datos


## Columnas de la tabla usuarios (users)
- id 
- name 
- email
- password

## Columnas de la tabla tareas (tasks)
- id 
- title 
- description
- done
- user_id
