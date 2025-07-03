# GitHub Repository Setup

## 1. GitHub'da repository yarating

1. GitHub.com ga kiring
2. "New repository" tugmasini bosing
3. Repository nomi: `laravel-api-generator`
4. Description: `Laravel API generator package for creating controllers, services, repositories, resources and requests`
5. Public repository qiling
6. README.md, .gitignore va LICENSE qo'shmaslik (bizda allaqachon bor)
7. "Create repository" tugmasini bosing

## 2. Remote repository qo'shing

Repository yaratgandan keyin GitHub sizga quyidagi commandlarni beradi:

```bash
git remote add origin https://github.com/YOUR_USERNAME/laravel-api-generator.git
git push -u origin main
```

Yoki SSH ishlatayotgan bo'lsangiz:

```bash
git remote add origin git@github.com:YOUR_USERNAME/laravel-api-generator.git
git push -u origin main
```

## 3. Tag yarating (version uchun)

```bash
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

## 4. Repository sozlamalari

Repository yaratgandan keyin GitHub'da:

1. **About** bo'limida:
   - Description: `Laravel API generator package for creating controllers, services, repositories, resources and requests`
   - Website: packagist sahifangiz (keyinroq)
   - Topics: `laravel`, `php`, `api`, `generator`, `artisan`, `package`

2. **Releases** bo'limida:
   - "Create a new release" tugmasini bosing
   - Tag: `v1.0.0`
   - Title: `Laravel API Generator v1.0.0`
   - Description'da CHANGELOG.md dan copy qiling

## 5. GitHub Personal Access Token (agar kerak bo'lsa)

Agar push qilishda authentication muammo bo'lsa:

1. GitHub Settings > Developer settings > Personal access tokens
2. "Generate new token" (classic)
3. Permissions: `repo`, `write:packages`
4. Token'ni saqlang va passwordga ishlatting

## Keyingi qadam: Packagist.org

Repository GitHub'ga yuklangandan keyin keyingi qadam - Packagist.org ga ro'yxatdan o'tish.
