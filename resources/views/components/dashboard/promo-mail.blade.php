<div class="container">
    <div class="row">
        <div class="col-md-10 col-lg-10">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4 class="text-center">GeetkroVert</h4>
                    <hr />
                    <form id="promotion-form">
                        
                             <!--Email Subject--->
                            <div class="col-md-12 p-2 form-group">
                                <label>Subject</label>
                                <input id="subject" placeholder="Email Subject" class="form-control" type="text" />
                            </div>
                            <!--Email Content--->
                            <div class="col-md-12 p-2 form-group">
                                <label>Email Content</label>
                                <textarea id="content" class="form-control" type="text" rows="20" cols="20"></textarea>
                            </div>

                           <div class="col-md-12 p-2">
                                <button class="btn mt-3 w-100  btn-primary" type="submit">Send</button>
                            </div>

                        

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const promotion_form = document.getElementById('promotion-form');
    

    promotion_form.addEventListener('submit', async (e) => {

        e.preventDefault();
        try {
            const subject = document.getElementById('subject').value;
            const content = document.getElementById('content').value;

            if (subject.length == 0) {
                errorToast("Subject is Required", "POS Says:");
            } else if (content.length == 0) {
                errorToast("Message is Required", "POS Says:");
            } else {
                showLoader();

                const res = await axios.post('/send-promotion', {
                    subject: subject,
                    content: content
                });
                hideLoader();
               // console.log(res.data);
                if (res.status == 200) {
                    promotion_form.reset();
                    successToast(res.data['message'], "POS Says:");
                } else {
                    promotion_form.reset();
                    errorToast(res.data['message'], "POS says");

                }
            }

        } catch (error) {
            console.log('Something went Wrong');
        }


    });
</script>