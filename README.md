# 📰 News Portal Management System

A full-stack, database-driven **News Portal Management System** developed using **PHP, MySQL, JavaScript, Bootstrap, and jQuery**.

The platform provides a complete news publishing workflow with **role-based access control, admin management, reporter submissions, editor verification, automated news scheduling, publishing automation, category and location management, language conversion, API integration, dashboards, and member features**.

---

## 🚀 Project Overview

The News Portal is designed as a complete online news management platform where different users can perform different activities according to their assigned roles.

The system supports four major user roles:

* 👑 **Admin**
* ✍️ **Reporter**
* 📝 **Editor**
* 👤 **Member**

Each role has its own dashboard, permissions, and responsibilities.

The system follows a structured workflow:

```text
Reporter
   ↓
News Submission
   ↓
Editor Review
   ↓
Approval / Rejection
   ↓
Scheduling / Publishing
   ↓
Public News Portal
   ↓
Member Interaction
```

---

# ✨ Key Features

## 🔐 Role-Based Access Control (RBAC)

The application implements role-based permissions for different types of users.

### 👑 Admin

Admin has complete control over the platform.

Features include:

* Admin Dashboard
* User Management
* Reporter Management
* Editor Management
* Member Management
* Category Management
* Location Management
* News Management
* News Approval
* News Publishing
* Scheduled News Management
* Role Management
* User Verification
* Content Management
* System Monitoring

---

### ✍️ Reporter

Reporters are responsible for creating and submitting news.

Features include:

* Reporter Dashboard
* Add News
* Update News
* Delete News
* Upload News Images
* Select Category
* Select Location
* Submit News for Review
* View Submitted News
* Track News Status
* Manage Own News
* Schedule News where permitted

---

### 📝 Editor

Editors manage the content review and publishing workflow.

Features include:

* Editor Dashboard
* View Submitted News
* Review News
* Verify News
* Approve News
* Reject News
* Edit News
* Manage Published Content
* Manage Scheduled Content
* Content Quality Control

---

### 👤 Member

Members are regular users of the news platform.

Features include:

* Member Registration
* Login / Logout
* Browse News
* Search News
* Filter News
* View News Details
* Browse Categories
* Browse Locations
* Read Published News
* User Profile

---

# 🗞️ News Management System

The News Management module provides complete CRUD functionality.

### News Operations

* Create News
* Read News
* Update News
* Delete News
* Publish News
* Unpublish News
* Schedule News
* Search News
* Filter News
* Categorize News
* Assign Location
* Upload Images
* Manage News Status

Each news article can be associated with:

* Category
* Location
* Reporter
* Editor
* Publishing Status
* Scheduling Date & Time
* Creation Date
* Update Date

---

# ⏰ News Scheduling & Automated Publishing

One of the major features of the project is the **News Scheduling System**.

Instead of publishing an article immediately, authorized users can specify a future publishing date and time.

### Workflow

```text
Create News
     ↓
Set Schedule Date & Time
     ↓
Save Scheduled News
     ↓
Automated Scheduler
     ↓
Check Current Date & Time
     ↓
Scheduled Time Reached
     ↓
is_publish = 1
     ↓
News Becomes Published
```

Normal news remains unpublished until it is approved/published according to the configured workflow.

Scheduled news is automatically published when its scheduled date and time are reached.

---

# ⚙️ Automation System

The application includes automation-oriented functionality for scheduled content publishing.

The automation checks scheduled news records and identifies content whose scheduled publishing time has been reached.

Conceptually:

```sql
IF scheduled_time <= current_time
THEN
    is_publish = 1
END IF
```

This allows the portal to automatically publish scheduled articles without requiring the administrator to manually publish every article.

The scheduling mechanism can be implemented using server-side scheduled execution or a database scheduler depending on the deployment environment.

---

# 🌐 API Integration

The system is designed to support external API integration for extending portal functionality.

API-based functionality can be used for:

* External News Sources
* News Data
* Language Services
* Translation Services
* Third-Party Services
* External Content Integration

API credentials should be stored securely and should **never be committed directly to a public GitHub repository**.

Example configuration:

```php
$apiKey = getenv('API_KEY');
```

---

# 🌍 Language Converter / Translation

The portal can integrate a language conversion/translation service to make news content available in multiple languages.

Potential workflow:

