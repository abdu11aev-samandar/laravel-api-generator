# Migration Field Examples

Bu hujjat migration va model yaratishda field definition'larni qanday ishlatishni ko'rsatadi.

## Field Definition Format

```
field_name:field_type:modifier1:modifier2
```

## Supported Field Types

### String Fields
```bash
# Basic string (default 255 characters)
name:string

# String with custom length
title:string:100

# Text field
description:text

# Long text
content:longText
```

### Numeric Fields
```bash
# Integer
age:integer

# Big integer
user_id:bigInteger

# Decimal with precision
price:decimal:10,2

# Float
rating:float

# Double
distance:double
```

### Date/Time Fields
```bash
# Timestamp
created_at:timestamp

# Date
birth_date:date

# Time
start_time:time

# DateTime
published_at:dateTime
```

### Boolean Fields
```bash
# Boolean
is_active:boolean

# Boolean with default
is_verified:boolean:default:false
```

### Special Fields
```bash
# JSON
metadata:json

# UUID
uuid:uuid

# Email (string with validation in request)
email:string

# Password (string with hidden in resource)
password:string
```

## Field Modifiers

### Nullable
```bash
phone:string:nullable
middle_name:string:nullable
```

### Unique
```bash
email:string:unique
username:string:unique
```

### Index
```bash
category_id:bigInteger:index
status:string:index
```

### Default Values
```bash
# String default
status:string:default:pending

# Boolean default
is_active:boolean:default:true

# Integer default
priority:integer:default:1

# Null default
notes:text:nullable:default
```

### Combined Modifiers
```bash
# Email: string, unique, not nullable
email:string:unique

# Phone: string, nullable, with index
phone:string:nullable:index

# Status: string with default and index
status:string:default:active:index

# Price: decimal with precision and default
price:decimal:10,2:default:0.00
```

## Real-world Examples

### User Model
```bash
php artisan make:bread User --fields="name:string,email:string:unique,phone:string:nullable,password:string,is_active:boolean:default:true,email_verified_at:timestamp:nullable"
```

### Product Model
```bash
php artisan make:bread Product --fields="name:string,slug:string:unique,description:text:nullable,price:decimal:10,2,stock:integer:default:0,is_featured:boolean:default:false,category_id:bigInteger:index"
```

### Post Model
```bash
php artisan make:bread Post --fields="title:string,slug:string:unique,content:longText,excerpt:text:nullable,featured_image:string:nullable,is_published:boolean:default:false,published_at:timestamp:nullable,author_id:bigInteger:index"
```

### Order Model
```bash
php artisan make:bread Order --fields="order_number:string:unique,total_amount:decimal:10,2,status:string:default:pending:index,customer_id:bigInteger:index,notes:text:nullable"
```

## Generated Migration Example

Quyidagi command:
```bash
php artisan make:migration-api create_products_table --fields="name:string,price:decimal:10,2,is_active:boolean:default:true"
```

Quyidagi migration yaratadi:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

## Generated Model Example

Quyidagi command:
```bash
php artisan make:model-api Product --fillable="name,price,is_active" --casts="price:decimal:2,is_active:boolean"
```

Quyidagi model yaratadi:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'is_active'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Add your model relationships, scopes, and custom methods here
}
```
