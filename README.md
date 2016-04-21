BadDeeds-Logic
==============

[![Build Status](https://travis-ci.org/dmelo/baddeeds-logic.svg)](https://travis-ci.org/dmelo/baddeeds-logic)

BadDeeds-Logic contains the business logic of BadDeeds. The projects is
framework agnostic and is written for PHP 7. The main class is
`\BadDeeds\Controller\Api`. BadDeeds-Logic provides the following features:

- List the latest deeds (Api::list);
- Insert a new deed (Api::insert).

`\BadDeeds\Controller\Api`'s construtor requires a PDO.
