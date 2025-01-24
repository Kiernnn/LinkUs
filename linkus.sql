-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 02:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkus`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 62, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(2, 42, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(3, 20, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(4, 22, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(5, 47, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(6, 59, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(7, 56, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(8, 57, 1, 'pending', '2025-01-24 13:30:20', '2025-01-24 13:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `loves`
--

CREATE TABLE `loves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_30_043344_create_posts_table', 1),
(6, '2024_08_05_083418_create_comments_table', 1),
(7, '2024_08_13_110958_create_profiles_table', 1),
(8, '2024_08_16_102221_create_friend_requests_table', 1),
(9, '2024_08_16_102235_create_friends_table', 1),
(10, '2024_09_17_142556_create_loves_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('public','friends','me') NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `status`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'friends', 'Laboriosam labore ea...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(2, 2, 'me', 'In ut quod excepturi...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(3, 3, 'friends', 'Sunt autem harum ill...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(4, 4, 'me', 'Officiis laborum fug...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(5, 5, 'friends', 'Dicta nemo nostrum s...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(6, 6, 'public', 'Quos molestias ut au...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(7, 7, 'friends', 'Ratione similique of...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(8, 8, 'friends', 'Fugit aliquam sed ne...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(9, 9, 'me', 'Aut non repudiandae...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(10, 10, 'public', 'Incidunt est consequ...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(11, 11, 'friends', 'Perspiciatis sit ea...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(12, 12, 'public', 'Vitae sint neque qua...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(13, 13, 'friends', 'Quia quod ea quos no...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(14, 14, 'public', 'Dolorem modi dolore...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(15, 15, 'me', 'Nulla rerum dolor de...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(16, 16, 'friends', 'Non quibusdam volupt...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(17, 17, 'me', 'Ut eius molestiae et...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(18, 18, 'friends', 'Reiciendis ut ut sap...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(19, 19, 'friends', 'Dolore et perferendi...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(20, 20, 'me', 'Quibusdam consectetu...', NULL, '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(21, 41, 'friends', 'Et similique est vol...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(22, 42, 'public', 'Blanditiis voluptate...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(23, 43, 'me', 'Vel ullam rem ea non...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(24, 44, 'friends', 'Reprehenderit laudan...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(25, 45, 'public', 'Aut a ut earum ut ex...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(26, 46, 'friends', 'Recusandae non hic e...', NULL, '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(27, 47, 'me', 'Repellendus magnam v...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(28, 48, 'friends', 'Repellat molestias f...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(29, 49, 'public', 'Repellendus quis acc...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(30, 50, 'me', 'Est blanditiis eum i...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(31, 51, 'friends', 'Voluptatibus earum e...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(32, 52, 'friends', 'Saepe adipisci exped...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(33, 53, 'me', 'Vero nisi corrupti q...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(34, 54, 'public', 'Veritatis molestias...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(35, 55, 'friends', 'Maiores quasi neque...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(36, 56, 'public', 'Autem cum sed molest...', NULL, '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(37, 57, 'me', 'Esse voluptate dolor...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(38, 58, 'friends', 'Reprehenderit nulla...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(39, 59, 'friends', 'Omnis modi maxime un...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(40, 60, 'me', 'Est itaque illum ill...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(41, 61, 'friends', 'Vitae nostrum autem...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(42, 62, 'public', 'Quas omnis vel eius...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(43, 63, 'me', 'Tenetur expedita sed...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(44, 64, 'me', 'Dolor aperiam sint v...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(45, 65, 'public', 'Sed et voluptatem re...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(46, 66, 'friends', 'Officiis magnam quod...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(47, 67, 'friends', 'Eveniet veniam tempo...', NULL, '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(48, 68, 'me', 'Rem nihil consectetu...', NULL, '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(49, 69, 'friends', 'Ea qui fugit omnis v...', NULL, '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(50, 70, 'public', 'Dolor magnam quia de...', NULL, '2025-01-24 13:30:20', '2025-01-24 13:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `image`, `about`, `created_at`, `updated_at`) VALUES
(1, 21, NULL, 'Tears \'Curiouser and curiouser!\' cried Alice in a low, hurried tone. He looked at the time they were IN the well,\' Alice said with a knife, it.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(2, 22, NULL, 'Alice for some way of speaking to it,\' she said this, she came in with a soldier on each side to guard him; and near the right thing to get hold of.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(3, 23, NULL, 'Alice looked down at her side. She was looking for it, he was speaking, and this time she went on \'And how many hours a day or two: wouldn\'t it be.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(4, 24, NULL, 'Classics master, though. He was looking at the cook tulip-roots instead of the jury wrote it down \'important,\' and some \'unimportant.\' Alice could.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(5, 25, NULL, 'Knave, \'I didn\'t write it, and then Alice put down yet, before the trial\'s over!\' thought Alice. The poor little thing sat down again into its mouth.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(6, 26, NULL, 'Hatter, \'you wouldn\'t talk about her pet: \'Dinah\'s our cat. And she\'s such a curious appearance in the pool of tears which she found it so yet,\'.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(7, 27, NULL, 'Cat, and vanished again. Alice waited patiently until it chose to speak again. The Mock Turtle in the air. Even the Duchess asked, with another.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(8, 28, NULL, 'March Hare. \'Then it wasn\'t very civil of you to leave off being arches to do it?\' \'In my youth,\' said the Mock Turtle, capering wildly about.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(9, 29, NULL, 'Only I don\'t think,\' Alice went on eagerly. \'That\'s enough about lessons,\' the Gryphon answered, very nearly carried it off. * * * * * * * * * * * *.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(10, 30, NULL, 'Alice. \'Then you should say \"With what porpoise?\"\' \'Don\'t you mean that you think you could see it again, but it was very provoking to find it out.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(11, 31, NULL, 'English,\' thought Alice; \'only, as it\'s asleep, I suppose it doesn\'t matter much,\' thought Alice, \'shall I NEVER get any older than I am so VERY.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(12, 32, NULL, 'Alice, feeling very glad to get rather sleepy, and went on without attending to her; \'but those serpents! There\'s no pleasing them!\' Alice was very.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(13, 33, NULL, 'Caterpillar, just as well as she could have been a holiday?\' \'Of course not,\' Alice cautiously replied: \'but I must have been changed several times.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(14, 34, NULL, 'IS his business!\' said Five, \'and I\'ll tell you more than nine feet high, and her eyes to see that queer little toss of her voice, and the little.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(15, 35, NULL, 'MINE.\' The Queen smiled and passed on. \'Who ARE you talking to?\' said the Hatter, who turned pale and fidgeted. \'Give your evidence,\' said the.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(16, 36, NULL, 'I got up this morning, but I don\'t like the look of things at all, at all!\' \'Do as I tell you!\' But she went to school in the sky. Alice went on.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(17, 37, NULL, 'Still she went on, \'if you only kept on good terms with him, he\'d do almost anything you liked with the end of trials, \"There was some attempts at.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(18, 38, NULL, 'Hatter. Alice felt dreadfully puzzled. The Hatter\'s remark seemed to Alice for some way of keeping up the fan and the White Rabbit, \'but it doesn\'t.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(19, 39, NULL, 'Pigeon in a day or two: wouldn\'t it be murder to leave off this minute!\' She generally gave herself very good advice, (though she very.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(20, 40, NULL, 'KNOW IT TO BE TRUE--\" that\'s the jury-box,\' thought Alice, \'to pretend to be patted on the top of his shrill little voice, the name \'Alice!\' CHAPTER.', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(21, 71, NULL, NULL, '2025-01-24 13:31:34', '2025-01-24 13:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `userName`, `birthDate`, `gender`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Camryn', 'Sanford', 'schmeler.pierre', '2002-10-04', 'other', 'fjones@gmail.com', '2025-01-24 13:30:13', '$2y$10$FNVUVywUK.chkTfJv3kySevttI14UzsKairWHp8KzGh/CcAlE995y', 'xOdCzFOMSj2Q2hbu9umu', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(2, 'Marietta', 'Metz', 'orosenbaum', '1991-11-03', 'other', 'kunde.ethelyn@gmail.com', '2025-01-24 13:30:13', '$2y$10$oLacO/mGTlMUvdqb0zASeuL4wLlw1hz7/DGa.jwA4Wl86HOLKpENC', 'PTKhRIp8Pe5z9nBUXRM4', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(3, 'Bernardo', 'Wilderman', 'jacklyn.braun', '1979-10-05', 'other', 'shanon68@gmail.com', '2025-01-24 13:30:13', '$2y$10$Aau21Ww/lyN7tMeRDFwFGOTTKLkkAIhUN7u3PfG5A90WEb8TY3bsy', '5aPqQJrPXzIAurmpR6dT', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(4, 'Natasha', 'Hayes', 'grimes.ole', '2008-07-24', 'male', 'justyn.carroll@gmail.com', '2025-01-24 13:30:13', '$2y$10$YMc3dhfyxSkhOiafZ3eJ6Ow6uV5CeKuvFXIeUi8VVn7PqRoS15pju', '6rESxZtOZTx5K8hAkVKw', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(5, 'Lizeth', 'Fay', 'georgiana.lindgren', '2007-07-01', 'other', 'bcrooks@gmail.com', '2025-01-24 13:30:13', '$2y$10$ZdVXeTMW0OWeZ6aBl4B4XujmklXwNzVIT/etidrGK3eXXme0rW4SW', 'RXeAbN2gYn0CGQkBBAGG', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(6, 'Glenda', 'Walter', 'fausto42', '1978-03-20', 'female', 'kamron.blick@gmail.com', '2025-01-24 13:30:13', '$2y$10$gIKWwuHa1NsL3CSWh7z2AOULhL8DX31stTmEAwCJrCLCAuL9mV9q6', 'KOUyAlfB3n12hF2PtgfY', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(7, 'Noah', 'Howell', 'stracke.gwendolyn', '1974-01-11', 'male', 'estrella.bahringer@gmail.com', '2025-01-24 13:30:13', '$2y$10$xUpl96Mkhk8D2iJTFdamEOM392xGWyH6ldZ8G/q.nizGqK5Ehes/m', 'ngtSVdOx6hSval5GDcjr', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(8, 'Hettie', 'Legros', 'lexus.graham', '1996-03-23', 'female', 'runte.adrianna@gmail.com', '2025-01-24 13:30:13', '$2y$10$5c9I.jNaAgRvyNltNAC6v.arR0DRIgQ/bxb5QC9WTf8TBjcV4AHli', 'XhFQ5pHxVaoecfvspfwD', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(9, 'Ruben', 'Hill', 'fkonopelski', '2014-08-06', 'other', 'yberge@gmail.com', '2025-01-24 13:30:13', '$2y$10$/lAA51HfHd.MgERcsR96DO8mm0P91jzNMEHAeUjn4MQ74LN3YC81C', 'lsGMe4If10MXcrhFZXdG', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(10, 'Jennie', 'Rolfson', 'willms.elaina', '1996-09-17', 'female', 'bauch.noah@gmail.com', '2025-01-24 13:30:14', '$2y$10$lHGgzijI703dgF5Sc5p2FulyZK7acpfDG436OTnwnmkT1xgR3u0Ii', 'wtEpV130MLy6vaGfefcx', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(11, 'Florence', 'Dickinson', 'chanelle77', '1997-09-08', 'other', 'hardy.emmerich@gmail.com', '2025-01-24 13:30:14', '$2y$10$516fSZZp0UdIrPZz9jKdqOevAGWdW6iH9KOjsgS/3dP0e.sFIMBzm', 'tYEcYE4aPR3c1QWL4jQM', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(12, 'Alfreda', 'Klocko', 'jayda.leannon', '2018-11-03', 'other', 'fstanton@gmail.com', '2025-01-24 13:30:14', '$2y$10$NyNvvtt/T6UO.dPWMLIACeqDy1YhD5.scupty/zJRV/fUv8ngABUm', '2LJ2koiUvuYOPU27QQsH', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(13, 'Merl', 'Nienow', 'yparker', '1984-04-21', 'male', 'fhayes@gmail.com', '2025-01-24 13:30:14', '$2y$10$xNtjOrJvMQwtbLA16LG57.hNiW6Nva5So5BzZfNz/gREPtuYASaey', 'gy45f5aaOU7Eg4TD45Ji', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(14, 'Aryanna', 'Graham', 'litzy.murray', '1990-04-26', 'other', 'kreiger.aylin@gmail.com', '2025-01-24 13:30:14', '$2y$10$QRU8612qqWWAJ9DVl1k0WOlb.E2Oh01W0klImj6ak1PGAvqyrMcjW', 'KpnDduYOy6u5tjbdpKEb', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(15, 'Alize', 'Sawayn', 'benjamin.abshire', '1991-11-19', 'other', 'kortiz@gmail.com', '2025-01-24 13:30:14', '$2y$10$96FZ9da/vZIjQbNY/0j9Me1ejk2R4BCpsTSH5VTs3d.WofTijrute', '5uHk0BGcCK60AYgBfBC6', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(16, 'Yasmeen', 'Volkman', 'emmitt83', '2009-03-29', 'other', 'amann@gmail.com', '2025-01-24 13:30:14', '$2y$10$YcWbYIeH35kacBrkpu.YBO7xcdv/M.ATJHyjjPSr7lLeEzoplXIpy', 'yHif6uOSKqwN0cqDywhR', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(17, 'Letitia', 'Harris', 'lexie56', '2001-10-16', 'female', 'sawayn.cielo@gmail.com', '2025-01-24 13:30:14', '$2y$10$nxUN0LSgakiNQLPDMuYAveo0Tep5BiB9RyaCEheGEMaB2uuUrFE/W', 'IFWyy3gXMbFYKHQa2UNy', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(18, 'Tavares', 'Trantow', 'jedediah.walter', '2003-11-11', 'male', 'jazmin86@gmail.com', '2025-01-24 13:30:14', '$2y$10$7HB.YGpqqniEkTm2nlMRYeZHZBFFfsc0JbNOab1I2Hb7/CQz70w3q', 'jnxelWWmug5BCZv11qYb', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(19, 'Carolyn', 'Harvey', 'bernita47', '1972-11-11', 'male', 'gaetano64@gmail.com', '2025-01-24 13:30:14', '$2y$10$YsP0qemydjCZdtM21.C6kukVX3FCse0TUsQLyUW7WKy.tufZhhRDC', 'KJgPGefNcPRiky7lDoSp', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(20, 'Vicenta', 'Carter', 'hand.margarita', '1972-06-29', 'other', 'winona.oconner@gmail.com', '2025-01-24 13:30:15', '$2y$10$HaY7YY39DW14FIu4a4iCA.0TDXxOkticTC8yR92654jYuOgNIssqy', 'yUDjreCKyDJAv6D7SM3c', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(21, 'Theron', 'Moore', 'daniela.hartmann', '1974-11-10', 'female', 'ryan.stanton@gmail.com', '2025-01-24 13:30:15', '$2y$10$FvQVL9T7vkP/VhD095OUN.SavaQhfPy8Y3ZsDgXAa2dG95Wp2mMI6', '1Ai8HQY2fuNn8AWzWtWl', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(22, 'Rylan', 'Stanton', 'amorissette', '2009-06-07', 'male', 'morissette.lois@gmail.com', '2025-01-24 13:30:15', '$2y$10$9R.H6HySJFbtObPMKtsJRu1N6Go.GiTRrxw6K/7aBsQV4ebR.pj2u', 'fJTWez4u1qGDFnbrGU64', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(23, 'Logan', 'Kihn', 'sylvia42', '1980-06-04', 'other', 'pkuphal@gmail.com', '2025-01-24 13:30:15', '$2y$10$7GG/aYg7qmn/tj07UADYG.u7YyzIJtvYJXP7abG37o1UO3dHkeIRS', 'frnLJjIatf8UsjvLEYXt', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(24, 'Zelda', 'Powlowski', 'ortiz.marcelle', '2008-04-08', 'female', 'bkautzer@gmail.com', '2025-01-24 13:30:15', '$2y$10$H7H2p7.8H/JiR3S.DcRiH.SsV4HBPdJ5wWfbwvqK/o5kBD/p5K7wu', '8lFB7PDyX0g5OJrVtEi0', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(25, 'Kassandra', 'Grimes', 'rosalyn.labadie', '2014-07-20', 'female', 'grover87@gmail.com', '2025-01-24 13:30:15', '$2y$10$XzwttaKn/VdBzuPrryVVweBriDXaCZVUzYhxZhlkoyNlrcjSpMuOi', 'Ka0EJlMtwVtbhLSmEqcU', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(26, 'Verner', 'Denesik', 'franecki.destin', '2006-03-06', 'other', 'orie16@gmail.com', '2025-01-24 13:30:15', '$2y$10$bMP7zaPl7Bd/NqvfBABHe.8bSMf1RRVzmdYavjgMQ4R6pMgNgve4m', 'HLBJxpeFaqi5vmZDBV92', '2025-01-24 13:30:15', '2025-01-24 13:30:15'),
(27, 'Florence', 'Gerlach', 'hickle.julie', '1978-05-21', 'female', 'mclaughlin.lera@gmail.com', '2025-01-24 13:30:15', '$2y$10$fNRHsehGdl8sE/Uj78n2Ne0f0h5x0bkMvYOpYs6sV5COGlP.KbCBW', 'iVeAFhq39RimAT0jKLNP', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(28, 'Susie', 'Lueilwitz', 'monahan.haskell', '1981-03-19', 'male', 'alexandre.pagac@gmail.com', '2025-01-24 13:30:16', '$2y$10$IPk/piSTevbAtD4./NeFVOv9QgnfJJk1qXOXlht8XjWGiwe4GEaRa', 'XxGTqGCHtZ4G6YgQQ8rW', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(29, 'Amalia', 'Dare', 'lew.schoen', '1994-03-13', 'female', 'braxton13@gmail.com', '2025-01-24 13:30:16', '$2y$10$jjt46MAujbJqWYxjH8e7jOLUzZixX8xkIQFcIjxL.gHXasIB2mJ1i', 'K4ACZv5Uv3T3P4650T81', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(30, 'Lenna', 'Tromp', 'lamont.bayer', '1977-10-25', 'female', 'iwyman@gmail.com', '2025-01-24 13:30:16', '$2y$10$xXf7/T26RyIRPegKXf688esnzV72Mx5ZoOsrIE.6tnb84XMGB25k.', 'wM9UZMcriu3KWozpmIBl', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(31, 'Matt', 'Breitenberg', 'tavares.kuhic', '1976-09-12', 'male', 'lucile.howe@gmail.com', '2025-01-24 13:30:16', '$2y$10$7XboPTt.aRw1zB941ZOFa.4ishUTl1SeI1OO/kBQmJEgrVdfuuBtS', 'UIkNOBikGdwDzMsyMtAn', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(32, 'Damion', 'Kreiger', 'june53', '1977-11-14', 'other', 'abbott.fernando@gmail.com', '2025-01-24 13:30:16', '$2y$10$6N0Bfb8YTzmUmfbqugy5suXPCiemsYw469dyQr6uMKpniEYg9xYa.', 'XxTzX6YhCgVJ250lBPTg', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(33, 'Gunnar', 'DuBuque', 'edison55', '1977-02-20', 'female', 'gabbott@gmail.com', '2025-01-24 13:30:16', '$2y$10$zRZlcc2f50OMnY7jVdg04OMo/5Rh46RqYpZoXb3kdwncPB6UuBekS', 'BFffWPBFC5torCXj2Y0h', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(34, 'Alyson', 'Wiegand', 'tabitha28', '1989-03-18', 'male', 'stefanie16@gmail.com', '2025-01-24 13:30:16', '$2y$10$UUMXqF7VLcziIQ8pmhAHH.QLX3Vxqf0BpDxov.6wGaYt8A1sLtu2.', 'MLVLJ5JdHttFq3Pdqi2a', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(35, 'Sharon', 'Schowalter', 'white.zackery', '2006-01-29', 'male', 'bmosciski@gmail.com', '2025-01-24 13:30:16', '$2y$10$hS6joz27SMiJI5McacQru.FJBoVOyIRpIqCVhntoARFId1aOzkVDy', 'cjjAmuyake5nUNigEUvY', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(36, 'Blair', 'Hauck', 'viola.corwin', '1982-12-10', 'female', 'zbosco@gmail.com', '2025-01-24 13:30:16', '$2y$10$EQ.ryHiBvVQwSCJhim95puB3sp67AkKbN6oKFh7BlnDjcjiUkR3G2', 'yhM96Sud9ndQ24n5kUTV', '2025-01-24 13:30:16', '2025-01-24 13:30:16'),
(37, 'Clifford', 'Kirlin', 'ward53', '1972-11-06', 'female', 'turner.lang@gmail.com', '2025-01-24 13:30:16', '$2y$10$lcOcYwvw0zH6LK1l.1QEn.scgKnhJuqedcZ5PLfvu5sBOpMYcdks2', '4kN0LGuxAV8JA3hJhmC7', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(38, 'Libby', 'Heathcote', 'josiane98', '2013-04-11', 'other', 'hpollich@gmail.com', '2025-01-24 13:30:17', '$2y$10$tcMefDZ9KU1bCD0O2xogPOOF1CWY1HrJGcn8wTLxI1WqolF3M37QC', 'cX6aTe6XU5VBKVtQ52ph', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(39, 'Brittany', 'Mraz', 'ora.gleason', '1988-09-27', 'other', 'eratke@gmail.com', '2025-01-24 13:30:17', '$2y$10$Hrm9VSuWFv86V0xpY5h5B.JaU.2wLfo/LVW07kCl1iOebYw5PlqtK', 'wxyPPNdISZGFsnf36dVd', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(40, 'Ellsworth', 'Kub', 'pbrakus', '2013-12-09', 'female', 'monty.wyman@gmail.com', '2025-01-24 13:30:17', '$2y$10$W01A2HuhMsTa.APs29B6T.PPrn590Pct8ecXY1z/gPZtHs47WRd4a', 'fOQQxDSGsEfaiddOFDn0', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(41, 'Gust', 'Runolfsson', 'irwin.walter', '2003-06-27', 'female', 'uriah.haley@gmail.com', '2025-01-24 13:30:17', '$2y$10$OMkMbJxDMbLt2XN3pEt81.p0SNp3FEGtNTd2b/qlUzIh58YJgxuPu', 'gtd1HPyxMdc3sqSAjDRI', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(42, 'Dahlia', 'Raynor', 'stewart03', '2019-04-14', 'other', 'estanton@gmail.com', '2025-01-24 13:30:17', '$2y$10$Gx87/UD0orrVNxM6G4IuBO9XNK4eL1ns1.YDnMVxOlj6z8BxpureG', '9zeoXfPLG8N6GU62Lo3x', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(43, 'Deon', 'Schowalter', 'dax55', '2006-03-17', 'other', 'blair54@gmail.com', '2025-01-24 13:30:17', '$2y$10$CzqKBY4RE.rR/0/wn6a7SuVZ7ZOM/dP6Y40u/d5tzLvy0tfsbbE2G', 'WRf9VsmOXPQTnXbXyqUs', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(44, 'Anna', 'Jones', 'clare04', '2011-07-11', 'male', 'rodrigo.glover@gmail.com', '2025-01-24 13:30:17', '$2y$10$Vk5YUTrjHeq5ipG06PYSjurVCA6M1P6B7mNlhd.J7K67S5NlYVzV.', 'EJTRFacCcxniNAiml9cb', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(45, 'Myrna', 'Swaniawski', 'rkozey', '1974-07-03', 'male', 'ykoepp@gmail.com', '2025-01-24 13:30:17', '$2y$10$RNQjxcnfseK4SLcHmGbC3u/Qu4iY81/rBn4CR37c38kO0GZLqblvG', 'xEsk9vz6zG70d7CZBNMu', '2025-01-24 13:30:17', '2025-01-24 13:30:17'),
(46, 'Jess', 'Dickinson', 'demarcus.koss', '2018-04-09', 'female', 'bergnaum.keagan@gmail.com', '2025-01-24 13:30:17', '$2y$10$hOJDJzvzRzoUdKWzVnX0cesjVAtcqPnamDQikMKC.nboSR59s0Eh2', 'Akixjj1hM7gChpkklZVl', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(47, 'Eliezer', 'Glover', 'bryce31', '2003-09-15', 'female', 'jules10@gmail.com', '2025-01-24 13:30:18', '$2y$10$B6t.aeIjo.CC.x/h7G0AUOSbIEaAdi8Qxo4TvvKpcmg7dh9SaDMoK', 'qoJsJbFgePmZH6nGANCx', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(48, 'Joanny', 'Ankunding', 'cleo81', '1990-03-30', 'other', 'purdy.anita@gmail.com', '2025-01-24 13:30:18', '$2y$10$c/oE897Jm4e9YgRc8TgYEe8ImFBWZyznyDWkXnxwsS7NvciiFEmT6', 'wfRabrvpcDtuFjuEeij1', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(49, 'Liam', 'Goyette', 'jkunze', '2015-01-21', 'female', 'yharvey@gmail.com', '2025-01-24 13:30:18', '$2y$10$Gw/hQWHHDOIsNl8rpEg4VeAXDA1n/NbcMDqhJVsQi6EXMzVFSad3G', 'JmrwJ5JBj7T9RkwSvQMO', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(50, 'Maritza', 'Cronin', 'calista.terry', '1971-08-18', 'male', 'jherman@gmail.com', '2025-01-24 13:30:18', '$2y$10$X6/LGcg9FzLfz5V8jObISO71rjW/Nrl1jGKwXEer6YC2CFh5XrtzC', 'pYaScIrgwUevRgNn7qqn', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(51, 'Davin', 'Rowe', 'rosetta79', '1981-05-04', 'male', 'cwisozk@gmail.com', '2025-01-24 13:30:18', '$2y$10$CB3DReJw3VmnZrE31/1ROeJDw.fl23dXjzwAOvY.Lpqe6tOwVL2iW', 'lSw2BVhRepZbTgbXncZc', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(52, 'Dusty', 'Schowalter', 'kaleb.parker', '1997-07-17', 'female', 'sschinner@gmail.com', '2025-01-24 13:30:18', '$2y$10$urpJZtO8kCIsxfV5a6UlnenkOA90nIoTPuMPxPN0Q/BBzYVg7WWRu', 'J6Y0pUuM7OKOt854duMF', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(53, 'Heloise', 'Windler', 'vincenza57', '2022-11-20', 'male', 'rbode@gmail.com', '2025-01-24 13:30:18', '$2y$10$nPPWqJI7R5HlMwMZTPxT9O.Wi8fkp/SUXq1N3Y4XLFMsUw0g/.ugW', 'vgWTnNqVOGT2Pbv7WdsK', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(54, 'Jamarcus', 'Moen', 'torey.kilback', '2022-07-31', 'female', 'nicholas86@gmail.com', '2025-01-24 13:30:18', '$2y$10$plIIjFeWiezM8DaZBvSoCupNjgjNPrhLMNAyvXnuYmq5NXUS202JO', 'fR1jvAwXO7YYwX1oRhB8', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(55, 'Annamae', 'Bode', 'meghan.jerde', '1986-02-12', 'other', 'yesenia21@gmail.com', '2025-01-24 13:30:18', '$2y$10$dBmYIuGrGOVzg7HQcipdAedtNTaxwe1Zf0nAUbfZnuNH.EgOcwZOK', '8KS0jp3PrvlWjoxp0qDH', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(56, 'Clement', 'Kertzmann', 'clegros', '1984-11-18', 'female', 'laverne10@gmail.com', '2025-01-24 13:30:18', '$2y$10$b6b3tENKtIkGvVInc9lT3O4RnaV82b8zuSug50V7mgi2kUOH6995S', 'Aepb5DIfZEKawKTCdCol', '2025-01-24 13:30:18', '2025-01-24 13:30:18'),
(57, 'Buck', 'Murazik', 'swaniawski.novella', '2021-09-03', 'female', 'eulalia13@gmail.com', '2025-01-24 13:30:19', '$2y$10$/Co.KRTorSkfGrpkuSo2ieCiPz6IBHBfmU9udBaemBHP8aMQuK8pq', '91XC7qtQw9BCzbqLfqoG', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(58, 'Lucio', 'Harvey', 'tia79', '1976-07-23', 'female', 'lawrence26@gmail.com', '2025-01-24 13:30:19', '$2y$10$Ek12eoOYPRqZI5gmLW.44uwpbvXZ6SbrsMXySChcXNv3bX8V7xYT2', 'GdwXsxFMNpHJvxK5o8nP', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(59, 'Earnest', 'Rempel', 'jany.bergnaum', '2018-01-16', 'male', 'cormier.esteban@gmail.com', '2025-01-24 13:30:19', '$2y$10$v0k00VLBefHykdUcaKY/NON05mACq1OOZwF.zGEzCCD7uBTuwH0XS', 'g8EqxWifUcPw7LjGIOoe', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(60, 'Alda', 'Brown', 'dean94', '1974-10-07', 'female', 'wcruickshank@gmail.com', '2025-01-24 13:30:19', '$2y$10$XqcU0yJGV732Tr/7xGAhbupBVDiAiqkNPgTI.uQ2KqvmXANtJlpW2', 'bExS3aMkxCUPHiMPVP8u', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(61, 'Tristian', 'Dietrich', 'hsenger', '2023-06-30', 'other', 'hal81@gmail.com', '2025-01-24 13:30:19', '$2y$10$0FuQe.adPLOmTC.D/e7xku2I3d9bSzmDyyinfDUJN9sFKNLoksRji', 'eu0tPIBRGZc8PAyBDQom', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(62, 'Guadalupe', 'Mertz', 'rhills', '2011-05-07', 'male', 'cstiedemann@gmail.com', '2025-01-24 13:30:19', '$2y$10$dSS2P7US3bc8KyiPHcj1qeDuMh7nEQZB7vDgOCq2yl2taqBwIvj/2', '7TNorRL4NGx3h8UCB1zp', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(63, 'Tiana', 'Considine', 'jean.zboncak', '1991-10-13', 'other', 'usporer@gmail.com', '2025-01-24 13:30:19', '$2y$10$mcd.iaWBOCey9FfSje.3eOIJTOphZBBkrsTmqSpRJwNC/73pO.JDq', 'ffVK9eFNuB5hYOSrUL0w', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(64, 'Darrin', 'Dare', 'imiller', '2011-10-18', 'other', 'elroy.dickens@gmail.com', '2025-01-24 13:30:19', '$2y$10$FrdFpniQx0k/wgEd/bG0GuxmrPD6SaR9aQ1WXI2rU.cJRXb/Q.h/O', 'RO0cpz0rJikTmwaMFh6K', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(65, 'Gretchen', 'Robel', 'gkihn', '1992-12-05', 'other', 'srath@gmail.com', '2025-01-24 13:30:19', '$2y$10$/.Zzs2YLjV1R2fC.v1rgmO331KJw7Iht0e94OBt38InUE7hgl86b.', '2Q6CKFzSV2a04NbjU5iW', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(66, 'Edwardo', 'Halvorson', 'dasia47', '1993-12-16', 'other', 'hirthe.kristian@gmail.com', '2025-01-24 13:30:19', '$2y$10$aJ3QJnFBURo4uzsp/ZCaC.IbuPcHgJ1EWK5Yj1T1NBPjjba7Hdqu.', 'BVEjHwlTARmRIgsX8zVY', '2025-01-24 13:30:19', '2025-01-24 13:30:19'),
(67, 'Arthur', 'Hintz', 'erdman.alda', '1985-03-09', 'male', 'langworth.luella@gmail.com', '2025-01-24 13:30:19', '$2y$10$n8zcF8.QhYWcFmENYJGDBOquA4sdzeNr/U3bAU2yuZ3/5Jj1FsHla', '13FsbL6MhfQCo8R5NlPh', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(68, 'Lucas', 'Weber', 'nelson.padberg', '2018-02-10', 'male', 'mayra23@gmail.com', '2025-01-24 13:30:20', '$2y$10$bFbZViP1cQ//5keqcYZdjeE.daIyuCdwQ9Dom39Rs3S4/pvisWySu', 'zs3CuAr4nYPvSNM5MzNl', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(69, 'Frederic', 'McGlynn', 'schowalter.kariane', '1971-07-29', 'female', 'bell.labadie@gmail.com', '2025-01-24 13:30:20', '$2y$10$I.K61qTSDoeEFFzBn6aH8O23C.W1SaCkGi4UwiLWtQEJCDUGpRYsa', 'gCCrmsWUto2sGEdLmxde', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(70, 'Gerda', 'Hudson', 'lora.schulist', '2003-05-19', 'male', 'pgreen@gmail.com', '2025-01-24 13:30:20', '$2y$10$MhHtGZGpljMgeYj3ORoau.o9YW0FPlkYC4DaFch5uDHzdVVDZVuvm', 'zXcuyjG9WaDp7B38CWfp', '2025-01-24 13:30:20', '2025-01-24 13:30:20'),
(71, 'kiern', 'nova', 'kiernnn', '2003-12-06', 'male', 'kiern@gmail.com', NULL, '$2y$10$MGcJYdGK0cdbtTaxaaQ1re6T6ToNXCAZUl8TUzRUS71N.qUhelSJ.', NULL, '2025-01-24 13:31:34', '2025-01-24 13:31:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friends_user_id_friend_id_unique` (`user_id`,`friend_id`),
  ADD KEY `friends_friend_id_foreign` (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friend_requests_sender_id_receiver_id_unique` (`sender_id`,`receiver_id`),
  ADD KEY `friend_requests_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `loves`
--
ALTER TABLE `loves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loves_user_id_foreign` (`user_id`),
  ADD KEY `loves_post_id_foreign` (`post_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `loves`
--
ALTER TABLE `loves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loves`
--
ALTER TABLE `loves`
  ADD CONSTRAINT `loves_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
