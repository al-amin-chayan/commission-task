# Commission Task
A company allows private and business clients to deposit and withdraw funds to and from company accounts in multiple currencies. Clients may be charged a commission fee.

We have to create an application that handles operations provided in CSV format and calculates a commission fee based on defined rules.


## How to Install

Run the following commands in composer:

```
- git clone git@github.com:alamin-chayan/commission-task.git
- cd commission-task
- composer install
```

## Install using Docker

If you do not have php 8.1 image available in your machine, you can install it viz docker

```
// Clone Project
- git clone git@github.com:alamin-chayan/commission-task.git
- cd commission-task

// Build Docker Image
- docker-compose build
- docker-compose up -d
- docker-compose exec php /bin/bash

// Install Composer Dependecies
- composer install
```
### Available Commands
```
// Run script
- php script.php input.csv

// Run testcases
- composer run phpunit

// Fix CS
- composer run fix-cs
```
