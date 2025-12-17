# Laravel Module Generator

Laravel package for generating a complete modular architecture using **Service & Repository pattern**.  
It creates a ready-to-use module structure with Controllers, Models, Requests, Resources, Services, Repositories, Policies, Providers, and Routes.

---

## Features

- Generates a full module structure with all necessary folders and files.
- Implements **Service & Repository pattern** for clean separation of business logic.
- Automatically creates:
  - Controllers
  - Models
  - Requests (Store & Update)
  - Resources
  - Services
  - Repositories (with Interfaces)
  - Policies
  - Providers (AppServiceProvider & PolicyServiceProvider)
- Generates a `Routes` folder with `web.php` automatically if it does not exist.
- Ready-to-use **Resource classes** for API responses.
- Easy to modify or extend generated files.
- Supports **Blade** and **Inertia.js** views.
- Optional **Policy setup** for authorization.

---

## Installation

Add the repository to your `composer.json`:

```bash
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/blendibajrami/laravel-module-generator.git"
    }
],
"minimum-stability": "dev",
"prefer-stable": true
```

Then require the package via composer:

```bash
composer require modular/laravel-module-generator:dev-main
```

Usage

Generate a complete module structure with a single command:

```bash
php artisan make:module-model {ModuleName} {ModelName}
```

Example:

```bash
php artisan make:module-model Blog Post
```

This will generate the following folder structure:

```bash
Modules/
└── Blog/
    ├── Http/
    │   ├── Controllers/
    │   │   └── PostController.php
    │   ├── Requests/
    │   │   ├── StorePostRequest.php
    │   │   └── UpdatePostRequest.php
    │   └── Resources/
    │       └── PostResource.php
    ├── Models/
    │   └── Post.php
    ├── Policies/
    │   └── PostPolicy.php
    ├── Providers/
    │   ├── AppServiceProvider.php
    │   └── PolicyServiceProvider.php
    ├── Repositories/
    │   ├── PostRepository.php
    │   └── Contracts/
    │       └── PostRepositoryInterface.php
    ├── Services/
    │   └── PostService.php
    └── Routes/
        └── web.php

```
Advantages

-Provides ready-to-use code following Laravel conventions.

-Encourages modular development for better maintainability and scalability.

-Clean separation of concerns via Service & Repository pattern.

-All generated files are editable and extendable.

-Saves development time by automating repetitive tasks.


Customizing Stubs

All generated code is based on stub files.
You can modify the stub files in Modules/ModuleGenerator/Stubs/ to adjust the generated code to your project conventions or add new features.

Contributing

Feel free to open issues or submit pull requests. Contributions are welcome to improve the generator, add new stubs, or enhance compatibility with the latest Laravel versions.
