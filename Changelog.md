# Changelog
### Konekt Customer Module

## 0.9

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
