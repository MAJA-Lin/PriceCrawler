
require('locutus/php/var/unserialize');

var app = angular.module('App', []),
    server = "https://safe-shelf-6136.herokuapp.com",
    api = "/book/discount/week/",
    source = "taaze",
    service = server.concat(api.concat(source));

app.controller('Ctrl', ['$scope', '$http', function ($scope, $http) {
    $http.get(service, {withCredentials: true}).then(function(response){
        console.log(response)
            var status = response.data.status,
                data = response.data.data;
            if (status != undefined || status == 'successful') {
                $scope.Data = unserialize(decodeURIComponent(data));
                console.log($scope.Data);

            }
    })
}])
