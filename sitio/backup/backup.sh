#!/bin/bash
# Incluye el archivo que contiene las variables de entorno
export $(cat /home/christian/proyecto/Base_de_Datos/clasesdb/.env | xargs)

# Directorio de destino para las copias de seguridad
backup_dir="/home/christian/proyecto/Base_de_Datos/clasesdb/html/FirsSalud/sitio/backup"
backup_dir2="/home/christian/proyecto/Base_de_Datos/clasesdb/html/FirsSalud/sitio/backup-respaldo"

# Nombre del archivo de copia de seguridad (incluyendo la fecha)
backup_file="$backup_dir/backup-$(date +\%Y-\%m-\%d_\%H:\%M).sql"
backup_file2="$backup_dir2/backup-$(date +\%Y-\%m-\%d_\%H:\%M).sql"



# Comando para realizar la copia de seguridad de la base de datos en el contenedor MySQL
docker exec mysql mysqldump -h "$PMA_HOST" -u "$MYSQL_USER" -p"$MYSQL_ROOT_PASSWORD" --databases medic > "$backup_file"
docker exec mysql mysqldump -h "$PMA_HOST" -u "$MYSQL_USER" -p"$MYSQL_ROOT_PASSWORD" --databases medic > "$backup_file2"

# Imprime las variables de entorno para depurar
echo "Valor de DB_SERVER: $PMA_HOST"
echo "Valor de DB_USER: $MYSQL_USER"
echo "Valor de DB_PASS: $MYSQL_ROOT_PASSWORD"

# Comprimir la copia de seguridad en un archivo ZIP con el mismo nombre
zip -j "$backup_file.zip" "$backup_file"
zip -j "$backup_file2.zip" "$backup_file2"

# Eliminar la copia de seguridad original (opcional)
rm "$backup_file"
rm "$backup_file2"

# Eliminar archivos de copias de seguridad con más de 30 días de antigüedad
find "$backup_dir" -type f -name "backup-*.sql.zip" -mtime +30 -exec rm {} \;
find "$backup_dir2" -type f -name "backup-*.sql.zip" -mtime +30 -exec rm {} \;

#!/bin/bash

# Define la programación cron cada 1 minuto
cron_job="0 18 * * * /bin/bash /home/christian/proyecto/Base_de_Datos/clasesdb/html/FirsSalud/sitio/backup/backup.sh"

# Lista las tareas cron actuales
current_cron_jobs=$(crontab -l)

# Verifica si la entrada cron ya existe
if [[ $current_cron_jobs == *"$cron_job"* ]]; then
    echo "La entrada cron ya existe."
else
    # Agrega la nueva entrada cron
    (crontab -l; echo "$cron_job") | crontab -
    echo "Nueva entrada cron agregada."
fi

# Prueba
# Eliminar archivos de copias de seguridad con más de 1 minuto de antigüedad
# find "$backup_dir" -type f -name "backup-*.sql.zip" -mmin +1 -exec rm {} \;
