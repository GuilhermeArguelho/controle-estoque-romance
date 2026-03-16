# 🏗️ Arquitetura do Sistema: Controle de Estoque - Romance

Este documento descreve as decisões arquiteturais, padrões de projeto e o fluxo de dados do sistema de controle de repasses e estoque.

## 🚀 Stack Tecnológica
* **Backend:** Laravel 11 (PHP)
* **Frontend:** React com Tailwind CSS
* **Comunicação:** Inertia.js (Substituindo APIs RESTful tradicionais)
* **Banco de Dados:** PostgreSQL
* **Infraestrutura:** Docker & Docker Compose (Isolamento de ambiente)

## 🧩 Padrão de Projeto (Design Pattern)

A aplicação utiliza uma abordagem de **Monólito Moderno**, implementando o padrão **MVC (Model-View-Controller)** turbinado com uma **Camada de Serviço (Service Layer)**.

Esta decisão foi tomada para garantir o princípio de *Separation of Concerns* (Separação de Responsabilidades), mantendo os Controladores "magros" e centralizando as regras de negócio críticas.

### O Fluxo de Dados (De ponta a ponta)

1. **Apresentação (React + Inertia):**
   * Componentes visuais isolados. O React não possui estado de negócio complexo, apenas envia intenções de ação (ex: "Registrar Repasse") e recebe as propriedades (`props`) injetadas diretamente pelo backend via Inertia.js.

2. **Segurança e Validação (Form Requests):**
   * Antes de qualquer requisição tocar os Controladores, classes dedicadas de `Form Request` do Laravel interceptam os dados, garantindo que regras de tipagem, obrigatoriedade e existência no banco de dados sejam cumpridas.

3. **Orquestração (Controllers):**
   * Controladores atuam apenas como "maestros". Eles recebem a requisição já validada, repassam para a Camada de Serviço e, em seguida, retornam a resposta atualizada para o Frontend. Zero regras de negócio ou de banco de dados residem aqui.

4. **Regras de Negócio (Service Layer):**
   * O "cérebro" da aplicação. Classes como `RepasseService` são responsáveis por abrir **Transações de Banco de Dados (DB::transaction)**, calcular baixas de estoque, garantir a propriedade ACID e salvar os registros consolidados. Se houver falha em qualquer etapa, ocorre o *Rollback* automático.

5. **Acesso a Dados (Models - Eloquent ORM):**
   * As classes de modelo representam as tabelas do PostgreSQL e gerenciam os relacionamentos (ex: `Repasse` pertence a uma `Vendedora` e a uma `Roupa`).