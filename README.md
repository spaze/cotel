Cotel: companies intel
======================
A ***prototype*** for a library of links to articles describing how companies do their things. *For source code archeologists only.*

The code is of prototype and proof-of-concept quality, it's messy and I don't like it either. I wanted to nuke it from orbit but the data might be of some use to somebody so here it is, with source code and fries. You've been warned.

Screenshots
-----------
Typing `cr` into the searchbox:
![Searchbox](screenshots/cotel1.png)

Listing entries tagged with `mongodb`:
![Entries tagged with mongodb](screenshots/cotel2.png)

Listing entries tagged with `cloud` and `netflix`:
![Entries tagged with cloud and netflix](screenshots/cotel3.png)

Installation
------------
Just don't install it. In case you still want to, `cd site` and create `log` and `temp` directories, make them writable for your web server user. Then, install dependencies using `composer install`. The thing is powered by [Nette Framework](https://nette.org/), thanks. *One more thing...* don't you dare to install it.
