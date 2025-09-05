# HMIS Vendor Evaluation Tool

A web-based tool to facilitate the evaluation of HMIS vendors based on predefined criteria.

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- A database (MySQL, PostgreSQL, SQLite, etc.)

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/hmis-evaluation.git
    cd hmis-evaluation
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

4.  **Set up your environment:**
    -   Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Generate an application key:
        ```bash
        php artisan key:generate
        ```
    -   Configure your database connection in the `.env` file. For example, for a local SQLite database, you can set:
        ```
        DB_CONNECTION=sqlite
        DB_DATABASE=/path/to/your/database.sqlite
        ```
        Make sure the sqlite file exists. You can create it with `touch database/database.sqlite`.

5.  **Run database migrations and seeders:**
    This will create the necessary tables and populate the vendors table with initial data.
    ```bash
    php artisan migrate --seed
    ```

## Running the Application

1.  **Start the development server:**
    ```bash
    php artisan serve
    ```

2.  **Compile frontend assets:**
    The project uses Tailwind CSS and Alpine.js. The following command will watch for changes in your CSS and JS files and recompile them automatically.
    ```bash
    npm run dev
    ```

    For production, use:
    ```bash
    npm run build
    ```

3.  Access the application in your browser at the address provided by `php artisan serve` (usually `http://127.0.0.1:8000`).

## Running Tests

To run the test suite:
```bash
php artisan test
```