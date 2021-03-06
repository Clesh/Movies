'use strict';

/* Controllers */

(function(){

    var app = angular.module('cleshFilm.controllers', [ 'truncate', 'angularFileUpload' ]);

    app.controller('HatCtr', ['$scope', '$route', function($scope,$route) {
        var self = this;
        self.activeTab = undefined;

        $scope.$on('$routeChangeSuccess', function(event,current) {
            self.activeTab = current.$$route === undefined ? undefined : current.$$route.activeTab;
        });

        self.isActive = function(tabName)
        {
            return tabName == self.activeTab;
        };
    }]);

    app.controller('HomePageCtrl', ['$scope', function($scope) {

    }]);

    app.controller('MoviePageCtrl', ['$scope', '$http', '$timeout', function($scope,$http,$timeout) {
        var self = this;
        self.movies = [];
        // This is what you will bind the filter to
        self.filterSearchQuery = '';

        $http.get('./json/main-movies-list.json').success(function(data){
            self.movies = data;
            //$scope.movies = data;
        });

        /*$http.get('/app/json/all-movies-list.json').success(function(data){
            self.movies = data;
            //$scope.movies = data;
        });*/



        // Instantiate these variables outside the watch
        var tmpFilterSearchQuery = '',filterSearchQueryTimeout;
        $scope.$watch('searchQuery', function (val) {
            if (filterSearchQueryTimeout)
                $timeout.cancel(filterSearchQueryTimeout);

            tmpFilterSearchQuery = val;

            filterSearchQueryTimeout = $timeout(function() {
                self.filterSearchQuery = tmpFilterSearchQuery;
            }, 250); // delay 250 ms
        });

        self.getRowMoviesNum = function () {
            return 4;
        };

        self.calculateIndex = function (index, parent) {
            return index + parent * self.getRowMoviesNum();
        };

        self.removeMovie = function (index) {
            //$scope.movies.splice(index,1);
            //$scope.movies.push({ name: 'new', thumbUrl: 'lool'});
            //console.log(self.movies[index].name);
            self.movies.splice(index,1);
        };


    }]);

    app.controller('MovieEditCtrl', ['$scope', '$http', '$routeParams', function($scope,$http,$routeParams) {
        var self = this;
        self.movieId = $routeParams.movieId;
        self.movie = { };

        $http.get('./json/spider-man-movie.json').success(function (data) {
            self.movie = data;
        });

    }]);

    app.controller('MovieAddSuccessCtrl', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        var self = this;
        self.movieId = $routeParams.movieId;
        $scope.movie = {};

        $http.get('./json/spider-man-movie.json').success(function (data) {
            $scope.movie = data;
        });

    }]);


    app.controller('MovieAddFormCtrl',['$scope', '$http', '$routeParams', '$location', '$timeout', '$filter',
        function ($scope, $http, $routeParams, $location, $timeout, $filter)
        {
            var self = this;

            self.movie = {
                image : {},
                crew : [
                    { staffId:null,professionId:null }
                ]
            };
            self.tmpData = {
                imagePreViewUrl : ""
            };
            self.images = [];
            self.professions = [];
            self.staff = [];
            self.showForm = true;
            self.showImageContainer = true;
            self.showLoadMoreBtn = true;
            self.filterImageSearchQuery = '';


            $http.get('./json/all-professions-list.json').success(function (data) {
                self.professions = data;
                self.broadcastDataLoaded();
            });

            $http.get('./json/all-stuff-list.json').success(function (data) {
                self.staff = data;
                self.broadcastDataLoaded();
            });


            // Instantiate these variables outside the watch
            var tmpFilterSearchQuery = '',filterSearchQueryTimeout;
            $scope.$watch('imageSearchQuery', function (val) {
                if (filterSearchQueryTimeout)
                    $timeout.cancel(filterSearchQueryTimeout);

                tmpFilterSearchQuery = val;

                filterSearchQueryTimeout = $timeout(function() {
                    self.filterImageSearchQuery = tmpFilterSearchQuery;
                }, 250); // delay 250 ms
            });

            self.addStaffMember = function () {
                self.movie.crew.push({ staffId:null,professionId:null });
                $timeout(function () {
                    self.broadcastDataLoaded();
                },0,false);
            };

            self.removeStaffMember = function (index) {
              self.movie.crew.splice(index,1);
            };

            self.broadcastDataLoaded = function () {
                if(!self.professions.length || !self.staff.length)
                    return;
                $scope.$broadcast('dataloaded');
            };

            self.getRowNum = function () {
                return 3;
            };

            self.chooseImg = function (id) {
                var tmpImg = $filter('filter')(self.images, { "id": id }, true)[0];
                //self.movie.image = $filter('filter')(self.images, { "id": id }, true)[0];
                self.movie.imageId = id;
                self.toggleImageContainer();
                self.tmpData.imagePreViewUrl = tmpImg.thumbUrl;
                $scope.addMovieForm.$setDirty();
                //$scope.addMovieForm.movieImageId.$setValidity('required', true);
                //console.log(self.movie.image);
            };

            self.refreshImagesList = function () {
                $http.get('./json/all-images-list.json').success(function (data) {
                    self.images = data;
                    self.showLoadMoreBtn = true;
                });
            };

            self.loadMoreImages = function () {
                $http.get('./json/additional-images-list.json').success(function (data) {
                    //self.images = data;
                    for(var i =0; i != data.length; i++)
                    {
                        self.images.push(data[i]);
                    }
                    self.showLoadMoreBtn = false;
                });
            };

            self.toggleImageContainer = function () {
                var $cont = $('#imagesContainer');
                if(self.showImageContainer)
                {
                    $cont.slideUp("slow");
                    self.showImageContainer = false;
                    return;
                }
                $cont.slideDown("slow");
                self.showImageContainer = true;
            };

            self.submitForm = function () {
                console.log("Form submit");
                self.showForm = false;
                self.movie.id = "1";
                $location.path("movies/add/success/"+self.movie.id);
            };

            self.refreshImagesList();

            //$("select[name='herolist']").selectpicker({style: 'btn-primary', menuStyle: 'dropdown-inverse'});
            //$('#imagesContainer').slideUp();
    }]);


    app.controller('ImagesPageCtrl', ['$scope', '$http', '$timeout', 'Image', function($scope,$http,$timeout,Image) {
        var self = this;
        self.images = [];
        // This is what you will bind the filter to
        self.filterSearchQuery = '';

        self.images = Image.query(function () {
            console.log("Query callback",self.images.length);
        });

        /*$http.get('/app/json/all-images-list.json').success(function(data){
            self.images = data;
            //$scope.movies = data;
        });*/

        /*$http.get('/app/json/all-movies-list.json').success(function(data){
         self.movies = data;
         //$scope.movies = data;
         });*/



        // Instantiate these variables outside the watch
        var tmpFilterSearchQuery = '',filterSearchQueryTimeout;
        $scope.$watch('searchQuery', function (val) {
            if (filterSearchQueryTimeout)
                $timeout.cancel(filterSearchQueryTimeout);

            tmpFilterSearchQuery = val;

            filterSearchQueryTimeout = $timeout(function() {
                self.filterSearchQuery = tmpFilterSearchQuery;
            }, 250); // delay 250 ms
        });

        self.getRowNum = function () {
            return 3;
        };

        self.calculateIndex = function (index, parent) {
            return index + parent * self.getRowNum();
        };

        self.removeImage = function (index) {
            //$scope.movies.splice(index,1);
            //$scope.movies.push({ name: 'new', thumbUrl: 'lool'});
            //console.log(self.movies[index].name);
            self.images.splice(index,1);
        };


    }]);


    app.controller('ImageEditCtrl', ['$scope', '$http', '$routeParams', '$sce', '$filter', function($scope,$http,$routeParams,$sce,$filter) {
        var self = this;
        self.imageId = $routeParams.imageId;
        //var tmp = $sce.trustAsUrl($filter('doubleDecodeUri')($routeParams.returnPath));
        self.returnPath = $routeParams.returnPath || '#/images';
        self.image = { };

        $http.get('./json/super-girl-image.json').success(function (data) {
            self.image = data;
        });

        $scope.selected = function(x) {
            console.log("selected",x);
        };

        $scope.trustSrc = function(src) {
            return $sce.trustAsResourceUrl(src);
        }

    }]);


    app.controller('ImageUploadCtrl', function ($scope, $fileUploader) {
        // Creates a uploader
        var uploader = $scope.uploader = $fileUploader.create({
            scope: $scope,
            url: 'upload.php'
        });


        // ADDING FILTERS

        // Images only
        uploader.filters.push(function(item /*{File|HTMLInputElement}*/) {
            var type = uploader.isHTML5 ? item.type : '/' + item.value.slice(item.value.lastIndexOf('.') + 1);
            type = '|' + type.toLowerCase().slice(type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
        });


        // REGISTER HANDLERS

        uploader.bind('afteraddingfile', function (event, item) {
            console.info('After adding a file', item);
        });

        uploader.bind('whenaddingfilefailed', function (event, item) {
            console.info('When adding a file failed', item);
        });

        uploader.bind('afteraddingall', function (event, items) {
            console.info('After adding all files', items);
        });

        uploader.bind('beforeupload', function (event, item) {
            console.info('Before upload', item);
        });

        uploader.bind('progress', function (event, item, progress) {
            console.info('Progress: ' + progress, item);
        });

        uploader.bind('success', function (event, xhr, item, response) {
            console.info('Success', xhr, item, response);
        });

        uploader.bind('cancel', function (event, xhr, item) {
            console.info('Cancel', xhr, item);
        });

        uploader.bind('error', function (event, xhr, item, response) {
            console.info('Error', xhr, item, response);
        });

        uploader.bind('complete', function (event, xhr, item, response) {
            console.info('Complete', xhr, item, response);
        });

        uploader.bind('progressall', function (event, progress) {
            console.info('Total progress: ' + progress);
        });

        uploader.bind('completeall', function (event, items) {
            console.info('Complete all', items);
        });
    });


    app.controller('ProfessionsPageCtrl', ['$scope', '$http', '$timeout', function($scope,$http,$timeout) {
        var self = this;
        self.professions = [];
        // This is what you will bind the filter to
        self.filterSearchQuery = '';

        $http.get('./json/all-professions-list.json').success(function(data){
            self.professions = data;
            //$scope.movies = data;
        });

        /*$http.get('/app/json/all-movies-list.json').success(function(data){
         self.movies = data;
         //$scope.movies = data;
         });*/



        // Instantiate these variables outside the watch
        var tmpFilterSearchQuery = '',filterSearchQueryTimeout;
        $scope.$watch('searchQuery', function (val) {
            if (filterSearchQueryTimeout)
                $timeout.cancel(filterSearchQueryTimeout);

            tmpFilterSearchQuery = val;

            filterSearchQueryTimeout = $timeout(function() {
                self.filterSearchQuery = tmpFilterSearchQuery;
            }, 250); // delay 250 ms
        });


        self.removeProfession = function (index) {
            //$scope.movies.splice(index,1);
            //$scope.movies.push({ name: 'new', thumbUrl: 'lool'});
            //console.log(self.movies[index].name);
            self.professions.splice(index,1);
        };


    }]);


    app.controller('StuffPageCtrl', ['$scope', '$http', '$timeout', function($scope,$http,$timeout) {
        var self = this;
        self.stuff = [];
        // This is what you will bind the filter to
        self.filterSearchQuery = '';

        $http.get('./json/all-stuff-list.json').success(function(data){
            self.stuff = data;
            //$scope.movies = data;
        });

        /*$http.get('/app/json/all-movies-list.json').success(function(data){
         self.movies = data;
         //$scope.movies = data;
         });*/



        // Instantiate these variables outside the watch
        var tmpFilterSearchQuery = '',filterSearchQueryTimeout;
        $scope.$watch('searchQuery', function (val) {
            if (filterSearchQueryTimeout)
                $timeout.cancel(filterSearchQueryTimeout);

            tmpFilterSearchQuery = val;

            filterSearchQueryTimeout = $timeout(function() {
                self.filterSearchQuery = tmpFilterSearchQuery;
            }, 250); // delay 250 ms
        });


        self.removeProfession = function (index) {
            //$scope.movies.splice(index,1);
            //$scope.movies.push({ name: 'new', thumbUrl: 'lool'});
            //console.log(self.movies[index].name);
            self.stuff.splice(index,1);
        };


    }]);

})();

/*
var rand = function (n,d,u) {
    var ret = [];
    for (var i = 0; i != n; i++) {
        var numWords = Math.round(Math.random() * 3 + 1);
        var name = '';
        var url = '';
        for (var j = 0; j != numWords; j++) {
            name += ' ' + $.trim(d[Math.round(Math.random() * d.length)]);
        }
        url += u[Math.round(Math.random() * u.length)];
        ret.push({ "name":name, thumbUrl:url });
    }
    return ret;
};*/