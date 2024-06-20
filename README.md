# SkyStock

Isitech PHP project

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

## Docker

The project is dockerized and use docker-compose to run the container.

The container is composed of 3 services :

- php :  php:8.2-apache
- db : mariadb
- mailcatcher : schickling/mailcatcher

The php service is the main service and is the one that run the application.

The db service is the database service and is used to store the data.

The mailcatcher service is used to catch the mail sent by the application.

| service     | port |
|-------------|------|
| php         | 8080 |
| db          | 3306 |
| mailcatcher | 1080 |


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

## Password hashing

The password are hashed with the PHP function `password_hash` and are verified with the PHP function `password_verify`.

## Recover password

When a user forget his password, he can click on the link "Forgot password" on the login page.

He will be redirected to the recover password page where he can enter his username.

If the username exists, a mail will be sent to the user with a link to reset his password.

The link is valid for 1 use.

When the user click on the link, he will be redirected to the reset password page where he can enter his new password.

`The mail is available in mailcatcher on localhost:1080`

## Home made sql request builder / ORM

The project use a home made sql request builder / ORM to interact with the database.

To make a table create a class that extends the `OrmModel` class and define the table name and the fields with.

To define the table name use the public variable `$table` and to define the fields use the public variable `$column`.

```php
class Categories extends OrmModel
{
    public function __construct()
    {
        $this->table = 'categories';
        $this->columns = [
            new Column('id', 'int', 11, false, true, true),
            new Column('name', 'varchar', 255, false, false, false),
        ];
        
        parent::__construct();
    }
}
```

You can also define constraints with the class Constraints.

```php
$this->columns = [
    new Column('id', 'int', 11, false, true, true),
    new Column('name', 'varchar', 255, false, false, false),
    new Column('price', 'decimal', 10, false, false, false),
    new Column('stock', 'int', 11, false, false, false),
    new Column('category_id', 'int', 11, false, false, false, [
        new Constraint(
            'product_categories_fk',
            ConstraintType::FOREIGN_KEY,
            ['category_id'],
            new Categories(),
            ['id'],
            'CASCADE',
            'CASCADE'
        )
    ]),
];
```

#### Available methods for Models
- delete
- getData
- setData
- update
- save
- drop

To make a request use the `Query` class.

```php
$queryUser = new Query(new Users());
$user = $queryUser
    ->where('id', $_SESSION['user'])
    ->get()
    ->first();

$query = new Query(new \db\models\Product());
$products = $query
    ->where('stock', 10, '<')
    ->get()
    ->arr();

$query = new Query($this);
$result = $query
    ->where('email', $email)
    ->orWhere('username', $email)
    ->get();
```

#### get will return a SearchResult object with the result of the request
- first will return the first result of the request
- arr will return the result as an array

#### available methods for query
- select
- where
- orWhere
- orderBy
- limit
- offset

## Authors

- [Lylixn](https://github.com/Lylixn)