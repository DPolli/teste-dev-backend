## Como executar o projeto
- Na pasta do projeto use docker-compose up -d --build para iniciar os containers
- Apos isso rode o comando docker-compose exec app php artisan migrate:fresh --seed
- O usuario de testes é recrutador_estech@gmail.com, e a senha é mecontrata123
- Todas as requisições devem ser JSON