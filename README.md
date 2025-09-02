# pwii-thiago-nestor
Aula de Programação Web II com os Professores João Siles e Ricardo Palhares 

# Manual Definitivo: Do Zero ao Primeiro Projeto **Laravel**

> **Objetivo**: guiar você desde a _instalação_ do PHP/Composer e preparação do ambiente (incluindo **XAMPP**), até a criação de um projeto Laravel funcional com CRUD simples, rodando em servidor local (PHP built‑in, Apache/XAMPP ou Docker via **Sail**).  
> **Público**: iniciantes e intermediários.  
> **Versão**: recomendações alinhadas às docs do **Laravel 12.x** / **11.x** (válidas para hoje). Sempre confira a documentação oficial para requisitos mais recentes.

---

## 🛡️ DISCLAIMER / CHECKLIST — **ANTES DE INICIAR (PHP & XAMPP)**

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

> ✅ **Alternativa sem XAMPP**: **Docker + Sail** (macOS/Windows/Linux). Evita conflitos de versão e ativa serviços (MySQL, Redis) automaticamente. Docs: <https://laravel.com/docs/12.x/sail>

---

## 1) O que você precisa (Requisitos mínimos)

- **PHP**: Laravel 11+ requer **PHP ≥ 8.2** (recomendado 8.2/8.3).  
- **Composer 2.x**  
- **Extensões PHP**: `openssl`, `mbstring`, `pdo_*`, `curl`, `fileinfo`, `ctype`, `xml`, `bcmath` (normalmente já inclusas/em uso).  
- **Banco de dados**: SQLite (padrão), MySQL/MariaDB, PostgreSQL, etc.  
- **Node.js + npm** (para Vite/Frontend, opcional neste guia básico).

**Referências oficiais**  
- Instalação Laravel 12.x: <https://laravel.com/docs/12.x/installation>  
- Notas / Requisitos (11.x+): <https://laravel.com/docs/11.x/upgrade>  
- Frontend (Vite/Build): <https://laravel.com/docs/12.x/frontend>

---

## 2) Criando um projeto (3 caminhos)

### A) **Composer (local, sem Docker)** — rápido
```bash
# Escolha uma pasta "vazia" para o projeto
composer create-project laravel/laravel exemplo-app

cd exemplo-app
cp .env.example .env        # no Windows PowerShell: copy .env.example .env
php artisan key:generate
php artisan serve           # http://127.0.0.1:8000
```

### B) **Laravel Installer** (opcional)
```bash
composer global require laravel/installer
laravel new exemplo-app
```

> Se `laravel` não for reconhecido, adicione o diretório **Composer bin** à PATH do sistema. No Windows (Composer Setup) isso costuma ser feito automaticamente.

### C) **Laravel Sail (Docker)** — recomendado p/ evitar conflitos
```bash
# Requer Docker em execução
curl -s https://laravel.build/exemplo-app | bash
cd exemplo-app
./vendor/bin/sail up -d       # sobe containers
./vendor/bin/sail php -v      # usa o PHP do container
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```
Doc oficial Sail: <https://laravel.com/docs/12.x/sail>

> **Dica**: Com Sail, a configuração padrão usa **SQLite**. Para mudar para MySQL, rode `./vendor/bin/sail artisan sail:install` e habilite o serviço MySQL.

---

## 3) Configuração do ambiente (`.env`)

Após criar o projeto:
```bash
cp .env.example .env
php artisan key:generate
```
Edite o `.env` para seu banco (ex.: **MySQL no XAMPP**):
```dotenv
APP_NAME="Exemplo"
APP_ENV=local
APP_KEY=base64:GERADO-PELO-ARTISAN
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meubanco
DB_USERNAME=root
DB_PASSWORD=
```
- **SQLite** (padrão em 12.x): garanta que `database/database.sqlite` exista.  
- Docs: Banco de Dados (geral): <https://laravel.com/docs/12.x/database> • Migrations: <https://laravel.com/docs/12.x/migrations> • Configuração: <https://laravel.com/docs/12.x/configuration>

> **Dica**: Em dev, **evite** `php artisan config:cache` enquanto ainda altera `.env`. Isso “congela” as configs até você limpar o cache.

---

## 4) Entendendo a estrutura

