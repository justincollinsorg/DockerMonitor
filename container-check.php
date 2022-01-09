<?php

shell_exec("ls /root/illd/live_containers_folder  > /root/illd/live_containers");

$containers_string = file_get_contents("/root/illd/live_containers");

$containers = explode("\n",$containers_string);

shell_exec("docker ps | sed 's/|/ /' | awk '{print $1}' > /root/illd/ps");

$ps = file_get_contents("root/illd/ps");
sleep(2);
//echo "/n $ps \n";
$ps_array = explode("\n",$ps);
foreach($containers as $container){
        if (in_array(trim($container), $ps_array, true)){
                        if($container != "") {
                        echo "\n $container is running  \n";
                        }
        } else {
                echo "\n $container is down  \n";

                shell_exec("docker start $container");
        }

}

