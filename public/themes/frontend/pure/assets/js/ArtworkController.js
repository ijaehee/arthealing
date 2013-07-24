var app = app || angular.module('ArtworkApp',['ngResource']) ; 

app.factory('OwnArtwork',['$resource',function($resource){
    return $resource('/api/v1/artist/:artistId/artwork/:artworkId/:page',{
        artistId:1,artworkId : '@id'
    },{ 
        'update':{ 
            method : 'put'
        }

    }); 
}]); 
app.controller('ArtworkController', function($scope, OwnArtwork){
    $scope.artworkList = [] ; 
    $scope.artist_id = 0 ; 

    $scope.selectedArtwork = null ; 

    $scope.init = function(){ 
        $scope.getOwnArtworks() ; 
        $scope.editBox.init() ; 
    };

    $scope.getList = function(){ 

    }; 

    $scope.update = function(){

    }; 

    $scope.getOwnArtworks = function(){ 
        $scope.artworkList = OwnArtwork.query(function(response){
        }) ; 
    }; 

    $scope.edit = function(){
    }; 

    $scope.editBox = (function(){ 
        var that = {} ; 
        var status = {
            isDirty : false, 
            isVisible : false
        } ; 
        
        that.init = function(){ 
            status.isDirty  = false ;
            status.isVisible = false ; 
        }; 

        that.isVisible = function(){ 
            return status.isVisible ; 
        }

        that.save = function(){ 
            var selectedArtwork = $scope.artwork.getSelectedArtwork() ; 
            var artwork = new OwnArtwork ; 
            artwork.name = 'hello' ; 
            artwork.id = selectedArtwork.id  ; 
            artwork.$update() ; 
        };

        that.show = function(artwork){
            status.isVisible = true ; 
            $scope.artwork.setSelectedArtwork(artwork)  ; 
        };

        that.hide = function(){
            status.isVisible = false ; 
            $scope.artwork.resetSelectedArtwork()  ; 
        }; 

        return that ; 
    })(); 

    $scope.artwork = (function(){
        var that = {} ; 
        var selectedArtwork = null ; 

        that.edit = function(artwork){ 
            $scope.selectedArtwork = angular.copy(artwork) ; 
            $scope.editBox.show() ; 
        }; // end of edit 

        that.getSelectedArtwork = function(){ 
            return $scope.selectedArtwork ; 
        };

        that.setSelectedArtwork = function(artwork){ 
            $scope.selectedArtwork = angular.copy(artwork) ; 
        };

        that.resetSelectedArtwork = function(){ 
            $scope.selectedArtwork = {} ; 
        }; 

        return that ; 
    })(); 
}); 
