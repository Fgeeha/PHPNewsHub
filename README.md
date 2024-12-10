# PHPNewsHub

# PHP News Management System with PostgreSQL

## Overview

This is a simple PHP-based news management system that allows users to manage news articles. It supports creating, viewing, editing, deleting news articles, and adding images to each news item. The system is backed by a PostgreSQL database.

## Project Structure

```
├── src/                     # Source code directory
│   ├── config/              # Database configuration
│   ├── controllers/         # Controller classes (handles logic)
│   ├── models/              # Model classes (interact with the database)
│   ├── views/               # View templates (HTML files)
│   ├── uploads/             # Directory for uploaded images
│   ├── public/assets        # Directory for css/js/images
│   ├── .htaccess            # Apache configuration file for URL routing
│   ├── index.php            # File for URL routing
├── sql/                     # Database schema files
│   ├── init.sql             # SQL initialization script for setting up the PostgreSQL database
├── .dockerignore            # Docker ignore file
├── Dockerfile               # Docker configuration for building the PHP container
├── docker-compose.yml       # Docker Compose configuration for services (app, db, pgAdmin)
├── makefile                 # Makefile for managing Docker commands
├── TODO.md                  # To-do list for the project
├── .gitignore               # Git ignore file
├── makefile                 # Used for automating common tasks related to managing Docker containers
```

## Requirements

- **PHP 7.4 or higher**
- **PostgreSQL 15**
- **Docker (optional, for containerized environment)**

## Installation

### 1. Clone the Repository

```bash
git clone <repository_url>
cd <project_directory>
```

### 2. Set Up Database (PostgreSQL)

The PostgreSQL database is set up automatically using Docker.

1. Ensure you have PostgreSQL set up with the following credentials (configured in `docker-compose.yml`):

   - **User**: `news_user`
   - **Password**: `news_password`
   - **Database**: `news_db`

2. The database schema is initialized using the `init.sql` script located in the `sql/` folder.

3. Start the application services (PHP, PostgreSQL, and pgAdmin) using Docker Compose:

```bash
docker-compose up --build -d
```

This will start the services:

- **PHP App**: Accessible via `http://localhost:80`
- **PostgreSQL Database**: Accessible via port `5432`
- **pgAdmin**: Accessible via `http://localhost:8001` (Login with `admin@admin.org` and password `admin_password`)

### 3. Access the Application

Once the application is running, you can access the following:

- **Home Page**: [http://localhost](http://localhost) – Displays all news articles.
- **All News**: [http://localhost/news](http://localhost/news) – Lists all the news articles.
- **News Details**: [http://localhost/news/{id}](http://localhost/news/{id}) – Shows the details of a specific news article.
- **Add News**: [http://localhost/add-news](http://localhost/add-news) – Adds a new news article.
- **Edit News**: [http://localhost/edit-news/{id}](http://localhost/edit-news/{id}) – Edits an existing news article.
- **Delete News**: [http://localhost/delete-news/{id}](http://localhost/delete-news/{id}) – Deletes a news article.

## Usage

### Routes

- **Home Page** `/` or `/index.php`: Displays all news articles.
- **All News** `/news`: Lists all news articles.
- **News Details** `/news/{id}`: Shows the detailed view of a specific news article.
- **Add News** `/add-news`: Allows you to add a new news article.
- **Edit News** `/edit-news/{id}`: Edit an existing news article.
- **Delete News** `/delete-news/{id}`: Delete a news article.

### Functionalities

- **Add News**: Allows submitting a title, content, and optionally an image.
- **Edit News**: Modify the title, content, and images of an existing news article.
- **Delete News**: Remove a news article from the database.
- **Image Upload**: Allows attaching images to news articles, which are stored in the `uploads/` directory.

## Development

### Docker Setup

The project is containerized with Docker. You can manage the application with Docker Compose, which will start the app and the PostgreSQL database as services.

- To start the app, run:

```bash
docker-compose up --build -d
```

or

```bash
make app
```

- To stop the app, run:

```bash
docker-compose down
```

or

```bash
make app-down
```

### PHP CS Fixer

The project uses PHP CS Fixer for maintaining coding standards. To fix the code, run:

```bash
make app-php-cs-fixer
```

This will automatically format the code according to PHP standards.

### Makefile

You can use the `Makefile` to manage common tasks such as:

- `app`: Build and start the Docker containers.
- `app-down`: Stop the Docker containers.
- `app-php-cs-fixer`: Target automatically formats PHP code in the src directory according to predefined coding standards using PHP CS Fixer inside a Docker container.

### TODO

The project’s to-do list is in the `TODO.md` file. You can check it for ongoing tasks and feature improvements.
