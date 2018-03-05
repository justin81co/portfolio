<?php
// TODO: add cute icons
if (!isset ( $_SESSION ["user"] )) {
	echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#login">Login</button>';
}
echo '
<br>
<form class="form-inline" method="post" action="' . htmlspecialchars ( $_SERVER ["PHP_SELF"] ) . '" enctype="application/x-www-form-urlencoded">
    <input type="hidden" name="filter" value="filterSortCommand"/>
    <div  class="form-group">
        <label for="commandFilter"></label>
		<select class="form-control selectpicker" id="commandFilter" name="commandFilter[]" multiple>
            <option value="" selected>Filter group{s)</option>';
if (count ( $variables ["commandGroups"] ) > 0) {
	foreach ( $variables ["commandGroups"] as $value ) {
		echo '
				            <option value=' . $value ["groupname"] . '>' . $value ["groupname"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <br>
    <div  class="form-group">
        <label for="vendorFilter"></label>
		<select class="form-control selectpicker" id="vendorFilter" name="vendorFilter[]" multiple>
            <option value="" selected>Filter vendor(s)</option>';
if (count ( $variables ["commandVendors"] ) > 0) {
	foreach ( $variables ["commandVendors"] as $value ) {
		echo '
				            <option value=' . $value ["vendor"] . '>' . $value ["vendor"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <br>
    <div  class="form-group">
        <label for="regexFilter"></label>
		<select class="form-control selectpicker" id="regexFilter" name="regexFilter[]" multiple>
            <option value="" selected>Filter regex</option>';
if (count ( $variables ["commandRegex"] ) > 0) {
	foreach ( $variables ["commandRegex"] as $value ) {
		echo '
				            <option value=' . $value ["regex"] . '>' . $value ["regex"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <br>
    <div  class="form-group">
        <label for="allowFilter"></label>
		<select class="form-control selectpicker" id="allowFilter" name="allowFilter[]" multiple>
            <option value="" selected>Filter allowability</option>';
if (count ( $variables ["allow"] ) > 0) {
	foreach ( $variables ["allow"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
	</select>
    </div>
    <br>
    <br>
    <div  class="form-group">
        <label for="firstSort"></label>
		<select class="form-control" id="firstSort" name="firstSort">
            <option value="" selected>First Sort</option>';
if (count ( $variables ["sortOn"] ) > 0) {
	foreach ( $variables ["sortOn"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="revFirstSort" name="revFirstSort" value="desc">
             </label>
        </div>
    </div>
    <span class="caret"></span>
    <div  class="form-group">
        <label for="secondSort"></label>
		<select class="form-control" id="secondSort" name="secondSort">
            <option value="" selected>Second Sort</option>';
if (count ( $variables ["sortOn"] ) > 0) {
	foreach ( $variables ["sortOn"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="revSecondSort" name="revSecondSort" value="desc">
            </label>
        </div>
    </div>
    <span class="caret"></span>
    <div  class="form-group">
        <label for="thirdSort"></label>
		<select class="form-control" id="thirdSort" name="thirdSort">
            <option value="" selected>Third Sort</option>';
if (count ( $variables ["sortOn"] ) > 0) {
	foreach ( $variables ["sortOn"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="revThirdSort" name="revThirdSort" value="desc">
            </label>
        </div>
    </div>
    <span class="caret"></span>
    <div  class="form-group">
        <label for="fourthSort"></label>
		<select class="form-control" id="forthSort" name="fourthSort">
            <option value="" selected>Fouth Sort</option>';
if (count ( $variables ["sortOn"] ) > 0) {
	foreach ( $variables ["sortOn"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
        </select>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="revFourthSort" name="revFourthSort" value="desc">
            </label>
        </div>
    </div>
    <span class="caret"></span>
    <button type="submit" class="btn btn-primary">Filter/Sort</button>
    <!--<button type="reset" class="btn btn-default" id="resetCommand" name="resetCommand">Reset</button>-->
</form>
<br>
<form class="form-inline" action="#commands" method="post">
	<input type="hidden" name="search" value="searchCommand"/>
    <div  class="form-group">
    	<label for="commandSearch"></label>
		<input type="text" class="form-control" name="commandSearch" id="commandSearch" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
    <button type="reset" class="btn btn-default hidden" id="resetCommand">Reset</button>
</form>
There are currently ' . count ( $variables ["commands"]) . ' results
<br >
<table class="table table-hover" id="commandsTableHead">
    <thead>
        <tr>
			<th>';
if (isset ( $_SESSION ["user"] )) {
	echo '
				<button type="submit" class="btn btn-warning" onclick="selectAll()" id="selectAll">Select All</button>';
}
echo '		</th>
			<th>';
if (isset ( $_SESSION ["user"] )) {
	echo '
				<button type="button" class="btn btn-danger" onclick="findSelectedCount()">Delete</button>';
}
echo '		</th>
            <th id="groupname">Group</th>
            <th id="vendor">Vendor</th>
            <th id="allow">Allow</th>
            <th id="regex">Created or Edited by</th>
            <th id="regex">Regex</th>
			';
if (isset ( $_SESSION ["user"] )) {
	echo '
		    <th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCommand">Add</button></th>';
    if (count ( $variables ["commands"] ) > 0) {
	    echo '
			<th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cloneCommand" onClick="clearFields()">Group Clone</button></th>';
    }
}
else {
	echo '
			<th></th>
			<th></th>';
}
echo '
            <th><a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Commands_View">Help</a></th>
        </tr>
    </thead>
    <tbody id="commandsTableBody">';
if (count ( $variables ["commands"] ) > 0) {
	foreach ( $variables ["commands"] as $value ) {
		echo '
        <tr>
			<td></td>
			<td>
				<label>
					<input type="checkbox" form="deleteMany" name="deleteArray[]" value="' . $value ["cp_id"] . '">
				</label>
            </td>
            <td>' . $value ["groupname"] . '</td>
            <td>' . $value ["vendor"] . '</td>';
        foreach ( $variables ["allow"] as $value2 ) {
			if ($value2 ["id"] == $value ["allow"]) {
				echo '
        	<td>' . $value2 ["text"] . '</td>';
			}
		}
		echo '
            <td>' . $value ["username"] . '</td>
            <td colspan="3">' . $value ["regex"] . '</td>
			<td>';
		if (isset ( $_SESSION ["user"] )) {
			echo '
	            <button type="button" class="btn btn-warning" onclick="editCommandRow(' . $value ["cp_id"] . ')">Edit</button>';
		}	
		echo '
			</td>
        </tr>';
	}
}
echo '
    </tbody>
</table>';
// Add a Command
echo '
<div class="modal fade" id="addCommand" tabindex="-1" role="dialog" aria-labelledby="addCommandLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" target="_top" onSubmit="return checkUniqueAdd()" action="index.php" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="add" value="addCommand"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addCommandLabel">Add Command Pattern</h4>
                </div>
                <div class="modal-body">
            		<div id="warning" class="hidden">Needs to have unique values for the Group, Regex, and Vendor</div>
                    <div class="form-group">
                        <label for="groupSelect">Group</label>
                        <select class="form-control" id="groupSelect" name="group" required>
                            <option value="" selected>Select a group</option>';
if (count ( $variables ["groupNames"] ) > 0) {
	foreach ( $variables ["groupNames"] as $value ) {
		echo '
				            <option value=' . $value ["groupname"] . '>' . $value ["groupname"] . '</option>';
	}
}
echo '
                        </select>
                    </div>
		            <div class="form-group">
                        <label for="vendorSelect">Vendor</label>
                        <select class="form-control" id="vendorSelect" name="vendor" required>
                            <option value="" selected>Select a vendor</option>';
if (count ( $variables ["vendorNames"] ) > 0) {
	foreach ( $variables ["vendorNames"] as $value ) {
		echo '<option value=' . $value ["vendor"] . '>' . $value ["vendor"] . '</option>';
	}
}
echo '
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="commandInput">Regex</label>
                        <input type="text" class="form-control" id="commandInput" placeholder="Regex" name="command" required>
                        <a href="http://www.regexplained.co.uk">Regex helper</a>
                    </div>
		            <div class="form-group">
                        <label for="allowSelect">Is It Allowed</label>
                        <select class="form-control" id="allowSelect" name="allow" required>
                            <option value="" selected>Is it Allowed</option>';
if (count ( $variables ["allow"] ) > 0) {
	foreach ( $variables ["allow"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
				        </select>
				    </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Commands_Add">Help</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>
';

// Edit a Command
echo '
<div class="modal fade" id="editCommand" tabindex="-1" role="dialog" aria-labelledby="editCommandLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" target="_top" onSubmit="return checkUniqueEdit()" action="index.php" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="edit" value="editCommand"/>
            	<input type="hidden" id="idEdit" name="id" value=""/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editCommandLabel">Edit Command</h4>
                </div>
                <div class="modal-body">
                    <div id="warning" class="hidden">Needs to have unique values for the Group, Regex, and Vendor</div>
                    <div class="form-group">
                        <label for="groupSelectEdit">Group</label>
                        <select class="form-control" id="groupSelectEdit" name="groupEdit" required>';
if (count ( $variables ["groupNames"] ) > 0) {
	foreach ( $variables ["groupNames"] as $value ) {
		echo '
				            <option value=' . $value ["groupname"] . '>' . $value ["groupname"] . '</option>';
	}
}
echo '
                        </select>
                    </div>
		            <div class="form-group">
                        <label for="vendorSelectEdit">Vendor</label>
                        <select class="form-control" id="vendorSelectEdit" name="vendorEdit" required>';
if (count ( $variables ["vendorNames"] ) > 0) {
	foreach ( $variables ["vendorNames"] as $value ) {
		echo '
				            <option value=' . $value ["vendor"] . '>' . $value ["vendor"] . '</option>';
	}
}
echo '
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="commandInputEdit">Regex</label>
                        <input type="text" class="form-control" id="commandInputEdit" placeholder="Regex" name="commandEdit" required>
                        <a href="http://www.regexplained.co.uk">Regex helper</a>
                    </div>
		            <div class="form-group">
                        <label for="allowSelectEdit">Is It Allowed</label>
                        <select class="form-control" id="allowSelectEdit" name="allowEdit" required>';
if (count ( $variables ["allow"] ) > 0) {
	foreach ( $variables ["allow"] as $value ) {
		echo '
				            <option value=' . $value ["id"] . '>' . $value ["text"] . '</option>';
	}
}
echo '
				        </select>
				    </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Commands_Edit">Help</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>
';

// Delete a Command
echo '
<div class="modal fade" id="deleteCommand" tabindex="-1" role="dialog" aria-labelledby="deleteCommandLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" target="_top" action="' . htmlspecialchars ( $_SERVER ["PHP_SELF"] ) . '" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="delete" value="deleteCommand"/>
            	<input type="hidden" id="idDelete" name="idD" value=""/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteCommandLabel">Delete Command</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="groupSelectDelete">Group</label>
            		    <input type="text" class="form-control" id="groupInputDelete" name="groupDelete" readonly>
                    </div>
		            <div class="form-group">
                        <label for="vendorSelectDelete">Vendor</label>
		                <input type="text" class="form-control" id="vendorInputDelete" name="vendorDelete" readonly> 
                    </div>
                    <div class="form-group">
                        <label for="commandInputDelete">Command</label>
                        <input type="text" class="form-control" id="commandInputDelete" name="commandDelete" readonly>
                    </div>
            		<div class="form-group">
                        <label for="allowSelectDelete">Is It Allowed</label>
                        <input type="text" class="form-control" id="allowDelete" readonly>
            		    <input type="hidden" id="allowInputDelete" name="allowDelete" value=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Commands_Delete">Help</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
';
// Clone a group
echo '
<div class="modal fade" id="cloneCommand" tabindex="-1" role="dialog" aria-labelledby="cloneCommandLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" target="_top" action="' . htmlspecialchars ( $_SERVER ["PHP_SELF"] ) . '" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="clone" value="cloneCommand"/>
                <input type="hidden" name="commandData[]" value="" id="commandData"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="cloneCommandLabel">Clone a Group\'s Command</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="groupSelectClone">From Group</label>
                        <select class="form-control" id="groupSelectClone" name="groupClone" onChange="getCommandsForGroup()" required>
            		        <option value="" selected>Select a Group to Clone</option>';
if (count ( $variables ["cloneGroups"] ) > 0) {
	foreach ( $variables ["cloneGroups"] as $value ) {
		echo '
				            <option value=' . $value ["groupname"] . '>' . $value ["groupname"] . '</option>';
	}
}
echo '
                        </select>
                    </div>
                    <div id="clone" class="invisible">
		                <div class="form-group">
			                <label for="commandCloneSelect">Commands to Clone (Hold down the Ctrl (windows) / Command (Mac) button to select multiple options)</label>
				            <select multiple size="10" class="form-control" id="commandsSelectClone" name="commandsClone[]"></select>
				        </div>
			            <div class="form-group">
				            <input type="checkbox" id="commandAllCheck" name="commandAll" > Select All Commands
				        </div>
                    </div>
			        <div class="form-group">
	                    <label for="groupSelectPaste">To Group</label>
	                    <select class="form-control" id="groupSelectPaste" name="groupPaste[]" required multiple size="10">';
if (count ( $variables ["groupNames"] ) > 0) {
	foreach ( $variables ["groupNames"] as $value ) {
		echo '
				            <option value=' . $value ["groupname"] . '>' . $value ["groupname"] . '</option>';
	}
}
echo '
                        </select>
	                </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Commands_Clone">Help</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Clone</button>
                </div>
            </form>
        </div>
    </div>
</div>
';
//Delete many
echo '
<div class="modal fade" id="deleteManyCommand" tabindex="-1" role="dialog" aria-labelledby="deleteManyCommandLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<form class="form-inline" action="#commands" method="post" id="deleteMany">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteCommandLabel">Delete Multiple Rules</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <span id="ruleCount"></span> rules?
					<input type="hidden" name="delete" value="deleteMany"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="Submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
';
//Login
echo '
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">';
$browserString = $_SERVER ['HTTP_USER_AGENT'];
				if (stripos ( $browserString, "Trident" ) !== false) {
					echo '
        	<div class="label label-danger">
            	It appears you\'re using Internet Explorer, which isn\'t the best option for this site. Please visit <a href="http://whatbrowser.org/">http://whatbrowser.org/</a> to find 
another web browser.
        	</div>';
				}
				
				echo '
    		<form method="post" action="' . htmlspecialchars ( $_SERVER ["PHP_SELF"] ) . '" enctype="application/x-www-form-urlencoded autocomplete="on">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="loginLabel">Login</h4>
                </div>
                <div class="modal-body">
        			<input type="hidden" name="login" value="yes"/>
	    			<div class="form-group">
		    			<label for="inputLDAP">NT login</label>
		    			<input type="text" class="form-control" id="LDAPID" placeholder="Lastname.First" name="username" autofocus autocomplete="on">
					</div>
					<div class="form-group">
		    			<label for="inputPassword">Password</label>
		    			<input type="password" class="form-control" id="inputPassword" placeholder="Password" name="current-password" autocomplete="on">
	    			</div>	
				</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Continue</button>
					<a target="_blank" href="http://wiki.level3.com/wiki/NSD_Systems_and_Tools/Applications/ROCi/Admin_Website#Login">Help</a>
                </div>
            </form>
        </div>
    </div>
</div>
';
?>