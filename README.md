# To-Do App - Laravel 11

## Wymagania

- Docker & Docker Compose
- PHP 8.2+

## Instalacja i konfiguracja

### 1. Klonowanie repozytorium

```sh
git clone https://github.com/kxmyk/todo-app.git
cd todo-app
```

### 2. Konfiguracja plików

Skopiuj plik konfiguracyjny:

```sh
cp .env.example .env
```

Edytuj `.env` i uzupełnij wymagane dane (wygwiazdkowane)

Generowanie klucza aplikacji:

```sh
php artisan key:generate
```

### 3. Uruchomienie aplikacji

```sh
docker-compose up -d --build
```

### 4. Migracja bazy danych i seedowanie

```sh
docker-compose exec app php artisan migrate --seed
```

### 5. Dostęp do aplikacji

- `http://localhost`

## Funkcjonalności

- Pełna obsługa REST API
- Obsługa kolejek za pomocą Laravel Queue
- Harmonogram zadań Laravel Scheduler
- Docker + Nginx + MySQL 8
- Notyfikacje email

## Struktura repozytorium

- `app/` - Logika aplikacji
- `config/` - Pliki konfiguracyjne
- `database/` - Migracje i seedery
- `nginx/` - Konfiguracja serwera Nginx
- `docker-compose.yml` - Definicja usług Dockera

## Autor

Kamil Łukasiuk

