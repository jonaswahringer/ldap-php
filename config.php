<?php
class config {
    static $ORGANIZATION = "sz-ybbs,dc=local";
    static $DOMAIN = "sz-ybbs.local";
    static $LDAPHOST = "ldap://192.168.1.1";
    static $LDAPPORT = 389;
    static $MAXUSER = 500;

    static $LDAPADMIN = "Administrator";
    static $LDAPPASS = "htl";
    const BASEDN = "ou=schueler,dc=sz-ybbs,dc=local";
}