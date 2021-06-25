# computing_cluster

### Project by subject:
### ***Distributed information systems design technologies***
### Shitikov Dmitrii

### Installation
#### run rabbitmq from docker
```
sudo docker-compose up --build -d
```
#### to remove docker run
```
sudo docker-compose down --remove-orphans
```
#### run composer
```
cd sender
composer install
cd ../receiver
composer install
cd ..
```
#### create .env
```
cp .env.example .env
```
#### run sender consumer
```
php sender/app/console/rabbitmq/consumer.php
```
#### run receiver consumer
```
php receiver/app/console/rabbitmq/consumer.php
```

### Usage
#### Send tasks
```
php sender/app/console/rabbitmq/producer.php
```
#### You can specify the number of tasks. For example 20
```
php sender/app/console/rabbitmq/producer.php 20
```
#### View sent tasks
```
less sender/logs/send_task.log
```
#### View completed tasks
```
less sender/logs/get_result.log
```
#### To speed up the work, you can launch multiple receiver instances
```
php receiver/app/console/rabbitmq/consumer.php
```
