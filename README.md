# nsa-uno-website
The website project for the NSA UNO. Check out our [WIKI](https://github.com/LengCorp/nsa-uno-website/wiki)!

## What it is
This project is part of the larger NSA UNO project, which is an alarm system for the home.
This is the website, which is the user interface part of the alarm system. It reads from a database every few seconds and react if it is a new input since last read.
The website can also change the state of the alarm (on or off) by sending a value to the database.

## How it works
* With jQuery the website will do an ajax call to a php file who checks the latest input in the event table of the database, and respond with true if it found somethign new and nothing if not. This will let the website know it is time to update.
* There is a button that will change depending on the current state of the alarm.
* The website also have a login page and a history page. On the history page you can see the last 15 events.