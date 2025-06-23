@extends('layouts.app')
@section('content')

<!--div x-data="counter">
<h2>Hi, <span x-text= "name"></span></h2>
<p>The count value is: <span x-text = "count"></span></p>
<button class="btn btn-success btn-fill"
x-on:click= "count++">Increase count</button>
<button class="btn btn-danger btn-fill" x-on:click = "count--">Decrease count</button>
<button class="btn btn-primary btn-fill" x-on:click= "logCount">Log count</button>
</div-->


<form x-data="signupForm" x-on:submit.prevent= "submitForm">
    <h1>Ninja Signup Form</h1>

   <!-- <button type="button" x-on:click.shift= "console.log('click')" >Click</button>
    <button type="button" @@mouseleave.ctrl= "console.log('mouseleave')" >Mouseleave</button>
    <button type="button" @@dblclick= "console.log('dblclick')">dblclick</button>
    <input type="text" @@keyup="console.log('keyup')">--> 

    <!-- username -->
    <div class="form-field">
    <p class="hint" :class = "{'warning': username.length > 10}">
        <span x-text="15 - username.length"></span> characters remaining
    </p>

      <label>
        <span></span>Username:
        <input
          x-model="username" 
          type="text" 
          maxlength="15"
          >
      </label>

    <template x-if= "errors.username">
    <p class="error" x-text= "errors.username"></p>
    </template>
    </div>

    <!-- password -->
    <div class="form-field password">
      <label>
        <span>Password:</span>
        <input :type="showPass ? 'text' : 'password' " x-model="password">
      </label>
      <span @@click =
      "showPass = !showPass">
      <i style="cursor:pointer;" class="fa-solid" :class= "showPass ? 'fa-eye-slash' : 'fa-eye' "></i>
      </span>

    <template x-if= "errors.password">
    <p class="error" x-text= "errors.password"></p>
    </template>
    </div>

    <!-- confirm password -->
    <div class="form-field">
      <label>
        <span>Confirm Password:</span>
        <input type="password" x-model="passwordConfirm">
      </label>
    <template x-if= "errors.passwordConfirm">
    <p class="error" x-text= "errors.passwordConfirm"></p>
    </template>
    </div>

    <!-- belt color -->
    <div class="form-field">
      <label>Belt Color:
        <select x-model="belt">
          <option value="">Select a belt</option>

          <template x-for="choice in beltChoices" :key="choice" >
          <option :value="choice" x-text= "choice"></option>
          </template>
         
        </select>
      </label>
      <template x-if= "errors.belt">
    <p class="error" x-text= "errors.belt"></p>
    </template>
    </div>

    <!-- short bio -->
    <div class="form-field">
    <p class="hint"  :class = "{'warning': bio.length > 90}">
        <span x-text="100 - bio.length"></span> characters remaining
    </p>
    
      <label>
        <span>Short Bio:</span>
        <textarea maxlength="100" x-model="bio"></textarea>
      </label>
    <template x-if= "errors.bio">
    <p class="error" x-text= "errors.bio"></p>
    </template>
    </div>

    <!-- newsletter signup -->
    <div class="form-field newsletter">
      <label>
        <input type="checkbox" x-model="newsletter">
        <span>Sign up for the newsletter</span>
      </label>
      <div x-text="newsletter"></div>
    </div>

    <!-- submit button -->
    <button type="submit">Submit</button>

    <div class="overlay" x-show="success" x-cloak
     x-transition.opacity.transition.500ms>
   
        <div class="custom-modal" x-show="success"
        x-transition:enter-start= "off-screen"
        x-transition:enter-end= "on-screen"
        >
            <h2>Thank you!</h2>
            <button type="button" @@click="success = false">Close</button>
        </div>
    </div>

  </form>
 
@endsection