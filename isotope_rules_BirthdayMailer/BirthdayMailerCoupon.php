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
 * Class BirthdayMailerCoupon
 *
 * Provides the hook used for BirthdayMailer and miscellaneous functions.
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @package    Isotope
 */
class BirthdayMailerCoupon extends Backend
{
	/**
	 * Construct the class
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Add an coupon restricted for the birthday member
	 * @param object
	 * @throws Exception
	 * @return bool
	 */
	public function addCouponForMember($objConfig)
	{
		$objBirthdayMailer = $this->Database->prepare("SELECT couponDiscount,couponPeriod FROM tl_birthdaymailer WHERE memberGroup=(SELECT group_id FROM tl_member_to_group WHERE member_id=?)")
		                                    ->limit(1)
		                                    ->execute($objConfig->id);

		if (!$objBirthdayMailer->couponDiscount || !$objBirthdayMailer->couponPeriod)
		{
			throw new Exception('Birthday mailer configuration not entire or not found.');
		}

		$time = time();

		$arrRuleParams = array
		(
			'tstamp'                => $time,
			'type'                  => 'cart',
			'name'                  => sprintf($GLOBALS['TL_LANG']['MSC']['iso_memberCouponName'], $objConfig->firstname . ' ' . $objConfig->lastname),
			'label'                 => $GLOBALS['TL_LANG']['MSC']['iso_memberCouponLabel'],
			'applyTo'               => 'subtotal',
			'discount'              => $objBirthdayMailer->couponDiscount,
			'enableCode'            => 1,
			'code'                  => $this->generateCoupon(),
			'quantityMode'          => 'cart_items',
			'limitPerMember'        => 1,
			'endDate'               => $time+$objBirthdayMailer->couponPeriod,
			'memberRestrictions'    => 'members',
			'productRestrictions'   => 'none',
			'enabled'               => 1,
			'birthdayCoupon'        => 1
		);

		// Update tl_iso_rules
		$objRule = $this->Database->prepare("INSERT INTO tl_iso_rules %s")
		                          ->set($arrRuleParams)
		                          ->execute();

		$arrRestrictionParams = array
		(
			'pid'       => $objRule->insertId,
			'tstamp'    => $time,
			'type'      => 'members',
			'object_id' => $objConfig->id
		);

		// Update tl_iso_rule_restrictions
		$this->Database->prepare("INSERT INTO tl_iso_rule_restrictions %s")
		               ->set($arrRestrictionParams)
		               ->execute();

		$this->archiveOutdatedCoupons($time);

		return true;
	}


	/**
	 * Check for out-dated coupons and delete them
	 */
	protected function archiveOutdatedCoupons($time)
	{
		// Fetch possible coupons
		$objOutdatedCoupons = $this->Database->query("SELECT id FROM tl_iso_rules WHERE endDate < $time AND birthdayCoupon=1");

		while ($objOutdatedCoupons->next())
		{
			// tl_iso_rules
			$this->Database->prepare("DELETE FROM tl_iso_rules WHERE id=?")
			               ->execute($objOutdatedCoupons->id);

			// tl_iso_rule_restrictions
			$this->Database->prepare("DELETE FROM tl_iso_rule_restrictions WHERE pid=?")
			               ->execute($objOutdatedCoupons->id);
		}
	}


	/**
	 * Return an unique coupon code
	 * @param int
	 * @return string
	 */
	protected function generateCoupon($len=8)
	{
		$strCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, $len));

		// Return coupon code but check if code already exists
		return ($this->Database->prepare("SELECT id FROM tl_iso_rules WHERE code=?")->limit(1)->execute($strCode)->numRows) ? $this->generateCoupon($len) : $strCode;
	}


	/**
	 * Replace the coupon insert tag
	 */
	public function replaceBirthdayMailInsertTags($strTag)
	{
		$objConfig = BirthdayMailSender::getCurrentConfig();
		$arrTagChunks = explode('::', $strTag);

		if ($arrTagChunks[0] == 'brithdaychild' && $objConfig)
		{
			if (in_array($arrTagChunks[1], array('coupon', 'code', 'couponcode')))
			{
				$objCoupon = Database::getInstance()->prepare("SELECT code FROM tl_iso_rules WHERE id=(SELECT pid FROM tl_iso_rule_restrictions WHERE object_id=?) AND enabled=1")
				                                    ->limit(1)
				                                    ->execute($objConfig->id);

				return ($objCoupon->numRows > 0) ? $objCoupon->code : 'ERROR';
			}
		}

		return false;
	}


	/**
	 * Return the default coupon period (one month) as field callback
	 * @param var
	 * @param object
	 * @return int
	 */
	public function returnDefaultCouponPeriod($varValue, $dc)
	{
		if (!$varValue)
		{
			return 60*60*24*31; // Highest possible seconds of a month (= 31 days)
		}

		return $varValue;
	}
}
