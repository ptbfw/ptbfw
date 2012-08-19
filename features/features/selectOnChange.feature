Feature: select test


Scenario: test select onchange
Given I am on "http://localhost/Selenium2-driver/tests/www/select_on_change.html"
When I select "2" from "select_a"
Then I should see "2test"

Scenario: test select onchange
Given I am on "http://localhost/Selenium2-driver/tests/www/select_on_change.html"
When I select "empty" from "select_b"
Then I should see "b__b"