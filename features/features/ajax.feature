Feature: ajax test

Scenario: go to wikipedia
Given I am on "http://en.wikipedia.org/wiki/Main_Page"
When I fill in "search" with "Behavior Driven Development"
And I press "searchButton"
