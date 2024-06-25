
---

# To-Do List Management System

This project is a simple To-Do list management system built using Laravel 10 (backend) and Nuxt 3 (frontend). It allows users to create, update, and delete tasks.

1. Clone the repository:
   ```
   git clone <repository-url> 
   ```
## Backend (Laravel)

### Setup


2. `cd backend` Create a `.env` file based on `.env.example` and configure your database connection.

3. Open your `.env` file (located in the root directory of your Laravel project).

4. Locate the line that defines the `DB_HOST` variable. It might look something like this:
   ```
   DB_HOST=127.0.0.1
   ```

5. Replace the existing value with `db`:
   ```
   DB_HOST=db
   ```

6. Save the changes to your `.env` file.

7. Install dependencies:
   ```
   composer install
   ```

8. Run database migrations:
   ```
   php artisan migrate
   ```

### Run the Backend

Execute:
```
php artisan serve
```

## Frontend (NuxtJS)

### Setup

9. `cd frontend` Create a `.env` file and set the API endpoint (pointing to your Laravel backend).

10. Install dependencies:
   ```
   pnpm install
   ```

### Access the Application

Run:
```
pnpm run dev
```

Open your browser and navigate to `http://localhost:3000`.

