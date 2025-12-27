# Instragram – Laravel Social Media Platform

**Instragram** is a full-stack social media web application modeled after Instagram. It is designed to provide a visually focused networking experience, allowing users to share photos and videos while interacting through likes, comments, and follows.

## 🚀 Key Features

* **User Authentication**: Secure registration and login system using Bcrypt hashing for passwords.


* **Media Sharing**: Users can create, edit, and delete photo/video posts with captions.


* **Social Interaction**: Real-time feedback for liking/unliking posts and commenting.


* **Follow System**: Ability to follow or unfollow other accounts to curate a personalized feed.


* **Real-time Notifications**: Instant alerts for new likes, comments, and followers.


* **User Profiles**: Customizable profiles where users can manage their bio, display name, and profile picture.


* **Search**: Discover other users by searching for their usernames.


* **Dark Mode**: A toggleable dark/light mode that saves user preferences.



## 🛠️ Technology Stack

* **Backend**: Laravel (PHP >= 8.1)
* **Frontend**: Bootstrap, Blade Templates, and AJAX for real-time interactions 


* **Database**: MySQL (>= 5.7)
* **Tools**: Composer, NPM, VS Code

## 📥 Installation

Follow these steps to set up the project locally:

1. **Clone the repository and install dependencies**:
```bash
composer install
npm install

```


2. **Configure Environment**:
* Copy `.env.example` to `.env`.
* Set your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) in the `.env` file.


3. **Generate Application Key**:
```bash
php artisan key:generate

```


4. **Run Migrations**:
```bash
php artisan migrate

```


5. **Start the Server**:
```bash
php artisan serve

```


The application will be available at `http://127.0.0.1:8000`.

## 📁 Project Structure

* `app/`: Core application logic, including Models, Controllers, and Notifications.
* `resources/views/`: Blade templates for the user interface.
* `routes/web.php`: Defines the web routes for the application.
* `database/`: Contains database migrations and seeders.

## 🔒 Security Features

* **Password Hashing**: Uses the Bcrypt algorithm with salts to protect against brute-force attacks.


* **CSRF Protection**: All forms are protected with Cross-Site Request Forgery tokens.


* **Authentication Middleware**: Restricts sensitive pages to authenticated users only.


* **Input Validation**: All user inputs are validated and sanitized to prevent injection attempts.



## 📈 Future Improvements

* Implement image compression and optimization to improve loading times.


* Add end-to-end encryption for private messaging.


* Enhance search functionality with fuzzy matching and partial name suggestions.


* Introduce AI-based content recommendations.



---
