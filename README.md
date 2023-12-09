

#  Traffic Monitoring Project

This challenge involves creating a simple yet efficient Laravel application to track user interactions through an API. The project consists of two primary components:
1. API Endpoints: To track user visits and update their interaction.
2. API Endpoints: Get Interaction Statistics 

## Dependencies

- PHP: ^8.1
- Laravel: ^9.19

## Setup

Clone the project from the repository main branch and run the following commands:

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy the environment file
cp .env.example .env

# Generate the application key
php artisan key:generate

# API Keys Setup (Add this line to your .env file)
echo "API_KEY=your-api-key" >> .env

# Running Project
# Run database migrations
php artisan:migrate

# Start the development server
php artisan:serve

## API Reference

## Authentication

### Login
- **Endpoint:** `POST /auth/login`
- **Description:** Authenticate a user.
- **Request:**
    - Body:
        - `email` (string, required): User's email.
        - `password` (string, required): User's password.
- **Response:**
    - `token` (string): Authentication token.

### Signup
- **Endpoint:** `POST /auth/signup`
- **Description:** Register a new user.
- **Request:**
    - Body:
        - `name` (string, not required): User's name.
        - `email` (string, required): User's email.
        - `password` (string, required): User's password.
- **Response:**
    - `token` (string): Authentication token.
    -  `user` (JSON): Authentication token.

## Interactions

### List All Interactions
- **Endpoint:** `GET /user/interactions`
- **Description:** Get a list of all interactions for the authenticated user.
- **Authentication:** Bearer Token

### Create a New Interaction
- **Endpoint:** `POST /user/interactions`
- **Description:** Create a new interaction.
- **Request:**
    - Body:
        - `name` (string, required): Interaction name.
        - `label` (string, required): Interaction label.
        - Additional interaction details.
- **Authentication:** Bearer Token

### Update an Interaction
- **Endpoint:** `PUT /user/interactions/{id}`
- **Description:** Update an existing interaction.
- **Request:**
    - Body:
        - `name` (string, required): Updated interaction name.
        - `label` (string, required): Updated interaction label.
- **Authentication:** Bearer Token

### Delete an Interaction
- **Endpoint:** `DELETE /user/interactions/{id}`
- **Description:** Delete an existing interaction.
- **Authentication:** Bearer Token

### Simulate Event
- **Endpoint:** `POST /user/interactions/{interaction}/events`
- **Description:** Simulate an event for a specific interaction.
- **Request:**
    - Body:
        - `event_type` (string, required): Type of the event.
- **Authentication:** Bearer Token

### Get Interaction Statistics
- **Endpoint:** `GET /user/interactions/{interaction}/statistics`
- **Description:** Get statistics for a specific interaction.
- **Query Parameters:**
    - `start_date` (string, optional): Start date for filtering statistics.
    - `end_date` (string, optional): End date for filtering statistics.
- **Authentication:** Bearer Token
