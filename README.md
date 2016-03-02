# Code Detective Scanner
A wrapper around the code climate docker container CLI.

https://github.com/codeclimate/codeclimate

## Requirements
- Docker

## Usage
### Global Options
| Name        | Usage                               | Short option | Description |
| ----------- | ----------------------------------- | ------------ | ----------- |
| Directory   | `--directory /directory/to/project` | `-d`         | Specifies the directory in which to run the analysis on.



### Initialize
Creates a .codeclimate.yml file in the directory you specify.

Example:
```
php code-detective-scanner.phar init -d /var/www/website
```

### Analyze
Analyzes your code using the settings from the .codeclimate.yml. It will then send these results off to your code detective instance if you specify one.


Example:
```
php code-detective-scanner.phar analyze -d /var/www/website
```

#### Options
| Name        | Usage                               | Short option | Description |
| ----------- | ----------------------------------- | ------------ | ----------- |
| Code Detective Host   | `--detective_host detective.example.com` | `-dhost`         | Specifies the hostname/IP address to send the results from the analysis to.
