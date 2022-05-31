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


### Cache (opcional)

Algumas partes podem usar cache ([https://github.com/uspdev/cache](https://github.com/uspdev/cache)). Para utilizá-lo você precisa instalar e configurar o memcached no mesmo servidor da aplicação.

    apt install memcached
    vim /etc/memcached.conf
        I = 5M
        -m 128

    /etc/init.d/memcached restart

### Apache ou nginx

Deve apontar para a <pasta do projeto>/public, assim como qualquer projeto laravel.

No Apache é possivel utilizar a extensão MPM-ITK (http://mpm-itk.sesse.net/) que permite rodar seu Servidor Virtual com usuário próprio. Isso facilita rodar o sistema como um usuário comum e não precisa ajustar as permissões da pasta storage/.

sudo apt install libapache2-mpm-itk
sudo a2enmod mpm_itk
sudo service apache2 restart
Dentro do seu virtualhost coloque

<IfModule mpm_itk_module>
AssignUserId nome_do_usuario nome_do_grupo
</IfModule>

### Senha única

Cadastre uma nova URL no configurador de senha única utilizando o caminho https://seu_app/callback. Guarde o callback_id para colocar no arquivo .env.

### Banco de dados

* DEV

    php artisan migrate:fresh --seed

* Produção

    php artisan migrate

## Histórico

31/05/2022 - Código da sala de monitoria parametrizado

