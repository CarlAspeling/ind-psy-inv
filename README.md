# Industrial Psychology Inventories

Description: This app enables users to complete industrial psychology-related inventories (questionnaires) and to see their
                results contextualised to a relevant domain (e.g., career interests, personality). 

## Tech Stack
-> **Laravel 12**
-> **Docker + Laravel Sail**
-> **Filament Admin Panel**
-> **Livewire**
-> **Tailwind CSS**
-> **Vite**
-> **MySQL**

---

## Requirements

### Required
1. Access to a unix based system: Linux, MacOS, WSL2. 
2. Docker. 

### Optional
1. Alias for ./vendor/bin/sail in your .bashrc file. If opting for an alias, adjust installation steps accordingly. 
    _For information on how to set up this alias, feel free to visit: https://bobcares.com/blog/laravel-sail-alias/_

---

## Installation
1. Clone the repository to your local environment
2. Copy the .env.example file and edit it accordingly. 
3. Run './vendor/bin/sail up -d'
4. Run './vendor/bin/sail composer install'
5. Run './vendor/bin/sail artisan: key:generate'
6. Run './vendor/bin/sail artisan migrate'
7. Run './vendor/bin/sail artisan db:seed'
8. Run './vendor/bin/sail npm install'
9. Run './vendor/bin/sail npm run dev'

---

## Accessing the platform:
1. A user record is created in the initial seed of the database.
Username: test@example.com
Password: password