```text
Original News
     ↓
Language Converter API
     ↓
Translated Content
     ↓
Preview / Review
     ↓
Publish
```

This functionality can help make news accessible to users from different language backgrounds.

> API provider and supported languages should be configured according to the translation service used by the deployment.

---

# 🔌 Plugins & External Services

The project architecture can be extended through third-party services and plugins.

Possible integrations include:

* Translation APIs
* News APIs
* Authentication Services
* Notification Services
* Analytics
* Rich Text Editors
* Image Processing
* Social Media Integration
* Email Services
* Scheduling Services

External services should be configured separately from the application source code.

---

# 📊 Dashboard System

Different dashboards are provided according to user roles.

## Admin Dashboard

Admin dashboard provides an overview of:

* Total Users
* Total Reporters
* Total Editors
* Total Members
* Total News
* Published News
* Pending News
* Scheduled News
* Categories
* Locations

---

## Reporter Dashboard

Reporter dashboard provides:

* Total Submitted News
* Pending News
* Approved News
* Rejected News
* Published News
* Scheduled News

---

## Editor Dashboard

Editor dashboard provides:

* Pending Reviews
* Approved News
* Rejected News
* Published News
* Scheduled News
* Content Management

---

## Member Dashboard

Member dashboard provides:

* Profile Information
* News Browsing
* Categories
* Locations
* Published Content

---

# 🗂️ Category Management

The administrator can manage news categories.

Supported operations:

* Add Category
* View Category
* Update Category
* Delete Category

Example categories:

```text
Politics
Technology
Business
Sports
Entertainment
Education
Health
World
India
Science
```

Categories are stored separately in the database and linked with news records using their IDs.

---

# 📍 Location Management

The system provides separate location management.

Operations include:

* Add Location
* View Location
* Update Location
* Delete Location

News articles can be associated with a specific location.

Example:

```text
India
Delhi
Mumbai
Hyderabad
Bhopal
Bangalore
International
```

---

# 🗄️ Database Architecture

The application uses **MySQL** as its relational database.

The database contains separate tables for different entities and relationships.

Example structure:

```text
users
  ├── Admin
  ├── Reporter
  ├── Editor
  └── Member

category
  ├── cid
  └── category_name

location
  ├── lid
  └── location_name

news
  ├── news_id
  ├── title
  ├── description
  ├── category_id
  ├── location_id
  ├── reporter_id
  ├── editor_id
  ├── is_publish
  └── schedule_date
```

Category and location information can be retrieved using relational database queries and JOIN operations rather than storing duplicate names inside the news table.

---

# 🔗 Database Relationships

Conceptual relationship:

```text
Users
  │
  ├── Reporter ──────┐
  │                  │
  ├── Editor ────────┤
  │                  ↓
  └── Admin       News
                    │
             ┌──────┴──────┐
             ↓             ↓
         Category       Location
```

This approach keeps the database normalized and easier to maintain.

---

# 🔑 Authentication & Session Management

The system uses session-based authentication.

Authentication features include:

* User Registration
* User Login
* Logout
* Session Management
* Role Verification
* Protected Dashboards
* Unauthorized Access Prevention

Users are redirected to the appropriate dashboard according to their assigned role.

Example:

```text
Admin    → Admin Dashboard
Reporter → Reporter Dashboard
Editor   → Editor Dashboard
Member   → Member Dashboard
```

---

# 🛡️ Security Features

The application follows basic web application security practices.

Security considerations include:

* Session-Based Authentication
* Role-Based Authorization
* Protected Dashboard Pages
* Input Validation
* Database Query Validation
* Password Protection
* Restricted Access to Admin Features
* Secure API Credential Handling
* File Upload Validation

For production deployment, additional security hardening should be applied, including prepared statements, CSRF protection, secure cookies, HTTPS, strict file-upload validation, and environment-based secrets.

---

# 🖥️ Frontend

The frontend is built using:

* HTML5
* CSS3
* JavaScript
* Bootstrap
* jQuery
* Font Awesome

The interface is designed to be responsive and usable across:

* Desktop
* Laptop
* Tablet
* Mobile

---

# ⚡ JavaScript & jQuery

JavaScript and jQuery are used for interactive functionality such as:

* Form Validation
* Dynamic UI
* AJAX Requests
* Modal Dialogs
* Dropdowns
* Search
* Dynamic Content
* Client-Side Interaction

Bootstrap components are used for responsive layouts and dashboard interfaces.

