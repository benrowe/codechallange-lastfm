# Lastfm Coding Challange

## How to setup

- Copy the .env.example to .env and update the variables within
- point all http requests to public/index.php


## Braindump

Application planning :)

### Application Structure

- app
- assets
- bootstrap
- config
- public
- storage
- tests

### Process

- build directory structure
- setup travis/scrutinizer
- setup heroku
- build basic tests for required components
- stub out components/interfaces as per tests
- implement logic for components
- build bootstrap
- build routes
- setup controller/view logic
- build lastfm service
- implement service into controller/view
- styling
- angular2

### Required components
- env
- config
- app container
 - services
  - lastfm
 - router
- controller
- view

# extra points

- git flow - tick
- flexible configuration (.env + config) - tick
- unit testing - tick
- automation - travis/scrutinizer/heroku - tick
