Feature: List the users in the application

  Background:
    Given the database is empty
    And the fixtures "@UserBundle/DataFixtures/ORM/Coordinator.yml" are loaded
    And I am authenticated as "Coordinator"

  Scenario: List Users
    Given I am on the User list page
    Then I should see "user.list"
