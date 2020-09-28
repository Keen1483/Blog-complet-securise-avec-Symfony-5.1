# Blog-complet-securise-avec-Symfony-5.1
Registration et login; création, explorer et commenter les articles avec images

Instructions pour mettre la base de données sur pied :
1 - Ouvrez l'invite de commande
2 - Rendez-vous dans le repertoire du projet
3 - Exécutez la commande: php bin/console doctrine:migrations:migrate

Instructions pour charger des jeux de fausses données pour faire fonctionner le blog
1 - Ouvrez l'invite de commande
2 - Rendez-vous dans le repertoire du projet
3 - Exécuter la commande: php bin/console doctrine:fixtures:load

A présent, exécutez la commande:
php bin/console server:run

Laissez tourner le server et ouvrez votre navigateur à la page http://127.0.0.1:8000

Votre blog est opérationnel. Merci, cordialement.
