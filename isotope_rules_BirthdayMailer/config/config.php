<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @package    Isotope
 * @license    LGPL
 * @filesource
 */


/**
 * Hooks
 * This hook is added manually because it is not implemented in Contao 2.11 the extension is made for
 * @see https://github.com/cliffparnitzky/BirthdayMailer/issues/4
 */
$GLOBALS['HOOKS']['preSendBirthdayMail'][] = array('BirthdayMailerCoupon', 'addCouponForMember');
