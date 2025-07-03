# Packagist.org Setup Guide

## 1. Packagist.org account yarating

1. https://packagist.org ga kiring
2. "Sign up" tugmasini bosing
3. GitHub account bilan login qiling (yoki email bilan ro'yxatdan o'ting)
4. Email tasdiqini bajaring

## 2. Package submit qiling

1. Packagist.org ga login qiling
2. "Submit" tugmasini bosing (https://packagist.org/packages/submit)
3. Repository URL'ni kiriting:
   ```
   https://github.com/YOUR_USERNAME/laravel-api-generator
   ```
4. "Check" tugmasini bosing
5. Packagist composer.json'ni tekshiradi va package ma'lumotlarini ko'rsatadi
6. "Submit" tugmasini bosing

## 3. Auto-update sozlash

Package'ni har safar yangilanishda avtomatik yangilanishi uchun:

### GitHub Webhook (Tavsiya etiladi)

1. GitHub repository'ga kiring
2. Settings > Webhooks > Add webhook
3. Payload URL: `https://packagist.org/api/github?username=YOUR_PACKAGIST_USERNAME`
4. Content type: `application/json`
5. Secret: Packagist profilingizdan "API Token" oling
6. Events: "Just the push event"
7. "Add webhook" tugmasini bosing

### Manual yoki API orqali

Yoki har safar qo'lda yangilash:
1. Packagist'dagi package sahifangizga kiring
2. "Update" tugmasini bosing

## 4. Package verification

Package submit qilingandan keyin:

1. Package sahifasi: `https://packagist.org/packages/uzinfo/laravel-api-generator`
2. Downloads statistikasi
3. Dependents ro'yxati
4. GitHub integration holati

## 5. Package install test qiling

Boshqa loyihada test qiling:

```bash
composer require uzinfo/laravel-api-generator
```

## 6. Package badges (README uchun)

README.md'ga qo'shish uchun badges:

```markdown
[![Latest Version](https://img.shields.io/packagist/v/uzinfo/laravel-api-generator.svg?style=flat-square)](https://packagist.org/packages/uzinfo/laravel-api-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/uzinfo/laravel-api-generator.svg?style=flat-square)](https://packagist.org/packages/uzinfo/laravel-api-generator)
[![License](https://img.shields.io/packagist/l/uzinfo/laravel-api-generator.svg?style=flat-square)](https://packagist.org/packages/uzinfo/laravel-api-generator)
```

## 7. Troubleshooting

### Umumiy muammolar:

1. **Package topilmaydi**
   - Repository public ekanligini tekshiring
   - composer.json valid ekanligini tekshiring
   - GitHub'da tag mavjudligini tekshiring

2. **Composer.json xatolari**
   - `composer validate` ishga tushiring
   - Required fieldlar to'liq ekanligini tekshiring

3. **Auto-update ishlamaydi**
   - Webhook to'g'ri sozlanganini tekshiring
   - API token to'g'riligini tekshiring

## 8. Versioning best practices

Yangi version chiqarishda:

```bash
# Code o'zgartirishlar
git add .
git commit -m "Add new feature"

# Version tag
git tag -a v1.1.0 -m "Release version 1.1.0"
git push origin main
git push origin v1.1.0
```

CHANGELOG.md'ni ham yangilashni unutmang!
