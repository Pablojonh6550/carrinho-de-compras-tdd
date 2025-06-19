# 📦 Carrinho-de-compras-tdd

Aplicação desenvolvida com Laravel para o gerenciamento de finanças.

## 🚀 Tecnologias

-   Laravel (v12)
-   React (v19.1)
-   PHP (v8.2)
-   Composer
-   Docker
-   PHPUnit

## ⚙️ Requisitos

-   PHP >= v8.2
-   Composer
-   Node >= 20.\*
-   Npm >= 10.\*
-   Laravel CLI
-   Docker

## 🚧 Instalação

```conf
# Clone o repositório
git clone https://github.com/Pablojonh6550/carrinho-de-compras-tdd.git
cd carrinho-de-compras-tdd

# Copie o arquivo de ambiente
cp .env.example .env

# Suba os containers
docker compose up -d --build
```

-   Lembre-se de carregar as informações da base de dados dentro da .env!

```conf
Campos necessários:
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=mysql-db
    DB_USERNAME=laravel-agent
    DB_PASSWORD=root

    MYSQL_DATABASE=mysql-db
    MYSQL_ROOT_PASSWORD=root
    MYSQL_USER=laravel-agent
    MYSQL_PASSWORD=root
```

## ▶️ Acessos

-   Aplicação (local): http://localhost:8000 (nginx)
-   Container PHP (CLI): docker exec laravel-app bash
-   Container Node (CLI): docker exec node-frontend bash
-   Banco de dados: acessível pela porta configurada no .env (DB_PORT)

## 🧪 Testes

-   Localização: `tests/Unit/`

```conf
docker exec -it laravel-app php artisan test
# ou
docker-compose exec -it laravel-app ./vendor/bin/phpunit

```

## 📌 Rotas Api

| Método | Rota         | Descrição                                  |
| ------ | ------------ | ------------------------------------------ |
| POST   | /cart/finish | Envia os dados de finalização do pagamento |

## 🐞 Logs, Erros e Debug

Os erros são registrados em `storage/logs/laravel.log`.

Utilize `Log::error()` ou `report()` para registrar exceções.

## 🧰 Comandos Úteis

```conf
# Limpar caches
docker exec -it easy-wallet-app /bin/bash php artisan config:clear
docker exec -it easy-wallet-app php artisan route:clear
docker exec -it easy-wallet-app php artisan cache:clear

# Caso as chaves não sejam geradas
# Gerar a chave da aplicação
docker exec -it easy-wallet-app php artisan key:generate


# Caso o banco não seja populado
# Executar as migrações do banco de dados
docker exec -it easy-wallet-app php artisan migrate --seed
```

## 🧾 Licença

Este projeto está licenciado sob a MIT License.
