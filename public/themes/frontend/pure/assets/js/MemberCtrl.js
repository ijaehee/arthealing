var app = app|| angular.module('APP',[]) ; 

app.directive('passwordValidator',[function(){
    return {
        require: 'ngModel',
        link: function(scope, elm, attr, ctrl) {
            var pwdWidget = elm.inheritedData('$formController')[attr.passwordValidator];

            ctrl.$parsers.push(function(value) {
                if (value === pwdWidget.$viewValue) {
                    ctrl.$setValidity('sameAs', true);
                    return value;
                }
                ctrl.$setValidity('sameAs', false);
                return undefined ; 
            });

            pwdWidget.$parsers.push(function(value) {
                ctrl.$setValidity('sameAs', value === ctrl.$viewValue);
                return value;
            });
        }
    }
}]); 

app.directive('alertWindow',[function(){
    return { 
        require : 'ngModel' , 
        template : '<div class="alert alert-{{dialog.status}} " style="display:{{dialog.display}}" >{{dialog.msg}}</div>',
        link :function(scope, elm, attr, ctrl){ 
        }
    } 
}]) ; 

app.controller('MemberCtrl',function($scope,$http){ 
     
    $scope.alertMsg = '' ; 
    $scope.alertCode = 200 ; 
    $scope.dialog = { display : 'none'} ; 

    $scope.login = function() { 
        var data = { 
            'password' : $scope.member.password,
            'email' : $scope.member.email
        } 

        $scope.dialog.status = 'info' ; 
        $scope.dialog.display = 'block' ; 
        $scope.dialog.msg = '로그인 중 입니다.' 

        $http.post('login',data)
        .success(function(responseData){ 
            $scope.dialog.status = 'success' ; 
            $scope.dialog.msg = responseData.msg ;
            location.href='/artist/gate' ; 
        })
        .error(function(responseData){ 
            $scope.dialog.status = 'danger' ; 
            $scope.dialog.msg = responseData.msg ; 
        });
    }

    $scope.join = function(){ 

        var data = { 
            'password' : $scope.member.password,
            'email' : $scope.member.email
        } 

        $scope.dialog.status = 'info' ; 
        $scope.dialog.display = 'block' ; 
        $scope.dialog.msg = '회원가입 중 입니다.' 

        $http.post('join/artist',data)
        .success(function(responseData){ 
            $scope.dialog.status = 'success' ; 
            $scope.dialog.msg = responseData.msg ;
        })
        .error(function(responseData){ 
            $scope.dialog.status = 'danger' ; 
            $scope.dialog.msg = responseData.msg ; 
        }); 
    }
}); 
