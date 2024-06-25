
# Fullstack Developer Test Task Documentation

## Overview

The Fullstack Developer Test Task is a simple To-Do list management system built with Laravel (backend) and NuxtJS (frontend). Users can view, create, update, and delete tasks. Here's what the completed application includes:

1. **Backend (Laravel with GraphQL):**

   - **Authentication:**
     - Users can log in and log out.
     - Only authenticated users can access the API.

   - **Task Management:**
     - A `Task` model with states: `todo` and `done`.
     - Each task belongs to a specific user.

   - **GraphQL API:**
     - Queries:
       - `tasks`: Fetch all tasks for the authenticated user.
     - Mutations:
       - `register`: Register the user.
       - `login`: Authenticate the user.
       - `logout`: Log out the user.
       - `createTask`: Create a new task.
       - `updateTask`: Update an existing task.
       - `deleteTask`: Delete a task.
       - `deleteAllTasks`: Delete all tasks.

   - **Unit Tests:**
     - Unit tests cover the API for `User` and the `Task` model.

   - **Constraints:**
     - Users can only manage their own tasks.
     - Task names can be the same for different users.

   - **Docker Setup:**
     - The backend is Dockerized for easy setup across different machines.

2. **Frontend (NuxtJS):**

   - **Features:**
     - ES6 features are used.
     - Integration with the Laravel backend.
     - Vuetify design framework for a polished UI.

   - **Vue.js Concepts and CSS/SASS:**
     - Demonstrates understanding of Vue.js concepts.
     - Clean and organized CSS/SASS structure.

   - **Readable Code Structure:**
     - Code is well-organized and follows best practices.

   - **Error Handling and Validation:**
     - Basic error handling for form submissions and API requests.

   - **Project Documentation:**
     - README file with setup instructions.
     - Any other relevant documentation.

   - **Additional Notes:**
     - Describes approach, challenges, and solutions.
     - Includes examples of text inputs and their summaries.
     - Outlines ideas for future enhancements.


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

