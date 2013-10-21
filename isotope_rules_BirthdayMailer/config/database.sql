-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

--
-- Table `tl_birthdaymailer`
--
CREATE TABLE `tl_birthdaymailer` (
	`autoCoupon` char(1) NOT NULL default '',
	`couponDiscount` varchar(16) NOT NULL default '',
	`couponPeriod` varchar(16) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table `tl_iso_rules`
--
CREATE TABLE `tl_iso_rules` (
	`birthdayCoupon` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
