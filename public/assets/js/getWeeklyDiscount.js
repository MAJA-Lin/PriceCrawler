var app = angular.module('App', []),
    server = "https://safe-shelf-6136.herokuapp.com",
    api = "/book/discount/week/",
    source = [
        "taaze",
        "bookscom",
        "sanmin",
        "iread"
    ],
    unserialize = require('locutus/php/var/unserialize'),
    phpUnserialize = require('phpUnserialize/phpUnserialize');

app.controller('Ctrl', ['$scope', '$http', function ($scope, $http) {
    $scope.Data = [];

    for (val of source) {
        var service = server.concat(api.concat(val));

        $http.get(service, {withCredentials: true}).then(function(response){
            console.log(response)
                var status = response.data.status,
                    data = response.data.data;
                if (status != undefined || status == 'successful') {
                    if (val == "iread") {
                        var clearData = phpUnserialize(decodeURIComponent(data));
                    } else {
                        var clearData = unserialize(decodeURIComponent(data));
                    }

                    $scope.Data.push(clearData);
                    console.log($scope.Data);
                }
        })
    }
}])
