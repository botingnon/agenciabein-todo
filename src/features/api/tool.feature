@tools @crud
Feature: Teste CRUD Ferramentas

  Scenario: Criando uma nova ferramenta
    Given that I want to make a new "Tool"
    And his "title" is "hotel"
    And his "link" is "https://github.com/typicode/hotel"
    And his "description" is "Local app manager. Start apps within your browser, developer tool with local .localhost domain and https out of the box."
    And his "tags" json is ["node", "organizing", "webapps", "domain", "developer", "https", "proxy"]    
    And the request is sent as JSON
    When I request "tool"
    Then the response status code should be 200
    And the response should be JSON
    And the response has a "id" property

  Scenario: Apagando Tool
    Given that I want to delete an "Tool"
    And his "id" is 1
    When I request "tool/{id}"
    Then the response status code should be 200
    And the response should be JSON
    And the response has an "id" property