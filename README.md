# pwii-thiago-nestor
Aula de Programação Web II com os Professores João Siles e Ricardo Palhares 

# Manual Definitivo: Do Zero ao Primeiro Projeto **Laravel**

---

##  DISCLAIMER / CHECKLIST — **ANTES DE INICIAR (PHP & XAMPP)**

Se você pretende usar **XAMPP (Windows)**, faça **TUDO** abaixo **antes** do `composer create-project`:

1. **Instale o XAMPP compatível com PHP ≥ 8.2**  
   - Baixe em: <https://www.apachefriends.org/>  
   - No **XAMPP Control Panel**, **inicie** _Apache_ e _MySQL_.

2. **Garanta que o PHP de linha de comando (CLI) é o do XAMPP** (ou use WSL2).  
   - No PowerShell:  
     ```powershell
     where php
     php -v
     ```
   - Se aparecer outro PHP primeiro na `PATH`, ajuste a ordem da variável `Path` ou chame explicitamente `C:\xampp\php\php.exe`.
   - Alternativa recomendada: **WSL2 + Docker + Laravel Sail** (isola ambiente). Docs: <https://laravel.com/docs/12.x/sail>

3. **Ative/extensões necessárias no `php.ini` do XAMPP** (geralmente já ativas, mas confira):  
   - **openssl**, **mbstring**, **pdo_mysql**, **curl**, **fileinfo**, **ctype**, **xml**, **bcmath**.  
   - Abra `C:\xampp\php\php.ini`, localize linhas como `;extension=mbstring` e **remova o `;`** para ativar. Reinicie o Apache e teste com `phpinfo()`.  
   - PHP docs (enabling extensions): <https://www.php.net/manual/en/install.pecl.windows.php>  
   - mbstring: <https://www.php.net/manual/en/mbstring.installation.php>

4. **Ative `mod_rewrite` no Apache** (URLs amigáveis do Laravel):  
   - Em `C:\xampp\apache\conf\httpd.conf`, garanta:
     ```apache
     LoadModule rewrite_module modules/mod_rewrite.so
     AllowOverride All
     ```
   - Reinicie o Apache. Referência oficial do Apache: <https://httpd.apache.org/docs/current/mod/mod_rewrite.html>

5. **Defina `date.timezone` no `php.ini`** (evita avisos de fuso horário):
   ```ini
   date.timezone = America/Sao_Paulo
   ```

6. **Crie um banco no phpMyAdmin (opcional, se for usar MySQL/MariaDB)**  
   - Acesse <http://localhost/phpmyadmin>, crie o DB (ex.: `meubanco`) com collation `utf8mb4_unicode_ci`.

7. **Instale o Composer** e verifique que o binário correto está na PATH:  
   - Windows: <https://getcomposer.org/download/> (use o installer).  
   - Teste: `composer -V`

>  **Alternativa sem XAMPP**: **Docker + Sail** (macOS/Windows/Linux). Evita conflitos de versão e ativa serviços (MySQL, Redis) automaticamente. Docs: <https://laravel.com/docs/12.x/sail>

### Verifique as versões instaladas
```bash
php -v
composer -V
npm -v
```

Se algum comando não funcionar, revise a instalação.

------------------------------------------------------------------------------------------------------------------------------------------------

## Criar um Projeto Laravel Novo

1. Crie o projeto na pasta desejada:
```bash
composer create-project laravel/laravel nome-projeto
cd nome-projeto
```

2. Copie o arquivo `.env` e gere a chave da aplicação:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configure o banco de dados no `.env`:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meubanco
DB_USERNAME=root
DB_PASSWORD=
```

4. Rode as migrations:
```bash
php artisan migrate
```

5. Suba o servidor:
```bash
php artisan serve
```
➡️ Acesse: http://127.0.0.1:8000

------------------------------------------------------------------------------------------------------------------------------------------------

## Baixar e Rodar um Projeto Laravel Existente

Se você recebeu um projeto pronto (ex.: do GitHub):

1. Clone o repositório:
```bash
git clone link-do-repositorio
cd nome-projeto
```

2. Instale as dependências do backend:
```bash
composer install
```

3. Instale e compile dependências do frontend:
```bash
npm install
npm run build
```

4. Copie e configure o `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure o banco de dados no `.env` e rode:
```bash
php artisan migrate
```

6. Corrija permissões (se necessário):
```bash
chmod -R 775 storage bootstrap/cache
```

7. Suba o servidor:
```bash
php artisan serve
```

------------------------------------------------------------------------------------------------------------------------------------------------

## Estrutura Básica do Projeto Laravel

- **routes/web.php** → onde ficam as rotas.  
- **app/Models** → classes que representam tabelas do banco.  
- **app/Http/Controllers** → lógica da aplicação.  
- **resources/views** → páginas (Blade).  
- **database/migrations** → versões do banco de dados.  
