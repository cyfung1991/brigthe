# brighte
Page:
1. Product list page
  - product picture
  - product name
  - product price
  - actions (Edit, delete with success reload)
  - Create product Link (On the top)
  - Sort( name, price ASC/DESC )

2. Product create page
  - File upload (Accept: jpg, jpeg, gif and png)
  - 4 fileds (mandatory and min length = 4)

3. Product edit page
  - All field editable

4. Product details page
  - Show picture, name, price, Description

Test suite:
kenjis/ci-phpunit-test ( phpunit for codeigniter )
Ref link: https://github.com/kenjis/ci-phpunit-test
full support the framework codeigniter

Q1: Name of your chosen PHP framework and why.
Framework: Codeigniter
Reason:
  1. Fast response time
  2. Built in security tool( cookies encryption, escaping sql query )

Q2: Steps needed to setup the solution and dependencies.
  1. open "application/config/config.php"
  2. update $config['base_url'] to your host ip
  3. open "application/config/database.php"
  4. update hostname, username, password, database (schema)
  5. import file in root name "db_backup.sql" to schema
  6. go to http://yourhost/product

Q3: Steps needed to run the test suite.
  1. open "command line"(Windows: cmd)
  2. cd to application root (eg. C:\inetpub\wwwroot\brighte\application\tests)
  3. Must go to folde "application\tests"
  4. run "../../vendor/bin/phpunit"
  5. result!!

Q4: Time taken to complete the test.
- Setup(download codeigniter source) - 10mins
- Coding(basic layout, function) - 2hrs
- Database setup - 1hr
- Test suite - 2hrs
- Total:5h10m

Q5: Any compromises/shortcuts you made due to time considerations.
- DB design( product_photo should be one two many to product)
