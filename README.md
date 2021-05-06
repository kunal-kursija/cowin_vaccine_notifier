# cowin_vaccine_notifier
- PHP package to search COVID vaccine availability in India by pin-codes in every one minute.

Pre-Requisites:
--------------
- Make sure you have PHP installed on your system.
- To check if its installed or not, Execute below command from the command line tool:
```bash
php --version
```

Introduction
------------
- This package helps you in finding the available vaccines on https://selfregistration.cowin.gov.in/ by Pin-Codes.
 
Installation
------------
Option 1: 
- Open Command Line Tool and clone the repository by executing below command:
```bash
git clone git@github.com:kunal-kursija/cowin_vaccine_notifier.git
```
Option 2:
- Download the zip from [here](https://github.com/kunal-kursija/cowin_vaccine_notifier/archive/refs/heads/main.zip)
- Unzip it.

Usage
-----
- Go to the newly cloned/downloaded directory and edit the file `cowin_notifier.php`.
- Configure Pin-Codes that you want to search on Line.No.9. And they need to be in comma separated format.
  Example: `$pincodes = [400001, 421004, 431127, 431523, 413249, 431131, 414201, 416810];`
- Configure Age Group for which you want to search vaccines on Line.No.18.
  Example:  `$age = 18;` OR `$age = 45;`
- Change the directory to the newly cloned directory by following command:
```bash
cd cowin_vaccine_notifier
```
- Execute the php script by below command:
```bash
php -f cowin_notifier.php
```

- The script will execute every one minute and will shout "Vaccines Found" if it comes across any available slots in your configured pincodes.
- If you want to change the lookup frequency, You can change it from Line.No.54 as `sleep(60);` where 60 is the number of seconds. By default we execute the script every 1 minute.
