<?php 

#	This File is a connection between Seemalive Pakistan Back End Admin Panel and Your Front End Website.

#	This File is executing all the mysql queries on behalf of which you can get variables that are to be 

#	used in front end to make your website dynamic.

#	Just Place This File in main folder of your website usually (public_html, htdocs) or in sub-directory if website is in other folder.

#	Once you have saved this file you have to call it in every page of your website on which you want to use it.

#	You have to call it on the top of the file by following code (require_once('frontendfile.php');) with in php tags.

#	To configure the database you have to access (controls/ovais.php).

#	Once you have configured the database and you set you are able to access the admin panel then you can use this website to upgrade the values.

#	The Seemalive CMS is developed to enhance the website experience and make it dynamic.

#	We have added predefined modules like:

#	User Management (As an admin you can add a user, edit a user, delete a user, approve a user and ban/unban a user.)

#	The User Module is well enhanced, it can create, modify a user, can send activation code to email address via mail(); 

#	Forgot Password Feature Enabled. (A user can send a request to reset its password via forgot password link. if the email provided is correct and 

#	saved in database a new password will be sent to its email.)

#	Register User : A user can be resistered in two ways :

#		1. An administrator can register it via internal form.

#		2. A registration form is available for the user to register.

#	On form submission the system checks and verifies the email and also checks if this email or username is already registered. if yes the registration is cancelled or you have to use different values.



require_once('controls/ovais.php');

?>



<?php 

########################################################################################

###MAJOR THEME OPTION VARIABLES ARE DEFINED BELOW JUST COPY THEM AND USE IN FRONT END###

########################################################################################

$query_theme = "select * from general_web_options";

$theme_query = mysqli_query($con,$query_theme);

$theme = mysqli_fetch_array($theme_query);

#Copy Following Variable And Use Them as Per Requirement

$Logo = $theme['logo_pic'];

$Logo_Title = $theme['logo_title'];

$Logo_Height = $theme['logo_h'];

$Logo_Width = $theme['logo_w'];

$Logo_CSS = $theme['logo_css'];

$Company = $theme['company_title']; 

$Phone = $theme['phone'];

$Phone2 = $theme['phone2'];

$Fax = $theme['fax'];

$Email = $theme['email'];

$Email2 = $theme['email2'];

$Footer_Copyright = $theme['footer_copyright'];

$Address = $theme['address'];

#For Changing Logo on Front End Use (<img src="admin/upload/<?php echo $theme['logo_pic'];?'>") 





########################################################################################

######SOCIAL LINKS VARIABLES ARE DEFINED BELOW JUST COPY THEM AND USE IN FRONT END######

########################################################################################

$query_social1 = "select facebook,twitter,linkedin,googleplus,skype,emailz from general_web_options";

$query_social = mysqli_query($con,$query_social1);

$social = mysqli_fetch_array($query_social);

#Copy Following Variable And Use Them as Per Requirement

$Facebook = $social['facebook'];

$Twitter = $social['twitter'];

$Google_Plus = $social['googleplus'];

$LinkedIn = $social['linkedin'];

$Skype = $social['skype'];

$Webmail = $social['emailz'];


########################################################################################

###GOOGLE MAP IFRAME CODE VARIABLE IS DEFINED BELOW JUST COPY IT AND USE IN FRONT END###

########################################################################################



$query_map = mysqli_query($con, "select googlemap from general_web_options");

$map = mysqli_fetch_array($query_map);

#Copy Following Variable And Use Them as Per Requirement

$Google_Map = $map['googlemap'];



########################################################################################

######SEO RELATED VARIABLES ARE DEFINED BELOW JUST COPY THEM AND USE IN FRONT END#######

########################################################################################



$query_seo = mysqli_query($con, "select * from static_seo where id='1'");

$seo = mysqli_fetch_array($query_seo);

#Copy Following Variable And Use Them as Per Requirement

$Page_Title = $seo['page_title'];

$Page_Description = $seo['page_description'];

$Page_Author = $seo['page_author'];

$Page_Keywords = $seo['page_keywords'];

$Page_Publisher = $seo['page_publisherid'];





########################################################################################

#####TEAM MEMBERS INFORMATION ARE DEFINED BELOW JUST COPY THEM AND USE IN FRONT END#####

########################################################################################

#Only Those Users can be shown in team that have:

# 1: Approved = '1'

# 2: Banned = '2'

# 3: Team = '1'

########################################################################################

#######Define How many Users you want to show in your team area default is 4 but #######

#######you can change it any time just replace 4 with what ever number you want.########

$Limit = '4'; 

##########################Team Member will be shown in ASC Order########################

$Query_teams = "select 

						full_name,

						user_email,

						photo,

						country,

						address,

						tel,

						website,

						qualification,

						specialization,

						facebook,

						twitter,

						linkedin,

						google,

						experience,

						skills,

						job 

				from users where team='1' and approved='1' and banned='0'";



$query_team = mysqli_query($con,$Query_teams);

###### Create A While Loop in Front End Page and Pass ('$query_team') as argument/input variable.



########################################################################################

#####SHOW DOCTORS INFORMATION ARE DEFINED BELOW JUST COPY THEM AND USE IN FRONT END#####

