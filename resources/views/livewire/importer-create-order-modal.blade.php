<form class="mb-0 p-0" wire:submit.prevent= "save">
                                        
                                            <div class= "row ml-25">

                                                <div class="form-group w-50 pr-4">
                                                    <label for="type">Coffee Type</label>
                                                    <select id="type" class="form-control" x-model= "selectedType"  @@change= "$wire.set('coffeeType',selectedType)">
                                                        <option value="" disabled>Select type</option>

                                                        <template x-for= "type in typeNames" :key = "type">
                                                            <option :value= "type" x-text= "type"></option>
                                                        </template>

                                                    </select>
                                                    <div>
                                                    @error('coffeeType') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group w-50 pl-4">
                                                    <label for="grade">Grade</label>
                                                    <select id="grade" class="form-control" x-model= "selectedGrade"  @@change= "$wire.set('grade',selectedGrade)">
                                                        <option value="" disabled>Select grade</option>

                                                        <template x-for= "grade in grades" :key = "grade">
                                                            <option :value= "grade" x-text= "grade"></option>
                                                        </template>

                                                    </select>
                                                    <div>
                                                    @error('grade') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class= "row ml-25">
                                                <div class="form-group pr-4 w-50">
                                                    <label for="qtn">Quantity</label>
                                                    <input type="text" class="form-control" id="qtn" placeholder="kgs" wire:model="quantity">
                                                        <div>
                                                            @error('quantity') <span class="error">{{ $message }}</span> @enderror
                                                        </div>
                                                </div>

                                                <div class="form-group pl-4 w-50">
                                                    <label for="qtn">Destination</label>
                                                    <input type="text" class="form-control" id="qtn" placeholder="destination" wire:model="destination">
                                                        <div>
                                                            @error('destination') <span class="error">{{ $message }}</span> @enderror
                                                        </div>
                                                </div>

                                            </div>
                                            <div class= "row ml-25">
                                                <div class="form-group pr-4 w-50">
                                                    <label for="date">Deadline</label>
                                                    <input type="date" class="form-control" id="date" wire:model="deadline">
                                                        <div>
                                                            @error('deadline') <span class="error">{{ $message }}</span> @enderror
                                                        </div>
                                                </div>    
                                            </div>

                                            <div class= "row mr-2">
                                            <button  class="btn save mr-2" type="submit" >Save
                                                    <div wire:loading>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <style>.spinner_DupU{animation:spinner_sM3D 1.2s infinite}.spinner_GWtZ{animation-delay:.1s}.spinner_dwN6{animation-delay:.2s}.spinner_46QP{animation-delay:.3s}.spinner_PD82{animation-delay:.4s}.spinner_eUgh{animation-delay:.5s}.spinner_eUaP{animation-delay:.6s}.spinner_j38H{animation-delay:.7s}.spinner_tVmX{animation-delay:.8s}.spinner_DQhX{animation-delay:.9s}.spinner_GIL4{animation-delay:1s}.spinner_n0Yb{animation-delay:1.1s}
                                                            @keyframes spinner_sM3D{0%,50%{animation-timing-function:cubic-bezier(0,1,0,1);r:0}10%{animation-timing-function:cubic-bezier(.53,0,.61,.73);r:2px}}
                                                            </style>
                                                            <circle class="spinner_DupU" cx="12" cy="3" r="0"/>
                                                            <circle class="spinner_DupU spinner_GWtZ" cx="16.50" cy="4.21" r="0"/>
                                                            <circle class="spinner_DupU spinner_n0Yb" cx="7.50" cy="4.21" r="0"/>
                                                            <circle class="spinner_DupU spinner_dwN6" cx="19.79" cy="7.50" r="0"/>
                                                            <circle class="spinner_DupU spinner_GIL4" cx="4.21" cy="7.50" r="0"/>
                                                            <circle class="spinner_DupU spinner_46QP" cx="21.00" cy="12.00" r="0"/>
                                                            <circle class="spinner_DupU spinner_DQhX" cx="3.00" cy="12.00" r="0"/>
                                                            <circle class="spinner_DupU spinner_PD82" cx="19.79" cy="16.50" r="0"/>
                                                            <circle class="spinner_DupU spinner_tVmX" cx="4.21" cy="16.50" r="0"/>
                                                            <circle class="spinner_DupU spinner_eUgh" cx="16.50" cy="19.79" r="0"/>
                                                            <circle class="spinner_DupU spinner_j38H" cx="7.50" cy="19.79" r="0"/>
                                                            <circle class="spinner_DupU spinner_eUaP" cx="12" cy="21" r="0"/>
                                                            </svg> <!-- SVG loading spinner -->
                                                    </div>
                                            </button>
                                            <button type="button" class="btn exit" @@click= "showModal = false">Cancel</button>
                                            </div>
                                
                                        </form>
