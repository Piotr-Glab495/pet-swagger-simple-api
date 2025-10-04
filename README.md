# Pet Swagger API Client (Symfony + SvelteKit)

This project is a simple full-stack application that integrates with the [**Swagger Petstore API**](https://petstore.swagger.io/) to let user manage /pet data. What's more important, is that it **demonstrates how to design a modern web application** with a clear separation between frontend, backend, and DTO-based data flow.

Of course, this task could have been solved much more simply – e.g. a single-page frontend fetching data directly from Swagger Petstore, or a minimal PHP script proxying requests.  
However, I intentionally chose a more **“over-engineered” architecture** to demonstrate best practices that I would apply in a production project:
- clear separation of responsibilities between frontend, backend, and service layers
- using **DTOs** for type safety and clean data flow
- leveraging modern frameworks (**Symfony 6**, **SvelteKit**) instead of minimal scripts
- following real-world workflows (serialization, error handling, typed APIs, CI-friendly setup)

The result is not just a working demo, but also a showcase of how I think about **maintainability, scalability, and clean design**.

## 🔧 Technologies

- **Backend:**  
  - [Symfony 7](https://symfony.com/) – chosen for its clean architecture, routing, dependency injection, and ecosystem support.  
  - **GuzzleHTTP** – HTTP client for consuming external APIs (Petstore). I configured it with base URI, timeouts, and proper exception handling.
  - **DTO (Data Transfer Objects)** – I use strongly typed DTOs to keep controllers slim, ensure data integrity, and avoid leaking raw arrays across layers. DTOs are serialized/deserialized consistently.
  - **PHP 8.2** – modern features like readonly classes for DTOs, symfony attributes (`#[Route]`), closures, nullsafe operator etc. are used throughout.

- **Frontend:**  
  - [SvelteKit](https://kit.svelte.dev/) – chosen because of its reactivity model and simplicity compared to React. It provides fast builds and a very concise component syntax. It has minimal configuration. Maybe **Vue.js** would be even more natural choice (especially with Laravel instead of Symfony), but for me Svelte gives clearer code in small projects and it was all about creating a readable POC fast. So this time svelte.
  - **TypeScript** – for type safety and consistency between frontend models and backend DTOs.
  - **Fetch API** – used for communication with the Symfony backend endpoints (`/api/pets`, `/api/pet/{id}`, etc.).

## ⚙️ Architecture

1. **Frontend (SvelteKit)** sends requests to **Symfony API**.  
2. **Symfony Controller** receives the request, constructs DTOs, and delegates logic to a service.
3. **Service layer** uses Guzzle to call the external Petstore API, converts raw JSON to DTOs, and returns strongly typed objects.  
4. **Controller** serializes DTOs back to JSON, which the frontend consumes.  

This pattern ensures:
- Controllers remain very thin.  
- External API quirks are isolated in a single service.
- Strong typing and DTOs guarantee consistency.  

## ▶️ How to run locally

### Prerequisites
- **PHP 8.2+** (with `ext-json`, `ext-curl`)  
- **Composer**
- **Symfony CLI** (for `symfony serve`)  
- **Node.js 24** with npm 
- **Git**
- (Windows only) configure `php.ini`:
  ```ini
  curl.cainfo="C:\path\to\cacert.pem"

### Setup

```bash
# Clone repository
git clone https://github.com/Piotr-Glab495/pet-swagger-simple-api.git
cd pet-swagger-simple-api

# Install backend dependencies
cd backend
composer install

# Run Symfony server
symfony serve -d
# Symfony will run at http://127.0.0.1:8000

# Install frontend dependencies
cd ../frontend
npm install

# Run SvelteKit dev server
npm run dev
# Frontend available at http://localhost:5173