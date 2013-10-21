isotope_rules_BirthdayMailer
============================

This Contao extension extends [BirthdayMailer](https://github.com/cliffparnitzky/BirthdayMailer/tree/Version-2) and provides the possibility to auto generate isotope coupons for birthday members.

Usage:
------
* Add an hook to BirthdayMailer as [described in this ticket](https://github.com/cliffparnitzky/BirthdayMailer/issues/4). It is necessary becaus it is not implemented in the Contao 2 version.
* Extend the BirthdayMailer configuration in the back end.
* Use the InsertTag {{birthdaychild::coupon}} (``code`` or ``couponcode`` possible too) to insert the coupon code in the birthday mail.
