'use strict';

angular.
module('NewsApp').
component('newsList', {
    templateUrl:  '/app_dev.php/ru/news_list',
    controller: function NewsListController($scope, $http) {
        var self = this;

        var totalItems;
        $http.get('/app_dev.php/ru/getJsonNews').success(function(data) {
            $scope.news = data;
            $scope.totalItems = data.all;
            $scope.currentPage = 1;
            $scope.itemsPerPage = $scope.viewby;
            $scope.totalPages = Math.ceil($scope.totalItems / 10);
            totalItems = $scope.totalItems;
            var it = $scope.locale;
            var item = $scope.currentPage;
        });

        $scope.setPage = function (pageNo) {
            $scope.currentPage = pageNo;
        };

        var jsonContent = {};
        $scope.viewby = function (countNews) {
            if ((countNews === 0) || (countNews === totalItems)) {
                $scope.disabled = true;
            }
            else {
                $scope.disabled = false;
            }
            if(typeof jsonContent[countNews] === 'undefined') {
                $http.get('/app_dev.php/ru/getJsonNews/'+countNews).success(function(data) {
                    $scope.news = data;
                    jsonContent[countNews] = data;
                    console.log('Вызвана функция, значение - ' + countNews);
                });
            }
            else {
                $scope.news = jsonContent[countNews];
            }
        }
    }
});

