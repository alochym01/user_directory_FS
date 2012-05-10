#create database freeswitch

#create table subscriber tren database freeswitch
#CREATE TABLE subscriber (
#  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,\
#  username CHAR(64) DEFAULT '' NOT NULL,\
#  domain CHAR(64) DEFAULT '' NOT NULL,\
#  context CHAR(64) DEFAULT '' NOT NULL,\
#  callgroup CHAR(64) DEFAULT '' NULL,\
#  password CHAR(25) DEFAULT '' NOT NULL \
#) ENGINE=My;

#insert data into subscriber table
#insert into subscriber(username, domain, context, callgroup, password, toll_allow)\
#value("2000", "172.30.41.154", "default", "", "1234", "local")

<?php

#server localhost
  $server_name = "localhost";

#username de login vao mysql server
  $user_name = "root";

#password of username login
  $password = "";

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
    echo '  <section name="result">' . "\n";
    echo '    <result status="not found">' . "\n";
    echo '  </section>' . "\n";
    echo '</document>' . "\n";
  }

#print the result
  else{
    echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
    echo '<document type="freeswitch/xml">' . "\n";
    echo '  <section name="directory">' . "\n" ;
    echo '    <domain name="' . $_POST['domain']. '">' . "\n" ;
    echo '      <user id="' . $mysql_result['username'] . '">' . "\n" ;
    echo '        <params>' . "\n";
    echo '          <param name="password" value="' . $mysql_result['password'] . '"/>' . "\n" ;
    echo '        </params>' . "\n";
    echo '        <variables>' . "\n";
    echo '          <variable name="toll_allow" value="' . $mysql_result['toll_allow'] . '"/>' . "\n" ;
    echo '          <variable name="user_context" value="' . $mysql_result['context'] . '"/>' . "\n" ;
    if(!$mysql_result['callgroup'])
      echo '          <variable name="callgroup" value="' . $mysql_result['callgroup'] . '"/>' . "\n" ;
    echo '        </variables>' . "\n";
    echo '      </user>' . "\n";
    echo '    </domain>' . "\n";
    echo '  </section>' . "\n";
    echo '</document>' . "\n";
  }

?>


#the request from Freeswitch server(HTTP POST)
#hostname=localhost.localdomain
#section=directory
#tag_name=domain
#key_name=name
#key_value=172.30.41.119
#Event-Name=REQUEST_PARAMS
#Core-UUID=ca887df0-9a89-11e1-9cbb-e59a060b0337
#FreeSWITCH-Hostname=localhost.localdomain
#FreeSWITCH-Switchname=localhost.localdomain
#FreeSWITCH-IPv4=172.30.41.119
#FreeSWITCH-IPv6=%3A%3A1
#Event-Date-Local=2012-05-10%2006%3A23%3A36
#Event-Date-GMT=Thu,%2010%20May%202012%2010%3A23%3A36%20GMT
#Event-Date-Timestamp=1336645416803100
#Event-Calling-File=sofia_reg.c
#Event-Calling-Function=sofia_reg_parse_auth
#Event-Calling-Line-Number=2301
#Event-Sequence=440
#action=sip_auth
#sip_profile=internal
#sip_user_agent=X-Lite%20release%201104o%20stamp%2056125
#sip_auth_username=2000
#sip_auth_realm=172.30.41.119
#sip_auth_nonce=340a4786-9a8a-11e1-9cc0-e59a060b0337
#sip_auth_uri=sip%3A172.30.41.119
#sip_contact_user=2000
#sip_contact_host=172.30.41.241
#sip_to_user=2000
#sip_to_host=172.30.41.119
#sip_from_user=2000
#sip_from_host=172.30.41.119
#sip_request_host=172.30.41.119
#sip_auth_qop=auth
#sip_auth_cnonce=f447f797bf566d867593d8dfaae9c3d6
#sip_auth_nc=00000001
#sip_auth_response=781fbc31af1d51a063e523bafc04f57d
#sip_auth_method=REGISTER
#key=id
#user=2000
#domain=172.30.41.119
#ip=172.30.41.241



# the result which is respone from HTTP server to Freeswitch
#T 127.0.0.1:80 -> 127.0.0.1:48546 [AP]
#HTTP/1.1 200 OK.
#Date: Thu, 10 May 2012 10:23:36 GMT.
#Server: Apache/2.2.15 (CentOS).
#X-Powered-By: PHP/5.3.3.
#Content-Length: 447.
#Connection: close.
#Content-Type: text/html; charset=UTF-8.
#.
#<?xml version="1.0" encoding="utf-8"?>
#<document type="freeswitch/xml">
# <section name="directory">
#   <domain name="172.30.41.119">
#     <user id="2000">
#       <params>
#         <param name="password" value="1234"/>
#       </params>
#       <variables>
#         <variable name="toll_allow" value="local"/>
#         <variable name="user_context" value="default"/>
#       </variables>
#     </user>
#   </domain>
# </section>
#</document>