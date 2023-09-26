@command @season

Feature:
    I want to test my command to activate Seasons

    Scenario: Update Seasons test with and passed endDate and in Active status

        Given a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | name | Season to finish |
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |

        When I run the command "app:season:finish"

        Then the command should be successful

        And command output should contain "Finish Season : Season to finish | 4abc4578-0b77-432e-8dc4-89d7fafe5f26"

        And a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::FINISHED |




