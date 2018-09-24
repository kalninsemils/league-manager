# League Manager Test Project

## Prerequisites

 GNU Linux Capable of Launching Docker 17+
 Docker
 Ports 8080 and 5432 should be open (otherwise modify Dockerfile accordingly)

## Deploy Instructions:

Locate Deployment Directory:
```$ cd league-manager/deploy/docker```

Create a development Docker environment with nginx, docker, npm, redis and php7.2
```$ ./deploy.sh league-manager```
Verify that the evnironment has started
```$ sudo docker ps```

###Database setup:

Enter Container in bash mode
```$ sudo docker exec -it league-manager bash```
Login into pgsql:
```$ psql -u postgres```
Create Database;
```create database league_manager;```
Exit pgsql and execute the following command in bash:
```$ php artisan migrate```


Visit the project in browser
http://localhost:8080

## Project Workflow

1) Generates teams (result lists newly appended)
2) Creates League with divisions
3) Generate Scores per Division
4) Generate Finals Scores

## Disclaimer

Caching mechanics were not used in the project
Node driven modern UI was not used in the project
Score generations for Finals was created by taking into account hardcoded requirements of 4 winning teams per division
Equal victory count for multiple division teams was not taken into account and no special development was made to handle such cases

##Troubleshoot

###deploy.sh not working

Error:
bash: ./deploy.sh: /bin/bash^M: bad interpreter: No such file or directory
The above error can be fixed by changing the file encoding to unix, open file with vim:
```:set ff=unix```


