# Ponto

Registro de ponto de monitores das salas Pró-Aluno.
## Funcionalidades

* Registro de ponto com foto.

### Em produção

Para receber as últimas atualizações do sistema rode:

    git pull
    composer install --no-dev
    php artisan migrate


## Instalação

### Básico

    git clone git@github.com:uspdev/ponto
    composer install
    cp .env.example .env
    php artisan key:generate

### Senha única

Cadastre uma nova URL no configurador de senha única utilizando o caminho https://seu_app/callback. Guarde o callback_id para colocar no arquivo .env.

### Banco de dados

* DEV

    `php artisan migrate:fresh --seed`

* Produção

    `php artisan migrate`

## Histórico

14/06/2022 - Exibindo informações e foto do registro
31/05/2022 - Código da sala de monitoria parametrizado
