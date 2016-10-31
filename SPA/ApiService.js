var ApiService = function ($http) {
    var result;

    this.GetApiCall = function (controllerName, methodName, callback) {
        result = $http.get('api.php', {params: {"controller" : controllerName, "method": methodName}}).success(
           function (data, status) {
               var event = {
                   result: data,
                   hasErrors: false
               };
               callback(event);
           }).error(
            function (data, status) {
                var event = {
                    result: "",
                    hasErrors: true,
                    error: data
                };
                callback(event);
            }
        );
    }

    this.PostApiCall = function (controllerName, methodName, obj, callback) {
        result = $http.post('api.php?controller_post=' + controllerName + '&method_post=' + methodName, obj).success(function (data, status) {
            var event = {
                result: data,
                hasErrors: false
            };
            callback(event);
        }).error(function () {
            var event = {
                result: "",
                hasErrors: true,
                error: data
            };
            callback(event);
        });
        return result;
    };

}