-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 11 2022 г., 22:23
-- Версия сервера: 5.7.19
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zorin_golev_kp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `academic_year`
--

CREATE TABLE `academic_year` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `academic_year`
--

INSERT INTO `academic_year` (`id`, `mode`) VALUES
(2021, 'Открыт'),
(2022, 'Открыт'),
(2023, 'Открыт'),
(2024, 'Открыт');

-- --------------------------------------------------------

--
-- Структура таблицы `actives`
--

CREATE TABLE `actives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `actives`
--

INSERT INTO `actives` (`id`, `Name`) VALUES
(1, 'Староста'),
(2, 'Не состоит в активе');

-- --------------------------------------------------------

--
-- Структура таблицы `branch`
--

CREATE TABLE `branch` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Number` int(11) NOT NULL,
  `Supervisor` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `branch`
--

INSERT INTO `branch` (`id`, `Name`, `Number`, `Supervisor`) VALUES
(1, 'Общеобразовательная подготовка', 1, 'Бирюкова Юлия Юрьевна'),
(2, 'Информационные технологии и транспорт', 2, 'Сидорова Наталья Викторовна'),
(3, 'Механическое, гидравлическое оборудование и металлургия', 3, 'Науменко Оксана Петровна'),
(4, 'Строительство, экономика и сфера обслуживания', 4, 'Закирова Лилия Анатольевна');

-- --------------------------------------------------------

--
-- Структура таблицы `classhour`
--

CREATE TABLE `classhour` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Month` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `id_group` bigint(20) UNSIGNED NOT NULL,
  `id_academicYear` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `classhour`
--

INSERT INTO `classhour` (`id`, `Month`, `Date`, `Subject`, `qty`, `id_group`, `id_academicYear`) VALUES
(1, 'May', '2022-06-15', 'Скажем курению «Нет!»', 2, 2, 2021),
(2, 'June', '2022-06-22', 'Что нами движет при выборе профессии?', 5, 2, 2021),
(3, 'June', '2022-06-22', 'Снежная уборка', 5, 1, 2021),
(4, 'June', '2022-06-22', 'Грязь на улицах города!', 5, 1, 2021);

-- --------------------------------------------------------

--
-- Структура таблицы `conversation`
--

CREATE TABLE `conversation` (
  `id` int(10) UNSIGNED NOT NULL,
  `Date` date NOT NULL,
  `Reason` varchar(150) NOT NULL,
  `Note` varchar(150) NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `conversation`
--

INSERT INTO `conversation` (`id`, `Date`, `Reason`, `Note`, `id_student`) VALUES
(1, '2022-06-30', 'Курение на территории учебного заведения', 'Отсутствует', 2),
(2, '2022-06-01', 'Распитие алкогольных напитков', 'Во время проведения занятия', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Month` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `id_typeofevent` bigint(20) UNSIGNED NOT NULL,
  `id_academicYear` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `Name`, `Month`, `Date`, `id_typeofevent`, `id_academicYear`) VALUES
(1, 'Путь к успеху', 'Январь', '2022-01-06', 1, 2021),
(2, 'ГТО', 'Май', '2022-05-25', 3, 2021),
(3, '\"Все на субботник\"', 'Июнь', '2022-06-01', 4, 2021),
(4, 'Кибердром', 'Февраль', '2022-02-12', 1, 2021);

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE `group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Year` year(4) NOT NULL,
  `id_specialty` bigint(20) UNSIGNED NOT NULL,
  `id_roles` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`id`, `Name`, `Year`, `id_specialty`, `id_roles`) VALUES
