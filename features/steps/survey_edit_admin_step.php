<?php
use Behat\Behat\Context\Step\When;

$steps->Given('/^there is a organization:$/', function($world, $table) {
  $hash = $table->getHash();
  $world->truncateModel('organizations');
  $post = $world->getModel('organizations');
  foreach ($hash as $row) {
    $post->create(array('organizations'=>array('id'=>$row['Id'], 'name'=>$row['Name'], 'isDeleted' => 0)));
    $post->save();
  }
});

$steps->Given('/^there is a user:$/', function($world, $table) {
  $hash = $table->getHash();
  $world->truncateModel('users');
  $user = $world->getModel('users');
  foreach ($hash as $row) {
    $user->create(
      array(
        'users'=>array(
          'id'=>$row['id'], 
          'username'=>$row['username'], 
          'password'=>AuthComponent::password($row['password']), 
          'first_name'=>$row['first_name'], 
          'last_name'=>$row['last_name'], 
          'organization_id' => $row['organization_id'], 
          'type' => $row['type']
        )
      )
    );
    $user->save();
  }
});

$steps->Given('/^there is a survey:$/', function($world, $table) {
  $hash = $table->getHash();
  $world->truncateModel('surveys');
  $survey = $world->getModel('surveys');
  foreach ($hash as $row) {
    $survey->create(
      array(
        'surveys'=>array(
          'id'=>$row['id'], 
          'organization_id' => $row['organization_id'],
          'label'=> $row['label'], 
          'isActive'=>$row['isActive'], 
          'isDeleted'=>$row['isDeleted'],
        )
      )
    );
    $survey->save();
  }
});
$steps->Given('/^there is a grouping:$/', function($world, $table) {
  $hash = $table->getHash();
  $world->truncateModel('groupings');
  $survey = $world->getModel('groupings');
  foreach ($hash as $row) {
    $survey->create(
      array(
        'groupings'=>array(
          'id'=>$row['id'], 
          'survey_id' => $row['survey_id'],
          'label'=> $row['label'], 
          'ordering'=>$row['ordering'], 
          'is_used'=>$row['is_used'],
        )
      )
    );
    $survey->save();
  }
});
$steps->Given('/^I login as "([^"]*)" with password "([^"]*)"$/', function($world, $username, $password) {
    $steps = array();
    $steps[] = new When('I fill in "UserUsername" with "' . $username . '"');
    $steps[] = new When('I fill in "UserPassword" with "' . $password . '"');
    $steps[] = new When('I press "Login"');
    return $steps;
});

$steps->When('/^I change "([^"]*)" order value to "([^"]*)"$/', function($world, $row, $value) {
  $session = $world->getSession('selenium');
  $page = $session->getPage();

  $question = $page->find('css', '.question.' . str_replace(' ', '_', $row));
  $div = $question->findField('input.ordering.' . str_replace(' ', '_', $row));
  assertNotNull($div, $row . ' could not be found');
  $div->setValue($value);
});

$steps->Given('/^I click "([^"]*)"$/', function($world, $arg1) {
    throw new \Behat\Behat\Exception\PendingException();
});

$steps->Then('/^I should see "([^"]*)" with an order value of "([^"]*)"$/', function($world, $arg1, $arg2) {
    throw new \Behat\Behat\Exception\PendingException();
});

$steps->Given('/^I expand "([^"]*)"$/', function($world, $value) {
    $session = $world->getSession('selenium');
    $session->wait('5000');
    $page = $session->getPage();

    $h3 = $page->findAll('css', 'h3');
    $group = null;
    foreach( $h3 as $header )
    {
      if( $header->getText() == $value )
      {
        $group = $header;
        break;
      }
    }

    assertNotNull($group);
    $group->click();
});
?>