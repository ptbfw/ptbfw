Feature: ajax test
@current
Scenario: go to wikipedia
Given I am on "http://en.wikipedia.org/wiki/Main_Page"
When I fill in "searchInput" with "Behavior Driven Development"
And I press "searchButton"
Then I should see "Behavior-driven development (or BDD) is an"