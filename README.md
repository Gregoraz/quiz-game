### Introduction
A simple quiz game. Quiz questions are taken randomly from the API:

```
https://opentdb.com/api_config.php
```

### Configuration

We can configure game in .env file. There is a question amount, which will be asked to each player,
api host from trivia API and category from trivia API. More categories could be found on the link above.
Right now default category is set to Computing.


### Requirements
- composer 2 (is included in repo)
- php8.1-common


### Installation

After getting repository, we have to install composer requirements:

```
php composer.phar install
```

### Commands

All commands are available after executing:

```
php main.php
```

Start game command:
```
php main.php 1
php main.php start
php main.php quiz:play
```

Show stats command:
```
php main.php 2
php main.php stats
php main.php quiz:stats
```

Reset stats command:
```
php main.php 3
php main.php stats-reset
php main.php quiz:stats:reset
```
