# Laravel API Generator - O'rnatish bo'yicha qo'llanma

## Mahalliy Development uchun

### 1. Package'ni mahalliy ravishda test qilish

Package'ni mahalliy loyihangizda test qilish uchun composer.json fayliga quyidagini qo'shing:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../laravel-api-generator"
        }
    ],
    "require": {
        "uzinfo/laravel-api-generator": "dev-master"
    }
}
```

Keyin o'rnating:

```bash
composer require uzinfo/laravel-api-generator:@dev
```

### 2. Stub fayllarni publish qiling

```bash
php artisan vendor:publish --tag=api-generator-stubs
```

### 3. Package commandlarini tekshiring

```bash
php artisan list make
```

## Production uchun

### Packagist ga publish qilish

1. **GitHub repository yarating**
2. **Composer.json ni to'g'rilang**
3. **Packagist.org da ro'yxatdan o'ting**
4. **Repository'ni Packagist ga qo'shing**

### GitHub repository yaratish

```bash
git add .
git commit -m "Initial commit: Laravel API Generator v1.0.0"
git branch -M main
git remote add origin https://github.com/uzinfo/laravel-api-generator.git
git push -u origin main
```

### Versioning

Semantic versioning ishlatamiz:

- **1.0.0** - Major release
- **1.1.0** - Minor release (yangi feature)
- **1.0.1** - Patch release (bug fix)

### Composer o'rnatish (Production)

Package Packagist ga publish qilingandan keyin:

```bash
composer require uzinfo/laravel-api-generator
```

## Troubleshooting

### Umumiy muammolar

1. **Command topilmaydi**
   - Service provider ro'yxatdan o'tganini tekshiring
   - `composer dump-autoload` ishga tushiring

2. **Stub fayllar topilmaydi**
   - Stub fayllarni publish qilganingizni tekshiring
   - `vendor:publish` buyrug'ini qayta ishga tushiring

3. **Namespace xatolari**
   - Composer autoload ni yangilang
   - `composer dump-autoload` ishga tushiring

### Debug mode

Development vaqtida xatoliklarni ko'rish uchun:

```bash
php artisan --verbose make:bread TestModel
```
