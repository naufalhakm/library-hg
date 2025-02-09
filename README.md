# Library Microservice

## Overview
The **Library** Microservice is part of the **Library Management System** and is responsible for managing users, categories, books, and book borrowing.

This microservice is built using:
- **Laravel** for the backend.
- **MySQL** for the database.
- **JWT** for authentication.

---

## **Technologies Used**
- **Programming Language**: PHP (Laravel Framework)
- **Database**: MySQL
- **Authentication**: JWT
- **Middleware**: `jwt.auth`

---

## **API Documentation**
### REST API Endpoints

#### **Authentication**
| HTTP Method | Endpoint       | Description              |
|------------|---------------|--------------------------|
| `POST`     | `/api/v1/register`    | Register a new user      |
| `POST`     | `/api/v1/login`       | Login a user             |

#### **Categories** (Protected by JWT)
| HTTP Method | Endpoint          | Description                     |
|------------|------------------|---------------------------------|
| `GET`      | `/api/v1/categories`      | Get all categories              |
| `POST`     | `/api/v1/categories`      | Create a new category           |
| `GET`      | `/api/v1/categories/{id}` | Get details of a specific category |
| `PUT`      | `/api/v1/categories/{id}` | Update a category               |
| `DELETE`   | `/api/v1/categories/{id}` | Delete a category               |

#### **Books** (Protected by JWT)
| HTTP Method | Endpoint       | Description                     |
|------------|---------------|---------------------------------|
| `GET`      | `/api/v1/books`       | Get all books                   |
| `POST`     | `/api/v1/books`       | Create a new book               |
| `GET`      | `/api/v1/books/{id}`  | Get details of a specific book  |
| `PUT`      | `/api/v1/books/{id}`  | Update a book                   |
| `DELETE`   | `/api/v1/books/{id}`  | Delete a book                   |

#### **Borrowing Books** (Protected by JWT)
| HTTP Method | Endpoint           | Description                        |
|------------|-------------------|----------------------------------|
| `GET`      | `/api/v1/users/borrow`    | Get list of borrowed books        |
| `POST`     | `/api/v1/users/borrow`    | Borrow a book                     |
| `POST`     | `/api/v1/users/{id}/return` | Return a borrowed book            |

---

## Installation

### Prerequisites
- Install [PHP](https://www.php.net/downloads)
- Install [Composer](https://getcomposer.org/download/)
- Install [MySQL](https://www.mysql.com/downloads/)
- Install [Laravel](https://laravel.com/docs/)

### Setting Up the Project
1. Clone the repository:
   ```sh
   git clone https://github.com/naufalhakm/library-hg.git
   cd library-hg
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Set up the `.env` file:
   ```sh
   cp .env.example .env
   ```
   Update the database configuration in `.env`:
   ```sh
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Run database migrations:
   ```sh
   php artisan migrate
   ```
5. Generate an application key:
   ```sh
   php artisan key:generate
   ```
6. Generate JWT secret key:
   ```sh
   php artisan jwt:secret
   ```
7. Start the Laravel development server:
   ```sh
   php artisan serve
   ```

The API will be available at `http://127.0.0.1:8000/`.
