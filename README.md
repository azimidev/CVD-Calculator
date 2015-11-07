# CVD-Calculator
This is a PHP Cardiovascular Disease Calculator system created by Hassan Azimi

# What does this app do?
This app calculates the cardio vascular disease based on user's age, blood pressude, HDL-C, LDL-C, smoking history, diabetic history and their gender.

# What language is used?
I used PHP, MySQL, advanced JavaScript and jQuery. Also HTML5 and CSS3 is used for presentation.

# How to install?
Download the project and unzip in your localhost root directory.
Import the cvd.sql file in phpMyAdmin or paste the code to create the tables. (Database creating needed at first.)
Open includes/db_connection.php and manipulate the details to be able to connect your MySQL database.

# How to use this app?
There are 2 types of users:
1- Patients
2- Doctors

Doctor's credentials:
Username: doctor
Password: 123

Patient's credentials:
Username: amir
Password: 321

There are no registration for the system. Patients can be added through database and because the password is blowfish encrypted, therefore, by adding patients email password can be reset via forgot password feature.