---

# 📁 Project Structure

A typical structure of the project:

```text
news-portal/
│
├── admin/
│   ├── dashboard.php
│   ├── manage_users.php
│   ├── manage_category.php
│   ├── manage_location.php
│   └── manage_news.php
│
├── reporter/
│   ├── dashboard.php
│   ├── add_news.php
│   ├── update_news.php
│   └── my_news.php
│
├── editor/
│   ├── dashboard.php
│   ├── review_news.php
│   └── manage_news.php
│
├── member/
│   ├── dashboard.php
│   └── profile.php
│
├── includes/
│   ├── config.php
│   ├── database.php
│   └── functions.php
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── plugins/
│
├── uploads/
│
├── database/
│   └── news.sql
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── news.php
└── README.md
```

> The exact structure may vary depending on the current project implementation.

---

# 🛠️ Technologies Used

| Technology             | Purpose                      |
| ---------------------- | ---------------------------- |
| PHP                    | Backend Development          |
| MySQL                  | Database                     |
| HTML5                  | Page Structure               |
| CSS3                   | Styling                      |
| JavaScript             | Client-Side Functionality    |
| Bootstrap              | Responsive UI                |
| jQuery                 | Dynamic Interaction / AJAX   |
| Font Awesome           | Icons                        |
| MySQLi                 | Database Connectivity        |
| REST APIs              | External Service Integration |
| Scheduler / Automation | Scheduled Publishing         |

---

# 📦 Requirements

Before running the project, install:

* PHP 7.4+ / compatible PHP version
* MySQL
* Apache
* XAMPP / WAMP / LAMP
* Modern Web Browser

Recommended local environment:

```text
XAMPP
├── Apache
├── MySQL
└── PHP
```

---

# ⚙️ Installation

## 1. Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/news-portal.git
```

## 2. Move Project

For XAMPP:

```text
C:\xampp\htdocs\
```

Place the project inside:

```text
C:\xampp\htdocs\news-portal
```

---

## 3. Start XAMPP

Start:

```text
Apache
MySQL
```

---

## 4. Create Database

Open phpMyAdmin and create:

```text
news
```

---

## 5. Import Database

Import:

```text
database/news.sql
```

into the `news` database.

---

## 6. Configure Database

Update your database configuration according to your environment.

Example local configuration:

```php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "news"
);
```

Do not commit production credentials to GitHub.

---

# 🔐 Environment Variables

For production, sensitive configuration should be stored outside the repository.

Example:

```text
DB_HOST
DB_USER
DB_PASS
DB_NAME
API_KEY
TRANSLATION_API_KEY
```

Example:

```php
$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = getenv('DB_NAME');
```

---

# ⏱️ Scheduled Publishing Setup

For local development, scheduled publishing can be tested using the available scheduler mechanism.

For production hosting, scheduling can be connected with:

* Server Cron Jobs
* Hosting Cron Jobs
* Database Events
* Scheduled PHP execution

The scheduler should execute the publishing logic periodically.

Example concept:

```text
Every Minute / Every Few Minutes
             ↓
Check Scheduled News
             ↓
Find Due Articles
             ↓
Update Publishing Status
             ↓
Article Becomes Public
```

---

# 🔄 News Status Workflow

A news article can move through different stages:

```text
Draft
  ↓
Submitted
  ↓
Under Review
  ↓
Approved
  ↓
Scheduled
  ↓
Published
```

Rejected content can follow:

```text
Under Review
     ↓
Rejected
     ↓
Reporter Update
     ↓
Resubmit
```

---

# 🔍 Search & Filtering

The portal supports content discovery through:

* News Search
* Category Filtering
* Location Filtering
* Published News Filtering
* Date-Based Filtering
* Keyword Search

This makes it easier for users to find relevant news articles.

---

# 🖼️ Image & Media Management

News articles can contain associated images.

The media system supports:

* Image Upload
* News Thumbnail
* News Featured Image
* Image Display
* File Validation

For production, uploaded files should be validated by:

* File Extension
* MIME Type
* File Size
* Filename Sanitization

---

# 📱 Responsive Design

The interface is designed using Bootstrap's responsive grid system.

The application can adapt to:

```text
Desktop
   ↓
Laptop
   ↓
Tablet
   ↓
Mobile
```

---

# 🔌 API Architecture

External APIs can be integrated through backend PHP requests.

Conceptual architecture:

```text
User
 ↓
