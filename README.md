# St Alphonsus School Records

A university back-end development project exploring how PHP and MySQL can organise pupil, teacher and class records.

**Status:** coursework prototype for local learning and demonstration.

## What the project explores

- Forms for adding pupils, teachers and classes.
- Pages for viewing school records.
- Relationships between classes, teachers, pupils and parents.
- A session-based role-selection login and role-dependent navigation.
- A class form with a capacity input limited to 20.

## Technologies

PHP, MySQL/MariaDB, HTML and CSS. Database access uses PHP’s mysqli extension.

## Run locally

1. Download or clone this repository into your local PHP web server’s document root.
2. Start PHP and MySQL/MariaDB, for example through a local development stack.
3. Import `st_alphonsus.sql` using your database administration tool. The application expects a database named `st_alphonsus`.
4. Review the database connections in the PHP files. They currently expect `localhost`, the `root` user and an empty password; adapt them to your local development configuration.
5. Open the project’s `index.php` through your local web server. The demonstration role credentials are defined in that file.

PHP files must be served by PHP; opening them directly in a browser or using GitHub Pages will not run the application. These instructions describe the source configuration; a fresh installation has not been runtime-tested as part of this documentation update.

## Main files

| File | Purpose |
| --- | --- |
| `index.php` | Demonstration login |
| `home.php` | Dashboard and role-dependent navigation |
| `pupil.php`, `teacher.php`, `classes.php` | Record-entry forms |
| `view_pupils.php`, `view_teachers.php`, `view_classes.php` | Record views |
| `st_alphonsus.sql` | Database schema and included records |

## Limitations and next improvements

This prototype uses hard-coded demonstration passwords. Role-dependent navigation is not a complete authorisation system. Before any real deployment, it needs proper account authentication, server-side permission checks, prepared database statements, CSRF protection and consistent validation. Use fictional records for demonstrations.

Further improvements include centralising database configuration, reviewing HTML structure and session handling, and adding meaningful tests for record creation and class capacity.

## Learning focus

Connecting web forms to relational data, understanding table relationships and identifying the gap between a coursework prototype and a deployable application.
