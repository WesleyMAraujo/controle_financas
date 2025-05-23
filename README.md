# Dependências do Projeto

Este projeto utiliza as seguintes versões de linguagens, frameworks e bibliotecas principais:

## 🧰 Ambiente

- **PHP**: 8.3.20  
- **Composer**: 2.8.8  
- **Laravel**: 10.x  
- **Filament Admin Panel**: v3.3.14

## 🔧 Requisitos adicionais

Certifique-se de ter instalado:

- Extensões PHP comuns (pdo, mbstring, tokenizer, xml, etc)
- Um servidor web (Apache, Nginx, etc)
- Um banco de dados compatível (MySQL 5.7+, PostgreSQL, etc)

## 📦 Instalação de Dependências

Após clonar o repositório:

```bash
composer install
php artisan key:generate
```

## 👤 Criação de Usuário Administrador (Filament)
Para acessar o painel do Filament:
```bash
php artisan make:filament-user
```

## 🚀 Iniciar o Servidor Local

Para iniciar o servidor local do Laravel, use o comando:

```bash
php artisan serve
```

O servidor será iniciado em `http://127.0.0.1:8000` por padrão.
