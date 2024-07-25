#Install

Requirements : 
- Composer Package Manager
- Laravel 10
- PHP 8.1 or higher


Install Instructions : 
- composer install
- npm install
- npm run build
- create a Schema for the system
- Setup a DB connection in the .env file for your schema. (There is a .env.example you can copy)
- php artisan migrate; php artisan db:seed;

--- 

# Assessment Developer - Secret message

At BAS Tech we primarily use PHP for our service development. We create web applications, 
APIs, microservices, (native) apps and a monolithic intranet. 

We're very interested to see how you develop. Having something in a working fashion is
secondary to be being able to explain why you did what you did. 

This is because we believe that anyone can learn a language, framework and ecosystem 
surrounding a language/framework. The hard parts are explaining choices you made, following
design patterns and writing human-readable code. 

## Requirements

- Use Git versioning system
- Your application must run with a maximum of 3 commands:
  - clone
  - install dependencies
  - (optional) start Docker containers

If you forego the Docker part, we will be running it in a Docker instance running: 

- PHP ^8.1
- MySQL ^8.0
- Node ^17

Make sure to upload your project to a VCS system (preferably Github) and provide us with
the (public) link to be able to clone it. 

_**Spend an approximate maximum of 4 hours on the assignment**_

_Remember: your choices of how to work matter more than the final product_

### Optional things

- Use a framework of choice
- If instructions are needed for us to run your project, make sure to include them in the ReadMe
- Have the project be (partially) tested

## Assignment

Be able to share an encrypted message with a colleague. 

Message: 

- text
- recipient
- created at

Expiry:

- read once, then delete
- delete after X period

Reading Message:

- Provide identifier for message
- Provide decryption key

Recipient:

- identifier

_**Remember: it's not a requirement to have everything ready! Your choices matter more than
a finished product!**_
