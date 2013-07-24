var app = app || angular.module('ProfileApp',['ngResource']) ; 

app.directive('alertWindow',[function(){
    return { 
        require : 'ngModel' , 
        template : '<div class="alert alert-{{dialog.status}} " style="display:{{dialog.display}}" >{{dialog.msg}}</div>',
        link :function(scope, elm, attr, ctrl){ 
        }
    } 
}]) ; 

app.directive('helpText',[function(){
    var msg =  {} ; 

    msg.helpText = { 
        "user_name" : '이름을 입력하세요. ' , 
        "homepage" : '홈페이지가 있다면, 홈페이지 주소를 적어주세요.' ,
        "facebook" : '페이스북 ID를 적어주세요.'  , 
        "blog" : '블로그 주소를 적어주세요.'  
    }; 

    return { 
        link : function(scope, elm, attr, ctrl){ 
            elm.bind('focus',function(){ 
                var helpText = msg.helpText[attr.name] || scope.field ; 
                
                elm.parent().append('<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;'+ helpText +'</span>') ; 
            }); 

            elm.bind('blur',function(){ 
                var children = elm.parent().find('span');  
                angular.forEach(children,function(val,key){ 
                    var el = angular.element(val) ; 

                    if(el.hasClass('help-block')){ 
                        el.remove() ; 
                    }
                }); 
            }); 
        }
    }
}]); 

app.factory('Profile',['$resource',function($resource){
    return $resource('/api/v1/artist/:artistId/profile',{
        artistId : 1 
    },{ 

    }); 
}]); 


app.controller('ProfileController',function($scope,Profile){ 
    $scope.dialog = {} ; 
    $scope.userId = 0 ; 

    $scope.init = function(config){
        //angular.element(document).ready(function(){
            $scope.userId = config.userId||0 ;
            $scope.getProfile() ; 
        //}) ;
    } ; 

    $scope.getProfile = function(){ 
        //$scope.profile.facebook = 'facebook' ; 
        $scope.profile = Profile.get(function(response){

        });
    } ;

    $scope.createProfile = function(){
        var data = { 
            'username' : $scope.profile.username , 
            'welcome_id' : $scope.profile.welcome_id , 
            'facebook' : $scope.profile.facebook , 
            'homepage' : $scope.profile.homepage , 
            'blog' : $scope.profile.blog  
        } ; 

        $scope.dialog.status = 'info' ; 
        $scope.dialog.display = 'block' ; 
        $scope.dialog.msg = '프로필 만드는 중입니다.' 

        $http.post('artist/createProfile',data)
        .success(function(responseData){
            $scope.dialog.status = 'success' ; 
            $scope.dialog.msg = responseData.msg ;
            //location.href='/artist/gate' ; 
        })
        .error(function(responseData){ 
            $scope.dialog.status = 'danger' ; 
            $scope.dialog.msg = responseData.msg ; 
        });
    }; 

    $scope.saveProfile = function(){ 
        $scope.profile.$save() ; 
    }; 
}); 
