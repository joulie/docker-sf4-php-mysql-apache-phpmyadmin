# 1. Principe de l'appli : webservice
Vous devez réaliser un Web Service en langage PHP qui permet de récupérer les informations d’un « adhérent » à partir de son « identifiant ». Les données (liste des adhérents) sont stockées dans un fichier CSV.

# 2. choix  du framework et des composants
Symfony 4.1 : j'aime symfony et je n'avais pas testé la V4
choix d'une API REST : plus lisible que SOAP
MVC : 
* model : src/Entity/Userlabels.php
* vue : une homepage index.html.twig et gestion custom des 404 : templates\bundles\TwigBundle\Exception\error404.html.twig
* Controller : src/Controller/CsvController.php

# 3. pré-requis 
* apache2
* php 7.1

# 4.1. installation avec .zip (demandé dans les specifications): 
* copier le fichier AJE.zip fourni dans le mail à la racine www de votre serveur apache
* décompresser ce fichier et supprimer l'archive AJE.zip

# 4.2. installation via http : 
dans votre répertoire www :
* git clone https://github.com/joulie/demo1.git .
* php composer.phar install
* (Cas 2 : eventuellement si problème avec le .htaccess : php -S 127.0.0.1:8000 -t public)

# 5. éléments réalisés : 
* une homepage qui liste les actions possibles via l'URL http://localhost/
* vous trouverez les résultats du test1 via l'URL http://localhost/test1 : test1.1 via http://localhost/test1/6 (ou autre identifiant) - test1.2 via http://localhost/test1/9 (ou autre identififiant non existant) 
* vous trouverez les résultats du test2 via l'URL http://localhost/test2 : test 2.1 via http://localhost/test2 - test 2.2 avec un fichier .csv vide (hébergé ici dans hardis\public\donnees.csv - test 2.3 en supprimant le fichier.csv

# 6. améliorations non réalisées faute de temps :
* passer les routes et paramètres en annotation
* gérer une mise en page html pour les éléments non Json
* une icone 

# 7. réponses au document : partie 2 – Réflexion
* les choix de conception ont été princiapelement orientés sur le temps imparti et le manque d'information sur l'utilisation de ce webservice
par exemple est-ce que les noms des colonnes sont fixes, est-ce que ça doit servir dans un contexte international, est-ce que l'utisateur peut augmenter le nombre de colonnes 
ou sommes nous dans le cadre d'un ESB qui a un format fixe de réception
* la gestion des erreurs a été orientée temps imparti / réponse au besoin, sans prendre en compte des bonne pratiques comme une mise en page des 404, seul le texte brut est renvoyé
* la création d'une entité a été principalement orientée "spécification en MVC"
* la création d'une homepage a été principalement orientée "spécification en MVC"

# 8. Propositions
* authentification avec token
* vérification des en-tetes de colonne avec message spécifique
* vérification si toute une ligne est vide