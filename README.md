## Configuração do Docker para Laravel

Este projeto fornece uma aplicação Laravel Dockerizada com MySQL.

### Requisitos

- Docker
- Docker Compose

### Configuração

Clone o repositório:

```
git clone https://github.com/drusco/teste-logcomex
```

Acesse o diretório do projeto:

```
cd teste-logcomex
```

Crie seu arquivo de ambiente:

```
cp laravel-app/.env.example laravel-app/.env
```

Construa e inicie a aplicação:

```
docker-compose up --build -d
```

Instalar as dependencias
```
docker exec -it laravel_app composer install
```

Configurar permissões em diretórios

```
docker exec -it laravel_app bash -c "chown -R www-data:www-data /var/www/laravel-app/storage /var/www/laravel-app/bootstrap/cache && chmod -R 775 /var/www/laravel-app/storage /var/www/laravel-app/bootstrap/cache"

```

Gerar encription key

```
docker exec -it laravel_app php artisan key:generate
```

Execute as migrações (aguarde até o MySQL estar totalmente em execução):

```
docker exec -it laravel_app php artisan migrate
```

Importe os pokémons usando o comando artisan:

```
docker exec -it laravel_app php artisan app:import-pokemons
```

### RESTful API

- Listar pokémons utilizando paginação padrão:

```
GET http://localhost:9000/api/pokemon
```

- Pesquisar pelo nome, tipo ou ambos

```
GET http://localhost:9000/api/pokemon/?nome=bulbasaur&tipo=grass
```

- Ver detalhes de um pokémon:

```
GET http://localhost:9000/api/pokemon/{id}
```

