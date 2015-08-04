<?php
// ---------------------------------------
// Script created by John Brookes
// Copyright John Brookes ©2005
// http://www.gotaxe.com
// ---------------------------------------
// GARP v1.0 (GotAxe? Random Passwords)
// http://www.gotaxe.com/randpass.php
// ---------------------------------------

/*
    ==========================================================================
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    ==========================================================================
*/

// The number of textual characters at the beginning of the string
define('NUM_TEXT_CHARS', 8);

// The number of numeric characters at the end of the password string
define('NUM_NUMERIC_CHARS', 8);

// Do you want to use lower and UPPER case characters?  If false, only
// lower case characters will be used.
define('LOWER_AND_UPPER', true);

// This code below is simply to demonstrate how the script works.
// By using include('randpass.php'), the below code will be displayed
// automatically.

// If you remove the below code chunk, and keep just the two functions,
// you can call pass_gen(); in your code to generate a password and "return"
// it to your function.

/*****************************************************
if ($_POST['PW']) {
  // Return the password
  echo pass_gen();
  echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">
    <input type="hidden" name="PW" value="true">
    <input type="submit" value="Generate Another" name="submit">
    </form>';
} else {
  // Display the pass generation form
  echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">
    <input type="hidden" name="PW" value="true">
    <input type="submit" value="Generate A Password" name="submit">
    </form>';
}
******************************************************/
// -------------------------------------------------------------------------------------------------------------
// You don't need to edit anything below this line.
// -------------------------------------------------------------------------------------------------------------

function alphabet($innum) {
  if (LOWER_AND_UPPER) {
    $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
      'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  } else {
    $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
  }
  return $alphabet[$innum];
}

function pass_gen() {
  $a = 0;
  while ($a < NUM_TEXT_CHARS) {
    if (LOWER_AND_UPPER) {
      $random_char[$a] = alphabet(rand(0,51));
    } else {
      $random_char[$a] = alphabet(rand(0,25));
    }
    $a++;
  }
  while ($a < (NUM_TEXT_CHARS + NUM_NUMERIC_CHARS)) {
    $random_char[$a] = rand(0,9);
    $a++;
  }
  $a = 0;
  while ($a < (NUM_TEXT_CHARS + NUM_NUMERIC_CHARS)) {
    $random_password .= $random_char[$a];
    $a++;
  }
  return $random_password;
}


?>