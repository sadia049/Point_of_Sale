<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" readonly/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
getProfile();
async function getProfile(){

 showLoader();
 let response =  await axios.get('/user-profile');
 hideLoader();
 let data = response.data['data'];
 console.log(data);
 if(response.status===200){
    
    //let data2 = data['data'];

    document.getElementById('email').value=data['email'];
 } 










}
function onUpdate() {
try{
let email = document.getElementById('email').value;
let firstName = document.getElementById('firstName').value;
let lastName = document.getElementById('lastName').value;
let mobile = document.getElementById('mobile').value;
let password = document.getElementById('password').value;

if(email.length===0){
    errorToast('Email is required')
}
else if(firstName.length===0){
    errorToast('First Name is required')
}
else if(lastName.length===0){
    errorToast('Last Name is required')
}
else if(mobile.length===0){
    errorToast('Mobile is required')
}
else if(password.length===0){
    errorToast('Password is required')
}

    showLoader();
    const data = {
        firstName: firstName,
        lastName: lastName,
        email: email,
        mobile: mobile,
        password: password
        };
    const URL = "{{ url('/Registration') }}";
    const res= axios.post(URL,data).catch(function(error){
        if(error.response){
            console.log(error.response.data);
            console.log(error.response.status);

        }
        else if(error.request)
        {
            console.log(error.request);
        }
        else{
            console.log(error.message);
        }
        console.log(error.config);
    });
    //console.log(res);
    hideLoader();
if(res.status==200 && res.data['status']=='successfull'){
        successToast(res.data);
        setTimeout(function (){
            window.location.href='/userLogin'
        },2000)
    }
}
catch(error){

    
        alert(error);


}

   
   
}

</script>