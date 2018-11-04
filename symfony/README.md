# 1. Principe de l'appli : webservice
Vous devez réaliser un Web Service en langage PHP qui permet de récupérer les informations d’un « adhérent » à partir de son « identifiant ». Les données (liste des adhérents) sont stockées dans un fichier CSV.

# 2.1 test1 : http://localhost/test1
récupérer en json les données d'un fichier .csv et les renvoyer
* en totalité via l'URL http://localhost/test1 => renvoie en json les données du fichier csv
* les données d'une seule ligne en passant son id via http://localhost/test1/6 (ou autre identifiant) => renvoie en json les données de la ligne correspondant à l'id séléctionné
* si id inexistant un message spécifique via http://localhost/test1/9 (ou autre identififiant non existant) 
# 2.2 test2 : http://localhost/test2 
récupérer les données d'un fichier avec le compte du nombre de lignes
* en totalité via l'URL http://localhost/test2  => renvoie en json le compte des lignes et les données du fichier csv 
* tester la meme URL avec un fichier vide pour avoir un message spécifique en json
* tester la meme URL avec certaines données vides ou un ligne entière vide
* tester la meme URL avec une absence de fichier
le fichier csv est hébergé dans public/cvs/donnees.csv
# 2.3 test3 : http://localhost/test3
affichage du résultat sous forme lisible (template et plus json)
# 2.4 test4 : http://localhost/test4  => non fonctionnel
affichage du résultat sous template via récupération des données dans un appel curl 
# 2.5 test5 : http://localhost/test5
affichage du résultat sous tempplate via récupération des données dans un appel d'un controller de la même appli sous forme de service
# 2.6 test6 : http://localhost/test6
affichage du résultat sous template via récupération des données dans un appel ajax inclus dans le template qui appelle  un controller de la même appli (nécessite un 2eme controller/template pour les données à rafraichir)

RAF
```
* passer les routes et paramètres en annotation
* debugger test4 l'appel curl qui ne passe pas à cause d'une config docker
* tester les commandes
* enregistrer les données en base 
* rafraichir les données en base
* utiliser les "command" pour importer le fichier csv en base 
* fixer les version dev du composer.json sur des vraies versions

Propositions
* authentification avec token
* vérification des en-tetes de colonne avec message spécifique
# usefull tools
```


