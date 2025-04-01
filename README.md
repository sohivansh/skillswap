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

- Profile System
  - View and edit personal information
  - Display teaching and learning skills
  - Manage skill preferences

## Technologies Used

- PHP
- MySQL
- Bootstrap 5
- HTML/CSS
- JavaScript

## Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/skillswap.git
```

2. Import the database
- Create a new MySQL database named 'skillswap'
- Import the SQL file from the `database` folder

3. Configure database connection
- Open `includes/functions.php`
- Update the database credentials:
  - Host (default: localhost:3308)
  - Username (default: root)
  - Password
  - Database name (skillswap)

4. Start your local server
- Place the files in your web server directory
- Access through localhost

## Database Structure

### Tables
- users
- skills
- user_skills

## Contributing

1. Fork the repository
2. Create a new branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 