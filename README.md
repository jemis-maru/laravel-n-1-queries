# Laravel N+1 Query Problem Demo

Simple demo showing how to:
✅ Profile a Laravel app using Laravel Telescope  
✅ Identify and fix N+1 queries

## Install & Enable Laravel Telescope

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Then start the server:

```bash
php artisan serve
```

Visit:  
👉 http://127.0.0.1:8000/telescope

You'll see Telescope's dashboard showing queries, requests, exceptions, etc.

---

## Create a Demo with an N+1 Problem

### Create Models and Relationships:

```bash
php artisan make:model User -m
php artisan make:model Post -m
```

Update migration file same as this: `2025_10_19_101815_create_users_table.php`  
and `2025_10_19_101854_create_posts_table.php`

Run migrations:

```bash
php artisan migrate
```

### Add Relationships in Models

**app/Models/User.php**

```php
public function posts()
{
    return $this->hasMany(Post::class);
}
```

**app/Models/Post.php**

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

### Create factory files to seed fake data in database:

- `PostFactory.php`
- `UserFactory.php`

Use tinker to run seed data:

```bash
php artisan tinker
User::factory()->hasPosts(5)->count(3)->create();
exit
```

---

## Create Controller with N+1 Problem

```bash
php artisan make:controller PostController
```

**app/Http/Controllers/PostController.php**

```php
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // ❌ N+1 Query Problem
        $posts = Post::all(); // no eager load
        foreach ($posts as $post) {
            $post->user->name; // triggers a query for each post
        }

        return view('posts.index', compact('posts'));
    }
}
```

**routes/web.php**

```php
Route::get('/posts', [PostController::class, 'index']);
```

And also create `resources/views/posts/index.blade.php` to display posts

### Test the N+1 Problem

Now visit:  
http://127.0.0.1:8000/posts

And then observe:  
http://127.0.0.1:8000/telescope/queries

Below queries will be visible:

```
select * from `users` where `users`.`id` = 3 limit 1	0.16ms	6m ago	
select * from `users` where `users`.`id` = 3 limit 1	0.17ms	6m ago	
select * from `users` where `users`.`id` = 3 limit 1	0.18ms	6m ago	
select * from `users` where `users`.`id` = 3 limit 1	0.17ms	6m ago	
select * from `users` where `users`.`id` = 3 limit 1	0.16ms	6m ago	
select * from `users` where `users`.`id` = 2 limit 1	0.18ms	6m ago	
select * from `users` where `users`.`id` = 2 limit 1	0.29ms	6m ago	
select * from `users` where `users`.`id` = 2 limit 1	0.20ms	6m ago	
select * from `users` where `users`.`id` = 2 limit 1	0.18ms	6m ago	
select * from `users` where `users`.`id` = 2 limit 1	0.21ms	6m ago	
select * from `users` where `users`.`id` = 1 limit 1	0.17ms	6m ago	
select * from `users` where `users`.`id` = 1 limit 1	0.18ms	6m ago	
select * from `users` where `users`.`id` = 1 limit 1	0.25ms	6m ago	
select * from `users` where `users`.`id` = 1 limit 1	0.31ms	6m ago	
select * from `users` where `users`.`id` = 1 limit 1	0.60ms	6m ago	
select * from `posts`
```

**That's your N+1 problem!**

---

## Fix It Using Eager Loading

Update your controller:

```php
public function index()
{
    // ✅ Fixed using eager loading
    $posts = Post::with('user')->get();

    foreach ($posts as $post) {
        $post->user->name; // No additional query now
    }

    return view('posts.index', compact('posts'));
}
```

Now visit again:  
http://127.0.0.1:8000/posts

And then observe:  
http://127.0.0.1:8000/telescope/queries

Below queries will be visible:

```
select * from `users` where `users`.`id` in (1, 2, 3)	0.38ms	7m ago	
select * from `posts`
```

**Problem fixed 🎯**
