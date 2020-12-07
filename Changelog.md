# Changelog
### Konekt Customer Module

## 2.1.0
##### 2020-12-07

- Added PHP 8 support

## 2.0.1
##### 2020-10-11

- Fixed (slightly) invalid dependency versions in composer.json

## 2.0.0
##### 2020-10-11

- BC: return type hints have been added to the interfaces
- BC: Enums have been upgraded to v3
- Added Laravel 8 support
- Dropped Laravel 5 support
- Dropped PHP 7.2 support

### 1.2.0
##### 2020-03-14

- Added Laravel 7 support
- Added PHP 7.4 support
- Dropped PHP 7.1 support
- Minimum required Concord version is 1.5+

### 1.1.0
##### 2019-11-23

- Added Laravel 6 support
- Removed Laravel 5.4 support
- Minimum required Concord version is 1.4+

### 1.0.0
##### 2019-08-17

- Removed PHP 7.0 support
- Added PHP 7.3 support
- Minimum Address module version is 1.0.1
- Stability fixes

## 0.9

### 0.9.6
##### 2018-11-01

- Added `last_purchase_at` field to customers table
- Minimum Concord version requirement is 1.0
- Fixed model events incompatibility with Laravel 5.5+
- Tested up to Laravel v5.7

### 0.9.5
##### 2018-01-10

- The calculated Name can be accessed as property as well

### 0.9.4
##### 2017-12-11

- Dependency updates
- Readme fixes


### 0.9.3
##### 2017-11-26

- Client Module has been forked into Customer
- Everything has been renamed from **_Client_ -> Customer**
- Customer is no longer a composite object of `Person` and `Organization`
- Customer is now stored in a single table, and no longer contains the
  following fields:
    - birthdate
    - gender
    - nin
    - nameorder
- Nameorder and gender support has been dropped (so far)

### 0.9.2
##### 2017-11-25

- Client factory methods have been added for creating client objects
  without saving them to the db


### 0.9.1
##### 2017-11-25

- Common fields (name, email, phone) can be set directly on client


### 0.9.0
##### 2017-11-24

- Changelog and versioning has been started
