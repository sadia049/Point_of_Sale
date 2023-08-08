<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function Save() {
        try {

            let name = document.getElementById('customerName').value;
            let email = document.getElementById('customerEmail').value;
            let mobile = document.getElementById('customerMobile').value;

            if (name.length == 0) {
                errorToast("Category Required !")
            } else if (email.length == 0) {
                errorToast("Email Required !")
            } else if (mobile.length == 0) {
                errorToast("Mobile no Required !")
            } else {
                document.getElementById('modal-close').click();
                showLoader()
                let res = await axios.post('/create-customer', {
                    name: name,
                    email: email,
                    mobile: mobile
                })

                hideLoader()

                if (res.status === 201) {
                    successToast('Request completed');

                    document.getElementById("save-form").reset();

                    await getList();
                } else {
                    errorToast("Request fail !")
                }

            }

        } catch (error) {

        }
    }
</script>