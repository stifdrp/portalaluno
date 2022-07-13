# Sistema Graduação

## Principais funcionalidades

* Solicitação de documentos (implementado)
* Solicitação de Aproveitamento de Estudos no Brasil (pendente)
* Solicitação de Aproveitamento de Estudos no Exterior (pendente)
* Correção de Matrículas (pendente)
* Contagem de Créditos (pendente)

## Requisitos
    1. Base USP replicada;
    2. Servidor web (nginx ou apache);
    3. Servidor de banco de dados (postgresql, mysql);
    4. Algum serviço/servidor de e-mail para envio das comunicações;
    5. Supervisor, serviço para gerenciar a fila de e-mails;

### Instalação

* Via clone do repositório github.com/fearusp/graduacao
```
    git clone git@github.com:fearpusp/graduacao graduacao
    cd graduacao
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    Configure o .env conforme a necessidade
```

* Ou crie um fork do repositório para seu github e depois faça o clone a partir dele
    * Caso faça dessa forma, será necessário verificar atualizações no repositório github.com/fearpusp/graduacao

### Em produção

Para receber as últimas atualizações do sistema rode:

    git pull
    composer install --no-dev


### Autenticação 

Este projeto utiliza o [Senha única](https://github.com/uspdev/senhaunica-socialite), para configurá-lo, cadastre uma nova URL no [site](https://uspdigital.usp.br/adminws/oauthConsumidorAcessar) com a URL https://seu_app/callback. Este callback_id deverá ser inserido no arquivo .env.

### Banco de dados

A utilização do ```--seed ``` é necessário para criação dos registros dos tipos de formulários previstos no sistema:

* Ambiente DEV

    php artisan migrate:fresh --seed

* Ambiente de Produção

    php artisan migrate --seed

### Supervisor 

Gerenciador das filas de envio de e-mail. No Debian/Ubuntu faça instalação com:

    sudo apt install supervisor

Modelo de arquivo de configuração. Como **`root`**, crie o arquivo `/etc/supervisor/conf.d/chamados_queue_worker_default.conf` com o conteúdo abaixo:

    [program:graduacao_queue_worker_default]
    command=/usr/bin/php /home/app/graduacao/artisan queue:listen --queue=default --tries=3 --timeout=60
    process_num=1
    username=app
    numprocs=1
    process_name=%(process_num)s
    priority=999
    autostart=true
    autorestart=unexpected
    startretries=3
    stopsignal=QUIT
    stderr_logfile=/home/app/graduacao/storage/logs/graduacao_queue_worker_default.log

Ajustes necessários:

    command=<ajuste o caminho da aplicação>
    username=<nome do usuário do processo do sistema graduacao>
    stderr_logfile = <aplicacao>/storage/logs/<seu arquivo de log>

Reinicie o **Supervisor**

    sudo supervisorctl reread
    sudo supervisorctl update
    sudo supervisorctl restart all

Este Readme foi inspirado no projeto [Uspdev/Starter](https://github.com/uspdev/starter)