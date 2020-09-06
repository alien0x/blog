-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2020 at 06:58 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(19, 'Science', 'Science is what we do to find out about the natural world. Natural sciences include physics, chemistry, biology, geology and astronomy.', NULL, 0, 0, 0),
(20, 'Storys', 'Story is a statement regarding the facts pertinent to a situation in question .', NULL, 0, 0, 0),
(21, 'Technology', 'Technology is the sum of techniques, skills, methods, and processes used in the production of goods or services or in the accomplishment of objectives, such as scientific investigation.', NULL, 1, 1, 0),
(22, 'Space news', 'space is everything in the universe beyond the top of the Earth\'s atmosphere – the Moon, where the GPS satellites orbit, Mars, other stars .', NULL, 0, 0, 0),
(23, 'General', 'An article is a word used to modify a noun, which is a person, place, object, or idea. Technically, an article is an adjective, which is any word that modifies a noun. Usually adjectives modify nouns through description .', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `status`, `Comment_Date`, `Item_id`, `User_id`) VALUES
(75, 'so cool , I love it .', 0, '2020-09-06', 29, 2),
(76, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 30, 2),
(77, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 31, 2),
(78, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 32, 2),
(79, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 35, 2),
(80, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 29, 40),
(81, 'so cool , Iove it so much , keep going.\r\n', 0, '2020-09-06', 30, 40),
(82, 'so cool , Iove it so much , keep going.', 0, '2020-09-06', 33, 40);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Add_Date` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Add_Date`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(29, 'Are you afraid of flying?', 'Many people are afraid of flying in airplanes, but they shouldn’t be. Flying is actually one of the safest ways to travel. In fact, when measured per mile, flying is actually far safer than driving, or travelling by train.\r\n\r\nNot only is flying the safest mode of transport, but it is also the fastest. Just a hundred years ago if you wanted to travel from China to the United States, you would have to travel by boat for many weeks. Now, you can get there in less than 24 hours. Airplanes are also quite comfortable, and often offer in-flight entertainment, such as movies. This helps explain why travelling by plane is now the preferred choice for long distance journeys.\r\n\r\nOf course, that doesn’t stop some people from being afraid of flying. The idea of hurtling through the atmosphere at hundreds of miles per hour can be intimidating for many. One of the main reasons that people are afraid to fly is that passengers lack any control over the airplane, and have to place their trust in the hands of the pilots. Many people would prefer to remain in control!', '2020-09-06', '6867201_pic1.PNG', '2', 0, 1, 23, 2),
(30, 'Places you need to visit in Europe', 'Discovering ancient monuments, eating sensational food and experiencing new adventures make the perfect holiday. Thankfully, Europe has something for everyone, but narrowing down the top places in Europe to visit is a difficult task especially with so many unique and interesting cities to discover.\r\n\r\nLondon and Paris are indeed wonderful cities to explore.  However, there are many other beautiful and interesting places worth a visit.', '2020-09-06', '2953723_pic2.PNG', '1', 0, 1, 23, 40),
(31, 'Unusual Foods People Eat in Europe', 'Just about every country, region, and culture has its own unusual foods. Often, these foods can seem gross or weird to people who are not from the region. Yet in many cases these unusual foods are actually tasty delicacies.\r\n\r\nWith its long history and varied cultures, Europe is home to some of the strangest foods in the world. The immense differences in climate, ranging from the arctic climate of\r\n\r\nScandinavia to the warm and mild Mediterranean weather found in Southern Europe,  have led to widely differing agricultural practices.\r\n\r\nThis, in turn, has led to a variety of different food cultures. So let’s take a look at ten of the weirdest foods found in Europe.', '2020-09-06', '345173_pic3.PNG', '3', 0, 1, 23, 41),
(32, 'Alberto\'s new neighbours', 'Alberto took one look at his new neighbours and knew that his life was going to get more difficult. He watched them arrive in their big, noisy car and watched them get out. There they were, two of them, as big and as noisy as their car – and smelly and stupid as well.\r\n\r\n\'Terrible!\' he thought. \'How am I going to put up with them?\' He went to tell Mimi. Mimi was the friend he lived with.\r\n\r\n\'Have you seen the new neighbours?\' he asked her.\r\n\r\n\'No,\' she said. \'Who are they?\'\r\n\r\n\'Two of them. The ones we don’t like. Big and noisy and stupid and smelly. Just like they always are.\'\r\n\r\n\'Oh no,\' said Mimi. \'How awful! Still, I suppose we can just ignore them.\'\r\n\r\n\'I suppose you\'re right,\' agreed Alberto. \'We\'ll just have to ignore them.\'\r\n\r\nFor a few days, then, Alberto and Mimi tried to ignore their new neighbours. When the neighbours went out for a walk, Alberto and Mimi didn\'t say hello to them. When the neighbours were in their garden, Alberto and Mimi went inside. This was OK for a few days, but, perhaps inevitably, things didn\'t stay this way …\r\n\r\nOne day, Alberto woke up from his sleep to find one of the neighbours in his garden. \'Mimi!\' he shouted. \'Have you seen this!? He\'s in our garden!!!! Look!\'\r\n\r\n\'How terrible,\' said Mimi. \'Let\'s call our staff and make sure they get rid of him immediately!\'\r\n\r\nMimi went off to call their staff. Two minutes later, Alberto and Mimi\'s head of staff was out in the garden trying to get rid of the unwelcome neighbour. \'Go on!\' he shouted. \'Get out of here! Go home!\' The neighbour didn\'t say anything but gave Alberto and Mimi\'s head of staff a dirty look, then he went back into his garden. Alberto and Mimi felt better and then asked their head of staff to prepare their lunch for them.\r\n\r\nHowever, it wasn\'t enough. Over the next few days, Alberto and Mimi often found one or other or both of their new neighbours walking around their own garden. It was terrible. To show how they felt, Alberto and Mimi went into their neighbours\' garden at night, when the neighbours were inside, and broke all the flowers.\r\n\r\nThe next morning one of the neighbours came to talk to Alberto.\r\n\r\n\'Hey!\' he said. \'Hey, you!\' Alberto ignored him, but he continued talking. \'You came into our garden last night and broke all the flowers!\' Alberto didn\'t say anything but gave his neighbour a dirty look. \'Now I\'m in trouble!\' continued his neighbour. \'They think I did it!\'\r\n\r\n\'Who are \"they\"?\' asked Alberto.\r\n\r\n\'My owners, of course,\' replied the neighbour.\r\n\r\n\'Owners!?\' said Alberto. \'You have \"owners\"?\'\r\n\r\n\'Course we do,\' said his neighbour. \'Don\'t you?\'\r\n\r\n\'Oh, no,\' replied Alberto. \'We have staff.\'\r\n\r\nAlberto went to tell Mimi that the neighbours didn\'t have staff but owners.\r\n\r\n\'That\'s not a surprise,\' said Mimi. \'That explains everything. That\'s why they\'re so noisy and smelly and stupid. We need to make their owners become staff.\'\r\n\r\nThe next day, Alberto and Mimi were actually very friendly with their new neighbours. They tried to explain how to make their owners become \'staff\'.\r\n\r\n\'Listen,\' said Alberto to them. \'It\'s very easy. First, understand that the house is your house, not theirs.\'\r\n\r\n\'And second,\' said Mimi, \'make sure that you are always clean.\'\r\n\r\n\'Make sure they give you food whenever you want!\'\r\n\r\n\'Sit on the newspaper while they are reading it!\'\r\n\r\n\'Sleep as much as possible – on their beds!\'\r\n\r\n\'And finally, try not to bark but to miaow instead.\'\r\n\r\nBut it was no good. The neighbours just didn\'t understand. After a week, they gave up.\r\n\r\n\'It\'s no good,\' said Mimi. \'They\'ll never understand – dogs have owners, cats have staff.\'\r\n\r\nChris Rose\r\nWhat Is Great About It: The old lady in this story is one of the most cheerful characters anyone can encounter in English fiction. Her positive disposition (personality) tries to make every negative transformation seem like a gift, and she helps us look at luck as a matter of perspective rather than events.', '2020-09-06', '7283189_pic4.PNG', '1', 0, 1, 20, 2),
(33, 'The broken mirror, the black cat and lots of good luck', 'Nikos was an ordinary man. Nothing particularly good ever happened to him; nothing particularly bad ever happened to him. He went through life accepting the mixture of good things and bad things that happen to everyone. He never looked for any explanation or reason about why things happened just the way they did.\r\n\r\nOne thing, however, that Nikos absolutely did not believe in was superstition. He had no time for superstition, no time at all. Nikos thought himself to be a very rational man, a man who did not believe that his good luck or bad luck was in any way changed by black cats, walking under ladders, spilling salt or opening umbrellas inside the house.\r\n\r\nNikos spent much of his time in the small taverna near where he lived. In the taverna he sat drinking coffee and talking to his friends. Sometimes his friends played dice or cards. Sometimes they played for money. Some of them made bets on horse races or football matches. But Nikos never did. He didn’t know much about sport, so he didn’t think he could predict the winners. And he absolutely didn’t believe in chance or luck or superstition, like a lot of his friends did.\r\n\r\nOne morning Nikos woke up and walked into the bathroom. He started to shave, as he did every morning, but as he was shaving he noticed that the mirror on the bathroom wall wasn’t quite straight. He tried to move it to one side to make it straighter, but as soon as he touched it, the mirror fell off the wall and hit the floor with a huge crash. It broke into a thousand pieces. Nikos knew that some people thought this was unlucky. ‘Seven years’ bad luck,’ they said, when a mirror broke. But Nikos wasn’t superstitious. Nikos wasn’t superstitious at all. He didn’t care. He thought superstition was nonsense. He picked up the pieces of the mirror, put them in the bin and finished shaving without a mirror.', '2020-09-06', '7738807_pic5.PNG', '2', 0, 1, 20, 40),
(34, 'The interesting most boring man in the world', 'People often said that Thierry Boyle was the most boring man in the world. Thierry didn’t know why people thought he was so boring. Thierry thought he was quite interesting. After all, he collected stamps. What could be more interesting than stamps? It was true that he didn’t have any other hobbies or interests, but that didn’t matter for Thierry. He had his job, after all. He had a very interesting job. At least, Thierry thought it was interesting. Everybody else said that his job was boring. But he was an accountant! Why do people think that accountants are boring? thought Thierry. Thierry thought his job was fascinating. Every day, he went to his office, switched on his computer and spent seven and a half hours looking at spreadsheets and moving numbers around on them. What could be more interesting than that?\r\n\r\nBut Thierry was unhappy. He was unhappy because people thought he was boring. He didn’t want to be boring. He wanted people to think that he was a very interesting person. He tried to talk to people about his stamp collection. But every time he talked about his stamp collection he saw that people were bored. Because people were bored when he talked about his stamp collection, he talked about his job instead. He thought people would be very interested when he talked about his job, but, no, people thought his job was even more boring than his stamp collection. Sometimes, people even went to sleep when he talked to them.', '2020-09-06', '3495590_pic6.PNG', '2', 0, 1, 20, 41),
(35, 'The moon is rusty, and it’s likely Earth\'s fault', 'The moon is turning ever so slightly red, and it\'s likely Earth\'s fault. Our planet\'s atmosphere may be causing the moon to rust, new research finds.  \r\n\r\nRust, also known as an iron oxide, is a reddish compound that forms when iron is exposed to water and oxygen. Rust is the result of a common chemical reaction for nails, gates, the Grand Canyon\'s red rocks — and even Mars. The Red Planet is nicknamed after its reddish hue that comes from the rust it acquired long ago when iron on its surface combined with oxygen and water, according to a statement from NASA\'s Jet Propulsion Laboratory (JPL) in Pasadena, California. \r\n\r\nBut not all celestial environments are optimal for rusting, especially our dry, atmosphere-free moon. \r\n\r\n\"It\'s very puzzling,\" study lead author Shuai Li, an assistant researcher at the University of Hawaii at Mānoa\'s Hawaii Institute of Geophysics and Planetology, said in the statement. \"The Moon is a terrible environment for [rust] to form in.\" ', '2020-09-06', '5340944_pexels-pixabay-47367.jpg', '1', 0, 1, 22, 2),
(41, 'Rocket Lab has launched its 1st homegrown Photon satellite', 'Rocket Lab isn&#39;t just a launch provider anymore.\r\n\r\nThe California-based company now has a spacecraft in Earth orbit — the first of its Photon satellite line, which is designed to tote customer payloads to a variety of destinations, including the moon and Venus.\r\n\r\nThe Photon spacecraft, named &#34;First Light,&#34; rode to orbit atop Rocket Lab&#39;s 57-foot-tall (17 meters) Electron booster on Aug. 30, company representatives announced today (Sept. 3). The primary payload on that mission was the 220-lb. (100 kilograms) Sequoia, an Earth-observation satellite built by San Francisco-based company Capella Space.', '2020-09-06', '1507935_pexels-marco-milanesi-2670898 (1).jpg', '1', 0, 0, 22, 40);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify user',
  `Username` varchar(255) NOT NULL COMMENT 'Username to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `trustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date NOT NULL,
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `trustStatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'hagar', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'hagaryousef2000@gmail.com', 'hagar', 1, 1, 1, '2020-07-29', ''),
(2, 'ahmed', '8cb2237d0679ca88db6464eac60da96345513964', 'ahmad@gmail.com', 'ahmed ahmed', 0, 0, 1, '2020-09-06', '8891400_1 (1).jpg'),
(40, 'mohamed', '8cb2237d0679ca88db6464eac60da96345513964', 'mohamed@gmail.com', 'mohamed mohamed', 0, 0, 1, '2020-09-06', '4301057_1 (2).jpg'),
(41, 'noor', '12345', 'noor@gmail.com', 'noor noor', 0, 0, 0, '2020-09-06', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `item_1` (`Item_id`),
  ADD KEY `member` (`User_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `category_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`) USING BTREE,
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify user', AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_1` FOREIGN KEY (`Item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member` FOREIGN KEY (`User_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `category_1` FOREIGN KEY (`Cat_ID`) REFERENCES `category` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
