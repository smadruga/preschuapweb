<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TesteController extends BaseController
{
    /**
     * constructor
     */
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {

echo 'oi';
echo '<br>';
//LDAP Bind paramters, need to be a normal AD User account.
$ldap_password = '#Int&lbras82!';
$ldap_username = 'EBSERHNET\adm.rcampos';
echo $ldap1 = ldap_connect("10.88.1.31");
echo $ldap2 = ldap_connect("10.88.1.32");
echo '<br>';
if (FALSE !== $ldap1) {
    $ldap_connection = $ldap1;
}
elseif (FALSE !== $ldap2) {
    $ldap_connection = $ldap2;
}
else {
    exit('Unable to connect to the ldap server');
}

echo '<br>';echo '<br>';echo '<br>';echo '<br>';

try {
    #$user = $userModel->find($id);
    $l = ldap_bind($ldap_connection, 'adm.rcampos@ebserh.gov.br', '#Int&lbras82!');
} catch (\Exception $e) {
    die($e->getMessage());
}

echo (TRUE === ldap_bind($ldap_connection, 'adm.rcampos@ebserh.gov.br', '#Int&lbras82!')) ? '1OK!<br>' : '1não<br>';
echo (ldap_bind($ldap_connection, 'campos.rodrigo@ebserh.gov.br', '#Int&&lbr@@s82!2')) ? '1OK!<br>' : '1não<br>';
exit(ldap_bind($ldap_connection, 'campos.rodrigo@ebserh.gov.br', '#Int&&lbr@@s82!1'));
echo '<br>';echo '<br>';echo '<br>';echo '<br>';


// We have to set this option for the version of Active Directory we are using.
ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

#/*
if (TRUE === ldap_bind($ldap_connection, $ldap_username, $ldap_password)) {

    //Your domains DN to query
    $ldap_base_dn = 'OU=Usuarios,OU=HUAP,OU=EBSERH,DC=ebserhnet,DC=ebserh,DC=gov,DC=br';

    //Get standard users and contacts
    #$search_filter = '(|(objectCategory=person)(objectCategory=contact))';
    $search_filter = 'sn=Paula Campos*';

    //Connect to LDAP
    $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);

    if (FALSE !== $result) {
        $entries = ldap_get_entries($ldap_connection, $result);

        // Uncomment the below if you want to write all entries to debug somethingthing
        //var_dump($entries);

        //Create a table to display the output
        echo '<h2>AD User Results</h2></br>';
        echo '<table border = "1"><tr bgcolor="#cccccc"><td>Username</td><td>Last Name</td><td>First Name</td><td>Company</td><td>Department</td><td>Office Phone</td><td>Fax</td><td>Mobile</td><td>DDI</td><td>E-Mail Address</td><td>Home Phone</td></tr>';

        //For each account returned by the search
        for ($x = 0; $x < $entries['count']; $x++) {

            //
            //Retrieve values from Active Directory
            //

            //Windows Usernaame
            $LDAP_samaccountname = "";

            if (!empty($entries[$x]['samaccountname'][0])) {
                $LDAP_samaccountname = $entries[$x]['samaccountname'][0];
                if ($LDAP_samaccountname == "NULL") {
                    $LDAP_samaccountname = "";
                }
            } else {
                //#There is no samaccountname s0 assume this is an AD contact record so generate a unique username

                $LDAP_uSNCreated = $entries[$x]['usncreated'][0];
                $LDAP_samaccountname = "CONTACT_" . $LDAP_uSNCreated;
            }

            //Last Name
            $LDAP_LastName = "";

            if (!empty($entries[$x]['sn'][0])) {
                $LDAP_LastName = $entries[$x]['sn'][0];
                if ($LDAP_LastName == "NULL") {
                    $LDAP_LastName = "";
                }
            }

            //First Name
            $LDAP_FirstName = "";

            if (!empty($entries[$x]['givenname'][0])) {
                $LDAP_FirstName = $entries[$x]['givenname'][0];
                if ($LDAP_FirstName == "NULL") {
                    $LDAP_FirstName = "";
                }
            }

            //Company
            $LDAP_CompanyName = "";

            if (!empty($entries[$x]['company'][0])) {
                $LDAP_CompanyName = $entries[$x]['company'][0];
                if ($LDAP_CompanyName == "NULL") {
                    $LDAP_CompanyName = "";
                }
            }

            //Department
            $LDAP_Department = "";

            if (!empty($entries[$x]['department'][0])) {
                $LDAP_Department = $entries[$x]['department'][0];
                if ($LDAP_Department == "NULL") {
                    $LDAP_Department = "";
                }
            }

            //Job Title
            $LDAP_JobTitle = "";

            if (!empty($entries[$x]['title'][0])) {
                $LDAP_JobTitle = $entries[$x]['title'][0];
                if ($LDAP_JobTitle == "NULL") {
                    $LDAP_JobTitle = "";
                }
            }

            //IPPhone
            $LDAP_OfficePhone = "";

            if (!empty($entries[$x]['ipphone'][0])) {
                $LDAP_OfficePhone = $entries[$x]['ipphone'][0];
                if ($LDAP_OfficePhone == "NULL") {
                    $LDAP_OfficePhone = "";
                }
            }

            //FAX Number
            $LDAP_OfficeFax = "";

            if (!empty($entries[$x]['facsimiletelephonenumber'][0])) {
                $LDAP_OfficeFax = $entries[$x]['facsimiletelephonenumber'][0];
                if ($LDAP_OfficeFax == "NULL") {
                    $LDAP_OfficeFax = "";
                }
            }

            //Mobile Number
            $LDAP_CellPhone = "";

            if (!empty($entries[$x]['mobile'][0])) {
                $LDAP_CellPhone = $entries[$x]['mobile'][0];
                if ($LDAP_CellPhone == "NULL") {
                    $LDAP_CellPhone = "";
                }
            }

            //Telephone Number
            $LDAP_DDI = "";

            if (!empty($entries[$x]['telephonenumber'][0])) {
                $LDAP_DDI = $entries[$x]['telephonenumber'][0];
                if ($LDAP_DDI == "NULL") {
                    $LDAP_DDI = "";
                }
            }

            //Email address
            $LDAP_InternetAddress = "";

            if (!empty($entries[$x]['mail'][0])) {
                $LDAP_InternetAddress = $entries[$x]['mail'][0];
                if ($LDAP_InternetAddress == "NULL") {
                    $LDAP_InternetAddress = "";
                }
            }

            //Home phone
            $LDAP_HomePhone = "";

            if (!empty($entries[$x]['homephone'][0])) {
                $LDAP_HomePhone = $entries[$x]['homephone'][0];
                if ($LDAP_HomePhone == "NULL") {
                    $LDAP_HomePhone = "";
                }
            }

            echo "<tr><td><strong>" . $LDAP_samaccountname . "</strong></td><td>" . $LDAP_LastName . "</td><td>" . $LDAP_FirstName . "</td><td>" . $LDAP_CompanyName . "</td><td>" . $LDAP_Department . "</td><td>" . $LDAP_OfficePhone . "</td><td>" . $LDAP_OfficeFax . "</td><td>" . $LDAP_CellPhone . "</td><td>" . $LDAP_DDI . "</td><td>" . $LDAP_InternetAddress . "</td><td>" . $LDAP_HomePhone . "</td></tr>";
        } //END for loop
    } //END FALSE !== $result

    ldap_unbind($ldap_connection); // Clean up after ourselves.
    echo ("</table>"); //close the table

} //END ldap_bind
#*/
    }


    /**
    * Formulário de Acesso a aplicação web (GET)
    *
    * @return void
    */
    public function index2()
    {

        echo "<h3>LDAP query test</h3>";
        echo "<br><br>Connecting ...";

        #$sr=ldap_search($ds, "o=My Company, c=US", "sn=S*");
        #ldap_search($ds, $dn, $filter, $justthese);
        #$sr=ldap_search($ds, "OU=Usuarios,OU=HUAP,OU=EBSERH,DC=ebserhnet,DC=ebserh,DC=gov,DC=br");
        $dn="OU=Usuarios,OU=HUAP,OU=EBSERH,DC=ebserhnet,DC=ebserh,DC=gov,DC=br";
        $filter="(&(objectClass=user)(objectCategory=person))";
        #$filter="(|(SN=*)(CN=*))";
        $justthese="EBSERHNET\adm.rcampos";

        $ds=ldap_connect("10.88.1.32");  // must be a valid LDAP server!
        echo "<br><br>connect result is " . $ds . "<br />";
#/*
        if ($ds) {
            echo "<br><br>Binding ...";
            $r=ldap_bind($ds, "EBSERHNET\adm.rcampos", "#Int&lbras82!");     // this is an "anonymous" bind, typically
                                   // read-only access
            echo "<br><br>Bind result is " . $r . "<br />";

            $sr=ldap_search($ds, $dn, "sn=Campos*");
            echo "Search result is " . $sr . "<br />";

            echo "Number of entries returned is " . ldap_count_entries($ds, $sr) . "<br />";

            $entry = ldap_first_entry($ds, $sr);
            $attrs = ldap_get_attributes($ds, $entry);
            echo $attrs["count"] . " attributes held for this entry:<p>";

            for ($i=0; $i < $attrs["count"]; $i++) {
                echo $attrs[$i] . "<br />";
            }

            echo "Getting entries ...<p>";
            $info = ldap_get_entries($ds, $sr);
            echo "Data for " . $info["count"] . " items returned:<p>";

            for ($i=0; $i<$info["count"]; $i++) {
                echo "dn is: " . $info[$i]["dn"] . "<br />";
                echo "1>> cn: " . $info[$i]["cn"][0] . "<br />";
                echo "2>> sn: " . $info[$i]["sn"][0] . "<br />";
                echo "3>> c: " . $info[$i]["c"][0] . "<br />";
                echo "4>> l: " . $info[$i]["l"][0] . "<br />";
                echo "5>> st: " . $info[$i]["st"][0] . "<br />";
                echo "6>> name: " . $info[$i]["name"][0] . "<br />";
                echo "8888>> ????: " . $info[$i]["title"][0] . "<br />";
                echo "7>> manager: " . $info[$i]["manager"][0] . "<br /><br /><br /><br />";
            }

            echo "Closing connection";
            ldap_close($ds);
/*
            echo "<br><br>Searching for (sn=S*) ...";
            // Search surname entry

            $sr=ldap_search($ds, $dn, "sn=*Campos*");
            echo "Search result is " . $sr . "<br />";

            echo "Number of entries returned is " . ldap_count_entries($ds, $sr) . "<br />";

            echo "Getting entries ...<p>";
            $info = ldap_get_entries($ds, $sr);
            echo "Data for " . $info["count"] . " items returned:<p>";
#/*
            for ($i=0; $i<$info["count"]; $i++) {
                echo "dn is: " . $info[$i]["dn"] . "<br />";
                echo "first cn entry is: " . $info[$i]["cn"][0] . "<br /><br /><br />";
                #echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
            }

            echo "Closing connection";
            ldap_close($ds);
            #*/

        } else {
            echo "<h4>Unable to connect to LDAP server</h4>";
        }
#*/
        #return view('home/form_login');

    }



    /**
     * User Registration form
     *
     * @return void
     */
    public function index()
    {
        return view('teste/form_teste');
    }

    /**
     * Register User
     *
     * @return void
     */
    public function create() {
        $inputs = $this->validate([
            'name' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[5]|alpha_numeric',
            'confirm_password' => 'required|matches[password]',
            'phone' => 'required|numeric|regex_match[/^[0-9]{10}$/]',
            'address' => 'required|min_length[10]'
        ]);

        if (!$inputs) {
            return view('teste/form_teste', [
                'validation' => $this->validator
            ]);
        }
    }
}
