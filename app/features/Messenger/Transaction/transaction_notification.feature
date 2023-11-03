@messenger @transaction

Feature:
    I want to test when a TransactionNotificationMessage is received
    UserScore should be created or updated if a Season is active

    Scenario Outline:
    I send incorrect Messages
    Errors should be logged
    UserScore entity should not be created or updated

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=188967649332428800" should match:
            | score | 10000 |
        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 1500 |

        When I send and consume a TransactionNotificationMessage to the queue with body:
        """
        {
          "amount": "<amount>",
          "walletTo": {
            "amount": "<walletToAmount>",
            "discordUser": {
              "discordId": "<discordUserIdTo>",
              "name": "Veli"
            },
            "type": "<walletToType>",
            "name": "Veli Wallet"
          },
          "walletFrom": {
            "amount": "<walletFromAmount>",
            "discordUser": {
              "discordId": "<discordUserIdFrom>",
              "name": "Juju"
            },
            "type": "<walletFromType>",
            "name": "Wallet Juju"
          },
          "externalIdentifier": null,
          "type": "classic"
        }
        """

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=188967649332428800" should match:
            | score | 10000 |
        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 1500 |

        And the logger logged an error containing "<message>"

        Examples:
            | amount | discordUserIdTo    | discordUserIdFrom  | walletToAmount | walletFromAmount | walletToType | walletFromType | message                                    |
            |        | 188967649332428800 | 195659530363731968 | 1000           | 1000             | classic      | classic        | The amount value should not be blank.      |
            | 10     |                    | 195659530363731968 | 1000           | 1000             | classic      | classic        | The discordId value should not be blank.   |
            | 10     | 188967649332428800 |                    | 1000           | 1000             | classic      | classic        | The discordId value should not be blank.   |
            | 10     | 188967649332428800 | 188967649332428800 |                | 1000             | classic      | classic        | The amount value should not be blank.      |
            | 10     | 188967649332428800 | 195659530363731968 | 1000           |                  | classic      | classic        | The amount value should not be blank.      |
            | 10     | 188967649332428800 | 195659530363731968 | 1000           | 1000             |              | classic        | The Wallet Type value should not be blank. |
            | 10     | 188967649332428800 | 195659530363731968 | 1000           | 1000             | classic      |                | The Wallet Type value should not be blank. |

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 1500 |

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

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 3000001500 |

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 1500 |

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

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | -2999998500 |

    Scenario: I receive a correct Bank Transaction Message
    TransactionNotificationMessage should be processed
    A UserScore should be created with correct score for the User

        Given I reload the fixtures

        And a "Season" entity found by "status=active" should match:
            | id | 4abc4578-0b77-432e-8dc4-89d7fafe5f26 |

        And a "Leaderboard" entity found by "season=4abc4578-0b77-432e-8dc4-89d7fafe5f26" should match:
            | id | fdd01f6c-6f61-45c7-8fbe-cdf89579eacc |

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=189029821328785409" should match:
            | score | 2500 |
        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | 1500 |

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

        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=189029821328785409" should match:
            | score | 3000002500 |
        And a "UserScore" entity found by "leaderboard=fdd01f6c-6f61-45c7-8fbe-cdf89579eacc&discordUserId=195659530363731968" should match:
            | score | -2999998500 |
