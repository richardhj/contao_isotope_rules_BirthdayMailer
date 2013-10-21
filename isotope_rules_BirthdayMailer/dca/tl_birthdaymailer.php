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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_birthdaymailer']['palettes']['__selector__'][] = 'autoCoupon';
$GLOBALS['TL_DCA']['tl_birthdaymailer']['palettes']['default'] .= ';{isotope_legend},autoCoupon';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_birthdaymailer']['subpalettes']['autoCoupon'] = 'couponDiscount,couponPeriod';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_birthdaymailer']['fields']['autoCoupon'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_birthdaymailer']['autoCoupon'],
	'exclude'       => true,
	'search'        => true,
	'inputType'     => 'text',
	'eval'          => array('submitOnChange'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_birthdaymailer']['fields']['couponDiscount'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_birthdaymailer']['couponDiscount'],
	'exclude'       => true,
	'inputType'     => 'text',
	'eval'          => array('mandatory'=>true, 'maxlength'=>16, 'rgxp'=>'discount', 'tl_class'=>'clr w50')
);

$GLOBALS['TL_DCA']['tl_birthdaymailer']['fields']['couponPeriod'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_birthdaymailer']['couponPeriod'],
	'exclude'       => true,
	'inputType'     => 'text',
	'eval'          => array('mandatory'=>true, 'maxlength'=>16, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'load_callback' => array(array('BirthdayMailerCoupon', 'returnDefaultCouponPeriod'))
);
