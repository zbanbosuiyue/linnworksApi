var GridController = function ($scope, $uibModal, Api) {
    $scope.data = {
        WarehouseTransferInfo: {
            totalitems: 0,
            currentPage: 1,
            itemsperpage: 10,
            data: []
        }
    };

    function GetData() {
        if ($scope.selectedFromLocation!=null){
            $scope.data.WarehouseTransferInfo.data = [];
            
            var request = {
                locationId: $scope.selectedFromLocation.StockLocationId,
            };
            SetBusy($("#ActiveTransferGrid"));
            Api.PostApiCall("WarehouseTransfer", "GetActiveTransfersForLocation", request, function (event) {
                SetBusy($("#ActiveTransferGrid"), true);
                if (event.hasErrors == true) {
                    alert("Error Getting data: " + event.error);
                } else {
                    $scope.data.WarehouseTransferInfo.totalitems = event.result.length;
                    $scope.data.WarehouseTransferInfo.data = event.result;
                    
                    event.result.forEach(function(element){
                        request = {
                            pkTransferId: element.PkTransferId
                        }

                        Api.PostApiCall("WarehouseTransfer", "GetTransferItems", request, function (event) {
                             if (event.hasErrors == true) {
                                alert("Error Getting data: " + event.error);
                             } else {
                                if (event.result.length > 0){
                                    element.firstItemSKU = event.result[0].SKU;
                                    element.firstItemTitle = event.result[0].ItemTitle;
                                }
                             }
                        });
                    })
                    console.log($scope.data.WarehouseTransferInfo.data);
                }
            });
        }

    }

    $scope.pageChanged = function () {
        GetData();
    }


    $scope.$watch('selectedFromLocation', function () {
        $scope.data.WarehouseTransferInfo.currentPage = 1;
        GetData();
    });


    $scope.openProduct = function (product) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: '/SPA/Views/ViewProductWindow.html',
            controller: 'ViewProductController',
            size: "",
            resolve: {
                data: product
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.data.WarehouseTransferInfo.selectedItem = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    }

}

GridController.$inject = ['$scope','$uibModal','Api'];