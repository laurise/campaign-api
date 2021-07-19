# Instructions

./vendor/bin/sail up
./vendor/bin/sail artisan migrate --seed

Endpoints:
  - Get users: GET http://localhost/api/users?email=&name=
  - Get campaigns: GET http://localhost/api/campaigns?page=&sort=&sortBy=
  - Create campaigns: POST http://localhost/api/campaigns/create