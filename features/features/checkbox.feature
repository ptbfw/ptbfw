Feature: select test


Scenario: test select onchange
Given I am on "http://localhost/Selenium2-driver/tests/www/checkbox.html"
When I check "check1"
Then I should see "check1test"
When I uncheck "check1"
Then I should not see "check1test"