PHP Backend
 ↓
API Request
 ↓
External API
 ↓
API Response
 ↓
PHP Processing
 ↓
Database / UI
```

API keys should remain server-side and should never be exposed in frontend JavaScript.

---

# 🧩 Extensibility

The application can be extended with additional modules such as:

* Breaking News Notifications
* Email Notifications
* Push Notifications
* Social Media Sharing
* Advanced Search
* News Analytics
* Trending News
* Comments
* Likes
* Bookmarks
* User Preferences
* Multi-Language News
* AI-Assisted News Summarization
* Advertisement Management
* Newsletter System

---

# 📈 Future Improvements

Planned/possible improvements:

* REST API for Mobile Applications
* JWT Authentication
* Advanced RBAC Permissions
* Real-Time Notifications
* WebSocket Integration
* Advanced Analytics Dashboard
* Redis Caching
* Elasticsearch Search
* Cloud Storage
* Docker Deployment
* CI/CD Pipeline
* Automated Testing
* Progressive Web App
* AI-Based Content Assistance

---

# 🧪 Testing Checklist

Before deployment, verify:

```text
✓ Registration
✓ Login
✓ Logout
✓ Role Authorization
✓ Admin Dashboard
✓ Reporter Dashboard
✓ Editor Dashboard
✓ Member Dashboard
✓ Add News
✓ Update News
✓ Delete News
✓ Category Management
✓ Location Management
✓ News Approval
✓ News Rejection
✓ News Scheduling
✓ Automated Publishing
✓ Image Upload
✓ Search
✓ Filtering
✓ API Integration
✓ Language Conversion
```

---

# 🚀 Production Deployment

For production deployment:

1. Upload project files to hosting.
2. Create MySQL database.
3. Import `news.sql`.
4. Configure environment variables.
5. Configure Apache/PHP.
6. Configure scheduled task / cron.
7. Enable HTTPS.
8. Secure uploaded files.
9. Remove development credentials.
10. Test all user roles and workflows.

---

# 🔒 Git & GitHub Security

Never commit:

```text
.env
passwords
API keys
database credentials
private tokens
production configuration
```

Recommended `.gitignore`:

```gitignore
.env
.env.*
*.log

.vscode/
.idea/

.DS_Store
Thumbs.db

config.local.php
```

---

# 🎯 Project Highlights

### Enterprise-Style Role Management

Implemented multiple user roles with role-specific dashboards and access control.

### Automated News Publishing

Implemented scheduled news publishing based on configured date and time.

### Database-Driven Architecture

Used MySQL relational tables for users, categories, locations, and news content.

### API-Ready Architecture

Designed backend integration for external APIs and third-party services.

### Multi-Language Capability

Supports integration with language conversion/translation services.

### Responsive UI

Built responsive interfaces using Bootstrap, JavaScript, and jQuery.

---

# 📊 Core Modules

```text
┌──────────────────────────────────────┐
│          NEWS PORTAL SYSTEM          │
└──────────────────────────────────────┘
                  │
      ┌───────────┼───────────┐
      ↓           ↓           ↓
    Admin      Reporter     Editor
      │           │           │
      └───────────┼───────────┘
                  ↓
          News Management
                  │
       ┌──────────┼──────────┐
       ↓          ↓          ↓
   Category    Location   Scheduling
       │          │          │
       └──────────┼──────────┘
                  ↓
          Automated Publishing
                  ↓
           Public News Portal
                  ↓
               Members
```

---

# 💡 Learning Outcomes

This project demonstrates practical experience with:

* Full-Stack Web Development
* PHP Backend Development
* MySQL Database Design
* CRUD Operations
* Authentication
* Authorization
* RBAC
* Session Management
* API Integration
* AJAX
* JavaScript
* jQuery
* Bootstrap
* File Uploads
* Scheduling
* Automation
* Relational Database Design
* Responsive Web Design
* Git & GitHub

---

# 👨‍💻 Author

**Aszad Raza**

Full Stack Developer

### Technologies

```text
PHP • MySQL • JavaScript • Bootstrap • jQuery
```

---

# ⭐ Support

If you find this project useful or interesting, consider giving the repository a ⭐ on GitHub.

---

# 📄 License

This project is currently provided for **portfolio and educational purposes**.

If you plan to distribute or reuse the source code, please contact the author for permission.
