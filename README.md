=============================
-------- FirsSalud ----------
=============================


Bienvenidos al proyecto MEDIC

➜ Para poder levantar el proyecto deberan clonar el repositorio y utilizar el mismo docker.
➜ Para clonar el repositorio deben entrar a GitHub y agregar su clave SSH o Token
➜ A continuacion los pasos para establecer la configuracion SSH

1) Abrimos una terminal y ejecutamos los siguientes comandos;
➜ cd .ssh
➜ ls -a
➜ ssh cat id_rsa.pub 

2) Copiamos todo el codigo y lo pegamos dentro de las configutaciones de GitHub; 
➜ setting 
➜ SSH
➜ New SSH


3) Para poder levantar el proyecto deberan crear un directorio (carpeta) en su equipo y dentro de el deberan guardar;
➜ DockerFile
➜ Docker-Compose.yml

4) Ejecutar el comando;
➜ docker-compose up -d --build
➜ Este comando inicia los servicios definidos en tu archivo docker-compose.yml, construye las imágenes si hay cambios en los
➜ archivos de construcción, y luego ejecuta los servicios en segundo plano.
➜ Asegurense de ejecutar este comando desde el mismo directorio en el que se encuentra tu archivo docker-compose.yml
➜ Luego de ejecutar el comando veran que dentro del directorio se crearon 3 directorios. Deberan clonar el proyecto dentro
➜ del directorio html.
➜ Los archivos DockerFile & Docker-Compose.yml se enviaran por privado.


5) Clonar el repositorio
➜ Navegar desde la terminal mediante el comando "cd" hasta el directorio html y ejecutar el comando;
➜ git clone git@github.com:Practicas-Profesionalizantes-2023/FirsSalud.git

6) Luego de clonar el repositorio;
➜ Deberan Crear el directorio "data" dentro de sitio dentro de "data" guardar los archivos;
➜ .txt
➜ .env

7) Registro
➜ Podra registrarse mediante usuario y contraseña
➜ Le llegara un correo de confirmacion a su email

8) Iniciar Sesion;
➜ Admin
➜ User: admin@mail.com
➜ Pass: 123456

➜ Paciente
➜ User: paciente@mail.com
➜ Pass: 123456

➜ Doctor
➜ User: doctor@mail.com
➜ Pass: 123456
