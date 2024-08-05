-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 05/08/2024 às 16:57
-- Versão do servidor: 10.11.3-MariaDB-1-log
-- Versão do PHP: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `preschuapweb`
--
CREATE DATABASE IF NOT EXISTS `preschuapweb` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `preschuapweb`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Preschuap_Agenda`
--

CREATE TABLE `Preschuap_Agenda` (
  `idPreschuap_Agenda` int(11) NOT NULL,
  `DataAgendamento` date DEFAULT NULL,
  `Turno` varchar(45) DEFAULT NULL,
  `Observacoes` varchar(255) DEFAULT NULL,
  `idPreschuap_Prescricao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Preschuap_Prescricao`
--

CREATE TABLE `Preschuap_Prescricao` (
  `idPreschuap_Prescricao` int(11) NOT NULL,
  `Prontuario` int(11) NOT NULL,
  `DataMarcacao` date DEFAULT NULL,
  `DataPrescricao` datetime DEFAULT current_timestamp(),
  `Dia` int(2) DEFAULT NULL,
  `Ciclo` int(2) DEFAULT NULL,
  `Aplicabilidade` varchar(45) DEFAULT NULL,
  `idTabPreschuap_Categoria` varchar(10) NOT NULL,
  `idTabPreschuap_Subcategoria` varchar(10) DEFAULT NULL,
  `idTabPreschuap_Protocolo` int(11) NOT NULL,
  `idTabPreschuap_TipoTerapia` int(11) DEFAULT NULL,
  `CiclosTotais` int(4) DEFAULT NULL,
  `EntreCiclos` int(4) DEFAULT NULL,
  `Peso` decimal(10,3) DEFAULT NULL,
  `CreatininaSerica` decimal(10,3) DEFAULT NULL,
  `Altura` int(5) DEFAULT NULL,
  `IndiceMassaCorporal` decimal(10,3) DEFAULT NULL,
  `ClearanceCreatinina` decimal(10,3) DEFAULT NULL,
  `SuperficieCorporal` decimal(10,3) DEFAULT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Leito` varchar(45) DEFAULT NULL,
  `DescricaoServico` varchar(100) DEFAULT NULL,
  `idTabPreschuap_MotivoCancelamento` int(11) DEFAULT NULL,
  `InformacaoComplementar` longtext DEFAULT NULL,
  `ReacaoAdversa` longtext DEFAULT NULL,
  `Concluido` int(1) DEFAULT 0,
  `Alergia` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Preschuap_Prescricao_Medicamento`
--

CREATE TABLE `Preschuap_Prescricao_Medicamento` (
  `idPreschuap_Prescricao_Medicamento` int(11) NOT NULL,
  `idPreschuap_Prescricao` int(11) NOT NULL,
  `idTabPreschuap_Protocolo_Medicamento` int(11) NOT NULL,
  `Ajuste` decimal(10,3) DEFAULT NULL,
  `TipoAjuste` varchar(45) DEFAULT NULL,
  `Calculo` decimal(10,3) DEFAULT NULL,
  `idTabPreschuap_Protocolo` int(11) NOT NULL,
  `OrdemInfusao` int(3) DEFAULT NULL,
  `idTabPreschuap_EtapaTerapia` int(11) NOT NULL,
  `idTabPreschuap_Medicamento` int(11) NOT NULL,
  `Dose` decimal(10,3) DEFAULT NULL,
  `idTabPreschuap_UnidadeMedida` int(11) NOT NULL,
  `idTabPreschuap_ViaAdministracao` int(11) NOT NULL,
  `idTabPreschuap_Diluente` int(11) DEFAULT NULL,
  `Volume` decimal(10,3) DEFAULT NULL,
  `TempoInfusao` varchar(100) DEFAULT NULL,
  `idTabPreschuap_Posologia` int(11) NOT NULL,
  `idTabPreschuap_MotivoAjusteDose` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_Auditoria`
--

