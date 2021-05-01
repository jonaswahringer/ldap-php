<?php
require_once 'config.php';

class Model_modify {
    private $entries;
    private $dn;
    private $ds;

    public function __construct() {
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
        if (!ldap_bind($this->ds, config::$LDAPADMIN . '@' . config::$DOMAIN, config::$LDAPPASS)) {
            echo "Bind fehlgeschlagen";
            die("");
        }

        if ($this->ds == false) {
            echo "Keine LDAP Verbindung";
            die("");
        }

        $this->dn = "ou=uebung," . "dc=" . config::$ORGANIZATION;
        $filter = "(cn=*)";
        $sr = ldap_search($this->ds, $this->dn, $filter) or die("Error in search query: " . ldap_error($this->ds));
        $this->entries = ldap_get_entries($this->ds, $sr);
    }

    public function force_user_to_change_pw($index, $name) {
        $dn = "cn=" . $name . "," . $this->dn;
        $userdata = array();
        $userdata["pwdlastset"][0] = 0;
        ldap_modify($this->ds, $dn, $userdata);
    }

    public function change_user_password($username, $new_password) {
        $user = "cn=" . $username . "," . $this->dn;
        $entry = array();
        $entry["userPassword"] = "{SHA}" . base64_encode(pack("H*", sha1($new_password)));

        if (ldap_modify($this->ds, $user, $entry) === false) {
            $message[] = "E201 - Your password cannot be change, please contact the administrator.";
        } 
        else {
            $message[] = " Your password has been changed. ";
        }
    }

    public function get_entries() {
        return $this->entries;
    }

    public function get_users() {
        $data = array();
        $h = 0;
        for ($i = 0; $i < $this->entries["count"]; $i++) {
            if (isset($this->entries[$i]["objectclass"][3])) {
                $data[$h]["name"] = $this->entries[$i]["cn"][0];
                $data[$h]["category"] = $this->entries[$i]["objectclass"][3];
                $h++;
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
