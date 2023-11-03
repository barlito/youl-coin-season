@command @season

Feature:
    I want to test my command to activate Seasons

    Scenario: Update Seasons to finish

        Given a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | name   | Season to finish                            |
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |

        When I run the command "app:season:finish"

        Then the command should be successful

        And command output should contain "Finish Season : Season to finish | 4abc4578-0b77-432e-8dc4-89d7fafe5f26"

        And a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::FINISHED |


    Scenario: Update Seasons to finish
    Ranks should be updated

        Given I reload the fixtures

        And a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | name   | Season to finish                            |
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |

        And a "UserScore" entity found by "id=9308cf83-b52c-4326-b1c1-e0e55aeb35fa" should match:
            | score | 10000 |
            | rank  |       |
        And a "UserScore" entity found by "id=8562c20e-4a15-488f-8da0-c60e1d10068f" should match:
            | score | 5000 |
            | rank  |      |

        When I run the command "app:season:finish"

        Then the command should be successful

        And command output should contain "Finish Season : Season to finish | 4abc4578-0b77-432e-8dc4-89d7fafe5f26"

        And a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::FINISHED |

        And a "UserScore" entity found by "id=9308cf83-b52c-4326-b1c1-e0e55aeb35fa" should match:
            | score | 10000 |
            | rank  | 1     |
        And a "UserScore" entity found by "id=8562c20e-4a15-488f-8da0-c60e1d10068f" should match:
            | score | 5000 |
            | rank  | 2    |
