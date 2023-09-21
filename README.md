# Scandiweb Test Assignment

This repository contains my solution to the Scandiweb Test Assignment. The assignment involves creating a web application that allows the user to add products with specific details based on the product type.

## Features

- Add products with details based on product type (DVD, Book, Furniture).
- Display a list of added products.
- Mass delete selected products.

## Technologies Used

- JavaScript
- React
- SCSS
- PHP
- MySQL

## How to Run

1. Clone the repository to your local machine.
2. Set up a local server environment with PHP and MySQL.
3. Import the database schema provided in `database/create_database.sql` to your MySQL database.
4. Import the initial data using `database/insert_initial_data.sql` to pre-fill the database with sample data.
5. Update the PHP server details in the project files to match your local environment.
6. Start the local server.
7. Navigate to the project directory.
8. Open the project in a web browser.

## Setting up the MySQL Database

To set up the MySQL database:

- Install MySQL and set up your local MySQL server.
- Create a new database named `scandiweb_products`.
- Import the database schema by running the following command in your MySQL console:

`mysql -u username -p scandiweb_products < server/database/create_database.sql > `

- Import the initial data by running the following command in your MySQL console:

`mysql -u username -p scandiweb_products < server/database/insert_initial_data.sql >`


## Website

You can view the working application at this link: `https://test-assigment-scandi.000webhostapp.com/`.

## Contributing

Contributions to the Chat App MERN project are welcome! If you have any ideas for improvements, bug fixes, or new features, feel free to open an issue or submit a pull request.

Please make sure to follow the existing coding style and guidelines when contributing.

## License

This project is currently without a specific license. All rights are reserved.