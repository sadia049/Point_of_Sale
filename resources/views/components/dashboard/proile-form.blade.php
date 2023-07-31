<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" readonly />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Update</button>
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
        let res=await axios.get("/user-profile")
        hideLoader();
        if(res.status===200){
            let data=res.data['data'];
            document.getElementById('email').value=data['email'];
            document.getElementById('firstName').value=data['firstName'];
            document.getElementById('lastName').value=data['lastName'];
            document.getElementById('mobile').value=data['mobile'];
            document.getElementById('password').value=data['password'];
        }
        else{
            errorToast(res.data['message'])
        }

    }

    async function onUpdate() {
        try {
            
            let firstName = document.getElementById('firstName').value;
            let lastName = document.getElementById('lastName').value;
            let mobile = document.getElementById('mobile').value;
            let password = document.getElementById('password').value;

            if (firstName.length === 0) {
                errorToast('First Name is required')
            } else if (lastName.length === 0) {
                errorToast('Last Name is required')
            } else if (mobile.length === 0) {
                errorToast('Mobile is required')
            } else if (password.length === 0) {
                errorToast('Password is required')
            }

            showLoader();
            const data = {
                firstName: firstName,
                lastName: lastName,
                
                mobile: mobile,
                password: password
            };
            const URL = "{{ url('/update-profile') }}";
            const res = await axios.post(URL, data).catch(function(error) {
                if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);

                } else if (error.request) {
                    console.log(error.request);
                } else {
                    console.log(error.message);
                }
                console.log(error.config);
            });
            console.log(res);
            hideLoader();
            if (res.status==200) {
                console.log('sucess');
                successToast(res.data['message']);
                await getProfile();
            }
        } catch (error) {

             errorToast(res.data['message']);
            
        }



    }
</script>