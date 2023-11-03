@command @season

Feature:
    I want to test my command to give rewards to users

    Scenario: I want to test my YoulCoin Reward is given to the first user on the Leaderboard
        Given I reload the fixtures

        And a "Season" entity found by "id=7558e085-9f5e-404d-a15f-e286c24ec7e4" should match:
            | status | !php/enum App\Enum\SeasonStatusEnum::FINISHED |

        And a "UserScore" entity found by "id=863c82cb-1091-4f1d-acfa-5d6a71378387" should match:
            | score | 5000 |
            | rank  | 1     |

        When I run the command "app:reward:distribution"

        Then the command should be successful
