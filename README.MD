# 📝 WordWeave - Blog Application

A simple and responsive **Blog Application** built with **HTML, CSS, and JavaScript** for the frontend, **PHP** for the backend, and **MySQL** as the database.  
This project demonstrates a full-stack web application with **user authentication**, **CRUD blog management**, and a clean UI.

---

## 🚀 Features

### 🧑‍💻 User Authentication & Authorization
- Register, Login, and Logout functionality.
- Only authenticated users can:
  - Create new blogs.
  - Edit or delete **their own** blogs.
- Authorization rules prevent users from modifying others' blogs.

### 📰 Blog Management
- ✍️ Create new blog posts using an editor.
- 📖 Read blogs on the home page (all published posts).
- 🧩 Update your own blog posts.
- 🗑️ Delete your own blog posts.
- Blogs display **title, author, and date**.

### 🎨 Frontend
- Responsive, modern design using HTML, CSS, and JavaScript.
- Home page showing all blogs.
- Single blog view page for detailed reading.
- Blog editor page for creating/updating posts.
- Hamburger menu for mobile navigation.

### 🗄️ Database Schema
**MySQL Database Tables:**

#### `user`
| Column     | Type         | Description                   |
|-------------|--------------|-------------------------------|
| id          | INT (PK)     | Auto Increment Primary Key    |
| username    | VARCHAR(100) | User’s display name           |
| email       | VARCHAR(150) | User’s email address          |
| password    | VARCHAR(255) | Hashed user password          |
| role        | VARCHAR(50)  | e.g., "user" or "admin"       |

#### `blogPost`
| Column     | Type         | Description                     |
|-------------|--------------|---------------------------------|
| id          | INT (PK)     | Auto Increment Primary Key      |
| user_id     | INT (FK)     | Linked to `user.id`             |
| title       | VARCHAR(255) | Blog post title                 |
| content     | TEXT         | Main content of the blog        |
| created_at  | DATETIME     | Creation timestamp              |
| updated_at  | DATETIME     | Last modification timestamp     |

---

## 🧰 Tech Stack

**Frontend:**
- HTML5
- CSS3 
- JavaScript 

**Backend:**
- PHP (Session-based authentication, routing, CRUD operations)

**Database:**
- MySQL

---

## ⚙️ Installation & Setup

Follow these steps to set up the project locally:

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/binu126/blog.git
cd blog
