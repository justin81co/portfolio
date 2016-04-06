var app = angular.module('barApp', []);

app.factory('barFactory', function($http, $q) { 
    return {
        getFedStrip : function() {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_FedStripList.php",
                cache: false
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(0);
            });
            return deferred.promise;
        },

        getBuyers : function() {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_BuyersList.php",
                cache: false
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(0);
            });
            return deferred.promise;
        },

    	getQueryResults : function(fed,name) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_Results.php",
                cache: false,
                params: {"fed": fed, "buyerlastname": name}
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(0);
            });
            return deferred.promise;
        },

        getChangeResults : function(fed,name) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_ChangeResults.php",
                cache: false,
                params: {"fed": fed, "buyerlastname": name}
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(0);
            });
            return deferred.promise;
        },

        getLowRanges : function() {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_LowRanges.php",
                cache: false
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        },

        getHighRanges : function() {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_HighRanges.php",
                cache: false
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        },

        getUsers : function(data) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_UserLastName.php",
                cache: false,
                params: {"data": data}
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        },

        saveRecords : function(data) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_AddRecords.php",
                cache: false,
                params: {"agency" : data.AGENCY, "rule_num" : data.RULE_NUM, "valid": data.VALID, "detail_num" : data.DETAIL_NUM, "rule_description" : data.RULE_DESCRIPTION, "rule": data.RULE, "userid" : data.USERID, "username": data.USERNAME, "dollar_range" : data.DOLLAR_RANGE, "fedstrip" : data.FEDSTRIP, "low_dollar" : data.LOW_DOLLAR, "high_dollar" : data.HIGH_DOLLAR, "file_name" : data.CHANGE_CN, "change_type_one": data.CHANGE_TYPE_ONE, "change_type_two": data.CHANGE_TYPE_TWO}
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        },

        addRecords : function(data) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_AddRecords.php",
                cache: false,
                params: {"agency" : data.AGENCY, "rule_num" : data.RULE_NUM, "valid": data.VALID, "detail_num" : data.DETAIL_NUM, "rule_description" : data.RULE_DESCRIPTION, "rule": data.RULE, "userid" : data.USERID, "username": data.USERNAME, "dollar_range" : data.DOLLAR_RANGE, "fedstrip" : data.FEDSTRIP, "low_dollar" : data.LOW_DOLLAR, "high_dollar" : data.HIGH_DOLLAR, "file_name" : data.CHANGE_CN, "change_type_one": "Insert Condition", "change_type_two": null}
            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        },

        removeRecords : function(data) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: "ajax_AddRecords.php",
                cache: false,
                params: {"agency" : data.AGENCY, "rule_num" : data.RULE_NUM, "valid": data.VALID, "detail_num" : data.DETAIL_NUM, "rule_description" : data.RULE_DESCRIPTION, "rule": data.RULE, "userid" : data.USERID, "username": data.USERNAME, "dollar_range" : data.DOLLAR_RANGE, "fedstrip" : data.FEDSTRIP, "low_dollar" : data.LOW_DOLLAR, "high_dollar" : data.HIGH_DOLLAR, "file_name" : data.CHANGE_CN, "change_type_one": "Delete Condition", "change_type_two": null}

            })
            .success(function(data, status, headers, config) {
                deferred.resolve(data);
            })
            .error(function(data, status, headers, config) {
                deferred.resolve(data);
            });
            return deferred.promise;
        }
    }
});
