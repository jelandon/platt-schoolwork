-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2018 at 06:14 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trish2_pictuto0817`
--
CREATE DATABASE IF NOT EXISTS `trish2_pictuto0817` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `trish2_pictuto0817`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `comment_date` datetime NOT NULL,
  `body` text NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `comment_date`, `body`, `post_id`, `is_approved`) VALUES
(1, 1, '2017-09-07 19:11:24', 'Awesome pic. Your cat is so fluffy I''m a gonna die!', 4, 1),
(2, 2, '2017-09-07 19:11:24', 'Soooo cuuuuuute!!!!!!!', 3, 1),
(3, 1, '2017-09-19 20:14:19', 'This is a really dark cat. Watch out for Halloween. Keep that kitty inside.', 4, 1),
(5, 1, '2017-09-20 18:21:06', 'Make a new comment!', 5, 1),
(6, 1, '2017-09-20 18:49:54', 'I&#39;m going to delete this comment.', 5, 1),
(7, 1, '2017-10-03 18:42:16', 'woo hoo', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
`like_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `post_id` mediumint(9) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(1, 1, 1),
(2, 2, 4),
(4, 2, 1),
(5, 2, 4),
(6, 1, 3),
(7, 1, 4),
(8, 3, 12),
(9, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
`post_id` mediumint(9) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(256) NOT NULL,
  `post_date` datetime NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `image`, `post_date`, `user_id`, `allow_comments`, `is_published`) VALUES
