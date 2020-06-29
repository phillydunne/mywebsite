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

# inject database password - this worked second time around with a sudo around it.
#-------------------------
sudo sed -i.bak "s/<password>/$(cat /home/bitnami/bitnami_application_password)/;" /opt/bitnami/apache2/htdocs/configs/config.txt

# create database -  i should set this up with some test data. How else could i get data onto the server securely?
#-----------------
cat /opt/bitnami/apache2/htdocs/data/init.sql | /opt/bitnami/mysql/bin/mysql -u root -p$(cat /home/bitnami/bitnami_application_password)