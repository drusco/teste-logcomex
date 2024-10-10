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
cp .env.example .env
```

Construa e inicie a aplicação:

```
docker-compose up --build -d
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

- Ver detalhes de um pokémon:

```
GET http://localhost:9000/api/pokemon/{id}
```
