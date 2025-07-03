# Changelog

Laravel API Generator package uchun barcha muhim o'zgarishlar shu yerda qayd etiladi.

## [Unreleased]

## [1.1.0] - 2024-07-03

### Added
- `make:model-api` - Eloquent model yaratish
- `make:migration-api` - Database migration yaratish
- Model generator'da SoftDeletes qo'llab-quvvatlash
- Migration generator'da field definition parser
- BREAD command'ga model va migration integratsiya
- Advanced field type qo'llab-quvvatlash (string, integer, boolean, decimal, etc.)
- Field modifiers (nullable, unique, index, default values)
- Emoji-based progress indicators
- Detailed file generation summary

### Enhanced
- BREAD command yangilandi va model/migration qo'shildi
- --fields option barcha commandlarda
- --no-model va --no-migration options
- Service Provider'ga yangi commandlar qo'shildi

## [1.0.0] - 2024-07-03

### Added
- Laravel API komponentlarini yaratish uchun artisan commandlari
- `make:controller-api` - API controllerlari yaratish
- `make:service-api` - Service klasslari yaratish
- `make:repository-api` - Repository klasslari yaratish
- `make:resource-api` - API resource klasslari yaratish
- `make:resource-list-api` - Resource collection klasslari yaratish
- `make:request-api` - Form request klasslari yaratish
- `make:bread` - To'liq CRUD yaratish (barcha komponentlar bilan)
- `ApiResponse` trait - API javoblari uchun
- `ApiRequest` trait - Request parametrlarini boshqarish uchun
- Stub fayllar auto-publishing
- Service provider auto-discovery
- To'liq Laravel 10/11/12 qo'llab-quvvatlash
- PHP 8.2+ qo'llab-quvvatlash

### Features
- Repository pattern qo'llab-quvvatlash
- Service layer yaratish
- Standardlashgan API response struktura
- Pagination qo'llab-quvvatlash
- Route parameters bilan avtomatik ishlash
- Namespace avtomatik yaratish
- Kod generatsiya stub'lari
