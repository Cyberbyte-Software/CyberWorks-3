# CyberWorks 3

[![discord](https://img.shields.io/badge/Discord-Join-7289DA.svg)](https://discord.gg/qHsTEhY)

CyberWorks 3 is one of our many rewrites of CyberWorks to make it more usable. It was originally designed for [Critical Gaming](https://criticalgaming.org/) and we have since decided to open source it after removing the custom content. We __highly__ recommend you use this version and not our original CyberWorks as we intent to maintain this version.

## Features
CyberWorks 3 was designed to have all the features as our original but be much more maintainable and secure. You can view all screenshots on [imgur](https://imgur.com/a/wq9Ue). A small list is below:

- [Group editing and permissions](https://i.imgur.com/GWWqkkF.png)
- Action audit log
- [Player editing](https://i.imgur.com/8myqjVX.png)
    - Licence editing
    - Level editing
    - Notes system
- [Metrics and Statistics](https://i.imgur.com/2KfoWbc.png)
- [Vehicle editing](https://i.imgur.com/5mSML9O.png)
- [Auto installer](https://i.imgur.com/3b908i2.png)
- [Dashboard](https://i.imgur.com/SgO4yky.png)


## Installation
Below are the installation guides for various different setups. If you have any problems feel free to reach out using our Discord.

### Requirements
- PHP > 7.0
- mbstring
- [Composer](https://getcomposer.org/) (if not using built release)
- Altis Life 5 or newer

### Using the installer
You will need to first complete the steps below to setup your environment then visit `/installer.php`. Enter your database details for it to generate the configs.


### Linux
We always recommend running PHP on linux and do all of our testing on linux environments. (Also because Linux is better)

#### Docker
We recommend you deploy CyberWorks 3 to your own servers using docker. We have included a `docker-compose.yml` which will allow you to get started quickly. All you need to do is install [docker](https://docs.docker.com/engine/installation/) and [docker-compose](https://docs.docker.com/compose/install/) and run the following command.
   
    wget https://github.com/Cyberbyte-Studios/CyberWorks-3/releases cyberworks.zip
    unzip cyberworks.zip
    docker-compose up
    
This should work out of the box and might also work on other operating systems.

#### Shared hosting
The application should work on shared hosting such as cPanel as long as they support PHP 7 or above. All you will need to do is upload the files into your webroot and then follow the installer instructions above.
IF there is enough interest we might setup preconfigured Cyberworks hosting. Contact us for more details.

#### Manually
A guide will be written shortly. Basicly you want to install PHP 7 and Nginx in a standard setup.

### Windows
The platform should be compatible with IIS web server. We are looking to make a guide on how to use this and would like people who are interested in helping us get in contact though Discord.


[![Cyberbyte Studios](https://i.imgur.com/qeXU9CH.png)](https://cyberbyte.org.uk/)

This project is maintained by [CyberByte Studios](https://cyberbyte.org.uk/). Follow us on [twitter](https://twitter.com/cyberbytestudio). Commercial support is available contact sam@cyberbyte.org.uk or cameron@cyberbyte.org.uk.
