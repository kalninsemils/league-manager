#!/bin/bash
NAME=$1
ID=$(id -u $USER)

sudo docker build -t $NAME .
cd ../../

# currently supporting only http, later will add https
sudo docker run -d --name $NAME -v "$PWD"/deploy/nginx/conf.d:/etc/nginx/conf.d -v "$PWD"/:/var/www/app -p 8080:80 -p 5433:5432 $NAME
# default user with the same access rights as current host user

sudo docker exec -it $NAME mkdir -p /home/$NAME
sudo docker exec -it $NAME useradd -r -u "$ID" -g sudo $NAME
sudo docker exec -it $NAME chown -R $NAME:sudo /home/$NAME/


# initially this should be run, so the project actually works,
#  these can be run anytime if needed afterwards
sudo docker exec -it --user $NAME $NAME composer update
#sudo docker exec -it --user $NAME $NAME npm install
#sudo docker exec -it --user $NAME $NAME npm run dev
sudo chmod +777 storage -R
# pgAdmin docker
#sudo docker run -d --name pgadmin -p 5433:80 foxylion/pgadmin4
