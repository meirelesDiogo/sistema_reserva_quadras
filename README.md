# 🏟️ Sistema de Reserva de Quadras

<p align="center">
  <img src="https://img.shields.io/badge/Status-Conclu%C3%ADdo-brightgreen?style=for-the-badge" alt="Status Concluído">
  <img src="https://img.shields.io/badge/Curso-Inform%C3%A1tica%20para%20Internet-blue?style=for-the-badge" alt="Curso">
  <img src="https://img.shields.io/badge/Institui%C3%A7%C3%A3o-SENAI-red?style=for-the-badge" alt="SENAI">
</p>

---

## 🎯 Sobre o Projeto

[cite_start]Este é um **Sistema Web completo** desenvolvido de ponta a ponta (contendo interface, camada de aplicação e armazenamento de dados) para gerenciar e automatizar a reserva de quadras esportivas[cite: 5]. 

[cite_start]A aplicação foi criada como um **Projeto Individual** avaliativo para a Unidade Curricular de **Implantação de Sistemas** do curso de Informática para Internet no **SENAI**[cite: 1, 2, 3]. [cite_start]O projeto cumpre todos os requisitos de arquitetura solicitados, conectando a interface de usuário de forma funcional ao banco de dados relacional[cite: 5].

---

## 📌 Funcionalidades Principais

* [cite_start]**🔑 Autenticação e Cadastro:** O próprio cliente consegue se cadastrar e realizar login no sistema de forma autônoma para acessar a área restrita[cite: 38].
* [cite_start]**🏟️ Consulta de Quadras:** Exibição e checagem das quadras disponíveis no local para agendamento[cite: 37].
* [cite_start]**📅 Agendamento de Reservas:** Permite ao cliente logado realizar reservas de horários para as quadras desejadas de maneira simples[cite: 37, 38].

---

## 💼 Regras de Negócio

[cite_start]O sistema foi estruturado e validado seguindo rigorosamente as seguintes diretrizes de negócio explicitadas no documento de requisitos[cite: 6]:
* [cite_start]**👤 Clientes e Reservas:** Um cliente poderá realizar várias reservas de quadra[cite: 7].
* [cite_start]**🏟️ Quadras e Reservas:** Uma quadra poderá ser reservada várias vezes[cite: 8].
* [cite_start]**📅 Exclusividade de Agendamento:** Cada reserva será vinculada a apenas uma quadra por vez[cite: 9].

---

## 📐 Estrutura do Banco de Dados (SQL)

O banco de dados relacional foi implementado em MySQL utilizando a seguinte estrutura de tabelas:

```sql
CREATE DATABASE sistema_reserva_quadras;
USE sistema_reserva_quadras;

-- Tabela Cliente
CREATE TABLE cliente (
    cod_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    endereco VARCHAR(205),
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela Quadra
CREATE TABLE quadra (
    cod_quadra INT AUTO_INCREMENT PRIMARY KEY,
    nome_quadra VARCHAR(50) NOT NULL
);

-- Tabela Reserva (Relaciona Cliente e Quadra)
CREATE TABLE reserva (
    cod_reserva INT AUTO_INCREMENT PRIMARY KEY,
    data_reserva DATETIME NOT NULL,
    cod_quadra INT NOT NULL,
    cod_cliente INT NOT NULL,
    FOREIGN KEY (cod_quadra) REFERENCES quadra(cod_quadra),
    FOREIGN KEY (cod_cliente) REFERENCES cliente(cod_cliente)
);

-- Inserindo Quadras de Teste
INSERT INTO quadra (nome_quadra) VALUES 
('Quadra 1'), 
('Quadra 2'), 
('Quadra 3');

## 🛠️ Como Executar o Projeto Localmente

> 💡 **Guia de Instalação Rápida:** Siga o passo a passo abaixo para configurar e rodar a aplicação no seu ambiente local.

### 📦 1. Clonar o Repositório
Abra o terminal na pasta onde deseja salvar o projeto e execute os comandos abaixo:
```bash
git clone [https://github.com/MeirelesDiogo/sistema-reserva-quadras.git](https://github.com/MeirelesDiogo/sistema-reserva-quadras.git)
cd sistema-reserva-quadras


### 💻 2. Configurar o Ambiente Web
* **Servidor Local:** Certifique-se de ter um servidor local ativo com suporte ao ambiente web (como **XAMPP**, **WampServer** ou similar).
* **Banco de Dados:** O serviço do **MySQL** deve estar obrigatoriamente iniciado.
* **Diretório do Projeto:** Caso utilize o XAMPP, mova ou clone a pasta do projeto para dentro do diretório padrão `htdocs`.

---

### 🗄️ 3. Configurar o Banco de Dados
1. Abra o seu painel de gerenciamento de banco de dados (como o **phpMyAdmin** ou o **MySQL Workbench**).
2. Crie uma nova base de dados vazia chamada `sistema_reserva_quadras`.
3. Copie o script SQL disponibilizado na seção anterior deste **README**, cole na aba **SQL** do seu gerenciador e execute-o para estruturar as tabelas e inserir os dados iniciais.

---

### 🔑 4. Conexão com o Banco
* Abra o código do projeto no seu editor de código (como o **VS Code**).
* Verifique o arquivo de configuração da conexão com o banco de dados (`conexao.php`, `.env` ou equivalente).
* Ajuste as credenciais de acesso para corresponderem ao seu ambiente local. O padrão costuma ser:

| Configuração | Valor Padrão |
| :--- | :--- |
| **Host** | `localhost` |
| **User** | `root` |
| **Senha** | `""` *(em branco)* |

---

### 🚀 5. Inicializar e Acessar a Aplicação
* Com o seu servidor local rodando, abra o seu navegador de preferência.
* Acesse a URL que aponta para a pasta do seu projeto:

```text
http://localhost/sistema-reserva-quadras/

## 👨‍💻 Informações do Desenvolvedor

| Detalhes | Identificação do Aluno & Projeto |
| :--- | :--- |
| **👤 Aluno / Desenvolvedor** | Diogo Meireles |
| **🌐 GitHub** | [@MeirelesDiogo](https://github.com/MeirelesDiogo) |
| **👨‍🏫 Professor Orientador** | Wíverson Gomes |
| **👥 Turma** | HT-IPI-01-M-25-10495 |
| **📚 Unidade Curricular** | Implantação de Sistemas |
| **🎓 Curso** | Informática para Internet |
| **🏢 Instituição** | SENAI |