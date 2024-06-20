# SkyStock

## Description

SkyStock is a web application in php that allow users to manage their stock.

Users can add new products, update them, delete them and see the list of all products.

Admin can :
- create new users, update them, delete them and see the list of all users
- create new categories, update them, delete them and see the list of all categories.

Dashboard is available for users and admin and show the number of products, categories and users the total price of all products and the number of products in stock.

## Installation

1. Clone the repository `git clone https://github.com/Lylixn/isitech_php.git`
2. Go to the project directory `cd isitech_php`
3. Install container `docker compose up -d`
4. Go to localhost:8080
5. Enjoy

## Database

The database is a MySQL database and is created automatically when you run the container.

Table :

- users
- products
- categories
- requests
- recover_token

### Users

| id | username | password | email | role |
|----|----------|----------|-------|------|

### Products

| id | name | price | stock | category_id |
|----|------|-------|-------|------------|

### Categories

| id | name |
|----|------|

### Requests

| id | query |
|----|-------|

### Recover_token

| id | username | token |
|----|----------|-------|

## Features

- Add, update, delete products
- Add, update, delete categories
- Add, update, delete users
- Dashboard
- Recover password

## Technologies

- PHP
- MySQL (MariaDB)
- HTML
- TailwindCSS
- Docker
- Docker-compose
- Apache
- PHPMailer

## Authors

- [Lylixn](https://github.com/Lylixn)