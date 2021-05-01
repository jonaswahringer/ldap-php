<?php
require_once('config.php');

class Model{
    private $entries;
    private $dn;
    private $ds;

    public function __construct(){
        $this->ds = ldap_connect(config::$LDAPHOST, config::$LDAPPORT) or die('not connected');
        if (!ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
            echo "failed protocol version";
            ldap_close($this->ds);
            die("");
        }    
        if (!ldap_set_option($this->ds, LDAP_OPT_REFERRALS, 0)) {
            echo "failed referalls option";
            ldap_close($this->ds);
            die("");
        } 
        if(!ldap_bind($this->ds, config::$LDAPADMIN . '@' . config::$DOMAIN, config::$LDAPPASS)) {
            echo "Bind fehlgeschlagen";
            die("");
        }

        if ($this->ds == FALSE) {
            echo "Keine LDAP Verbindung";
            die("");
        }
    
        $this->dn = "ou=uebung," . "dc=" . config::$ORGANIZATION;
        $filter = "(cn=*)";
        $sr = ldap_search($this->ds, $this->dn, $filter) or die ("Error in search query: ".ldap_error($this->ds));
        $this->entries = ldap_get_entries($this->ds, $sr);
    }

    public function get_entries(){
        return $this->entries;
    }

    public function get_users_and_groups(){
        $data = array();
        for($i=0;$i<$this->entries["count"];$i++){
            $data[$i]["name"] = $this->entries[$i]["cn"][0];
            if(isset($this->entries[$i]["objectclass"][1])){
                $data[$i]["category"] = $this->entries[$i]["objectclass"][1];
            }
            if(isset($this->entries[$i]["objectclass"][3])){
                $data[$i]["category"] = $this->entries[$i]["objectclass"][3];
            }
            
        }
        return $data;
    }

    public function get_dn() {
        return $this->dn;
    }

    public function get_ds() {
        return $this->ds;
    }

    public function cut_connection() {
        ldap_close($this->ds);
    }
}