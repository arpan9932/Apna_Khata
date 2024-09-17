
# Apna Khata 💰📊

**Apna Khata** is a daily tracking website designed to help you manage and monitor your finances easily. You can add your salary, manual income, and track your spending with an insightful analysis. This project helps you to stay on top of your finances and get a better understanding of where your money is going.

## Features ✨
- **Add Salary and Manual Income**: Input your monthly salary and any additional income you receive manually.
- **Track Spending**: Record and categorize your expenses.
- **Spending Analysis**: Visualize your spending through easy-to-understand graphs and tables.
- **User-Friendly Interface**: Simple and clean design for easy navigation.
- **AJAX-Powered Interactions**: Real-time updates without page reloads using AJAX.
- **Responsive Design**: Works on all devices — mobile, tablet, and desktop.

## Technologies Used 🛠️
- **Frontend**:
  - HTML5
  - CSS3
  - JavaScript (ES6)
  - jQuery
  - AJAX for real-time updates

- **Backend**:
  - PHP for server-side logic
  - MySQL for database management


## Setup Instructions ⚙️

1. **Clone the repository:**

   ```bash
   git clone https://github.com/arpan9932/Apna_Khata.git
   ```

2. **Configure the Database:**
   - Create a MySQL database and import the provided `apna_khata.sql` file.
   - Update the `db.php` file in the `/config/` folder with your database credentials:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "apnakhata";
     ```

3. **Run the Project:**
   - Host the project on a local or remote server (XAMPP, WAMP, or LAMP).
   - Open `http://localhost/apna-khata/` in your browser.


## Future Enhancements 🚀
- Add user authentication for secure access.
- Introduce budgeting goals.
- Enable automated reminders for bill payments.
- Support for multiple currencies.
- Enhanced data visualization with charts and graphs.

## Contributing 🤝
Contributions are welcome! If you'd like to contribute, please fork the repository and submit a pull request.

1. Fork it (`https://github.com/arpan9932/Apna_Khata/fork`)
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request