- `routes/web.php` — Rotas web. **Routing**: <https://laravel.com/docs/12.x/routing>  
- `app/Http/Controllers` — Controladores. **Controllers**: <https://laravel.com/docs/12.x/controllers>  
- `resources/views` — Templates Blade. **Blade**: <https://laravel.com/docs/12.x/frontend> (seção Views/Blade)  
- `app/Models` — Modelos Eloquent. **Eloquent**: <https://laravel.com/docs/12.x/eloquent>  
- `database/migrations` — Versões do schema. **Migrations**: <https://laravel.com/docs/12.x/migrations>

---

## 5) Exemplo Rápido: “Olá, mundo”

Em `routes/web.php`:
```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // resources/views/welcome.blade.php
});

Route::get('/ola', function () {
    return 'Olá, mundo!';
});
```
Rode:
```bash
php artisan serve  # http://127.0.0.1:8000/ola
```

---

## 6) Projeto Guiado (CRUD simples de Tarefas)

### 6.1. Criar Model + Migration
```bash
php artisan make:model Task -m
```
Abra a migration criada em `database/migrations/*_create_tasks_table.php`:
```php
public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}
```
Execute:
```bash
php artisan migrate
```

### 6.2. Controller Resource
```bash
php artisan make:controller TaskController --resource
```
Edite `app/Http/Controllers/TaskController.php` (versão compacta):
```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);
        Task::create($validated);
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {
        $task->update(['completed' => (bool) $request->boolean('completed')]);
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
```
Habilite preenchimento em massa no Model `app/Models/Task.php`:
```php
class Task extends Model
{
    protected $fillable = ['title', 'completed'];
}
```

### 6.3. Rotas
Em `routes/web.php`:
```php
use App\Http\Controllers\TaskController;

Route::get('/', fn() => redirect()->route('tasks.index'));
Route::resource('tasks', TaskController::class)->only(['index','store','update','destroy']);
```

### 6.4. View Blade
Crie `resources/views/tasks/index.blade.php`:
```blade
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tarefas</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body style="max-width: 720px; margin: 40px auto; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell;">
    <h1>Tarefas</h1>

    <form method="POST" action="{{ route('tasks.store') }}" style="margin-bottom: 24px;">
      @csrf
      <input type="text" name="title" placeholder="Nova tarefa..." required>
      <button type="submit">Adicionar</button>
      @error('title') <div style="color:crimson">{{ $message }}</div> @enderror
    </form>

    <ul style="list-style:none; padding:0;">
      @foreach($tasks as $task)
        <li style="display:flex; align-items:center; gap:8px; margin:8px 0;">
          <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf @method('PUT')
            <input type="hidden" name="completed" value="{{ $task->completed ? 0 : 1 }}">
            <button type="submit">{{ $task->completed ? 'Desfazer' : 'Concluir' }}</button>
          </form>

          <span style="{{ $task->completed ? 'text-decoration: line-through; color: #777' : '' }}">
            {{ $task->title }}
          </span>

          <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="margin-left:auto">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Excluir tarefa?')">Excluir</button>
          </form>
        </li>
      @endforeach
    </ul>

    <script type="module">
      // Vite entry (se você usar o preset padrão do Laravel)
    </script>
  </body>
</html>
```
Se usar o preset padrão com Vite:
```bash
npm install
npm run dev
```
Frontend docs: <https://laravel.com/docs/12.x/frontend>

---

## 7) Validação, Eloquent & Boas práticas

- **Validação** (no Controller ou Form Requests): <https://laravel.com/docs/12.x/validation>  
- **Eloquent: Relationships**: <https://laravel.com/docs/12.x/eloquent-relationships>  
- **Mutators & Casting**: <https://laravel.com/docs/12.x/eloquent-mutators>  
- **API Resources (transformação JSON)**: <https://laravel.com/docs/12.x/eloquent-resources>

**Dicas**  
- Centralize regras de validação em **Form Requests** (`php artisan make:request`), mantém Controllers limpos.  
- Padronize collation do DB em `utf8mb4_unicode_ci`.  
- Use `php artisan tinker` para testar consultas rapidamente.

---

## 8) Banco de dados: Seeds e Factories (opcional)

