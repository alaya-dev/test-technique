
I-Guide Détaillé pour Exécuter l'application localement : 
1. Cloner le Répertoire
Ouvrez le terminal et clonez le répertoire du projet :

 ***********************

git clone https://github.com/alaya-dev/test-technique.git
cd test-technique

************************
2. Installer les Dépendances
Assurez-vous que Composer et Node.js sont installés, puis exécutez :

 ***********************

composer install

npm install

npm run dev
*****************************
3. Configurer l'Environnement
Copiez le fichier .env.example en .env et configurez-le :

 ***********************

cp .env.example .env


php artisan key:generate

***********************
4. Configurer MySQL
Mettez à jour votre fichier .env avec vos identifiants MySQL :


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_bd
DB_USERNAME=root
DB_PASSWORD=


5. Configurer la Base de Données:
Assurez-vous que MySQL est en cours d'exécution, puis exécutez :

************************
php artisan migrate --seed
****************************

6. Exécuter l'Application :
Démarrez le serveur de développement Laravel :

***********************
php artisan serve
*******************

II-Guide  pour Exécuter l'application sur docker : 

Assurez-vous que Docker Desktop est installé et en cours d'exécution 

1-Ouvrez le terminal et executez la commande suivante 
********************************
docker-compose up -d
**********************************
2-tapez l'url "localhost:8000" sur le navigateur



