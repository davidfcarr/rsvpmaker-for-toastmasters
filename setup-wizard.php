<?php
function wp4t_setup_wizard() {
if($_POST['setup_wizard']) {
print_r($_POST);
}

if(empty($_REQUEST['setup_wizard']))
    wpt_setup_wizard_1();
elseif($_REQUEST['setup_wizard'] == '1')
    wpt_setup_wizard_2();
elseif($_REQUEST['setup_wizard'] == '2')
    wpt_setup_wizard_3();
elseif($_REQUEST['setup_wizard'] == '3')
    wpt_setup_wizard_4();
}

function wpt_setup_wizard_1 () {
    ?>
    <h2>Step 1: Meeting Defaults</h2>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
    <p><label>Number of Speakers at a Typical Meeting </label> <select name="numberspeakers">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3" selected="selected">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    </select></p>
    <p><label>Table Topics included ... </label> <select name="tabletopics">
    <option value="before">before speakers</option>
    <option value="after">after speakers, before evaluators</option>
    <option value="end">end of the meeting</option>
    <option value="none">no Table Topics</option>
    </select></p>
    <p><label>Invite Guests to Register Online</label> <input type="radio" name="invite" value="1" checked="checked" /> Yes <input type="radio" name="invite" value="0" > No</p>
    <p><label>Allow Member Data to Sync (see <a href="" target="_blank">blog post</a>)</label> <input type="radio" name="sync" value="1" checked="checked" /> Yes <input type="radio" name="sync" value="0" > No</p>
    <input type="hidden" name="setup_wizard" value="1" />
    <?php submit_button('Next'); ?>
    </form>
    <?php    
}

function wpt_setup_wizard_2 () {
    ?>
    <h2>Invite Other Users</h2>
    <p>It's a good idea to invite a few people who can review what you are doing with the website and join you in experimenting with using the online agenda. When the website is ready, you can invite in all your members.</p>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
<?php for($i = 0; $i < 10; $i++) { ?>
    <p><label>First Name</label> <input type="text" name="first[]" /></p>
    <p><label>Last Name</label> <input type="text" name="last[]" /></p>
    <p><label>Email</label> <input type="text" name="email[]" /></p>
    <p><label>Officer Role</label> <select name="role[]" >
    <option value="">None</option>
    <option value="Webmaster">Webmaster</option>
    <option value="President">President</option>
    <option value="VP of Education">VP of Education</option>
    <option value="VP of Membership">VP of Membership</option>
    <option value="VP of Public Relations">VP of Public Relations</option>
    <option value="Secretary">Secretary</option>
    <option value="Treasurer">Treasurer</option>
    <option value="Sgt. at Arms">Sgt. at Arms</option>
    <option value="Immediate Past President">Immediate Past President</option>
   </select></p>
   <p><label>Security Role</label> <select name="security[]" >
    <option value="">Member</option>
    <option value="Administrator">Administrator</option>
    <option value="Manager">Manager</option>
    <option value="Editor">Editor</option>
    <option value="Author">Author</option>
   </select></p>
<?php
}
?>
    <p><label>My Role</label> <select name="myrole" >
    <option value="">None</option>
    <option value="Webmaster" selected="selected">Webmaster</option>
    <option value="President">President</option>
    <option value="VP of Education">VP of Education</option>
    <option value="VP of Membership">VP of Membership</option>
    <option value="VP of Public Relations">VP of Public Relations</option>
    <option value="Secretary">Secretary</option>
    <option value="Treasurer">Treasurer</option>
    <option value="Sgt. at Arms">Sgt. at Arms</option>
    <option value="Immediate Past President">Immediate Past President</option>
   </select></p>
    <input type="hidden" name="setup_wizard" value="2" />
    <?php submit_button('Next'); ?>
    </form>

<p>Note on security roles: You may want to assign another Administrator who will have security rights equal to your own. A Manager can do most of the same things as an administrator, including adding user accounts, but cannot change the basic settings of the website. An Editor can add and edit pages and blog posts. An author can post to the blog but cannot edit other people's content.</p>

    <?php    
}

function wpt_setup_wizard_3 () {
    ?>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
    <input type="hidden" name="setup_wizard" value="2" />
    <?php submit_button('Next'); ?>
    </form>
    <?php    
}

function wpt_setup_wizard_4 () {
    ?>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
    <input type="hidden" name="setup_wizard" value="2" />
    <?php submit_button('Next'); ?>
    </form>
    <?php    
}