# Online Library

## Setup Instructions

### Prerequisites

Before you begin, ensure you have the following installed on your machine:
- PHP >= 8.0
- Composer
- MySQL
- Redis
- Node.js & npm
- Git

### Clone the Repository

```bash
git clone https://github.com/radosevic-dr/online_library.git
cd online_library
```

## Checkout Development Branch

Make sure you are working on the development branch:

```bash
git checkout development
```

## Install Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

## Enviroment Variables

Copy the template environment file .env.example to .env:

```bash
cp .env.example .env
```

## Serve the Application

To start the development server, run:

```bash
php artisan serve
```

## Contribution Guidelines

### Branching Strategy

- **main**: This branch is protected and should only contain stable code. Changes to this branch require approval.
- **development**: This branch is used for developing new features and should contain all changes that are not yet ready for production.