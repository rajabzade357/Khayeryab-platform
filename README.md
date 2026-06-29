#  Khayeryab-platform
A donation facilitation platform connecting donors with charities

## 📌 About the Project

Kheiryab is a web-based platform designed to bridge the gap between donors and verified charities. Charities register with official documentation, undergo admin approval, and are then publicly listed. Donors can browse approved charities, view their needs, and submit donations of surplus items. Each donation passes through a structured workflow — from submission and charity review to delivery confirmation — ensuring transparency and accountability throughout the process.

The system features a professional admin panel with full oversight: approve or reject charity registrations, manage users, record donor violations, view comprehensive statistics and charts, and configure platform settings. Built with Laravel 11 and a clean, responsive Tailwind CSS interface, Kheiryab delivers a practical and scalable solution for facilitating charitable giving in a structured, trustworthy environment.

## ✨ Key Features

- **Dual Registration:** Separate registration flows for donors and charities
- **Admin Approval:** Charity documents reviewed before public listing
- **Donation Submission:** Donors submit items with title, description, category, delivery method and date
- **Donation Workflow:** Charities approve/reject donations, track delivery status, and record reasons
- **Violation System:** Automatic violation points when donors fail to deliver, with admin override
- **Preferred Items:** Charities list needed items with priority levels
- **Password Recovery:** Password reset via mobile number verification
- **Professional Admin Panel:** Dashboard with statistics, charts, user management, violation recording, and settings
- **FAQs Page:** Tabbed FAQ section for both donors and charities
- **Responsive UI:** Tailwind CSS with RTL Persian support, sidebar navigation, and gradient design

## 🛠 Tech Stack

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** Blade, Tailwind CSS, Chart.js, Font Awesome 6
- **Database:** MySQL / MariaDB
- **Authentication:** Laravel Breeze (customized for mobile login)


## 👥 User Roles

| Role | Capabilities |
|------|-------------|
| **Donor** | Register, verify mobile number, browse approved charities, submit donations, track donation status, view violation points, edit profile, change mobile number |
| **Charity** | Register with official documents, await admin approval, view received donations, approve/reject/mark delivery status, manage preferred items, edit profile with logo, auto-suspend on sensitive data changes |
| **Admin** | Hidden login route, full dashboard with stats & charts, approve/reject charities, activate/deactivate users, record manual violations, view all donations, manage admins |

## 📊 Core database tables

6 main tables with Eloquent relationships:

| Table | Description |
|-------|-------------|
| `users` | Central user entity with role-based access (donor, charity, admin) |
| `charities` | Charity profile with registration documents, approval status |
| `donations` | Donation records with workflow status and delivery tracking |
| `preferred_items` | Charity-requested items with priority levels |
| `phone_verifications` | Independent OTP codes linked via session |
| `violations` | OTP codes stored temporarily for mobile verification (simulated in dev, ready for real SMS) |


## 🚀 Installation

```bash
git clone https://github.com/rajabzade357/khayeryab-platform.git
cd khayeryab-platform
composer install
cp .env.example .env
npm install
npm run build
php artisan key:generate
# Configure your database credentials in the .env file
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## 📁 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/             
│   │   ├── Auth/              
│   └── Middleware/
│       └── AdminMiddleware.php
│
├── Models/
│
resources/
├── views/
│   ├── admin/
│   ├── auth/
│   ├── charity/
│   ├── donor/
│   └── public/
│
routes/
├── web.php
└── auth.php
|
database/
├── migrations/
├── seeders/
└── factories/