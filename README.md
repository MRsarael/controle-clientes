<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Sobre o projeto

API de um CRUD de controle de clientes e placas veiculares.

## Passos para configurar o projeto para teste

```bash
git clone https://github.com/MRsarael/controle-clientes.git
composer install
php artisan key:generate
composer dump-autoload
OBS: Será necessário criar um banco de dados 'clientes' e configurar o acesso no arquivo .env
php artisan migrate
```

## Rotas disponíveis

| Rota                   | Método    | Descrição                             |
| ---------------------- | --------- | ------------------------------------- |
|`/cliente/`             | `GET`     | Lista todos os clientes               |
|`/cliente/`             | `POST`    | Cadastra um cliente                   |
|`/cliente/{id}`         | `GET`     | Consulta cliente específico           |
|`/cliente/{id}`         | `PUT`     | Atualiza dados de cliente específico  |
|`/cliente/{id}`         | `DELETE`  | Remove um cliente                     |
|`/final-placa/{numero}` | `GET`     | Consulta clientes pelo final da placa |

## Link collection Postman
