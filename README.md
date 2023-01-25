# satisfatction-surveyV2

French Satisfaction Survey Made By Johan Goutorbe For The Society Office Center The 01/25/2023

## Table des Matières
1. [Fonctionnement](#Fonctionnement)
2. [Prérequis](#Prérequis)


### Fonctionnement

Cette page PHP utilise la méthode GET pour récupérer les paramètres d'une URL, qui sont ensuite vérifiés pour leur validité. Ces paramètres comprennent un numéro d'intervention, le nom d'un technicien, une date, un choix de notation et une adresse e-mail. Si tous les paramètres sont valides, une requête est effectuée pour enregistrer les informations dans une base de données MySQL. Sinon, des messages d'erreur sont affichés pour indiquer les paramètres incorrects. La page utilise également la classe PDO pour se connecter à la base de données.

### Prérequis

