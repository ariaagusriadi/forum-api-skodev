### Installation


```
composer install
```

```
php artisan key:generate
```

```
php artisan migrate:fresh
```

```
php artisan serve
```

### EndPoint API

#### AUTH
METHOD | ENDPOINT 
 ------------ | ------------- 
POST | api/auth/login 
POST | api/auth/logout 
POST | api/auth/me 
POST | api/auth/register 
POST | api/forums/{forum} 



#### FORUMS
METHOD | ENDPOINT 
 ------------ | ------------- 
GET HEAD | api/forums 
POST | api/forums 
GET HEAD | api/forums/tag/{tag} 
GET HEAD | api/forums/{forum} 
PUT PATCH | api/forums/{forum} 
DELETE | api/forums/{forum} 



#### COMMENTS
METHOD | ENDPOINT 
 ------------ | -------------  
POST | api/forums/{forum}/comments 
PUT PATCH | api/forums/{forum}/comments/{comment} 
DELETE | api/forums/{forum}/comments/{comment} 



#### FORUMS
METHOD | ENDPOINT 
 ------------ | ------------- 
GET HEAD | api/user/@{username}
GET HEAD | api/user/@{username}/activity

