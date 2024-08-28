### Tạo file .env
```bash
cp .env.example .env
```
### Gen key
```bash
php artisan key:generate

php artisan config:cache
```

### Migarete database

```bash
php artisan migrate
```


### Seeder database
```bash
php artisan db:seed
```

### Run website dev
```bash
php artisan server
```