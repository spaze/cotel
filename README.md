Cotel: companies intel
======================
A ***prototype*** for a library of links to articles describing how companies do their things. *For source code archeologists only.*

The code is of prototype and proof-of-concept quality, it's messy and I don't like it either. I wanted to nuke it from orbit but the data might be of some use to somebody so here it is, with source code and fries. You've been warned.

Original idea
-------------
The idea was to have a bookmark manager, sort of, with links to articles and videos which should help you when you need an inspiration when solving an engineering issue. Scaling MongoDB and would love to know how others have done it? No problem, search for the `mongodb` tag and add `scale` if you feel like. Want to know what else have Netflix shared with the rest of the world? Search for the `netflix` tag.

The content was to be curated and verified by a community (that would be mostly *me*), but general public was supposed to easily add URLs. The new entry would end up in a queue of new entries which would be moved to the main database after details like date and title would be added. Everyone could also add new or remove existing tags, such action would also create an entry in the queue and an administrator would need to manually confirm or merge changes.

I've added first 100 links, roughly one per week for last two years, except for the last 6 months. I haven't added a single link since April 2015. I haven't touched the code since March 2014, except some minor changes which were due to this app being part of a different, bigger repository.

So I'm releasing it now, hopefully the data will be useful to somebody. The code probably won't, but that's fine, it was not production-ready anyway. It's actually kinda messy, proof-of-concept only. No, I don't usually write SQL queries like this.

Data
----
Probably the most interesting thing here is the data. 100 tagged links to articles (and videos) about mostly engineering topics. You know, scaling, architecture, but also a bit of "engineering HR". I've uploaded the data to the [`data`](data) dir, it's exported to SQL and YAML. The latter is missing tag categories, all the tags are equal. Tag categories are used to distinguish between tags used for tagging companies (`netflix`, `amazon`), technologies (`postgresql`, `nodejs`), etc.

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
1. Just *don't* install it
2. In case you still want to, `cd site`
3. Create `log` and `temp` directories
4. Make them writable for your web server user
5. Install dependencies using `composer install`
6. `cd app/config`
7. Copy `config.local.neon.template` to `config.local.neon`
8. Edit `dsn`, `user`, `password` in your new `config.local.neon`
9. Point your virtual host document root to `site/www`
10. ...
11. Profit!

This thingie is powered by [Nette Framework](https://nette.org/), thanks.

*One more thing...* don't you even dare to install it.

Known issues
------------
The code was separated from another repository, so there might be some missing parts here and there. Known issue is that the `X-XSS-Protection` and `Content-Security-Policy` headers are missing.
