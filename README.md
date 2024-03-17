# Laravel Admin Management System
Complete Backend Project with Laravel framework for Admin Management System (AMS)

## Starter Template
### Prerequisite
Server : Ubuntu 20.04 and above, PHP 7.3 and above<br>
localhost : XAMPP or MAMP, PHP 7.3 and above

### URL
Admin: {domain}/{project_name}/bol/login<br/>
http://localhost/laravel_admin_management_system/bol/login<br/>
Member: {domain}/{project_name}/login<br/>
http://localhost/laravel_admin_management_system/login<br/>

### Access
Admin: demo / admin / finance<br/>
Member: tester<br/>
Password = "username"+"1234"<br/>

### New setup
1. Clone this project to your localhost ( Use XAMPP or MAMP )
2. Follow step below
	- In a Terminal or Command Prompt, go to this project directory, run
	- <code>composer install</code>
	- <code>cp .env.example .env</code>( Mac only )
	- For Windows, copy .env.example and rename to .env
	- <code>php artisan key:generate</code>
	- Open .env file and change DB_DATABASE to localhost database, change APP_URL without tailing slash "/" http://localhost/{project_name} 
	- <code>php artisan migrate</code>
	- <code>php artisan db:seed</code>
	- <code>php artisan storage:link</code>

### Tips
<code>php artisan route:clear</code><br/>
<code>php artisan config:clear</code><br/>
Use sudo if permission denied.<br/>

