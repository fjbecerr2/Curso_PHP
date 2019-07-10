# Curso_PHP
Curso Unir PHP II [2019]

Accede a la página web oficial de XAMPP.
Descarga la versión de XAMPP que contiene PHP 7.1.
Instala XAMPP.
Accede al archivo de configuración php.ini y cambia la directiva error_reporting indicando el siguiente valor:
E_ALL & ~E_NOTICE & ~E_DEPRECATED

Accede a la web de phpMyAdmin.
Descarga el zip y descomprímelo en una carpeta llamada phpmyadmin dentro de la carpeta pública de tu servidor.
Renombra el archivo config.sample.inc.php por config.inc.php.
Dentro del archivo config.inc.php establece el valor de $cfg['Servers'][$i]['AllowNoPassword'] a true.

