
# Deploy

  Minimalistic deployment shell script.

## Getting Started
   - Above the list of files, click  Code.
   
   - Copy the URL for the repository.
   
For example, to clone a repository using HTTPS, click under "HTTPS".

    $ https://github.com/leonidSahakyan/weedshop.git

## Installation
- Open Git Bash.
- Change the current working directory to the location where you want the cloned directory.
  
  - For Example 

        $ cd C:/ospanel/domains
    
- Type git clone, and then paste the URL you copied earlier.

      $ git clone https://github.com/leonidSahakyan/weedshop.git

- cd into your cloned project or go to developer tools and open the cloned project․
- control .env configuration
- change php version 8.1
- control DB import or migrate
  
        $ php artisan migrate

- When you run composer install, Composer installs the required packages listed in the composer.json file and creates the vendor directory in your project. The vendor directory contains all the installed packages and their autoload files.

        $ composer i

- npm will read the package.json file in your project (or create one if it doesn't exist), and install the dependencies specified in that file.

        $ npm install
  
- run project

        $ php artisan serve

