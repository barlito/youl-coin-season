@messenger @transaction

Feature:
    I want to test when a TransactionNotificationMessage is received
    UserScore should be created or updated if a Season is active

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And I should find "0" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        When I send and consume a TransactionNotificationMessage to the queue with body:
        """
        {
          "amount": "3000000000",
          "walletFrom": {
            "amount": "997000000000",
            "discordUser": null,
            "type": "bank",
            "name": "Bank Wallet"
          },
          "walletTo": {
            "amount": "803000000000",
            "discordUser": {
              "discordId": "195659530363731968",
              "name": "Juju"
            },
            "type": "user",
            "name": "Wallet Juju"
          },
          "externalIdentifier": null,
          "type": "air_drop"
        }
        """

        And I should find "1" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        And a "UserScore" entity found by "discordUserId=195659530363731968" should match:
            | score          | 3000000000                           |
            | leaderboard.id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And I should find "0" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        When I send and consume a TransactionNotificationMessage to the queue with body:
        """
        {
          "amount": "3000000000",
          "walletTo": {
            "amount": "1030000000000",
            "discordUser": null,
            "type": "bank",
            "name": "Bank Wallet"
          },
          "walletFrom": {
            "amount": "797000000000",
            "discordUser": {
              "discordId": "195659530363731968",
              "name": "Juju"
            },
            "type": "user",
            "name": "Wallet Juju"
          },
          "externalIdentifier": null,
          "type": "air_drop"
        }
        """

        And I should find "1" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        And a "UserScore" entity found by "discordUserId=195659530363731968" should match:
            | score          | -3000000000                          |
            | leaderboard.id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And I should find "0" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        When I send and consume a TransactionNotificationMessage to the queue with body:
        """
        {
          "amount": "3000000000",
          "walletTo": {
            "amount": "1030000000000",
            "discordUser": {
              "discordId": "189029821328785409",
              "name": "Veli"
            },
            "type": "user",
            "name": "Veli Wallet"
          },
          "walletFrom": {
            "amount": "797000000000",
            "discordUser": {
              "discordId": "195659530363731968",
              "name": "Juju"
            },
            "type": "user",
            "name": "Wallet Juju"
          },
          "externalIdentifier": null,
          "type": "classic"
        }
        """

        And I should find "2" "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc"

        And a "UserScore" entity found by "discordUserId=189029821328785409" should match:
            | score          | 3000000000                           |
            | leaderboard.id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And a "UserScore" entity found by "discordUserId=195659530363731968" should match:
            | score          | -3000000000                          |
            | leaderboard.id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |
