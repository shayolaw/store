#!/bin/bash

# Start PHP-FPM (Laravel backend)
php artisan serve --host=0.0.0.0 --port=9000 &

# Start Vite (Frontend build tool)
npm run dev --prefix /var/www/html &

# Wait indefinitely to keep the container running
tail -f /dev/null

