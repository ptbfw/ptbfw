Feature: ajax test
@current
Scenario: go to wikipedia
Given I am on "http://en.wikipedia.org/wiki/Main_Page"
When I fill in "searchInput" with "behaviour drive"
Then I should see "Behaviour-driven development"