(1, 'Flop over i cry and cry and cry unless you pet me', 'Cat ipsum dolor sit amet, Gate keepers of hell. Bleghbleghvomit my furball really tie the room together pet right here, no not there, here, no fool, right here that other cat smells funny you should really give me all the treats because i smell the best and omg you finally got the right spot and i love you right now missing until dinner time. Man running from cops stops to pet cats, goes to jail mew for poop in a handbag look delicious and drink the soapy mopping up water then puke giant foamy fur-balls so have my breakfast spaghetti yarn howl uncontrollably for no reason or purr. ', 'cat1', '2017-09-07 18:43:20', 1, 1, 1),
(2, 'instead of drinking water from the cat bowl, make sure to steal water from the toilet', 'Freak human out make funny noise mow mow mow mow mow mow success now attack human climb a tree, wait for a fireman jump to fireman then scratch his face. Small kitty warm kitty little balls of fur if it smells like fish eat as much as you wish yet loved it, hated it, loved it, hated it, rub whiskers on bare skin act innocent yet soft kitty warm kitty little ball of furr. I cry and cry and cry unless you pet me, and then maybe i cry just for fun. ', 'cat2', '2017-09-07 18:50:20', 1, 1, 1),
(3, 'i like big cats and i can not lie', 'scratch me there, elevator butt for cough furball so catch mouse and gave it as a present so eat grass, throw it back up. Chirp at birds get video posted to internet for chasing red dot eat from dog''s food so scratch me there, elevator butt ears back wide eyed so cat slap dog in face, drink water out of the faucet. Kick up litter meow to be let in. Slap kitten brother with paw jump off balcony, onto stranger''s head. Stare out the window cat not kitten around give attitude, i could pee on this if i had the energy soft kitty warm kitty little ball of furr,', 'cat3', '2017-09-07 18:45:42', 1, 1, 1),
(4, 'Cat from Hell', 'Who''s the baby Gate keepers of hell but meow for food, then when human fills food dish, take a few bites of food and continue meowing. Chase red laser dot eat owner''s food spot something, big eyes, big eyes, crouch, shake butt, prepare to pounce. Cat mojo human is washing you why halp oh the horror flee scratch hiss bite, but destroy couch as revenge and toy mouse squeak roll over or cat snacks, but fooled again thinking the dog likes me under the bed. Chase dog then run away sniff sniff. ', 'cat4', '2017-09-07 18:46:39', 2, 1, 1),
(5, 'Immigrant Song', 'I come from the land of ice and snow...', 'ced241ad4c394f12a0238dddc45bb10494dea85c', '2017-09-13 21:03:43', 1, 1, 1),
(6, 'This was a test on the cropper..', 'does not look like it worked.', '164add0d425f666007265ae3dd98f6938faf5b32', '2017-09-25 19:01:37', 1, 0, 1),
(7, 'Wait, you are not a cat....', 'But he&#39;s a beautiful square cropped fox!', '7d5a022df0cea3af9edc6a4dbc7271701243c9c2', '2017-09-25 20:00:27', 1, 1, 1),
(8, 'New Cropper test.', 'Yay it works!', '5bab4a8ead4fef5f5e43fec7a7797aebfbfadedd', '2017-09-25 20:01:31', 1, 0, 1),
(9, 'not centered', 'this is an example of a non-centered image.', '71adfa1b5bab34a68c7cf7f4325f0ebec43fd959', '2017-09-27 19:49:53', 1, 1, 1),
(10, 'Isn&#39;t he cute!', 'cool stuff about cats in space!!!!!', '3ab524f3b6da17183a6ee444de1e5cfd949fe4b0', '2017-10-02 18:14:01', 1, 1, 1),
(11, 'This is a rabbit', 'with glasses!', 'd12457e708b122d84ac8d648ed764a5ca989b8f5', '2018-02-13 18:08:38', 1, 1, 1),
(12, 'rabbit with laptop', 'cute little bunny thinks he&#39;s smart! He sure looks the part! ', '27342ec6a2a1b4f7fe571b79c076c3d15ca3230e', '2018-02-13 18:14:47', 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE IF NOT EXISTS `post_tags` (
`post_tag_id` mediumint(9) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `tag_id` mediumint(9) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`post_tag_id`, `post_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 3, 3),
(4, 3, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 1, 7),
(9, 3, 5),
(10, 5, 5),
(11, 5, 6),
(12, 5, 7),
(14, 5, 10),
(15, 5, 11),
(16, 10, 13),
(17, 10, 2),
(18, 10, 3),
(19, 11, 14),
(20, 11, 3),
(21, 11, 2),
(22, 11, 15),
(23, 12, 16),
(24, 12, 17),
(25, 12, 2),
(26, 9, 2),
(27, 9, 18),
(28, 9, 19),
(29, 9, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
`tag_id` mediumint(9) NOT NULL,
  `tag_name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(1, 'happy'),
(2, 'cute'),
(3, 'fluffy'),
(4, 'sleepy'),
(5, 'soft'),
(6, 'kitten'),
(7, 'playful'),
(8, 'hungry'),
(9, 'healthy'),
(10, 'viking'),
(11, 'tabby'),
(12, 'grey'),
(13, 'space'),
(14, 'fluffy, cute, glasses'),
(15, 'glasses'),
(16, 'funny'),
(17, 'stylish'),
(18, 'not centered'),
(19, 'killer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` mediumint(9) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(40) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `join_date` datetime NOT NULL,
  `secret_key` varchar(40) DEFAULT NULL,
  `bio` varchar(256) DEFAULT NULL,
  `profile_pic` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `is_admin`, `join_date`, `secret_key`, `bio`, `profile_pic`) VALUES
(1, 'TrishZwei', 'trishzwei@gmail.com', '57bda0b6e9c9b950f389b997da3d43254a0b6fc4', 1, '2017-09-07 18:54:38', 'f5ab557a4d34645a694c83a1d539962cb602dcfe', NULL, '38abfb49d0a0a849758f386a9af0b2604bea37d0'),
(2, NULL, 'keeperofthemagick@cox.net', '57bda0b6e9c9b950f389b997da3d43254a0b6fc4', 0, '2017-09-07 18:54:38', '', ' I love cats.', 'avatar'),
(3, 'Trish2', 't2@t2.com', '57bda0b6e9c9b950f389b997da3d43254a0b6fc4', 0, '2017-09-14 19:44:03', '5d8b365d87cc8e34b086b8e7f167aad45e216a14', NULL, 'avatar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
 ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
 ADD PRIMARY KEY (`post_tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
MODIFY `like_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
MODIFY `post_tag_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
