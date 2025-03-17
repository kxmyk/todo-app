# Podsumowanie projektu To-Do List

## Wprowadzenie
Projekt To-Do List został stworzony jako aplikacja do zarządzania zadaniami użytkowników. Głównym celem było zapewnienie funkcjonalności CRUD, uwierzytelniania użytkowników, filtrowania zadań oraz mechanizmu powiadomień e-mail. Dodatkowo, projekt miał zostać dostarczony w kontenerach Docker, co ułatwia jego wdrożenie i uruchomienie.

Mimo ograniczonego czasu udało się zaimplementować większość kluczowych funkcji, jednak kilka aspektów mogłoby zostać wykonanych lepiej lub wymaga dodatkowego rozwoju.

## Zrealizowane funkcje

### 1. **Konfiguracja w Dockerze**
- Stworzono Dockerfile i docker-compose.yml umożliwiające szybkie uruchomienie projektu.
- Instalacja zależności Composer i generowanie klucza aplikacji odbywa się automatycznie przy budowie obrazu.
- Uruchomienie bazy danych MySQL oraz kolejek Laravel w środowisku Docker.

### 2. **CRUD dla zadań**
- Możliwość tworzenia, edytowania, usuwania oraz przeglądania zadań.
- Zadania posiadają pola:
  - Nazwa (wymagana, max 255 znaków)
  - Opis (opcjonalne)
  - Priorytet (low, medium, high)
  - Status (to-do, in progress, done)
  - Termin wykonania (wymagane)

### 3. **Filtrowanie zadań**
- Filtrowanie według priorytetu, statusu i terminu wykonania.
- Dynamiczne odświeżanie listy zadań bez przeładowania strony.

### 4. **Powiadomienia e-mail**
- Mechanizm powiadomień e-mail przypominających o zbliżającym się terminie zadania (1 dzień wcześniej).
- Wykorzystanie Laravel Queues oraz Scheduler do asynchronicznego wysyłania powiadomień.

### 5. **Walidacja danych**
- Pełna walidacja danych w formularzach, zapewniająca poprawne wprowadzanie informacji.
- Obsługa błędów walidacji i informowanie użytkownika o problemach z danymi.

### 6. **Obsługa wielu użytkowników**
- Każdy użytkownik może zarządzać swoimi zadaniami po zalogowaniu się.
- Wykorzystano Laravel Sanctum do uwierzytelniania użytkowników.

### 7. **Udostępnianie zadań przez link z tokenem**
- Możliwość wygenerowania linku publicznego do konkretnego zadania.
- Link zawiera token dostępu, który wygasa po określonym czasie.
- Pozwala na wyświetlenie szczegółów zadania bez logowania.

---

## Funkcjonalności, które nie zostały ukończone

### 1. **Pełna historia edycji zadań**
- Planowano zapisywanie każdej zmiany wprowadzanej w zadaniu (np. zmiana nazwy, priorytetu, statusu itp.).
- Wymagałoby to stworzenia osobnej tabeli w bazie danych oraz mechanizmu logowania zmian.

### 2. **Integracja z Google Calendar**
- Miał zostać dodany mechanizm przypinania zadań do kalendarza Google za pomocą biblioteki `spatie/laravel-google-calendar`.
- Integracja ta wymaga dodatkowej konfiguracji OAuth oraz autoryzacji użytkowników w Google.

---

## Przemyślenia i wnioski
Projekt udało się zrealizować w dużym zakresie, choć istnieją obszary, które mogłyby być wykonane lepiej lub bardziej optymalnie.

**Co mogłoby być lepsze:**
- **Optymalizacja zapytań do bazy danych** – w niektórych miejscach można by było zastosować lepsze indeksowanie czy lazy loading.
- **Poprawienie UX/UI** – interfejs użytkownika mógłby zostać bardziej dopracowany, np. dynamiczne animacje czy lepsze powiadomienia o błędach.

Niestety ograniczenia czasowe nie pozwoliły na dopracowanie wszystkich aspektów projektu, jednak udało się dostarczyć w pełni funkcjonalną aplikację, którą można w przyszłości rozwijać o dodatkowe funkcjonalności.

---

## Podsumowanie
Projekt To-Do List spełnia swoje podstawowe założenia, oferując użytkownikom możliwość zarządzania zadaniami w sposób intuicyjny i efektywny. Udało się zrealizować większość wymagań, a brakujące funkcje mogą zostać dodane w przyszłości. Pomimo pewnych niedociągnięć wynikających z ograniczonego czasu, aplikacja stanowi solidną podstawę do dalszego rozwoju i może być z powodzeniem używana przez użytkowników.

