<?php
/**
* Foodnet platform
* Copyright (C) 2018  Københavns Fødevarefællesskab and think.dk
*
* Københavns Fødevarefællesskab
* KPH-Projects
* Enghavevej 80 C, 3. sal
* 2450 København SV
* Denmark
* mail: bestyrelse@kbhff.dk
*
* think.dk
* Æbeløgade 4
* 2100 København Ø
* Denmark
* mail: start@think.dk
*	
* This source code is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This source code is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this source code.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
* @package janitor.users
* This file contains simple user extensions
* Meant to allow local user additions/overrides
*/

/**
* User customization class
*/
class User extends UserCore {


	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		parent::__construct(get_class());


	}

	function updateDepartment($action) {
		
		
	}

}

?>