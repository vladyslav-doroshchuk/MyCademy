### Start the container

    docker-compose up -d

### Start migrations

    docker-compose exec php yii migrate
    
### You can then access the application through the following URL:

    http://localhost:8030/group-info/2

### PHPMyAdmin:
    http://localhost:8888/
