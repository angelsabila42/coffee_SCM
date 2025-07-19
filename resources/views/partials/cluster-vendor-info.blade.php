<div x-data= "viewVendorCluster" x-init="init()">
    <button class="btn btn-sm text-white bg-orange" style="border:none" @@click= "showModal= true">View Clusters</button>
        <div class="overlay" x-show="showModal" x-cloak x-transition>
            <div class = "custom-modal">
                <div class="container scrollbar" style="max-height:250px; overflow:auto">
                    <div class="d-flex justify-content-between">
                        <h3 class="my-3 text-brown font-weight-bold">Vendor Segmentation</h3>
                        <span @@click="showModal = false"><i class="fa-solid fa-xmark cur"></i></span>
                    </div>

                    <template x-if="clusters.length === 0">
                       <p class="text-muted text-center">Loading vendor cluster data...</p>
                    </template>  

                    <template x-for="(cluster, index) in clusters" :key="index">
                    <div class="mb-3 p-3 rounded shadow-sm border bg-light">
                        <h5 class="text-primary mb-2" x-text="cluster.label"></h5>
                        <ul class="pl-3 text-gray-800">
                            <li><strong>Total Bags:</strong> <span x-text="cluster.total"></span></li>
                            <li><strong>Arabica:</strong> <span x-text="cluster.arabica"></span></li>
                            <li><strong>Robusta:</strong> <span x-text="cluster.robusta"></span></li>
                        </ul>

                        <template x-if="cluster.vendorList.length">
                            <ul class="pl-4 mt-2 list-disc text-gray-700">
                                <template x-for="vendor in cluster.vendorList" :key="vendor">
                                    <li x-text="vendor"></li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </template>              
                </div>
            </div>
        </div>
</div>