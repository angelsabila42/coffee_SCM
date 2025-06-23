/*const hamburger= document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");

hamburger.addEventListener("click", function(){
    document.querySelector("#sidebar").classList.toggle("expand");
    toggler.classList.toggle("bxs-chevrons-right");
    toggler.classList.toggle("bxs-chevrons-left");
});*/

/** document.addEventListener('alpine:init', ()=>{
    Alpine.data('counter',()=>({
        count:0,
        name:'Mario',

        logCount(){
            console.log(this.count);
        },
    }))
})**/

document.addEventListener('alpine:init', ()=>{
    Alpine.data('signupForm',() => ({
        username: '',
        password: '',
        passwordConfirm: '',
        belt: '',
        bio: '',
        newsletter:true,
        showPass:false,
        errors:{},
        beltChoices:['black','red','white','orange','brown'],
        success: false,

        validateForm(){
            this.errors = {}

            if (this.username.length < 3){
                this.errors.username = 'Username must be atleast 3 characters.'
            }
              if (this.password.length < 6){
                this.errors.password = 'Password must be atleast 6 characters.'
            }
              if (this.password !== this.passwordConfirm){
                this.errors.passwordConfirm = 'Passwords do not match.'
            }
              if (!this.belt){
                this.errors.belt = 'Please select a belt'
            }
              if (this.bio.length < 10){
                this.errors.bio = 'Bio must be atleast 10 characters'
            }
        },

        submitForm($event){
            this.validateForm()
            console.log(this.errors)

            if(Object.keys(this.errors).length === 0){
                console.log(this.username, this.password, this.passwordConfirm, this.belt, this.bio, this.newsletter)

                this.success= true
                $event.target.reset()

            }
        }
    }));

    Alpine.data('sideBar', () => ({
        isExpanded: false,
        toggle(){
            this.isExpanded = !this.isExpanded;
        }
    }));

    Alpine.data('newBtn',() => ({
        showModal: false,
        selectedVendor: '',
        selectedType: '',
        selectedCenter: '',
        centers: ['Mbale','Mukono','Kasese','Kampala'],
        typeNames: ['Arabica', 'Robusta'],
        vendorNames: ['Elgon Farmers', 'Endiiro', 'Kasese Coffee'],
    }))


})