# Rendu final

## Objectif

Developper une application de gestion de stock avec PHP MySQL et le pattern MVC.

## Features:

- Systeme de connexion avec sessions
- CRUD sur les produits
- CRUD sur les categories
- CRUD sur les utilisateurs
- CRUD sur les commandes
- Acces admin/utilisateur avec des permissions differentes
- Systeme de pagination pour les produits si besoin
- Systeme de recherche filtree pour les produits
- Dashboard avec des statistiques sur les produits, categories, utilisateurs et commandes

## Technologies

- utilsation de PHP 8
- utilisation de MySQL (ecriture de requetes SQL)
- PDO et requetes preparees
- Utilisation du pattern MVC

# Features +

- stock bas
- top vente
- produit plus vendu
- chiffre affaire
- total prix marchandise


alter table product
    add constraint product_categories_id_fk
        foreign key (category_id) references categories (id)
            on update cascade on delete cascade;

