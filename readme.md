##NUSAnswers

Discussion forum for students at an [National University of Singapore](http://www.nus.edu.sg/) to ask and answer questions regarding anything related to the university. The website can be found [here](http://www.nusanswers.com/).

##### Set up server:
* Install [XAMPP](https://www.apachefriends.org/index.html) **or** upload the server-side to some other host
* Populate the DB with proper tables

##### Set up client:
* Install npm and grunt
* Install packages by running ```npm install```
* Edit ```questionService.js``` to point at where you hosted your database
* Run local server with ```grunt server```

All calls to the server are made by ```questionService.js```, this file needs to be edited to match your server
