<h1 align="center">Filament Learning</h1>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-5-FDAE4B?style=for-the-badge&logo=laravel&logoColor=white" alt="Filament">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  Projeto de estudos dedicado ao desenvolvimento de painéis administrativos com Laravel e Filament.
</p>

---

## Sobre o projeto

O **Filament Learning** é um projeto educacional desenvolvido para explorar, na prática, os recursos do Filament integrado ao Laravel.

O objetivo é aprofundar conhecimentos em desenvolvimento backend, criação de interfaces administrativas, manipulação de dados e organização de aplicações web.

## Tecnologias

| Tecnologia | Descrição |
|:--|:--|
| PHP | Linguagem de programação |
| Laravel | Framework para desenvolvimento web |
| Filament | Construção de painéis administrativos |
| MySQL | Banco de dados relacional |
| Composer | Gerenciamento de dependências |
| Git e GitHub | Versionamento e controle de código |

## Conteúdos de estudo

- Configuração do ambiente Laravel e Filament
- Criação e personalização de Resources
- Desenvolvimento de formulários
- Construção e configuração de tabelas
- Operações CRUD
- Integração com banco de dados
- Relacionamentos entre modelos
- Filtros, ações e funcionalidades administrativas

## Instalação

Clone o repositório:

```bash
git clone https://github.com/ruanborgess/filament-learning.git
```

Acesse o diretório:

```bash
cd filament-learning
```

Instale as dependências:

```bash
composer install
```

Configure o ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

Configure a conexão com o banco de dados no arquivo `.env` e execute as migrações:

```bash
php artisan migrate
```

Inicie o servidor de desenvolvimento:

```bash
php artisan serve
```

O painel administrativo estará disponível em:

`http://127.0.0.1:8000/admin`

Caso ainda não exista um usuário administrativo, crie um com:

```bash
php artisan make:filament-user
```

## Status

**Em desenvolvimento**

O projeto será atualizado continuamente conforme o avanço dos estudos, com novas implementações, testes e melhorias.

## Objetivo

Consolidar conhecimentos em PHP e Laravel, explorar as funcionalidades do Filament e desenvolver boas práticas de programação por meio da prática.

---

<p align="center">
  Desenvolvido como parte da minha jornada de aprendizado em desenvolvimento de software.
</p>
