var app = angular.module('APP',[]) ; 
app.directive('helpText',[function(){
    var msg =  {} ; 

    msg.helpText = { 
        "email" : '이메일을 입력하세요. ' , 
        "username" : '이름을 입력하세요. ' , 
        "facebook" : '페이스북 ID를 적어주세요.'  , 
        "password" : '패스워드를 적어주세요.'  , 
        "blog" : '블로그 주소를 적어주세요.'  
    };
    return{ 
        transclude:true ,
        link : function(scope, elm, attr, ctrl){ 
                   elm.bind('focus',function(){
                       var helpText = msg.helpText[attr.helpText] ; 

                        elm.parent().append('<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;'+ helpText +'</span>') ; 
                   }).bind('blur',function(){ 
                       var validation= attr.validation ; 
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

app.controller('MemberController',function($scope,$http){

    $scope.join = function(){ 
        if(!$scope.signupForm.$invalid){
	        $http.post('/signup',$scope.member).success(function(){
	
	        }).error(function(){
	
	        }); 
        }
    }
}); 
