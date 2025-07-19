<div x-data= "viewImporterCluster" x-init="init()">
    <button class="btn btn-sm text-white bg-orange" style="border:none" @@click= "showModal= true">View Clusters</button>
        <div class="overlay" x-show="showModal" x-cloak x-transition>
            <div class = "custom-modal">
                <div class="container scrollbar" style="max-height:250px; overflow:auto">
                    <div class="d-flex justify-content-between">
                        <h3 class="mt-3 text-brown font-weight-bold">Importer Segmentation</h3>
                        <span @@click="showModal = false"><i class="fa-solid fa-xmark cur"></i></span>
                    </div>

                    <template x-for="cluster in clusters" :key="cluster.id">
                       <div class="mt-4 p-3 border rounded bg-light">
                           <h5 class="font-weight-bold text-primary" x-text="cluster.label"></h5>
                           <p><strong>Total Bags:</strong><span x-text="cluster.totalBags.toLocaleString()"></span></p>
                           <p><strong>Avg Order Size:</strong><span x-text="cluster.avgOrderSize"></span></p>
                           <p><strong>Arabica %:</strong><span x-text="cluster.arabicaPct + '%'"></span></p>
                           <p ><strong>Importers:</strong></p>
                              <ul class="ml-4 text-sm"  style="list-style: disc; padding-left: 1.5rem;">
                                    <template x-for="importer in cluster.importers" :key="importer">
                                       <li x-text="importer"></li>
                                    </template>
                              </ul>
                       </div>
                    </template>                
                </div>
            </div>
        </div>
</div>