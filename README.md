# SkillSwap

SkillSwap is a web platform that enables users to exchange skills and knowledge with others. Users can teach what they know and learn what they want to learn, creating a collaborative learning environment.

## Features

- User Authentication
  - Sign up with email
  - Secure login system
  - Profile management

- Skill Management
  - Add skills you can teach
  - Add skills you want to learn
  - Remove skills from your profile

- Swap Requests
  - Send requests to other users
  - Accept or reject incoming requests
  - View request history

## Technologies Used

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Bootstrap 5
- HTML5/CSS3
- JavaScript

## Prerequisites

- XAMPP (or similar local server stack with PHP and MySQL)
- Web browser (Chrome, Firefox, Safari, or Edge)
- Git (optional, for cloning the repository)

## Installation

1. **Set up XAMPP**
   - Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Start Apache and MySQL services from the XAMPP Control Panel

2. **Clone or Download the Repository**
   ```bash
   # Option 1: Clone using Git
   git clone https://github.com/sohivansh/skillswap.git
   
   # Option 2: Download ZIP from GitHub
   # Visit https://github.com/sohivansh/skillswap and click "Code" > "Download ZIP"
   ```

3. **Set up the Project**
   - Copy the project files to `C:\xampp\htdocs\SkillSwap\` (or your preferred web server directory)
   - Make sure the directory structure matches:
     ```
     SkillSwap/
     ├── includes/
     │   ├── config.php
     │   ├── functions.php
     │   ├── header.php
     │   └── footer.php
     ├── css/
     ├── js/
     ├── images/
     └── *.php files
     ```

4. **Configure Database**
   - Open `includes/config.php`
   - The default database configuration is:
     ```php
     define('DB_HOST', 'localhost:3308');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'skillswap');
     ```
   - If your MySQL port is different from 3308, update the `DB_HOST` value
   - If you have set a password for MySQL, update the `DB_PASS` value

5. **Access the Website**
   - Open your web browser
   - Visit `http://localhost/SkillSwap/`
   - The database and tables will be created automatically on first visit

## Database Structure

### Tables
- `users`
  - id (INT, AUTO_INCREMENT)
  - username (VARCHAR, UNIQUE)
  - email (VARCHAR, UNIQUE)
  - password (VARCHAR)
  - bio (TEXT)
  - created_at (TIMESTAMP)
  - updated_at (TIMESTAMP)

- `skills`
  - id (INT, AUTO_INCREMENT)
  - user_id (INT, FOREIGN KEY)
  - skill_name (VARCHAR)
  - teach (BOOLEAN)
  - learn (BOOLEAN)

- `swap_requests`
  - id (INT, AUTO_INCREMENT)
  - requester_id (INT, FOREIGN KEY)
  - requested_id (INT, FOREIGN KEY)
  - status (ENUM: 'Pending', 'Accepted', 'Rejected')
  - created_at (TIMESTAMP)

## Troubleshooting

1. **Database Connection Issues**
   - Verify MySQL is running in XAMPP
   - Check if the port number in `config.php` matches your MySQL port
   - Ensure database credentials are correct

2. **Page Not Found**
   - Verify files are in the correct directory
   - Check Apache is running in XAMPP
   - Ensure file permissions are correct

3. **Login Issues**
   - Clear browser cache and cookies
   - Try registering a new account
   - Check if the database tables were created properly

## Contributing

1. Fork the repository
2. Create a new branch (`git checkout -b feature/improvement`)
3. Make your changes
4. Commit your changes (`git commit -am 'Add new feature'`)
5. Push to the branch (`git push origin feature/improvement`)
6. Submit a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 