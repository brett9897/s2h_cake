<?php
use Behat\Behat\Context\Step\When;

$steps->Given('/^I login "([^"]*)" "([^"]*)"$/', function($world, $username, $password) {
  $steps = array();  
  $steps[] = new When('I fill in "Username" with "'.$username.'"');
  $steps[] = new When('I fill in "Password" with "'.$password.'"');
  $steps[] = new When('I press "Login"');
  return $steps;
});

$steps->When('/^I post article form :$/', function($world, $table) {
  $steps = array();  
  $hash = $table->getHash();
  foreach ($hash as $field) {
    $steps[] = new When('I fill in "'.$field['Label'].'" with "'.$field['Value'].'"');
  }
  $steps[] = new When('I press "Send"');
  return $steps;
});

?>