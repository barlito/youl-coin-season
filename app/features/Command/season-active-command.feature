@command @season

Feature:
    I want to test my command to activate Seasons

    Scenario: I want to test that a Season can't be activated is another is already active
        Given I reload the fixtures

        Given a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | name   | Season to activate                           |
            | status | !php/enum App\Enum\SeasonStatusEnum::CREATED |

        And a "Season" entity found by "id=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |

        When I run the command "app:season:activate"

        Then the command should be successful

        And command output should contain "Activate Season : Season to activate | 965b08ce-9264-47e2-9086-00ac969bf609"
        And command output should contain "Season 965b08ce-9264-47e2-9086-00ac969bf609 is not valid"
        And command output should contain "Only one Season can be Active at a time."

        And a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::CREATED |

    Scenario: Update Seasons test with and passed endDate and in Active status
        Given I reload the fixtures

        And I finish all active Seasons

        And a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | name   | Season to activate                           |
            | status | !php/enum App\Enum\SeasonStatusEnum::CREATED |

        When I run the command "app:season:activate"

        Then the command should be successful

        And command output should contain "Activate Season : Season to activate | 965b08ce-9264-47e2-9086-00ac969bf609"

        And a "Season" entity found by "id=965b08ce-9264-47e2-9086-00ac969bf609" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::ACTIVE |
