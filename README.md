
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

1- Aprés avoir cloner le repo mettez à jour votre fichier .env (DB_HOST = db au lieu 127.0.0.1) :


DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=nom_de_votre_bd
DB_USERNAME=root
DB_PASSWORD=


2- Ouvrez le terminal et executez la commande suivante 
********************************
docker-compose up -d
**********************************
 
3-Tapez l'url "localhost:8000" sur le navigateur
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
III-Guide d'Utilisation de l'Application

1. Connexion
Pour vous connecter à l'application, utilisez les informations suivantes créées via le fichier app\database\seeders\LeaderSeeder.php :
Email : 3leya21@gmail.com
Mot de passe : 12345678

2. Tableau de Bord du Leader
Après la connexion, le leader sera dirigé vers un tableau de bord affichant les statistiques des tâches. Sur la gauche, il trouvera une barre de navigation (navbar) avec les options suivantes :
Gestion des utilisateurs(membres)
Gestion des tâches
Déconnexion

3. Gestion des Tâches

Lorsque le leader affecte une tâche à un utilisateur ou modifie une tâche affectée, l'utilisateur sera notifié par email.

Pour les membres : Après la connexion, l'utilisateur verra une liste de tâches. Les tâches incomplètes seront affichées avec le statut "en attente". Lorsqu'un utilisateur termine une tâche, il doit cliquer sur le statut de cette tâche pour le transformer en "terminée". À ce moment, l'administrateur sera notifié par email que la tâche est terminée.

Le leader et les membres recevront quotidiennement un rappel des tâches incomplètes via email.

///////////////////////////////////////////////////////////////////////
IV- configuration de service email

Mettez à jour votre fichier .env  :
PAR EXEMPLE:

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=3leya21@gmail.com
MAIL_PASSWORD=onldraxuvmtswuwm   #mot de passe de l'application 
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="3leya21@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"


V-Fichiers de Log
Les fichiers de log de l'application se trouvent dans le répertoire storage/logs. Vous trouverez principalement trois fichiers de log :

statistics.log : Contient les logs liés aux statistiques des tâches.
task_management.log : Contient les logs liés à la gestion des tâches.
user_management.log : Contient les logs liés à la gestion des utilisateurs.
Ces fichiers peuvent être consultés pour diagnostiquer les problèmes ou vérifier les activités de l'application.




