# PHP API Template

A lightweight and flexible PHP API framework template designed for rapid API development. This template offers a modular structure, easy routing, and simple configuration.

## Features

- **Modular Architecture**: Organize your application with a clear and maintainable structure.
- **Flexible Routing**: Define and manage routes with ease.
- **Simple Configuration**: Out-of-the-box configuration for quick setup.

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/php-api-template.git
   
2.	Navigate to the project directory:
  ```bash
    cd php-api-template
  ```
3. Install dependencies using Composer:
  ```bash
    composer install
  ```
4. Run the PHP built-in server:
  ```bash
    composer start
  ```
Access the application at http://localhost:8080.

Usage

Routing

Define your API routes in the src/Http/Routers/ApiRouter.php file. Use the Router class to set up routes and handle requests.

Database Configuration

Configure your database settings directly in the application code or use a configuration file as needed.

API Validation

Use the Http/Validators directory to create validation classes for your API requests.

Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.
