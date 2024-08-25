To manually run/start chrome driver
-------------------------------
Mac
./vendor/laravel/dusk/bin/chromedriver-mac-intel 

copy the port and paste it in DuskTestcase.php > driver function.
http://localhost:[Copied port]

To Run dusk
-----------
php artisan migrate
php artisan dusk
