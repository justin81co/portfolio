<div class="container-fluid barContainer" ng:cloak ng-controller="barCtrl">
    <div class="row-fluid well" ng-show="showAll">
        <h3>IAS Buyer Assignment Rules</h3>

        <p>
            <ul>
                <li>
                    Forest Service IAS Buyer Assignment Rules control Requisition routing in IAS. 
                    Once a Requisition is approved by a Budget Approver, it is routed to a Lead Buyer based on the FedStrip submit to location on the Requisition.
                    The Buyer must be a LEAD Purchasing Agent or a SUPERVISORY Contracting Officer.
                </li>
                <li>
                    This tool will allow you to enter a new rule or change an existing rule for a fedstrip or buyer.
                </li>
                <li>
                    When making a change request you will be required to submit a complete rule that covers every possible dollar range (0 - 999,999,999).
                </li>
            </ul>
            Search by either:
        </p>

        <div class="radio">
            <label>
                <input type="radio" name="searchChoice" id="fedStrips" ng-click="searchChoice('fedStrip')">
                Fedstrip
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="searchChoice" id="buyers" ng-click="searchChoice('buyer')">
                Buyer
            </label>
        </div>

        <div id="fedStrip" ng-show="showFedStrip">
            <form class="form-inline" ng-submit="submitQuery()">
                <div class="form-group">
                    <label for="fedStripIn">Fedstrip: </label>
                    <input type="text" ng-model="fedStripIn" class="form-control" id="fedStripIn" placeholder="Fedstrip">
                </div>
                <button class="btn btn-primary" id="save1" type="submit">Lookup</button>
                <img src="<?php echo COREIMG; ?>preloader.gif" id="numberloader" ng-show="searchRunning" />
            </form>
        </div>

        <div id="buyerForm" ng-show="showBuyer">
            <form ng-submit="submitQuery()" class="form-inline">
                <div class="form-group">
                    <label for="buyerlname">Buyer Last Name: </label>
                    <input type="text" ng-model="buyerlname" id="buyerlname" name="buyerlname" class="form-control" placeholder="Last Name">
                    Or
                    <select ng-model="BuyerDD" id="BuyerDD" ng-options="aBuyer.NAME for aBuyer in buyerList">
                        <option value="">All IAS Buyers</option>
                    </select>
                </div> 
                <button class="btn btn-primary" id="save1" type="submit">Lookup</button>
                <img src="<?php echo COREIMG; ?>preloader.gif" id="numberloader" ng-show="searchRunning" />
            </form>
        </div>

        <h4 ng-show="fsID">Current Rules for Fedstrip {{FEDSTR}}</h3>
        <h4 ng-show="buy">Current Rules for Buyer {{buyerName}}</h3>

        <div ng-show="buy">
            <button class="btn btn-primary" id="changeBuyer" type="button" ng-click="changeBuyer()">Change Buyer</button>
        </div>

        <br />
        <br />

        <table ng-show="rulesTable" class="table table-striped table-condensed table-responsive table-hover'">
            <thead>
                <tr>
                    <th ng-show="fsID">Buyer</th>
                    <th ng-show="buy">Fed Strip</th>
                    <th>Dollar Range</th>
                </tr>
            </thead>
            <tbody>

                <tr ng-show="fsID" ng-repeat="f in currentRulesF" ng-model="fedTable">
                    <td ng-click="changeABuyer($index)">{{f.USERNAME}}</td>
                    <td ng-click="changeARange($index)">{{f.LOW_DOLLAR}} - {{f.HIGH_DOLLAR}}</td>
                    <td>
                        <button class="btn btn-primary" id="removeRule" type="button" ng-click="removeRule($index)">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Rule
                        </button>
                    </td>
                </tr>

                <tr ng-show="buy" id="buyerTable" ng-repeat="b in currentRulesB" ng-model="buyTable">
                    <td>{{b.FEDSTRIP}}</td>
                    <td>{{b.LOW_DOLLAR}} - {{b.HIGH_DOLLAR}}</td>
                </tr>

            </tbody>
        </table>

        <button ng-show="fsID" class="btn btn-primary" id="addRules" type="button" ng-click="addRules()">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Rule
        </button>
        <br />
        <br />
        <!-- <button ng-show="rulesTable" class="btn btn-primary" id="showChangeR" type="button" ng-click="showChangeRequests()">
             Show Change Requests in Process
        </button> -->
        <div ng-show="rulesTableChange">
            <h4 ng-show="fsIDChange">Change Requests in Process for Fedstrip {{FEDSTR}}</h3>
            <h4 ng-show="buyChange">Change Requests in Process for Buyer {{buyerName}}</h3>
            <br />
            <br />
        </div>
        <table ng-show="rulesTableChange" class="table table-striped table-condensed table-responsive table-hover'">
            <thead>
                <tr>
                    <th ng-show="fsID">Buyer</th>
                    <th ng-show="buy">Fed Strip</th>
                    <th>Dollar Range</th>
                    <th>Requested By</th>
                    <th>Change Type</th>
                </tr>
            </thead>
            <tbody>

                <tr ng-show="fsID" ng-repeat="fc in currentRulesFChange" ng-model="fedTable">
                    <td>{{fc.USERNAME}}</td> <!-- ng-click="changeABuyer($index)" -->
                    <td>{{fc.LOW_DOLLAR}} - {{fc.HIGH_DOLLAR}}</td> <!-- ng-click="changeARange($index)" -->
                    <td>{{fc.REQUESTED_BY}}</td>
                    <td>{{fc.CHANGE_TYPE_ONE}}</td>
                    <!-- <td>
                        For future use maybe <button class="btn btn-primary" id="removeRule" type="button" ng-click="removeRule($index)">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Rule
                        </button>
                    </td> -->
                </tr>

                <tr ng-show="buy" id="buyerTableChange" ng-repeat="bc in currentRulesBChange" ng-model="buyTable">
                    <td>{{bc.FEDSTRIP}}</td>
                    <td>{{bc.LOW_DOLLAR}} - {{bc.HIGH_DOLLAR}}</td>
                    <td>{{bc.REQUESTED_BY}}</td>
                    <td>{{bc.CHANGE_TYPE_ONE}}</td>
                </tr>

            </tbody>
        </table>

        <div ng-show="special">
            <br />
            <br />
            <button class="btn btn-primary" id="addRequisitioner" type="button" ng-click="addRequisitioner()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Requisitioner</button>
            <table class="table table-striped table-condensed table-responsive table-hover'">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>

                    <tr id="requisitionerTable" ng-repeat="s in currentRulesS" ng-model="buyTable">
                        <td>{{s.REQUSERID}}</td>
                        <td>{{s.REQUSER}}</td>
                        <td>
                            <button class="btn btn-primary" id="removeReq" type="button" ng-click="removeReq($index)">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Rule
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div ng-show="specialChange">
            <table class="table table-striped table-condensed table-responsive table-hover'">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User</th>
                        <th>Requested By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="requisitionerTableChange" ng-repeat="sc in currentRulesSChange" ng-model="requisitionerTableChange">
                        <td>{{sc.REQUSERID}}</td>
                        <td>{{sc.REQUSER}}</td>
                        <td>{{sc.REQUESTED_BY}}</td>
                        <!-- <td>
                            <button class="btn btn-primary" id="removeReq" type="button" ng-click="removeReq($index)">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Rule
                            </button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
   
        <div ng-show="empty">
            <h4>{{emptytext}}</h4>
        </div>
        <br />

        <button ng-show="changesMade" class="btn btn-primary" id="changesMade" type="button" ng-click="saveRules()">
            Save Changes
        </button>

        <div ng-show="showSaveError">
            {{saveErrorText}}
        </div>

    </div>

    <div class="modal fade" role="dialog" id="changeUserModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aira-hidden="true">&times;</button>
                    <h3>Change All Buyers</h3>
                </div>
                <div class="modal-body">
                    <select ng-model="buyerChangeDD" id="buyerChangeDD" ng-options="aBuyer.NAME for aBuyer in buyerList">
                        <option value="">All IAS Buyers</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <a class="btn" ng-click="buyerChanged(buyerChangeDD)">Change</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="changeAUserModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aira-hidden="true">&times;</button>
                    <h3>Change A Buyer</h3>
                </div>
                <div class="modal-body">
                    <select ng-model="aBuyerChangeDD" id="aBuyerChangeDD" ng-options="aBuyer.NAME for aBuyer in buyerList">
                        <option value="">All IAS Buyers</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" ng-click="aBuyerChanged(aBuyerChangeDD)" type="submit">Change</a>
                    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
        <button ng-show="changesMade" type="button" class="btn btn-default" ng-click="saveRules()">Save Changes</button>
    </div>

    <div class="modal fade" role="dialog" id="changeRangeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aira-hidden="true">&times;</button>
                    <h3>Change The Range for A Rule</h3>
                </div>
                <div class="modal-body">
                    <form ng-submit="changedRange()" class="form-inline" name="changeRange">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="minimumChecked"> Min
                            </label>
                        </div>
                        <select ng-model="minimum" id="minimum" ng-options="num.number for num in lowRange">
                        </select>
                        to 
                        <select ng-model="maximum" id="maximum" ng-options="num.number for num in highRange">
                        </select>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="maximumChecked"> Max
                            </label>
                        </div>
                        <div ng-show="showMinMaxerror" class="alert alert-danger">
                            {{minMaxerror}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="changedRange()" type="submit">Change</button>
                    <a href="#" class="btn" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="addRequisitionerModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aira-hidden="true">&times;</button>
                    <h3>Add Requisitioner</h3>
                </div>
                <div class="modal-body">
                    <form ng-submit="searchRe()" class="form-inline" name="searchRec">
                        <label for="reqLName">Search by Last Name: </label>
                        <input type="text" ng-model="reqLName" id="reqLName" name="reqLName" class="form-control" placeholder="Last Name">
                        Or
                        <label for="reqEmail">Search by Email: </label>
                        <input type="text" ng-model="reqEmail" id="reqEmail" name="reqEmail" class="form-control" placeholder="Email">
                        <button class="btn btn-primary" id="searchRecSub" type="submit">Lookup</button>
                    </form>
                </div>
                <table ng-show="reqTable" class="table table-bordered table-striped table-condensed table-responsive table-hover'">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="reqTable" ng-repeat="s in users" ng-model="userTable">
                            <td>{{s.FIRST_NAME}}</td>
                            <td>{{s.LAST_NAME}}</td>
                            <td>{{s.E_MAIL}}</td>
                            <td>
                                <button class="btn btn-primary" id="reqAdded" type="button" ng-click="reqAdded($index)">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    <br />Rule
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="finishModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aira-hidden="true">&times;</button>
                    <h3>Change submitted</h3>
                </div>
                <div class="modal-body">
                    {{successMsg}}
                </div>
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include_once("../bg.php"); ?>
