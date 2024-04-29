# LiaStore
Este es nuestra pagina web LiaStore que creamos utilizando el framework de **#Laravel versión 10.10#** y diseñamos con Bootstrap.

## Integrantes
- Julio Emmanuel Romero Beltrán [__@JulioRomeroBeltran__][1]
- Eva Estefani Diaz Beltrán [__@EstefanDiaz__][2]
- Luis Antonio Burgos Rojas [__@LuisBurgos9751__][3]
- Jesus Javier Camacho Castro [__@JavierCamacho9703__][4]

[1]: https://github.com/JulioRomeroBeltran
[2]: https://github.com/EstefanDiaz
[3]: https://github.com/LuisBurgos9751
[4]: https://github.com/JavierCamacho9703


## Elementos necesarios para que funcione el programa
__-PhP 8.2.11__ // si te da error "error Call to undefined function Illuminate\Encryption\openssl_cipher_iv_length()"  debes quitar un ; en el php.ini, en donde dice ;extension=openssl, la version de PhP viene en el composer.json

__-Composer__ // Para usar ````composer install````


__-Node.js/npm__ // Para usar ````npm install````


__-MySQL 8.1.0__ 


 ## Base de datos
**IMPORTANTE, SE ESTA USANDO DOCKER PARA USAR LA BASE DE DATOS**
 
Dentro de la carpeta **docker-bdd** dejaré los archivos correspondientes para ya pasarle una base de datos con información dentro, viene el docker-compose.yml y el volumen.

-El docker-compose.yml es para montar el contenedor.

-El mysql_liastore.tar.zst es el volumen para obtener todos los datos de la base de datos, para ello es necesario tener la extensión **Volumes Backup & Share** en la aplicacion de **Docker Desktop**

-Configura el archivo .env para que se conecte a tu base de datos. Deberia ser la base de datos liastoredb4 contraseña liastoredb.


## Como ejecutar la pagina
-Ejecute el comando. ````php artisan serve````

-Y en otra terminal el comando. ````npm run dev````

-NOTA: Si no se ven las imagenes tiene que ejecutar este comando. ````php artisan storage:link````

-Si quiere entrar en una cuenta con administrador use estas credenciales. 

-Correo:**mrgatogamer5@gmail.com**  Contraseña:**Admin12345**.
