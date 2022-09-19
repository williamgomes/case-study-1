<h2 align="center">Trivago Case Study</h2>

## Installation

Use following procedure to complete setup of this project.


1. Download composer if you didn't have.


```
curl -sS https://getcomposer.org/installer | php
```

2. Install all the packages required to run this application by running following command.

```
php composer.phar install
```

3. Define the CSV file name inside config.yml file like below.

```
file_name: 'hotels.csv'  #<== file name to read data from
```

4. Read whole configuration defined inside config.yml and customize it according to your needs.

5. In order to generate validated hotel data into yaml/xml format, use below command. Optionally you can define file name.

```
php index.php generate:validdata {output_type} {file_name|optional}
```

6. This will create a new file in the same directory as the input.



## Testing

To run the test properly, please run below command from commandline.

```
php vendor/bin/phpunit --colors --coverage-text --configuration tests/phpunit.xml.dist  tests/
```