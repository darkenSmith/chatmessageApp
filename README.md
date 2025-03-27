# ChatMessageApp Usage

**ChatMessageApp** is a real-time messaging system where users send messages for processing, an admin team confirms them, and the messages are labeled as "complete" before being returned to the user. The backend is powered by **Laravel 11** and **PHP 8.2**, using **Laravel Reverb** for WebSocket-based real-time updates. The frontend, built with **Angular 18**, provides an interactive interface for message submission and status tracking. Data is stored in a MySQL database for persistence.

## Features
- **Message Submission**: Users send messages via the Angular frontend to the Laravel API.
- **Admin Confirmation**: An admin team processes messages, marking them as "complete" (assumed via backend logic).
- **Real-Time Updates**: Laravel Reverb broadcasts completed messages to users instantly over WebSockets.
- **Tech Stack**: Laravel 11, Laravel Reverb, PHP 8.2, Angular 18, MySQL.

## Running Locally

These instructions detail how to run the project locally using your host’s PHP, Node.js, and MySQL installations, based on the repository at `https://github.com/darkenSmith/chatmessageApp`. Node.js is required to build and serve the Angular frontend.

### Prerequisites
- **PHP 8.2+** with Composer (extensions: `pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`)
- **Node.js 18+** with npm (for Angular frontend development and runtime)
- **MySQL 5.7 or 8.0**
- **Git** (to clone the repository)

### Setup Instructions

- fork repo if need be.

1. **Setup MySQL**
    - Start your local MySQL server.
    
3. **Configure Laravel Backend**
    - Install PHP dependencies:
      ```bash
      composer install
      ```
    
      Edit `.env` make sure database name is `messageapp` and
    - also edit reverb setup - here are some defaults: 
    - ```
      REVERB_APP_ID=802751
      REVERB_APP_KEY=hbrebdgtltg89tldyqme
      REVERB_APP_SECRET=rrhixcnx5xgaxkypabhx
      REVERB_HOST="localhost"
      REVERB_PORT=8080
      REVERB_SCHEME=http
      ```
    - run migrations:
      ```bash
      php artisan migrate
      ```

4. **Run Laravel Server**
    - Start the Laravel API server:
      ```bash
      php artisan serve --port=8000
      ```
    - This runs the API at `http://localhost:8000`.

5. **Start Laravel Reverb**
    - Open a new terminal tab and navigate to the project root:
      ```bash
      cd messageApp
      ```
    - Start the Reverb WebSocket server:
      ```bash
      php artisan reverb:start --host=127.0.0.1 --port=8080
      ```
    - This runs Reverb at `ws://localhost:8080`.

6. **Run Angular Frontend**
    - Navigate to the frontend directory:
      ```bash
      cd /messageApp/realtime-chat-app
      ```
    - Install Node.js dependencies (required for Angular):
      ```bash
      npm install
      ```
    - you can edit the  `realtime-chat-app/src/environments/environment.ts`:

    - Start the Angular frontend:
      ```bash
      ng serve --port=4200
      ```
    - This runs the frontend at `http://localhost:4200`.

7. **Access the Application**
    - **Laravel API**: `http://localhost:8000`
    - **Reverb WebSocket**: `ws://localhost:8080`
    - **Angular Frontend**: `http://localhost:4200`

### Notes
- Keep three terminal windows open:
    1. Laravel API: `php artisan serve --port=8000`
    2. Reverb: `php artisan reverb:start --host=127.0.0.1 --port=8080`
    3. Angular: `ng serve --port=4200`
- there was a docker setup but due to my low storage i was having issue setting up correctly
