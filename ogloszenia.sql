-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2026 at 09:41 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ogloszenia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `cena` decimal(10,2) NOT NULL,
  `status` enum('dostepny','sprzedany') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data_dodania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `nazwa`, `opis`, `cena`, `status`, `user_id`, `data_dodania`) VALUES
(1, 'Lap top Dell xxx', 'Stan dobry 2021', 2500.00, 'sprzedany', 1, '2026-04-15 21:08:25'),
(2, 'hjfjhfgj', 'grhgruhugir', 250.00, 'sprzedany', 2, '2026-04-15 21:14:38'),
(3, 'ttht', 'trhrthth', 250.00, 'sprzedany', 2, '2026-04-15 21:15:30'),
(4, 'fhgfhgiur', 'ergrhrh', 2000.00, 'dostepny', 1, '2026-04-15 21:50:35'),
(5, 'Kamera Sony A112', 'Kompletny zestaw z obiektywem ', 4000.00, 'dostepny', 3, '2026-04-15 21:56:07'),
(6, 'hghg', 'fgfhbgf', 1000.00, 'sprzedany', 3, '2026-04-15 21:56:35'),
(7, 'hgghh', 'uyuffhgjhgh', 500.00, 'sprzedany', 1, '2026-04-15 22:09:43'),
(8, 'gjgvggvgh', 'hgvhgv', 5560.00, 'dostepny', 3, '2026-04-15 22:18:21'),
(9, 'as', 'ghtyhtyhythtyh', 3232.00, 'sprzedany', 3, '2026-04-15 22:39:50'),
(10, 'hyhytghgty', 'htyhghggfgfgh', 123.00, 'dostepny', 3, '2026-04-17 09:23:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`) VALUES
(1, 'Samanta', '$2y$10$Cj8N4EKfmXHGc5xgjp1eWOyj6JjFH7.0xRhHqz5mRJ8tCXjpQVno.', 'samanta@gmail.pl'),
(2, 'a_11', '$2y$10$SOAKBB4aeOQjSNJVHYBVa.U.qHHrk4UJT1RSvGlBHa.txjkkAX3nO', 'alicja@gmail.com'),
(3, 'tymon_k', '$2y$10$rD/52AeGqdCay25AOP3wU.e0hDLkwEx9.VR7bgAuONGfQerixjeu2', 'tymon@gmail.pl'),
(4, 'kasia', '$2y$10$fAdnObiTegoLkZT5l9uvYOAJCTgE/gG7MpdjfyEvVMi.qTgXhmtzi', 'kasia@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zakupy`
--

CREATE TABLE `zakupy` (
  `id` int(11) NOT NULL,
  `produkt_id` int(11) DEFAULT NULL,
  `kupujacy_id` int(11) DEFAULT NULL,
  `data_zakupu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zakupy`
--

INSERT INTO `zakupy` (`id`, `produkt_id`, `kupujacy_id`, `data_zakupu`) VALUES
(1, 1, 2, '2026-04-15 21:41:17'),
(2, 2, 1, '2026-04-15 21:50:49'),
(3, 6, 1, '2026-04-15 22:10:42'),
(4, 7, 3, '2026-04-15 22:13:47'),
(5, 3, 3, '2026-04-17 09:23:10'),
(6, 9, 1, '2026-04-17 09:39:25');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `zakupy`
--
ALTER TABLE `zakupy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produkt_id` (`produkt_id`),
  ADD KEY `kupujacy_id` (`kupujacy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zakupy`
--
ALTER TABLE `zakupy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `zakupy`
--
ALTER TABLE `zakupy`
  ADD CONSTRAINT `zakupy_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkty` (`id`),
  ADD CONSTRAINT `zakupy_ibfk_2` FOREIGN KEY (`kupujacy_id`) REFERENCES `uzytkownicy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
