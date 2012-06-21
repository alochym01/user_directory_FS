<?php

#server localhost
  $server_name = "localhost";

#username de login vao mysql server
  $user_name = "freeswitch";

#password of username login
  $password = "freeswitch";

#databse of data
  $database_name = "freeswitch";

#create connection to connect mysql server
  $connect = mysql_connect($server_name, $user_name, $password) or die("Could not connect: " . mysql_error());

#use the database name
  $db_select = mysql_select_db($database_name, $connect) or die("Not connected : " . mysql_error());

#check the file POST request from freeswitch to see below http POST method contents
  $user=$_POST["user"];

#query database base on user reest
  $result = mysql_query("SELECT * FROM subscriber where username=$user");

#pharse the result of sql query
  $mysql_result = mysql_fetch_array($result);

#check if user is exist or not
  if(!$mysql_result){
    echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
    echo '<document type="freeswitch/xml">' . "\n";
    echo ' <section name="result">' . "\n";
    echo '  <result status="not found">' . "\n";
    echo ' </section>' . "\n";
    echo '</document>' . "\n";
  }

#print the result
  else{
    echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
    echo '<document type="freeswitch/xml">' . "\n";
    echo ' <section name="directory">' . "\n" ;
    echo '  <domain name="' . $_POST['domain']. '">' . "\n" ;
    echo '   <user id="' . $mysql_result['username'] . '">' . "\n" ;
    echo '    <params>' . "\n";
    echo '     <param name="dial-string" value="{presence_id=${dialed_user}@${dialed_domain}}${sofia_contact(${dialed_user}@${dialed_domain})}"/>';
	echo '     <param name="password" value="' . $mysql_result['password'] . '"/>' . "\n" ;
    echo '    </params>' . "\n";
    echo '    <variables>' . "\n";
    echo '     <variable name="toll_allow" value="' . $mysql_result['toll_allow'] . '"/>' . "\n" ;
    echo '     <variable name="user_context" value="' . $mysql_result['context'] . '"/>' . "\n" ;
    echo '    </variables>' . "\n";
    echo '   </user>' . "\n";
    echo '  </domain>' . "\n";
    echo ' </section>' . "\n";
    echo '</document>' . "\n";
  }