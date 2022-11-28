# dockerized command chain

docker exec -it example_app_php bash

https://github.com/mbessolov/test-tasks/blob/master/7.md

Yo can register master command or chain command in app/bundles/CommandChainBundle/Resources/config/services.yaml
file
The first one it's a master command the command above it's a chain commands.

CommandChainBundle not invasive - so you can use it in any place of your application.

Next release will build on chain of [responsibility pattern](https://en.wikipedia.org/wiki/Chain-of-responsibility_pattern)