########################################################################################

#Only Those Users can be shown in team that have:

# 1: Approved = '1'

# 2: Banned = '2'

# 3: Doctor Level = '2'


###### Create A While Loop in Front End Page and Pass ('$query_doc') as argument/input variable.

# while ($doctor = mysqli_fetch_array($query_doc)) {

################################################################################################

##QUERY TO PRINT HOSTING PACKAGES ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE##

################################################################################################

$query_hosting = mysqli_query($con, "select * from hosting_packages where status='1'");

# while ($hosting = mysqli_fetch_array($query_hosting)) {







################################################################################################

##QUERY TO SEND FRONT END CONTACT US FORM DETAILS TO EMAIL OF ADMIN. USE GIVEN INPUT NAME ##

################################################################################################

#the form method must be post and action must be this front end file.

if (isset($_POST['submit'])) { #in front end, the submit button name must be name="contact". 

$name = mysqli_real_escape_string($con,$_POST['sendername']);

$subject = mysqli_real_escape_string($con,$_POST['sendersubject']);

$emailfrom = mysqli_real_escape_string($con,$_POST['emailaddress']);

$message = mysqli_real_escape_string($con,$_POST['sendermessage']);

$telephone = mysqli_real_escape_string($con,$_POST['telephone']);

$admin = "engineer.awaisahmad@gmail.com";

$send = "New Contact Us Form Filled. Details are as under:\n



Name of Person: $name \n

Email of Person : $emailfrom \n

Subject. : $subject \n

Phone No. : $telephone \n

Message : $message ";




 mail($admin, "$Company", $send,



    "From: \"$Company\" <contact@$host>\r\n" .



     "X-Mailer: PHP/" . phpversion()); 







 

$contact_success = "Thanks for Your Valuable Time, Your Details are received, We will be with you soon.";

#you can echo $contact_success on front end so that if the contact form is successful then the user can read the confirmation message.

}



################################################################################################

##QUERY TO PRINT THE PARTNER LOGOS ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_partners = mysqli_query($con, "select * from partners where status='1' order by id DESC");

# while ($partner = mysqli_fetch_array($query_partners)) {







################################################################################################

##QUERY TO PRINT THE HOME SLIDER ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_sliders = mysqli_query($con, "select * from sliders where status='1' order by id DESC");

# while ($slider = mysqli_fetch_array($query_sliders)) {





################################################################################################

##QUERY TO PRINT THE HOME SLIDER ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_albums = mysqli_query($con, "select * from gallery_album where status='1' order by id DESC");

# while ($album = mysqli_fetch_array($query_albums)) {





################################################################################################

##QUERY TO PRINT THE DEPARTMENT ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_departments = mysqli_query($con, "select * from products where status='1' and product_typesid='3' order by id DESC");

# while ($departments = mysqli_fetch_array($query_departments)) {



################################################################################################

##QUERY TO PRINT THE DEPARTMENT ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_rag = mysqli_query($con, "select * from products where status='1' and product_typesid='7' order by id DESC");

# while ($departments = mysqli_fetch_array($query_hl)) {



################################################################################################

##QUERY TO PRINT THE COURSES ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_courses = mysqli_query($con, "select * from post where status='1' and post_categoryid='1' order by id");

# while ($courses = mysqli_fetch_array($query_courses)) {



################################################################################################

##QUERY TO PRINT THE HEALTHY LIVING ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_pcoc = mysqli_query($con, "select * from post where status='1' and post_categoryid='1' order by id DESC limit 3");

# while ($departments = mysqli_fetch_array($query_departments)) {



################################################################################################

##QUERY TO PRINT THE NEWS AND EVENT ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_news = mysqli_query($con, "select * from post where status='1' and post_categoryid='2' order by id DESC");

# while ($news = mysqli_fetch_array($query_news)) {



################################################################################################

##QUERY TO PRINT THE NEWS AND EVENT ON FOOTER. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_newss = mysqli_query($con, "select * from post where status='1' and post_categoryid='2' order by id DESC Limit 3");

# while ($newss = mysqli_fetch_array($query_newss)) {



################################################################################################

##QUERY TO PRINT THE DEPARTMENT ON INDEX PAGE. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_departmen = mysqli_query($con, "select * from products where status='1' and product_typesid='3' order by id DESC Limit 4");

# while ($departmen = mysqli_fetch_array($query_departmen)) {



################################################################################################

##QUERY TO PRINT THE Download ON FRONT END. USE BELOW VARIABLE IN WHILE LOOP ON FRONT PAGE#

################################################################################################

$query_down = mysqli_query($con, "select * from post where status='1' and post_categoryid='2' order by id DESC");

# while ($download = mysqli_fetch_array($query_down)) {



################################################################################################

#QUERY TO PRINT THE CURRENT LOGGED IN USERS. USE BELOW VARIABLE IN WHILE LOOP ON DASHBOARD PAGE#

################################################################################################

$query_loggedin = mysqli_query($con, "select * from users where ckey!='' and ctime!='' order by ctime");

# while ($loggedin = mysqli_fetch_array($query_loggedin)) {



?>