```bash
php artisan make:seeder TaskSeeder
php artisan make:factory TaskFactory --model=Task
```
Seeds: `database/seeders/TaskSeeder.php`  
Factories: `database/factories/TaskFactory.php`  
Execute:
```bash
php artisan db:seed --class=TaskSeeder
```

---

## 9) Rodando o projeto

### PHP built‑in
```bash
php artisan serve  # http://127.0.0.1:8000
```

### Apache/XAMPP
- Aponte `DocumentRoot` para `public/` ou crie um **VirtualHost**:
  ```apache
  <VirtualHost *:80>
      ServerName laravel.test
      DocumentRoot "C:/caminho/exemplo-app/public"
      <Directory "C:/caminho/exemplo-app/public">
          AllowOverride All
          Require all granted
      </Directory>
  </VirtualHost>
  ```
- Adicione `127.0.0.1 laravel.test` ao `C:\Windows\System32\drivers\etc\hosts`.
- Reinicie o Apache. (URLs do Laravel dependem de `.htaccess` + `mod_rewrite`.)

### Docker/Sail
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

---

## 10) Autenticação rápida (starter kits)

Use Breeze/Jetstream (12.x introduz pacotes de starter para React/Vue/Livewire).  
- Releases: <https://laravel.com/docs/12.x/releases>  
- Autenticação: <https://laravel.com/docs/12.x/authentication>

Exemplo (Breeze + Blade):
```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

---

## 11) Comandos Artisan úteis (cheatsheet)

```bash
php artisan list                       # todos comandos
php artisan route:list                 # lista rotas
php artisan make:model Post -mcr       # model + migration + controller resource
php artisan make:controller Api/PostController --api
php artisan migrate:fresh --seed       # recria banco e semeia
php artisan tinker                     # REPL do Laravel
php artisan cache:clear && php artisan config:clear
```

Docs Artisan: <https://laravel.com/docs/12.x/artisan>

---

## 12) Diagnóstico de problemas comuns (FAQ)

- **404/URLs não funcionam no Apache** → verifique `mod_rewrite` e `AllowOverride All`.  
- **`Class "PDO" not found`** → extensões `pdo_*` não ativas no `php.ini`.  
- **`The only supported ciphers are...`** → ative `openssl`.  
- **`mb_strlen` undefined** → ative `mbstring`.  
- **Composer falha em SSL** → `openssl` + hora/`date.timezone` OK.  
- **Múltiplos PHPs na máquina** → confira `php -v`/`where php` e ajuste PATH.  
- **`APP_URL` incorreta** → ajuste no `.env` (links/redirects).

---

## 13) Próximos passos & deploy

- **Ciclo de Requisição**: <https://laravel.com/docs/12.x/requests>  
- **Service Container & Facades**: <https://laravel.com/docs/12.x/container> • <https://laravel.com/docs/12.x/facades>  
- **Deployment** (cache/otimizações, env, queues, storage link): <https://laravel.com/docs/12.x/deployment>

Checklist de deploy (resumo):
```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 14) Créditos e Referências Oficiais

- **Instalação (12.x)**: <https://laravel.com/docs/12.x/installation>  
- **Routing**: <https://laravel.com/docs/12.x/routing>  
- **Controllers**: <https://laravel.com/docs/12.x/controllers>  
- **Frontend/Blade**: <https://laravel.com/docs/12.x/frontend>  
- **Database**: <https://laravel.com/docs/12.x/database> • **Migrations**: <https://laravel.com/docs/12.x/migrations>  
- **Eloquent**: <https://laravel.com/docs/12.x/eloquent> • **Relationships**: <https://laravel.com/docs/12.x/eloquent-relationships> • **Mutators**: <https://laravel.com/docs/12.x/eloquent-mutators> • **API Resources**: <https://laravel.com/docs/12.x/eloquent-resources>  
- **Artisan**: <https://laravel.com/docs/12.x/artisan>  
- **Sail (Docker)**: <https://laravel.com/docs/12.x/sail>  
- **Deployment**: <https://laravel.com/docs/12.x/deployment>  
- **Apache mod_rewrite**: <https://httpd.apache.org/docs/current/mod/mod_rewrite.html>  
- **PHP — habilitar extensões**: <https://www.php.net/manual/en/install.pecl.windows.php> • **mbstring**: <https://www.php.net/manual/en/mbstring.installation.php>

---

### Fim — Bom código! 🚀