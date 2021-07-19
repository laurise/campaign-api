## Instructions

Setup:
  - git clone https://github.com/laurise/campaign-api.git
  - composer install
  - ./vendor/bin/sail up
  - ./vendor/bin/sail artisan migrate --seed

Test:
  - ./vendor/bin/sail artisan test 

Endpoints:
  - Get users: GET http://localhost/api/users?email=&name=
  - Get campaigns: GET http://localhost/api/campaigns?page=&sort=&sortBy=
  - Create campaigns: POST http://localhost/api/campaigns