# ztpai
GameCritic project 

# Running the project 
All the commands shown assume you are in the root of the project.
## Database
Use the following commands to start the database
```
cd App
docker-compose -f docker-compose.yml up -d
```

## Symfony
Use the following commands to start the symfony server
```
cd App
composer install
php bin/console doctrine:migrations:migrate

php bin/console lexik:jwt:generate-keypair

symfony server:start -d
```

## Angular
Use the following commands to start the angular server
```
cd Front
npm install
ng serve
```