# Getting Started

# Project Management
* [Project Plan](https://docs.google.com/document/d/1J5gbx_r5AXEo8fP5Cc-gDZdNPEhrciXQ1HwtXZO7qik/edit?usp=sharing)
* [Test Plan](https://docs.google.com/document/d/1jE6X7g_JBS8mX1yALYoJKXTXlJXvGhyNrJgicouL614/edit?usp=sharing)
* [API Documentation](https://docs.google.com/document/d/1MG-j3ZsFUWn_ICWLGpF2YUeykQpgX3fJ/edit?usp=sharing&ouid=100255763102801101629&rtpof=true&sd=true)


# Project Information
The project is regarding development of a Web Application which will implement the whole
business process flow regarding the events which is basically to connect people, Registration,
Login and facilitate posting or sharing any videos.
The main goal of this project is connecting people, providing information about the events to the
users whom they know. The user also can share videos, upload images, comment on their
friend’s sharing, chat with them and get informed about other’s activity.

# Prerequisites
* Eclipse IDE
* Oracle Java Development Kit

#Preparing Environment
* [Install Eclipse IDE](https://www.eclipse.org/downloads/packages/installer)
* [Install Java JDK 1.8](https://www.oracle.com/in/java/technologies/javase/javase8-archive-downloads.html)
Download jdk-8u111-windows-i586.exe 

After successfull installation of JDK, You need to configure your environment variables
1. Right click on My Computer
2. Select Properties
3. Select Advanced System Settings
4. Select the Advanced tab
5. Select Environment Variables
6. Select Path under System Variables
7. Click on the Edit button
8. Click on new and paste the entire path of jdk upto bin

	C:\Program Files\Java\jdk1.8.0_111\bin;
Click Ok then Ok again

Restart command prompt otherwise it won't see the change to the path variable

Type java -version in the command prompt. 


#Import Project into Eclipse

* Open Eclipse IDE.
* Click on File.
* Select import -> Existing Maven Project.
* Browse to cloned project directory.
* Click on Finish


#Run the Project
* Run SocialAppApplication.java
Use postman to check the working of api.
 
 
#API
* For like - localhost:8080/send-like
* For comment - localhost:8080/send-comment 



### Guides
The following guides illustrate how to use some features concretely:

* [Using WebSocket to build an interactive web application](https://spring.io/guides/gs/messaging-stomp-websocket/)

