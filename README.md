# Időjárás Monitorozó Alkalmazás

Ez egy Laravel alapú alkalmazás, amely városok időjárási adatait gyűjti és jeleníti meg.

## Funkciók
- Városok kezelése (Hozzáadás/Törlés)
- Automatikus adatfrissítés óránként (Open-Meteo API)
- Grafikonos megjelenítés (Chart.js)
- API végpont: `/api/weather/{id}`

## Telepítés
1. `git clone [link]`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. Adatbázis adatok beállítása az `.env` fájlban.
6. `php artisan migrate`