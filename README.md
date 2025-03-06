**Introduction this repository**

Welcome to the Cinema Booking System repository! This project is built using PHP Native and includes key features such as PHPMailer for email handling and Midtrans as the payment gateway.

**Key Features:**
1. User Authentication & Email Verification:
   • PHPMailer is utilized to send email verification links upon user registration.<br>
   • Users can also request password reset emails if they forget their credentials.

2. Secure Online Payment with Midtrans:

   • The system integrates Midtrans payment gateway to facilitate secure and seamless transactions for   ticket bookings.<br>
   • Once the payment is successfully processed, the system automatically generates a PDF ticket containing a QR Code, which is sent to the user’s registered email via PHPMailer.

3. QR Code Scanning for Ticket Validation:
   • At the cinema counter, clerks can scan the QR Code on the ticket to verify its authenticity and grant access to the customer.<br>
   • This ensures a fast and efficient check-in process for moviegoers.

This project is designed to provide a smooth, secure, and efficient movie ticket booking experience, combining the power of PHP Native, PHPMailer, and Midtrans.

Feel free to explore the repository, contribute, or modify the system according to your needs! 🚀🎬


**Prerequisites**
1. Xampp
2. Visual Studio Code


**Follow the following steps after Starting Apache and MySQL in XAMPP:**

1st Step: Firstly, Extract the file
2nd Step: After that, Copy the main project folder
3rd Step: So, you need to Paste in xampp/htdocs/

**Changing Mailer and Payment Gateway:**

4th Step: You need to change email on PHP Mailer in CUSTOMER/bookingSuccess.php file ,
CUSTOMER/process.php file and CUSTOMER/process_forgot_password.php file
5th Step: You need to change with your Key on MidTrans (Client Key or Server Key) in 
CUSTOMER/bookingSuccess.php file and CUSTOM/displayBookingDetails.php file

**Creating database:**

6th Step: Open a browser and go to URL “http://localhost/phpmyadmin/”
7th Step: After that, Click on the databases tab
8th Step: So, Create a database name it as “paragoncinemadb” and then click on the import tab
9th Step: Click on browse file and select “paragoncinemadb.sql” file which is inside the “DATABASE”      folder
10th Step: click on Go button.

**Running the website:**
11st Step: Proceed to the URL below

If Customer's System:-
“http://localhost/Cinema-Booking-System-CRUD-/CUSTOMER”



If Admin(Manager/Clerk) system:-
“http://localhost/Cinema-Booking-System-CRUD-/ADMIN"

12nd Step: You can login into Customer's System by using existing account or register for a new one through phpmyadmin. 
Admin's System on the other hand doesn't have any registration so you must use existing account by referring to the table Clerk or Manager respectively in the database.

**Documentation of the system:**

<img src="https://github.com/user-attachments/assets/8e2590bf-55d0-4543-9459-e668c47b4dd3" width="3000">

<br><br>

<img src="https://github.com/user-attachments/assets/5901290c-9f99-4877-8a3e-7a4ac37255f6" width="3000">

<br><br>

<img src="https://github.com/user-attachments/assets/be79db82-f069-4d2d-b7a1-5ec5e0d7aca7" width="3000">

<br><br>

<img src="https://github.com/user-attachments/assets/7ce11b2f-7c51-4fe6-9a35-ad619c54fe84" width="3000">

<br><br>

![image](https://github.com/user-attachments/assets/6de5310b-e8b5-44be-9285-60db2a68ffed)

<br><br>

<img src="https://github.com/user-attachments/assets/aca2f224-75a0-4add-8c2f-c2916b21296a" width="500">





