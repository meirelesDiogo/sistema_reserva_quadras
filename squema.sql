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