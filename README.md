OTP Verification

Prerequisites:
* MySQL 
* Node.js
* PHP 7+
--------------


1. Run PHP server from the command line/terminal inside 'otpfy/api' folder with 'php -S localhost:3030'
2. Go to 'http://localhost:3030/db_setup.php' in order to recreate DB and Users table
3. Start React server from '/otpfy' folder with 'npm start'
4. The OTP will be sent as a response in the Chrome Dev console (simulating mobile service provider)

--------------

To be implemented:
- SMS API integration or similar
