docker run --rm -it -v "$(pwd):/app" composer init
docker run --rm -it -v "$(pwd):/app" composer require slim/slim
docker run --rm -it -v "$(pwd):/app" composer require firebase/php-jwt
docker run --rm -it -v "$(pwd):/app" composer require selective/basepath
docker run --rm -it -v "$(pwd):/app" composer install
docker run --rm -it -v "$(pwd):/app" composer dump-autoload
docker run --rm -it -v "$(pwd):/app" -p 8080:8080 composer start

docker run --rm -it -v "$(pwd):/app" -p 8080:8080 php:7.4-cli -S 0.0.0.0:8080 -t /app/public

curl -H "Authorization: " http://localhost:8080/api/v1/employees

curl --location --request GET 'http://localhost:8080/api/v1/employees' \
--header 'Authorization: Bearer yourToken' \
--header 'Content-Type: application/json'

curl --location --request POST 'http://localhost:8080/login' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username":"admin",
    "password":"1234"
}'