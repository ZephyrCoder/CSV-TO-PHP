# Import CSV Data to MySQL

This script allows you to import data from a CSV file into a MySQL database. It includes features such as:

- Connecting to the MySQL database
- Validating the uploaded CSV file
- Reading the CSV data
- Inserting the data into the database
- Handling errors and displaying messages to the user

## Notes

- The script assumes that the CSV file has three columns: "name", "email", and "age".
- The "age" column is optional and can be left empty.
- The script uses prepared statements to prevent SQL injection attacks.
- The script handles errors and displaying messages to the user.

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- PHP MySQLi extension

## License

This script is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
