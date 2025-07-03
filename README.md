# Laravel API Generator

Laravel API Generator - bu Laravel loyihalar uchun API komponentlarini tez va oson yaratish uchun mo'ljallangan package.

## 🚀 Xususiyatlar

- **Controllers** - API kontrollerlari yaratish
- **Services** - Biznes logika servislari
- **Repositories** - Ma'lumotlar bazasi bilan ishlash layerlari  
- **Resources** - API resurslari (bitta va collection)
- **Requests** - Form validatsiya klasslari
- **Traits** - ApiResponse va ApiRequest traitlari
- **BREAD** - To'liq CRUD operatsiyalari bir buyruq bilan

## 📦 O'rnatish

Composer orqali package'ni o'rnating:

```bash
composer require uzinfo/laravel-api-generator
```

Stub fayllarni publish qiling:

```bash
php artisan vendor:publish --tag=api-generator-stubs
```

## 🛠️ Foydalanish

### Ayrim komponentlar yaratish

```bash
# Controller yaratish
php artisan make:controller-api UserController

# Service yaratish  
php artisan make:service-api UserService

# Repository yaratish
php artisan make:repository-api UserRepository

# Resource yaratish
php artisan make:resource-api UserResource

# Resource Collection yaratish
php artisan make:resource-list-api UserResourceList

# Request yaratish
php artisan make:request-api StoreUserRequest
```

### To'liq CRUD yaratish

```bash
# Barcha kerakli fayllarni bir buyruq bilan yaratish
php artisan make:bread User
```

Bu buyruq quyidagi fayllarni yaratadi:
- `app/Http/Controllers/UserController.php`
- `app/Services/UserService.php` 
- `app/Repositories/UserRepository.php`
- `app/Http/Resources/User/UserResource.php`
- `app/Http/Resources/User/UserResourceList.php`
- `app/Http/Requests/User/StoreUserRequest.php`
- `app/Http/Requests/User/UpdateUserRequest.php`

## 📁 Yaratilgan fayllar strukturasi

```
app/
├── Http/
│   ├── Controllers/
│   │   └── UserController.php
│   ├── Requests/
│   │   └── User/
│   │       ├── StoreUserRequest.php
│   │       └── UpdateUserRequest.php
│   └── Resources/
│       └── User/
│           ├── UserResource.php
│           └── UserResourceList.php
├── Repositories/
│   └── UserRepository.php
└── Services/
    └── UserService.php
```

## 🎯 Traitlar

Package quyidagi traitlarni taqdim etadi:

### ApiResponse Trait

```php
use UzInfo\LaravelApiGenerator\Traits\ApiResponse;

class UserController extends Controller 
{
    use ApiResponse;
    
    public function index() 
    {
        return $this->replySuccess('Users retrieved successfully', $users);
    }
}
```

**Mavjud metodlar:**
- `replySuccess($message, $data, $status)` - Muvaffaqiyatli javob
- `replyFailure($message, $data, $status)` - Xato javob  
- `replyPaginatedData($data, $paginator)` - Pagination bilan javob
- `replyUnpaginatedData($data)` - Oddiy array javob
- `replyWithMeta($message, $data, $meta, $status)` - Meta ma'lumotlar bilan
- `replyRaw($response, $status)` - Raw response

### ApiRequest Trait

```php
use UzInfo\LaravelApiGenerator\Traits\ApiRequest;

class StoreUserRequest extends FormRequest 
{
    use ApiRequest;
    
    protected $route_parameter = 'user';
    protected $route_params = ['company' => 'company_id'];
}
```

## 🔧 Konfiguratsiya

Stub fayllarni o'zgartirib, yaratilgan kodlarni loyihangizga moslashtira olasiz.

## 📝 Misol

User CRUD yaratish:

```bash
php artisan make:bread User
```

Yaratilgan controller:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceList;
use App\Services\UserService;
use UzInfo\LaravelApiGenerator\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected UserService $service
    ) {}

    public function index()
    {
        $items = $this->service->paginate();
        return $this->replyPaginatedData(
            UserResource::collection($items), 
            $items
        );
    }

    public function store(StoreUserRequest $request)
    {
        $item = $this->service->create($request->validated());
        return $this->replySuccess(
            'User created successfully',
            new UserResource($item)
        );
    }

    public function show(string $id)
    {
        $item = $this->service->getById($id);
        return $this->replySuccess(
            'User retrieved successfully',
            new UserResource($item)
        );
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $item = $this->service->update($id, $request->validated());
        return $this->replySuccess(
            'User updated successfully',
            new UserResource($item)
        );
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return $this->replySuccess('User deleted successfully');
    }
}
```

## 🤝 Hissa qo'shish

Loyihaga hissa qo'shish uchun:

1. Repository'ni fork qiling
2. Feature branch yarating (`git checkout -b feature/AmazingFeature`)
3. O'zgartirishlarni commit qiling (`git commit -m 'Add some AmazingFeature'`)
4. Branch'ga push qiling (`git push origin feature/AmazingFeature`)
5. Pull Request oching

## 📄 Litsenziya

Bu loyiha MIT litsenziyasi ostida chiqarilgan. Batafsil ma'lumot uchun `LICENSE` faylini ko'ring.

## 👥 Mualliflar

- **UzInfo Team** - [dev@uzinfo.uz](mailto:dev@uzinfo.uz)

## 🙏 Minnatdorchilik

Laravel jamoasiga ajoyib framework uchun rahmat!