CREATE TABLE `Sishuap_Auditoria` (
  `idSishuap_Auditoria` int(11) NOT NULL,
  `Tabela` varchar(45) DEFAULT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `DataAuditoria` timestamp NULL DEFAULT current_timestamp(),
  `Operacao` varchar(45) DEFAULT NULL,
  `ChavePrimaria` int(11) DEFAULT NULL,
  `Ip` varchar(20) DEFAULT NULL,
  `So` varchar(45) DEFAULT NULL,
  `Navegador` varchar(45) DEFAULT NULL,
  `NavegadorVersao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_AuditoriaAcesso`
--

CREATE TABLE `Sishuap_AuditoriaAcesso` (
  `idSishuap_AuditoriaAcesso` int(11) NOT NULL,
  `SessionId` varchar(45) DEFAULT NULL,
  `DataAuditoria` timestamp NULL DEFAULT current_timestamp(),
  `Operacao` varchar(45) DEFAULT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `Ip` varchar(20) DEFAULT NULL,
  `So` varchar(45) DEFAULT NULL,
  `Navegador` varchar(45) DEFAULT NULL,
  `NavegadorVersao` varchar(45) DEFAULT NULL,
  `idTab_Modulo` int(11) NOT NULL DEFAULT 26
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_AuditoriaLog`
--

CREATE TABLE `Sishuap_AuditoriaLog` (
  `idSishuap_AuditoriaLog` int(11) NOT NULL,
  `idSishuap_Auditoria` int(11) NOT NULL,
  `Campo` varchar(100) DEFAULT NULL,
  `ValorAnterior` longtext DEFAULT NULL,
  `ValorAtual` longtext DEFAULT NULL,
  `ChavePrimaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_Perfil`
--

CREATE TABLE `Sishuap_Perfil` (
  `idSishuap_Perfil` int(11) NOT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `idTab_Perfil` int(11) NOT NULL,
  `idTab_Modulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_PermissaoModulo`
--

CREATE TABLE `Sishuap_PermissaoModulo` (
  `idSishuap_PermissaoModulo` int(11) NOT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `idTab_Modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_PermissaoModulo_BKP`
--

CREATE TABLE `Sishuap_PermissaoModulo_BKP` (
  `idSishuap_PermissaoModulo` int(11) NOT NULL,
  `idSishuap_Usuario` int(11) NOT NULL,
  `idTab_Modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_Usuario`
--

CREATE TABLE `Sishuap_Usuario` (
  `idSishuap_Usuario` int(11) NOT NULL,
  `Inativo` int(1) DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Nome` varchar(200) DEFAULT NULL,
  `Cpf` bigint(11) DEFAULT NULL,
  `EmailSecundario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sishuap_Usuario_BKP`
--

CREATE TABLE `Sishuap_Usuario_BKP` (
  `idSishuap_Usuario` int(11) NOT NULL,
  `Inativo` int(1) DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Nome` varchar(200) DEFAULT NULL,
  `Cpf` bigint(11) DEFAULT NULL,
  `EmailSecundario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Sismicrob_Tratamento`
--

CREATE TABLE `Sismicrob_Tratamento` (
  `idSismicrob_Tratamento` int(11) NOT NULL,
  `DataInicioTratamento` date DEFAULT NULL,
  `Duracao` int(5) DEFAULT NULL,
  `DataFimTratamento` date DEFAULT NULL,
  `DoseAtaque` varchar(1) DEFAULT NULL,
  `DoseAtaquePosologica` decimal(18,2) DEFAULT NULL,
  `DoseAtaqueUnidadeMedida` varchar(4) DEFAULT NULL,
  `DoseAtaqueIntervalo` int(2) DEFAULT NULL,
  `DoseAtaqueIntervaloUnidade` varchar(15) DEFAULT NULL,
  `DoseAtaqueNumeroDoses` int(2) DEFAULT NULL,
  `DosePosologica` decimal(18,2) DEFAULT NULL,
  `UnidadeMedida` varchar(4) DEFAULT NULL,
  `IntervaloUnidade` varchar(15) DEFAULT NULL,
  `DoseDiaria` decimal(18,2) DEFAULT NULL,
  `Unidades` int(11) DEFAULT NULL,
  `Peso` decimal(6,2) DEFAULT NULL,
  `Creatinina` decimal(6,2) DEFAULT NULL,
  `Clearance` decimal(6,2) DEFAULT NULL,
  `Hemodialise` varchar(1) DEFAULT NULL,
  `DiagnosticoInfecciosoOutro` varchar(250) DEFAULT NULL,
  `SubstituicaoMedicamento` varchar(250) DEFAULT NULL,
  `IndicacaoTipoCirurgia` varchar(250) DEFAULT NULL,
  `Avaliacao` varchar(1) DEFAULT 'P',
  `AvaliacaoDose` tinyint(1) DEFAULT NULL,
  `AvaliacaoDoseObs` varchar(250) DEFAULT NULL,
  `AvaliacaoDuracao` tinyint(1) DEFAULT NULL,
  `AvaliacaoDuracaoObs` varchar(250) DEFAULT NULL,
  `AvaliacaoIntervalo` tinyint(1) DEFAULT NULL,
  `AvaliacaoIntervaloObs` varchar(250) DEFAULT NULL,
  `AvaliacaoIndicacao` tinyint(1) DEFAULT NULL,
  `AvaliacaoIndicacaoObs` varchar(250) DEFAULT NULL,
  `AvaliacaoPreenchimentoInadequado` tinyint(1) DEFAULT NULL,
  `AvaliacaoPreenchimentoInadequadoObs` varchar(250) DEFAULT NULL,
  `AvaliacaoOutros` tinyint(1) DEFAULT NULL,
  `AvaliacaoOutrosObs` varchar(250) DEFAULT NULL,
  `AlteracaoPorAlta` tinyint(1) DEFAULT NULL,
  `SubstituirTratamento` int(11) DEFAULT NULL,
  `SubstituidoPeloTratamento` int(11) DEFAULT NULL,
  `Justificativa` longtext DEFAULT NULL,
  `Suspender` tinyint(1) DEFAULT NULL,
  `SuspenderObs` varchar(250) DEFAULT NULL,
  `Prorrogar` tinyint(1) DEFAULT NULL,
  `ProrrogarObs` longtext DEFAULT NULL,
  `idTabSismicrob_ViaAdministracao` int(11) NOT NULL,
  `idTabSismicrob_Especialidade` int(11) NOT NULL,
  `idTabSismicrob_DiagnosticoInfeccioso` int(11) DEFAULT NULL,
  `idTabSismicrob_Tratamento` int(11) NOT NULL,
  `idTabSismicrob_Substituicao` int(11) DEFAULT NULL,
  `idTabSismicrob_Indicacao` int(11) NOT NULL,
  `idTabSismicrob_Infeccao` int(11) DEFAULT NULL,
  `idTabSismicrob_Intervalo` int(11) NOT NULL,
  `idTabSismicrob_AntibioticoMantido` int(11) DEFAULT NULL,
  `CodigoMedicamento` int(11) NOT NULL,
  `NomeMedicamento` varchar(255) NOT NULL,
  `Prontuario` int(11) NOT NULL,
  `CodigoAghux` int(11) NOT NULL,
  `Concluido` tinyint(1) DEFAULT 0,
  `DataPrescricao` datetime DEFAULT current_timestamp(),
  `DataConclusao` datetime DEFAULT NULL,
  `idSishuap_Usuario` int(11) DEFAULT NULL COMMENT 'Profissional que criou a prescrição',
  `idSishuap_Usuario1` int(11) DEFAULT NULL COMMENT 'Profissional que concluiu a prescrição',
  `idSishuap_Usuario2` int(11) DEFAULT NULL COMMENT 'Profissional que avaliou a prescrição',
  `AvaliacaoObs` text DEFAULT NULL,
  `DataAvaliacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Alergia`
--

CREATE TABLE `TabPreschuap_Alergia` (
  `idTabPreschuap_Alergia` int(11) NOT NULL,
  `Alergia` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Categoria`
--

CREATE TABLE `TabPreschuap_Categoria` (
  `idTabPreschuap_Categoria` varchar(10) NOT NULL,
  `Categoria` varchar(250) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Diluente`
--

CREATE TABLE `TabPreschuap_Diluente` (
  `idTabPreschuap_Diluente` int(11) NOT NULL,
  `Diluente` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_EtapaTerapia`
--

CREATE TABLE `TabPreschuap_EtapaTerapia` (
  `idTabPreschuap_EtapaTerapia` int(11) NOT NULL,
  `EtapaTerapia` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Formula`
--

CREATE TABLE `TabPreschuap_Formula` (
  `idTabPreschuap_Formula` int(11) NOT NULL,
  `Formula` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Medicamento`
--

CREATE TABLE `TabPreschuap_Medicamento` (
  `idTabPreschuap_Medicamento` int(11) NOT NULL,
  `Medicamento` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp(),
  `CalculoLimiteMinimo` decimal(9,2) DEFAULT NULL,
  `CalculoLimiteMaximo` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_MotivoAjusteDose`
--

CREATE TABLE `TabPreschuap_MotivoAjusteDose` (
  `idTabPreschuap_MotivoAjusteDose` int(11) NOT NULL,
  `MotivoAjusteDose` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_MotivoCancelamento`
--

CREATE TABLE `TabPreschuap_MotivoCancelamento` (
  `idTabPreschuap_MotivoCancelamento` int(11) NOT NULL,
  `MotivoCancelamento` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Posologia`
--

CREATE TABLE `TabPreschuap_Posologia` (
  `idTabPreschuap_Posologia` int(11) NOT NULL,
  `Posologia` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Protocolo`
--

CREATE TABLE `TabPreschuap_Protocolo` (
  `idTabPreschuap_Protocolo` int(11) NOT NULL,
  `Aplicabilidade` varchar(100) DEFAULT NULL,
  `Protocolo` varchar(250) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp(),
  `idTabPreschuap_Categoria` varchar(10) NOT NULL,
  `idTabPreschuap_TipoTerapia` int(11) NOT NULL,
  `Observacoes` longtext DEFAULT NULL,
  `idTabPreschuap_TipoAgendamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Protocolo_Medicamento`
--

CREATE TABLE `TabPreschuap_Protocolo_Medicamento` (
  `idTabPreschuap_Protocolo_Medicamento` int(11) NOT NULL,
  `idTabPreschuap_Protocolo` int(11) NOT NULL,
  `OrdemInfusao` int(3) DEFAULT NULL,
  `idTabPreschuap_EtapaTerapia` int(11) NOT NULL,
  `idTabPreschuap_Medicamento` int(11) NOT NULL,
  `Dose` decimal(9,2) DEFAULT NULL,
  `idTabPreschuap_UnidadeMedida` int(11) NOT NULL,
  `idTabPreschuap_ViaAdministracao` int(11) NOT NULL,
  `idTabPreschuap_Diluente` int(11) DEFAULT NULL,
  `Volume` decimal(6,2) DEFAULT NULL,
  `TempoInfusao` varchar(100) DEFAULT NULL,
  `idTabPreschuap_Posologia` int(11) NOT NULL,
  `DataCadastro` datetime DEFAULT current_timestamp(),
  `Inativo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_Subcategoria`
--

CREATE TABLE `TabPreschuap_Subcategoria` (
  `idTabPreschuap_Subcategoria` varchar(10) NOT NULL,
  `Subcategoria` varchar(250) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_TipoAgendamento`
--

CREATE TABLE `TabPreschuap_TipoAgendamento` (
  `idTabPreschuap_TipoAgendamento` int(11) NOT NULL,
  `TipoAgendamento` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_TipoTerapia`
--

CREATE TABLE `TabPreschuap_TipoTerapia` (
  `idTabPreschuap_TipoTerapia` int(11) NOT NULL,
  `TipoTerapia` varchar(100) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_UnidadeMedida`
--

CREATE TABLE `TabPreschuap_UnidadeMedida` (
  `idTabPreschuap_UnidadeMedida` int(11) NOT NULL,
  `UnidadeMedida` varchar(100) DEFAULT NULL,
  `Representacao` varchar(45) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `idTabPreschuap_Formula` int(11) NOT NULL,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabPreschuap_ViaAdministracao`
--

CREATE TABLE `TabPreschuap_ViaAdministracao` (
  `idTabPreschuap_ViaAdministracao` int(11) NOT NULL,
  `ViaAdministracao` varchar(100) DEFAULT NULL,
  `Codigo` varchar(10) DEFAULT NULL,
  `Inativo` int(1) NOT NULL DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_AntibioticoMantido`
--

CREATE TABLE `TabSismicrob_AntibioticoMantido` (
  `idTabSismicrob_AntibioticoMantido` int(11) NOT NULL,
  `AntibioticoMantido` varchar(45) DEFAULT NULL,
  `Inativo` tinyint(1) DEFAULT 0,
  `DataCadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_DiagnosticoInfeccioso`
--

CREATE TABLE `TabSismicrob_DiagnosticoInfeccioso` (
  `idTabSismicrob_DiagnosticoInfeccioso` int(11) NOT NULL,
  `DiagnosticoInfeccioso` varchar(100) DEFAULT NULL,
  `Classificacao` int(1) DEFAULT 1,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Especialidade`
--

CREATE TABLE `TabSismicrob_Especialidade` (
  `idTabSismicrob_Especialidade` int(11) NOT NULL,
  `Especialidade` varchar(250) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Indicacao`
--

CREATE TABLE `TabSismicrob_Indicacao` (
  `idTabSismicrob_Indicacao` int(11) NOT NULL,
  `Indicacao` varchar(100) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Infeccao`
--

CREATE TABLE `TabSismicrob_Infeccao` (
  `idTabSismicrob_Infeccao` int(11) NOT NULL,
  `Infeccao` varchar(45) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Intervalo`
--

CREATE TABLE `TabSismicrob_Intervalo` (
  `idTabSismicrob_Intervalo` int(11) NOT NULL,
  `Intervalo` int(3) DEFAULT NULL,
  `Codigo` varchar(15) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Produto`
--

CREATE TABLE `TabSismicrob_Produto` (
  `idTabSismicrob_Produto` int(11) NOT NULL,
  `Produto` varchar(255) DEFAULT NULL,
  `NomeTipo` varchar(255) DEFAULT NULL,
  `CodigoTipo` varchar(3) DEFAULT NULL,
  `Ativo` varchar(1) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Substituicao`
--

CREATE TABLE `TabSismicrob_Substituicao` (
  `idTabSismicrob_Substituicao` int(11) NOT NULL,
  `Substituicao` varchar(100) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_Tratamento`
--

CREATE TABLE `TabSismicrob_Tratamento` (
  `idTabSismicrob_Tratamento` int(11) NOT NULL,
  `Tratamento` varchar(100) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TabSismicrob_ViaAdministracao`
--

CREATE TABLE `TabSismicrob_ViaAdministracao` (
  `idTabSismicrob_ViaAdministracao` int(11) NOT NULL,
  `ViaAdministracao` varchar(250) DEFAULT NULL,
  `Codigo` varchar(6) DEFAULT NULL,
  `Inativo` tinyint(4) NOT NULL DEFAULT 0,
  `DataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Tab_Modulo`
--

CREATE TABLE `Tab_Modulo` (
  `idTab_Modulo` int(11) NOT NULL,
  `NomeModulo` varchar(255) DEFAULT NULL,
  `Descricao` text DEFAULT NULL,
  `Ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Tab_Perfil`
--

CREATE TABLE `Tab_Perfil` (
  `idTab_Perfil` int(11) NOT NULL,
  `Inativo` int(1) DEFAULT NULL,
  `Perfil` varchar(45) DEFAULT NULL,
  `Descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `teste_blog`
--

CREATE TABLE `teste_blog` (
  `CD_DOCUMENTO` int(11) NOT NULL,
  `CD_VERSAO` int(11) NOT NULL,
  `BLOB_CONTEUDO` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Preschuap_Agenda`
--
ALTER TABLE `Preschuap_Agenda`
  ADD PRIMARY KEY (`idPreschuap_Agenda`),
  ADD KEY `fk_Preschuap_Agenda_Preschuap_Prescricao1_idx` (`idPreschuap_Prescricao`);

--
-- Índices de tabela `Preschuap_Prescricao`
--
ALTER TABLE `Preschuap_Prescricao`
  ADD PRIMARY KEY (`idPreschuap_Prescricao`),
  ADD KEY `fk_Preschuap_Prescricao_TabPreschuap_Categoria1_idx` (`idTabPreschuap_Categoria`),
  ADD KEY `fk_Preschuap_Prescricao_TabPreschuap_Subcategoria1_idx` (`idTabPreschuap_Subcategoria`),
  ADD KEY `fk_Preschuap_Prescricao_TabPreschuap_Protocolo1_idx` (`idTabPreschuap_Protocolo`),
  ADD KEY `fk_Preschuap_Prescricao_TabPreschuap_TipoTerapia1_idx` (`idTabPreschuap_TipoTerapia`),
  ADD KEY `fk_Preschuap_Prescricao_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Preschuap_Prescricao_TabPreschuap_MotivoCancelamento1_idx` (`idTabPreschuap_MotivoCancelamento`);

--
-- Índices de tabela `Preschuap_Prescricao_Medicamento`
--
ALTER TABLE `Preschuap_Prescricao_Medicamento`
  ADD PRIMARY KEY (`idPreschuap_Prescricao_Medicamento`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_Preschuap_Prescricao1_idx` (`idPreschuap_Prescricao`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Protocolo__idx` (`idTabPreschuap_Protocolo_Medicamento`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Protocolo1_idx` (`idTabPreschuap_Protocolo`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_EtapaTerap_idx` (`idTabPreschuap_EtapaTerapia`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Medicament_idx` (`idTabPreschuap_Medicamento`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_UnidadeMed_idx` (`idTabPreschuap_UnidadeMedida`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_ViaAdminis_idx` (`idTabPreschuap_ViaAdministracao`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Diluente1_idx` (`idTabPreschuap_Diluente`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Posologia1_idx` (`idTabPreschuap_Posologia`),
  ADD KEY `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_MotivoAjus_idx` (`idTabPreschuap_MotivoAjusteDose`);

--
-- Índices de tabela `Sishuap_Auditoria`
--
ALTER TABLE `Sishuap_Auditoria`
  ADD PRIMARY KEY (`idSishuap_Auditoria`),
  ADD KEY `fk_Sishuap_Auditoria_Sishuap_Usuario_idx` (`idSishuap_Usuario`);

--
-- Índices de tabela `Sishuap_AuditoriaAcesso`
--
ALTER TABLE `Sishuap_AuditoriaAcesso`
  ADD PRIMARY KEY (`idSishuap_AuditoriaAcesso`),
  ADD KEY `fk_Sishuap_AuditoriaAcesso_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Sishuap_AuditoriaAcesso_Tab_Modulo1_idx` (`idTab_Modulo`);

--
-- Índices de tabela `Sishuap_AuditoriaLog`
--
ALTER TABLE `Sishuap_AuditoriaLog`
  ADD PRIMARY KEY (`idSishuap_AuditoriaLog`),
  ADD KEY `fk_Sishuap_AuditoriaLog_Sishuap_Auditoria1_idx` (`idSishuap_Auditoria`);

--
-- Índices de tabela `Sishuap_Perfil`
--
ALTER TABLE `Sishuap_Perfil`
  ADD PRIMARY KEY (`idSishuap_Perfil`),
  ADD KEY `fk_Sishuap_Perfil_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Sishuap_Perfil_Tab_Perfil1_idx` (`idTab_Perfil`),
  ADD KEY `fk_Sishuap_Perfil_Tab_Modulo1_idx` (`idTab_Modulo`);

--
-- Índices de tabela `Sishuap_PermissaoModulo`
--
ALTER TABLE `Sishuap_PermissaoModulo`
  ADD PRIMARY KEY (`idSishuap_PermissaoModulo`),
  ADD KEY `fk_Sishuap_PermissaoModulo_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Sishuap_PermissaoModulo_Tab_Modulo1_idx` (`idTab_Modulo`);

--
-- Índices de tabela `Sishuap_PermissaoModulo_BKP`
--
ALTER TABLE `Sishuap_PermissaoModulo_BKP`
  ADD PRIMARY KEY (`idSishuap_PermissaoModulo`),
  ADD KEY `fk_Sishuap_PermissaoModulo_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Sishuap_PermissaoModulo_Tab_Modulo1_idx` (`idTab_Modulo`);

--
-- Índices de tabela `Sishuap_Usuario`
--
ALTER TABLE `Sishuap_Usuario`
  ADD PRIMARY KEY (`idSishuap_Usuario`),
  ADD UNIQUE KEY `Cpf_UNIQUE` (`Cpf`),
  ADD UNIQUE KEY `Usuario_UNIQUE` (`Usuario`);

--
-- Índices de tabela `Sishuap_Usuario_BKP`
--
ALTER TABLE `Sishuap_Usuario_BKP`
  ADD PRIMARY KEY (`idSishuap_Usuario`),
  ADD UNIQUE KEY `Cpf_UNIQUE` (`Cpf`),
  ADD UNIQUE KEY `Usuario_UNIQUE` (`Usuario`);

--
-- Índices de tabela `Sismicrob_Tratamento`
--
ALTER TABLE `Sismicrob_Tratamento`
  ADD PRIMARY KEY (`idSismicrob_Tratamento`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_ViaAdministracao1_idx` (`idTabSismicrob_ViaAdministracao`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Especialidade1_idx` (`idTabSismicrob_Especialidade`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_DiagnosticoInfeccioso1_idx` (`idTabSismicrob_DiagnosticoInfeccioso`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Tratamento1_idx` (`idTabSismicrob_Tratamento`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Substituicao1_idx` (`idTabSismicrob_Substituicao`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Indicacao1_idx` (`idTabSismicrob_Indicacao`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Infeccao1_idx` (`idTabSismicrob_Infeccao`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_Intervalo1_idx` (`idTabSismicrob_Intervalo`),
  ADD KEY `fk_Sismicrob_Tratamento_TabSismicrob_AntibioticoMantido1_idx` (`idTabSismicrob_AntibioticoMantido`),
  ADD KEY `fk_Sismicrob_Tratamento_Sishuap_Usuario1_idx` (`idSishuap_Usuario`),
  ADD KEY `fk_Sismicrob_Tratamento_Sishuap_Usuario2_idx` (`idSishuap_Usuario1`),
  ADD KEY `fk_Sismicrob_Tratamento_Sishuap_Usuario3_idx` (`idSishuap_Usuario2`);

--
-- Índices de tabela `TabPreschuap_Alergia`
--
ALTER TABLE `TabPreschuap_Alergia`
  ADD PRIMARY KEY (`idTabPreschuap_Alergia`),
  ADD UNIQUE KEY `Alergia_UNIQUE` (`Alergia`);

--
-- Índices de tabela `TabPreschuap_Categoria`
--
ALTER TABLE `TabPreschuap_Categoria`
  ADD PRIMARY KEY (`idTabPreschuap_Categoria`),
  ADD UNIQUE KEY `idTabPreschuap_Categoria_UNIQUE` (`idTabPreschuap_Categoria`);

--
-- Índices de tabela `TabPreschuap_Diluente`
--
ALTER TABLE `TabPreschuap_Diluente`
  ADD PRIMARY KEY (`idTabPreschuap_Diluente`),
  ADD UNIQUE KEY `Diluente_UNIQUE` (`Diluente`);

--
-- Índices de tabela `TabPreschuap_EtapaTerapia`
--
ALTER TABLE `TabPreschuap_EtapaTerapia`
  ADD PRIMARY KEY (`idTabPreschuap_EtapaTerapia`),
  ADD UNIQUE KEY `EtapaTerapia_UNIQUE` (`EtapaTerapia`);

--
-- Índices de tabela `TabPreschuap_Formula`
--
ALTER TABLE `TabPreschuap_Formula`
  ADD PRIMARY KEY (`idTabPreschuap_Formula`);

--
-- Índices de tabela `TabPreschuap_Medicamento`
--
ALTER TABLE `TabPreschuap_Medicamento`
  ADD PRIMARY KEY (`idTabPreschuap_Medicamento`),
  ADD UNIQUE KEY `Medicamento_UNIQUE` (`Medicamento`);

--
-- Índices de tabela `TabPreschuap_MotivoAjusteDose`
--
ALTER TABLE `TabPreschuap_MotivoAjusteDose`
  ADD PRIMARY KEY (`idTabPreschuap_MotivoAjusteDose`),
  ADD UNIQUE KEY `MotivoAjusteDose_UNIQUE` (`MotivoAjusteDose`);

--
-- Índices de tabela `TabPreschuap_MotivoCancelamento`
--
ALTER TABLE `TabPreschuap_MotivoCancelamento`
  ADD PRIMARY KEY (`idTabPreschuap_MotivoCancelamento`),
  ADD UNIQUE KEY `MotivoCancelamento_UNIQUE` (`MotivoCancelamento`);

--
-- Índices de tabela `TabPreschuap_Posologia`
--
ALTER TABLE `TabPreschuap_Posologia`
  ADD PRIMARY KEY (`idTabPreschuap_Posologia`),
  ADD UNIQUE KEY `Posologia_UNIQUE` (`Posologia`);

--
-- Índices de tabela `TabPreschuap_Protocolo`
--
ALTER TABLE `TabPreschuap_Protocolo`
  ADD PRIMARY KEY (`idTabPreschuap_Protocolo`),
  ADD UNIQUE KEY `Protocolo_UNIQUE` (`Protocolo`),
  ADD KEY `fk_TabPreschuap_Protocolo_TabPreschuap_Categoria1_idx` (`idTabPreschuap_Categoria`),
  ADD KEY `fk_TabPreschuap_Protocolo_TabPreschuap_TipoTerapia1_idx` (`idTabPreschuap_TipoTerapia`),
  ADD KEY `fk_TabPreschuap_Protocolo_TabPreschuap_TipoAgendamento1_idx` (`idTabPreschuap_TipoAgendamento`);

--
-- Índices de tabela `TabPreschuap_Protocolo_Medicamento`
--
ALTER TABLE `TabPreschuap_Protocolo_Medicamento`
  ADD PRIMARY KEY (`idTabPreschuap_Protocolo_Medicamento`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_Protocolo1_idx` (`idTabPreschuap_Protocolo`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_Medicamento1_idx` (`idTabPreschuap_Medicamento`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_UnidadeMedida1_idx` (`idTabPreschuap_UnidadeMedida`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_ViaAdministracao1_idx` (`idTabPreschuap_ViaAdministracao`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_Diluente1_idx` (`idTabPreschuap_Diluente`),
  ADD KEY `fk_TabPreschuap_Prot_Med_TabPreschuap_Posologia1_idx` (`idTabPreschuap_Posologia`),
  ADD KEY `fk_TabPreschuap_Protocolo_Medicamento_TabPreschuap_EtapaTer_idx` (`idTabPreschuap_EtapaTerapia`);

--
-- Índices de tabela `TabPreschuap_Subcategoria`
--
ALTER TABLE `TabPreschuap_Subcategoria`
  ADD PRIMARY KEY (`idTabPreschuap_Subcategoria`);

--
-- Índices de tabela `TabPreschuap_TipoAgendamento`
--
ALTER TABLE `TabPreschuap_TipoAgendamento`
  ADD PRIMARY KEY (`idTabPreschuap_TipoAgendamento`),
  ADD UNIQUE KEY `TipoAgendamento_UNIQUE` (`TipoAgendamento`);

--
-- Índices de tabela `TabPreschuap_TipoTerapia`
--
ALTER TABLE `TabPreschuap_TipoTerapia`
  ADD PRIMARY KEY (`idTabPreschuap_TipoTerapia`),
  ADD UNIQUE KEY `TipoTerapia_UNIQUE` (`TipoTerapia`);

--
-- Índices de tabela `TabPreschuap_UnidadeMedida`
--
ALTER TABLE `TabPreschuap_UnidadeMedida`
  ADD PRIMARY KEY (`idTabPreschuap_UnidadeMedida`),
  ADD UNIQUE KEY `UnidadeMedida_UNIQUE` (`UnidadeMedida`),
  ADD UNIQUE KEY `Representacao_UNIQUE` (`Representacao`),
  ADD KEY `fk_TabPreschuap_UnidadeMedida_TabPreschuap_Formula1_idx` (`idTabPreschuap_Formula`);

--
-- Índices de tabela `TabPreschuap_ViaAdministracao`
--
ALTER TABLE `TabPreschuap_ViaAdministracao`
  ADD PRIMARY KEY (`idTabPreschuap_ViaAdministracao`),
  ADD UNIQUE KEY `ViaAcesso_UNIQUE` (`ViaAdministracao`),
  ADD UNIQUE KEY `Codigo_UNIQUE` (`Codigo`);

--
-- Índices de tabela `TabSismicrob_AntibioticoMantido`
--
ALTER TABLE `TabSismicrob_AntibioticoMantido`
  ADD PRIMARY KEY (`idTabSismicrob_AntibioticoMantido`),
  ADD UNIQUE KEY `AntibioticoMantido_UNIQUE` (`AntibioticoMantido`);

--
-- Índices de tabela `TabSismicrob_DiagnosticoInfeccioso`
--
ALTER TABLE `TabSismicrob_DiagnosticoInfeccioso`
  ADD PRIMARY KEY (`idTabSismicrob_DiagnosticoInfeccioso`);

--
-- Índices de tabela `TabSismicrob_Especialidade`
--
ALTER TABLE `TabSismicrob_Especialidade`
  ADD PRIMARY KEY (`idTabSismicrob_Especialidade`);

--
-- Índices de tabela `TabSismicrob_Indicacao`
--
ALTER TABLE `TabSismicrob_Indicacao`
  ADD PRIMARY KEY (`idTabSismicrob_Indicacao`);

--
-- Índices de tabela `TabSismicrob_Infeccao`
--
ALTER TABLE `TabSismicrob_Infeccao`
  ADD PRIMARY KEY (`idTabSismicrob_Infeccao`);

--
-- Índices de tabela `TabSismicrob_Intervalo`
--
ALTER TABLE `TabSismicrob_Intervalo`
  ADD PRIMARY KEY (`idTabSismicrob_Intervalo`);

--
-- Índices de tabela `TabSismicrob_Produto`
--
ALTER TABLE `TabSismicrob_Produto`
  ADD PRIMARY KEY (`idTabSismicrob_Produto`);

--
-- Índices de tabela `TabSismicrob_Substituicao`
--
ALTER TABLE `TabSismicrob_Substituicao`
  ADD PRIMARY KEY (`idTabSismicrob_Substituicao`);

--
-- Índices de tabela `TabSismicrob_Tratamento`
--
ALTER TABLE `TabSismicrob_Tratamento`
  ADD PRIMARY KEY (`idTabSismicrob_Tratamento`);

--
-- Índices de tabela `TabSismicrob_ViaAdministracao`
--
ALTER TABLE `TabSismicrob_ViaAdministracao`
  ADD PRIMARY KEY (`idTabSismicrob_ViaAdministracao`),
  ADD UNIQUE KEY `ViaAdministracao_UNIQUE` (`ViaAdministracao`);

--
-- Índices de tabela `Tab_Modulo`
--
ALTER TABLE `Tab_Modulo`
  ADD PRIMARY KEY (`idTab_Modulo`);

--
-- Índices de tabela `Tab_Perfil`
--
ALTER TABLE `Tab_Perfil`
  ADD PRIMARY KEY (`idTab_Perfil`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Preschuap_Agenda`
--
ALTER TABLE `Preschuap_Agenda`
  MODIFY `idPreschuap_Agenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Preschuap_Prescricao`
--
ALTER TABLE `Preschuap_Prescricao`
  MODIFY `idPreschuap_Prescricao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Preschuap_Prescricao_Medicamento`
--
ALTER TABLE `Preschuap_Prescricao_Medicamento`
  MODIFY `idPreschuap_Prescricao_Medicamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_Auditoria`
--
ALTER TABLE `Sishuap_Auditoria`
  MODIFY `idSishuap_Auditoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_AuditoriaAcesso`
--
ALTER TABLE `Sishuap_AuditoriaAcesso`
  MODIFY `idSishuap_AuditoriaAcesso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_AuditoriaLog`
--
ALTER TABLE `Sishuap_AuditoriaLog`
  MODIFY `idSishuap_AuditoriaLog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_Perfil`
--
ALTER TABLE `Sishuap_Perfil`
  MODIFY `idSishuap_Perfil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_PermissaoModulo`
--
ALTER TABLE `Sishuap_PermissaoModulo`
  MODIFY `idSishuap_PermissaoModulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_PermissaoModulo_BKP`
--
ALTER TABLE `Sishuap_PermissaoModulo_BKP`
  MODIFY `idSishuap_PermissaoModulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_Usuario`
--
ALTER TABLE `Sishuap_Usuario`
  MODIFY `idSishuap_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sishuap_Usuario_BKP`
--
ALTER TABLE `Sishuap_Usuario_BKP`
  MODIFY `idSishuap_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Sismicrob_Tratamento`
--
ALTER TABLE `Sismicrob_Tratamento`
  MODIFY `idSismicrob_Tratamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Alergia`
--
ALTER TABLE `TabPreschuap_Alergia`
  MODIFY `idTabPreschuap_Alergia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Diluente`
--
ALTER TABLE `TabPreschuap_Diluente`
  MODIFY `idTabPreschuap_Diluente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_EtapaTerapia`
--
ALTER TABLE `TabPreschuap_EtapaTerapia`
  MODIFY `idTabPreschuap_EtapaTerapia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Formula`
--
ALTER TABLE `TabPreschuap_Formula`
  MODIFY `idTabPreschuap_Formula` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Medicamento`
--
ALTER TABLE `TabPreschuap_Medicamento`
  MODIFY `idTabPreschuap_Medicamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_MotivoAjusteDose`
--
ALTER TABLE `TabPreschuap_MotivoAjusteDose`
  MODIFY `idTabPreschuap_MotivoAjusteDose` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_MotivoCancelamento`
--
ALTER TABLE `TabPreschuap_MotivoCancelamento`
  MODIFY `idTabPreschuap_MotivoCancelamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Posologia`
--
ALTER TABLE `TabPreschuap_Posologia`
  MODIFY `idTabPreschuap_Posologia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Protocolo`
--
ALTER TABLE `TabPreschuap_Protocolo`
  MODIFY `idTabPreschuap_Protocolo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_Protocolo_Medicamento`
--
ALTER TABLE `TabPreschuap_Protocolo_Medicamento`
  MODIFY `idTabPreschuap_Protocolo_Medicamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_TipoAgendamento`
--
ALTER TABLE `TabPreschuap_TipoAgendamento`
  MODIFY `idTabPreschuap_TipoAgendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_TipoTerapia`
--
ALTER TABLE `TabPreschuap_TipoTerapia`
  MODIFY `idTabPreschuap_TipoTerapia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_UnidadeMedida`
--
ALTER TABLE `TabPreschuap_UnidadeMedida`
  MODIFY `idTabPreschuap_UnidadeMedida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabPreschuap_ViaAdministracao`
--
ALTER TABLE `TabPreschuap_ViaAdministracao`
  MODIFY `idTabPreschuap_ViaAdministracao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_AntibioticoMantido`
--
ALTER TABLE `TabSismicrob_AntibioticoMantido`
  MODIFY `idTabSismicrob_AntibioticoMantido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_DiagnosticoInfeccioso`
--
ALTER TABLE `TabSismicrob_DiagnosticoInfeccioso`
  MODIFY `idTabSismicrob_DiagnosticoInfeccioso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Especialidade`
--
ALTER TABLE `TabSismicrob_Especialidade`
  MODIFY `idTabSismicrob_Especialidade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Indicacao`
--
ALTER TABLE `TabSismicrob_Indicacao`
  MODIFY `idTabSismicrob_Indicacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Infeccao`
--
ALTER TABLE `TabSismicrob_Infeccao`
  MODIFY `idTabSismicrob_Infeccao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Produto`
--
ALTER TABLE `TabSismicrob_Produto`
  MODIFY `idTabSismicrob_Produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Substituicao`
--
ALTER TABLE `TabSismicrob_Substituicao`
  MODIFY `idTabSismicrob_Substituicao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_Tratamento`
--
ALTER TABLE `TabSismicrob_Tratamento`
  MODIFY `idTabSismicrob_Tratamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `TabSismicrob_ViaAdministracao`
--
ALTER TABLE `TabSismicrob_ViaAdministracao`
  MODIFY `idTabSismicrob_ViaAdministracao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Tab_Modulo`
--
ALTER TABLE `Tab_Modulo`
  MODIFY `idTab_Modulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Tab_Perfil`
--
ALTER TABLE `Tab_Perfil`
  MODIFY `idTab_Perfil` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Preschuap_Agenda`
--
ALTER TABLE `Preschuap_Agenda`
  ADD CONSTRAINT `fk_Preschuap_Agenda_Preschuap_Prescricao1` FOREIGN KEY (`idPreschuap_Prescricao`) REFERENCES `Preschuap_Prescricao` (`idPreschuap_Prescricao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Preschuap_Prescricao`
--
ALTER TABLE `Preschuap_Prescricao`
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Sishuap_Usuario1` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_TabPreschuap_Categoria1` FOREIGN KEY (`idTabPreschuap_Categoria`) REFERENCES `TabPreschuap_Categoria` (`idTabPreschuap_Categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_TabPreschuap_MotivoCancelamento1` FOREIGN KEY (`idTabPreschuap_MotivoCancelamento`) REFERENCES `TabPreschuap_MotivoCancelamento` (`idTabPreschuap_MotivoCancelamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_TabPreschuap_Protocolo1` FOREIGN KEY (`idTabPreschuap_Protocolo`) REFERENCES `TabPreschuap_Protocolo` (`idTabPreschuap_Protocolo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_TabPreschuap_Subcategoria1` FOREIGN KEY (`idTabPreschuap_Subcategoria`) REFERENCES `TabPreschuap_Subcategoria` (`idTabPreschuap_Subcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_TabPreschuap_TipoTerapia1` FOREIGN KEY (`idTabPreschuap_TipoTerapia`) REFERENCES `TabPreschuap_TipoTerapia` (`idTabPreschuap_TipoTerapia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Preschuap_Prescricao_Medicamento`
--
ALTER TABLE `Preschuap_Prescricao_Medicamento`
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_Preschuap_Prescricao1` FOREIGN KEY (`idPreschuap_Prescricao`) REFERENCES `Preschuap_Prescricao` (`idPreschuap_Prescricao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Diluente1` FOREIGN KEY (`idTabPreschuap_Diluente`) REFERENCES `TabPreschuap_Diluente` (`idTabPreschuap_Diluente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_EtapaTerapia1` FOREIGN KEY (`idTabPreschuap_EtapaTerapia`) REFERENCES `TabPreschuap_EtapaTerapia` (`idTabPreschuap_EtapaTerapia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Medicamento1` FOREIGN KEY (`idTabPreschuap_Medicamento`) REFERENCES `TabPreschuap_Medicamento` (`idTabPreschuap_Medicamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_MotivoAjuste1` FOREIGN KEY (`idTabPreschuap_MotivoAjusteDose`) REFERENCES `TabPreschuap_MotivoAjusteDose` (`idTabPreschuap_MotivoAjusteDose`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Posologia1` FOREIGN KEY (`idTabPreschuap_Posologia`) REFERENCES `TabPreschuap_Posologia` (`idTabPreschuap_Posologia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Protocolo1` FOREIGN KEY (`idTabPreschuap_Protocolo`) REFERENCES `TabPreschuap_Protocolo` (`idTabPreschuap_Protocolo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_Protocolo_Me1` FOREIGN KEY (`idTabPreschuap_Protocolo_Medicamento`) REFERENCES `TabPreschuap_Protocolo_Medicamento` (`idTabPreschuap_Protocolo_Medicamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_UnidadeMedida1` FOREIGN KEY (`idTabPreschuap_UnidadeMedida`) REFERENCES `TabPreschuap_UnidadeMedida` (`idTabPreschuap_UnidadeMedida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preschuap_Prescricao_Medicamento_TabPreschuap_ViaAdministr1` FOREIGN KEY (`idTabPreschuap_ViaAdministracao`) REFERENCES `TabPreschuap_ViaAdministracao` (`idTabPreschuap_ViaAdministracao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sishuap_Auditoria`
--
ALTER TABLE `Sishuap_Auditoria`
  ADD CONSTRAINT `fk_Sishuap_Auditoria_Sishuap_Usuario` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sishuap_AuditoriaAcesso`
--
ALTER TABLE `Sishuap_AuditoriaAcesso`
  ADD CONSTRAINT `fk_Sishuap_AuditoriaAcesso_Sishuap_Usuario1` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sishuap_AuditoriaAcesso_Tab_Modulo1` FOREIGN KEY (`idTab_Modulo`) REFERENCES `Tab_Modulo` (`idTab_Modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sishuap_AuditoriaLog`
--
ALTER TABLE `Sishuap_AuditoriaLog`
  ADD CONSTRAINT `fk_Sishuap_AuditoriaLog_Sishuap_Auditoria1` FOREIGN KEY (`idSishuap_Auditoria`) REFERENCES `Sishuap_Auditoria` (`idSishuap_Auditoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sishuap_Perfil`
--
ALTER TABLE `Sishuap_Perfil`
  ADD CONSTRAINT `fk_Sishuap_Perfil_Sishuap_Usuario1` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sishuap_Perfil_Tab_Perfil1` FOREIGN KEY (`idTab_Perfil`) REFERENCES `Tab_Perfil` (`idTab_Perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sishuap_PermissaoModulo`
--
ALTER TABLE `Sishuap_PermissaoModulo`
  ADD CONSTRAINT `fk_Sishuap_PermissaoModulo_Sishuap_Usuario1` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sishuap_PermissaoModulo_Tab_Modulo1` FOREIGN KEY (`idTab_Modulo`) REFERENCES `Tab_Modulo` (`idTab_Modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `Sismicrob_Tratamento`
--
ALTER TABLE `Sismicrob_Tratamento`
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_Sishuap_Usuario1` FOREIGN KEY (`idSishuap_Usuario`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_Sishuap_Usuario2` FOREIGN KEY (`idSishuap_Usuario1`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_Sishuap_Usuario3` FOREIGN KEY (`idSishuap_Usuario2`) REFERENCES `Sishuap_Usuario` (`idSishuap_Usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_AntibioticoMantido1` FOREIGN KEY (`idTabSismicrob_AntibioticoMantido`) REFERENCES `TabSismicrob_AntibioticoMantido` (`idTabSismicrob_AntibioticoMantido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_DiagnosticoInfeccioso1` FOREIGN KEY (`idTabSismicrob_DiagnosticoInfeccioso`) REFERENCES `TabSismicrob_DiagnosticoInfeccioso` (`idTabSismicrob_DiagnosticoInfeccioso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Especialidade1` FOREIGN KEY (`idTabSismicrob_Especialidade`) REFERENCES `TabSismicrob_Especialidade` (`idTabSismicrob_Especialidade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Indicacao1` FOREIGN KEY (`idTabSismicrob_Indicacao`) REFERENCES `TabSismicrob_Indicacao` (`idTabSismicrob_Indicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Infeccao1` FOREIGN KEY (`idTabSismicrob_Infeccao`) REFERENCES `TabSismicrob_Infeccao` (`idTabSismicrob_Infeccao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Intervalo1` FOREIGN KEY (`idTabSismicrob_Intervalo`) REFERENCES `TabSismicrob_Intervalo` (`idTabSismicrob_Intervalo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Substituicao1` FOREIGN KEY (`idTabSismicrob_Substituicao`) REFERENCES `TabSismicrob_Substituicao` (`idTabSismicrob_Substituicao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_Tratamento1` FOREIGN KEY (`idTabSismicrob_Tratamento`) REFERENCES `TabSismicrob_Tratamento` (`idTabSismicrob_Tratamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Sismicrob_Tratamento_TabSismicrob_ViaAdministracao1` FOREIGN KEY (`idTabSismicrob_ViaAdministracao`) REFERENCES `TabSismicrob_ViaAdministracao` (`idTabSismicrob_ViaAdministracao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `TabPreschuap_Protocolo`
--
ALTER TABLE `TabPreschuap_Protocolo`
  ADD CONSTRAINT `fk_TabPreschuap_Protocolo_TabPreschuap_Categoria1` FOREIGN KEY (`idTabPreschuap_Categoria`) REFERENCES `TabPreschuap_Categoria` (`idTabPreschuap_Categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Protocolo_TabPreschuap_TipoAgendamento1` FOREIGN KEY (`idTabPreschuap_TipoAgendamento`) REFERENCES `TabPreschuap_TipoAgendamento` (`idTabPreschuap_TipoAgendamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Protocolo_TabPreschuap_TipoTerapia1` FOREIGN KEY (`idTabPreschuap_TipoTerapia`) REFERENCES `TabPreschuap_TipoTerapia` (`idTabPreschuap_TipoTerapia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `TabPreschuap_Protocolo_Medicamento`
--
ALTER TABLE `TabPreschuap_Protocolo_Medicamento`
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_Diluente1` FOREIGN KEY (`idTabPreschuap_Diluente`) REFERENCES `TabPreschuap_Diluente` (`idTabPreschuap_Diluente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_Medicamento1` FOREIGN KEY (`idTabPreschuap_Medicamento`) REFERENCES `TabPreschuap_Medicamento` (`idTabPreschuap_Medicamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_Posologia1` FOREIGN KEY (`idTabPreschuap_Posologia`) REFERENCES `TabPreschuap_Posologia` (`idTabPreschuap_Posologia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_Protocolo1` FOREIGN KEY (`idTabPreschuap_Protocolo`) REFERENCES `TabPreschuap_Protocolo` (`idTabPreschuap_Protocolo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_UnidadeMedida1` FOREIGN KEY (`idTabPreschuap_UnidadeMedida`) REFERENCES `TabPreschuap_UnidadeMedida` (`idTabPreschuap_UnidadeMedida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Prot_Med_TabPreschuap_ViaAdministracao1` FOREIGN KEY (`idTabPreschuap_ViaAdministracao`) REFERENCES `TabPreschuap_ViaAdministracao` (`idTabPreschuap_ViaAdministracao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TabPreschuap_Protocolo_Medicamento_TabPreschuap_EtapaTerap1` FOREIGN KEY (`idTabPreschuap_EtapaTerapia`) REFERENCES `TabPreschuap_EtapaTerapia` (`idTabPreschuap_EtapaTerapia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `TabPreschuap_UnidadeMedida`
--
ALTER TABLE `TabPreschuap_UnidadeMedida`
  ADD CONSTRAINT `fk_TabPreschuap_UnidadeMedida_TabPreschuap_Formula1` FOREIGN KEY (`idTabPreschuap_Formula`) REFERENCES `TabPreschuap_Formula` (`idTabPreschuap_Formula`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
