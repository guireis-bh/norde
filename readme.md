## Projeto SSX - Norde

### Sobre o projeto

O projeto está sendo desenvolvido em [Laravel 5.5](https://laravel.com/docs/5.5/) com [VueJS V2](https://vuejs.org/v2/api/).  Para desenvolvimento, recomendo [Laradock](https://laradock.io/) com PHP 7.0. Também recomendo utilizar a versão 10.15.03 do NodeJS.

### Executando o deploy

Os passos para a execução do deploy, são simples, porem, há a necessidade de atenção.

Os passos abaixo, deverão ser utilizados apenas na primeira versão de desenvolvimento do MVP. Após o fechamento do MVP, esses passos serão atualizados
- Limpar o DB (Exclua todas as tabelas e registros)
- Limpar o diretório
```bash
git clean -xdf
```
- Baixando a última versão
```bash
git fetch --tags
git tag #Lista as versões disponiveis
```
- De um checkout na ultima versão disponivel
```bash
git checkout v0.0.0 #Ultima versão
```
- Instale as dependências do PHP
```bash
composer install --verbose
```
- Configure o DotEnv
```bash
cp .env-example .env
php artisan key:generate
vim .env
```
Configurações básicas do DotEnv
```env
APP_NAME=Norde
APP_ENV=production
APP_KEY=your-key-generated
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=https://sys.norde.com.br

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
- Rodando a Migrations e Seeds para criar as tabelas e populalas com os valores padrões
```bash
php artisan migrate
php artisan db:seed
```
- Instalando e configurando o Laravel Passport
```bash
php artisan passport:install
php artisan passport:client --password
```
- Adicione o ID e a Secret geradas no passport client --password ao seu DotEnv
```env
CLIENT_ID=1
CLIENT_SECRET=secret
 ```
- Crie um usuário administrativo
```bash
php artisan tinker
```
```php
// Command line do tinker
$user = new User
$user->name = 'Admin'
$user->email = 'admin@mail.com'
$user->password = Hash::make('qwerty')
$user->save()
$user->assignRole('superuser')
```
- Instalando e publicando as dependencias Javascript
```bash
npm install --verbose
npm run prod
```
- Pronto!!

Se tudo correu corretamente, você já está com uma instância do projeto Norde funcionando