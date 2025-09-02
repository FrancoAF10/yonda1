## 🚀 PASOS PARA INICIAR EL PROYECTO

1. **Clonar el repositorio** dentro de la carpeta `laragon/www` hacemos clickderecho y seleccionamos git bash here donde ingresaremos el siguiente comando:  
   ```
   git clone <url del repositorio>
   ```
2. **Instalar dependencias con Composer**

- Ubicarse dentro del proyecto con el comando:

```
cd <nombre_del_proyecto>
```
- Instalar dependencias:

```
composer install
```
3. Configurar el archivo **.env** + **Database**
- En este archivo se deben colocar todos los datos necesarios para la conexión a la base de datos:
```
CI_ENVIRONMENT = development

database.default.hostname =
database.default.database =
database.default.username =
database.default.password =
database.default.DBDriver =
database.default.port =

```
- Para hacer que corra correctamente el proyecto se debe importar el backup para traer todos los datos y evitar estar insertando dato por dato de cada tabla.
4. Generar las carpetas de escritura
Debido a que la carpeta writable/ está en .gitignore, debemos asegurarnos de tener las carpetas necesarias ejecutando:
```
mkdir -p writable/cache writable/logs writable/session writable/uploads writable/debugbar
```
5. Vista del Proyecto
- Al haber realizado todos los pasos anteriores, procedemos a darle al boton de **Iniciar Todo** de laragon.
- Por ultimo, ingresamos la ruta de nuestro proyecto 'http://yonda1.test/'.