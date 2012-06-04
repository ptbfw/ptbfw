Feature: select test

@current
Scenario: test select onchange
Given I am on "http://localhost/Selenium2-driver/tests/www/select_on_change.html"
When I fill in "select_a" with "2"
Then I should see "2test"