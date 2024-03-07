# FirsSalud

## Bienvenidos al proyecto MEDIC

Para levantar el proyecto, deben clonar el repositorio y utilizar el mismo Docker.

1. Clonar el repositorio en GitHub utilizando su clave SSH o Token.

2. **Configurar SSH:**

   Abrir una terminal y ejecutar los siguientes comandos:

   ```bash
   cd .ssh
   ls -a
   ssh cat id_rsa.pub
   
###Copiar todo el código y pegarlo en las configuraciones de GitHub en Settings -> SSH -> New SSH.

###Crear un directorio en su equipo y guardar dentro de él:

- DockerFile
- Docker-Compose.yml
  
**Ejecutar el siguiente comando:**

- docker-compose up -d --build
Este comando inicia los servicios definidos en docker-compose.yml, construye las imágenes si hay cambios y ejecuta los servicios en segundo plano. Asegurarse de ejecutarlo desde el mismo directorio que docker-compose.yml.

Después de ejecutar el comando, se crearán 3 directorios. Clonar el proyecto dentro del directorio html.

Clonar el repositorio
Desde la terminal, navegar al directorio html y ejecutar:

git clone git@github.com:Practicas-Profesionalizantes-2023/FirsSalud.git
Después de clonar el repositorio, crear el directorio data dentro de sitio y guardar dentro de data los archivos:

.txt
.env

Registrarse mediante usuario y contraseña. Se enviará un correo de confirmación al email.

### Iniciar Sesión

- **Admin:**
  - User: admin@mail.com
  - Pass: 123456

- **Paciente:**
  - User: paciente@mail.com
  - Pass: 123456

- **Doctor:**
  - User: doctor@mail.com
  - Pass: 123456
