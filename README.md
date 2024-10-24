# Automatic-Scheduller-Application
This is an automatic time-table generating web application for schools and universities,
The application automate the process of generating time tables while considering various constraints and optimizing for criteria such as minimal gaps between classes and balanced teacher workloads. 

## How to Setup the web application

1) Download and install Visual Studio Code(VScode):- https://code.visualstudio.com/
2) Download and install python (don't change installing paths):- https://www.python.org/downloads/
3) Dowload and install xampp(don't change installing paths):- https://www.apachefriends.org/download.html
4) Download the project as zip and extract it.
5) After that there is a folder automatic_tt copy and paste it on C:\xampp\htdocs folder
6) Open Xampp control panel and start Apache and MySQL.
7) Click on admin in MySQL, create a new database automatic_tt, after database creation import the database to it.(In database folder you have the database sql file).
8) Once you do all these you have to open the generate_timetable.php (C:\xampp\htdocs\automatic_tt folder) in vscode,
9) And update the //Path to Python executable $pythonPath = 'C:\\Users\\*****\AppData\\Local\\Programs\\Python\\Python312\\python.exe'; you can find your python path by run -where python in cmd copy and paste the path.
10) Also Run this command in cmd -"pip install mysql-connector-python"
11) All done!!!
12) Now open your Web browser and paste this url:- http://localhost/automatic_tt/signin.php
13) You can create a new account and enjoy the application.
14) You can delete all the data from the database and apply new data to the database by the web application and generate time table for your need.

###Enjoy!!
Feel free to ask any questions!!!
