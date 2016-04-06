function barCtrl($scope, $location, barFactory) {
    $scope.lRange = "";
    $scope.hRange = "";
    $scope.fedStripList = "";
    $scope.buyerList = "";
    setUp();
    clearPage();
    clearPage2();
    clearPage3();
    clearPage4();
    $scope.showAll = true;
    $scope.changeIndex = "";
    $scope.removeRules = [];
    $scope.addModRules = [];
    $scope.saveModRules = [];
    $scope.emptytext = "No rules found.";
    $scope.showMinMaxerror = false;
    $scope.lowRange = "";
    $scope.highRange = "";
    //setTimeout(setUp2(), 10000);

    $scope.searchChoice = function(choice) {
        clearPage();
        clearPage2();
        if (choice == "fedStrip") {
            $scope.showFedStrip = true;
        }
        else {
            $scope.showBuyer = true;
        }
    }

    $scope.submitQuery = function () {
        searchRunning = true;
        addWaitCursor();
        var rulesB = [];
        var rulesS = [];
        var rulesBChange = [];
        var rulesSChange = [];
        var fed = "";
        var buyer = "";
        clearPage2();
        if($scope.fedStripDD != null && $scope.fedStripDD.FEDSTRIP != undefined) {
            fed = ($scope.fedStripDD.FEDSTRIP).substr(0, 4);
            $scope.fsID = true;
            $scope.FEDSTR = fed;
        }
        else if ($scope.fedStripIn != undefined && $scope.fedStripIn != '') {
            fed = $scope.fedStripIn;
            $scope.fsID = true;
            $scope.FEDSTR = fed;
        }
        else if ($scope.BuyerDD != null && $scope.BuyerDD != undefined) {
            buyer = $scope.BuyerDD.NAME;
            $scope.buy = true;
            $scope.buyerName = buyer;
        }
        else if ($scope.buyerlname != undefined && $scope.buyerlname != '') {
            buyer = $scope.buyerlname;
            $scope.buy = true;
            $scope.buyerName = buyer;
        }
        else {

        }
        var apps = barFactory.getQueryResults(fed,buyer);
        apps.then(function(app) {
            removeWaitCursor();
            searchRunning = false;
            if(app.length > 0) {
                if ($scope.buy) {
                    for (var i=0; i<app.length; i++) {
                        if (app[i].RULE_NUM < 3) {
                            $scope.special = true;
                            rulesS.push(app[i]);
                        }
                        else {
                            rulesB.push(app[i]);
                        }
                    }
                    $scope.currentRulesB = rulesB;
                    $scope.currentRulesS = rulesS;
                }
                if ($scope.fsID) {
                    $scope.currentRulesF = app;
                }
                $scope.rulesTable = true;
            }
        });
        var apps2 = barFactory.getChangeResults(fed,buyer);
        apps2.then(function(app2) {
            removeWaitCursor();
            searchRunning = false;
            if(app2.length > 0) {
                if ($scope.buy) {
                    for (var i=0; i<app2.length; i++) {
                        if (app2[i].RULE_NUM < 3) {
                            $scope.special = true;
                            rulesSChange.push(app2[i]);
                        }
                        else {
                            rulesBChange.push(app2[i]);
                        }
                    }
                    $scope.currentRulesBChange = rulesBChange;
                    $scope.buyChange = true;
                    $scope.currentRulesSChange = rulesSChange;
                }
                if ($scope.fsID) {
                    $scope.currentRulesFChange = app2;
                    $scope.fsIDChange = true;
                }
                $scope.rulesTableChange = true;
            }
        });
        if ($scope.lowRange == "") {
            setUp2();
        }
    }

    $scope.changeBuyer = function() {
        $scope.BuyerDD = "";
        $('#changeUserModal').modal('show');
    }

    $scope.buyerChanged = function(buyerChanged) {
        var descr = "";
        var oldBuyer = "";
        for (var i=0; i<$scope.currentRulesB.length; i++) {
            oldBuyer = $scope.currentRulesB[i].USERNAME;
            $scope.currentRulesB[i].USERNAME = buyerChanged.NAME;
            $scope.currentRulesB[i].USERID = buyerChanged.USERID;
            descr = $scope.currentRulesB[i].RULE_DESCRIPTION;
            //$scope.currentRulesB[i].RULE_DESCRIPTION = descr.substr( 0, 1+descr.indexOf("'")) + buyerChanged.USERID + "-" + buyerChanged.NAME + "'";
            $scope.currentRulesB[i].CHANGE_TYPE_TWO = "Old Buyer("+oldBuyer+")";
            $scope.currentRulesB[i].CHANGE_TYPE_ONE = "New Buyer("+buyerChanged.NAME+")";;
        }
        $scope.saveModRules = $scope.currentRulesB;
        $scope.buyerName = buyerChanged.NAME;
        $('#changeUserModal').modal('hide');
        $scope.changesMade = true;
    }

    $scope.changeABuyer = function(index) {
        $scope.changeIndex = index;
        $scope.BuyerDD = "";
        $('#changeAUserModal').modal('show');
    }

    $scope.aBuyerChanged = function(buyerChanged) {
        if (buyerChanged != null) {
            var oldBuyer = $scope.currentRulesF[$scope.changeIndex].USERNAME;
            $scope.currentRulesF[$scope.changeIndex].USERNAME = buyerChanged.NAME;
            $scope.currentRulesF[$scope.changeIndex].USERID = buyerChanged.USERID;
            var descr = $scope.currentRulesF[$scope.changeIndex].RULE_DESCRIPTION;
            //$scope.currentRulesF[$scope.changeIndex].RULE_DESCRIPTION = descr.substr( 0, 1+descr.indexOf("'")) + buyerChanged.USERID + "-" + buyerChanged.NAME + "'";
            $scope.currentRulesF[$scope.changeIndex].CHANGE_TYPE_TWO = "Old Buyer("+oldBuyer+")";
            $scope.currentRulesF[$scope.changeIndex].CHANGE_TYPE_ONE = "New Buyer("+buyerChanged.NAME+")";
            $scope.saveModRules.push($scope.currentRulesF[$scope.changeIndex]);
            $('#changeAUserModal').modal('hide');
            $scope.changesMade = true;
        }
    }

    $scope.changeARange = function(index) {
        $scope.showMinMaxerror = false;
        $scope.minMaxerror = "";
        $scope.minimumChecked = false;
        $scope.maximumChecked = false;
        $scope.maximum = "";
        $scope.minimum = "";
        $scope.changeIndex = index;
        $('#changeRangeModal').modal('show');
    }

    $scope.changedRange = function() {
        var minimum = "";
        var maximum = "";
        if ($scope.minimumChecked) {
            minimum = {number:"0"};
        }
        else {
            minimum = $scope.minimum;
        }
        if ($scope.maximumChecked) {
            maximum = {number:"999999999"};
        }
        else {
            maximum = $scope.maximum;
        }
        if ((minimum == undefined) || (minimum == "")) {
            $scope.showMinMaxerror = true;
            $scope.minMaxerror = "The minimum needs to be filled out";
        }
        else if ((maximum == undefined) || (maximum == "")) {
            $scope.showMinMaxerror = true;
            $scope.minMaxerror = "The maximum needs to be filled out";
        }
        else if (Number(minimum.number) < Number(maximum.number)) {
            $scope.currentRulesF[$scope.changeIndex].LOW_DOLLAR = minimum.number;
            $scope.currentRulesF[$scope.changeIndex].HIGH_DOLLAR = maximum.number;
            var dollarRange = minimum.number + " - " + maximum.number;
            var oldRange = $scope.currentRulesF[$scope.changeIndex].DOLLAR_RANGE;
            $scope.currentRulesF[$scope.changeIndex].DOLLAR_RANGE = dollarRange;
            var descr = $scope.currentRulesF[$scope.changeIndex].RULE_DESCRIPTION;
            //$scope.currentRulesF[$scope.changeIndex].RULE_DESCRIPTION = descr.replace(/[(](\d*|[,]?)*\s[-]?\s(\d*|[,]?)*[)]/,dollarRange);
            $('#changeRangeModal').modal('hide');
            $scope.currentRulesF[$scope.changeIndex].CHANGE_TYPE_TWO = "Old Range("+oldRange+")";
            $scope.currentRulesF[$scope.changeIndex].CHANGE_TYPE_ONE = "New Range("+dollarRange+")";
            $scope.saveModRules.push($scope.currentRulesF[$scope.changeIndex]);
            $scope.changesMade = true;
        }
        else {
            $scope.showMinMaxerror = true;
            $scope.minMaxerror = "The maximum has to be greater then the minimum";
        }
    }

    $scope.addRules = function() {
        var ruleDesc = "";
        if ($scope.currentRulesF.length == 0) {
            ruleDesc = $scope.removeRules[0].RULE_DESCRIPTION;;
        }
        else {
            ruleDesc = $scope.currentRulesF[0].RULE_DESCRIPTION;
        }
        var fed = $scope.FEDSTR;
        $scope.currentRulesF.push({"AGENCY":"FS","RULE_NUM": "","VALID":"Y","DETAIL_NUM": "","RULE_DESCRIPTION": ruleDesc,"RULE":"OR  ShipTo Office Code = "+fed+"","USERID":null,"USERNAME": null,"DOLLAR_RANGE":null,"FEDSTRIP":fed,"AQM_FEDSTRIP": "","FILE_NAME": "","WAVE" :"","NOTES_NAME": "","LOW_DOLLAR":null,"HIGH_DOLLAR":null,"CHANGE_CN":""});
        $scope.addModRules.push({"AGENCY":"FS","RULE_NUM": "","VALID":"Y","DETAIL_NUM": "","RULE_DESCRIPTION": ruleDesc,"RULE":"OR  ShipTo Office Code = "+fed+"","USERID":null,"USERNAME": null,"DOLLAR_RANGE":null,"FEDSTRIP":fed,"AQM_FEDSTRIP": "","FILE_NAME": "","WAVE" :"","NOTES_NAME": "","LOW_DOLLAR":null,"HIGH_DOLLAR":null,"CHANGE_CN":""});
        $scope.changesMade = true;
    }

    $scope.removeRule = function(index) {
        $scope.removeRules.push($scope.currentRulesF[index]);
        $scope.currentRulesF.splice(index, 1);
        $scope.changesMade = true;
    }

    $scope.addRequisitioner = function() {
        clearPage3();
        $('#addRequisitionerModal').modal('show');
    }

    $scope.searchRe = function() { 
        var searchBy = "";
        if ($scope.reqEmail != "") {
            searchBy = $scope.reqEmail;
        }
        else if ($scope.reqLName != "") {
            searchBy = $scope.reqLName;
        }
        var apps = barFactory.getUsers(searchBy);
        apps.then(function(app) {
            if(app.length > 0) {
                $scope.reqTable = true;
                $scope.users = app;
            }
        });
    }

    $scope.reqAdded = function(index) {
        var ffUID = $scope.users[index].FFIS_UID;
        var reqUser = $scope.users[index].LAST_NAME + ", " + $scope.users[index].FIRST_NAME;
        var ruleDesc = $scope.currentRulesS[0].RULE_DESCRIPTION;
        var ruleNum = $scope.currentRulesS[0].RULE_NUM;
        var userID = $scope.currentRulesS[0].USERID;
        var userName = $scope.currentRulesS[0].USERNAME;
        $scope.currentRulesS.push({"AGENCY":"FS","RULE_NUM": ruleNum,"VALID":"Y","DETAIL_NUM": "","RULE_DESCRIPTION": ruleDesc,"RULE":"OR  Requisitioner ID = "+ffUID+"","USERID":userID,"USERNAME": userName,"DOLLAR_RANGE":"0 - 999999999","FEDSTRIP":"","AQM_FEDSTRIP": "","FILE_NAME": "","WAVE" :"","NOTES_NAME": "","LOW_DOLLAR":"0","HIGH_DOLLAR":"999999999","CHANGE_CN":ffUID, "REQUSERID":ffUID, "REQUSER":reqUser});
        $scope.changesMade = true;
        $scope.addModRules.push({"AGENCY":"FS","RULE_NUM": ruleNum,"VALID":"Y","DETAIL_NUM": "","RULE_DESCRIPTION": ruleDesc,"RULE":"OR  Requisitioner ID = "+ffUID+"","USERID":userID,"USERNAME": userName,"DOLLAR_RANGE":"0 - 999999999","FEDSTRIP":"","AQM_FEDSTRIP": "","FILE_NAME": "","WAVE" :"","NOTES_NAME": "","LOW_DOLLAR":"0","HIGH_DOLLAR":"999999999","CHANGE_CN":ffUID, "REQUSERID":ffUID, "REQUSER":reqUser});
        $('#addRequisitionerModal').modal('hide');
    }

    $scope.removeReq = function(index) {
        $scope.removeRules.push($scope.currentRulesS[index]);
        $scope.currentRulesS.splice(index, 1);
        $scope.changesMade = true;
    }

    $scope.saveRules = function() {
        clearPage4();
        var saveRules = "";
        if ($scope.currentRulesF != "") {
            var deltaArray = [];
            for (var i = 0; i < $scope.currentRulesF.length; i++) {
                deltaArray.push($scope.currentRulesF[i].LOW_DOLLAR);
                deltaArray.push($scope.currentRulesF[i].HIGH_DOLLAR);
                if ($scope.currentRulesF[i].LOW_DOLLAR == null || $scope.currentRulesF[i].HIGH_DOLLAR == null) {
                    $scope.saveErrorText = "Need to fill out all the dollar ranges";
                    $scope.success = false;
                    break;
                }
                else if (($scope.currentRulesF[i].USERNAME == null) || ($scope.currentRulesF[i].USERNAME == "")) {
                    $scope.saveErrorText = "Need to fill out all the Buyers";
                    $scope.success = false;
                    break;
                }
                else {
                    $scope.success = true;
                }
            }
            deltaArray.sort(function(a, b){return a-b});
            if ($scope.success == true) {
                if (deltaArray[0] =="0") {
                    if (deltaArray[deltaArray.length -1] == "999999999") {
                        if (deltaArray.length == 2) {
                            $scope.success = true;
                            // for only one rule
                        }
                        else {
                            for (var i = 1; i < deltaArray.length; i=i+2) {
                                if (i == deltaArray.length -1) {
                                    $scope.success = true;
                                    // end of loop
                                }
                                else if (Number(deltaArray[i]) + 1 == Number(deltaArray[i+1])) {
                                    $scope.success = true;
                                    // may just want to do continue instead
                                }
                                else {
                                    $scope.saveErrorText = "Error(s) in the dollar ranges";
                                    $scope.success = false;
                                    break;
                                }
                            }
                        }
                    }
                    else {
                        $scope.saveErrorText = "A rule need to cover 999999999";
                        $scope.success = false;
                    }
                }
                else {
                    $scope.saveErrorText = "A rule need to cover 0";
                    $scope.success = false;
                }
            }
            if ($scope.success == false) {
                $scope.showSaveError = true;
            }
            else {
                saveModRulesFunc($scope.saveModRules);
            }
        }
        if ($scope.currentRulesB != "") {
            saveModRulesFunc($scope.saveModRules);
        }
        if ($scope.currentRulesS != "") {
            saveModRulesFunc($scope.saveModRules);
        }
        for (var i = 0; i < $scope.addModRules.length; i++) {
            console.log("here");
            var apps = barFactory.addRecords($scope.addModRules[i]);
            apps.then(function(app) {
                if(app.length > 0) {
                }
                else {
                    $scope.success = false;
                }
            });
        }
        for (var i = 0; i < $scope.removeRules.length; i++) {
            var apps = barFactory.removeRecords($scope.removeRules[i]);
            apps.then(function(app) {
                if(app.length > 0) {
                }
                else {
                    $scope.success = false;
                }
            });
        }
        if ($scope.success == true) {
            $('#finishModal').modal('show');
            $scope.successMsg = "Your changes have been made"
        }
    }

    function saveModRulesFunc (saveRules) {
        for (var i = 0; i < saveRules.length; i++) {
            var apps = barFactory.saveRecords(saveRules[i]);
            apps.then(function(app) {
                if(app.length > 0) {
                    $scope.success = true;
                }
                else {
                    $scope.success = false;
                }
            });
        }
    }

    function setUp() {
        var apps = barFactory.getLowRanges();
        apps.then(function(app) {
            if(app.length > 0) {
                $scope.lRange = app;
            } 
        });
        var apps2 = barFactory.getHighRanges();
        apps2.then(function(app2) {
            if (app2.length > 0) {
                $scope.hRange = app2;
            } 
        });
        var apps3 = barFactory.getFedStrip();
        apps3.then(function(app3) {
            if(app3.length > 0) {
                $scope.fedStripList = app3;
            }
        });
        var apps4 = barFactory.getBuyers();
        apps4.then(function(app4) {
            if(app4.length > 0) {
                var alist = [];
                //alist = [{"NAME":"All IAS Buyers", "USERID": ""}];
                for (var i=0; i<app4.length; i++) {
                    alist.push(app4[i]);
                }
                $scope.buyerList = alist;
            }
        });
    }

    function setUp2() {
        var low = [];
        var high = [];
        low.push({number: "0"});
        for (var i=0; i<$scope.lRange.length; i++) {
            for (var j=0; j<$scope.hRange.length; j++) {
                if (Number($scope.hRange[j].HIGH_DOLLAR) + 1 == Number($scope.lRange[i].LOW_DOLLAR)) {
                    high.push({number: $scope.hRange[j].HIGH_DOLLAR});
                    low.push({number: $scope.lRange[i].LOW_DOLLAR});
                }
            }
        }
        high.push({number: "999999999"});
        $scope.lowRange = low;
        $scope.highRange = high;
    }

    function clearPage() {
        $scope.showFedStrip = false;
        $scope.showBuyer = false;
        $scope.fedStripDD = "";
        $scope.fedStripIn = "";
        $scope.BuyerDD = "";
        $scope.buyerlname = "";
    }

    function clearPage2() {
        $scope.rulesTable = false;
        $scope.rulesTableChange = false;
        $scope.buy = false;
        $scope.fsID = false;
        $scope.special = false;
        $scope.fsIDChange = false;
        $scope.buyChange = false;
        $scope.changesMade = false;
        $scope.showSaveError = false;
        $scope.currentRulesB = "";
        $scope.currentRulesF = "";
        $scope.currentRulesS = "";
        $scope.currentRulesFChange = "";
        $scope.currentRulesSChange = "";
        $scope.currentRulesBChange = "";
        $scope.buyerName = "";
        $scope.FEDSTR = "";
    }

    function clearPage3() {
        $scope.reqTable = false;
        $scope.reqEmail = "";
        $scope.reqLName = "";
    }

    function clearPage4() {
        $scope.saveErrorText = "";
        $scope.success = false;
        $scope.showSaveError = false;
    }

    function addWaitCursor() {
        $('body').addClass('wait');
        $('body').addClass('pleaseWait');
    }

    function removeWaitCursor() {
        $('body').removeClass('wait');
        $('body').removeClass('pleaseWait');
        //$scope.showAll = true;
    }
}
