@test-continue
Feature: test session continue

Scenario: test continue
Given I am on "http://www.wikipedia.org/"
Then I follow "English"

@continue
Scenario: test continue 2
Then I follow "Random article"