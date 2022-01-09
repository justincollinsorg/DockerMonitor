# Docker Monitor
Monitors specified docker containers to ensure they are restarted if not running.


----
 1. Must have **php** installed, or rewrite the functionality in bash.
 ```
 apt install php7.4-cli
 ```
 2. Must have **ubuntu** or make ajustments as needed.



----
Installation
```
git clone this ./
```
```
chmod +x test.sh
```
```
chmod +x start_daemons.sh
```
```
chmod +rw down.log 
```


add to crontab - @reboot /path/to/start_daemons.sh
```
crontab -e
```
```
@reboot /root/illd/start_daemons.sh
```
Then,

**create systemd service file /etc/systemd/system/illd.service**
```
[Unit]
Description=Watches and restarts docker containers that die. Read from folder live-containers and compared to docker ps
After=network.target

[Service]
ExecStart=/root/illd/test.sh
Restart=always
User=root

[Install]
WantedBy=muilti-user.target
```
```
chmod 664 /etc/systemd/system/illd.service
```


```
systemctl enable illd.service 
```
```
systemctl start illd.service 
```
```
systemctl status illd.service 
```



**source illd-lib to ~/.bashrc or copy ill-lib functions to .bashrc** 
```

function livecontainer () {
     touch /root/illd/live_containers_folder/${1}
}

function startcontainer () {
     touch /root/illd/live_containers_folder/${1}
}

function addcontainer () {
     touch /root/illd/live_containers_folder/${1}
}

alias lib.ill='ill.lib'
alias rmcontainer='stopcontainer'
alias killcontainer='stopcontainer'

function stopcontainer () {
     rm /root/illd/live_containers_folder/${1}
}

function rmcontainer () {
     rm /root/illd/live_containers_folder/${1}
}

function listcontainers () {
     ls /root/illd/live_containers_folder
}           

alias illds='systemctl status illd.service'
alias illdlog='cat /root/illd/down.log | less'

function illdctl  () {
      if [ "$1" == "restart" ]; 
then
     systemctl restart illd
 return 1
elif  [ "$1" == "status" ];
then
systemctl status illd
 return 1           
elif  [ "$1" == "start" ];
then
systemctl start illd
 return 1
elif  [ "$1" == "stop" ];
then
systemctl stop illd
 return 1           
fi
}

```
refresh .bashrc  with 
```
source ~/.bashrc
```



#Example
----
get the ID  of the docker container you want to have always running.
```
docker ps 
```
```
addcontainer 23e605ef2512
```
```
listcontainers
```
```
systemctl status illd.service 
```
test it
```
docker kill 23e605ef2512
```
```
systemctl status illd.service 
```



