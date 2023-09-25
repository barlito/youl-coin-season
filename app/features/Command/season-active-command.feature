@command @season

Feature:
    I want to test my command to activate Seasons

    Scenario: Update Seasons test with and passed endDate and in Active status

        Given a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | name   | Season to activate                             |
            | status | !php/enum App\Enum\SeasonStatusEnum::CREATED |

        When I run the command "app:season:activate"

        Given command out should contain "Activate Season : Season to activate | 965b08ce-9264-47e2-9086-00ac969bf609"

        Given a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |
