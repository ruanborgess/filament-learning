<h1 align="center">Filament Learning</h1>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-5-FDAE4B?style=for-the-badge&logo=laravel&logoColor=white" alt="Filament">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  Projeto de estudos dedicado ao desenvolvimento de painéis administrativos com Laravel e Filament.
</p>

## Requisitos

- Docker Engine com Docker Compose v2 no Linux Mint, ou Docker Desktop com integração WSL 2 no Windows 11.
- Composer 2 para instalar as dependências PHP. O contêiner `composer:2` pode ser usado sem instalar PHP no host.
- Node.js/npm no host para compilar os assets, ou npm dentro do contêiner Sail.

No Windows 11, recomenda-se manter o repositório dentro do sistema de arquivos da distribuição WSL 2 e executar comandos de shell pelo terminal WSL. Docker Desktop deve estar iniciado e integrado a essa distribuição.

## Preparar o projeto

Clone o repositório e entre na pasta:

```bash
git clone https://github.com/ruanborgess/filament-learning.git
cd filament-learning
```

Crie o `.env` local a partir do exemplo. Cada máquina deve manter seu próprio `.env`, que não é versionado:

```bash
cp .env.example .env
```

No Windows PowerShell, use `Copy-Item .env.example .env`. Em ambos os sistemas, defina no `.env` um `APP_KEY` (pode ficar vazio inicialmente) e um `DB_PASSWORD` local forte. O mesmo `DB_PASSWORD` é usado para o usuário de desenvolvimento do MySQL e para a senha root do contêiner; não reutilize uma senha pessoal ou de produção. Para evitar conflito com um MySQL já instalado, altere `FORWARD_DB_PORT` (por exemplo, para `3307`). `DB_HOST=mysql` deve permanecer assim dentro dos contêineres.

Instale as dependências PHP sem precisar instalar PHP no host:

```bash
docker run --rm -v "$PWD:/app" -w /app composer:2 install --ignore-platform-req=ext-intl
```

No PowerShell, o mesmo comando funciona usando `${PWD}`:

```powershell
docker run --rm -v "${PWD}:/app" -w /app composer:2 install --ignore-platform-req=ext-intl
```

O Composer temporário não inclui `intl`; essa opção só ignora a extensão durante a instalação auxiliar. A imagem Sail da aplicação instala `intl` e deve usá-la em runtime.

Construa/inicie Sail e gere a chave da aplicação:

```bash
docker compose up -d --build
docker compose exec laravel.test php artisan key:generate
```

O Sail fica disponível em `http://localhost:8000`, e o painel Filament em `http://localhost:8000/admin`.

## Banco de dados e dados existentes do Laragon

O Compose usa MySQL 8.0 e guarda os arquivos do banco no volume nomeado `sail-mysql`, que persiste ao parar e recriar os contêineres. A configuração do projeto e os arquivos de migration foram preservados.

Não há `.env`, banco local ou dump do Laragon neste repositório. Se você tiver dados no Windows, faça um backup/exportação do Laragon antes de migrar e mantenha esse arquivo fora do Git. Para importar, coloque temporariamente o dump na máquina que executa Docker, inicie o serviço `mysql` e importe no banco configurado em `DB_DATABASE` (revise o dump para que não contenha `CREATE DATABASE`/`USE` apontando para outro banco). Exemplo, substituindo o caminho pelo seu arquivo:

```bash
docker compose up -d mysql
docker compose exec -T mysql sh -c 'exec mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' < /caminho/seguro/laragon.sql
```

No PowerShell, use:

```powershell
Get-Content -Raw .\laragon.sql | docker compose exec -T mysql sh -c 'exec mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"'
```

Depois de iniciar a aplicação, execute as migrations pendentes:

```bash
docker compose exec laravel.test php artisan migrate
```

Em um volume novo, as migrations criam as tabelas. Após restaurar um dump, Laravel registra o estado pela tabela `migrations` e executa somente as pendentes. Não use `migrate:fresh` para migrar dados existentes. Não execute `docker compose down -v`, pois isso remove o volume persistente do MySQL.

## Comandos úteis

```bash
docker compose up -d                 # iniciar
docker compose stop                  # parar sem remover contêineres ou dados
docker compose down                  # remover contêineres, preservar o volume do banco
docker compose logs -f               # acompanhar logs
docker compose exec laravel.test php artisan migrate
docker compose exec laravel.test php artisan make:filament-user
```

Para desenvolver os assets, instale dependências JavaScript com `npm install` no host e rode `npm run dev`, ou use `docker compose exec laravel.test npm install` e `docker compose exec laravel.test npm run dev`. O contêiner publica a porta Vite 5173.

## Tecnologias

| Tecnologia | Versão/configuração |
|:--|:--|
| PHP | 8.4 no contêiner Sail |
| Laravel Framework | 12.x |
| Filament | 5.x |
| Composer | 2.x |
| MySQL | 8.0 |

O projeto permanece em desenvolvimento e é dedicado ao estudo de Laravel e Filament.
