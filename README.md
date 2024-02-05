# Ponto

Registro de ponto de monitores das salas Pró-Aluno.

## Funcionalidades

* Registro de ponto com foto.
* Supervisor e autorizador podem acompanhar o ponto das pessoas nos seus grupos. Para isso, após o supervisor ou autorizador logar no sistema, através da rota /senhaunica-users pode-se adicionar essa pessoa à permissão hireárquica **boss**.
* Cálculo de dias úteis.
* Carga horária semanal.
* Feriados através da API Invertexto disponível em https://api.invertexto.com

## Em produção

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
    mkdir storage/app/feriados
    chmod -R 777 storage/app/feriados

### Senha única

Cadastre uma nova URL no configurador de senha única utilizando o caminho https://seu_app/callback. Guarde o callback_id para colocar no arquivo .env.

### Banco de dados

* DEV

    `php artisan migrate:fresh --seed`

* Produção

    `php artisan migrate`

### Exemplos de query que poder ser usados nos grupos

Monitores da sala próaluno:

    SELECT DISTINCT t1.codpes
        FROM BENEFICIOALUCONCEDIDO t1
        INNER JOIN BENEFICIOALUNO t2
        ON t1.codbnfalu = t2.codbnfalu
        AND t1.dtafimccd > GETDATE()
        AND t1.dtacanccd IS NULL
        AND t2.codbnfalu = 32
        AND t1.codslamon = 22

Estagiários da STI FFLCH:

    SELECT codpes FROM LOCALIZAPESSOA 
        WHERE tipvin LIKE 'ESTAGIARIORH' 
        AND codundclg = 8 
        AND sitatl = 'A'
        AND nomabvset = 'SCINFOR-08'

## Histórico

- 15/06/2022 - Mostrando o monitor que está presente no local
- 14/06/2022 - Protegendo os arquivos de imagem
- 14/06/2022 - Exibindo informações e foto do registro
- 31/05/2022 - Código da sala de monitoria parametrizado
- 27/11/2023 - Supervisor e autorizador podem ver o ponto das pessosas nos seus grupos
- 07/12/2023 - Carga horária semanal, feriados, dias úteis e saldo de horas