-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Nov-2018 às 09:16
-- Versão do servidor: 10.1.34-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cazulo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `banco`
--

CREATE TABLE `banco` (
  `operacao` varchar(3) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `agencia` varchar(10) NOT NULL,
  `nomeBanco` varchar(50) NOT NULL,
  `encerrado` tinyint(1) NOT NULL,
  `dataEncerramento` datetime DEFAULT NULL,
  `usuarioEncerramento` varchar(50) DEFAULT NULL,
  `dataAtualizacao` datetime NOT NULL,
  `usuarioAtualizacao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `grupo` varchar(100) NOT NULL,
  `descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condominio`
--

CREATE TABLE `condominio` (
  `cnpj` varchar(14) NOT NULL,
  `razaoSocial` varchar(100) NOT NULL,
  `telefone` varchar(12) DEFAULT NULL,
  `celular` varchar(12) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `rua` varchar(50) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `setor` varchar(50) NOT NULL,
  `complemento` varchar(200) DEFAULT NULL,
  `municipio` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `condominio`
--

INSERT INTO `condominio` (`cnpj`, `razaoSocial`, `telefone`, `celular`, `email`, `cep`, `rua`, `numero`, `setor`, `complemento`, `municipio`, `estado`) VALUES
('12312312300099', 'asdasd', 'qweq', 'dascz', 'xczx', 'zx', 'sdfsa', 23, 'sadf2r', 'f34rwf', 'rfw34', 'GO'),
('12345678900012', 'yrthr', 'tberd', 'tb', 'bbbbbbbbbbbbbbbbbbd', 'bhdf', 'bhdfgh', 567, 'tyrtbyrtybvt', 'yvrthv', 'ty', '54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `condomino`
--

CREATE TABLE `condomino` (
  `bloco` varchar(50) NOT NULL,
  `apartamento` varchar(10) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `usuarioAtualizacao` varchar(50) NOT NULL,
  `codigo` varchar(14) NOT NULL,
  `documento` varchar(10) NOT NULL,
  `origemdocumento` varchar(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `celular` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dataAtualizacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condominolancamento`
--

CREATE TABLE `condominolancamento` (
  `codigo` varchar(10) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `bloco` varchar(50) NOT NULL,
  `apartamento` varchar(10) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `percentual` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `extratobanco`
--

CREATE TABLE `extratobanco` (
  `agencia` varchar(10) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `operacao` varchar(3) NOT NULL,
  `periodo` date NOT NULL,
  `dataExtrato` datetime NOT NULL,
  `dataAtualizacao` datetime NOT NULL,
  `usuarioAtualizacao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `extratobancolancamento`
--

CREATE TABLE `extratobancolancamento` (
  `agencia` varchar(10) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `operacao` varchar(3) NOT NULL,
  `periodo` date NOT NULL,
  `codigo` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `numeroDocumento` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `saldo` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE `perfil` (
  `perfil` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilacesso`
--

CREATE TABLE `perfilacesso` (
  `perfil` int(11) NOT NULL,
  `codigoPerfil` int(11) NOT NULL,
  `codAcesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prestacaoconta`
--

CREATE TABLE `prestacaoconta` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `dataFechamento` datetime NOT NULL,
  `usuarioFechamento` varchar(50) NOT NULL,
  `totalReceita` decimal(10,0) NOT NULL,
  `totalDespesa` decimal(10,0) NOT NULL,
  `saldoBancario` decimal(10,0) NOT NULL,
  `rref` decimal(10,0) NOT NULL,
  `crep` decimal(10,0) NOT NULL,
  `rdef` decimal(10,0) NOT NULL,
  `cdep` decimal(10,0) NOT NULL,
  `caixa` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prestacaocontadocumento`
--

CREATE TABLE `prestacaocontadocumento` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `codigo` int(11) NOT NULL,
  `codigoCategoria` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `dataEmissao` datetime NOT NULL,
  `identificacao` varchar(100) NOT NULL,
  `valorTotal` decimal(10,0) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `identificacaoExtrato` int(11) NOT NULL,
  `agencia` varchar(10) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `operacao` varchar(3) NOT NULL,
  `periodo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prestacaocontaef`
--

CREATE TABLE `prestacaocontaef` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `codigoDocumento` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `identificacao` varchar(100) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `valor` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `previsaodespesa`
--

CREATE TABLE `previsaodespesa` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `fundoReserva` decimal(10,0) NOT NULL,
  `subTotal` decimal(10,0) NOT NULL,
  `valorFundoReserva` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `QuantidadeCondominos` smallint(6) NOT NULL,
  `dataFechamento` datetime NOT NULL,
  `usuarioFechamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `previsaodespesalancamento`
--

CREATE TABLE `previsaodespesalancamento` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `codigo` int(11) NOT NULL,
  `tipoCategoria` int(11) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `fixo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `taxacondominio`
--

CREATE TABLE `taxacondominio` (
  `cnpj` varchar(14) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `bloco` varchar(50) NOT NULL,
  `apartamento` varchar(10) NOT NULL,
  `codigoBoleto` varchar(50) NOT NULL,
  `dataEmissao` datetime NOT NULL,
  `usuarioEmissao` varchar(50) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `valorPago` decimal(10,0) NOT NULL,
  `DataPagamento` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `perfil` int(11) NOT NULL,
  `dataUltimoAcesso` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`operacao`,`conta`,`agencia`),
  ADD KEY `Fk_BancoUsuarioEncerramento` (`usuarioEncerramento`),
  ADD KEY `Fk_BancoUsuarioAtualizacao` (`usuarioAtualizacao`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `condominio`
--
ALTER TABLE `condominio`
  ADD PRIMARY KEY (`cnpj`);

--
-- Indexes for table `condomino`
--
ALTER TABLE `condomino`
  ADD PRIMARY KEY (`bloco`,`cnpj`,`apartamento`) USING BTREE,
  ADD KEY `Fk_CNPJ` (`cnpj`),
  ADD KEY `Fk_Usuario` (`usuarioAtualizacao`);

--
-- Indexes for table `condominolancamento`
--
ALTER TABLE `condominolancamento`
  ADD PRIMARY KEY (`cnpj`,`bloco`,`apartamento`,`codigo`) USING BTREE;

--
-- Indexes for table `extratobanco`
--
ALTER TABLE `extratobanco`
  ADD PRIMARY KEY (`agencia`,`conta`,`operacao`,`periodo`),
  ADD KEY `Fk_ExtratoBanco` (`operacao`,`conta`,`agencia`),
  ADD KEY `Fk_ExtratoBancoUsuario` (`usuarioAtualizacao`);

--
-- Indexes for table `extratobancolancamento`
--
ALTER TABLE `extratobancolancamento`
  ADD PRIMARY KEY (`codigo`,`agencia`,`conta`,`operacao`,`periodo`) USING BTREE,
  ADD KEY `Fk_ExtratoBancoLancamento` (`agencia`,`conta`,`operacao`,`periodo`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`perfil`);

--
-- Indexes for table `perfilacesso`
--
ALTER TABLE `perfilacesso`
  ADD PRIMARY KEY (`perfil`,`codigoPerfil`);

--
-- Indexes for table `prestacaoconta`
--
ALTER TABLE `prestacaoconta`
  ADD PRIMARY KEY (`cnpj`,`ano`,`mes`) USING BTREE,
  ADD KEY `Fk_PrestacaoUsuario` (`usuarioFechamento`);

--
-- Indexes for table `prestacaocontadocumento`
--
ALTER TABLE `prestacaocontadocumento`
  ADD PRIMARY KEY (`codigo`,`cnpj`,`ano`,`mes`) USING BTREE,
  ADD KEY `Fk_Categoria` (`codigoCategoria`),
  ADD KEY `Fk_ExtratoLanc` (`identificacaoExtrato`,`agencia`,`conta`,`operacao`,`periodo`),
  ADD KEY `Fk_PrestacaoDocs` (`cnpj`,`ano`,`mes`);

--
-- Indexes for table `prestacaocontaef`
--
ALTER TABLE `prestacaocontaef`
  ADD PRIMARY KEY (`cnpj`,`ano`,`mes`),
  ADD KEY `Fk_PrestacaoContas` (`codigoDocumento`,`cnpj`,`ano`,`mes`);

--
-- Indexes for table `previsaodespesa`
--
ALTER TABLE `previsaodespesa`
  ADD PRIMARY KEY (`cnpj`,`ano`,`mes`) USING BTREE,
  ADD KEY `Fk_PrevisaoUsuario` (`usuarioFechamento`);

--
-- Indexes for table `previsaodespesalancamento`
--
ALTER TABLE `previsaodespesalancamento`
  ADD PRIMARY KEY (`cnpj`,`ano`,`mes`,`codigo`) USING BTREE,
  ADD KEY `Fk_PrevisaoCategoria` (`tipoCategoria`);

--
-- Indexes for table `taxacondominio`
--
ALTER TABLE `taxacondominio`
  ADD PRIMARY KEY (`cnpj`,`codigoBoleto`,`ano`,`mes`,`bloco`,`apartamento`),
  ADD KEY `Fk_TaxaCondominio` (`cnpj`,`bloco`,`apartamento`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `FK_Perfil` (`perfil`);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `banco`
--
ALTER TABLE `banco`
  ADD CONSTRAINT `Fk_BancoUsuarioAtualizacao` FOREIGN KEY (`usuarioAtualizacao`) REFERENCES `usuario` (`usuario`),
  ADD CONSTRAINT `Fk_BancoUsuarioEncerramento` FOREIGN KEY (`usuarioEncerramento`) REFERENCES `usuario` (`usuario`);

--
-- Limitadores para a tabela `condomino`
--
ALTER TABLE `condomino`
  ADD CONSTRAINT `Fk_CNPJ` FOREIGN KEY (`cnpj`) REFERENCES `condominio` (`cnpj`),
  ADD CONSTRAINT `Fk_Condomino` FOREIGN KEY (`cnpj`) REFERENCES `condominio` (`cnpj`),
  ADD CONSTRAINT `Fk_Usuario` FOREIGN KEY (`usuarioAtualizacao`) REFERENCES `usuario` (`usuario`);

--
-- Limitadores para a tabela `condominolancamento`
--
ALTER TABLE `condominolancamento`
  ADD CONSTRAINT `Fk_LancCondomino` FOREIGN KEY (`cnpj`,`bloco`,`apartamento`) REFERENCES `condomino` (`cnpj`, `bloco`, `apartamento`);

--
-- Limitadores para a tabela `extratobanco`
--
ALTER TABLE `extratobanco`
  ADD CONSTRAINT `Fk_ExtratoBanco` FOREIGN KEY (`operacao`,`conta`,`agencia`) REFERENCES `banco` (`operacao`, `conta`, `agencia`),
  ADD CONSTRAINT `Fk_ExtratoBancoUsuario` FOREIGN KEY (`usuarioAtualizacao`) REFERENCES `usuario` (`usuario`);

--
-- Limitadores para a tabela `extratobancolancamento`
--
ALTER TABLE `extratobancolancamento`
  ADD CONSTRAINT `Fk_ExtratoBancoLancamento` FOREIGN KEY (`agencia`,`conta`,`operacao`,`periodo`) REFERENCES `extratobanco` (`agencia`, `conta`, `operacao`, `periodo`);

--
-- Limitadores para a tabela `perfilacesso`
--
ALTER TABLE `perfilacesso`
  ADD CONSTRAINT `FK_PerfilAcesso` FOREIGN KEY (`perfil`) REFERENCES `perfil` (`perfil`);

--
-- Limitadores para a tabela `prestacaoconta`
--
ALTER TABLE `prestacaoconta`
  ADD CONSTRAINT `Fk_PrestacaoConta` FOREIGN KEY (`cnpj`) REFERENCES `condominio` (`cnpj`),
  ADD CONSTRAINT `Fk_PrestacaoUsuario` FOREIGN KEY (`usuarioFechamento`) REFERENCES `usuario` (`usuario`);

--
-- Limitadores para a tabela `prestacaocontadocumento`
--
ALTER TABLE `prestacaocontadocumento`
  ADD CONSTRAINT `Fk_Categoria` FOREIGN KEY (`codigoCategoria`) REFERENCES `categoria` (`codigo`),
  ADD CONSTRAINT `Fk_ExtratoLanc` FOREIGN KEY (`identificacaoExtrato`,`agencia`,`conta`,`operacao`,`periodo`) REFERENCES `extratobancolancamento` (`codigo`, `agencia`, `conta`, `operacao`, `periodo`),
  ADD CONSTRAINT `Fk_PrestacaoDocs` FOREIGN KEY (`cnpj`,`ano`,`mes`) REFERENCES `prestacaoconta` (`cnpj`, `ano`, `mes`);

--
-- Limitadores para a tabela `prestacaocontaef`
--
ALTER TABLE `prestacaocontaef`
  ADD CONSTRAINT `Fk_PrestacaoContas` FOREIGN KEY (`codigoDocumento`,`cnpj`,`ano`,`mes`) REFERENCES `prestacaocontadocumento` (`codigo`, `cnpj`, `ano`, `mes`);

--
-- Limitadores para a tabela `previsaodespesa`
--
ALTER TABLE `previsaodespesa`
  ADD CONSTRAINT `Fk_PrevisaoCNPJ` FOREIGN KEY (`cnpj`) REFERENCES `condominio` (`cnpj`),
  ADD CONSTRAINT `Fk_PrevisaoUsuario` FOREIGN KEY (`usuarioFechamento`) REFERENCES `usuario` (`usuario`);

--
-- Limitadores para a tabela `previsaodespesalancamento`
--
ALTER TABLE `previsaodespesalancamento`
  ADD CONSTRAINT `Fk_Previsao` FOREIGN KEY (`cnpj`,`ano`,`mes`) REFERENCES `previsaodespesa` (`cnpj`, `ano`, `mes`),
  ADD CONSTRAINT `Fk_PrevisaoCategoria` FOREIGN KEY (`tipoCategoria`) REFERENCES `categoria` (`codigo`);

--
-- Limitadores para a tabela `taxacondominio`
--
ALTER TABLE `taxacondominio`
  ADD CONSTRAINT `Fk_TaxaCondominio` FOREIGN KEY (`cnpj`,`bloco`,`apartamento`) REFERENCES `condomino` (`cnpj`, `bloco`, `apartamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