(1, 'ИСп-19-1', 2019, 1, 5),
(2, 'ИСп-19-2', 2019, 1, 5),
(3, 'ИСп-19-3', 2019, 1, 5),
(4, 'ИСп-19-4', 2019, 1, 6),
(5, 'АТп-19-1', 2019, 5, 6),
(6, 'Мг-19-1', 2019, 6, 6),
(7, 'АТп-19-2', 2019, 5, 6),
(8, 'Мг-19-2', 2019, 6, 6),
(9, 'ЗиК-19-1', 2019, 7, 6),
(10, 'ЗиК-19-2', 2019, 7, 6),
(11, 'Мэ-19-1', 2019, 8, 7),
(12, 'Мэ-19-2', 2019, 8, 7),
(13, 'С-19-1', 2019, 2, 7),
(14, 'С-19-2', 2019, 2, 7),
(15, 'Мр-19-1', 2019, 3, 7),
(16, 'Мр-19-2', 2019, 3, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `healthgroup`
--

CREATE TABLE `healthgroup` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Recommendations` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `healthgroup`
--

INSERT INTO `healthgroup` (`id`, `Name`, `Description`, `Recommendations`) VALUES
(1, 'Первая', 'Дети здоровые, с нормальным развитием и нормальным уровнем функций, и дети, имеющие внешние компенсированные врожденные дефекты развития.', 'Отсутствует'),
(2, 'Вторая', 'Дети здоровые, но с факторами риска по возникновению патологии, функциональными и некоторыми морфологическими отклонениями, хроническими заболеваниями в стадии стойкой клинико-лабораторной ремиссии не менее 3-5 лет, врожденными пороками развития, не осложненными заболеваниями одноименного органа или нарушением его функции, а также со сниженной сопротивляемостью к острым и хроническим заболеваниям.', 'Отсутствует'),
(3, 'Третья', 'Дети с хроническими заболеваниями и врожденными пороками развития разной степени активности и компенсации, с сохраненными функциональными возможностями.', 'Отсутствует'),
(4, 'Четвертая', 'Дети, имеющие значительные отклонения в состоянии здоровья постоянного (хронические заболевания в стадии субкомпенсации) или временного характера, но без выраженного нарушения самочувствия, со сниженными функциональными возможностями.\r\n\r\n', 'Отсутствует'),
(5, 'Пятая', 'Дети, больные хроническими заболеваниями в состоянии декомпенсации, со значительно сниженными функциональными возможностями.', 'Отсутствует');

-- --------------------------------------------------------

--
-- Структура таблицы `hostelschedule`
--

CREATE TABLE `hostelschedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Month` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Note` varchar(100) NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `id_academicYear` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hostelschedule`
--

INSERT INTO `hostelschedule` (`id`, `Month`, `Date`, `Note`, `id_student`, `id_academicYear`) VALUES
(1, 'Maй', '2022-06-24', 'Общежитие', 1, 2021);

-- --------------------------------------------------------

--
-- Структура таблицы `instructor`
--

CREATE TABLE `instructor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Surname` varchar(150) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Patronymic` varchar(100) NOT NULL,
  `Phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `instructor`
--

INSERT INTO `instructor` (`id`, `Surname`, `Name`, `Patronymic`, `Phone`) VALUES
(1, 'Юсупова', 'Алия', 'Азатовна', '89997776655'),
(2, 'Кумысов', 'Камил', 'Максимович', '89172281337');

-- --------------------------------------------------------

--
-- Структура таблицы `parent`
--

CREATE TABLE `parent` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Surname` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Patronymic` varchar(100) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parent`
--

INSERT INTO `parent` (`id`, `Surname`, `Name`, `Patronymic`, `Phone`, `Address`) VALUES
(1, 'Зорин', 'Пётр', 'Петрович', '88005003516', 'Москва'),
(2, 'Зорина', 'Елена', 'Александровна', '88005003516', 'Москва'),
(3, 'Голева', 'Наталья', 'Александровна', '89024701469', 'Питер'),
(4, 'Голев', 'Евгений', 'Анатольевич', '89024701469', 'Питер'),
(5, 'Хабитова', 'Олеся', 'Юрьевна', '89024701469', 'Питер'),
(6, 'Хабитов', 'Хабла', 'Олегович', '89024701469', 'Питер'),
(7, 'Назайнова', 'Дарья', 'Андреевна', '89024701469', 'Питер'),
(8, 'Назайнов', 'Сергей', 'Петров', '89024701469', 'Питер'),
(9, 'Кылысбаев', 'Мударис', 'Мударисович', '89024701469', 'Питер'),
(10, 'Кылысбаева', 'Ольга', 'Петровна', '89024701469', 'Питер');

-- --------------------------------------------------------

--
-- Структура таблицы `parentsmeeting`
--

CREATE TABLE `parentsmeeting` (
  `id` int(10) UNSIGNED NOT NULL,
  `Month` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `qty` varchar(50) NOT NULL,
  `id_group` bigint(20) UNSIGNED NOT NULL,
  `id_academicYear` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parentsmeeting`
--

INSERT INTO `parentsmeeting` (`id`, `Month`, `Date`, `Subject`, `qty`, `id_group`, `id_academicYear`) VALUES
(1, 'Декабрь', '2021-12-17', '\"Психофизиологические особенности раннего юношества\"', '27', 2, 2021),
(2, 'Май', '2022-05-15', '\"Взаимодействие и общение детей и родителей\"', '23', 8, 2021),
(3, 'Сентябрь', '2021-09-01', '\"Начало учебного года\"', '26', 11, 2021),
(4, 'Октябрь', '2021-10-09', '\"Влияние мотивации на успеваемость\"', '17', 14, 2021),
(5, 'Май', '2022-05-10', '\"Предстоящая производственная деятельность\"', '26', 2, 2021),
(6, 'Май', '2022-05-25', '\"Государственная аттестация. Как к ней подготовиться?\"', '28', 3, 2021),
(7, 'Май', '2022-05-25', '\"Государственная аттестация. Как к ней подготовиться?\"', '28', 1, 2021),
(8, 'Май', '2022-05-10', '\"Предстоящая производственная деятельность\"', '26', 1, 2021);

-- --------------------------------------------------------

--
-- Структура таблицы `parenttype`
--

CREATE TABLE `parenttype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parenttype`
--

INSERT INTO `parenttype` (`id`, `Name`) VALUES
(1, 'Советник'),
(2, 'Игнорщик');

-- --------------------------------------------------------

--
-- Структура таблицы `participationevents`
--

CREATE TABLE `participationevents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Result` varchar(150) NOT NULL,
  `id_event` bigint(20) UNSIGNED NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `participationevents`
--

INSERT INTO `participationevents` (`id`, `Result`, `id_event`, `id_student`) VALUES
(1, 'Золотая медаль', 2, 1),
(2, 'Золотая медаль', 2, 3),
(3, 'Бронзовая медаль', 2, 2),
(4, '1 место', 3, 2),
(5, '2 место', 3, 1),
(6, '3 место', 3, 3),
(7, '1 место', 1, 1),
(8, '1 место', 4, 1),
(9, '1 место', 4, 3),
(10, '5 место', 4, 8),
(11, '6 место', 4, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `selected_group_id` bigint(20) UNSIGNED
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `login`, `password`, `role`) VALUES
(1, 'Голев Максим Андреевич', 'skarp@mail.ru', 'golev123', 'developer'),
(2, 'Зорин Ян Игоревич', 'yanco@mail.ru', 'yanco123', 'developer'),
(3, 'admin', 'admin', '$2y$10$.rxnKvi/NRAth/v./JLYbOcbygmzEJmpnGy2RnYY8E2vDp7vHIrkC', 'ROLE_ADMIN'),
(4, 'instructor', 'instructor', '$2y$10$MYhiyRQaxT7OeIetPfNQv.lkeNUZbj03spgKrT2ril5XQNc3gjqyC', 'ROLE_INSTRUCTOR'),
(5, 'Зорина Ирина Геннадьевна', 'zorina_i', '$2y$10$flcAEAWBQ3AJwoGTsWxuO.yr1rXErFB12UxbsrFERWtFNh.Ww2.du', 'ROLE_INSTRUCTOR'),
(6, 'Закирова Регина Артуровна', 'zakirova_r', '$2y$10$jC6J61euvwqQVJ9OH553T.vhFBnUxv1HrcM5NgP7vneDQs.C7B9N2', 'ROLE_INSTRUCTOR'),
(7, 'Балашова Ирина Анатольевна', 'balashova_a', '$2y$10$RMTXctmAlRU9p9WuCk8jv.fv6scfCBrqaI61.FRo0ytxUWa.6QS2G', 'ROLE_INSTRUCTOR');

-- --------------------------------------------------------

--
-- Структура таблицы `specialty`
--

CREATE TABLE `specialty` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Cipher` varchar(50) NOT NULL,
  `id_branch` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `specialty`
--

INSERT INTO `specialty` (`id`, `Name`, `Cipher`, `id_branch`) VALUES
(1, 'Информационные системы и программирование', '09.02.07', 2),
(2, 'Строительство и эксплуатация зданий и сооружений', '08.02.01', 1),
(3, 'Монтаж, наладка и эксплуатация электрооборудования промышленных и гражданских зданий', '08.02.09', 1),
(4, 'Компьютерные системы и комплексы', '09.02.01', 2),
(5, 'Техническая эксплуатация гидравлических машин, гидроприводов и гидропневмоавтоматики', '15.02.03', 3),
(6, 'Монтаж, техническое обслуживание и ремонт промышленного оборудования (по отраслям)', '15.02.12', 3),
(7, 'Строительство и эксплуатация зданий и сооружений', '08.02.01', 4),
(8, 'Монтаж, наладка и эксплуатация электрооборудования промышленных и гражданских зданий', '08.02.09', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `Name`) VALUES
(1, 'Обычный');

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Surname` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Patronymic` varchar(100) NOT NULL,
  `DateOfBirthday` date NOT NULL,
  `Address` varchar(1000) NOT NULL,
  `Actual_address` varchar(1000) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Hostel` varchar(20) NOT NULL,
  `id_group` bigint(20) UNSIGNED NOT NULL,
  `id_healthGroup` bigint(20) UNSIGNED NOT NULL,
  `id_actives` bigint(20) UNSIGNED NOT NULL,
  `id_status` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `Surname`, `Name`, `Patronymic`, `DateOfBirthday`, `Address`, `Actual_address`, `Phone`, `Hostel`, `id_group`, `id_healthGroup`, `id_actives`, `id_status`) VALUES
(1, 'Зорин', 'Ян', 'Игоревич', '2003-09-12', 'ул.Жукова, 16-78', 'ул.Жукова, 16-78', '89193043332', 'Нет', 2, 1, 1, 1),
(2, 'Голев', 'Максим', 'Андреевич', '2002-11-26', 'ул.Октябрьская, 4-72', 'ул.Октябрьская, 4-72', '89093542332', 'Нет', 2, 1, 2, 1),
(3, 'Кылысбаев', 'Камиль', 'Мударисович', '2003-11-19', 'ул.Бурибайская, 1-2', 'ул.Грязнова 36/2', '89172281337', 'Да', 2, 1, 2, 1),
(4, 'Голиков', 'Максимильян', 'Борисович', '2002-11-27', 'ул.Октябрьская, 38-72', 'ул.Октябрьская, 38-72', '89193453225', 'Нет', 4, 2, 2, 1),
(5, 'Притула', 'Ян', 'Александрович', '2003-09-02', 'пр.Карла Маркса, 178-123', 'пр.Карла Маркса, 178-123', '89092352197', 'Нет', 7, 1, 2, 1),
(6, 'Демитрова', 'Карина', 'Максимовна', '2003-06-15', 'ул.Зеленый Лог, 21-56', 'ул.Зеленый Лог, 21-56', '89173674562', 'Нет', 9, 1, 2, 1),
(7, 'Кулусбаев', 'Алмаз', 'Петрович', '2002-10-23', 'ул.Бутубайская, 23-1', 'ул.Грязнова, 36/1', '89027651345', 'Да', 4, 3, 2, 1),
(8, 'Хабитова', 'Алсу', 'Азаматовна', '2002-10-23', 'ул.Бутубайская, 23-1', 'ул.Грязнова, 36/1', '89027651345', 'Да', 1, 3, 2, 1),
(9, 'Назайнова', 'Карина', 'Александровна', '2003-10-11', 'ул.Бутубайская, 23-1', 'ул.Грязнова, 36/1', '89027651345', 'Да', 1, 3, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `student_parent_typeofparent`
--

CREATE TABLE `student_parent_typeofparent` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `id_parent` bigint(20) UNSIGNED NOT NULL,
  `id_typeofparent` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student_parent_typeofparent`
--

INSERT INTO `student_parent_typeofparent` (`id`, `id_student`, `id_parent`, `id_typeofparent`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 2, 3, 1),
(4, 2, 4, 1),
(5, 8, 5, 1),
(6, 8, 6, 1),
(7, 9, 7, 1),
(8, 9, 8, 1),
(9, 3, 9, 1),
(10, 3, 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `student_violation`
--

CREATE TABLE `student_violation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `id_violation` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student_violation`
--

INSERT INTO `student_violation` (`id`, `id_student`, `id_violation`) VALUES
(3, 3, 2),
(5, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `typeofevent`
--

CREATE TABLE `typeofevent` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `typeofevent`
--

INSERT INTO `typeofevent` (`id`, `Name`) VALUES
(1, 'Профессионально-ориентирующий(развитие карьеры)'),
(2, 'Гражданско-патриотические'),
(3, 'Спортивное и здоровье-сберегающие'),
(4, 'Экологический'),
(5, 'Студенческое самоуправление'),
(6, 'Культурно-творческий'),
(7, 'Бизнес-ориентирующий(молодежное предпринимательство)'),
(8, 'Социально-психологический, включая профилактику асоциального поведения');

-- --------------------------------------------------------

--
-- Структура таблицы `typeofviolation`
--

CREATE TABLE `typeofviolation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `typeofviolation`
--

INSERT INTO `typeofviolation` (`id`, `Name`) VALUES
(1, 'Больной'),
(2, 'Здоровый');

-- --------------------------------------------------------

--
-- Структура таблицы `violation`
--

CREATE TABLE `violation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Date` date NOT NULL,
  `MeasuresTaken` varchar(150) NOT NULL,
  `Note` varchar(150) NOT NULL,
  `id_typeOfViolation` bigint(20) UNSIGNED NOT NULL,
  `id_academicYear` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `violation`
--

INSERT INTO `violation` (`id`, `Name`, `Date`, `MeasuresTaken`, `Note`, `id_typeOfViolation`, `id_academicYear`) VALUES
(1, 'Курение', '2022-06-15', 'Исключение ', 'На территории', 1, 2021),
(2, 'Срыв занятия', '2022-06-21', 'Вызов родителей', 'Сорвал учебное занятие', 2, 2021);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `actives`
--
ALTER TABLE `actives`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `classhour`
--
ALTER TABLE `classhour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_academicYear` (`id_academicYear`);

--
-- Индексы таблицы `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typeofevent` (`id_typeofevent`),
  ADD KEY `id_academicYear` (`id_academicYear`);

--
-- Индексы таблицы `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_specialty` (`id_specialty`),
  ADD KEY `id_roles` (`id_roles`);

--
-- Индексы таблицы `healthgroup`
--
ALTER TABLE `healthgroup`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hostelschedule`
--
ALTER TABLE `hostelschedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_academicYear` (`id_academicYear`);

--
-- Индексы таблицы `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `parentsmeeting`
--
ALTER TABLE `parentsmeeting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`id_group`),
  ADD KEY `id_academicYear` (`id_academicYear`),
  ADD KEY `id_group` (`id_group`);

--
-- Индексы таблицы `parenttype`
--
ALTER TABLE `parenttype`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `participationevents`
--
ALTER TABLE `participationevents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_student` (`id_student`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `selected_group_id` (`selected_group_id`);

--
-- Индексы таблицы `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_branch` (`id_branch`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_healthGroup` (`id_healthGroup`),
  ADD KEY `id_actives` (`id_actives`),
  ADD KEY `id_status` (`id_status`);

--
-- Индексы таблицы `student_parent_typeofparent`
--
ALTER TABLE `student_parent_typeofparent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_parent` (`id_parent`),
  ADD KEY `id_typeofparent` (`id_typeofparent`);

--
-- Индексы таблицы `student_violation`
--
ALTER TABLE `student_violation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_violation` (`id_violation`);

--
-- Индексы таблицы `typeofevent`
--
ALTER TABLE `typeofevent`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `typeofviolation`
--
ALTER TABLE `typeofviolation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `violation`
--
ALTER TABLE `violation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typeOfViolation` (`id_typeOfViolation`),
  ADD KEY `id_academicYear` (`id_academicYear`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actives`
--
ALTER TABLE `actives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `branch`
--
ALTER TABLE `branch`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `classhour`
--
ALTER TABLE `classhour`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `event`
--
ALTER TABLE `event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `group`
--
ALTER TABLE `group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `healthgroup`
--
ALTER TABLE `healthgroup`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `hostelschedule`
--
ALTER TABLE `hostelschedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `parent`
--
ALTER TABLE `parent`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `parentsmeeting`
--
ALTER TABLE `parentsmeeting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `parenttype`
--
ALTER TABLE `parenttype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `participationevents`
--
ALTER TABLE `participationevents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `specialty`
--
ALTER TABLE `specialty`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `student_parent_typeofparent`
--
ALTER TABLE `student_parent_typeofparent`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `student_violation`
--
ALTER TABLE `student_violation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `typeofevent`
--
ALTER TABLE `typeofevent`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `typeofviolation`
--
ALTER TABLE `typeofviolation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `violation`
--
ALTER TABLE `violation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `classhour`
--
ALTER TABLE `classhour`
  ADD CONSTRAINT `classhour_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `classhour_ibfk_2` FOREIGN KEY (`id_academicYear`) REFERENCES `academic_year` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `conversation_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`id_typeofevent`) REFERENCES `typeofevent` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`id_academicYear`) REFERENCES `academic_year` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`selected_group_id`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`id_specialty`) REFERENCES `specialty` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `group_ibfk_2` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `hostelschedule`
--
ALTER TABLE `hostelschedule`
  ADD CONSTRAINT `hostelschedule_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hostelschedule_ibfk_2` FOREIGN KEY (`id_academicYear`) REFERENCES `academic_year` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parentsmeeting`
--
ALTER TABLE `parentsmeeting`
  ADD CONSTRAINT `parentsmeeting_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `parentsmeeting_ibfk_2` FOREIGN KEY (`id_academicYear`) REFERENCES `academic_year` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `participationevents`
--
ALTER TABLE `participationevents`
  ADD CONSTRAINT `participationevents_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `participationevents_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `specialty`
--
ALTER TABLE `specialty`
  ADD CONSTRAINT `specialty_ibfk_1` FOREIGN KEY (`id_branch`) REFERENCES `branch` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`id_healthGroup`) REFERENCES `healthgroup` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`id_actives`) REFERENCES `actives` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_4` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_parent_typeofparent`
--
ALTER TABLE `student_parent_typeofparent`
  ADD CONSTRAINT `student_parent_typeofparent_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_parent_typeofparent_ibfk_2` FOREIGN KEY (`id_parent`) REFERENCES `parent` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_parent_typeofparent_ibfk_3` FOREIGN KEY (`id_typeofparent`) REFERENCES `parenttype` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_violation`
--
ALTER TABLE `student_violation`
  ADD CONSTRAINT `student_violation_ibfk_1` FOREIGN KEY (`id`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_violation_ibfk_2` FOREIGN KEY (`id_violation`) REFERENCES `violation` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `violation`
--
ALTER TABLE `violation`
  ADD CONSTRAINT `violation_ibfk_1` FOREIGN KEY (`id_typeOfViolation`) REFERENCES `typeofviolation` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `violation_ibfk_2` FOREIGN KEY (`id_academicYear`) REFERENCES `academic_year` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
