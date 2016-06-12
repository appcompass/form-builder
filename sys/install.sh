rm -fr database/migrations/* &&
./artisan vendor:publish &&
./artisan migrate &&
./artisan module:load options &&
./artisan module:load settings &&
./artisan module:load tags &&
./artisan module:load websites &&
./artisan module:load permissions &&
./artisan module:load ui &&
./artisan module:load users &&
./artisan module:load alerts &&
./artisan module:load navigation &&
./artisan module:load pages &&
./artisan module:load galleries &&
./artisan module:load photos &&
./artisan module:load auth &&
./artisan module:reload websites &&
./artisan module:reload navigation &&
./artisan module:reload users &&
./artisan module:reload permissions &&
./artisan module:list &&
./artisan db:seed &&
./artisan vendor:publish