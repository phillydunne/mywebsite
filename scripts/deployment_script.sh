# remove default website
#-----------------------
cd /opt/bitnami/apache2/htdocs
rm -rf *

# clone github repo
#-----------------------
cd ..
git clone https://github.com/phillydunne/mywebsite.git htdocs

# change permissions on config file
#-----------------------
cd htdocs/configs
chown bitnami:daemon config.txt
chmod 666 config.txt

# inject database password
#-------------------------
sed -i.bak "s/<password>/$(cat /home/bitnami/bitnami_application_password)/;" /opt/bitnami/apache2/configs/config.txt

# create database
#-----------------
cat /opt/bitnami/apache2/htdocs/data/init.sql | /opt/bitnami/mysql/bin/mysql -u root -p$(cat /home/bitnami/bitnami_application_password)