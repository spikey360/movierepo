--
-- Database: `movierepo`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE IF NOT EXISTS `avatars` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `avatar` mediumblob NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Table structure for table `cschemes`
--

CREATE TABLE IF NOT EXISTS `cschemes` (
  `csid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `css` varchar(32) NOT NULL,
  PRIMARY KEY (`csid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `plot` text NOT NULL,
  `director` varchar(255) NOT NULL,
  `starring` varchar(255) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Table structure for table `disc_posts`
--

CREATE TABLE IF NOT EXISTS `disc_posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'post id',
  `tid` int(11) NOT NULL COMMENT 'thread id',
  `user` int(11) NOT NULL,
  `post` text NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;


--
-- Table structure for table `disc_sections`
--

CREATE TABLE IF NOT EXISTS `disc_sections` (
  `secid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`secid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Table structure for table `disc_threads`
--

CREATE TABLE IF NOT EXISTS `disc_threads` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `section` int(11) NOT NULL,
  `startedBy` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `startedBy` (`startedBy`),
  KEY `section` (`section`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `action` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`eid`),
  KEY `uid` (`uid`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;


--
-- Table structure for table `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `owner` int(11) NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Table structure for table `orientatn`
--

CREATE TABLE IF NOT EXISTS `orientatn` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `ornt` int(11) NOT NULL COMMENT '0 for disagree; 1 for agree',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `pollid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `opt1` varchar(32) NOT NULL,
  `opt2` varchar(32) NOT NULL,
  `opt3` varchar(32) NOT NULL,
  `opt4` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`pollid`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `by` int(11) NOT NULL,
  `for` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  KEY `by` (`by`),
  KEY `for` (`for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cscheme` int(11) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `uid` (`uid`),
  KEY `cscheme` (`cscheme`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Table structure for table `thread_viewed`
--

CREATE TABLE IF NOT EXISTS `thread_viewed` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `lastPostSeen` int(11) NOT NULL,
  PRIMARY KEY (`nid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `lastPostSeen` (`lastPostSeen`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 NOT NULL,
  `password` varchar(48) NOT NULL,
  `mail` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `opt` int(11) NOT NULL COMMENT '1,2,3 or 4',
  PRIMARY KEY (`vid`),
  KEY `pollid` (`pollid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Table structure for table `watched`
--

CREATE TABLE IF NOT EXISTS `watched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` int(11) NOT NULL,
  `what` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `who` (`who`),
  KEY `what` (`what`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `movies` (`mid`);

--
-- Constraints for table `disc_posts`
--
ALTER TABLE `disc_posts`
  ADD CONSTRAINT `disc_posts_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`uid`);

--
-- Constraints for table `disc_threads`
--
ALTER TABLE `disc_threads`
  ADD CONSTRAINT `disc_threads_ibfk_2` FOREIGN KEY (`section`) REFERENCES `disc_sections` (`secid`),
  ADD CONSTRAINT `disc_threads_ibfk_3` FOREIGN KEY (`startedBy`) REFERENCES `users` (`uid`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `movies` (`mid`);

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orientatn`
--
ALTER TABLE `orientatn`
  ADD CONSTRAINT `orientatn_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `disc_posts` (`pid`);

--
-- Constraints for table `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `polls_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `disc_threads` (`tid`),
  ADD CONSTRAINT `polls_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`by`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`for`) REFERENCES `movies` (`mid`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`cscheme`) REFERENCES `cschemes` (`csid`);

--
-- Constraints for table `thread_viewed`
--
ALTER TABLE `thread_viewed`
  ADD CONSTRAINT `thread_viewed_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `thread_viewed_ibfk_4` FOREIGN KEY (`tid`) REFERENCES `disc_threads` (`tid`),
  ADD CONSTRAINT `thread_viewed_ibfk_5` FOREIGN KEY (`lastPostSeen`) REFERENCES `disc_posts` (`pid`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`pollid`) REFERENCES `polls` (`pollid`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `watched`
--
ALTER TABLE `watched`
  ADD CONSTRAINT `watched_ibfk_1` FOREIGN KEY (`who`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `watched_ibfk_2` FOREIGN KEY (`what`) REFERENCES `movies` (`mid`);

