# 📦 Sistema de Controle de Estoque - Romance

Um sistema moderno (MVP) desenvolvido para resolver o problema de logística e consignação de peças de vestuário. Ele permite que distribuidores gerenciem com precisão o repasse de roupas para vendedoras, controlando o estoque atual, itens enviados, vendidos e devolvidos.

## 🎯 O Problema de Negócio
No modelo de venda por consignação, o distribuidor entrega um lote de roupas para uma vendedora. Sem um sistema adequado, o controle de "quem pegou o quê" e "quantas peças restam no estoque principal" é feito em planilhas ou cadernos, gerando furos de estoque e prejuízos financeiros. Este sistema automatiza e blinda esse processo.

## 🛠️ Stack Tecnológica
Este projeto foi construído utilizando as melhores práticas do mercado para aplicações Full-Stack:
* **Backend:** Laravel 11 (PHP)
* **Frontend:** React (Componentização Funcional)
* **Comunicação:** Inertia.js (Abordagem de Monólito Moderno, sem APIs RESTful avulsas)
* **Estilização:** Tailwind CSS
* **Banco de Dados:** PostgreSQL
* **Infraestrutura:** Docker & Docker Compose

## 🏗️ Arquitetura
Para detalhes profundos sobre as decisões de design de software (MVC, Service Layer, Form Requests e Transações ACID), consulte o nosso documento oficial de arquitetura: [Ler ARCHITECTURE.md](./ARCHITECTURE.md)

## 🚀 Como rodar o projeto localmente

### 1. Clone o repositório

```bash
git clone https://github.com/SEU_USUARIO/controle-estoque-romance.git
cd controle-estoque-romance
```

### 2. Instale as dependências
```bash
composer install
npm install
```

### 3. Configure o ambiente e Banco de Dados
```bash
cp .env.example .env
docker compose up -d
php artisan key:generate
php artisan migrate
```

### 4. Inicie os servidores
* Backend:
```bash
php artisan serve
```
* Frontend:
```bash
npm run dev
```

### 5. Acesse no navegador
```bash
http://localhost:8000
```

