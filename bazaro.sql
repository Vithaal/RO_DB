-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Lip 2017, 09:24
-- Wersja serwera: 10.1.24-MariaDB
-- Wersja PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bazaro`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `idklienta` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `firma` text COLLATE utf8_polish_ci NOT NULL,
  `ulica` text COLLATE utf8_polish_ci NOT NULL,
  `kodpocztowy` text COLLATE utf8_polish_ci NOT NULL,
  `miejscowosc` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`idklienta`, `imie`, `nazwisko`, `firma`, `ulica`, `kodpocztowy`, `miejscowosc`, `telefon`, `email`) VALUES
(4, '', '', 'RO', 'Poleczki 35', '02-822', 'Warszawa', '0', ''),
(5, 'Slava', 'Lvovich', 'RO', 'Poleczki 35', '02-822', 'Warszawa', '783-002-232', 'slava@robocam.info'),
(6, 'Piotr', 'Kiepas', '', '', '', 'Warszawa', '728-144-610', ''),
(7, '', 'Dziedzicki', '', '', '', '', '0', ''),
(8, '', 'Rogalski', 'Dental Labor Rogalski Sp. z o.o.', 'Wiosenna 7', '70-807', 'Szczecin', '+48-694-415-846', 'biuro@dental-labor.pl'),
(9, 'Monika', 'Madej', 'Onildent', '', '', '', '509-971-361', 'sebastiansiuta@op.pl'),
(10, '', '', 'Redent', '', '', '', '503-006-410', 'redent@wp.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `skanery`
--

CREATE TABLE `skanery` (
  `idskanera` int(11) NOT NULL,
  `firma` text COLLATE utf8_polish_ci NOT NULL,
  `model` text COLLATE utf8_polish_ci NOT NULL,
  `nrseryjny` text COLLATE utf8_polish_ci NOT NULL,
  `typ` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `skanery`
--

INSERT INTO `skanery` (`idskanera`, `firma`, `model`, `nrseryjny`, `typ`) VALUES
(1, 'Medit', 'Identica Blue', 'BL1402052133', 'demo'),
(2, 'Medit', 'Identica Hybrid', '1H16061L8792', 'standard'),
(3, 'Medit', 'Identica Hybrid', '1H17011L9431\r\n', 'standard'),
(4, 'Medit', 'Identica Hybrid', '1H17011L9432', 'standard'),
(5, 'Medit', 'Identica Hybrid', '1H17021L9475', 'standard'),
(6, 'Medit', 'Identica Hybrid', '1H17021L9467', 'standard'),
(7, 'Medit', 'Identica Hybrid', '1H16121L9304', 'standard'),
(8, 'Medit', 'Identica Hybrid', '1H16121L9305', 'standard'),
(9, 'Medit', 'Identica Hybrid', '1H17021L9468', 'standard'),
(10, 'Medit', 'Identica Hybrid', '1H17031L9597', 'standard'),
(11, 'Medit', 'T500', '1M17051DA142', 'standard'),
(12, 'Medit', 'T500', '1M17051DA143', 'standard'),
(13, 'Medit', 'T500', '1M17051DA144', 'standard'),
(14, 'Medit', 'T500', '1M17051DA145', 'standard'),
(15, 'Medit', 'T500', '1M17051DA146', 'standard'),
(16, 'Medit', 'T500', '1M17051DA147', 'standard'),
(17, 'Medit', 'T500', '1M17051DA148', 'standard'),
(18, 'Medit', 'T500', '1M17051DA149', 'standard'),
(19, 'Medit', 'T500', '1M17051DA150', 'standard'),
(20, 'Medit', 'T500', '1M17051DA151', 'standard'),
(21, 'Medit', 'Identica Hybrid', '1H17031L9559', 'standard');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `idzamowienia` int(11) NOT NULL,
  `idklienta` int(11) NOT NULL,
  `idskanera` int(11) NOT NULL,
  `data` date NOT NULL,
  `status` text COLLATE utf8_polish_ci NOT NULL,
  `uwagi` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`idklienta`);

--
-- Indexes for table `skanery`
--
ALTER TABLE `skanery`
  ADD PRIMARY KEY (`idskanera`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`idzamowienia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `idklienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `skanery`
--
ALTER TABLE `skanery`
  MODIFY `idskanera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `idzamowienia` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
