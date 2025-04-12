# 🏆 Laravel Leaderboard System

This is a Laravel-based **Leaderboard System** to track and rank users based on physical activities. Each activity awards **+20 points**, and users are ranked according to total points. The leaderboard supports filters by day, month, and year, and includes search and recalculation functionalities.

---

## 📦 Features

- 📊 **Leaderboard with Rank** (based on total activity points)
- 🔍 **Search** by user ID (brings that user to the top)
- 📆 **Date Filters**: Day, Month, Year
- 🔁 **Recalculate** button (updates ranks + points)
- 💾 **Ranks stored in database**
- 🧮 No `GROUP BY` or `COUNT` used for ranking logic
- 🖥️ **Bootstrap Blade View** with jQuery DataTables

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-leaderboard.git
cd laravel-leaderboard
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Create .env and Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

# Then edit the .env file and set your local database credentials:
```bash
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Set File Permissions (Linux/Mac only)
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate --seed
```

### 6. Run the Local Development Server
```bash
php artisan serve
```

