#language: en
Feature:
  In order to edit a survey
  As an admin
  I want to be able to modify an existing survey

  Background:
  	Given there is a organization:
  	  | Id | Name        |
  	  | 1  | samwiseCorp |
  	And there is a user:
  	  | id | username | password | first_name | last_name | organization_id | type  |
  	  | 1  | Admin    | 1234     | Admin      | User      | 1               | admin |
    And there is a survey:
      | id | organization_id | label       | isActive | isDeleted |
      | 1  | 1               | Test Survey | 1        | 0         |
    And there is a grouping:
      | id | survey_id | label                | ordering | is_used |
      | 1  | 1         | Personal Information | 1        | 1       |
      | 2  | 1         | Other Grouping       | 2        | 1       |

  @javascript
  Scenario: Update ordering of default Personal Information fields
  	Given I go to "admin/surveys/edit/1"
  	And I login as "Admin" with password "1234"
  	When I expand "Personal Information" 
    And I change "DOB" order value to "6"
  	And I change "Nickname" order value to "5"
  	And I click "Update Order"
  	Then I should see "DOB" with an order value of "5"
  	And I should see "Nickname" with an order value of "6"